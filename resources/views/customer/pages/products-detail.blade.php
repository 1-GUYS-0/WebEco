@extends('customer.layout-app.layout')
@section('content')
<div class="breadcrumbs ">
    <h6 class="home"><a href="{{route('customer.home')}}">Home</a></h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="catalog">{{ $product->category->name }}</h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="i-phone-14-pro-max">{{ $product->name }}</h6>
</div> <!--breadcrumbs-->
<div class="product-detail">
    <div id="slide-product" class="product-image-slider">
        <div class="slides">
            @foreach ($product->images as $image)
            <div class="slide">
                <img class="product-detail_image" src="{{ asset($image->image_path) }}" />
            </div>
            @endforeach
        </div>
        <button class="prev" onclick="changeSlide(-1,'slide-product')">&#10094;</button>
        <button class="next" onclick="changeSlide(1,'slide-product')">&#10095;</button>
    </div>
    <div class="product-detail_infor ">
        <div class="detail_infor">
            <h2 class="product-detail_name">{{ $product->name }}</h2>
            <div class="product-detail_price" style="color:orange;">
                <h4>Đã bán: </h4>
                {{ $product->total_purchase_quantity }} sản phẩm
            </div>
            <div class="product-detail_rating">
                <h4>Đánh giá của sản phẩm: </h4>
                @for ($i = 0; $i < $product->total_rating; $i++)
                    <img src="{{asset('system/star.png')}}" alt="star">
                    @endfor
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
            <div>
                <h4>Loại da:</h4> {{ $product->skin}}
            </div>
            <div>
                <h4>Mùi hương:</h4> {{ $product->smell }}
            </div>
            <div>
                <h4>Thành phần chính:</h4> {{ $product->main_ingredient }}
            </div>
            <div class="product-detail_price">
                <h4>Kết cấu: </h4>
                {{ $product->texture }}
            </div>
            <p class="product-detail_description">{{ $product->description }}</p>
        </div>
        <button type="button" onclick="addToCart('{{ $product->id }}')" class="button">
            <div class="light-text">Thêm vào giỏ hàng</div>
        </button>
    </div>
</div> <!--product detail-->
<div class="product-details">
    <h3 class="title-section">Thông tin chi tiết</h3>
    <div class="product-detail_infor">
        <div class="product-detail_info-item">
            <h4>Thành phần:</h4>
            <p>{{ $product->ingredient}}</p>
        </div>
        <div class="product-detail_info-item">
            <h4>Cách sử dụng:</h4>
            <p>{{ $product->htu }}</p>
        </div>
        <div class="product-detail_info-item">
            <h4>Lưu ý:</h4>
            <p>{{ $product->note }}</p>
        </div>
    </div>
</div>
<div class="rela-prod_wrapper">
    <h3 class="title-section">Các sản phẩm tương tự</h3>
    <div class="rela-prod_list">
        @foreach($relatedProducts as $relatedProduct)
        <div class="trending-prods_cards ">
            <div class="card-image">
                <img class="product-detail_image" src="{{ asset($relatedProduct->images->first()->image_path) }}" alt="{{ $relatedProduct->name }}" />
            </div>
            <div class="cards_contain ">
                <h3>
                    <a class="cards_name-prod close-bt" href="{{ route('product.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                </h3>
                <div class="cards_item">
                    {{ $relatedProduct->brand }}
                </div>
                <div class="cards_item">
                    @if ($relatedProduct->promotion && now()->between($relatedProduct->promotion->promotion_start, $relatedProduct->promotion->promotion_end))
                    @php
                    $discountedPrice = $relatedProduct->price - ($relatedProduct->price * $relatedProduct->promotion->percent_promotion / 100);
                    @endphp
                    <h3>
                        Giá:
                        <span>{{ number_format($relatedProduct->price, 0, ',', '.') }} VND</span>
                        <span style="text-decoration: line-through;color: red;">{{ number_format($discountedPrice, 0, ',', '.') }} VND</span>
                    </h3>
                    @else
                    <h3>Giá: {{ number_format($relatedProduct->price, 0, ',', '.') }} VND</h3>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div><!--related products-->
<div class="rating-card">
    <div class="rating-summary">
        <h1>3.5/5</h1>
        <p>1000 reviews</p>
    </div>
    <div class="rating-details">
        <div class="rating-row">
            <div class="star-label">5 <img src="{{asset('system/star.png')}}" alt="star"></div>
            <div class="rating-bar">
                <div class="fill" style="width: 40%;"></div>
            </div>
            <div class="rating-count">400</div>
        </div>
        <div class="rating-row">
            <div class="star-label">4 <img src="{{asset('system/star.png')}}" alt="star"></div>
            <div class="rating-bar">
                <div class="fill" style="width: 30%;"></div>
            </div>
            <div class="rating-count">300</div>
        </div>
        <div class="rating-row">
            <div class="star-label">3 <img src="{{asset('system/star.png')}}" alt="star"></div>
            <div class="rating-bar">
                <div class="fill" style="width: 20%;"></div>
            </div>
            <div class="rating-count">200</div>
        </div>
        <div class="rating-row">
            <div class="star-label">2 <img src="{{asset('system/star.png')}}" alt="star"></div>
            <div class="rating-bar">
                <div class="fill" style="width: 5%;"></div>
            </div>
            <div class="rating-count">50</div>
        </div>
        <div class="rating-row">
            <div class="star-label">1 <img src="{{asset('system/star.png')}}" alt="star"></div>
            <div class="rating-bar">
                <div class="fill" style="width: 5%;"></div>
            </div>
            <div class="rating-count">50</div>
        </div>
    </div>
</div><!-- Biểu đồ đánh giá -->
<div class="reviews">
    <div class="review-list ">
        <h3 class="title-section">Reviews của sản phẩm {{ $product->name }} </h3>
        @if ($product->comments->isNotEmpty())
        @foreach($product->comments as $comment)
        <div class="review">
            <div>
                <img class="user-pic" src="{{ asset($comment->customer->avatar_path) }}" alt="{{ $comment->customer->name }}"" />
                    </div>
                    <div class=" comment_content">
                <div class="review-meta">
                    <div class="user-info">
                        <h5 class="user-name">{{ $comment->customer->name }}</h5>
                        <h6 class="review-date">{{ $comment->created_at->format('d F, Y') }}</h6>
                    </div>
                    <div class="stars">
                        @for ($i = 0; $i < $comment->rating; $i++)
                            <img src="{{asset('system/star.png')}}" alt="star">
                            @endfor
                    </div>
                </div>
                <div class="review-text">
                    {{ $comment->content }}
                </div>
                @if($comment->images)
                <div class="review_images">
                    @foreach(json_decode($comment->images) as $image)
                    <div class="size_review_images">
                        <img class="size_review_images" src="{{ asset($image) }}" alt="Comment Image">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endforeach
        @else
        <p>Sản phẩm này hiện chưa có bất kì đánh giá nào !</p>
        @endif
    </div>
    <div class="button_view-more">
        <button type="button light-text" onclick="window.location.href=`/home/product/{{$product->id}}/review`" class="button light-text">
            Xem thêm
        </button>
    </div>
</div><!--reviews-->
<div id="ratings-data"
    data-rating='{
        "ratings": {!! json_encode($ratings) !!},
        "averageRating": {!! json_encode($averageRating) !!},
        "totalRatings": {!! json_encode($totalRatings) !!}
    }' 
    style="display:none;">
</div>
<!--script-->
<script src="{{ asset('front-end/js/product-detail.js') }}"></script>
<script src="{{ asset('front-end/js/ratingreviews.js') }}"></script>
@endsection