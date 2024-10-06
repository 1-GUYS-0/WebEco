@extends('customer.preview-page.layout-app.layout')
@section('content')
<div class="background-log">
    <img src="{{ asset('system/background_log.jpg') }}" alt="banner" class="banner">
</div>
<div class="log_container">
    <div class="log_wrapper">
        <div class="log_form">
            <form method="POST" action="{{ route('customer.signup') }}">
                @csrf
                <div class="form_input">
                    <label for="myName" class="input-lable">Tên khách hàng</label>
                    <label class="input-desc">Nhập tên của bạn</label>
                    <input type="text" id="myName" placeholder="Nhập tên của bạn" size="5" required>
                </div>
                <div class="form_input">
                    <label for="myEmail" class="input-lable">Email</label>
                    <label class="input-desc">Nhập địa chỉ email đăng ký</label>
                    <input type="email" id="myEmail" name="email" placeholder="Enter your email" size="5" required>
                    @error('email')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form_input">
                    <label for="myPassw" class="input-lable">Password</label>
                    <label class="input-desc">Nhập mật khẩu</label>
                    <input type="password" id="myPassw" name="password" placeholder="Enter your password" size="5" required>
                    @error('password')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>
                <button type="submit" class="button">
                    <div class="light-text">Đăng ký tài khoản</div>
                </button>
            </form> <!-- form write information to sign up-->
        </div>
    </div>
</div>
@endsection