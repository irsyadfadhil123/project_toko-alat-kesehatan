<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return view('admin.dashboard');
        }
        return view('customer.dashboard');
    })->name('dashboard');
});

// customer
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/products', ProductController::class)->only(['index', 'show']);
    Route::resource('/carts', CartController::class)->except(['create', 'edit', 'show']);
    Route::resource('/orders', OrderController::class)->only(['index', 'store', 'show', 'update']);
});

// admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/customers', CustomerController::class)->only(['index', 'destroy', 'show']);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/orders', OrderController::class)->only(['index', 'show', 'update', 'destroy']);
});

require __DIR__.'/auth.php';
