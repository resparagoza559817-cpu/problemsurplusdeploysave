<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Models\Product; // Add this at the very top with the other 'use' lines

Route::get('/', function () {
    // 1. Grab the products from the database
    $products = Product::with('category')->get();

    // 2. Pass them to the view
    return view('products.index', compact('products'));
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard & POS
    Route::get('/dashboard', [OrderController::class, 'dashboard'])->name('dashboard');
    Route::get('/pos', [OrderController::class, 'pos'])->name('pos.index');

    // Inventory
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Orders / Sales History
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    
    // Management Routes (Update/Delete)
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';