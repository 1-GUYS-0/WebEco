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
use App\Http\Controllers\Customer\CustomerReviewController as CustomerReviewController;
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
        Route::post('/refund/reject', [AdminController::class, 'refundReject'])->name('refundReject');
        Route::post('/{orderId}/delete', [AdminController::class, 'deleteOrder'])->name('deleteOrder');
    });
    // Định nghĩa nhóm route cho trang quản lý sản phẩm
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminController::class, 'products'])->name('products.showProductMng');
        Route::get('/{id}', [AdminController::class, 'getProductDetails'])->name('products.details');
        Route::post('/add', [AdminController::class, 'addProduct'])->name('products.add');
        Route::post('/update', [AdminController::class, 'updateProduct'])->name('products.update');
        Route::post('/delete', [AdminController::class, 'deleteProduct'])->name('products.delete');
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
        Route::get('/{productId}', [CustomerProductController::class, 'show'])->name('product.show');
        // Route::get('/load-more-product', [CustomerHomeController::class, 'loadMore'])->name('customer.product.loadMore');
        Route::post('/interested', [CustomerHomeController::class, 'getInterestedProducts'])->name('customer.product.interested');
        // Nhóm route review product
        Route::prefix('{productId}/review')->group(function () {
            Route::get('/', [CustomerReviewController::class, 'index'])->name('product.review.index');
            Route::post('/', [CustomerReviewController::class, 'store'])->name('product.review.store');
            Route::get('/{reviewId}', [CustomerReviewController::class, 'show'])->name('product.review.show');
            Route::put('/{reviewId}', [CustomerReviewController::class, 'update'])->name('product.review.update');
            Route::delete('/{reviewId}', [CustomerReviewController::class, 'destroy'])->name('product.review.destroy');
            Route::post('/filter', [CustomerReviewController::class, 'filter'])->name('product.review.filter');
        });
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
    // Thông tin chương trình khuyến mãi
    Route::prefix('promotion')->group(function () {
        Route::get('/first-promotion', [CustomerPromotionDiscountController::class, 'firstPromotionDetail'])->name('promotion.first');
    });


});
Route::get('/product/load-more-product', [CustomerHomeController::class, 'loadMorePd'])->name('customer.product.loadMore');
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
// Hướng dẫn và về chúng tôi
Route::get('/guide', [CustomerHomeController::class, 'guide'])->name('guide');
Route::get('/about-us', [CustomerHomeController::class, 'aboutUs'])->name('about-us');
