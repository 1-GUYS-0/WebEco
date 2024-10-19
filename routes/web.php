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
use App\Http\Controllers\Customer\NotificationController as CustomerNotificationController;
use App\Http\Controllers\Auth\CustomerForgotPasswordController;
use App\Http\Controllers\Auth\CustomerResetPasswordController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Customer\LogSignController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/admin/login', [AdminController::class, 'showlogin'])->name('admin.show-login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');

// Định nghĩa route cho trang chủ admin
Route::prefix('admin')->middleware(['CheckAdminLog'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'showDashboardMng'])->name('dashboards.showDashboardMng');
    Route::post('/dashboard/filter', [AdminController::class, 'filterDashboardData'])->name('dashboards.filterDashboardData');
    Route::get('/dashboard/datachart', [AdminController::class, 'filterDashboardChartData'])->name('dashboards.filterDashboardChartData');

    // Định nghĩa route cho trang quản lý danh mục sản phẩm
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'show'])->name('categories.showCategoryMng');
        Route::get('/add-category', [CategoryController::class, 'create'])->name('categories.view_add-category');
        Route::post('/add-category', [CategoryController::class, 'store'])->name('categories.add-category');
        Route::post('/edit-category/{id}', [CategoryController::class, 'edit'])->name('categories.view_edit-category');
        Route::post('/delete-category/{id}', [CategoryController::class, 'destroy'])->name('categories.delete-category');
    });
    // Định nghĩa các nhóm các route trong quản lý đơn đặt hàng
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::get('/', [AdminController::class, 'showOrderMng'])->name('showOrderMng');
        Route::post('/{orderId}/edit', [AdminController::class, 'updateOrderManager'])->name('oderEditMng');
        Route::get('/{orderId}/detail', [AdminController::class, 'detailOrderMng'])->name('orderDetailMng');
    });
    // Định nghĩa route cho trang quản lý sản phẩm
    Route::get('/products', [ProductController::class, 'show'])->name('products.showProductMng');
    // route thêm sản phẩm  
    Route::get('/product/add-product', [ProductController::class, 'create'])->name('products.view_add-product');
    Route::post('/products/add-product', [ProductController::class, 'store'])->name('products.add-product');
    // route cập nhật sản phẩm
    Route::post('/product/update-product/{id}', [ProductController::class, 'update'])->name('products.update-product');
    // route sửa và xóa sản phẩm
    Route::get('/product/edit-product/{id}', [ProductController::class, 'edit'])->name('products.view_edit-product');
    Route::delete('/product/delete-product/{id}', [ProductController::class, 'destroy'])->name('products.delete-product');

    // Định nghĩa route cho trang quản lý slide
    Route::get('/banners', [AdminController::class, 'banners'])->name('banner.showBannerMng');
    Route::post('/banners/update-banner', [AdminController::class, 'updateBanner'])->name('banner.updateBanner');
    Route::post('/banners/add-banner', [AdminController::class, 'addBanner'])->name('banner.addBanner');

    // Định nghĩa route cho trang promotion
    Route::get('/promotions', [AdminController::class, 'showPromotionMng'])->name('promotions.showPromotionMng');
    // Định nghĩa route cho trang quản lý voucher
    Route::get('/vouchers', [AdminController::class, 'vouchers'])->name('vouchers.showVoucherMng');
    // Định nghĩa route cho trang quản lý khách hàng
    Route::get('/customers', [AdminController::class, 'customers'])->name('customers.showCustomerMng');
    // Định nghĩa route cho trang quản lý admin
    Route::get('/admins', [AdminController::class, 'admins'])->name('admins.showAdminMng');
    // Định nghĩa route đăng xuất
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

// Định nghĩa route cho trang quản lý đơn hàng
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::post('/{orderId}/delete/cash', [CustomerOrderController::class, 'deleteOrderCash'])->name('delete-order-cash');
    Route::post('/{orderId}/delete/vnpay', [CustomerVNPayController::class, 'paymentRefund'])->name('delete-order-vnpay');
    Route::post('/{orderId}/completed/cash', [CustomerOrderController::class, 'completedOrderCash'])->name('confirm-received');
    Route::get('/{orderId}/review', [CustomerOrderController::class, 'showReviewForm'])->name('show-review-form');
    Route::post('/{orderId}/review', [CustomerOrderController::class, 'submitReview'])->name('submit-review');
    Route::get('/orderdetail/{orderId}', [CustomerOrderController::class, 'getOrderDetails'])->name('get-order-details');
    Route::post('/orders/return', [CustomerOrderController::class, 'orderReturnRequest'])->name('orders.return');
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

    // Định nghĩa route cho trang quản lý thông báo
Route::get('home/notifications', [CustomerNotificationController::class, 'index'])->name('notifications.index');
Route::post('home/notifications/{id}/read', [CustomerNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/home', [CustomerHomeController::class, 'index'])->name('customer.home')->middleware('CheckLogin');
Route::get('/home/product/load-more', [CustomerHomeController::class, 'loadMore'])->name('customer.products.loadMore');
Route::post('/home/product/interested', [CustomerHomeController::class, 'getInterestedProducts'])->name('customer.products.interested');

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
