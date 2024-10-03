<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    protected $fakeUserId = 1; // ID giả định cho người dùng

    public function show()
    {
        $userId = $this->fakeUserId; // Sử dụng ID giả định
        $cart = Cart::where('customer_id', $userId)
            ->with(['cartItems.product.images']) // Tải trước các mối quan hệ
            ->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return response()->json([]);
        }
        // dd($cart->cartItems);
        return response()->json($cart->cartItems); // Trả về dữ liệu JSON của quan hệ cartItems
    }

    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1); // Số lượng mặc định là 1

        // Giả sử bạn có một user_id giả định
        $userId = 1;

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
        // return response()->json(['success' => true, 'message' => $currentStock ]);

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
        $userId = $this->fakeUserId; // Sử dụng ID giả định
        $cart = Cart::where('customer_id', $userId)->first();

        if ($cart) {
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->delete();
            }
        }

        return redirect()->back()->with('success', 'Product removed from cart successfully!');
    }

    public function updateCart(Request $request, $productId)
    {
        $userId = 1; // Sử dụng ID giả định
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
