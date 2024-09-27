@extends('customer.layout-app.layout')
@section('content')
<div class="pay-card_wrapper">
    <div class="pay-card_infor-cust">
        <div class="infor_cust ">
            <h3>Thông tin liên hệ của bạn</h3>
            <div class="text">@gmail.com</div>
            <div class="text">Địa chỉ giao hàng</div>
            <div class="cust_contain">
                <div class="cust_input">
                    <form for="myName" class="input">
                        <input type="text" id="myName" class="input__lable"
                            placeholder="Họ và Tên">
                    </form>
                </div>
                <div class="cust_input">
                    <select aria-label="Chọn tỉnh thành">
                        <option value="" disabled selected hidden>Chọn 1 tỉnh thành</option>
                        <option value="2">TH.HCM</option>
                        <option value="3">Đà Nẵng</option>
                        <option value="3">Hà Nội</option>
                    </select>
                </div>
                <div class="cust_input">
                    <select aria-label="Chọn tỉnh Phường/Xã">
                        <option value="" disabled selected hidden>Chọn 1 Phườnh/Xã</option>
                        <option value="phuocmy">phước mỹ</option>
                        <option value="aa">aa</option>
                        <option value="bb">bb</option>
                    </select>
                </div>
                <div class="cust_input">
                    <form for="myNumber" class="input">
                        <input type="text" id="myNumber" class="input__lable"
                            placeholder="Nhập số điện thoại">
                    </form>
                </div>
                <div class="cust_input">
                    <select aria-label="Chọn tỉnh Quận/Huyện">
                        <option value="" disabled selected hidden>Chọn 1 Quận/Huyện</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                </div>
                <div class="cust_input">
                    <form for="myAdress" class="input">
                        <input type="text" id="myAdress" class="input__lable"
                            placeholder="Nhập số nhà, tên đường">
                    </form>
                </div>
            </div>
        </div><!--address of custormer-->
        <div class="div"></div>
        <div class="infor_method-ex  bg-secondary ">
            <div class=" cust_input">
                <select aria-label="Chọn phương thức vận chuyển">
                    <option value="" disabled selected hidden>Chọn 1 phương thức vận chuyển
                    </option>
                    <option value="tannha">Tận Nhà</option>
                </select>
            </div>
            <div class="cust_input">
                <select aria-label="Chọn Phương Thức Thanh Toán">
                    <option value="" disabled selected hidden>Chọn 1 Phương Thức Thanh Toán
                    </option>
                    <option value="tienmat">Tiền mặt</option>
                </select>
            </div>
        </div><!--method express and payment-->
        <div class="div"></div>
        <div class="infor_mess">
            <form>
                <textarea class="mess_lable"
                    placeholder="Bạn có lời nhắn gì thêm cho shop..... "></textarea>
            </form>
        </div>
    </div> <!--information of order-->
    <div class="pay-card_total-price bg-primary  ">
        <section class="product-selected">
            <h3>Chi tiết đơn hàng</h3>
            <ol class="product-list">
                <li class="product-items">
                    <img src="./src/cards-image0.png" alt="Product Image"
                        class="product-image_selected" />
                    <!--inmage of product selected-->
                    <div class="product-details">
                        <a class="cards_name-prod">Product</a>
                        <div class="quantity-controls">
                            <button type="button">
                                <span class="material-symbols-outlined">remove</span>
                            </button>
                            <div class="number-order">1</div>
                            <button type="button">
                                <span class="material-symbols-outlined">add</span>
                            </button>
                        </div>
                        <div>
                            <span class="price">$10.99</span>
                        </div>
                    </div>
                    <button type="button">
                        <span class="material-symbols-outlined">cancel</span>
                    </button>
                </li> <!--product selected-->
            </ol>
        </section>
        <div class="div"></div>
        <section class="total-price">
            <div class="total-price_voucher">
                <h3>Mã Khuyến Mãi</h3>
                <form>
                    <input type="text" id="myVoucher" placeholder="Enter voucher" size="5">
                    <button type="button" onclick="alert('Xin chào!')" class="button">
                        <div class="light-text">Áp dụng</div>
                    </button>
                </form>
            </div>
            <div class="div"></div>
            <div class="price-breakdown">
                <div class="price-breakdown_details">
                    <dl>
                        <dt>Tạm tính:</dt>
                        <dd class="price-breakdown__subtotal">1500</dd>
                        <dt>Giảm giá:</dt>
                        <dd class="price-breakdown__discount">5000</dd>
                        <dt>Phí vận chuyển:</dt>
                        <dd class="price-breakdown__shipping">30000</dd>
                    </dl>
                </div>
                <div class="div"></div>
                <div class="total-price_cost">
                    <div class="cost_contain">
                        <dl>
                            <dt>Tổng cộng:</dt>
                            <dd class="total-price__amount">150000</dd>
                        </dl>
                    </div>
                    <button type="button" onclick="alert('Xin chào!')" class="button">
                        <div class="light-text">Đặt hàng</div>
                    </button>
                </div>
            </div>
            <div class="div"></div>
            <p class="terms-and-conditions">
                * Khi nhấn nút Đặt hàng nghĩa là bạn đã đọc và đồng ý với các điều khoản,
                chính sách bán hàng và bảo mật của chúng tôi tại Website
            </p>
        </section>
    </div><!-- calculator price and choosed products-->
</div>
@endsection