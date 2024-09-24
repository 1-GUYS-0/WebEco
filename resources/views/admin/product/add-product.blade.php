@extends('admin.part.layout-app')
@section('content')

<div class="container_add-product">
    <div class="title_feature">
        <p class="body-bold">Add Products</p>
    </div>
    <form id="productForm" class="form_add-product">
        <div class="wrap_input">
            <div class="input" for="nameProduct">
                <div class="input_title">Tên sản phẩm</div>
                <input type="text" id="nameProduct" class="input_lable" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="input" for="smellProduct">
                <div class="input_title">Mùi hương</div>
                <input type="text" id="smellProduct" class="input_lable" placeholder="Nhập mùi hương sản phẩm">
            </div>
            <div class="input" for="textureProduct">
                <div class="input_title">Kết cấu</div>
                <input type="text" id="textureProduct" class="input_lable" placeholder="Nhập kết cấu sản phẩm">
            </div>
            <div class="input" for="ingreMainProduct">
                <div class="input_title">Thành phầm chính</div>
                <input type="text" id="ingreMainProduct" class="input_lable" placeholder="Nhập thành phần chính">
            </div>
            <div class="input" for="skinProduct">
                <div class="input_title">Loại da</div>
                <input type="text" id="skinProduct" class="input_lable" placeholder="Nhập loại da phù hợp">
            </div>
            <div class="input" for="cateProduct">
                <div class="input_title">Danh mục sản phẩm</div>
                <select type="text" id="cateProduct" class="input_lable">
                    <option value="">Choose one category</option> <!-- Để trống -->
                    @foreach($categoriesIBL as $category)
                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="div"></div>
        <div class="input" for="detailProduct">
            <div class="input_title">Mô tả sản phẩm</div>
            <textarea type="text" id="detailProduct" class="input_lable" placeholder="Nhập mô tả sản phẩm"></textarea>
        </div>
        <div class="input" for="notelProduct">
            <div class="input_title">Lưu ý sản phẩm</div>
            <textarea type="text" id="noteProduct" class="input_lable" placeholder="Nhập lưu ý sản phẩm"></textarea>
        </div>
        <div class="input" for="allIngredientProduct">
            <div class="input_title">Thành phần cụ thể sản phẩm</div>
            <textarea type="text" id="allIngredientProduct" class="input_lable" placeholder="Nhập thành phần cụ thể sản phẩm"></textarea>
        </div>
        <div class="input" for="HTUProduct">
            <div class="input_title">Hướng dẫn sử dụng</div>
            <textarea type="text" id="HTUProduct" class="input_lable" placeholder="Nhập hướng dẫn sử dụng sản phẩm"></textarea>
        </div>
        <div class="div"></div>
        <div class="input" for="stockProduct">
            <div class="input_title">Số lượng sản phẩm</div>
            <input type="text" id="quantityProduct" class="input_lable" placeholder="Nhập số lượng sản phẩm">
        </div>
        <div class="input" for="priceProduct">
            <div class="input_title">Giá sản phẩm</div>
            <input type="text" id="priceProduct" class="input_lable" placeholder="Nhập giá sản phẩm">
        </div>
        <div class="div"></div>
        <div class="input">
            <div class="input_title">Ảnh của sản phẩm</div>
            <div class="list-image" id="listImage">
                <!--This is image of product-->
            </div>
            <input type="file" id="imageInput" accept="image/*" multiple style="display: none">
            <button type="button" onclick="document.getElementById('imageInput').click()" class="button">
                <div class="light-text">Thêm ảnh</div>
            </button>
            <!--button thêm ảnh-->
        </div>
        <div class="div"></div>
        <div class="confirm">
            <button type="submit" class="button light-text">Xác nhận gữi</button>
        </div>
    </form>
</div>
<script>
    const addProductUrl = "{{ route('products.add-product') }}";
</script>
<script src="{{asset('backend/js/products/add-products-ajax.js')}}" defer></script>
@endsection