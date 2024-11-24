@extends('customer.layout-app.layout')

@section('content')

<div class="promotion-details">

    <!-- Line 1: Advertising banner image -->
    <div class="banner-image">
        <img src="{{ asset($banner->images_path) }}" alt="{{ $banner->title }}">
    </div>

    <!-- Line 2: Program name -->
    <h2 class="promotion-name">{{ $promotion->name }}-
        🔥 Chào hè rực rỡ với chương trình khuyến mãi Summer Sale! 🔥
    </h2>

    <!-- Line 3: Program description -->
    <p class="promotion-description">
        Đón mùa hè sôi động cùng ưu đãi giảm giá cực lớn – giảm ngay 20% cho tất cả các sản phẩm trong cửa hàng! Đây là cơ hội hoàn hảo để bạn thoả sức mua sắm những sản phẩm yêu thích với giá hời. Hãy nhanh tay, bởi chương trình chỉ diễn ra trong thời gian ngắn và số lượng sản phẩm có hạn. Đừng bỏ lỡ – Summer Sale giúp bạn vừa tiết kiệm vừa trải nghiệm mua sắm tuyệt vời nhất!
    </p>

    <!-- Product cards -->
    <div class="promotion-products">
        @foreach ($promotionProducts as $product)
        <div class="trending-prods_cards ">
            <div class="card-image">
                @if ($product->images->isNotEmpty())
                @php
                $firstImage = $product->images->first();
                @endphp
                <img src="{{ asset($firstImage->image_path) }}" alt="{{ $product->name }}">
                @else
                <img src="N/A" alt="{{ $product->name }}">
                @endif
            </div>
            <div class="cards_contain ">
                <div class="product-detail_rating">
                    @for ($i = 0; $i < $product->total_rating; $i++)
                        <img src="{{ asset('system/star.png') }}" alt="star">
                        @endfor
                </div>
                <h3>
                    <a class="cards_name-prod" href="{{ route('product.show', $product->id) }}" onclick="saveProductToLocalStorage('{{ $product->id }}')">
                        {{ $product->name }}
                    </a>
                </h3>
                <div class="cards_item">
                    {{ $product->brand }}
                </div>
                <div class="product-detail_price">
                    @if ($product->promotion && now()->between($product->promotion->promotion_start, $product->promotion->promotion_end))
                    @php
                    $discountedPrice = $product->price - ($product->price * $product->promotion->percent_promotion / 100);
                    @endphp
                    <h3>
                        Giá:
                        <span>{{ number_format($discountedPrice, 0, ',', '.') }}</span>
                        <span style="text-decoration: line-through;color: red;">{{ number_format($product->price, 0, ',', '.') }}</span>
                    </h3>
                    @else
                    <h3>Giá: {{ number_format($product->price, 0, ',', '.') }} VND</h3>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection