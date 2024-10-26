@extends('customer.layout-app.layout')
@section('content')
<form id="order-form" method="POST" action="/submit-order">
    <div class="pay-card_wrapper">
        @csrf <!-- Laravel CSRF token for security -->
        <div class="pay-card_infor-cust">
            <div class="infor_cust">
                <h3>Thông tin liên hệ của khách hàng: {{$customerInfo['name']}}</h3>
                <div class="text">Email khách hàng: {{$customerInfo['email']}}</div>
                <!-- <div class="text">Địa chỉ giao hàng đã lưu</div>
                <div class="address-options">
                    <select title="select new address" id="choseAddress">
                        @foreach ($customerInfo['addresses'] as $anotherAddress)
                        <option value="{{ $anotherAddress->province }}, {{ $anotherAddress->district }}, {{ $anotherAddress->ward }}, {{ $anotherAddress->phone }}, {{ $anotherAddress->address }}">
                            {{ $anotherAddress->province }}, {{ $anotherAddress->district }}, {{ $anotherAddress->ward }}, {{ $anotherAddress->phone }}, {{ $anotherAddress->address }} .
                        </option>
                        @endforeach
                    </select>
                </div> -->
                <div class="text">Địa chỉ giao hàng của bạn:</div>
                <div class="cust_contain">
                    <div class="cust_input">
                        <label for="myName" class="input">
                            <input type="text" id="myName" name="name" class="input__lable" value="{{$customerInfo['name']}}" required>
                        </label>
                    </div>
                    <div class="cust_input">
                        <select id="province" name="province" aria-label="Chọn tỉnh thành" required>
                            @if ($defaultAddress == null)
                                <option value="" disabled selected hidden>Chọn 1 tỉnh thành</option>
                            @else
                            <option value="{{ $defaultAddress->province }}" selected>{{ $defaultAddress->province }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="cust_input">
                        <select id="district" name="district" aria-label="Chọn tỉnh Quận/Huyện" required>
                            @if ($defaultAddress == null)
                                <option value="" disabled selected hidden>Chọn 1 Quận/Huyện</option>
                            @else
                            <option value="{{ $defaultAddress->district }}" selected> {{ $defaultAddress->district }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="cust_input">
                        <select id="ward" name="ward" aria-label="Chọn tỉnh Phường/Xã" required>
                            @if ($defaultAddress == null)
                                <option value="" disabled selected hidden>Chọn 1 Phường/Xã</option>
                            @else
                            <option value="{{ $defaultAddress->ward }}" selected> {{ $defaultAddress->ward }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="cust_input">
                        <label for="myNumber" class="input">
                            @if ($defaultAddress == null)
                            <input type="text" id="myNumber" name="phone" class="input__lable" placeholder="Nhập số điện thoại" required>
                            @else
                            <input type="text" id="myNumber" name="phone" class="input__lable" value="{{ $defaultAddress->phone }}" required>
                            @endif
                        </label>
                    </div>
                    <div class="cust_input">
                        <label for="myAddress" class="input">
                            @if ($defaultAddress == null)
                            <input type="text" id="myAddress" name="address" class="input__lable" placeholder="Nhập số nhà, tên đường" required>
                            @else
                            <input type="text" id="myAddress" name="address" class="input__lable" value="{{ $defaultAddress->address }}" required>
                            @endif
                        </label>
                    </div>
                </div>
            </div><!-- address of customer -->
            <div class="div"></div>
            <div class="infor_method-ex bg-secondary">
                <div class="cust_input">
                    <select id="shipping-method" name="shipping_method" aria-label="Chọn phương thức vận chuyển" required>
                        <option value="" disabled selected hidden>Chọn 1 phương thức vận chuyển</option>
                        <option value="ahamove">Ahamove</option>
                        <option value="ghn">Giao hàng nhanh</option>
                        <option value="ghtk">Giao hàng tiết kiệm</option>
                        <option value="grap">GrapExpress</option>
                    </select>
                </div>
                <div class="cust_input">
                    <select name="payment_method" aria-label="Chọn Phương Thức Thanh Toán" required>
                        <option value="" disabled selected hidden>Chọn 1 Phương Thức Thanh Toán</option>
                        <option value="cash">Tiền mặt</option>
                        <option value="vnpay">VNPay</option>
                    </select>
                </div>
            </div><!-- method express and payment -->
            <div class="div"></div>
            <div class="infor_mess">
                <label for="message" style="min-height: 7rem;">
                    <textarea id="message" name="message" class="mess_lable" placeholder="Bạn có lời nhắn gì thêm cho shop....."></textarea>
                </label>
            </div>
        </div> <!-- information of order -->
        <div class="pay-card_total-price bg-primary">
            <section class="product-selected">
                <h3>Chi tiết đơn hàng</h3>
                <ol class="product-list">
                    @foreach ($products as $product)
                    <li class="product-items" value="{{$product['id']}}">
                        <img src="{{ asset($product['image_path']) }}" alt="Product Image" class="product-image_selected" />
                        <div class="product-details">
                            <input class="inputProductId" type="hidden" name="product_id[]" value="{{ $product['id'] }}">
                            <a class="cards_name-prod">{{ $product['name'] }}</a>
                            <div class="quantity-controls">
                                <a> Số lượng:</a>
                                <input type="number" class="number-order" name="quantity[]" value="{{ $product['quantity'] }}" min="1">
                            </div>
                            <div>
                                <span class="price">{{ number_format($product['price'] * $product['quantity'], 0, ',', '.') }} VND</span>
                                <input type="hidden" name="price[]" value="{{ $product['price'] * $product['quantity'] }}">
                            </div>
                        </div>
                        <button type="button" class="remove-product" onclick="removeProductFromSelect(`{{$product['id']}}`)">
                            <span class="material-symbols-outlined">cancel</span>
                        </button>
                    </li>
                    @endforeach
                </ol>
            </section>
            <div class="div"></div>
            <section class="total-price">
                <div class="total-price_voucher">
                    <h3>Mã Khuyến Mãi</h3>
                    <label for="myVoucher">
                        <input type="text" id="voucher-code" name="voucher" placeholder="Nhập mã voucher">
                    </label>
                    <button type="button" id="apply-voucher" class="button">
                        <div class="light-text">Áp dụng</div>
                    </button>
                </div>
                <div class="div"></div>
                <div class="price-breakdown">
                    <div class="price-breakdown_details">
                        <dl>
                            <dt>Tạm tính:</dt>
                            <dd id="estimated_price" value="{{ $product['price'] * $product['quantity'] }}">{{ number_format($product['price'] * $product['quantity'], 0, ',', '.') }} VND</dd>
                            <dt>Giảm giá:</dt>
                            <dd id="discount-amount" value="0">0</dd>
                            <dt>Phí vận chuyển:</dt>
                            <dd id="shipping-fee" value="0">0</dd>
                        </dl>
                    </div>
                    <div class="div"></div>
                    <div class="total-price_cost">
                        <div class="cost_contain">
                            <dl>
                                <dt>Tổng cộng:</dt>
                                <dd id="total-price" name="total_price" value="0">{{ number_format($product['price'] * $product['quantity'], 0, ',', '.') }} VND</dd>
                            </dl>
                        </div>
                        <button type="button" id="immediate-payment-button" class="button">
                            <div class="light-text">Thanh toán ngay!</div>
                        </button>
                    </div>
                </div>
                <div class="div"></div>
                <p class="terms-and-conditions">
                    * Khi nhấn nút Đặt hàng nghĩa là bạn đã đọc và đồng ý với các điều khoản,
                    chính sách bán hàng và bảo mật của chúng tôi tại Website
                </p>
            </section>
        </div><!-- calculator price and chosen products -->
    </div>
</form>
<script src="{{ asset('front-end/js/payment.js') }}"></script>
@endsection