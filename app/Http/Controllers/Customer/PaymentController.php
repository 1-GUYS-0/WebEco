<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\CartItem;


class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $products = $request->input('products');
        $detailedProducts = [];

        foreach ($products as $product) {
            $productInfo = Product::find($product['id']);

            if ($productInfo) {
                $detailedProducts[] = [
                    'id' => $productInfo->id,
                    'name' => $productInfo->name,
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'image_path' =>  $product['image'],
                ];
            }
        }

        // Lưu trữ dữ liệu sản phẩm chi tiết trong phiên làm việc
        session(['products' => $detailedProducts]);

        return response()->json(['success' => true]);
        // return response()->json([$detailedProducts]);
    }
    public function showPaymentPage()
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            return redirect()->route('customer.pages.log-in');
        }

        // Lấy dữ liệu sản phẩm từ phiên làm việc
        $products = session('products', []);

        // Lấy thông tin khách hàng
        $customerInfo = Customer::with('addresses')->find($customer->id);

        return view('customer.pages.payment', compact('products', 'customerInfo'));
    }

    public function orderSuccess()
    {
        // Lấy dữ liệu từ session
        $vnpayResponse = session('vnpay_response', []);
        return view('customer.pages.order-success',compact('vnpayResponse'));
    }

    public function orderFailure()
    {
        $errorMessage = session('error_message', []);
        return view('customer.pages.order-failure',compact('errorMessage'));
    }

    public function submitOrder(Request $request)
    {
        // In dữ liệu trong request
        Log::info('Request Data:', $request->all());

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

            // Tạo đơn hàng mới
            $order = new Order();
            $order->customer_id = $customer->id;
            $order->name = $name;
            $order->address = $fullAddress; // Lưu địa chỉ đầy đủ vào trường address
            $order->phone = $phone;
            $order->shipping_method = $request->shipping_method;
            $order->message = $message;
            $order->subtotal = $subtotal;
            $order->discount = $discountAmount;
            $order->shipping = $shippingFee;
            $order->total_price = $totalPrice;
            $order->status = 'pending';
            $order->save();

            // Tạo các mục đơn hàng
            foreach ($productIds as $index => $productId) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $productId;
                $orderItem->quantity = $quantities[$index];
                $orderItem->price = $prices[$index];
                $orderItem->save();
            }

            // Tạo thanh toán
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->payment_method = $paymentMethod;
            $payment->amount = $totalPrice;
            $payment->transaction_id = null; // Giả sử không có mã giao dịch
            $payment->save();

            // Xóa các sản phẩm đã đặt mua khỏi giỏ hàng trong cơ sở dữ liệu
            $cart = Cart::where('customer_id', $customer->id)->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)
                    ->whereIn('product_id', $productIds)
                    ->delete();
            }

            DB::commit();

            return response()->json(['success' => true, 'redirect_url' => route('order.success')]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in submitOrder: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'redirect_url' => route('order.failure')]);
        }
    }
}
