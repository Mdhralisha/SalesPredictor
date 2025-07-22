<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/base', function () {
    return view('base');
});


Route::get('/adminlogin', function () {
    return view('adminlogin');
});
Route::get('/sidebar', function () {
    return view('includes.sidebar');
});

// Route::get('/product', function () {
//     return view('product');
// });
Route::get('/forgetpw', function () {
    return view('forgetpw');
});
Route::get('/purchase', function () {
    return view('purchase');
});
Route::get('/sales', function () {
    return view('sales');
});
Route::get('/report', function () {
    return view('reports');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/vendors', function () {
    return view('vendors');
});
Route::get('/signup', function () {
    return view('createaccount');
});
use App\Http\Controllers\CategoryDetailsController;

Route::get('/category', [CategoryDetailsController::class, 'create'])->name('category.create');
Route::get('/category', [CategoryDetailsController::class, 'index'])->name('category.index');
Route::post('/category', [CategoryDetailsController::class, 'store'])->name('category.store');

use App\Http\Controllers\UserController;
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::put('/users/{user_details}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user_details}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/adminlogin', function () {
    return view('adminlogin');
});
Route::post('/adminlogin', [UserController::class, 'login'])->name('adminlogin.login');


use App\Http\Controllers\ProductDetailsController;
Route::get('/product', [ProductDetailsController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductDetailsController::class, 'create'])->name('product.create');
Route::post('/product', [ProductDetailsController::class, 'store'])->name('product.store');
Route::get('/product/{product_details}', [ProductDetailsController::class, 'show'])->name('product.show');
Route::get('/product/{product_details}/edit', [ProductDetailsController::class, 'edit'])->name('product.edit');
Route::put('/product/{product_details}', [ProductDetailsController::class, 'update'])->name('product.update');
Route::delete('/product/{product_details}', [ProductDetailsController::class, 'destroy'])->name('product.destroy');