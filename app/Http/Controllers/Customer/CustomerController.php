<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    public function profile($id)
    {
        $customer = Customer::with('addresses')->findOrFail($id);
        $orders = Order::with(['orderItems.product', 'payment'])->where('customer_id', $id)->get();
        $defaultAddress = $customer->addresses->firstWhere('is_default', true);
        $anotherAddresses = $customer->addresses->where('is_default', false);
        return view('customer.pages.profile', compact('customer', 'orders', 'defaultAddress', 'anotherAddresses'));
        // return response()->json($defaultAddress);
    }
    public function updateProfile(Request $request)
    {
        $checklogin = Auth::guard('customer')->check();

        if (!$checklogin) {
            return response()->json(['message' => 'Nguoi dung chua dang nhap',], 401);
        }

        $customer = Customer::find(Auth::guard('customer')->id());

        if ($request->has('name')) {
            $customer->name = $request->input('name');
        }

        // Cập nhật số điện thoại cho địa chỉ mặc định nếu có trong yêu cầu
        if ($request->has('phone')) {
            $defaultAddress = $customer->addresses()->where('is_default', true)->first();
            if ($defaultAddress) {
                $defaultAddress->phone = $request->input('phone');
                $defaultAddress->save();
            }
        }

        // Thay đổi trường is_default dựa vào ID địa chỉ được gửi từ client
        if ($request->has('default_address_id')) {
            // Hủy bỏ cột is_default của địa chỉ mặc định hiện tại
            $currentDefaultAddress = $customer->addresses()->where('is_default', true)->first();
            if ($currentDefaultAddress) {
                $currentDefaultAddress->is_default = false;
                $currentDefaultAddress->save();
            }
            $newDefaultAddress = $customer->addresses()->find($request->input('default_address_id'));
            if ($newDefaultAddress) {
                $newDefaultAddress->is_default = true;
                $newDefaultAddress->save();
            }
        }

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatar_customer', 'public');
            $customer->avarar_path = Storage::url($avatarPath);
        }

        $customer->save();

        return response()->json(['message' => 'Thông tin đã được cập nhật thành công.']);
    }
}
