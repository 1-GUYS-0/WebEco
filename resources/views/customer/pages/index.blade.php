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
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="next" onclick="changeSlide(1)">&#10095;</button>
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
                <a class="cards_name-prod" href="{{ route('product.show', $product->id) }}" onclick="saveProductToLocalStorage('{{ $product->id }}')">{{ $product->name }}</a>
                <div class="cards_desc-prod">
                    {{ $product->description }}
                </div>
                <div class="cards_price-prod">{{ $product->price }}VND</div>
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
    const loadmore_product = '{{ route("customer.products.loadMore") }}';
</script>
<script src="{{ asset('front-end/js/product.js') }}"></script>
@endsection