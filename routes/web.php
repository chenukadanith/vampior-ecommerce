<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Standard public and authenticated routes.
|
*/

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


/*
|--------------------------------------------------------------------------
| Role-Based Routes
|--------------------------------------------------------------------------
|
| Routes protected by role-specific middleware.
|
*/

Route::middleware(['auth'])->group(function () {
    // ADMIN ROUTES
    Route::group(['middleware' => ['role:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
      
        // Route::get('/manage-users', function () {
        //     return view('admin.manage-users');
        // })->name('manage-users');
        Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
    });

    // SELLER ROUTES
    Route::group(['middleware' => ['role:seller'], 'prefix' => 'seller', 'as' => 'seller.'], function () {
        Route::get('/dashboard', function () {
            return view('seller.dashboard');
        })->name('dashboard');
    });

    // BUYER ROUTES
    Route::group(['middleware' => ['role:buyer'], 'prefix' => 'home', 'as' => 'buyer.'], function () {
        Route::get('/', function () {
            return view('buyer.home');
        })->name('home');
    });
});


/*
|--------------------------------------------------------------------------
| Socialite & Authentication Routes
|--------------------------------------------------------------------------
|
| Handles social logins and post-login redirection logic.
|
*/

// Socialite Login Routes
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
        return redirect()->route('admin.dashboard');
    }
    if ($user->hasRole('seller')) {
        return redirect()->route('seller.dashboard');
    }
    return redirect()->route('buyer.home');
})->middleware('auth')->name('role.redirect');

Route::get('/role-redirect', function () {
    // All logged-in users are now sent to the main dashboard.
    return redirect()->route('dashboard');
})->middleware('auth')->name('role.redirect');


require __DIR__ . '/auth.php';
