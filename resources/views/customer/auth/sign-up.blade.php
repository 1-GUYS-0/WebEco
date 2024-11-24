@extends('customer.preview-page.layout-app.layout')
@section('content')
<div class="background-log">
    <img src="{{ asset('system/background_log.jpg') }}" alt="banner" class="banner">
</div>
<div class="log_container">
    <div class="log_wrapper">
        <div class="log_form">
            <form id="signupForm">
                <div class="form_input">
                    <label for="name" class="input-lable">Name</label>
                    <input type="text" id="name" name="name" placeholder="Nhập tên của bạn" size="5" required autocomplete="new-password">
                    @error('name')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>

                <div class="form_input">
                    <label for="email" class="input-lable">Email</label>
                    <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email đăng ký" size="5" required>
                    @error('email')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>

                <div class="form_input">
                    <label for="phone" class="input-lable">Phone</label>
                    <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" size="5" required pattern="\d{10}" maxlength="10" title="Số điện thoại phải có 10 chữ số">
                    @error('phone')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>

                <div class="form_input">
                    <label for="password" class="input-lable">Password</label>
                    <input type="password" id="password" name="password" placeholder="Nhập mật khẩu ít nhất 8 kí tự" size="5" autocomplete="new-password">
                    @error('password')
                    <label class="input-error">{{ $message }}</label>
                    @enderror
                </div>
                <div class="form_input">
                    <label for="password_confirmation" class="input-lable">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Nhập lại mật khẩu" size="5" required autocomplete="new-password">
                    @error('password_confirmation')
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
<div id="loading-overlay" style="
    display: none;
    position: fixed;
    top: -206px;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    justify-content: center;
    align-items: center;
">
    <div style="

    display:none;
    width: 12rem;
    height: 2rem;
    background-color: white;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 16px;
    font-weight: bold;
    color: black;
    border: 0.2rem solid;
    border-radius: 1rem;
    
    ">
        Loading...
    </div>
</div>
<script>
    // JavaScript để hiển thị và ẩn thông báo
    function showLoadingOverlay() {
        document.getElementById('loading-overlay').style.display = 'flex';
    }

    function hideLoadingOverlay() {
        document.getElementById('loading-overlay').style.display = 'none';
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const signupForm = document.getElementById('signupForm');
        signupForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Ngăn form tự động khởi động lại

            // Lấy các giá trị từ form thông qua ID
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const password = document.getElementById('password').value;
            const password_confirmation = document.getElementById('password_confirmation').value;

            // Tạo đối tượng dữ liệu để gửi
            const data = {
                name: name,
                email: email,
                number_phone: phone,
                password: password,
                password_confirmation: password_confirmation
            };
            showLoadingOverlay(); // Hiển thị loading
            // Gửi dữ liệu bằng AJAX
            fetch("{{ route('customer.signup') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        hideLoadingOverlay() // Ẩn loading
                        alert(data.message);
                        window.location.href = "{{ route('customer.pages.log-in') }}";
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                    hideLoadingOverlay() // Ẩn loading
                });
        });
    });
</script>
@endsection