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
                    <input type="file" id="avatar" accept="image/*" onchange="previewAvatar(event,'avatarPreview')">
                    <div id="avatarPreview">
                        <img class="avatarPreview" src="{{ asset($customer->avatar_path) }}" alt="" />
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
                    <button onclick="confirmDelete('{{ $order->id }},{{$order->payment->payment_method}}')">Hủy đơn hàng</button>
                    @else
                    <button onclick="confirmDelete('{{ $order->id }}','{{$order->payment->payment_method}}')">Hủy đơn hàng và hoàn tiền</button>
                    @endif
                    @endif
                    <button onclick="showDetailOrder('{{ $order->id }}')">Chi tiết đơn hàng</button>
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
                    @php
                        $orderDate = \Carbon\Carbon::parse($order->created_at);
                        $now = \Carbon\Carbon::now();
                        $diffInDays = $now->diffInDays($orderDate);
                    @endphp
                    @if ($order->refundRequest == null)
                        @if ($diffInDays <= 3 && $order->payment->payment_method=='cash')
                            <button onclick="showPopupReturn('returnProductPopup','{{$order->id }}')"> Yêu cầu trả hàng</button>
                        @else
                            <button onclick="showPopupReturn('returnProductPopup','{{$order->id }}')"> Yêu cầu trả hàng và hoàn tiền</button>
                        @endif
                    @else
                        <button>Đang xử lý trả hàng....</button>
                    @endif
                    @else
                    @endif
                    <button onclick="showDetailOrder('{{ $order->id }}')">Chi tiết đơn hàng</button>
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
<!--popup for return product-->
<div id="returnProductPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup('returnProductPopup')">&times;</span>
        <h2>Yêu cầu trả hàng cho đơn hàng:</h2>
        <div class="returnProduct">
            <div class="returnProduct_item">
                <input id="returnProductId" value="" hidden>
                <h3>Tại sao bạn muốn trả đơn hàng này?</h3>
                <select id="returnProduct">
                    <option value="Sản phẩm không đúng mô tả">Sản phẩm không đúng mô tả</option>
                    <option value="Sản phẩm không đúng kích thước">Sản phẩm không đúng kích thước</option>
                    <option value="Sản phẩm không đúng màu sắc">Sản phẩm không đúng màu sắc</option>
                </select>
            </div>
            <div class="returnProduct_item">
                <h3>Hãy mô tả kĩ hơn về lý do trả hàng</h3>
                <textarea id="returnReason" rows="9"></textarea>
            </div>
            <div class="returnProduct_item">
                <h3> Hãy cung cấp cho chúng tôi hình ảnh về sản phẩm</h3>
                <input type="file" id="returnImage" multiple accept="image/*" onchange="previewAvatar(event,'returnPreview')" hidden>
                <div id="returnPreview">
                </div>
                <button onclick="document.getElementById('returnImage').click()">Chọn hình ảnh</button>
            </div>
            <button onclick=" submitReturnRequest()">Xác nhận trả hàng</button>
        </div>
    </div>
</div>
<!-- Popup for detail order-->
<div id="order-detail-popup" class="order-detail-popup">
    <div class="order-detail-content">
        <span class="close-btn" onclick="closeOrderDetailPopup()">&times;</span>
        <h2>Chi tiết đơn hàng</h2>
        <div id="order-detail-content">
            <!-- Nội dung chi tiết đơn hàng sẽ được hiển thị ở đây -->
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