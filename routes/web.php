<?php

use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\CustomerController as CustomerCustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\LoginController;
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
Route:: get('/log-in', [LoginController::class, 'showSignUpForm'])->name('customer.pages.log-in');
Route:: post('/log-in', [LoginController::class, 'login'])->name('customer.login');

Route:: get('/log-out', [LoginController::class, 'showLogout'])->name('customer.pages.log-out')->middleware('CheckLogin');
Route:: post('/log-out', [LoginController::class, 'logout'])->name('customer.logout');
Route:: get('/sign-in', [PageController::class, 'signIn']);
Route:: post('/password-request', [LoginController::class, 'resetPassword'])->name('password.request');

Route:: get('/home', [CustomerHomeController::class, 'index'])->name('customer.home');
Route:: get('/product/load-more', [CustomerHomeController::class, 'loadMore'])->name('customer.products.loadMore');

Route:: get('/payment', [CustomerPaymentController::class, 'index']);
Route:: get('/product/{id}', [CustomerProductController::class, 'show'])->name('product.show');

Route::get('/cart', [ CustomerCartController::class, 'show'])->name('cart.show');
Route::post('/cart/add', [ CustomerCartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [ CustomerCartController::class, 'updateCart'])->name('cart.remove');

Route::get('/customer/profile/{id}', [CustomerCustomerController::class, 'profile'])->name('customer.profile');

