@extends('customer.layout-app.layout')
@section('content')
<div class="dis-and-promo-container">
    <div class="banner-section">
        <h2>Chương trình khuyến mãi nổi bật</h2>
        @foreach($banners as $banner)
        <div class="banner">
            <a href="{{$banner->link_to}}">
                <img src="{{ asset($banner->images_path) }}" alt="{{$banner->title}}">
            </a>
        </div>
        @endforeach
    </div>
    <div class="discount-section">
        <h2>Mã giảm giá dành cho bạn</h2>
        <div class="discounts">
            @foreach($vouchers as $voucher)
            @if ($voucher->name ==="Sale All Time" && $voucher->start_time <= date('H:i:s') && $voucher->end_time >= date('H:i:s'))
                <div class="discount">
                    <img src="{{ asset($voucher->image_path) }}" alt="discount">
                    <span class="code" hidden>{{$voucher->code}}</span>
                    <button onclick="copyCode('{{$voucher->code}}')">Sao chép</button>
                </div>
                @endif
                @endforeach
        </div>
        <h2>Giảm giá vào khung giờ vàng từ 9-12</h2>
        <div id="9-12-hour-discounts" style="min-width:100%;">
            <div style="display:flex;">
                <div id="countdown" class="countdown"></div>
            </div>
            <div class="discounts">
                @foreach($vouchers as $voucher)
                @if ($voucher->name === "9-12 Gold hours Sale" && $voucher->start_time <= date('H:i:s') && $voucher->end_time >= date('H:i:s'))
                    <div class="discount">
                        <img src="{{ asset($voucher->image_path) }}" alt="discount">
                        <span class="code" hidden>{{$voucher->code}}</span>
                        <button onclick="copyCode('{{$voucher->code}}')">Sao chép</button>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('front-end/js/promotion-and-discount.js') }}"></script>
@endsection
