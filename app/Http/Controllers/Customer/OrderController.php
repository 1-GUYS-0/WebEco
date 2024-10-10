<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    public function updateOrderManager(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->status = $request->input('status');
            $order->save();
            return response()->json(['success' => true, 'message' => 'Order status updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }
    public function deleteOrderCash(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->payment->payment_method == 'cash') {
            $order->delete();
            return response()->json(['success' => true, 'message' => 'Order deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Order not found or payment method is not cash.'], 404);
    }
    public function completedOrderCash(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->payment->payment_method == 'cash') {
            $order->status = 'completed';
            $order->save();
            return response()->json(['success' => true, 'message' => 'Order completed successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Order not found or payment method is not cash.'], 404);
    }
    public function showReviewForm($orderId)
    {
        $order = Order::with('orderItems.product.images')->find($orderId);
        if ($order) {
            return view('customer.pages.review-product', compact('order'));
            //return response()->json($order, 200, [], JSON_PRETTY_PRINT);
        }
        return redirect()->route('orders.index')->with('error', 'Order not found.');
    }
    public function submitReview(Request $request, $orderId)
    {
        $customerID = Auth::guard('customer')->user()->id;
        $order = Order::find($orderId);
        if ($order) {
            foreach ($request->reviews as $productId => $reviewData) {
                $images = [];
                if (isset($reviewData['images'])) {
                    foreach ($reviewData['images'] as $image) {
                        $path = $image->store('comment_images', 'public');
                        $images[] = 'storage/' . $path;
                    }
                }
                Comment::create([
                    'product_id' => $productId,
                    'customer_id' => $customerID,
                    'rating' => $reviewData['rating'],
                    'images' => json_encode($images),
                    'content' => $reviewData['comment']
                ]);
                // Cập nhật lại trung bình tổng số sao đánh giá cho sản phẩm
                $this->updateProductRating($productId);
            }
            // Đổi trạng thái đơn hàng sang 'reviewed'
            $order->status = 'rated';
            $order->save();
            return redirect()->route('customer.profile')->with('success', 'Đánh giá đã được ghi nhận, xin cảm ơn.');
        }
        return redirect()->back()->with('error', 'Lỗi khi không tìm thấy đơn hàng của bạn.');
    }
    private function updateProductRating($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $averageRating = Comment::where('product_id', $productId)->avg('rating');
            $product->total_rating = $averageRating;
            $product->save();
        }
    }
}

