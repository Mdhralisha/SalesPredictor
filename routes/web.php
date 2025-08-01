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
Route::get('/changepw', function () {
    return view('changepw');
}) ->name('changepw');
// // Route::get('/purchase', function () {
// //     return view('purchase');
// });
Route::get('/sales', function () {
    return view('sales');
});
Route::get('/report', function () {
    return view('reports');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
// Route::get('/customers', function () {
//     return view('customers');
// });
Route::get('/test', function () {
    return view('test');
});
Route::get('/purchasereport', function () {
    return view('purchasereport');
});

Route::get('/signup', function () {
    return view('createaccount');
});
Route::get('/salesreport', function () {
    return view('salesreport');
});
Route::get('/salespredictreport', function () {
    return view('salespredictreport');
});
Route::get('/inventoryreport', function () {
    return view('inventoryreport');
});
Route::get('/salesclusteringreport', function () {
    return view('salesclusteringreport');
});
use App\Http\Controllers\CategoryDetailsController;

Route::get('/category', [CategoryDetailsController::class, 'create'])->name('category.create');
Route::get('/category', [CategoryDetailsController::class, 'index'])->name('category.index');
Route::post('/category', [CategoryDetailsController::class, 'store'])->name('category.store');
Route::get('/category/{category_details}', [CategoryDetailsController::class, 'show'])->name('category.show');
Route::put('/category/{category_details}', [CategoryDetailsController::class, 'update'])->name('category.update');
Route::delete('/category/{category_details}', [CategoryDetailsController::class, 'destroy'])->name('category.destroy');

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

use App\Http\Controllers\VendorDetailsController;
Route::get('/vendor', [VendorDetailsController::class, 'index'])->name('vendor.index');
Route::get('/vendor/create', [VendorDetailsController::class, 'create'])->name('vendor.create');
Route::post('/vendor', [VendorDetailsController::class, 'store'])->name('vendor.store');
Route::get('/vendor/{vendor_details}', [VendorDetailsController::class, 'show'])->name('vendor.show');
Route::put('/vendor/{vendor_details}', [VendorDetailsController::class, 'update'])->name('vendor.update');
Route::delete('/vendor/{vendor_details}', [VendorDetailsController::class, 'destroy'])->name(' vendor.destroy');

use App\Http\Controllers\PurchaseDetailsController;
Route::get('/purchase', [PurchaseDetailsController::class, 'index'])->name('purchase.index');
Route::get('/purchase/create', [PurchaseDetailsController::class, 'create'])->name('purchase.create');
Route::post('/purchase', [PurchaseDetailsController::class, 'store'])->name('purchase.store');

Route::put('/purchase/{purchase_details}', [PurchaseDetailsController::class, 'update'])->name('purchase.update');
Route::delete('/purchase/{purchase_details}', [PurchaseDetailsController::class, 'destroy'])->name('purchase.destroy');
Route::get('/get-products-by-vendor/{vendor_id}', [PurchaseDetailsController::class, 'getProductsByVendor']);
Route::get('/get-product-price/{product_id}', [PurchaseDetailsController::class, 'getProductDetails']);

Route::post('/purchases/save-multiple', [PurchaseDetailsController::class, 'saveMultiple'])->name('purchase.saveMultiple');

use App\Http\Controllers\CustomerDetailsController;
Route::get('/customer', [CustomerDetailsController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerDetailsController::class, 'create'])->name('customer.create');
Route::post('/customer', [CustomerDetailsController::class, 'store'])->name('customer.store');
Route::get('/customer/{customer_details}', [CustomerDetailsController::class, 'show'])->name('customer.show');
Route::put('/customer/{customer_details}', [CustomerDetailsController::class, 'update'])->name('customer.update');
Route::delete('/customer/{customer_details}', [CustomerDetailsController::class, 'destroy'])->name('customer.destroy');

use App\Http\Controllers\SalesDetailsController;
Route::get('/sales', [SalesDetailsController::class, 'index'])->name('sales.index');
Route::get('/sales/create', [SalesDetailsController::class, 'create'])->name    ('sales.create');
Route::post('/sales', [SalesDetailsController::class, 'store'])->name('sales.store');
Route::get('/sales/{sales_details}', [SalesDetailsController::class, 'show'])->name('sales.show');
Route::put('/sales/{sales_details}', [SalesDetailsController::class, 'update'])->name('sales.update');
Route::delete('/sales/{sales_details}', [SalesDetailsController::class, 'destroy'])->name('sales.destroy');
Route::post('/saveMultiple', [SalesDetailsController::class, 'saveMultiple'])->name('sales.saveMultiple');
Route::get('/get-product-sale-price/{id}', [SalesDetailsController::class, 'getProductSalePrice']);