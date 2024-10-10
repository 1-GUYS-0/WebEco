<nav class="nav-bar_wrapper">
    <div class="nav-bar_logo">
        <a href="{{route('preview.index')}}">
            <img src="{{asset('system/logo.png')}}" />
        </a>
    </div>
    <div class="nav-bar_menu">
        <div class="nav-bar_link close-btn">
            <a>Danh mục</a>
        </div>
        <div class="nav-bar_link close-btn">
            <a>Chương trình</a>
        </div>
        <div class="nav-bar_link close-btn">
            <a>Về chúng tôi</a>
        </div>
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
    <div id="cart-sidebar" class="cart-sidebar">
        <div class="cart-header">
            <h3>Giỏ hàng của bạn</h3>
            <span class="material-symbols-outlined close-btn " onclick="toggleCart()">cancel</span>
        </div>
        <div class="cart-content">
            <ol class="product-list" id="cart-items">
                <!-- Các sản phẩm trong giỏ hàng sẽ được thêm vào đây bằng JavaScript -->
            </ol>
            <p id="empty-cart-message" style="display: none;">Giỏ hàng trống. Hãy thêm sản phẩm để thanh toán</p>
            <button type="button" onclick="alert('Xin chào!')" class="button">
                <div class="light-text">Thánh toán ngay!</div>
            </button>
        </div>
    </div><!-- Sidebar giỏ hàng -->
    <span id="menu_icon" class="material-symbols-outlined close-btn ">menu</span>
    <span id="hide-menu_icon" class="material-symbols-outlined close-btn hide ">cancel</span> <!-- Icon đóng giỏ hàng -->
</nav> <!-- nav-bar_wrapper -->
<div id="overlay" class="overlay" onclick="toggleCart()"></div>
<script>
    showCart = '{{ route("cart.show") }}';
</script>
<script>
    const baseUrl = "{{ asset('storage') }}/";
</script>
<script src="{{ asset('front-end/js/cart.js') }}" defer></script>