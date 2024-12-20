<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị danh sách danh mục sản phẩm
    public function show()
    {
        $categories = Category::all();
        return view('admin.catergories-manager', ['categoriesIBL' => $categories]); // Trả về view danh sách danh mục and truyền biến categoriesIBL chứa danh sách danh mục
    }
    // Hiển thị form thêm danh mục sản phẩm
    public function create()
    {
        $categories = Category::all();
        return view('admin.Catergory.add-category', ['categoriesIBL' => $categories]); // Trả về view form thêm danh mục and truyền biến categoriesIBL chứa danh sách danh mục
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
    //
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Không tìm thấy danh mục'], 404);
        }

        $category->delete();

        return response()->json(['success' => 'Đã xóa danh mục']);
    }
    // Chỉnh sửa các thông tin mới của danh mục
    public function edit(Request $request , $id)
    {
    
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['error' => 'Không tìm thấy danh mục'], 404);
        }
        // Thay đổi hai thông tin name và parent_category của danh mục có id = $id
        $category->name = $request->input('name');
        $category->parent_category = $request->input('parent');
        $category->save();
        return response()->json(['success' => 'Đã cập nhật danh mục']);
    }
}
