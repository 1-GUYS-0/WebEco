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
@endsection