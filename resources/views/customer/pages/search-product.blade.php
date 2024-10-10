@extends('customer.layout-app.layout')
@section('content')
<div class="container-search">
    <div class="filter-column">
        <h4>Lọc sản phẩm</h4>
        <form id="filter-form">
            <div class="form-group">
                <label for="category">Giá</label>
                <select id="price_order" name="category">
                    <option value="0">Giảm dần</option>
                    <option value="1">Tăng dần</option>
                </select>
            </div>
            <div class="form-group">
                <label for="category">Danh mục</label>
                <select id="category" name="category">
                    <option value="">Tất cả</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="skin_type">Loại da</label>
                <select id="skin_type" name="skin_type">
                    <option value="">Tất cả</option>
                    @foreach ($skinTypes as $skinType)
                    <option value="{{ $skinType }}">{{ $skinType }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="rating">Số sao đánh giá từ</label>
                <select id="rating" name="rating">
                    <option value="" selected>Tất cả</option>
                    <option value="1">1 sao</option>
                    <option value="2">2 sao</option>
                    <option value="3">3 sao</option>
                    <option value="4">4 sao</option>
                    <option value="5">5 sao</option>
                </select>
            </div>
            <button type="button" class="button light-text" onclick="filterProducts()">Tìm kiếm</button>
        </form>
    </div>

    <div class="result-column">
        <div class="form-search-name">
            <input id="search_name" type="text" placeholder="Tìm kiếm theo tên sản phẩm" name="search_name">
            <button class="button light-text" onclick="filterProducts()">Tìm kiếm</button>
        </div>
        <div id="product-list" style="display: flex;flex-wrap: wrap; gap:1rem;">
            <!-- Hiển thị sản phẩm -->
            <a>Sản phẩm đã hết hoặc không còn tồn tại!</a>
        </div>
    </div>
</div>
<script src="{{asset('front-end/js/search.js')}}"></script>
@endsection