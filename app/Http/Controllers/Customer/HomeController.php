<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy 3 sản phẩm đầu tiên
        $Products = Product::with('images')->paginate(3);
        // Lấy banner hiển thị
        $Banners =
            Banner::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        // Truyền dữ liệu đến view
        return view('customer.pages.index', compact('Banners', 'Products'));
    }

    public function loadMorePd(Request $request)
    {
        if ($request->ajax()) {
            // Lấy thêm 3 sản phẩm tiếp theo
            $Products = Product::with('images','promotion')->paginate(3, ['*'], 'page', $request->page); // page là tên của query string(bắt đầu bằng dấu ?) trên URL khi phân trang ajax (xem file load-more.js)
            

            //Trả về dữ liệu dưới dạng HTML
            $html = view('customer.partials.product.load-more', compact('Products'))->render(); // view('customer.partials.product.load-more') là view chứa HTML của sản phẩm, compact('products') là dữ liệu truyền vào view đó render() là phương thức chuyển view thành chuỗi HTML

            return $html;
        }
        return response()->json(['error' => 'Invalid request'], 400);
    }
    
    public function getInterestedProducts(Request $request)
    {
        $productIds = $request->input('productIds');
        // Giả sử bạn có logic để tìm sản phẩm liên quan dựa trên danh sách productIds
        $relatedProducts = Product::with('images')->whereIn('id', $productIds)->get();
        return response()->json(['products' => $relatedProducts]);
    }
    public function aboutUs()
    {
        return view('customer.pages.about-us');
    }
    public function guide()
    {
        return view('customer.pages.guide');
    }
}
