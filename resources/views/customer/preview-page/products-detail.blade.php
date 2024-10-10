@extends('customer.preview-page.layout-app.layout')
@section('content')
<div class="breadcrumbs ">
    <h6 class="home"><a href="{{route('preview.index')}}">Home</a></h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="catalog">Danh mục</h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="smartphones">{{$product->category->name}}</h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="i-phone-14-pro-max">{{ $product->name }}</h6>
</div> <!--breadcrumbs-->
<div class="product-detail padding-top">
    <div id="slide-product" class="product-image-slider">
        <div class="slides">
            @foreach ($product->images as $image)
            <div class="card-image_slide">
                <img class="product-detail_image" src="{{ asset($image->image_path) }}" />
            </div>
            @endforeach
        </div>
        <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
        <button class="next" onclick="changeSlide(1)">&#10095;</button>
    </div>
    <div class="product-detail_infor ">
        <div class="detail_infor">
            <h2 class="product-detail_name">{{ $product->name }}</h2>
            <p class="dproduct-detail_brand">{{ $product->brand }}</p>
            <div class="product-detail_rating">
                <h4>Đánh giá của sản phẩm: </h4>
                @for ($i = 0; $i < $product->total_rating; $i++)
                    <img src="{{asset('system/star.png')}}" alt="star">
                    @endfor
            </div>
            <div class="product-detail_price">
                <h4>Giá: </h4>
                {{ $product->price }}
            </div>
            <p class="product-detail_description">{{ $product->description }}</p>
        </div>
        <button type="button" onclick="addToCart('{{ $product->id }}')" class="button">
            <div class="light-text">Thêm vào giỏ hàng</div>
        </button>
    </div>
</div> <!--product detail-->
<div class="rela-prod_wrapper padding-top">
    <h3 class="title-section">Related products</h3>
    <div class="rela-prod_list padding-top">
        @foreach($relatedProducts as $relatedProduct)
        <div class="rela-prod_item ">
            <div class="card-image">
                <img class="product-detail_image" src="{{ asset($relatedProduct->images->first()->image_path) }}" alt="{{ $relatedProduct->name }}" />
            </div>
            <div class="cards_contain ">
                <h3>
                    <a class="cards_name-prod close-bt" href="{{ route('preview.product.show', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                </h3>
                <div class="cards_desc-prod">
                    {{ $relatedProduct->description }}
                </div>
                <div class="cards_price-prod">{{ $relatedProduct->price }}</div>
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
<div class="reviews padding-top">
    <!-- <div class="top">
        <h4>Reviews</h4>
        <input type="text" id="myComment" placeholder="Enter your comment" class="input-set">
        <div class="flex-end">
            <button type="button" onclick="alert('Xin chào!')" class="button">
                <div class="light-text">Thêm bình luận</div>
            </button>
        </div>
    </div> -->
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
        <button type="button" onclick="alert('Xin chào!')" class="button">
            <div class="light-text">View more</div>
        </button>
    </div>
</div><!--reviews-->
<!--script-->
<script id="ratings-data" type="application/json">
    {!! json_encode($ratings) !!}
</script>
<script id="average-rating-data" type="application/json">
    {!! json_encode($averageRating) !!}
</script>
<script id="total-ratings-data" type="application/json">
    {!! json_encode($totalRatings) !!}
</script>
<script src="{{ asset('front-end/js/product-detail.js') }}"></script>
<script src="{{ asset('front-end/js/ratingreviews.js') }}"></script>
@endsection