@extends('customer.layout-app.layout')
@section('content')
<div class="sign-up_wrapper">
    <div class="sign-up_form">
        <form>
            <div class="form_input">
                <label for="myEmail" class="input-lable">Email</label>
                <label class="input-desc">Description</label>
                <input type="text" id="myEmail" placeholder="Nhập email tài khoản" size="5">
                <label class="input-error ">Error</label>
            </div>
            <div class="form_input">
                <label for="myPassw" class="input-lable">Password</label>
                <label class="input-desc">Description</label>
                <input type="text" id="myPassw" placeholder="Nhập mật khẩu tài khoản" size="5">
                <label class="input-error">Error</label>
            </div>
        </form> <!-- form write information to sign up-->
        <button type="button" onclick="alert('Xin chào!')" class="button">
            <div class="light-text">Sign up</div>
        </button> <!--button sign up-->
        <div class="sign-up_forgot">
            <a>Forgot password?</a>
        </div> <!--link forgot password-->
    </div>
</div>
@endsection