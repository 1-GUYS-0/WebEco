<?php

use App\Http\Controllers\Customer\PreviewPageController as CustomerPreviewPageController;
use App\Http\Controllers\Customer\HomeController as CustomerHomeController;
use App\Http\Controllers\Customer\PaymentController as CustomerPaymentController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\CustomerController as CustomerCustomerController;
use App\Http\Controllers\Customer\VoucherController as CustomerVoucherController;
use App\Http\Controllers\Customer\VNPayController as CustomerVNPayController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\PromotionDiscountController as CustomerPromotionDiscountController;
use App\Http\Controllers\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\Auth\CustomerResetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\LogSignController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

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
Route::get('/products', [ProductController::class, 'show'])->name('products.view_products');
// route thêm sản phẩm  
Route::get('/product/add-product', [ProductController::class, 'create'])->name('products.view_add-product');
Route::post('/product/add-product', [ProductController::class, 'store'])->name('products.add-product');
// route sửa và xóa sản phẩm
Route::get('/product/edit-product/{id}', [ProductController::class, 'edit'])->name('products.view_edit-product');
Route::delete('/product/delete-product/{id}', [ProductController::class, 'destroy'])->name('products.delete-product');

//Định nghĩa routr cho trang quản lý slide
Route::get('/slides', [PageController::class, 'slides']);

// Định nghĩa route cho trang quản lý đơn hàng
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::get('/', [CustomerOrderController::class, 'index'])->name('index');
    Route::post('/{orderId}/edit', [CustomerOrderController::class, 'updateOrderManager'])->name('edit');
    Route::post('/{orderId}/delete/cash', [CustomerOrderController::class, 'deleteOrderCash'])->name('delete-order-cash');
    Route::post('/{orderId}/completed/cash', [CustomerOrderController::class, 'completedOrderCash'])->name('confirm-received');
    Route::get('/{orderId}/review', [CustomerOrderController::class, 'showReviewForm'])->name('show-review-form');
    Route::post('/{orderId}/review', [CustomerOrderController::class, 'submitReview'])->name('submit-review');
});

// Định nghĩa route cho trang quản lý người dùng
Route::get('/users', [PageController::class, 'users']);

// ĐỊnh nghĩa route cho trang quản lý admin
Route::get('/admins', [PageController::class, 'admins']);

//=====Customer routes=====\
Route::get('/log-in', [LogSignController::class, 'showLoginForm'])->name('customer.pages.log-in');
Route::post('/log-in', [LogSignController::class, 'login'])->name('customer.login');
Route::get('/sign-up', [LogSignController::class, 'showSignupForm'])->name('customer.pages.sign-up');
Route::post('/sign-up', [LogSignController::class, 'signup'])->name('customer.signup');

Route::get('/log-out', [LogSignController::class, 'showLogout'])->name('customer.pages.log-out')->middleware('CheckLogin');
Route::post('/log-out', [LogSignController::class, 'logout'])->name('customer.logout');


Route::get('/home', [CustomerHomeController::class, 'index'])->name('customer.home')->middleware('CheckLogin');
Route::get('/home/product/load-more', [CustomerHomeController::class, 'loadMore'])->name('customer.products.loadMore');

Route::get('home/customer/payment', [CustomerPaymentController::class, 'showPaymentPage'])->middleware('CheckLogin');
Route::post('home/customer/payment', [CustomerPaymentController::class, 'processPayment'])->name('payment')->middleware('CheckLogin');
Route::get('home/customer/product/{id}', [CustomerProductController::class, 'show'])->name('product.show');
Route::post('home/customer/payment/apply-voucher', [CustomerVoucherController::class, 'applyVoucher'])->name('voucher.apply');
Route::post('home/customer/payment/submitorder', [CustomerPaymentController::class, 'submitOrder'])->name('submit.order');
Route::post('home/customer/VNPAYpayment', [CustomerVNPayController::class, 'createPayment'])->name('vnpay.payment');
Route::get('home/customer/VNPAYpayment/return', [CustomerVNPayController::class, 'paymentReturn'])->name('vnpay.payment.return');

Route::get('home/customer/search-page', [CustomerProductController::class, 'showSearchPage'])->name('search.page');
Route::get('home/customer/search', [CustomerProductController::class, 'search'])->name('product.search');
Route::get('home/customer/promotion-discount', [CustomerPromotionDiscountController::class, 'index'])->name('promotion.discount');


Route::get('/order-success', [CustomerPaymentController::class, 'orderSuccess'])->name('order.success');
Route::get('/order-failure', [CustomerPaymentController::class, 'orderFailure'])->name('order.failure');

Route::get('home/cart', [CustomerCartController::class, 'show'])->name('cart.show');
Route::post('home/cart/add', [CustomerCartController::class, 'addToCart'])->name('cart.add');
Route::post('home/cart/update/{id}', [CustomerCartController::class, 'updateCart'])->name('cart.update');
Route::post('home/cart/remove/{id}', [CustomerCartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('home/customer/profile', [CustomerCustomerController::class, 'profile'])->name('customer.profile')->middleware('CheckLogin');
Route::get('home/customer/profile/editIfor/{id}', [CustomerCustomerController::class, 'edit'])->name('customer.profile.edit');
Route::post('home/customer/profile/update', [CustomerCustomerController::class, 'updateProfile'])->name('customer.profile.update');

// Prevỉew page
Route::get('/preview/index', [CustomerPreviewPageController::class, 'index'])->name('preview.index');
Route::get('preview/product/{id}', [CustomerPreviewPageController::class, 'show'])->name('preview.product.show');

Route::get('password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('password/reset/confirmation', [CustomerForgotPasswordController::class, 'SendResetLinkEmailConfirmation'])->name('password.reset.confirmation');
Route::post('password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [CustomerResetPasswordController::class, 'reset'])->name('password.update');
