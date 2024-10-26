<div class="menu_logo">
    <img src="{{ asset('backend/asset/dashboard/logo.png')}}" />
</div>
<div class="container_menu">
    <div class="admin-user">
        Hi, {{ Auth::guard('admin')->user()->name }}
    </div>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <button class="button light-text" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Log-out
    </button>
    <div class="div"></div>
    <div class="menu">
        <button class="module-menu " >
            <a class="text_menu {{ request()->is('admin/dashboard*') ? 'active' : '' }}" href="{{route('dashboards.showDashboardMng')}}">analyst-dashboard</a>
        </button>
        <button class="module-menu">
            <a class="text_menu {{ request()->is('admin/categorie*') ? 'active' : '' }}" href="{{route('categories.showCategoryMng')}}">category-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu {{ request()->is('admin/product*') ? 'active' : '' }}" href="{{route('products.showProductMng')}}">product-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu {{ request()->is('admin/banner*') ? 'active' : '' }}" href="{{route('banners.showBannerMng')}}">banner-management</a>
        </button>
        <button class="module-menu">
            <a class="text_menu {{ request()->is('admin/order*') ? 'active' : '' }}" href="{{route('orders.showOrderMng')}}">order-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu {{ request()->is('admin/promotion*') ? 'active' : '' }}" href="{{route('promotions.showPromotionMng')}}">promotion-MNgerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu {{ request()->is('admin/voucher*') ? 'active' : '' }}" href="{{route('vouchers.showVoucherMng')}}">voucher-managerment</a>
        </button>
        <button class="module-menu">
            <a class="text_menu {{ request()->is('admin/customer*') ? 'active' : '' }}" href="{{route('customers.showCustomerMng')}}">customer-managerment</a>
        </button>
        @php
        $user = Auth::guard('admin')->user()->role;
        @endphp
        @if ($user && $user === 'admin')
        <button class="module-menu">
            <a class="text_menu" href="{{ route('admins.showAdminMng') }}">admins-managerment</a>
        </button>
        @endif
    </div>
</div>