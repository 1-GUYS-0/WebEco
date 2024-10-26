@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Customer manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <button type="button" class="material-symbols-outlined" onclick="search('customerTable')">search</button>
            </div>
            <div class="input" for="inputSearch">
                <input type="text" id="inputSearch" class="input_lable" placeholder="Tìm kiếm">
            </div>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table id="customerTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->number_phone}}</td>
                    <td>{{ $customer->email}}</td>
                    <td>{{ $customer->status}}</td>
                    <td>
                        <button class="edit-button" onclick="showTab('detailCustomer', '{{ $customer->id }}')">
                            Chỉnh sửa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>

    <div id="detailCustomer" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Detail Customer</h2>
            </div>
            <div class="modal-body">
                <p>ID: <span id="customer-id"></span></p>
                <p>Tên Khách hàng: <input id="customer-name"></p>
                <p>Số điện thoại: <input id="customer-phone"></p>
                <p>Email: <input id="customer-email"></p>
                <p>Trạng thái: <input id="customer-status"></p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="updateCustomer()" style="width:100%;">Lưu chỉnh sửa</button>
                <button class="button light-text" onclick="deleteCustomer()" style="width:100%;">Xóa customer</button>
            </div>
        </div>
    </div>
</div> <!--container_cater-manager -->
@endsection
<script src="{{asset('backend/js/customer.js')}}"></script>