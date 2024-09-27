@extends('customer.layout-app.layout')
@section('content')
<div class="breadcrumbs ">
    <h6 class="home">Home</h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="catalog">Catalog</h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="smartphones">Smartphones</h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="apple">Apple</h6>
    <span class="material-symbols-outlined">arrow_forward_ios</span>
    <h6 class="i-phone-14-pro-max">iPhone 14 Pro Max</h6>
</div> <!--breadcrumbs-->
<div class="product-detail ">
    <div class="card-image">
        <img class="product-detail_image " src="{{asset('front-end/asset/src/cards-image0.png')}}" />
    </div>
    <div class="product-detail_infor ">
        <div class="detail_infor">
            <h2 class="product-detail_name">Product name</h2>
            <p class="dproduct-detail_brand">Subheading</p>
            <div class="product-detail_price">$10.99</div>
            <p class="product-detail_description">
                Body text for describing why this product is simply a must-buy
            </p>
        </div>
        <button type="button" onclick="alert('Xin chào!')" class="button">
            <div class="light-text">Thêm vào giỏ hàng</div>
        </button>
    </div>
</div> <!--product detail-->
<div class="rela-prod_wrapper">
    <h3 class="title-section">Related products</h3>
    <div class="rela-prod_list">
        <div class="rela-prod_item ">
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
        <div class="rela-prod_item ">
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
        <div class="rela-prod_item ">
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
        <div class="rela-prod_item ">
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
</div><!--related products-->
<div class="reviews ">
    <div class="top">
        <h4>Reviews</h4>
        <input type="text" id="myComment" placeholder="Enter your comment" class="input-set">
        <div class="flex-end">
            <button type="button" onclick="alert('Xin chào!')" class="button">
                <div class="light-text">Thêm bình luận</div>
            </button>
        </div>
    </div>
    <div class="review-list ">
        <div class="review">
            <div>
                <img class="user-pic" src="{{asset('front-end/asset/src/cards-image0.png')}}" />
            </div>
            <div class="content">
                <div class="review-meta">
                    <div class="user-info">
                        <h5 class="user-name">Darcy King</h5>
                        <h6 class="review-date">24 January,2023</h6>
                    </div>
                    <img class="stars" src="./src/star.png" />
                </div>
                <div class="review-text">
                    I might be the only one to say this but the camera is a little
                    funky. Hoping it will change with a software update:
                    otherwise, love this phone! Came in great condition
                </div>
                <div class="review_images">
                </div>
            </div>
        </div>
        <div class="review">
            <div>
                <img class="user-pic" src="{{asset('front-end/asset/src/cards-image0.png')}}" />
            </div>
            <div class="content">
                <div class="review-meta">
                    <div class="user-info">
                        <h5 class="user-name">Darcy King</h5>
                        <h6 class="review-date">24 January,2023</h6>
                    </div>
                    <img class="stars" src="./src/star.png" />
                </div>
                <div class="review-text">
                    I might be the only one to say this but the camera is a little
                    funky. Hoping it will change with a software update:
                    otherwise, love this phone! Came in great condition
                </div>
                <div class="review_images">
                    <div class=" size_review_images ">
                        <img class="size_review_images" src="{{asset('front-end/asset/src/cards-image0.png')}}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button_view-more">
        <button type="button" onclick="alert('Xin chào!')" class="button">
            <div class="light-text">View more</div>
        </button>
    </div>
</div><!--reviews-->

@endsection