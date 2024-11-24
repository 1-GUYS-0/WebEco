@extends('customer.layout-app.layout')
@section('content')
<div class="container-rv">
    <h3 style="padding:0.3rem 0;"> Đánh giá của sản phẩm {{ $product->name }} </h3>
    <a id="productId-rv" style="display:none;">{{$product->id}}</a>
    <div class="tabs-rv">
        <button class="tab-button-rv active-rv" onclick="openTab(event, 'reviews-rv')">Đánh giá</button>
        <button class="tab-button-rv" onclick="openTab(event, 'images-rv')">Hình ảnh</button>
    </div>

    <div id="reviews-rv" class="tab-content-rv active-rv">
        <div class="filter-bar-rv">
            <select id="timeSort-rv">
                <option value="desc">Sắp xếp mới nhất</option>
                <option value="asc">Sắp xếp cũ nhất</option>
            </select>
            <select id="starFilter-rv" >
                <option value="all">All Stars</option>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>
            <button class="filter-button-rv" onclick="applyFilters()">Apply Filters</button>
        </div>
        <div class="reviews-list-rv">
            @foreach($comments as $comment)
            <div class="review">
                <div>
                    <img class="user-pic" src="{{ asset($comment->customer->avatar_path) }}" alt="{{ $comment->customer->name }}" />
                </div>
                <div class="comment_content">
                    <div class="review-meta">
                        <div class="user-info">
                            <h5 class="user-name">{{ $comment->customer->name }}</h5>
                            <h6 class="review-date">{{ $comment->created_at->format('d F, Y') }}</h6>
                        </div>
                        <div class="stars">
                            @for ($i = 0; $i < $comment->rating; $i++)
                                <img src="{{ asset('system/star.png') }}" alt="star">
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
            <p>Đã hết đánh giá của sản phẩm này</p>
            <div class="button_view-more">
                <button type="button light-text" onclick="" class="button light-text">
                    Xem thêm
                </button>
            </div>
        </div>
    </div>

    <div id="images-rv" class="tab-content-rv">
        <div class="images-list-rv">
            @foreach($comments as $comment)
            @if($comment->images)
            @foreach(json_decode($comment->images) as $image)
            <div class="image-item-rv">
                <img src="{{ asset($image) }}" alt="Review Image">
                <span class="image-date-rv">{{ $comment->created_at->format('Y-m-d') }}</span>
            </div>
            @endforeach
            @endif
            @endforeach
        </div>
    </div>
</div>
<script src="{{asset('front-end/js/product-review.js')}}"></script>
@endsection