<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
// --- NEW: Add the controllers for public product viewing ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\CartController; 
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Buyer\OrderController as BuyerOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\WishlistController;




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

// --- MODIFIED: This now uses the HomeController to fetch and display products ---
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// --- NEW: This is the dynamic route for a single product page ---
Route::get('/product/{product:slug}', [ProductViewController::class, 'show'])
    ->middleware(['auth'])->name('product.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

/*
|--------------------------------------------------------------------------
| Wishlist Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{product}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// --- CHECKOUT ROUTES ---
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/success', [CheckoutController::class, 'success'])->name('checkout.success');
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
        Route::resource('users', UserController::class)->only(['index', 'update', 'destroy']);
        Route::resource('products', AdminProductController::class)->only(['index']);
        Route::resource('categories', AdminCategoryController::class);

    });

    // SELLER ROUTES
    Route::group(['middleware' => ['role:seller'], 'prefix' => 'seller', 'as' => 'seller.'], function () {
        Route::get('/dashboard', function () {
            return view('seller.dashboard');
        })->name('dashboard');
        Route::resource('products', SellerProductController::class);
        Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{orderItem}', [SellerOrderController::class, 'update'])->name('orders.update');
    });

    // BUYER ROUTES 
    Route::group(['middleware' => ['role:buyer'], 'prefix' => 'home', 'as' => 'buyer.'], function () {
        Route::get('/', function () {
            // This now redirects buyers to the main product dashboard
            return redirect()->route('dashboard');
        })->name('home');
        Route::get('/orders', [BuyerOrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{orderItem}', [BuyerOrderController::class, 'update'])->name('orders.update');
    });
});


/*
|--------------------------------------------------------------------------
| Socialite & Authentication Routes
|--------------------------------------------------------------------------
*/

// Socialite Login Routes
Route::get('login/{provider}', [SocialController::class, 'redirect'])
    ->where('provider', 'google|github')
    ->name('social.redirect');

Route::get('login/{provider}/callback', [SocialController::class, 'callback'])
    ->where('provider', 'google|github')
    ->name('social.callback');

// --- CLEANED UP: Kept only the correct redirect route ---
Route::get('/role-redirect', function () {
    // All logged-in users are now sent to the main dashboard.
    return redirect()->route('dashboard');
})->middleware('auth')->name('role.redirect');


require __DIR__ . '/auth.php';

