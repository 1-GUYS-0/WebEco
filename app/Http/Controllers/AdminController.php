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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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
        return view('admin.orders-manager', compact('payments'));
        //return json_encode($payments);
        //dump($payments);
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
    //Promotion
    public function showPromotionMng()
    {
        $promotions = Promotion::all();
        return view('admin.promotion-manager', compact('promotions'));
    }
    //Voucher
    public function vouchers()
    {
        $vouchers = Voucher::all();
        return view('admin.voucher-manager', compact('vouchers'));
    }
    //Customer
    public function customers()
    {
        $customers = Customer::all();
        return view('admin.customer-manager', compact('customers'));
    }
    //Admin
    public function admins()
    {
        $admins = Admin::all();
        return view('admin.admin-manager', compact('admins'));
    }
    //Banner
    public function banners()
    {
        $banners = Banner::all();
        return view('admin.banner-manager', compact('banners'));
    }
    public function updateBanner(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'id_banner' => 'required|integer',
                'title_banner' => 'required',
                'start-date_banner' => 'required|date',
                'end-date_banner' => 'required|date',
                'link_banner' => 'required',
                'images.*' => 'required|image|mimes:webp|max:2048',
            ]);
            $banner = Banner::find($request->input('id_banner'));
            if ($banner) {
                $banner->title = $request->input('title_banner');
                $banner->start_date = $request->input('start-date_banner');
                $banner->end_date = $request->input('end-date_banner');
                $banner->link_to = $request->input('link_banner');
                // Xóa ảnh cũ liên quan đến banner
                if ($request->hasFile('images')) {
                    // Xóa ảnh cũ
                    if ($banner->images_path) {
                        unlink(public_path($banner->images_path));
                    }
                    // Lưu ảnh mới
                    $path = $request->file('images')[0]->store('banner_images', 'public');
                    $banner->images_path = 'storage/' . $path;
                }
                $banner->save();
                DB::commit();
                return response()->json(['success' => 'Banner đã được cập nhật thành công.']);
            }
            return response()->json(['error' => 'Không tìm thấy banner.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Dữ liệu không hợp lệ.', 'message' => $e->getMessage()], 400);
        }
    }
    public function addBanner(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'title_banner' => 'required',
                'start-date_banner' => 'required|date',
                'end-date_banner' => 'required|date',
                'link_banner' => 'required',
                'image' => 'required|image|mimes:webp|max:2048',
            ]);
            $banner = new Banner();
            $banner->title = $request->input('title_banner');
            $banner->start_date = $request->input('start-date_banner');
            $banner->end_date = $request->input('end-date_banner');
            $banner->link_to = $request->input('link_banner');

            // Lưu ảnh mới
            $path = $request->file('image')->store('banner_images', 'public');
            $banner->images_path = 'storage/' . $path;

            $banner->save();
            DB::commit();
            return response()->json(['success' => 'Banner đã được thêm mới thành công.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Dữ liệu không hợp lệ.', 'message' => $e->getMessage()], 400);
        }
    }
}
