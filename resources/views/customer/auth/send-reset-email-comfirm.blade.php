@extends('customer.preview-page.layout-app.layout')
@section('content')
<div>
    <h1>Đã gữi yêu cầu thành công vui lòng kiểm tra Gmail của bạn</h1>
    <button type="submit" class="button">
        <a class="light-text" href="{{ route('customer.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
    </button>
</div>
@endsection