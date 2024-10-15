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
    // Dashboard
    public function showDashboardMng()
    {
        $authname = Auth::guard('admin')->user()->name;
        return view('admin.dashboard',compact('authname'));
        // trả về dạng json
        //return response()->json(['auth' => $authname]);
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
        $order = Order::with('orderItems.product')->find($orderId);
        $payment=Payment::where('order_id',$orderId)->id();
        $vnpaypayment=Payment::where('payment_id',$payment)->first();
        if ($order) {
            return view('admin.order-detail', compact('order','vnpaypayment'));
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
}

