<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\UserController;

// Guest Routes
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // Registration routes
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/post-register', [AuthController::class, 'post_register'])->name('post.register');  // Fix the method name here

    // Login routes
    Route::post('/post-login', [AuthController::class, 'login'])->name('post.login');
});

// Admin Routes
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Product Routes
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product');

    // Admin logout
    Route::get('/admin-logout', [AuthController::class, 'admin_logout'])->name('admin.logout');
});

// User Routes
Route::group(['middleware' => 'auth'], function () {  // Using 'auth' instead of 'web' is more appropriate for user authentication.
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');

    // User logout
    Route::get('/user-logout', [AuthController::class, 'user_logout'])->name('user.logout');
});