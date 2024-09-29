<nav class="nav-bar_wrapper">
    <div class="nav-bar_logo">
        <img src="{{asset('front-end/asset/src/image-10.png')}}" />
    </div>
    <div class="nav-bar_menu">
        <div class="nav-bar_link">
            <a>page</a>
        </div>
        <div class="nav-bar_link">
            <a>page</a>
        </div>
        <div class="nav-bar_link">
            <a>page</a>
        </div>
        <button type="button" onclick="alert('Xin chào!')" class="button">
            <div class="light-text">Login</div>
        </button>
        <button type="button" onclick="alert('Xin chào!')" class="button">
            <div class="light-text">Sign up</div>
        </button>
        <div class="cart-icon" onclick="toggleCart()">
            <span class="material-symbols-outlined close-btn ">local_mall</span>
        </div><!-- Icon giỏ hàng -->
    </div>
    <div id="cart-sidebar" class="cart-sidebar">
            <div class="cart-header">
                <h3>Giỏ hàng của bạn</h3>
                <span class="material-symbols-outlined close-btn " onclick="toggleCart()">cancel</span>
            </div>
            <div class="cart-content">
                <ol class="product-list">
                    <li class="product-items">
                        <img src="{{asset('front-end/asset/src/cards-image0.png')}}" alt="Product Image"
                            class="product-image_selected" />
                        <!--inmage of product selected-->
                        <div class="product-details">
                            <a class="cards_name-prod">Product</a>
                            <div class="quantity-controls">
                                <button type="button">
                                    <span class="material-symbols-outlined">remove</span>
                                </button>
                                <div class="number-order">1</div>
                                <button type="button">
                                    <span class="material-symbols-outlined">add</span>
                                </button>
                            </div>
                            <div>
                                <span class="price">$10.99</span>
                            </div>
                        </div>
                        <button type="button">
                            <span class="material-symbols-outlined">cancel</span>
                        </button>
                    </li> <!--product selected-->
                </ol>
                <button type="button" onclick="alert('Xin chào!')" class="button">
                    <div class="light-text">Thánh toán ngay!</div>
                </button>
            </div>
        </div><!-- Sidebar giỏ hàng -->
    <span id="menu_icon" class="material-symbols-outlined close-btn ">menu</span>
    <span id = "hide-menu_icon" class="material-symbols-outlined close-btn hide ">cancel</span> <!-- Icon đóng giỏ hàng -->
</nav> <!-- nav-bar_wrapper -->
<div id="overlay" class="overlay" onclick="toggleCart()"></div>