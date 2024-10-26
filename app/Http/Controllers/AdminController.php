<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\Voucher;
use App\Models\Customer;
use App\Models\Admin;
use App\Models\Banner;
use App\Models\VNPayPayment;
use App\Models\Product;
use App\Models\Category;
use App\Models\RefundRequest;
use App\Models\Notification;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


use function Symfony\Component\VarDumper\Dumper\esc;

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('admin.login-admin');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::guard('admin')->attempt($credentials)) // Kiểm tra thông tin đăng nhập của admin
        {
            return redirect()->route('dashboards.showDashboardMng');
        }
        return redirect()->route('admin.login')->with('error', 'Email hoặc mật khẩu không đúng.');
    }
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    // Dashboard
    public function showDashboardMng()
    {
        $today = Carbon::today();

        // Lấy số lượng đơn hàng mới hiện tại
        $newOrdersCount = Order::whereDate('created_at', $today)->where('status', 'pending')->count();
        // Lấy tổng số lượng đơn hàng trong ngày hôm nay
        $todayOrdersCount = Order::whereDate('created_at', $today)->count();

        // Lấy số lượng khách hàng mới trong ngày hôm nay
        $newCustomersCount = Customer::whereDate('created_at', $today)->count();

        // Lấy tổng doanh thu trong ngày hôm nay
        $todayRevenue = Payment::whereDate('payment_date', $today)
            ->where('status', 'paid')
            ->sum('amount');
        // Lấy tổng doanh thu toàn bộ
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        // Lấy tên sản phẩm và số lượng kho của sản phẩm lọc theo thứ tự giảm dần của số lượng kho
        $productsStocks = Product::orderBy('stock', 'asc')->get(['name', 'stock', 'id']);
        return view('admin.dashboard', compact('newOrdersCount', 'todayOrdersCount', 'newCustomersCount', 'todayRevenue', 'totalRevenue', 'productsStocks'));
    }
    public function filterDashboardData(Request $request)
    {
        $filter = $request->input('filter');
        $today = Carbon::today();
        $startDate = $today;
        $endDate = $today;

        switch ($filter) {
            case 'td':
                // Today
                $startDate = $today;
                $endDate = $today;
                break;
            case 'tw':
                // This week
                $startDate = $today->copy()->startOfWeek();
                $endDate = $today->copy()->endOfWeek();
                break;
            case 'tm':
                // This month
                $startDate = $today->copy()->startOfMonth();
                $endDate = $today->copy()->endOfMonth();
                break;
            case 'ty':
                // This year
                $startDate = $today->copy()->startOfYear();
                $endDate = $today->copy()->endOfYear();
                break;
        }

        // Lấy số lượng đơn hàng mới hiện tại
        $newOrdersCount = Order::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->where('status', 'pending')
            ->count();

        // Lấy tổng số lượng đơn hàng trong khoảng thời gian
        $todayOrdersCount = Order::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();

        // Lấy số lượng khách hàng mới trong khoảng thời gian
        $newCustomersCount = Customer::whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();

        // Lấy tổng doanh thu trong khoảng thời gian
        $todayRevenue = Payment::whereDate('payment_date', '>=', $startDate)
            ->whereDate('payment_date', '<=', $endDate)
            ->where('status', 'paid')
            ->sum('amount');

        // Lấy tổng doanh thu toàn bộ
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        // Lấy tên sản phẩm và số lượng kho của sản phẩm lọc theo thứ tự giảm dần của số lượng kho
        $productsStocks = Product::orderBy('stock', 'asc')->get(['name', 'stock', 'id']);

        return response()->json([
            'success' => true,
            'newOrdersCount' => $newOrdersCount,
            'todayOrdersCount' => $todayOrdersCount,
            'newCustomersCount' => $newCustomersCount,
            'todayRevenue' => $todayRevenue,
            'totalRevenue' => $totalRevenue,
            'productsStocks' => $productsStocks,
        ]);
        //return json_encode([$startDate, $endDate]);
    }
    public function filterDashboardChartData(Request $request)
    {
        $today = Carbon::today();

        // Lấy dữ liệu cho BarChart (số lượng sản phẩm trong các tháng của năm hiện tại)
        $barChartData = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $today->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $barChartLabels = array_keys($barChartData);
        $barChartValues = array_values($barChartData);

        // Lấy dữ liệu cho LineChart (tổng doanh thu của mỗi tháng trong năm hiện tại)
        $lineChartData = Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->whereYear('payment_date', $today->year)
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        $lineChartValues = array_values($lineChartData);
        // Lấy dữ liệu cho PieChart (tổng số lượng sản phẩm đã bán ra cho từng danh mục)
        $categories = Category::with(['products' => function ($query) {
            $query->selectRaw('categories_id, SUM(total_purchase_quantity) as total_quantity')->groupBy('categories_id');
        }])->get();

        $pieChartData = [];
        foreach ($categories as $category) {
            $totalQuantity = $category->products->sum('total_quantity');
            $pieChartData[$category->name] = $totalQuantity;
        }
        Log::info('Pie Chart Data:', ['data' => $pieChartData]);
        $pieChartLabels = array_keys($pieChartData);
        $pieChartValues = array_values($pieChartData);

        return response()->json([
            'success' => true,
            'barChart' => [
                'labels' => $barChartLabels,
                'data' => $barChartValues,
                'lineData' => $lineChartValues,
            ],
            'pieChart' => [
                'labels' => $pieChartLabels,
                'data' => $pieChartValues,
            ],
        ]);
    }
    // Order
    public function showOrderMng()
    {
        $payments = Payment::with('order')->get();
        $refunds = RefundRequest::with('order.payment')->get();
        return view('admin.orders-manager', compact('payments', 'refunds'));
        //return json_encode($payments);
        //dump($refunds);
    }
    public function updateOrderManager(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $request->input('status');
            $order->save();
            return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }
    public function detailOrderMng($orderId)
    {
        $order = Order::with('orderItems.product.images', 'customer')->find($orderId);
        $paymentId = Payment::where('order_id', $orderId)->where('payment_method', 'vnpay')->first();
        $vnpaypayment = $paymentId ? VNPayPayment::where('payment_id', $paymentId->id)->first() : null;
        $payment = Payment::where('order_id', $orderId)->first();

        if ($order) {
            // Log::info('VNPay Payment:', ['vnpaypayment' => $vnpaypayment]);
            return response()->json([
                'success' => true,
                'order' => $order,
                'payment' => $payment,
                'vnpaypayment' => $vnpaypayment
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }
    public function detailRefund($refundsId)
    {
        $refund = RefundRequest::with('order.payment')->find($refundsId);
        if ($refund) {
            return response()->json(['success' => true, 'refund' => $refund]);
        }
        return response()->json(['success' => false, 'message' => 'Refund request not found.'], 404);
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
            if ($vnpayPayment !== null) {

                $apiUrl = env('VNP_REFUND_URL'); // URL API hoàn tiền của VNPAY
                $vnp_RequestId = date("YmdHis"); // Mã truy vấn
                $vnp_Command = "refund"; // Mã api
                $vnp_TransactionType = "02"; // 02 hoàn trả toàn phần - 03 hoàn trả một phần
                $vnp_TxnRef = $vnpayPayment->vnp_txn_ref; // Mã tham chiếu của giao dịch
                $vnp_Amount = $vnpayPayment->vnp_amount; // Số tiền hoàn trả
                $vnp_OrderInfo = "Hoan Tien Giao Dich tai web"; // Mô tả thông tin
                $vnp_TransactionNo = $vnpayPayment->vnp_transaction_no; // Tuỳ chọn, "0": giả sử merchant không ghi nhận được mã GD do VNPAY phản hồi.
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
                Order::where('id', $orderId)->update(['status' => 'cancelled']);
                $Orderitems = OrderItem::where('order_id', $orderId)->get();
                foreach ($Orderitems as $Orderitem) {
                    $product = Product::where('id', $Orderitem->product_id)->first();
                    $product->stock += $Orderitem->quantity;
                    $product->total_purchase_quantity -= $Orderitem->quantity;
                    $product->save();
                }
                Payment::where('id', $paymentId)->update(['status' => 'refund']);
                RefundRequest::where('order_id', $orderId)->update(['status' => 'confirmed']);
                // Tạo thông báo mới cho người dùng
                $notification = new Notification();
                $notification->customer_id = Order::where('id', $orderId)->first()->customer_id;
                $notification->title = 'Yêu cầu hoàn trả đã được xác nhận';
                $notification->message = 'Yêu cầu hoàn trả cho đơn hàng #' . $orderId . ' đã được xác nhận thành công. Số tiền hoàn trả sẽ được chuyển về tài khoản VNPAY của bạn trong thời gian sớm nhất.';
                $notification->is_read = false;
                $notification->save();

                return response()->json(['success' => true, 'data' => $response->json()]);
            } else {
                return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau', 'data' => $response->json()]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau']);
        }
        // return response()->json(['success' => true, 'payment_url' => $vnp_Url]); // Trả về URL thanh toán của VNPAY
    }
    public function refundConfirm(Request $request, $refundId)
    {
        $refund = RefundRequest::with('order.orderItems.product', 'order.payment')->find($refundId);
        $refundPaymentMethod = $refund->order->payment->payment_method;
        if ($refundPaymentMethod === 'cash') {
            $refund->status = 'accepted';
            $refund->save();
            // Cập nhật trạng thái của đơn hàng
            $order = $refund->order;
            $order->status = 'refunded';
            $order->save();
            // Cập nhật stock và total_purchase_quantity của từng sản phẩm trong đơn hàng
            foreach ($order->orderItems as $orderItem) {
                $product = $orderItem->product; // Lấy sản phẩm liên quan đến mục đơn hàng
                $product->stock += $orderItem->quantity;
                $product->total_purchase_quantity -= $orderItem->quantity;
                $product->save();
            }
            // Tạo thông báo mới cho người dùng
            $notification = new Notification();
            $notification->customer_id = $refund->order->customer_id;
            $notification->title = 'Yêu cầu hoàn trả đã được xác nhận';
            $notification->message = 'Yêu cầu hoàn trả cho đơn hàng #' . $refund->order->id . ' đã được xác nhận thành công. Shipper sẽ liên hệ với bạn để nhận lại hàng trong thời gian sớm nhất.';
            $notification->is_read = false;
            $notification->save();
            return response()->json(['success' => true, 'message' => 'Refund request status updated successfully.']);
        }
        if ($refundPaymentMethod === 'vnpay') {
            $this->paymentRefund($refund->order_id);
            return response()->json(['success' => true, 'message' => 'Refund request status updated successfully.']);
        };

        return response()->json(['success' => false, 'message' => 'Refund request not found.'], 404);
    }
    //Promotion
    public function showPromotionMng()
    {
        $promotions = Promotion::all();
        return view('admin.promotion-manager', compact('promotions'));
    }
    public function getPromotionDetails($id)
    {
        $promotion = Promotion::find($id);

        if ($promotion) {
            return response()->json(['status' => 'success', 'promotion' => $promotion]);
        }

        return response()->json(['status' => 'error', 'message' => 'Dont find promotion']);
        // trả về json
        //return json_encode($promotion);
    }
    public function addPromotion(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'percent_promotion' => 'required|numeric',
                'promotion_start' => 'required|date',
                'promotion_end' => 'required|date',
            ]);
            $promotion = new Promotion();
            $promotion->name = $request->input('name');
            $promotion->percent_promotion = $request->input('percent_promotion');
            $promotion->promotion_start = $request->input('promotion_start');
            $promotion->promotion_end = $request->input('promotion_end');
            $promotion->save();
            DB::commit();
            return response()->json(['success' => 'Promotion added successfully.', 'message' => 'Thêm khuyến mãi thành công.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    public function updatePromotion(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required',
                'percent_promotion' => 'required|numeric',
                'promotion_start' => 'required|date',
                'promotion_end' => 'required|date',
            ]);
            $promotion = Promotion::find($request->input('id'));
            if ($promotion) {
                $promotion->name = $request->input('name');
                $promotion->percent_promotion = $request->input('percent_promotion');
                $promotion->promotion_start = $request->input('promotion_start');
                $promotion->promotion_end = $request->input('promotion_end');
                $promotion->save();
                DB::commit();
                return response()->json(['success' => 'Promotion updated successfully.', 'message' => 'Cập nhật khuyến mãi thành công.']);
            }
            return response()->json(['error' => 'Promotion not found.', 'message' => 'Không tìm thấy Khuyến mãi'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    public function deletePromotion(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
            $promotion = Promotion::find($request->input('id'));
            if ($promotion) {
                $promotion->delete();
                DB::commit();
                return response()->json(['success' => 'Promotion deleted successfully.', 'message' => 'Xóa khuyến mãi thành công.']);
            }
            return response()->json(['error' => 'Promotion not found.', 'message' => 'Không tìm thấy Promotion'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    //Voucher
    public function vouchers()
    {
        $vouchers = Voucher::all();
        return view('admin.voucher-manager', compact('vouchers'));
    }
    public function getVoucherDetails($id)
    {
        $voucher = Voucher::find($id);

        if ($voucher) {
            return response()->json(['status' => 'success', 'voucher' => $voucher]);
        }

        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy voucher.']);
    }
    public function addVoucher(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'code' => 'required|string|max:255|unique:vouchers',
                'name' => 'required|string|max:255',
                'discount_amount' => 'required|numeric|min:0|max:100',
                'quantity' => 'required|integer|min:1',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
                'expiry_date' => 'required|date|after_or_equal:end_time',
            ]);

            $voucher = new Voucher();
            $voucher->code = $validatedData['code'];
            $voucher->name = $validatedData['name'];
            $voucher->discount_amount = $validatedData['discount_amount'];
            $voucher->quantity = $validatedData['quantity'];
            $voucher->start_time = $validatedData['start_time'];
            $voucher->end_time = $validatedData['end_time'];
            $voucher->expiry_date = $validatedData['expiry_date'];
            $voucher->save();

            return response()->json(['success' => 'Add vouchered', 'message' => 'Thêm voucher mới thành công.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Có lỗi xảy ra', 'message' => $e->getMessage()], 500);
        }
    }
    public function updateVoucher(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|exists:vouchers,id',
                'code' => 'required|string|max:255|unique:vouchers,code,' . $request->id,
                'name' => 'required|string|max:255',
                'discount_amount' => 'required|numeric|min:0|max:100',
                'quantity' => 'required|integer|min:1',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
                'expiry_date' => 'required|date|after_or_equal:end_time',
            ]);

            $voucher = Voucher::find($validatedData['id']);

            if ($voucher) {
                $voucher->code = $validatedData['code'];
                $voucher->name = $validatedData['name'];
                $voucher->discount_amount = $validatedData['discount_amount'];
                $voucher->quantity = $validatedData['quantity'];
                $voucher->start_time = $validatedData['start_time'];
                $voucher->end_time = $validatedData['end_time'];
                $voucher->expiry_date = $validatedData['expiry_date'];
                $voucher->save();

                return response()->json(['status' => 'success', 'message' => 'Cập nhật voucher thành công.']);
            }

            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy voucher.']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function deleteVoucher(Request $request)
    {
        $voucher = Voucher::find($request->input('id'));

        if ($voucher) {
            $voucher->delete();

            return response()->json(['status' => 'success', 'message' => 'Xóa voucher thành công.']);
        }

        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy voucher.']);
    }
    //Customer
    public function customers()
    {
        $customers = Customer::all();
        return view('admin.customer-manager', compact('customers'));
    }
    public function getCustomerDetails($id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return response()->json(['status' => 'success', 'customer' => $customer]);
        }

        return response()->json(['status' => 'error', 'message' => 'Không tìm thấy khách hàng.']);
    }
    public function updateCustomer(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required|string|max:255',
                'number_phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
                'status' => 'required|string|max:50',
            ]);

            $customer = Customer::find($request->input('id'));
            if ($customer) {
                $customer->name = $request->input('name');
                $customer->number_phone = $request->input('number_phone');
                $customer->email = $request->input('email');
                $customer->status = $request->input('status');
                $customer->save();
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Cập nhật khách hàng thành công.']);
            }
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy khách hàng.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
    public function deleteCustomer(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);

            $customer = Customer::find($request->input('id'));
            if ($customer) {
                $customer->delete();
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Xóa khách hàng thành công.']);
            }
            return response()->json(['status' => 'error', 'message' => 'Không tìm thấy khách hàng.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
    //Admin
    public function admins()
    {
        $admins = Admin::all();
        return view('admin.admin-manager', compact('admins'));
    }
    
    public function getAdminDetails($id)
    {
        $admin = Admin::find($id);
    
        if ($admin) {
            return response()->json(['status' => 'success', 'admin' => $admin]);
        }
    
        return response()->json(['status' => 'error', 'message' => 'Admin not found']);
    }
    
    public function addAdmin(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|min:6',
                'role' => 'required|in:admin,sale',
            ]);
    
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->password = Hash::make($request->input('password'));
            $admin->email = $request->input('email');
            $admin->role = $request->input('role');
            $admin->save();
    
            DB::commit();
            return response()->json(['success' => 'Admin added successfully.', 'message' => 'Thêm admin thành công.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    
    public function updateAdmin(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
                'name' => 'required',
                'email' => 'required|email|unique:admins,email,' . $request->input('id'),
                'role' => 'required|in:admin,sale',
            ]);
    
            $admin = Admin::find($request->input('id'));
            if ($admin) {
                $admin->name = $request->input('name');
                $admin->email = $request->input('email');
                $admin->role = $request->input('role');
                $admin->save();
    
                DB::commit();
                return response()->json(['success' => 'Admin updated successfully.', 'message' => 'Cập nhật admin thành công.']);
            }
    
            return response()->json(['error' => 'Admin not found.', 'message' => 'Không tìm thấy admin'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    
    public function deleteAdmin(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
    
            $admin = Admin::find($request->input('id'));
            if ($admin) {
                $admin->delete();
                DB::commit();
                return response()->json(['success' => 'Admin deleted successfully.', 'message' => 'Xóa admin thành công.']);
            }
    
            return response()->json(['error' => 'Admin not found.', 'message' => 'Không tìm thấy admin'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    //Banner
    public function banners()
    {
        $banners = Banner::all();
        return view('admin.banner-manager', compact('banners'));
    }
    
    public function getBannerDetails($id)
    {
        $banner = Banner::find($id);
    
        if ($banner) {
            return response()->json(['status' => 'success', 'banner' => $banner]);
        }
    
        return response()->json(['status' => 'error', 'message' => 'Banner not found']);
    }
    
    public function addBanner(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'title' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'link_to' => 'required|url',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $banner = new Banner();
            $banner->title = $request->input('title');
            $banner->start_date = $request->input('start_date');
            $banner->end_date = $request->input('end_date');
            $banner->link_to = $request->input('link_to');
    
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('banner_images', 'public');
                $banner->images_path = '/storage/' . $imagePath;
            }
    
            $banner->save();
            DB::commit();
            return response()->json(['success' => 'Banner added successfully.', 'message' => 'Thêm banner thành công.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    
    public function updateBanner(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
                'title' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'required|date',
                'link_to' => 'required|url',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
    
            $banner = Banner::find($request->input('id'));
            if ($banner) {
                $banner->title = $request->input('title');
                $banner->start_date = $request->input('start_date');
                $banner->end_date = $request->input('end_date');
                $banner->link_to = $request->input('link_to');
    
                if ($request->hasFile('image')) {
                    if ($banner->images_path) {
                        $oldImagePath = str_replace('/storage/', '', $banner->images_path);
                        Storage::disk('public')->delete($oldImagePath);
                    }

                    $image = $request->file('image');
                    $imagePath = $image->store('banner_images', 'public');
                    $banner->images_path = '/storage/' . $imagePath;
                }
    
                $banner->save();
                DB::commit();
                return response()->json(['success' => 'Banner updated successfully.', 'message' => 'Cập nhật banner thành công.']);
            }
    
            return response()->json(['error' => 'Banner not found.', 'message' => 'Không tìm thấy banner'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
    
    public function deleteBanner(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id' => 'required|integer',
            ]);
    
            $banner = Banner::find($request->input('id'));
            if ($banner) {
                if ($banner->images_path) {
                    $imagePath = str_replace('/storage/', '', $banner->images_path);
                    Storage::disk('public')->delete($imagePath);
                }
                $banner->delete();
                DB::commit();
                return response()->json(['success' => 'Banner deleted successfully.', 'message' => 'Xóa banner thành công.']);
            }
    
            return response()->json(['error' => 'Banner not found.', 'message' => 'Không tìm thấy banner'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid data.', 'message' => $e->getMessage()], 400);
        }
    }
}
