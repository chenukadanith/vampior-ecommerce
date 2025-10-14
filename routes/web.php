<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('login/{provider}', [SocialController::class, 'redirect'])
    ->where('provider', 'google|github')
    ->name('social.redirect');

Route::get('login/{provider}/callback', [SocialController::class, 'callback'])
    ->where('provider', 'google|github')
    ->name('social.callback');

// Role redirect route (after login)
Route::get('/role-redirect', function () {
    $user = auth()->user();
    if ($user->hasRole('admin')) {
        return redirect('/admin');
    }
    if ($user->hasRole('seller')) {
        return redirect('/seller/dashboard');
    }
    return redirect('/home');
})->middleware('auth')->name('role.redirect');

require __DIR__.'/auth.php';
