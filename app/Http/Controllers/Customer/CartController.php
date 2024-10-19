<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function show()
    {
        $userId = Auth::guard('customer')->id(); // Lấy ID người dùng hiện tại
        $cart = Cart::where('customer_id', $userId)
            ->with(['cartItems.product.images']) // Tải trước các mối quan hệ
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([]);
        }

        return response()->json($cart->cartItems); // Trả về dữ liệu JSON của quan hệ cartItems
    }

    public function addToCart(Request $request)
    {
        $checklogin = Auth::guard('customer')->check();

        if (!$checklogin) {
            return response()->json(['message' => 'Vui Lòng đăng nhập tài khoản để thực hiện chức năng này'], 401);
        }

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // Số lượng mặc định là 1

        $userId = Auth::guard('customer')->id(); // Lấy ID người dùng hiện tại

        // Lấy thông tin sản phẩm từ cơ sở dữ liệu
        $product = Product::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        // Kiểm tra số lượng tồn kho
        $currentStock = $product->stock;

        // Tìm hoặc tạo giỏ hàng cho người dùng
        $cart = Cart::firstOrCreate(['customer_id' => $userId]);

        // Tìm hoặc tạo mục giỏ hàng cho sản phẩm
        $cartItem = CartItem::firstOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $productId],
            ['quantity' => 0]
        );

        // Tổng số lượng sau khi thêm
        $newQuantity = $cartItem->quantity + $quantity;

        if ($newQuantity > $currentStock) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available'], 400);
        }

        // Cập nhật số lượng
        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    public function removeFromCart($productId)
    {
        $userId = Auth::guard('customer')->id(); // Lấy ID người dùng hiện tại
        $cart = Cart::where('customer_id', $userId)->first();

        if ($cart) {
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first(); // Lấy mục giỏ hàng đầu tiên

            if ($cartItem) {
                $cartItem->delete();
            }
        }

        return response()->json(['success' => true, 'message' => 'Product removed from cart successfully!']);
    }

    public function updateCart(Request $request, $productId)
    {
        $userId = Auth::guard('customer')->id(); // Lấy ID người dùng hiện tại
        $cart = Cart::where('customer_id', $userId)->first();

        if ($cart) {
            $cartItem = CartItem::where('cart_id', $cart->id) // Tìm mục giỏ hàng của người dùng hiện tại
                ->where('product_id', $productId) // Tìm sản phẩm
                ->first(); // Lấy mục giỏ hàng đầu tiên

            if ($cartItem) {
                $product = Product::find($productId);
                if (!$product) {
                    return response()->json(['success' => false, 'message' => 'Product not found'], 404);
                }

                $currentStock = $product->stock; // Số lượng tồn kho hiện tại
                $newQuantity = $cartItem->quantity + $request->change;

                if ($newQuantity > $currentStock) {
                    return response()->json(['success' => false, 'message' => 'Not enough stock available'], 400);
                }

                if ($newQuantity <= 0) { 
                    $cartItem->delete();
                } else {
                    $cartItem->quantity = $newQuantity;
                    $cartItem->save();
                }

                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
    }
}