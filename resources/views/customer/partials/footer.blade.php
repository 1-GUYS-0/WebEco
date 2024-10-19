<footer class="footer_wrapper">
    <div class="padding-global discolumn">
        <div class="container-large discolumn">
            <div class="footer_content">
                <div class="footer_brand" style="display:flex; flex-direction:column; gap:1rem;">
                    <div class="nav-bar_logo">
                        <a href="{{route('customer.home')}}">
                            <img src="{{asset('system/logo.png')}}" />
                        </a>
                    </div>
                    <p>Green Nature Cosmetics</p>
                    <div class="footer_social">
                        <ul class="social-list">
                            <li><a href="#"><img src="{{asset('system/facebook.png')}}"
                                        alt="facebook"></a></li>
                            <li><a href="#"><img src="{{asset('system/instagram.png')}}"
                                        alt="instagram"></a></li>
                            <li><a href="#"><img src="{{asset('system/tiktok.png')}}"
                                        alt="tiktok"></a></li>
                            <li><a href="#"><img src="{{asset('system/linkedin.png')}}"
                                        alt="linkedin"></a></li>
                        </ul>
                    </div>
                </div>
                <nav class="footer_nav">
                    <ul class="nav-list">
                        <li><a href="{{ route('search.page') }}">Danh mục và Tìm kiếm </a></li>
                        <li><a href="{{route('promotion.discount')}}">Chương trình và giảm giá</a></li>
                        <li><a>Về chúng tôi</a></li>
                        <li><a>Hướng dẫn cách sử dụng</a></li>
                    </ul>
                    <ul class="nav-list">
                        <p>© <span id="currentYear"></span> Green Nature Cosmetics. All rights reserved.</p>
                    </ul>
                </nav>

            </div>
        </div>
    </div>
</footer>
<script>
    // Lấy năm hiện tại
    document.getElementById('currentYear').textContent = new Date().getFullYear();
</script>