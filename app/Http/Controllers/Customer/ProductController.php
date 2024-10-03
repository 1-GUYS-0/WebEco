<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        // Tìm sản phẩm theo id và lấy thêm các ảnh và bình luận của sản phẩm đó
        $product = Product::with(['images', 'comments.customer'])->findOrFail($id);
        // Lấy ra 4 sản phẩm cùng loại với sản phẩm đang xem
        $relatedProducts = Product::where('categories_id', $product->categories_id)
            ->where('id', '!=', $id) // Loại trừ sản phẩm đang xem
            ->take(6) // Giới hạn số lượng sản phẩm liên quan hiển thị
            ->get(); // Lấy ra danh sách sản phẩm liên quan
        // Chuẩn bị dữ liệu cho phần đánh giá
        $ratings = $product->comments->groupBy('rating')->map->count(); // NHóm các đánh giá theo số sao sau đó dùng map để áp dụng hàm count() để đếm số lượng đánh giá
        $totalRatings = $product->comments->count(); // Tổng số lượng đánh giá
        $averageRating = $product->comments->avg('rating'); // Tính điểm đánh giá trung bình

        return view('customer.pages.products-detail', compact('product', 'relatedProducts', 'ratings', 'totalRatings', 'averageRating'));
        // return response()->json($ratings);
    }
}
