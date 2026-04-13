<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Gallery & Catalog
Route::get('/catalog', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');

// Custom & Tracking
Route::get('/custom-service', [HomeController::class, 'customOrder'])->name('custom.create');
Route::post('/custom-service', [HomeController::class, 'storeCustomOrder'])->name('custom.store');
Route::get('/track-order', [HomeController::class, 'trackOrder'])->name('orders.track');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/{order}/payment', [App\Http\Controllers\CheckoutController::class, 'payment'])->name('checkout.payment');
    Route::post('/checkout/sync', [App\Http\Controllers\CheckoutController::class, 'sync'])->name('checkout.sync');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/order/{order}/confirm', [App\Http\Controllers\ProfileController::class, 'confirmReceipt'])->name('profile.confirm-receipt');

    // Wishlist
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle/{product}', [App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');

    // Reviews
    Route::post('/reviews', [App\Http\Controllers\ProductReviewController::class, 'store'])->name('reviews.store');
});

// Midtrans Webhook
Route::post('/api/midtrans/callback', [App\Http\Controllers\CheckoutController::class, 'callback']);

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'create'])->name('login');
    Route::get('admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');
    Route::post('login', [AuthController::class, 'store']);
});

Route::post('logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');
