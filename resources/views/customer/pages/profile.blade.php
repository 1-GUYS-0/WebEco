@extends('customer.layout-app.layout')
@section('content')
<div class="container">
    <div class="profile-header">
        <div class="avatar">
            <div class="card-image">
                <img class="product-detail_image" src="{{ asset('system/cards-image0.png') }}" alt="" />
            </div>
            <input type="file" id="avatarInput" accept="image/*">
            <label for="avatarInput">Update Avatar</label>
        </div>
        <div class="info">
            <div>Name: John Doe <span onclick="editInfo('name')">Thay đổi</span></div>
            <div>Phone: 123-456-7890 <span onclick="editInfo('phone')">Thay đổi</span></div>
            <div>Address: 123 Main St, City, Country <span onclick="editInfo('address')">Thay đổi</span></div>
        </div>
    </div>
    <div class="profile-content">
        <div class="tabs">
            <div class="tab active" onclick="showTab('order')">Your Orders</div>
            <div class="tab" onclick="showTab('cart')">Your Cart</div>
        </div>
        <div class="tab-content">
            <div class="order active">
                @foreach ($orders as $order)
                <div class="order-item">
                    <h1>Order #{{ $order->id }}</h1>
                    <div class="display_item">
                        <p>Trạng thái đơn hàng: {{ $order->status }}</p>
                        <p>Phương Thức Thanh toán: {{ $order->payment->payment_method }}</p>
                        <p>Chi phí đơn hàng: {{ $order->total }}</p>
                    </div>
                    <h2>Danh sách sản phẩm</h2>
                    <ul>
                        @foreach ($order->orderItems as $order_item)
                        <li>{{ $order_item->product->name }} - Số Lượng: {{ $order_item->quantity }} - Tổng giá: {{ $order_item->price }}</li>
                        @endforeach
                    </ul>
                    <button onclick="confirmReceived()">Confirm Received</button>
                </div>
                @endforeach
                <!-- Add more orders as needed -->
            </div>
            <div class="cart">
                <div class="cart-item">
                    <p>Product Name</p>
                    <p>Quantity: 2</p>
                    <button>Remove from Cart</button>
                </div>
                <!-- Add more cart items as needed -->
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('front-end/js/profile.js') }}"></script>
@endsection