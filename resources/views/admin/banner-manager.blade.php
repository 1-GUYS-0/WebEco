@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Promotion manager</p>
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
                    <th>Tên banner</th>
                    <th>hình ảnh</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Link liên kết</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $banner)
                <tr>
                    <td>{{ $banner->id }}</td>
                    <td>{{ $banner->title}}</td>
                    <td>
                        <div class="size_review_images">
                            <img src=" {{ !empty($banner->images_path) ? asset($banner->images_path) : 'N/A' }} " /> <!--kiểm tra xem có tồn tại images không và có hình ảnh không-->
                        </div>
                    </td>
                    <td>{{ $banner->start_date}}</td>
                    <td>{{ $banner->start_date }}</td>
                    <td>{{ $banner->link_to}}</td>
                    <td>
                        <button class="edit-button" data-promotion="{{ json_encode($banner) }}">
                            Chỉnh sửa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
</div> <!--container_cater-manager -->
@endsection