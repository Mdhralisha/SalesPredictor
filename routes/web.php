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

Route::get('/product', function () {
    return view('products');
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