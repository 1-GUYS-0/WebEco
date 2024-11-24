<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Promotion;
use Carbon\Carbon;

class PromotionDiscountController extends Controller
{
    public function index()
    {
        $currentDate = Carbon::now();
        // Lấy các banner còn trong thời gian hiện tại
        $banners = Banner::where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->get();

        // Lấy các voucher còn trong thời gian hiện tại
        $vouchers = Voucher::where('expiry_date', '>=', $currentDate)->get();

        return view('customer.pages.promotion-and-discount', compact('banners', 'vouchers'));
        // trả về định dạng json có cấu trúc
        // return response()->json([
        //     'banners' => $banners,
        //     'vouchers' => $vouchers
        // ]);
    }
    public function firstPromotionDetail()
    {
        $banner= Banner::where('id', 1)->first();
        $promotion = Promotion::where('id', 1)->first();
        $promotionProducts = Product::with(['images' => function($query) {
            $query->where('image_type', 'cover');
        }])->where('promotion_id', 1)->get();
        // return response()->json([
        //     'banner' => $banner,
        //     'promotion' => $promotion,
        //     'promotionProducts' => $promotionProducts
        // ]);
        return view('customer.pages.promotion.first-promotion',compact('banner','promotion','promotionProducts'));
    }
}
