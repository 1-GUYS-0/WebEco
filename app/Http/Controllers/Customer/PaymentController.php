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
use App\Models\Notification;
use App\Models\Voucher;


class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $products = $request->input('products');
        $detailedProducts = [];

        foreach ($products as $product) {
            $productInfo = Product::with('promotion')->find($product['id']);

            if ($productInfo) {
                // Kiểm tra xem sản phẩm có chương trình khuyến mãi và ngày hiện tại nằm trong khoảng thời gian khuyến mãi
                if ($productInfo->promotion && $productInfo->promotion->promotion_start && $productInfo->promotion->promotion_end && now()->between($productInfo->promotion->promotion_start, $productInfo->promotion->promotion_end)) {
                    $discountedPrice = $productInfo->price - ($productInfo->price * $productInfo->promotion->percent_promotion / 100);
                } else {
                    $discountedPrice = $productInfo->price;
                }

                $detailedProducts[] = [
                    'id' => $productInfo->id,
                    'name' => $productInfo->name,
                    'quantity' => $product['quantity'],
                    'price' => $discountedPrice,
                    'image_path' => $product['image'],
                ];
            }
        }

        // Lưu trữ dữ liệu sản phẩm chi tiết trong phiên làm việc
        session(['products' => $detailedProducts]);

        return response()->json(['success' => true]);
        //return response()->json([$discountedPrice]);
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
        // Lấy thông tin địa chỉ mặc định của khách hàng
        $defaultAddress = $customer->addresses->firstWhere('is_default', true);
        return view('customer.pages.payment', compact('products', 'customerInfo', 'defaultAddress'));
        // return response()->json([$customerInfo]);
    }

    public function orderSuccess()
    {
        // Lấy dữ liệu từ session
        $vnpayResponse = session('vnpay_response', []);
        return view('customer.pages.order-success', compact('vnpayResponse'));
        // dump($vnpayResponse);
    }

    public function orderFailure()
    {
        $errorMessage = session('error_message', []);
        return view('customer.pages.order-failure', compact('errorMessage'));
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

            // Tính tổng số lượng tất cả sản phẩm được mua
            $totalQuantity = array_sum($quantities);
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
            $order->order_quantity = $totalQuantity;
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

                // Cập nhật lại trường "stock" và trường "total_purchase_quantity" trong bảng products
                $product = Product::find($productId);
                if ($product) {
                    $product->stock -= $quantities[$index];
                    $product->total_purchase_quantity += $quantities[$index];
                    $product->save();
                }
            }

            // Tạo thanh toán
            $payment = new Payment();
            $payment->order_id = $order->id;
            $payment->payment_method = $paymentMethod;
            $payment->amount = $totalPrice;
            $payment->status = 'unpaid';
            $payment->save();

            // Xóa các sản phẩm đã đặt mua khỏi giỏ hàng trong cơ sở dữ liệu
            $cart = Cart::where('customer_id', $customer->id)->first();
            if ($cart) {
                CartItem::where('cart_id', $cart->id)
                    ->whereIn('product_id', $productIds)
                    ->delete();
            }
            // Tạo thông báo mới
            $notification = new Notification();
            $notification->customer_id = $customer->id;
            $notification->title = 'Đơn hàng thành công';
            $notification->message = 'Đơn hàng số' . $order->id . 'của khách hàng: ' . $customer->name . ' đã được đặt thành công vào lúc ' . $order->created_at;
            $notification->is_read = false;
            $notification->save();
            DB::commit();
            // cập nhật lại voucher
            if ($request->voucher_code) {
                $voucher = Voucher::where('code', $request->voucher_code)->first();
                $voucher->quantity -= 1;
                $voucher->save();
            }
            return response()->json(['success' => true, 'redictCashPayment_url' => route('order.success')]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in submitOrder: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'redictCashPayment_url' => route('order.failure')]);
        }
    }
}
