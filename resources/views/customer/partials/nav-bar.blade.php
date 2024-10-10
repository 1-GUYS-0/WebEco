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
            <a>Chương trình và giảm giá</a>
        </div>
        <div class="nav-bar_link close-btn">
            <a>Về chúng tôi</a>
        </div>
        <div class="cart-icon" onclick="toggleCart()">
            <span class="material-symbols-outlined close-btn ">local_mall</span>
        </div><!-- Icon giỏ hàng -->
        <div class="cart-icon" onclick="myProfile()">
            <span class="material-symbols-outlined close-btn ">face</span>
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
            <button type="button" onclick="proceedToPayment()" class="button">
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


<script>
    logo_brand= "{{ asset('system/logo.png') }}";
    // Configs
    let liveChatBaseUrl   = document.location.protocol + '//' + 'livechat.fpt.ai/v36/src'
    let LiveChatSocketUrl = 'livechat.fpt.ai:443'
    let FptAppCode        = 'dd0384d5e3ab6cdc6502b3ee667de151'
    let FptAppName        = 'Hỗ trợ trực tuyến'
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
        prefixOptions: ["Anh","Chị"],
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
        themes : '',
        styles : CustomStyles
    }
    // Append Script
    let FptLiveChatScript  = document.createElement('script')
    FptLiveChatScript.id   = 'fpt_ai_livechat_script'
    FptLiveChatScript.src  = liveChatBaseUrl + '/static/fptai-livechat.js'
    document.body.appendChild(FptLiveChatScript)
    // Append Stylesheet
    let FptLiveChatStyles  = document.createElement('link')
    FptLiveChatStyles.id   = 'fpt_ai_livechat_script'
    FptLiveChatStyles.rel  = 'stylesheet'
    FptLiveChatStyles.href = liveChatBaseUrl + '/static/fptai-livechat.css'
    document.body.appendChild(FptLiveChatStyles)
    // Init
    FptLiveChatScript.onload = function () {
        fpt_ai_render_chatbox(FptLiveChatConfigs, liveChatBaseUrl, LiveChatSocketUrl)
    }
</script>

