<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryDetailsController;
use App\Http\Controllers\ProductDetailsController;
use App\Http\Controllers\VendorDetailsController;
use App\Http\Controllers\PurchaseDetailsController;
use App\Http\Controllers\CustomerDetailsController;
use App\Http\Controllers\SalesDetailsController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/sales/latest-invoice', [SalesDetailsController::class, 'latestInvoice'])->name('sales.latestInvoice');
Route::get('/sales-report', [SalesDetailsController::class, 'getSalesClusters']);


Route::get('/login', function () {
    return view('adminlogin');
})->name('login');

Route::post('/adminlogin', [UserController::class, 'login'])->name('adminlogin.login');

Route::get('/signup', function () {
    return view('createaccount');
})->name('signup');

Route::get('/forgetpw', function () {
    return view('forgetpw');
});

Route::get('/changepw', function () {
    return view('changepw');
})->name('changepw');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


Route::get('/inventory', function () {
    return view('landingpage');
});
Route::get('/sales-prediction-report', [SalesDetailsController::class, 'showPredictionReport'])->name('sales.prediction.report');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/sidebar', function () {
        return view('includes.sidebar');
    });

    Route::get('/base', function () {
        return view('base');
    });

    Route::get('/report', function () {
        return view('reports');
    });

    Route::get('/salesreport', [ReportController::class, 'salesReport'])->name('sales.report');
    Route::get('/salesreport', [ReportController::class, 'salesReport']);

    Route::get('/salespredictreport', function () {
        return view('salespredictreport');
    });

    Route::get('/inventoryreport', [ReportController::class, 'inventoryReport'])->name('inventory.report');
    Route::get('/inventoryreport', [ReportController::class, 'inventoryReport']);


    Route::get('/salesclusteringreport', function () {
        return view('salesclusteringreport');
    });

    Route::get('/editpurchase', function () {
        return view('editpurchase');
    });

    Route::get('/test', function () {
        return view('test');
    });



    Route::get('/purchasereport', [ReportController::class, 'purchaseReport'])->name('purchase.report');
    Route::get('/purchasereport', [ReportController::class, 'purchaseReport']);
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');


    // Category routes
    Route::get('/category', [CategoryDetailsController::class, 'index'])->name('category.index');
    Route::get('/category/create', [CategoryDetailsController::class, 'create'])->name('category.create');
    Route::post('/category', [CategoryDetailsController::class, 'store'])->name('category.store');
    Route::get('/category/{category_details}', [CategoryDetailsController::class, 'show'])->name('category.show');
    Route::put('/category/{category_details}', [CategoryDetailsController::class, 'update'])->name('category.update');
    Route::delete('/category/{category_details}', [CategoryDetailsController::class, 'destroy'])->name('category.destroy');

    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user_details}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user_details}', [UserController::class, 'destroy'])->name('users.destroy');

    // Product routes
    Route::get('/product', [ProductDetailsController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductDetailsController::class, 'create'])->name('product.create');
    Route::post('/product', [ProductDetailsController::class, 'store'])->name('product.store');
    Route::get('/product/{product_details}', [ProductDetailsController::class, 'show'])->name('product.show');
    Route::get('/product/{product_details}/edit', [ProductDetailsController::class, 'edit'])->name('product.edit');
    Route::put('/product/{product_details}', [ProductDetailsController::class, 'update'])->name('product.update');
    Route::delete('/product/{product_details}', [ProductDetailsController::class, 'destroy'])->name('product.destroy');

    // Vendor routes
    Route::get('/vendor', [VendorDetailsController::class, 'index'])->name('vendor.index');
    Route::get('/vendor/create', [VendorDetailsController::class, 'create'])->name('vendor.create');
    Route::post('/vendor', [VendorDetailsController::class, 'store'])->name('vendor.store');
    Route::get('/vendor/{vendor_details}', [VendorDetailsController::class, 'show'])->name('vendor.show');
    Route::put('/vendor/{vendor_details}', [VendorDetailsController::class, 'update'])->name('vendor.update');
    Route::delete('/vendor/{vendor_details}', [VendorDetailsController::class, 'destroy'])->name('vendor.destroy');

    // Purchase routes
    Route::get('/purchase', [PurchaseDetailsController::class, 'index'])->name('purchase.index');
    Route::get('/purchase/create', [PurchaseDetailsController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseDetailsController::class, 'store'])->name('purchase.store');
    Route::put('/purchase/{purchase_details}', [PurchaseDetailsController::class, 'update'])->name('purchase.update');
    Route::delete('/purchase/{id}', [PurchaseDetailsController::class, 'destroy'])->name('purchase.destroy');
    Route::get('/get-products-by-vendor/{vendor_id}', [PurchaseDetailsController::class, 'getProductsByVendor']);
    Route::get('/get-product-price/{product_id}', [PurchaseDetailsController::class, 'getProductDetails']);
    Route::post('/purchases/save-multiple', [PurchaseDetailsController::class, 'saveMultiple'])->name('purchase.saveMultiple');

    // Customer routes
    Route::get('/customer', [CustomerDetailsController::class, 'index'])->name('customer.index');
    Route::get('/customer/create', [CustomerDetailsController::class, 'create'])->name('customer.create');
    Route::post('/customer', [CustomerDetailsController::class, 'store'])->name('customer.store');
    Route::get('/customer/{customer_details}', [CustomerDetailsController::class, 'show'])->name('customer.show');
    Route::put('/customer/{customer_details}', [CustomerDetailsController::class, 'update'])->name('customer.update');
    Route::delete('/customer/{customer_details}', [CustomerDetailsController::class, 'destroy'])->name('customer.destroy');

    // Sales routes
    Route::get('/sales', [SalesDetailsController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SalesDetailsController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SalesDetailsController::class, 'store'])->name('sales.store');
    Route::get('/sales/{id}', [SalesDetailsController::class, 'show'])->name('sales.show');
    Route::put('/sales/{sales_details}', [SalesDetailsController::class, 'update'])->name('sales.update');
    Route::delete('/sales/{id}', [SalesDetailsController::class, 'destroy'])->name('sales.destroy');
    Route::post('/saveMultiple', [SalesDetailsController::class, 'saveMultiple'])->name('sales.saveMultiple');
    Route::get('/get-product-sale-price/{id}', [SalesDetailsController::class, 'getProductSalePrice']);
});
