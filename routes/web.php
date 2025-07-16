<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/base', function () {
    return view('base');
});
Route::get('/category', function () {
    return view('categories');
});
Route::get('/adminlogin', function () {
    return view('adminlogin');
});







