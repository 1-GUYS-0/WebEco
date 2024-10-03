<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    public function showSignUpForm()
    {
        return view('customer.auth.sign-up');
    }
    public function showLogout()
    {
        return view('customer.pages.log-out');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('customer')->attempt($credentials)) // Kiểm tra thông tin đăng nhập
        {
            $request->session()->regenerate(); // Tạo session mới

            $newSessionId = $request->session()->getId(); // Lấy session ID mới
            $customer = Auth::guard('customer')->user(); // Lấy thông tin customer đã đăng nhập từ guard 'customer' 
            DB::table('sessions')->where('id', $newSessionId)->update(['customer_id' => $customer->id]); // Cập nhật bảng sessions với customer_id

            return redirect()->intended(route('customer.home')); // Nếu thông tin đăng nhập chính xác, chuyển hướng về trang dashboard
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không đúng.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout(); // Đăng xuất guard 'customer'

        $request->session()->invalidate(); // Hủy session hiện tại
        $request->session()->regenerateToken(); // Tạo token mới để tránh CSRF

        return redirect()->intended(route('customer.pages.log-in')); // Chuyển hướng về trang chủ
    }
}
