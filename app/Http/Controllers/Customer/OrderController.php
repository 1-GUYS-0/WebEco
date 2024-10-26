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
    public function deleteOrderCash(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->payment->payment_method == 'cash') {
            $order->delete();
            return response()->json(['success' => true, 'message' => 'Order deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Order not found or payment method is not cash.'], 404);
    }
    public function completedOrder(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
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
    public function getOrderDetails($orderId)
    {
        // Lấy chi tiết đơn hàng từ cơ sở dữ liệu
        $order = Order::with('orderItems.product.images','payment','refundRequest')->findOrFail($orderId);
        return response()->json($order);
    }
    public function orderReturnRequest(Request $request)
    {
        $order = Order::find($request->order_id);
        if ($order) {
            // Xử lý việc upload ảnh và lưu đường dẫn ảnh vào mảng
            $imagePaths = [];
            if ($request->hasFile('images_refund')) {
                foreach ($request->file('images_refund') as $file) {
                    $path = $file->store('refund_images', 'public');
                    $imagePaths[] = '/storage/' . $path; // Thêm /storage vào đường dẫn ảnh
                }
            }
    
            // Tạo yêu cầu hoàn trả
            $order->refundRequest()->create([
                'order_id' => $request->order_id,
                'reason' => $request->reason,
                'details' => $request->details,
                'images_refund' => json_encode($imagePaths), // Lưu đường dẫn ảnh dưới dạng JSON
                'status' => 'pending'
            ]);
            return response()->json(['success' => true, 'message' => 'Return request submitted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'Order not found.'], 404);
    }
}

