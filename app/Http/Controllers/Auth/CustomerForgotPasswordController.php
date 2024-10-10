<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Models\Customer;

class CustomerForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('customer.auth.email-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
        $customer = Customer::where('email', $request->email)->first();
        if (!$customer) {
            return back()->withErrors(['email' => 'Email address not found.']);
        }

        // Gửi email chứa link reset password
        $status = Password::broker('customers')->sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->route('password.reset.confirmation');
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    }
    public function SendResetLinkEmailConfirmation()
    {
        return view('customer.auth.send-reset-email-comfirm');
    }
}