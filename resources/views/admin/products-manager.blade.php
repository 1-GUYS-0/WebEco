@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Products manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <span class="material-symbols-outlined">search</span>
            </div>
            <form class="input" for="searchCatergpry">
                <input type="text" id="searchCatergpry" class="input_lable" placeholder="Search for catergory">
            </form>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" href="{{ route('products.view_add-product') }}"> Add new catergory</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Tên danh mục sản phẩm</th>
                    <th>Giá ban đầu</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productsIBL as $product)
                <tr>
                    <td>{{ $product['id'] }}</td>
                    <td>{{ $product['name'] }}</td>
                    <td>
                        <div class="size_review_images">
                            <img src=" {{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->image_path) : 'N/A' }} " /> <!--kiểm tra xem có tồn tại images không và có hình ảnh không-->
                        </div>
                    </td>
                    <td>{{ $product->category ? $product->category->name: 'N/A' }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>12</td> <!--{{ $product['sale_price'] }}-->
                    <td>{{ $product['stock'] }}</td>
                    <td>
                        <a href="{{ route('products.view_edit-product', ['id' => $product['id']]) }}" class="dark-text">Edit</a>
                        <button class="dark-text delete-product" data-id="{{ $product['id'] }}">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
</div> <!--container_cater-manager -->
@endsection