<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Promotion;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function show()
    {
        $products = Product::with(['category', 'images', 'promotion'])->get(); // Tải trước thông tin category và images
        $promotions = Promotion::all();
        $categories = Category::all();
        return view('admin.products-manager', compact('products', 'categories', 'promotions'));
        // trả về định dạng jsson
        //return response()->json(['pr' => $promotions]);
    }
    public function create()
    {
        $categories = Category::all();
        return view("admin.product.add-product", ['categoriesIBL' => $categories]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_product' => 'required|string|max:255',
            'price_product' => 'required|numeric',
            'smell_product' => 'required|string',
            'texture_product' => 'required|string',
            'htu_product' => 'required|string',
            'all_ingredient_product' => 'required|string',
            'ingre_main_product' => 'required|string',
            'skin_product' => 'required|string',
            'quantity_product' => 'required|integer',
            'cate_product' => 'required|integer',
            'des_product' => 'required|string',
            'note_product' => 'required|string',
            'images.*' => 'required|image|mimes:webp|max:2048', // kiểm tra hình ảnh có đúng định dạng và dung lượng cụ thể là 2MB
            'image_type' => 'nullable|string',
            'promotion_id' => 'nullable|integer',
            'brand_product' => 'required|string',
            'weight_product' => 'required|string',
        ]);
        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $request->input('name_product'),
                'price' => $request->input('price_product'),
                'smell' => $request->input('smell_product'),
                'texture' => $request->input('texture_product'),
                'htu' => $request->input('htu_product'),
                'ingredient' => $request->input('all_ingredient_product'),
                'main_ingredient' => $request->input('ingre_main_product'),
                'skin' => $request->input('skin_product'),
                'stock' => $request->input('quantity_product'),
                'categories_id' => $request->input('cate_product'),
                'description' => $request->input('des_product'),
                'note' => $request->input('note_product'),
                'promotion_id' => $request->input('promotion_id'),
                'brand' => $request->input('brand_product'),
                'weight' => $request->input('weight_product'),
            ]);

            $product_id = $product->id;

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('product_images', 'public');  // lưu hình ảnh vào thư mục storage/app/public/product_images
                    ProductImage::create([
                        'product_id' => $product_id,
                        'image_path' => 'storage/' . $path,
                        'image_type' => $request->input('image_type'),
                    ]);
                }
            }

            DB::commit();

            return response()->json(['success', 'message' => 'Thêm sản phẩm thành công'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error', 'message' => 'Thêm sản phẩm thất bại: ' . $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_product' => 'required|string|max:255',
            'price_product' => 'required|numeric',
            'smell_product' => 'required|string',
            'texture_product' => 'required|string',
            'htu_product' => 'required|string',
            'all_ingredient_product' => 'required|string',
            'ingre_main_product' => 'required|string',
            'skin_product' => 'required|string',
            'quantity_product' => 'required|integer',
            'cate_product' => 'required|integer',
            'des_product' => 'required|string',
            'note_product' => 'required|string',
            'images.*' => 'required|image|mimes:webp|max:2048', // kiểm tra hình ảnh có đúng định dạng và dung lượng cụ thể là 2MB
            'image_type' => 'nullable|string',
            'promotion_id' => 'nullable|integer',
            'brand_product' => 'required|string',
            'weight_product' => 'required|string',
        ]);
        DB::beginTransaction();

        try {
            $product = Product::find($id);
            $product->name = $request->input('name_product');
            $product->price = $request->input('price_product');
            $product->smell = $request->input('smell_product');
            $product->texture = $request->input('texture_product');
            $product->htu = $request->input('htu_product');
            $product->ingredient = $request->input('all_ingredient_product');
            $product->main_ingredient = $request->input('ingre_main_product');
            $product->skin = $request->input('skin_product');
            $product->stock = $request->input('quantity_product');
            $product->categories_id = $request->input('cate_product');
            $product->description = $request->input('des_product');
            $product->note = $request->input('note_product');
            $product->promotion_id = $request->input('promotion_id');
            $product->brand = $request->input('brand_product');
            $product->weight = $request->input('weight_product');
            $product->save();

            $product_id = $id;

            if ($request->hasFile('images')) {
                // Xóa ảnh cũ liên quan đến sản phẩm
                ProductImage::where('product_id', $product_id)->delete();
            
                foreach ($request->file('images') as $image) {
                    $path = $image->store('product_images', 'public');  // lưu hình ảnh vào thư mục storage/app/public/product_images
                    ProductImage::create([
                        'product_id' => $product_id,
                        'image_path' => 'storage/' . $path,
                        'image_type' => $request->input('image_type'),
                    ]);
                }
            }
            DB::commit();

            return response()->json(['success', 'message' => 'Thêm sản phẩm thành công'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error', 'message' => 'Thêm sản phẩm thất bại: ' . $e->getMessage()], 500);
        }
    }
}
