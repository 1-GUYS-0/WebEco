@extends('customer.layout-app.layout')
@section('content')
<div class="container">
    <div class="banner-section">
        <h2>Chương trình</h2>
        <div class="banner">
            <img src="banner1.jpg" alt="Banner 1">
        </div>
        <div class="banner">
            <img src="banner2.jpg" alt="Banner 2">
        </div>
        <div class="banner">
            <img src="banner3.jpg" alt="Banner 3">
        </div>
    </div>
    <div class="discount-section">
        <h2>Giảm giá</h2>
        <div class="discount">
            <span class="code">DISCOUNT2023</span>
            <button onclick="copyCode('DISCOUNT2023')">Sao chép</button>
        </div>
        <div class="discount">
            <span class="code">SALE50</span>
            <button onclick="copyCode('SALE50')">Sao chép</button>
        </div>
        <div class="discount">
            <span class="code">FREESHIP</span>
            <button onclick="copyCode('FREESHIP')">Sao chép</button>
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
</script>
@endsection