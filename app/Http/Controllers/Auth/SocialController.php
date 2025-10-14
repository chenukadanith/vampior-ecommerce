<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    // allowed providers
    protected $providers = ['google', 'github'];

    public function redirect($provider)
    {
        if (!in_array($provider, $this->providers)) {
            abort(404);
        }
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        if (!in_array($provider, $this->providers)) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Unable to login using ' . $provider . '. Please try again.');
        }

        // Common fields from provider
        $email = $socialUser->getEmail();
        $name  = $socialUser->getName() ?: $socialUser->getNickname() ?: 'User';
        $providerId = $socialUser->getId();
        $avatar = $socialUser->getAvatar();

        if (!$email) {
            // Some GitHub accounts may not expose email; you may want to handle this.
            return redirect('/login')->withErrors('No email returned from ' . $provider . '. Use another login method.');
        }

        // Find or create user
        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                // random password because they will use OAuth to login
                'password' => bcrypt(Str::random(24)),
                'avatar' => $avatar ?? null,
                'provider' => $provider,
                'provider_id' => $providerId,
            ]);
        } else {
            // update provider data if not set
            $user->update([
                'provider' => $user->provider ?? $provider,
                'provider_id' => $user->provider_id ?? $providerId,
                'avatar' => $user->avatar ?? $avatar,
            ]);
        }

        // Assign default role if user has no role
        if (!$user->roles()->count()) {
            $user->assignRole('buyer'); // default role
        }

        Auth::login($user, true);

        // redirect based on role (route defined below)
        return redirect()->intended(route('role.redirect'));
    }
}
