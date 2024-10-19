@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Voucher manager</p>
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
                    <th>mã code</th>
                    <th>Tên mã giảm giá</th>
                    <th>Phần trăm giảm giá</th>
                    <th>Số lượng</th>
                    <th>Giờ bắt đầu</th>
                    <th>Giờ kết thúc</th>
                    <th>Ngày hết hạn</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $voucher)
                <tr>
                    <td>{{ $voucher->id }}</td>
                    <td>{{ $voucher->code }}</td>
                    <td>{{ $voucher->name}}</td>
                    <td>{{ $voucher->discount_amount}}</td>
                    <td>{{ $voucher->quantity }}</td>
                    <td>{{ $voucher->start_time }}</td>
                    <td>{{ $voucher->end_time }}</td>
                    <td>{{ $voucher->expiry_date}}</td>
                    <td>
                        <button class="edit-button" data-promotion="{{ json_encode($voucher) }}">
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