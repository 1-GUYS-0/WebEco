@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Orders manager</p>
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
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày đặt đơn</th>
                    <th>Trạng thái đơn</th>
                    <th>Tổng số tiền</th>
                    <th>Phương thức thanh toán</th>
                    <th>Số lượng sản phẩm</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @if ($payments===null)
                <tr>
                    <td colspan="8">Không có dữ liệu</td>
                </tr>
                @else
                @foreach($payments as $payment)
                @if($payment->order)
                <tr>
                    <td>{{ $payment->order->id }}</td>
                    <td>{{ $payment->order->customer->name }}</td>
                    <td>{{ $payment->order->created_at->format('d/m/Y') }}</td>
                    <td>{{ $payment->order->status }}</td>
                    <td>{{ number_format($payment->order->total_price, 0, ',', '.') }} VND</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>{{ $payment->order->order_quantity }}</td>
                    <td><button class="edit-button" data-order="{{ json_encode($payment->order) }}" data-payment-method="{{ $payment->payment_method }}">Chỉnh sửa</button></td>
                </tr>
                @endif
                @endforeach
                @endif
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
    <!-- Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Chỉnh sửa đơn hàng</h2>
            <div id="editOrderForm" class="editOrderForm">
                <div>
                    <label for="orderStatus">Trạng thái đơn:</label>
                    <select id="orderStatus" name="status" aria-label="{{ $payment->order->status }}">
                        <option value="pending">Đợi đóng gói</option>
                        <option value="shipping">Đang giao</option>
                        <option value="completedr">Giao hàng hoàn tất</option>
                        <option value="cancelled">Đã hủy</option>
                    </select>
                </div>
                <button id="saveButton" data-order-id="" class="button light-text">Lưu</button>
                <button type="button" class="button light-text">Xóa đơn hàng</button>
            </div>
        </div>
    </div>
</div> <!--container_cater-manager -->
<script src="{{ asset('backend/js/orders/order.js') }}"></script>
@endsection