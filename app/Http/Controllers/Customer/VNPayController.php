<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\VNPayPayment;
use Illuminate\Support\Facades\Http;



class VNPayController extends Controller
{
    public function createPayment(Request $request)
    {
        DB::beginTransaction();

        try {
            // Lấy thông tin khách hàng
            $customer = Auth::guard('customer')->user();

            // Lấy dữ liệu từ request
            $name = $request->name;
            $phone = $request->phone;
            $paymentMethod = $request->payment_method;
            $message = $request->message;
            $productIds = $request->product_id;
            $quantities = $request->quantity;
            $prices = $request->price;
            $totalPrice = $request->total_price;
            $discountAmount = $request->discount_amount;
            $shippingFee = $request->shipping_fee;
            $subtotal = $request->subtotal;

            // Kết nối các trường province, district, ward
            $province = $request->province;
            $district = $request->district;
            $ward = $request->ward;
            $fullAddress = implode(', ', [$province, $district, $ward]);

            // Lưu dữ liệu vào session
            session([
                'order_data' => [
                    'customer_id' => $customer->id,
                    'name' => $name,
                    'address' => $fullAddress,
                    'phone' => $phone,
                    'shipping_method' => $request->shipping_method,
                    'message' => $message,
                    'subtotal' => $subtotal,
                    'discount' => $discountAmount,
                    'shipping' => $shippingFee,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                    'product_ids' => $productIds,
                    'quantities' => $quantities,
                    'prices' => $prices,
                    'payment_method' => $paymentMethod,
                ]
            ]);

            DB::commit();
            Log::info('Order data saved in session: ' . json_encode(session('order_data')));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau']);
        }

        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật được cung cấp bởi VNPAY
        $vnp_Url = env('VNP_URL'); // URL thanh toán của VNPAY
        $vnp_Returnurl = route('vnpay.payment.return'); // URL để VNPAY gửi kết quả thanh toán về để xử lý
        $vnp_TxnRef = date("YmdHis"); // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng bằng VNPAY tại website Green Nature Cosmetics"; // Thông tin đơn hàng
        $vnp_OrderType = 'Cosmetize'; // Kiểu đơn hàng
        $vnp_Amount = $request->total_price * 100; // Số tiền thanh toán (VND)
        $vnp_Locale = 'vn'; // Ngôn ngữ hiển thị
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP của khách hàng


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return response()->json(['success' => true, 'payment_url' => $vnp_Url]); // Trả về URL thanh toán của VNPAY
    }

    public function paymentReturn(Request $request)
    {

        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật
        $inputData = array();
        $returnData = array();

        $inputData = $request->only(array_filter(array_keys($request->all()), function ($key) {
            return substr($key, 0, 4) == 'vnp_';
        }));
        Log::info('inputData: ' . json_encode($inputData));
        // foreach ($_GET as $key => $value) {
        //     if (substr($key, 0, 4) == "vnp_") {
        //         $inputData[$key] = $value;
        //     }
        // }
        // Đây việc kiểm tra checksum của dữ liệu
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret); // Tạo chuỗi hash từ dữ liệu đã nhận và chuỗi bí mật

        // Tiến hành kiểm tra dữ liệu và xử lý
        try {
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) // Kiểm tra chuỗi hash nhận được từ VNPAY có trùng với chuỗi hash tạo ra từ dữ liệu nhận được không
            {
                if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                    // Lấy dữ liệu đơn hàng từ session
                    $orderData = session('order_data');
                    // Tiến hành tạo đơn hàng từ dữ liệu trong session vao database
                    $this->createOrder($orderData, $inputData);
                    session(['vnpay_response' => $inputData]);
                    return redirect()->route('order.success');
                } else {
                    session(['error_message' => 'Giao dịch đã bị hủy do thanh toán không thành công']);
                    return redirect()->route('order.failure');
                }

                $returnData['RspCode'] = '00';
                $returnData['Message'] = 'Confirm Success';
            } else {
                session(['error_message' => 'Mã bí mật không khớp']);
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Mã bí mật không khớp';
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Lỗi không xác định';
        }
        //Trả lại VNPAY theo định dạng JSON
        echo json_encode($returnData);
        log::info('returnData: ' . json_encode($returnData));
    }
    public function createOrder($orderData, $inputData)
    {
        if ($orderData && $inputData) {
            DB::beginTransaction();

            try {
                // Tính tổng số lượng tất cả sản phẩm được mua
                $totalQuantity = array_sum($orderData['quantities']);
                // Tạo đơn hàng mới
                $order = new Order();
                $order->customer_id = $orderData['customer_id'];
                $order->name = $orderData['name'];
                $order->address = $orderData['address'];
                $order->phone = $orderData['phone'];
                $order->shipping_method = $orderData['shipping_method'];
                $order->message = $orderData['message'];
                $order->subtotal = $orderData['subtotal'];
                $order->discount = $orderData['discount'];
                $order->shipping = $orderData['shipping'];
                $order->total_price = $orderData['total_price'];
                $order->order_quantity = $totalQuantity;
                $order->status = 'pending';
                $order->save();

                // Tạo các mục đơn hàng
                foreach ($orderData['product_ids'] as $index => $productId) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $productId;
                    $orderItem->quantity = $orderData['quantities'][$index];
                    $orderItem->price = $orderData['prices'][$index];
                    $orderItem->save();

                    // Cập nhật lại trường "stock" trong bảng products và "total_purchase_quantity"
                    $product = Product::find($productId);
                    if ($product) {
                        $product->stock -= $orderData['quantities'][$index];
                        $product->total_purchase_quantity += $orderData['quantities'][$index];
                        $product->save();
                    }
                }

                // Tạo thanh toán
                $payment = new Payment();
                $payment->order_id = $order->id;
                $payment->payment_method = $orderData['payment_method'];
                $payment->amount = $orderData['total_price'];
                $payment->status = 'paid';
                $payment->save();
                $paymentId = $payment->id;
                $vnpayId = VNPayPayment::create([
                    'payment_id' => $paymentId,
                    'vnp_bank_code' => $inputData['vnp_BankCode'],
                    'vnp_amount' => $inputData['vnp_Amount'],
                    'vnp_paydate' => $inputData['vnp_PayDate'],
                    'vnp_txn_ref' => $inputData['vnp_TxnRef'],
                    'vnp_transaction_no' => $inputData['vnp_TransactionNo'],
                    'vnp_create_by_id' => Auth::guard('customer')->id(),
                ]);


                $cart = Cart::where('customer_id', $orderData['customer_id'])->first();
                if ($cart) {
                    CartItem::where('cart_id', $cart->id)
                        ->whereIn('product_id', $orderData['product_ids'])
                        ->delete();
                }

                DB::commit();
                Log::info('Order created from session data: ' . json_encode($orderItem));
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
                return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau']);
            }
        }
    }
    public function paymentRefund($orderId)
    {
        try {
            // Bắt đầu transaction
            DB::beginTransaction();

            // Tìm bảng ghi trong bảng payments bằng orderId
            $payment = Payment::where('order_id', $orderId)->first();

            if (!$payment) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy thông tin thanh toán']);
            }

            // Lấy payment_id từ bảng payments
            $paymentId = $payment->id;

            // Tìm bảng ghi trong bảng vnpaypayments bằng payment_id
            $vnpayPayment = Vnpaypayment::where('payment_id', $paymentId)->first();

            if (!$vnpayPayment) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy thông tin VNPAY']);
            }
            // dump($vnpayPayment->vnp_txn_ref);
            // Trả về dữ liệu của bảng ghi vnpaypayments
            DB::commit();
            if ($vnpayPayment!==null) {

                $apiUrl = env('VNP_REFUND_URL'); // URL API hoàn tiền của VNPAY
                $vnp_RequestId = date("YmdHis"); // Mã truy vấn
                $vnp_Command = "refund"; // Mã api
                $vnp_TransactionType ="02"; // 02 hoàn trả toàn phần - 03 hoàn trả một phần
                $vnp_TxnRef = $vnpayPayment->vnp_txn_ref; // Mã tham chiếu của giao dịch
                $vnp_Amount = $vnpayPayment->vnp_amount; // Số tiền hoàn trả
                $vnp_OrderInfo = "Hoan Tien Giao Dich tai web"; // Mô tả thông tin
                $vnp_TransactionNo =$vnpayPayment->vnp_transaction_no ; // Tuỳ chọn, "0": giả sử merchant không ghi nhận được mã GD do VNPAY phản hồi.
                $vnp_TransactionDate = $vnpayPayment->vnp_paydate; // Thời gian ghi nhận giao dịch
                $vnp_CreateDate = date('YmdHis'); // Thời gian phát sinh request
                $vnp_CreateBy = "ANh A"; // Người khởi tạo hoàn tiền
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; // Địa chỉ IP của máy chủ thực hiện gọi API

                $ispTxnRequest = array(
                    "vnp_RequestId" => $vnp_RequestId,
                    "vnp_Version" => "2.1.0",
                    "vnp_Command" => $vnp_Command,
                    "vnp_TmnCode" => env('VNP_TMN_CODE'),
                    "vnp_TransactionType" => $vnp_TransactionType,
                    "vnp_TxnRef" => $vnp_TxnRef, // Mã tham chiếu của giao dịch cần hoàn tiền
                    "vnp_Amount" => $vnp_Amount, // Số tiền hoàn trả
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_TransactionNo" => $vnp_TransactionNo, // Mã giao dịch của VNPAY
                    "vnp_TransactionDate" => $vnp_TransactionDate, // Thời gian ghi nhận giao dịch
                    "vnp_CreateDate" => $vnp_CreateDate,
                    "vnp_CreateBy" => $vnp_CreateBy,
                    "vnp_IpAddr" => $vnp_IpAddr
                );
                // dump($ispTxnRequest);
                $format = '%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s|%s';

                $dataHash = sprintf(
                    $format,
                    $ispTxnRequest['vnp_RequestId'], //1
                    $ispTxnRequest['vnp_Version'], //2
                    $ispTxnRequest['vnp_Command'], //3
                    $ispTxnRequest['vnp_TmnCode'], //4
                    $ispTxnRequest['vnp_TransactionType'], //5
                    $ispTxnRequest['vnp_TxnRef'], //6
                    $ispTxnRequest['vnp_Amount'], //7
                    $ispTxnRequest['vnp_TransactionNo'],  //8
                    $ispTxnRequest['vnp_TransactionDate'], //9
                    $ispTxnRequest['vnp_CreateBy'], //10
                    $ispTxnRequest['vnp_CreateDate'], //11
                    $ispTxnRequest['vnp_IpAddr'], //12
                    $ispTxnRequest['vnp_OrderInfo'] //13
                );
            }
            // Tạo checksum bằng cách hash chuỗi dữ liệu với chuỗi bí mật
            $checksum = hash_hmac('SHA512', $dataHash, env('VNP_HASH_SECRET'));
            $ispTxnRequest["vnp_SecureHash"] = $checksum;

            // Gửi yêu cầu refund đến API của VNPAY
            $response = Http::post(env('VNP_REFUND_URL'), $ispTxnRequest);
            // dump($response->json());
            // Trả về kết quả
            if ($response->json()['vnp_ResponseCode'] == '00') {
                Order::where('id',$orderId)->update(['status'=>'cancelled']);
                $Orderitems = OrderItem::where('order_id',$orderId)->get();
                foreach($Orderitems as $Orderitem){
                    $product=Product::where('id',$Orderitem->product_id)->first();
                    $product->stock += $Orderitem->quantity;
                    $product->total_purchase_quantity -= $Orderitem->quantity;
                    $product->save();
                }
                Payment::where('id',$paymentId)->update(['status'=>'refund']);
                return response()->json(['success' => true, 'data' => $response->json()]);
            } else {
                return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau','data' => $response->json()]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau']);
        }
        // return response()->json(['success' => true, 'payment_url' => $vnp_Url]); // Trả về URL thanh toán của VNPAY
    }
}
