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
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi

        // Tiến hành kiểm tra dữ liệu và xử lý
        try {
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) // Kiểm tra chuỗi hash nhận được từ VNPAY có trùng với chuỗi hash tạo ra từ dữ liệu nhận được không
            {
                if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                    // Lưu trữ dữ liệu vào session
                    $orderData = session('order_data');

                    if ($orderData) {
                        DB::beginTransaction();

                        try {
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

                                // Cập nhật lại trường "stock" trong bảng products
                                $product = Product::find($productId);
                                if ($product) {
                                    $product->stock -= $orderData['quantities'][$index];
                                    $product->save();
                                }
                            }

                            // Tạo thanh toán
                            $payment = new Payment();
                            $payment->order_id = $order->id;
                            $payment->payment_method = $orderData['payment_method'];
                            $payment->amount = $orderData['total_price'];
                            $payment->transaction_id = $inputData['vnp_TransactionNo']; // Mã giao dịch trả về từ VNPAY
                            $payment->save();

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
                    session(['vnpay_response' => $inputData]);
                    return redirect()->route('order.success');
                } else {
                    session(['vnpay_response' => $inputData]);
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
    }
}
