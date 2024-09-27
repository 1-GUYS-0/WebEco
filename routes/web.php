<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImagesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Models\ProductImage;

// Định nghĩa route cho trang chủ admin
Route::get('/dashboard', [PageController::class, 'dashboard']);

// Định nghĩa route cho trang quản lý danh mục sản phẩm
    // route trang danh mục
Route::get('/categories', [CategoryController::class, 'show'])->name('categories.view_categories');
    // route trang thêm danh mục
Route::get('/categories/add-category', [CategoryController::class, 'create'])->name('categories.view_add-category');
Route::post('/categories/add-category', [CategoryController::class, 'store'])->name('categories.add-category');
    // route sửa và xóa danh mục
Route::get('/categories/edit-category/{id}', [CategoryController::class, 'edit'])->name('categories.view_edit-category');
Route::delete('/categories/delete-category/{id}', [CategoryController::class, 'destroy'])->name('categories.delete-category');


// Định nghĩa route cho trang quảng lý sản phẩm
Route:: get('/products', [ProductController::class, 'show'])->name('products.view_products');
    // route thêm sản phẩm  
Route::get('/product/add-product', [ProductController::class, 'create'])->name('products.view_add-product');
Route::post('/product/add-product', [ProductController::class, 'store'])->name('products.add-product');
    // route sửa và xóa sản phẩm
Route::get('/product/edit-product/{id}', [ProductController::class, 'edit'])->name('products.view_edit-product');
Route::delete('/product/delete-product/{id}', [ProductController::class, 'destroy'])->name('products.delete-product');

//Định nghĩa routr cho trang quản lý slide
Route:: get('/slides', [PageController::class, 'slides']);

// Định nghĩa route cho trang quản lý đơn hàng
Route:: get('/orders', [PageController::class, 'orders']);

// Định nghĩa route cho trang quản lý người dùng
Route:: get('/users', [PageController::class, 'users']);

// ĐỊnh nghĩa route cho trang quản lý admin
Route:: get('/admins', [PageController::class, 'admins']);

//=====Customer routes=====\
Route:: get('/sign-up', [PageController::class, 'signUp']);
Route:: get('/sign-in', [PageController::class, 'signIn']);

Route:: get('/home', [PageController::class, 'home']);

Route:: get('/payment', [PageController::class, 'payment']);
Route:: get('/product', [PageController::class, 'product']);
