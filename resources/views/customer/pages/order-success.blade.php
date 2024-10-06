@extends('customer.layout-app.layout')
@section('content')
<div class="container">
    <h1>Đặt hàng thành công</h1>
    <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xác nhận.</p>
    <ul>
        @foreach($vnpayResponse as $key => $value)
        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
        @endforeach
    </ul>
    <a href="{{ route('customer.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
</div>
@endsection