<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Root Redirect
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/**
 * Unified Dashboard Route
 * This now correctly calls the OrderController to fetch products and customer trends
 */
Route::get('/dashboard', [OrderController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Order & Resource Management[cite: 5, 10]
Route::middleware('auth')->group(function () {
    // POS & History Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.process');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Standard Resources
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';