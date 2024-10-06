
@extends('customer.layout-app.layout')
@section('content')
<div class="container">
    <h1>Đặt hàng không thành công</h1>
    <p>Rất tiếc, đã có lỗi xảy ra trong quá trình đặt hàng. Vui lòng thử lại. Cụ thể:</p>
    <p>{{ $errorMessage }}</p>
    <a href="{{ route('customer.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
</div>
@endsection