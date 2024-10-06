@extends('customer.layout-app.layout')
@section('content')
<div class="container">
    <h1>Đặt hàng thành công</h1>
    <p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xác nhận.</p>
    <ul>
        <li><strong>Giá trị đơn hàng:</strong>{{ number_format($vnpayResponse['vnp_Amount']/100, 0, ',', '.') }} VND</li>
        <li><strong>Ngân hàng thanh toán:</strong>{{$vnpayResponse['vnp_BankCode']}}</li>
        <li><strong>Mã giao dịch:</strong>{{$vnpayResponse['vnp_TransactionNo']}}</li>
        <li><strong>Ngày thanh toán:</strong> {{ formatVNPayDate($vnpayResponse['vnp_PayDate']) }}</li>
    </ul>
    <a href="{{ route('customer.home') }}" class="btn btn-primary">Quay lại trang chủ</a>
</div>
<?php
function formatVNPayDate($dateString)
{
    $year = substr($dateString, 0, 4);
    $month = substr($dateString, 4, 2);
    $day = substr($dateString, 6, 2);
    $hour = substr($dateString, 8, 2);
    $minute = substr($dateString, 10, 2);
    $second = substr($dateString, 12, 2);

    return "$day/$month/$year $hour:$minute:$second";
}
?>
@endsection
<!-- Sample response from VNPAY
vnp_Amount: 10000000
vnp_BankCode: NCB
vnp_BankTranNo: VNP14604437
vnp_CardType: ATM
vnp_OrderInfo: Thanh toán đơn hàng bằng VNPAY tại website Green Nature Cosmetics
vnp_PayDate: 20241006205517
vnp_ResponseCode: 00
vnp_TmnCode: LCHZJ7JC
vnp_TransactionNo: 14604437
vnp_TransactionStatus: 00
vnp_TxnRef: 20241006135426 -->