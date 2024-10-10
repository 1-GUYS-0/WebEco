@extends('customer.layout-app.layout')
@section('content')
<div class="container">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    <div class="profile-header">
        <div class="avatar">
            <div class="card-image">
                <img class="product-detail_image" src="{{ asset($customer->avatar_path) }}" alt="" />
            </div>
            <!-- Popup để thay đổi hình ảnh -->
            <div id="avatarPopup" class="popup">
                <div class="popup-content">
                    <span class="close" onclick="closePopup('avatarPopup')">&times;</span>
                    <h2>Thay đổi hình ảnh đại diện</h2>
                    <input type="file" id="avatar" accept="image/*" onchange="previewAvatar(event)">
                    <div>
                        <img id="avatarPreview" src="{{ asset($customer->avatar_path) }}" alt="" />
                    </div>
                    <button onclick="document.getElementById('avatar').click()">Chọn hình ảnh</button>
                    <button onclick="updateProfile('avatar')">Lưu thay đổi</button>
                </div>
            </div>
            <button onclick="showPopup('avatarPopup')">Thay đổi</button>
        </div>
        <div class="info">
            <div>Tên: <span id="name">{{ $customer->name }}</span> <button onclick="updateProfile('name')">Thay đổi</button></div>
            @if ($defaultAddress !== null)
            <div>Địa chỉ mặc định: <span>{{ $defaultAddress->province }}, {{ $defaultAddress->district }}, {{ $defaultAddress->ward }}, {{ $defaultAddress->address }} .</span> <button onclick="showPopup('addressPopup')">Thay đổi</button></div>
            @else
            <div>Địa chỉ mặc định: <span></span> <button onclick="showPopup('addressPopup')">Thay đổi</button></div>
            @endif
            @if($defaultAddress !== null)
            <div>Số điện thoại: <span id="phone">{{ $customer->number_phone }}</span> <button onclick="updateProfile('phone')">Thay đổi</button></div>
            @else
            <div>Số điện thoại: <span id="phone"></span> <button onclick="updateProfile('phone')">Thay đổi</button></div>
            @endif
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
                @if($order->status == 'pending'|| $order->status == 'shipping' )
                <div class="order-item">
                    <h3>Mã Order #{{ $order->id }}</h3>
                    <div class="display_item">
                        @if ($order->status == 'pending')
                        <p class="pending-color">Trạng thái đơn hàng: {{ $order->status }}</p>
                        @else
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
                    <button onclick="confirmReceived('{{ $order->id }}')">Xác nhận đã nhận hàng</button>
                    @if ($order->status == 'pending')
                    @if($order->payment->payment_method == 'cash')
                    <button onclick="confirmDelete('{{ $order->id }}')">Hủy đơn hàng</button>
                    @else
                    <button onclick="confirmReceived('{{ $order->id }}')">Hủy đơn hàng và hoàn tiền</button>
                    @endif
                    @endif
                </div>
                @else()
                @endif
                @endforeach
                <h3>Đơn hàng của bạn đã hết!</h3>
            </div>
            <div class="order_finish">
                @foreach ($orders as $order)
                @if ($order->status == 'completed' || $order->status == 'rated')
                <div class="order_finish-item">
                    <h3>Mã Order #{{ $order->id }}</h3>
                    <div class="display_item">
                        @if ($order->status == 'completed')
                        <p class="completed-color">Trạng thái đơn hàng: {{ $order->status }}</p>
                        @else
                        <p class="rated-color">Trạng thái đơn hàng: {{ $order->status }}</p>
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
                    @if ($order->status == 'completed')
                        <button onclick="showReviewForm('{{ $order->id }}')">Đánh giá cho sản phẩm</button>
                    @else
                        
                    @endif
                </div>
                @else()
                @endif
                @endforeach
                <h3>Đơn hàng của bạn đã hết!</h3>
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
        <button onclick="showPopup('addNewAddresspopup')">Nhập địa chỉ mới</button>
    </div>
</div>
<!-- Popup for adding new address -->
<div id="addNewAddresspopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup('addNewAddresspopup')">&times;</span>
        <div class="infor_cust">
            <h3>Điền các thông tin cho địa chỉ mới của bạn</h3>
            <div class="cust_contain">
                <div class="cust_input">
                    <select id="province" name="province" aria-label="Chọn tỉnh thành" required>
                        <option value="" disabled selected hidden>Chọn 1 tỉnh thành</option>
                    </select>
                </div>
                <div class="cust_input">
                    <select id="district" name="district" aria-label="Chọn tỉnh Quận/Huyện" required>
                        <option value="" disabled selected hidden>Chọn 1 Quận/Huyện</option>
                    </select>
                </div>
                <div class="cust_input">
                    <select id="ward" name="ward" aria-label="Chọn tỉnh Phường/Xã" required>
                        <option value="" disabled selected hidden>Chọn 1 Phường/Xã</option>
                    </select>
                </div>
                <div class="cust_input">
                    <label for="myNumber" class="input">
                        <input type="text" id="myNumber" name="phone" class="input__lable" placeholder="Nhập số điện thoại" required>
                    </label>
                </div>
                <div class="cust_input">
                    <label for="myAddress" class="input">
                        <input type="text" id="myAddress" name="address" class="input__lable" placeholder="Nhập số nhà, tên đường" required>
                    </label>
                </div>
            </div>
            <button onclick="submitNewAddress()">Xác nhận cập nhật</button>
        </div>
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