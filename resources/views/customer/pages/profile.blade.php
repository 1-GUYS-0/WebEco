@extends('customer.layout-app.layout')
@section('content')
<div class="container">
    <div class="profile-header">
        <div class="avatar">
            <div class="card-image">
                <img class="product-detail_image" src="{{ asset($customer->avarar_path) }}" alt="" />
            </div>
            <!-- Popup để thay đổi hình ảnh -->
            <div id="avatarPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closePopup('avatarPopup')">&times;</span>
                    <h2>Thay đổi hình ảnh đại diện</h2>
                    <input type="file" id="avatar" accept="image/*" onchange="previewAvatar(event)">
                    <div>
                        <img id="avatarPreview" src="{{ asset($customer->avarar_path) }}" alt="" />
                    </div>
                    <button onclick="document.getElementById('avatar').click()">Chọn hình ảnh</button>
                    <button onclick="updateProfile('avatar')">Lưu thay đổi</button>
                </div>
            </div>
            <button onclick="showPopup('avatarPopup')">Thay đổi</button>
        </div>
        <div class="info">
            <div>Tên: <span id="name">{{ $customer->name }}</span> <button onclick="updateProfile('name')">Thay đổi</button></div>
            <div>Số điện thoại: <span id="phone">{{ $defaultAddress->phone }}</span> <button onclick="updateProfile('phone')">Thay đổi</button></div>
            <div>Địa chỉ mặc định: <span>{{ $defaultAddress->province }}, {{ $defaultAddress->district }}, {{ $defaultAddress->ward }}, {{ $defaultAddress->address }} .</span> <button onclick="showPopup('addressPopup')">Thay đổi</button></div>
        </div>
    </div>
    <div class="profile-content">
        <div class="tabs">
            <div class="tab active" onclick="showTab('order')">Đơn hành của bạn</div>
            <div class="tab" onclick="showTab('order_finish')">Đơn hàng đã giao thành công</div>
        </div>
        <div class="tab-content">
            <div class="order active">
                @foreach ($orders as $order)
                @if($order->status == 'pending'|| $order->status == 'completed' || $order->status == 'shipping' )
                <div class="order-item">
                    <h3>Mã Order #{{ $order->id }}</h3>
                    <div class="display_item">
                        @if ($order->status == 'pending')
                        <p class="pending-color">Trạng thái đơn hàng: {{ $order->status }}</p>
                        @else ($order->status == 'shipping')
                        <p class="shipping-color">Trạng thái đơn hàng: {{ $order->status }}</p>
                        @endif

                        <p>Phương Thức Thanh toán: {{ $order->payment->payment_method }}</p>
                        <p>Chi phí đơn hàng: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                    </div>
                    <h2>Danh sách sản phẩm</h2>
                    <ul>
                        @foreach ($order->orderItems as $order_item)
                        <li>{{ $order_item->product->name }} - Số Lượng: {{ $order_item->quantity }} - Tổng giá: {{ $order_item->price }}</li>
                        @endforeach
                    </ul>
                    <h4>Ngày đặt hàng: {{ formatVNDate($order->created_at) }}</h4>
                    <button onclick="confirmReceived()">Xác nhận đã nhận hàng</button>
                    @if($order->payment->payment_method == 'cash')
                    <button onclick="confirmReceived('{{ $order->id }}')">Hủy đơn hàng</button>
                    @else
                    <button onclick="confirmReceived('{{ $order->id }}')">Hủy đơn hàng và hoàn tiền</button>
                    @endif
                </div>
                @else()
                <h3>Bạn chưa có đơn hàng nào</h3>
                @endif
                @endforeach
            </div>
            <div class="order_finish">
                @foreach ($orders as $order)
                @if ($order->status == 'completed')
                <div class="order_finish-item">
                    <h3>Mã Order #{{ $order->id }}</h3>
                    <div class="display_item">
                        <p class="completed-color">Trạng thái đơn hàng: {{ $order->status }}</p>
                        <p>Phương Thức Thanh toán: {{ $order->payment->payment_method }}</p>
                        <p>Chi phí đơn hàng: {{ number_format($order->total_price, 0, ',', '.') }} VND</p>
                    </div>
                    <h2>Danh sách sản phẩm</h2>
                    <ul>
                        @foreach ($order->orderItems as $order_item)
                        <li>{{ $order_item->product->name }} - Số Lượng: {{ $order_item->quantity }} - Tổng giá: {{ $order_item->price }}</li>
                        @endforeach
                    </ul>
                    <h4>Ngày đặt hàng: {{ formatVNDate($order->created_at) }}</h4>
                    <button onclick="confirmReceived()">Xác nhận đã nhận hàng</button>
                    @if($order->payment->payment_method == 'cash')
                    <button onclick="confirmReceived('{{ $order->id }}')">Hủy đơn hàng</button>
                    @else
                    <button onclick="confirmReceived('{{ $order->id }}')">Hủy đơn hàng và hoàn tiền</button>
                    @endif
                </div>
                @else()
                @endif
                @endforeach
                <!-- Add more cart items as needed -->
            </div>
        </div>
    </div>
</div>
<!-- Popup for changing default address -->
<div id="addressPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup('addressPopup')">&times;</span>
        <h2>Chọn địa chỉ giao hàng mặc định</h2>
        <div class="address-options">
            <select title="select new address" id="address">
                <!-- Options will be populated dynamically -->
                @foreach ($anotherAddresses as $anotherAddress)
                <option value="{{ $anotherAddress->id }}">
                    {{ $anotherAddress->province }}, {{ $anotherAddress->district }}, {{ $anotherAddress->ward }}, {{ $anotherAddress->address }} .
                </option>
                @endforeach
            </select>
        </div>
        <button onclick="updateProfile('address')">Xác nhận thay đổi</button>
        <button onclick="window.location.href='/add-new-address'">Nhập địa chỉ mới</button>
    </div>
</div>
<script>
    const update_profile = '{{ route("customer.profile.update") }}';
</script>
<script src="{{ asset('front-end/js/profile.js') }}"></script>
@endsection
<?php
function formatVNDate($dateString)
{
    $date = \Carbon\Carbon::parse($dateString);
    return $date->format('d/m/Y H:i:s');
}
?>