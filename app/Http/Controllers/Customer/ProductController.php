<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        // Tìm sản phẩm theo id và lấy thêm các ảnh và bình luận của sản phẩm đó
        $product = Product::with(['images', 'comments.customer', 'category'])->findOrFail($id);
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
    public function showSearchPage()
    {
        $skinTypes = Product::distinct()->pluck('skin');
        $categories = Category::all();
        return view('customer.pages.search-product', compact('skinTypes', 'categories'));
        //return response()->json($skinTypes, 200, [], JSON_PRETTY_PRINT);
    }
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('category') && !empty($request->category)) {
            $query->where('categories_id', $request->category);
        }

        if ($request->filled('skin_type') && !empty($request->skin_type)) {
            $query->where('skin', $request->skin_type);
        }

        if ($request->filled('rating') && !empty($request->rating)) {
            $query->where('total_rating', '>=', $request->rating);
        }

        if ($request->filled('search_name') && !empty($request->search_name)) {
            $query->where('name', 'like', '%' . $request->search_name . '%');
        }
        if ($request->filled('price_order')) {
            if ($request->price_order == 0) {
                $query->orderBy('price', 'desc');
            } elseif ($request->price_order == 1) {
                $query->orderBy('price', 'asc');
            }
        }

        $products = $query->with('images')->get();

        return response()->json(['products' => $products]);
        //dump($products);
    }
}
