<?php

use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

// Định nghĩa route cho trang chủ admin
Route::get('/dashboard', [PageController::class, 'dashboard']);

// Định nghĩa route cho trang quản lý danh mục sản phẩm
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'show'])->name('categories.view_categories');
    Route::get('/add-category', [CategoryController::class, 'create'])->name('categories.view_add-category');
    Route::post('/add-category', [CategoryController::class, 'store'])->name('categories.add-category');
    Route::get('/edit-category/{id}', [CategoryController::class, 'edit'])->name('categories.view_edit-category');
    Route::delete('/delete-category/{id}', [CategoryController::class, 'destroy'])->name('categories.delete-category');
});

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
Route:: get('/home', [CustomerHomeController::class, 'index']);
Route::get('/product/load-more', [CustomerHomeController::class, 'loadMore'])->name('customer.products.loadMore');

Route:: get('/payment', [CustomerPaymentController::class, 'index']);
Route:: get('/product', [PageController::class, 'product']);


// //test
// Route:: get('/test', [CustomerProductController::class, 'index']);
// Route::get('/test/load-more', [CustomerProductController::class, 'loadMore'])->name('customer.products.loadMore');