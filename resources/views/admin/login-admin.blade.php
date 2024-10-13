<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('backend/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/css/vars.css')}}">
</head>

<body>
    <div class="log_container">
        <div class="log_wrapper">
            <div class="log_brand">
                <div class="menu_logo">
                    <img src="{{ asset('backend/asset/dashboard/logo.png')}}" />
                </div>
                <h1 class="title">Green Nature Comestics</h1>
            </div>
            <div class="log_form">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="form_input">
                        <h2 for="myEmail" class="input-lable">Email</h2>
                        <label class="input-desc">Nhập email của tài khoản</label>
                        <input type="email" id="myEmail" name="email" placeholder="Enter your email" size="5" required>
                        @error('email')
                        <label class="input-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="form_input">
                        <h2 for="myPassw" class="input-lable">Password</h2>
                        <label class="input-desc">Nhập mật khẩu tài khoản</label>
                        <input type="password" id="myPassw" name="password" placeholder="Enter your password" size="5" required>
                        @error('password')
                        <label class="input-error">{{ $message }}</label>
                        @enderror
                    </div>
                    @if (session('error'))
                    <div class="input-error">
                        {{ session('error') }}
                    </div>
                    @endif
                    <button type="submit" class="button light-text ">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>