<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/base', function () {
    return view('base');
});
Route::get('/category', function () {
    return view('category');
});
Route::get('/adminlogin', function () {
    return view('adminlogin');
});
Route::get('/sidebar', function () {
    return view('includes.sidebar');
});
Route::get('/users', function () {
    return view('users');
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
    return view('report');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});






