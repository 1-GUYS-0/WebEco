@extends('customer.preview-page.layout-app.layout')
@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{ $email ?? old('email') }}" required>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <label for="password-confirm">Confirm Password:</label>
    <input type="password" id="password-confirm" name="password_confirmation" required>
    <button type="submit" class="button">
        <a class="light-text">Reset Password</a>
    </button>
</form>
@endsection