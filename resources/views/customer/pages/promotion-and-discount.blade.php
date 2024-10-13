@extends('customer.layout-app.layout')
@section('content')
<div class="dis-and-promo-container">
    <div class="banner-section">
        <h2>Chương trình khuyến mãi nổi bật</h2>
        @foreach($banners as $banner)
        <div class="banner">
            <img src="{{ asset($banner->images_path) }}" alt="{{$banner->title}}">
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

<script>
    function copyCode(code) {
        navigator.clipboard.writeText(code).then(() => {
            alert('Đã sao chép mã: ' + code);
        }).catch(err => {
            console.error('Lỗi khi sao chép mã: ', err);
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('9-12-hour-discounts') === null) {
            return;
        }
        else {
            var startTime = '09:00:00';
            var endTime = '12:00:00';

            var endDateTime = new Date();
            var [endHours, endMinutes, endSeconds] = endTime.split(':');
            endDateTime.setHours(endHours);
            endDateTime.setMinutes(endMinutes);
            endDateTime.setSeconds(endSeconds);

            var countdownElement = document.getElementById('countdown');
            var interval = setInterval(function() {
                var now = new Date().getTime();
                var distance = endDateTime - now;

                if (distance < 0) {
                    clearInterval(interval);
                    countdownElement.innerHTML = "Chưa đến thời gian khuyến mãi, hãy quay lại sau!";
                    return;
                }

                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                countdownElement.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
            }, 1000);
        }
    });
</script>
@endsection