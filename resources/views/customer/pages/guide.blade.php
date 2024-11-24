@extends('customer.layout-app.layout')

@section('content')

<!-- Custom CSS -->
<style>
    /* Reset cơ bản */
    body,
    h1,
    h2,
    p,
    img,
    div,
    section {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        background-color: #f8f8f8;
        color: #333;
    }

    .header {
        background-color: #62ad50;
        color: #fff;
        text-align: center;
        padding: 20px;
    }

    .content {
        width: 90%;
        max-width: 1200px;
        margin: 20px auto;
    }

    .step {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .step .text {
        flex: 1;
        padding: 20px;
    }

    .step .image {
        flex: 1;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #fef5f7;
    }

    .step .image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .footer {
        text-align: center;
        padding: 10px;
        background-color: #f07c82;
        color: #fff;
        margin-top: 20px;
        font-size: 0.9rem;
    }
</style>

<header class="header">
    <h1>Hướng Dẫn Sử Dụng Website Bán Hàng Mỹ Phẩm</h1>
</header>
<main class="content">
    <section class="step">
        <div class="text">
            <h2>Bước 1: Đăng Nhập/Đăng Ký</h2>
            <p>Người dùng cần đăng nhập hoặc đăng ký tài khoản để bắt đầu mua sắm.</p>
        </div>
        <div class="image">
            <img src="/system/sign.png" alt="Đăng Nhập/Đăng Ký">
        </div>
    </section>
    <section class="step">
        <div class="text">
            <h2>Bước 2: Tìm Kiếm Sản Phẩm</h2>
            <p>Sử dụng thanh tìm kiếm hoặc duyệt danh mục để tìm sản phẩm mỹ phẩm yêu thích.</p>
        </div>
        <div class="image">
            <img src="/system/search.png" alt="Tìm Kiếm Sản Phẩm">
        </div>
    </section>
    <section class="step">
        <div class="text">
            <h2>Bước 3: Thêm Vào Giỏ Hàng</h2>
            <p>Chọn sản phẩm và nhấn nút "Thêm vào giỏ hàng" để lưu sản phẩm.</p>
        </div>
        <div class="image">
            <img src="/system/add-cart.png" alt="Thêm Vào Giỏ Hàng">
        </div>
    </section>
    <section class="step">
        <div class="text">
            <h2>Bước 4: Thanh Toán</h2>
            <p>Nhấn vào giỏ hàng, điền thông tin và hoàn tất thanh toán.</p>
        </div>
        <div class="image">
            <img src="/system/payment.png" alt="Thanh Toán">
        </div>
    </section>
</main>

@endsection