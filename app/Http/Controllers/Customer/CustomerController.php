<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CustomerController extends Controller
{
    public function profile()
    {
        if (Auth::guard('customer')->check()) {
            $customerID = Auth::guard('customer')->id();
            $customer = Customer::with('addresses')->findOrFail($customerID);
            $orders = Order::with(['orderItems.product', 'payment'])->where('customer_id', $customerID)->orderBy('created_at', 'desc')->get();
            $defaultAddress = $customer->addresses->firstWhere('is_default', true);
            $anotherAddresses = $customer->addresses->where('is_default', false);
            return view('customer.pages.profile', compact('customer', 'orders', 'defaultAddress', 'anotherAddresses'));
            //return response()->json($orders);
        }
    }
    public function updateProfile(Request $request)
    {
        try {
            $checklogin = Auth::guard('customer')->check();
    
            if (!$checklogin) {
                return response()->json(['message' => 'Người dùng chưa đăng nhập'], 401);
            }
    
            $customer = Customer::find(Auth::guard('customer')->id());
    
            if ($request->has('name')) {
                $customer->name = $request->input('name');
            }
    
            if ($request->has('phone')) {
                if ($customer) {
                    $customer->number_phone = $request->input('phone');
                    $customer->save();
                }
            }
    
            if ($request->has('default_address_id')) {
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
                $customer->avatar_path = Storage::url($avatarPath);
            }
    
            if ($request->has('addnewaddress')) {
                $addressData = explode('/', $request->input('addnewaddress'));
                if (count($addressData) === 5) {
                    $province = $addressData[0];
                    $district = $addressData[1];
                    $ward = $addressData[2];
                    $phone =$addressData[3];
                    $address = $addressData[4];
                    Log::info($phone);
                    // Lưu thông tin địa chỉ mới vào cơ sở dữ liệu
                    $newAddress = $customer->addresses()->create([
                        'province' => $province,
                        'district' => $district,
                        'ward' => $ward,
                        'phone' =>$phone,
                        'address' => $address,
                        'is_default' => false,
                        'customer_id' => $customer->id
                    ]);
                } else {
                    return response()->json(['message' => 'Dữ liệu địa chỉ không hợp lệ'], 400);
                }
            }
    
            $customer->save();
    
            return response()->json(['message' => 'Thông tin đã được cập nhật thành công.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }
}
