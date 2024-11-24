@extends('customer.layout-app.layout')

@section('content')

<!-- Custom CSS -->
<style>
    .store-info {
        padding: 20px;
        font-family: Arial, sans-serif;
        text-align: center;
    }
    .guide-button {
        margin-bottom: 20px;
    }
    .guide-button button {
        background-color: #62ad50;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
    }
    .guide-button button:hover {
        background-color: #0056b3;
    }
    .store-columns {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    .store-column {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        width: calc(33.333% - 40px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
    }
    .store-column h2 {
        font-size: 24px;
        color:  #62ad50;
        margin-bottom: 10px;
    }
    .store-column p {
        font-size: 16px;
        color: #333;
    }
</style>

<div class="store-info">

    <!-- Guide Button -->
    <div class="guide-button">
        <button onclick="window.location.href='/guide'">Hướng dẫn sử dụng</button>
    </div>

    <!-- Store Information Columns -->
    <div class="store-columns">
        <div class="store-column">
            <h2>Về chúng tôi</h2>
            <p>Chúng tôi là cửa hàng mỹ phẩm hàng đầu, cung cấp các sản phẩm chất lượng cao từ các thương hiệu nổi tiếng.</p>
        </div>
        <div class="store-column">
            <h2>Sản phẩm</h2>
            <p>Chúng tôi cung cấp đa dạng các loại mỹ phẩm bao gồm kem dưỡng da, son môi, phấn nền, và nhiều sản phẩm khác.</p>
        </div>
        <div class="store-column">
            <h2>Liên hệ</h2>
            <p>Địa chỉ: 123 Đường ABC, Quận 1, TP. Hồ Chí Minh</p>
            <p>Điện thoại: 0123 456 789</p>
            <p>Email: info@cosmeticsstore.com</p>
        </div>
    </div>

</div>

@endsection