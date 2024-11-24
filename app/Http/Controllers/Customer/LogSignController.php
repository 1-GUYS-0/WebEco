<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmail;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;


class LogSignController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.auth.log-in');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('customer')->attempt($credentials)) // Kiểm tra thông tin đăng nhập
        {
            $customer = Auth::guard('customer')->user(); // Lấy thông tin customer đã đăng nhập từ guard 'customer'

            if ($customer->status !== 'verified') {
                Auth::guard('customer')->logout(); // Đăng xuất nếu trạng thái không phải là verified
                return back()->withErrors([
                    'email' => 'Tài khoản của bạn chưa được xác nhận. Vui lòng kiểm tra email để xác nhận tài khoản.',
                ]);
            }

            $request->session()->regenerate(); // Tạo session mới

            $newSessionId = $request->session()->getId(); // Lấy session ID mới
            DB::table('sessions')->where('id', $newSessionId)->update(['customer_id' => $customer->id]); // Cập nhật bảng sessions với customer_id

            return redirect()->intended(route('customer.home')); // Nếu thông tin đăng nhập chính xác, chuyển hướng về trang dashboard
        }

        return back()->withErrors([
            'password' => 'Thông tin đăng nhập không đúng.',
        ]);
    }
    public function showLogout()
    {
        return view('customer.pages.log-out');
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout(); // Đăng xuất guard 'customer'

        $request->session()->invalidate(); // Hủy session hiện tại
        $request->session()->regenerateToken(); // Tạo token mới để tránh CSRF

        return redirect()->intended(route('customer.pages.log-in')); // Chuyển hướng về trang chủ
    }
    // Sign up
    public function showSignupForm()
    {
        return view('customer.auth.sign-up');
    }
    public function signup(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers'],
            'number_phone' => ['required', 'string', 'unique:customers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        DB::beginTransaction();
        try {
            $customer = Customer::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'number_phone' => $data['number_phone'],
                'password' => Hash::make($data['password']),
                'status' => 'unverified',
                'verification_token' => sha1(time()),
                'avatar_path'=>'/storage/avatar_customer/default-avatar.webp',
            ]);

            Mail::to($customer->email)->send(new VerifyEmail($customer));
            // Ghi thông báo vào cơ sở dữ liệu
            Notification::create([
                'customer_id' => $customer->id,
                'title' => 'Đăng ký thành công',
                'message' => 'Chào mừng khách hàng mới! tặng bạn mã giảm giá 25% trên tổng sản phẩm thanh toán, SP-50-30.',
                'is_read' => false,
            ]);
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.']);
        } catch (\Exception $e) {
            Log::error('Error creating customer: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Đã xảy ra lỗi khi tạo tài khoản. Vui lòng thử lại sau.'], 500);
        }
    }
    public function verify($token)
    {
        $customer = Customer::where('verification_token', $token)->first();

        if (!$customer) {
            return redirect()->route('customer.pages.log-in')->with('error', 'Invalid verification token.');
        }

        $customer->status = 'verified';
        $customer->verification_token = null;
        $customer->email_verified_at = now(); // Cập nhật email_verified_at
        $customer->save();

        return redirect()->route('customer.pages.log-in')->with('verifed', 'Your account has been verified. You can now login.');
    }
}
