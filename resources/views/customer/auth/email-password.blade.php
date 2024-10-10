@extends('customer.preview-page.layout-app.layout')
@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <label for="email">Email tài khoản đã đăng ký:</label>
    <input type="email" id="email" name="email" required>
    <button type="submit" class="button">
        <a class="light-text"> Gữi yêu cầu đặt lại mật khẩu</a
    </button>
</form>
@endsection