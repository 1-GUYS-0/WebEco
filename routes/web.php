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
        Route::post('/{orderId}/detailrefund', [AdminController::class, 'detailRefund'])->name('detailRefund');
        Route::post('/{orderId}/refund/confirm', [AdminController::class, 'refundConfirm'])->name('refundConfirm');
        Route::post('/{orderId}/refund/reject', [AdminController::class, 'refundReject'])->name('refundReject');
    });
    // Định nghĩa nhóm route cho trang quản lý sản phẩm
    Route::prefix('products')->group(function () {
        // Định nghĩa route cho trang quản lý sản phẩm
        Route::get('/', [ProductController::class, 'show'])->name('products.showProductMng');
        // route thêm sản phẩm
        Route::get('/add-product', [ProductController::class, 'create'])->name('products.view_add-product');
        Route::post('/add-product', [ProductController::class, 'store'])->name('products.add-product');
        // route cập nhật sản phẩm
        Route::post('/update-product/{id}', [ProductController::class, 'update'])->name('products.update-product');
    });


    // Định nghĩa nhóm route cho trang quản lý slide
    Route::prefix('banners')->group(function () {
        Route::get('/', [AdminController::class, 'banners'])->name('banners.showBannerMng');
        Route::get('/{id}', [AdminController::class, 'getBannerDetails'])->name('banners.details');
        Route::post('/add', [AdminController::class, 'addBanner'])->name('banners.add');
        Route::post('/update', [AdminController::class, 'updateBanner'])->name('banners.update');
        Route::post('/delete', [AdminController::class, 'deleteBanner'])->name('banners.delete');
    });

    // Định nghĩa route cho trang promotion
    Route::prefix('promotions')->group(function () {
        Route::get('/', [AdminController::class, 'showPromotionMng'])->name('promotions.showPromotionMng');
        Route::get('/{id}', [AdminController::class, 'getPromotionDetails'])->name('promotions.details');
        Route::post('/add', [AdminController::class, 'addPromotion'])->name('promotions.add');
        Route::post('/update', [AdminController::class, 'updatePromotion'])->name('promotions.update');
        Route::post('/delete', [AdminController::class, 'deletePromotion'])->name('promotions.delete');
    });

    // Định nghĩa route cho trang quản lý voucher
    Route::prefix('vouchers')->group(function () {
        Route::get('/', [AdminController::class, 'vouchers'])->name('vouchers.showVoucherMng');
        Route::get('/{id}', [AdminController::class, 'getVoucherDetails'])->name('vouchers.details');
        Route::post('/add', [AdminController::class, 'addVoucher'])->name('vouchers.add');
        Route::post('/update', [AdminController::class, 'updateVoucher'])->name('vouchers.update');
        Route::post('/delete', [AdminController::class, 'deleteVoucher'])->name('vouchers.delete');
    });

    // Định nghĩa route cho trang quản lý khách hàng
    Route::prefix('customers')->group(function () {
        Route::get('/', [AdminController::class, 'customers'])->name('customers.showCustomerMng');
        Route::get('/{id}', [AdminController::class, 'getCustomerDetails'])->name('customers.details');
        Route::post('/update', [AdminController::class, 'updateCustomer'])->name('customers.update');
        Route::post('/delete', [AdminController::class, 'deleteCustomer'])->name('customers.delete');
    });
    // Định nghĩa route cho trang quản lý admin
    Route::prefix('admins')->middleware(['CheckAdminRole'])->group(function () {
        Route::get('/', [AdminController::class, 'admins'])->name('admins.showAdminMng');
        Route::get('/{id}', [AdminController::class, 'getAdminDetails'])->name('admins.details');
        Route::post('/add', [AdminController::class, 'addAdmin'])->name('admins.add');
        Route::post('/update', [AdminController::class, 'updateAdmin'])->name('admins.update');
        Route::post('/delete', [AdminController::class, 'deleteAdmin'])->name('admins.delete');
    });
    // Định nghĩa route đăng xuất
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

//=====Customer routes=====
Route::prefix('home')->middleware(['CheckLogin'])->group(function () {
    Route::get('/', [CustomerHomeController::class, 'index'])->name('customer.home');
    // Đăng xuất
    Route::get('/log-out', [LogSignController::class, 'showLogout'])->name('customer.pages.log-out');
    Route::post('/log-out', [LogSignController::class, 'logout'])->name('customer.logout');
    // Định nghĩa route cho trang quản lý thông báo
    Route::get('/notifications', [CustomerNotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [CustomerNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    // Sản phẩm
    Route::prefix('product')->group(function () {
        Route::get('/{id}', [CustomerProductController::class, 'show'])->name('product.show');
        Route::get('/load-more', [CustomerHomeController::class, 'loadMore'])->name('customer.products.loadMore');
        Route::post('/interested', [CustomerHomeController::class, 'getInterestedProducts'])->name('customer.products.interested');
    });
    // Order
    Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
        Route::post('/{orderId}/delete/cash', [CustomerOrderController::class, 'deleteOrderCash'])->name('delete-order-cash');
        Route::post('/{orderId}/delete/vnpay', [CustomerVNPayController::class, 'paymentRefund'])->name('delete-order-vnpay');
        Route::post('/{orderId}/completed', [CustomerOrderController::class, 'completedOrder'])->name('confirm-received');
        Route::get('/{orderId}/review', [CustomerOrderController::class, 'showReviewForm'])->name('show-review-form');
        Route::post('/{orderId}/review', [CustomerOrderController::class, 'submitReview'])->name('submit-review');
        Route::get('/orderdetail/{orderId}', [CustomerOrderController::class, 'getOrderDetails'])->name('get-order-details');
        Route::post('/return', [CustomerOrderController::class, 'orderReturnRequest'])->name('orders.return');
    });
    // Thanh toán
    Route::prefix('payment')->group(function () {
        Route::get('/', [CustomerPaymentController::class, 'showPaymentPage']);
        Route::post('/', [CustomerPaymentController::class, 'processPayment'])->name('payment');
        Route::post('/apply-voucher', [CustomerVoucherController::class, 'applyVoucher'])->name('voucher.apply');
        Route::post('/submitorder', [CustomerPaymentController::class, 'submitOrder'])->name('submit.order');
        // API VNPAY
        Route::post('/VNPAYpayment', [CustomerVNPayController::class, 'createPayment'])->name('vnpay.payment');
        Route::get('/VNPAYpayment/return', [CustomerVNPayController::class, 'paymentReturn'])->name('vnpay.payment.return');
    });
    // Tìm kiếm và danh mục
    Route::prefix('search')->group(function () {
        Route::get('/search-page', [CustomerProductController::class, 'showSearchPage'])->name('search.page');
        Route::get('/search', [CustomerProductController::class, 'search'])->name('product.search');
    });
    // Khuyến mãi và giảm giá
    Route::get('/promotion-discount', [CustomerPromotionDiscountController::class, 'index'])->name('promotion.discount');
    // Phản hồi order
    Route::get('/order-success', [CustomerPaymentController::class, 'orderSuccess'])->name('order.success');
    Route::get('/order-failure', [CustomerPaymentController::class, 'orderFailure'])->name('order.failure');
    // Giỏ hàng
    Route::prefix('cart')->group(function () {
        Route::get('/', [CustomerCartController::class, 'show'])->name('cart.show');
        Route::post('/add', [CustomerCartController::class, 'addToCart'])->name('cart.add');
        Route::post('/update/{id}', [CustomerCartController::class, 'updateCart'])->name('cart.update');
        Route::post('/remove/{id}', [CustomerCartController::class, 'removeFromCart'])->name('cart.remove');
    });
    // Thông tin cá nhân
    Route::prefix('profile')->group(function () {
        Route::get('/', [CustomerCustomerController::class, 'profile'])->name('customer.profile');
        Route::post('/update', [CustomerCustomerController::class, 'updateProfile'])->name('customer.profile.update');
    });
});
// Đăng nhập
Route::get('/log-in', [LogSignController::class, 'showLoginForm'])->name('customer.pages.log-in');
Route::post('/log-in', [LogSignController::class, 'login'])->name('customer.login');
Route::get('/sign-up', [LogSignController::class, 'showSignupForm'])->name('customer.pages.sign-up');
Route::post('/sign-up', [LogSignController::class, 'signup'])->name('customer.signup');
Route::get('/sign-up/verify/{token}', [LogSignController::class, 'verify'])->name('customer.verify');
// Quên mật khẩu
Route::get('password/reset', [CustomerForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::get('password/reset/confirmation', [CustomerForgotPasswordController::class, 'SendResetLinkEmailConfirmation'])->name('password.reset.confirmation');
Route::post('password/email', [CustomerForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [CustomerResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [CustomerResetPasswordController::class, 'reset'])->name('password.update');
// Route::get('/log-out', [LogSignController::class, 'showLogout'])->name('customer.pages.log-out')->middleware('CheckLogin');
// Route::post('/log-out', [LogSignController::class, 'logout'])->name('customer.logout');



// Route::get('/home', [CustomerHomeController::class, 'index'])->name('customer.home')->middleware('CheckLogin');
// Route::get('/home/product/load-more', [CustomerHomeController::class, 'loadMore'])->name('customer.products.loadMore');
// Route::post('/home/product/interested', [CustomerHomeController::class, 'getInterestedProducts'])->name('customer.products.interested');

// Route::get('home/payment', [CustomerPaymentController::class, 'showPaymentPage'])->middleware('CheckLogin');
// Route::post('home/payment', [CustomerPaymentController::class, 'processPayment'])->name('payment')->middleware('CheckLogin');
// Route::get('home/product/{id}', [CustomerProductController::class, 'show'])->name('product.show');
// Route::post('home/payment/apply-voucher', [CustomerVoucherController::class, 'applyVoucher'])->name('voucher.apply');
// Route::post('home/payment/submitorder', [CustomerPaymentController::class, 'submitOrder'])->name('submit.order');
// Route::post('homepayment/VNPAYpayment', [CustomerVNPayController::class, 'createPayment'])->name('vnpay.payment');
// Route::get('homepayment/VNPAYpayment/return', [CustomerVNPayController::class, 'paymentReturn'])->name('vnpay.payment.return');

// Route::get('home/search-page', [CustomerProductController::class, 'showSearchPage'])->name('search.page');
// Route::get('home/search', [CustomerProductController::class, 'search'])->name('product.search');
// Route::get('home/promotion-discount', [CustomerPromotionDiscountController::class, 'index'])->name('promotion.discount');


// Route::get('/order-success', [CustomerPaymentController::class, 'orderSuccess'])->name('order.success');
// Route::get('/order-failure', [CustomerPaymentController::class, 'orderFailure'])->name('order.failure');

// Route::get('home/cart', [CustomerCartController::class, 'show'])->name('cart.show');
// Route::post('home/cart/add', [CustomerCartController::class, 'addToCart'])->name('cart.add');
// Route::post('home/cart/update/{id}', [CustomerCartController::class, 'updateCart'])->name('cart.update');
// Route::post('home/cart/remove/{id}', [CustomerCartController::class, 'removeFromCart'])->name('cart.remove');

// Route::get('home/profile', [CustomerCustomerController::class, 'profile'])->name('customer.profile')->middleware('CheckLogin');
// // Route::get('home/profile/editIfor/{id}', [CustomerCustomerController::class, 'edit'])->name('customer.profile.edit');
// Route::post('home/profile/update', [CustomerCustomerController::class, 'updateProfile'])->name('customer.profile.update');

// // Prevỉew page
// Route::get('/preview/index', [CustomerPreviewPageController::class, 'index'])->name('preview.index');
// Route::get('preview/product/{id}', [CustomerPreviewPageController::class, 'show'])->name('preview.product.show');
