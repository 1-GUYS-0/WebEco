<nav class="nav-bar_wrapper">
    <div class="nav-bar_logo">
        <a href="{{route('customer.home')}}">
            <img src="{{asset('system/logo.png')}}" />
        </a>
    </div>
    <div class="nav-bar_menu">
        <div class="nav-bar_link close-btn">
            <a href="{{ route('search.page') }}">Danh mục và Tìm kiếm </a>
        </div>
        <div class="nav-bar_link close-btn">
            <a href="{{route('promotion.discount')}}">Chương trình và giảm giá</a>
        </div>
        <div class="nav-bar_link close-btn">
            <a>Về chúng tôi</a>
        </div>
        <div class="cart-icon" onclick=" toggleSide('cart-sidebar')">
            <span class="material-symbols-outlined close-btn ">local_mall</span>
        </div><!-- Icon giỏ hàng -->
        <div class="cart-icon" onclick="toggleSide('notification-sidebar')">
            <span class="material-symbols-outlined close-btn">notifications</span>
            <span id="notification-count" class="notification-count">0</span>
        </div>
        <div class="cart-icon" id="cart-profile" onclick="toggleProfilePopup()">
            <span class="material-symbols-outlined close-btn">face</span>
            <div id="profile-popup" class="profile-popup">
                <a class="profile-popup-item" href="{{route('customer.profile')}}">Trang cá nhân</a>
                <form method="POST" action="{{ route('customer.logout') }}">
                    @csrf <!--Đây là token để bảo vệ form khi submit dữ liệu-->
                    <button type="submit" class="button">
                        <div class="light-text">Đăng xuất</div>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div id="cart-sidebar" class="cart-sidebar">
        <div class="cart-header">
            <h3>Giỏ hàng của bạn</h3>
            <span class="material-symbols-outlined close-btn " onclick=" toggleSide('cart-sidebar')">cancel</span>
        </div>
        <div class="cart-content">
            <ol class="product-list" id="cart-items">
                <!-- Các sản phẩm trong giỏ hàng sẽ được thêm vào đây bằng JavaScript -->
            </ol>
            <p id="empty-cart-message" style="display: none;">Giỏ hàng trống. Hãy thêm sản phẩm để thanh toán</p>
            <button type="button" onclick="proceedToPayment()" class="button">
                <div class="light-text">Thánh toán ngay!</div>
            </button>
        </div>
    </div><!-- Sidebar giỏ hàng -->
    <div id="notification-sidebar" class="cart-sidebar">
        <div class="cart-header">
            <h3>Thông báo</h3>
            <span class="material-symbols-outlined close-btn " onclick="toggleSide('notification-sidebar')">cancel</span>
        </div>
        <div class="cart-content">
            <ol class="product-list" id="notification-items">
                
            </ol>
            <p id="empty-notification-message" style="display: none;">Không có thông báo mới</p>
        </div>
    </div><!-- Sidebar thông báo -->
</nav> <!-- nav-bar_wrapper -->
<div id="overlay" class="overlay" onclick="toggleCart()"></div>
<script>
    showCart = '{{ route("cart.show") }}';
</script>
<script>
    const baseUrl = "{{ asset('storage') }}/";
</script>
<script src="{{ asset('front-end/js/cart.js') }}" defer></script>
<!-- pop-up-profile-->
<script>
    function toggleProfilePopup() {
        var popup = document.getElementById('profile-popup');
        if (popup.style.display === 'none' || popup.style.display === '') {
            popup.style.display = 'block';
        } else {
            popup.style.display = 'none';
        }
    }

    // Đóng popup khi click ra ngoài
    document.addEventListener('click', function(event) {

        var popup = document.getElementById('profile-popup');
        var cartIcon = document.getElementById('cart-profile');
        if (!cartIcon.contains(event.target)) {
            popup.style.display = 'none';
        }
    });
</script>
<!-- Chatbot -->
<script>
    logo_brand = "{{ asset('system/logo.png') }}";
    // Configs
    let liveChatBaseUrl = document.location.protocol + '//' + 'livechat.fpt.ai/v36/src'
    let LiveChatSocketUrl = 'livechat.fpt.ai:443'
    let FptAppCode = 'dd0384d5e3ab6cdc6502b3ee667de151'
    let FptAppName = 'Hỗ trợ trực tuyến'
    // Define custom styles
    let CustomStyles = {
        // header
        headerBackground: 'linear-gradient(86.7deg, #19925CFF 0.85%, #21BE5DFF 98.94%)',
        headerTextColor: '#ffffffff',
        headerLogoEnable: false,
        headerLogoLink: 'https://chatbot-tools.fpt.ai/livechat-builder/img/Icon-fpt-ai.png',
        headerText: 'Hỗ trợ trực tuyến',
        // main
        primaryColor: '#1B8538FF',
        secondaryColor: '#ecececff',
        primaryTextColor: '#ffffffff',
        secondaryTextColor: '#000000DE',
        buttonColor: '#b4b4b4ff',
        buttonTextColor: '#ffffffff',
        bodyBackgroundEnable: '',
        bodyBackgroundLink: ',',
        avatarBot: logo_brand,
        sendMessagePlaceholder: 'Nhập tin nhắn',
        // float button
        floatButtonLogo: logo_brand,
        floatButtonTooltip: 'Chúng tôi có thể hỗ trợ gì cho bạn?',
        floatButtonTooltipEnable: true,
        // start screen
        customerLogo: logo_brand,
        customerWelcomeText: 'Vui lòng nhập tên của bạn',
        customerButtonText: 'Bắt đầu',
        prefixEnable: false,
        prefixType: 'radio',
        prefixOptions: ["Anh", "Chị"],
        prefixPlaceholder: 'Danh xưng',
        // custom css
        css: ''
    }
    // Get bot code from url if FptAppCode is empty
    if (!FptAppCode) {
        let appCodeFromHash = window.location.hash.substr(1)
        if (appCodeFromHash.length === 32) {
            FptAppCode = appCodeFromHash
        }
    }
    // Set Configs
    let FptLiveChatConfigs = {
        appName: FptAppName,
        appCode: FptAppCode,
        themes: '',
        styles: CustomStyles
    }
    // Append Script
    let FptLiveChatScript = document.createElement('script')
    FptLiveChatScript.id = 'fpt_ai_livechat_script'
    FptLiveChatScript.src = liveChatBaseUrl + '/static/fptai-livechat.js'
    document.body.appendChild(FptLiveChatScript)
    // Append Stylesheet
    let FptLiveChatStyles = document.createElement('link')
    FptLiveChatStyles.id = 'fpt_ai_livechat_script'
    FptLiveChatStyles.rel = 'stylesheet'
    FptLiveChatStyles.href = liveChatBaseUrl + '/static/fptai-livechat.css'
    document.body.appendChild(FptLiveChatStyles)
    // Init
    FptLiveChatScript.onload = function() {
        fpt_ai_render_chatbox(FptLiveChatConfigs, liveChatBaseUrl, LiveChatSocketUrl)
    }
</script>