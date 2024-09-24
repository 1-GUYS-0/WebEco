<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
            'detail_product' => 'required|string',
            'note_product' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_type' => 'nullable|string',
        ]);

        // Lưu thông tin sản phẩm
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
            'description' => $request->input('detail_product'),
            'note' => $request->input('note_product'),
        ]);

        // Lấy product_id của sản phẩm vừa được lưu
        $product_id = $product->id;

        // Lưu hình ảnh sản phẩm
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');  // lưu hình ảnh vào thư mục storage/app/public/product_images
                ProductImage::create // tạo mới bản ghi trong bảng product_images
                ([
                    'product_id' => $product_id,
                    'image_path' => $path, // lấy đường dẫn hình ảnh đã lưu từ storage public
                    'image_type' => $request->input('image_type'),
                ]);
            }
        }

        return response()->json(['success' => true, 'product_id' => $product_id]);
    }
}
