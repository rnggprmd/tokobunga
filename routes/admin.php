<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Sales\OrderController;
use App\Http\Controllers\Admin\Sales\PaymentController;
use App\Http\Controllers\Admin\Sales\ShippingController;
use App\Http\Controllers\Admin\Sales\OrderItemController;
use App\Http\Controllers\Admin\Sales\CustomRequestController;
use App\Http\Controllers\Admin\Catalog\ProductController;
use App\Http\Controllers\Admin\Catalog\ProductVariantController;
use App\Http\Controllers\Admin\Catalog\CategoryController;
use App\Http\Controllers\Admin\UserManagement\UserController;
use App\Http\Controllers\Admin\Analytics\ReportController;

Route::middleware(['auth', 'admin'])->group(function () {
    // 1. Core / Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Sales Management
    Route::prefix('sales')->group(function () {
        // Orders
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
        
        // Integrated Order Actions
        Route::post('/orders/{order}/payment', [OrderController::class, 'storePayment'])->name('orders.payment.store');
        Route::post('/orders/{order}/shipping', [OrderController::class, 'storeShipping'])->name('orders.shipping.store');

        // Payments
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::patch('/payments/{pembayaran}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');

        // Shipping
        Route::get('/shipping', [ShippingController::class, 'index'])->name('shipping.index');
        Route::patch('/shipping/{pengiriman}/status', [ShippingController::class, 'updateStatus'])->name('shipping.updateStatus');

        // Order Items
        Route::get('/order-items', [OrderItemController::class, 'index'])->name('order-items.index');

        // Custom Requests
        Route::get('/custom-requests', [CustomRequestController::class, 'index'])->name('custom-requests.index');
        Route::get('/custom-requests/create', [CustomRequestController::class, 'create'])->name('custom-requests.create');
        Route::post('/custom-requests', [CustomRequestController::class, 'store'])->name('custom-requests.store');
        Route::get('/custom-requests/{customRequest}/edit', [CustomRequestController::class, 'edit'])->name('custom-requests.edit');
        Route::put('/custom-requests/{customRequest}', [CustomRequestController::class, 'update'])->name('custom-requests.update');
        Route::delete('/custom-requests/{customRequest}', [CustomRequestController::class, 'destroy'])->name('custom-requests.destroy');
        Route::patch('/custom-requests/{customRequest}/status', [CustomRequestController::class, 'updateStatus'])->name('custom-requests.updateStatus');
    });

    // 3. Catalog Management
    Route::prefix('catalog')->group(function () {
        // Products
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        // Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Product Variants
        Route::get('/variants', [ProductVariantController::class, 'index'])->name('variants.index');
        // Route::get('/variants/create', [ProductVariantController::class, 'create'])->name('variants.create');
        Route::post('/variants', [ProductVariantController::class, 'store'])->name('variants.store');
        // Route::get('/variants/{variant}/edit', [ProductVariantController::class, 'edit'])->name('variants.edit');
        Route::put('/variants/{variant}', [ProductVariantController::class, 'update'])->name('variants.update');
        Route::delete('/variants/{variant}', [ProductVariantController::class, 'destroy'])->name('variants.destroy');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        // Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        // Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });

    // 4. User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // 5. Analytics
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
