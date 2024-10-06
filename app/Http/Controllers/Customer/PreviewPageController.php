<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Http\Request;

class PreviewPageController extends Controller
{
    public function index()
    {
        // Lấy 3 sản phẩm đầu tiên
        $Products = Product::with('images')->paginate(3);
        // Lấy banner hiển thị
        $Banners = 
        Banner::where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->get();

        // Truyền dữ liệu đến view
        return view('customer.preview-page.index',compact('Banners', 'Products'));

    }
    public function show($id)
    {
        // Tìm sản phẩm theo id và lấy thêm các ảnh và bình luận của sản phẩm đó
        $product = Product::with(['images','category', 'comments.customer'])->findOrFail($id);
        // Lấy ra 4 sản phẩm cùng loại với sản phẩm đang xem
        $relatedProducts = Product::where('categories_id', $product->categories_id)
            ->where('id', '!=', $id) // Loại trừ sản phẩm đang xem
            ->take(6) // Giới hạn số lượng sản phẩm liên quan hiển thị
            ->get(); // Lấy ra danh sách sản phẩm liên quan
        // Chuẩn bị dữ liệu cho phần đánh giá
        $ratings = $product->comments->groupBy('rating')->map->count(); // NHóm các đánh giá theo số sao sau đó dùng map để áp dụng hàm count() để đếm số lượng đánh giá
        $totalRatings = $product->comments->count(); // Tổng số lượng đánh giá
        $averageRating = $product->comments->avg('rating'); // Tính điểm đánh giá trung bình

        return view('customer.preview-page.products-detail', compact('product', 'relatedProducts', 'ratings', 'totalRatings', 'averageRating'));
        // return response()->json($ratings);
    }
}
