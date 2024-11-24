<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function applyVoucher(Request $request)
    {
        $voucherCode = $request->input('voucher_code');
        $totalPrice = $request->input('total_price');
        $shippingFee = $request->input('shipping_fee');
    
        
        $voucher = Voucher::where('code', $voucherCode)->first();
        // Kiểm tra xem voucher có tồn tại không và còn hạn sử dụng(expiry_date) không
        if (!$voucher || $voucher->quantity==0 || $voucher->expiry_date < now()) {
            return response()->json(['success' => false, 'message' => 'Voucher không hợp lệ hoặc đã hết hạn.']);
        }
    
        $discount = 0;
    
        if (strpos($voucherCode, 'VC-') === 0) {
            // Giảm giá cho đơn vị vận chuyển
            $discount = $shippingFee * ($voucher->discount_amount / 100);
        } elseif (strpos($voucherCode, 'SP-') === 0) {
            // Giảm giá cho tổng số tiền sản phẩm
            $discount = $totalPrice * ($voucher->discount_amount / 100);
        }
    
        return response()->json(['success' => true, 'discount' => $discount]);
    }
}
