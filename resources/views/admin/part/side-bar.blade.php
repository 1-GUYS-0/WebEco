<div class="menu_logo">
    <img src="{{ asset('backend/asset/dashboard/logo.png')}}" />
</div>
<div class="container_menu">
    <div class="admin-user">
        
    </div>
    <div class="div"></div>
    <div class="menu">
        <button class="module-menu">
            <a class="text_menu"  href="{{route('dashboards.showDashboardMng')}}" >analyst-dashboard</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('categories.showCategoryMng')}}" >category-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('products.showProductMng')}}">product-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('banner.showBannerMng')}}">banner-management</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('orders.showOrderMng')}}">order-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('promotions.showPromotionMng')}}">promotion-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('vouchers.showVoucherMng')}}">voucher-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('customers.showCustomerMng')}}">customer-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu" href="{{route('admins.showAdminMng')}}">admins-managerment</a>
        </button>
    </div>
</div>