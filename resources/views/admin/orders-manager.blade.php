@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Orders manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <span class="material-symbols-outlined" ondragenter,onclick="search('categoryTable')">search</span>
            </div>
            <div class="input" for="searchCatergpry">
                <input type="text" id="searchCatergpry" class="input_lable" placeholder="Search for catergory">
            </div>
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
                    <th>Chỉnh sửa</th>
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
                    <td><button class="detail-button" onclick="showDetail('detailOrder','{{ $payment->order->id }}')">{{ $payment->order->id }}</button></td>
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
            <span class="close-btn">&times;Thoát</span>
            <h2>Chỉnh sửa đơn hàng</h2>
            <div id="editOrderForm" class="editOrderForm">
                <div>
                    <label for="orderStatus">Trạng thái đơn:</label>
                    <select id="orderStatus" name="status" aria-label="">
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
    <div id="detailOrder" class="tab">
        <div class="modal-content">
            <form id="detailOrderForm" class="form_add-product">
                <span class="close-btn">&times;Thoát</span>
                <h2>Chi tiết đơn hàng</h2>
                <input type="text" id="orderId" name="order_id" value="" hidden>
                <div>
                    <div> Tên khách hàng: <input type="text" id="customerName" name="customer_name" value="" readonly> </div>
                    <div> Ngày đặt đơn: <input type="text" id="orderDate" name="order_date" value="" readonly> </div>
                    <div> Trạng thái đơn: <input type="text" id="orderStatu" name="order_status" value="" readonly> </div>
                    <div> Tổng số tiền: <input type="text" id="totalPrice" name="total_price" value="" readonly> </div>
                    <div> Phương thức thanh toán: <input type="text" id="paymentMethod" name="payment_method" value="" readonly> </div>
                    <div> Số lượng sản phẩm: <input type="text" id="orderQuantity" name="order_quantity" value="" readonly> </div>
                </div>
                <div class="div" ></div>
                <div id="infor-another-payment" hidden>
                    <div> Mã ngân hàng thanh toán: <input type="text" id="vnp_bank_code" name="vnp_bank_code" value="" readonly> </div>
                    <div> Mã thanh toán: <input type="text" id="vnp_transaction_no" name="vnp_transaction_no" value="" readonly> </div>
                </div>
                <div>
                    <h2> Chi tiết sản phẩm đơn hàng </h2>
                    <div id="detailProductOrder">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/orders/order.js') }}"></script>
@endsection