<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;

class CustomerResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('customer.auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        Log::info('Reset password request received', ['email' => $request->email]);

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);

        Log::info('Validation passed', ['email' => $request->email]);

        $status = Password::broker('customers')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($customer, $password) {
                Log::info('Resetting password for customer', ['customer_id' => $customer->id]);
                $customer->password = Hash::make($password);
                $customer->save();
                Log::info('Password reset successfully', ['customer_id' => $customer->id]);
            }
        );

        Log::info('Password reset status', ['status' => $status]);

        if ($status === Password::PASSWORD_RESET) {
            Log::info('Password reset successful', ['email' => $request->email]);
            return redirect()->route('customer.pages.log-in')->with('status', __($status));
        } else {
            Log::error('Password reset failed', ['email' => $request->email, 'status' => $status]);
            return back()->withErrors(['email' => [__($status)]]);
        }
    }
}