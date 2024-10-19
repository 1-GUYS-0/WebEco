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
                <a class="light-text" href="{{ route('products.view_add-product') }}"> Add new Promotion</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sự kiện</th>
                    <th>Phần trăm giảm giá</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promotions as $promotion)
                <tr>
                    <td>{{ $promotion->id }}</td>
                    <td>{{ $promotion->name }}</td>
                    <td>{{ $promotion->percent_promotion}}</td>
                    <td>{{ $promotion->promotion_start }}</td>
                    <td>{{ $promotion->promotion_end }}</td>
                    <td>
                        <button class="edit-button" data-promotion="{{ json_encode($promotion) }}">
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