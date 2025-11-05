<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\GuestBookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// visitor
Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('dashboard');
    }
    return view('customer.home', ['title' => 'Home']);
})->name('home');
Route::resource('/products', ProductController::class)->only(['index', 'show']);
Route::resource('/guestBook', GuestBookController::class)->only(['store']);

// customer
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/carts', CartController::class)->except(['create', 'edit', 'show']);
    Route::resource('/orders', OrderController::class)->only(['index', 'store', 'show', 'update']);
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{order}/payment', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
    Route::resource('/feedbacks', FeedbackController::class)->only(['store']);
});

// admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('/admin/products', ProductController::class);
    Route::resource('/admin/customers', CustomerController::class)->only(['index', 'destroy', 'show']);
    Route::resource('/admin/categories', CategoryController::class);
    Route::resource('/admin/orders', OrderController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::resource('/feedbacks', FeedbackController::class)->only(['index', 'show', 'destroy']);
    Route::resource('/guestBooks', GuestBookController::class)->only(['index', 'show' , 'destroy']);;
});

require __DIR__.'/auth.php';
