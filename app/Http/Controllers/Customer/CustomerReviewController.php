<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    // Hiển thị danh sách các đánh giá
    public function index($productId)
    {
        // Tạo query để lấy các đánh giá
        $query = Comment::where('product_id', $productId);
        // Lấy ra trường của product
        $product = Product::find($productId);

        $comments = $query->get();

        return view('customer.pages.product-review', compact('comments', 'product'));
    }
    public function filter(Request $request, $productId)
    {
        // Tạo query để lấy các đánh giá
        $query = Comment::with('customer')->where('product_id', $productId);
    
        // Lọc theo số sao
        if ($request->filled('starFilter') && $request->starFilter !== 'all') {
            $query->where('rating', $request->starFilter);
        }
    
        // Sắp xếp theo thời gian
        if ($request->filled('timeSort') && !empty($request->timeSort)) {
            $query->orderBy('created_at', $request->timeSort);
        }
    
        $comments = $query->get();
    
        // Trả về dữ liệu JSON
        return response()->json([
            'comments' => $comments,
            'query' => $productId
        ]);
    }
}
