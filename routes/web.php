<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


// Định nghĩa route cho trang chủ admin
Route::get('/dashboard', [PageController::class, 'dashboard']);

// Định nghĩa route cho trang quản lý danh mục sản phẩm
Route::get('/caters', [PageController::class, 'catergories']);

Route::get('/caters/add-category', [CategoryController::class, 'create'])->name('caters.view_add-category');
Route::post('/caters/add-category', [CategoryController::class, 'store'])->name('caters.add-category');


// Định nghĩa route cho trang quảng lý sản phẩm
Route:: get('/products', [PageController::class, 'products']);

Route::get('/product/add-product', [ProductController::class, 'create'])->name('caters.view_add-product');
Route::post('/product/add-product', [ProductController::class, 'store'])->name('caters.add-product');

//Định nghĩa routr cho trang quản lý slide
Route:: get('/slides', [PageController::class, 'slides']);

// Định nghĩa route cho trang quản lý đơn hàng
Route:: get('/orders', [PageController::class, 'orders']);

// Định nghĩa route cho trang quản lý người dùng
Route:: get('/users', [PageController::class, 'users']);

// ĐỊnh nghĩa route cho trang quản lý admin
Route:: get('/admins', [PageController::class, 'admins']);


