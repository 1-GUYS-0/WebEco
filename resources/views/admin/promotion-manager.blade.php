@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Promotion manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <button type="button" class="material-symbols-outlined" onclick="search('promotionTable')">search</button>
            </div>
            <div class="input" for="inputSearch">
                <input type="text" id="inputSearch" class="input_lable" placeholder="Tìm kiếm">
            </div>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" onclick="showTab('addPromotion')"> Add new Promotion</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table id="promotionTable">
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
                        <button class="edit-button" onclick="showTab('detailPromotion','{{ $promotion->id }}')">
                            Chỉnh sửa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
    <div id="addPromotion" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Add new Promotion</h2>
            </div>
            <div class="modal-body">
                <p>Tên sự kiện: <input id="promotion-name-add"></p>
                <p>Phần trăm giảm giá: <input id="promotion-percent-add"></p>
                <p>Ngày bắt đầu: <input id="promotion-start-add" type="datetime-local"></p>
                <p>Ngày kết thúc: <input id="promotion-end-add" type="datetime-local"></p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="addPromotion()" style="width:100%;">Thêm promotion</button>
            </div>
        </div>
    </div>
    
    <div id="detailPromotion" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Detail Promotion</h2>
            </div>
            <div class="modal-body">
                <p>ID: <span id="promotion-id"></span></p>
                <p>Tên sự kiện: <input id="promotion-name"></p>
                <p>Phần trăm giảm giá: <input id="promotion-percent"></p>
                <p>Ngày bắt đầu: <input id="promotion-start" type="datetime-local"></p>
                <p>Ngày kết thúc: <input id="promotion-end" type="datetime-local"></p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick=" updatePromotion()" style="width:100%;">Lưu chỉnh sửa</button>
                <button class="button light-text" onclick="deletePromotion()" style="width:100%;">Xóa promotion</button>
            </div>
        </div>
    </div>

</div> <!--container_cater-manager -->
@endsection
<script src="{{asset('backend/js/promotion.js')}}"></script>