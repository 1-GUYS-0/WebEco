<nav class="nav-bar_wrapper">
    <div class="nav-bar_logo">
        <a href="{{route('customer.pages.log-in')}}">
            <img src="{{asset('system/logo.png')}}" />
        </a>
    </div>
    <div class="nav-bar_menu">
        <button type="button" class="button">
            <a class="light-text" href=" {{route('customer.pages.log-in')}} ">Đăng Nhập</a>
        </button>
        <button type="button" class="button">
            <a class="light-text" href="{{route('customer.pages.sign-up')}}">Đăng ký</a>
        </button>
        <div class="cart-icon">
            <a href="{{route('customer.pages.log-in')}}"><span class="material-symbols-outlined close-btn" >face</span></a>
        </div>
    </div>
</nav> <!-- nav-bar_wrapper -->
<div id="overlay" class="overlay" onclick="toggleCart()"></div>
