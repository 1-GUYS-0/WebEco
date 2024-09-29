@extends('customer.layout-app.layout')
@section('content')
<div class="slide-container">
    <div class="slides">
        <div class="slide">
            <img src="./src/cards-image1.png" alt="Slide 1">
        </div>
        <div class="slide">
            <img src="./src/cards-image3.png" alt="Slide 2">
        </div>
        <div class="slide">
            <img src="./src/cards-image1.png" alt="Slide 3">
        </div>
    </div>
    <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="next" onclick="changeSlide(1)">&#10095;</button>
</div>
<div class="cust-recomm_wrapper">
    <h3 class="title-section">Heading</h3>
    <div id="product-list" class="cust-recomm_contain">
        @foreach ($products as $product)
            <div class="trending-prods_cards ">
                <div class="card-image">
                    @if ($product->images->isNotEmpty())
                        @php
                            $firstImage = $product->images->first();
                        @endphp
                        <img src="{{ asset('storage/' . $firstImage->image_path) }}" alt="{{ $product->name }}">
                    @else
                        <img src="N/A" alt="{{ $product->name }}">
                    @endif
                </div>
                <div class="cards_contain ">
                    <a class="cards_name-prod">{{ $product->name }}</a>
                    <div class="cards_desc-prod">
                        {{ $product->description }}
                    </div>
                    <div class="cards_price-prod">{{ $product->price }}VND</div>
                </div>
            </div>
        @endforeach
    </div>
    @if ($products->hasMorePages()) <!--kiểm tra xem còn trang nào không-->
        <button id="load-more" data-page="2" class="button light-text">Load More</button>
    @endif
</div>
<div class="trending-prods_wrapper">
    <h3 class="title-section">Heading</h3>
    <div class="cust-recomm_contain">
        <div class="trending-prods_cards ">
            <div class="card-image">
                <img class="product-detail_image " src="{{asset('front-end/asset/src/cards-image0.png')}}" />
            </div>
            <div class="cards_contain ">
                <a class="cards_name-prod">Featured product</a>
                <div class="cards_desc-prod">
                    Description of featured product
                </div>
                <div class="cards_price-prod">$10.99</div>
            </div>
        </div>
        <div class="trending-prods_cards ">
            <div class="card-image">
                <img class="product-detail_image " src="{{asset('front-end/asset/src/cards-image0.png')}}" />
            </div>
            <div class="cards_contain ">
                <a class="cards_name-prod">Featured product</a>
                <div class="cards_desc-prod">
                    Description of featured product
                </div>
                <div class="cards_price-prod">$10.99</div>
            </div>
        </div>
        <div class="trending-prods_cards ">
            <div class="card-image">
                <img class="product-detail_image " src="{{asset('front-end/asset/src/cards-image0.png')}}" />
            </div>
            <div class="cards_contain ">
                <a class="cards_name-prod">Featured product</a>
                <div class="cards_desc-prod">
                    Description of featured product
                </div>
                <div class="cards_price-prod">$10.99</div>
            </div>
        </div>
        <div class="trending-prods_cards ">
            <div class="card-image">
                <img class="product-detail_image " src="{{asset('front-end/asset/src/cards-image0.png')}}" />
            </div>
            <div class="cards_contain ">
                <a class="cards_name-prod">Featured product</a>
                <div class="cards_desc-prod">
                    Description of featured product
                </div>
                <div class="cards_price-prod">$10.99</div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const loadmore_product = '{{ route("customer.products.loadMore") }}';
</script>
<script src="{{ asset('front-end/js/product.js') }}"></script>
@endsection