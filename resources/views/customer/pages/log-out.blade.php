@extends('customer.layout-app.layout')
@section('content')
<div class="logout_wrapper">
    <div class="logout_form">
        <form method="POST" action="{{ route('customer.logout') }}">
            @csrf // Đây là token để bảo vệ form khi submit dữ liệu
            <button type="submit" class="button">
                <div class="light-text">Logout</div>
            </button>
        </form>
    </div>
</div>
@endsection