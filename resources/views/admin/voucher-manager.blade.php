@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Voucher manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <button type="button" class="material-symbols-outlined" onclick="search('voucherTable')">search</button>
            </div>
            <div class="input" for="inputSearch">
                <input type="text" id="inputSearch" class="input_lable" placeholder="Tìm kiếm">
            </div>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" onclick="showTab('addVoucher')"> Add new voucher</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table id="voucherTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Mã code</th>
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
                    <td>{{ $voucher->name }}</td>
                    <td>{{ $voucher->discount_amount }}</td>
                    <td>{{ $voucher->quantity }}</td>
                    <td>{{ $voucher->start_time }}</td>
                    <td>{{ $voucher->end_time }}</td>
                    <td>{{ $voucher->expiry_date }}</td>
                    <td>
                        <button class="edit-button" onclick="showTab('detailVoucher', '{{ $voucher->id }}')">
                            Chỉnh sửa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
    <div id="addVoucher" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Add new Voucher</h2>
            </div>
            <div class="modal-body">
                <p>Mã code: <input id="voucher-code-add"></p>
                <p>Tên mã giảm giá: <input id="voucher-name-add"></p>
                <p>Phần trăm giảm giá: <input id="voucher-percent-add"></p>
                <p>Số lượng: <input id="voucher-quantity-add"></p>
                <p>Giờ bắt đầu: <input id="voucher-start-add" type="time"></p>
                <p>Giờ kết thúc: <input id="voucher-end-add" type="time"></p>
                <p>Ngày hết hạn: <input id="voucher-expiry-add"type="datetime-local"></p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="addVoucher()" style="width:100%;">Thêm voucher</button>
            </div>
        </div>
    </div>
    
    <div id="detailVoucher" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Detail Voucher</h2>
            </div>
            <div class="modal-body">
                <p>ID: <span id="voucher-id"></span></p>
                <p>Mã code: <input id="voucher-code"></p>
                <p>Tên mã giảm giá: <input id="voucher-name"></p>
                <p>Phần trăm giảm giá: <input id="voucher-percent"></p>
                <p>Số lượng: <input id="voucher-quantity"></p>
                <p>Giờ bắt đầu: <input id="voucher-start" type="time"></p>
                <p>Giờ kết thúc: <input id="voucher-end" type="time"></p>
                <p>Ngày hết hạn: <input id="voucher-expiry" type="datetime-local"></p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="updateVoucher()" style="width:100%;">Lưu chỉnh sửa</button>
                <button class="button light-text" onclick="deleteVoucher()" style="width:100%;">Xóa voucher</button>
            </div>
        </div>
    </div>
</div> <!--container_cater-manager -->
@endsection
<script src="{{asset('backend/js/voucher.js')}}"></script>