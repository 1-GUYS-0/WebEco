@extends('customer.preview-page.layout-app.layout')
@section('content')
<div class="background-log">
    <img src="{{ asset('system/background_log.jpg') }}" alt="banner" class="banner">
</div>
<h2 class ="log_container" style="min-height: 33%;"> 
    Hãy đăng nhập để sử dụng toàn bộ dịch vụ của Green Nature Comestics 
</h2>
<!-- Hiển thị thông báo success hoặc error -->
<div class ="log_container">
    <div class="log_wrapper">
        <div class="log_form">
            <form method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="form_input">
                    <label for="myEmail" class="input-lable">Email</label>
                    <input type="email" id="myEmail" name="email" placeholder="Nhập email của tài khoản" size="5" required>
                    @error('email')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form_input">
                    <label for="myPassw" class="input-lable">Password</label>
                    <input type="password" id="myPassw" name="password" placeholder="Nhập mật khẩu tài khoản" size="5" required>
                    @error('password')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>
                <button type="submit" class="button">
                    <div class="light-text">Đăng nhập</div>
                </button>
                <button type="submit" class="button">
                    <a class="light-text" href="{{route('customer.pages.sign-up')}}">Tạo tài khoản mới</a>
                </button>
            </form> <!-- form write information to sign up-->
            <div class="log_forgot">
                <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
            </div> <!--link forgot password-->
        </div>
    </div>
</div>
@endsection