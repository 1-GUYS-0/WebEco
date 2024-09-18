<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị form thêm danh mục sản phẩm
    public function create()
    {
        $categories = Category::all();
        return view('admin.Catergory.add-category', ['categoriesIBL' => $categories]); // Trả về view form thêm danh mục
    }
    // Lấy data từ form
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'parent_category' => 'nullable|integer',
        ]);

        $category = new Category();
        $category->name = $request->input('category_name');
        $category->parent_category = $request->input('parent_category');
        $category->save();

        return response()->json(['success' => true]);
    }
}
