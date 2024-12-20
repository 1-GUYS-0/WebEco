@extends('customer.layout-app.layout')
@section('content')
<div id="slide-banner" class="slide-container">
    <div class="slides">
        @foreach ($Banners as $banner)
        <div class="slide">
            <a href="{{ $banner->link_to }}">
                <img src="{{ asset($banner->images_path) }}" alt="{{ $banner->title }}">
            </a>
        </div>
        @endforeach
    </div>
    <button class="prev" onclick="changeSlide(-1,'slide-banner')">&#10094;</button>
    <button class="next" onclick="changeSlide(1,'slide-banner')">&#10095;</button>
</div>
<div class="cust-recomm_wrapper">
    <h3 class="title-section">Các sản phẩm có đánh giá cao</h3>
    <div id="product-list" class="cust-recomm_contain">
        @foreach ($Products as $product)
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
                        <img src="{{asset('system/star.png')}}" alt="star">
                        @endfor
                </div>
                <h3>
                    <a class="cards_name-prod" href="{{ route('product.show', $product->id) }}" onclick="saveProductToLocalStorage('{{ $product->id }}')">{{ $product->name }}</a>
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
                    <h3>Giá: {{ number_format($product->price, 0, ',', '.') }}</h3>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if ($Products->hasMorePages()) <!--kiểm tra xem còn trang nào không-->
    <button id="load-more" data-page="2" class="button light-text">Thêm Sản Phẩm</button>
    @endif
</div>
<div class="interested-product_wrapper">
    <h3 class="title-section">Các sản phẩm bạn quan tâm</h3>
    <div class="interested-product_list">
    </div>
</div>
<script>
    const loadmore_product = '{{ route("customer.product.loadMore") }}';
</script>
<script src="{{ asset('front-end/js/product.js') }}"></script>
<script src="{{ asset('front-end/js/home.js') }}"></script>
@endsection