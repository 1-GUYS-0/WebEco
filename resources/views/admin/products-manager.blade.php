@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Products manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <button type="button" class="material-symbols-outlined" onclick="search('productTable')">search</button>
            </div>
            <div class="input" for="inputSearch">
                <input type="text" id="inputSearch" class="input_lable" placeholder="Tìm kiếm">
            </div>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" onclick="showTab('addProductTab')"> Add new product</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table id="productTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh sản phẩm</th>
                    <th>Tên danh mục sản phẩm</th>
                    <th>Giá ban đầu</th>
                    <th>Khuyến mãi</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name}}</td>
                    <td>
                        <div class="size_review_images">
                            <img src="{{ $product->images->isNotEmpty() ? asset($product->images->first()->image_path) : 'N/A' }}" /> <!--kiểm tra xem có tồn tại images không và có hình ảnh không-->
                        </div>
                    </td>
                    <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->promotion ? $product->promotion->name : 'N/A' }}</td>
                    @if ($product->promotion)
                    <td>{{ $product->price - ($product->price * $product->promotion->percent_promotion / 100) }}</td>
                    @else
                    <td>{{ $product->price }}</td>
                    @endif
                    <td>{{ $product->stock }}</td>
                    <td>
                        <button class="edit-button" onclick="showDetailProduct('{{ $product->id }}')">Chỉnh sửa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
    <div id="addProductTab" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Thêm sản phẩm mới</h2>
            </div>
            <div class="modal-body">
                <form id="productForm" class="form_add-product">
                    <div class="wrap_input">
                        <div class="input" for="nameProduct">
                            <div class="input_title">Tên sản phẩm</div>
                            <input type="text" id="nameProduct" name="nameProduct" class="input_lable" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="input" for="brandProduct">
                            <div class="input_title">Tên thương hiệu</div>
                            <input type="text" id="brandProduct" name="brandProduct" class="input_lable" placeholder="Nhập thương hiệu sản phẩm" required>
                        </div>
                        <div class="input" for="weightProduct">
                            <div class="input_title">Khối lượng sản phẩm</div>
                            <input type="text" id="weightProduct" name="weightProduct" class="input_lable" placeholder="Nhập khối lượng sản phẩm(gram)" required>
                        </div>
                        <div class="input" for="smellProduct">
                            <div class="input_title">Mùi hương</div>
                            <input type="text" id="smellProduct" name="smellProduct" class="input_lable" placeholder="Nhập mùi hương sản phẩm" required>
                        </div>
                        <div class="input" for="textureProduct">
                            <div class="input_title">Kết cấu</div>
                            <input type="text" id="textureProduct" name="textureProduct" class="input_lable" placeholder="Nhập kết cấu sản phẩm" required>
                        </div>
                        <div class="input" for="ingreMainProduct">
                            <div class="input_title">Thành phần chính</div>
                            <input type="text" id="ingreMainProduct" name="ingreMainProduct" class="input_lable" placeholder="Nhập thành phần chính" required>
                        </div>
                        <div class="input" for="skinProduct">
                            <div class="input_title">Loại da</div>
                            <input type="text" id="skinProduct" name="skinProduct" class="input_lable" placeholder="Nhập loại da phù hợp" required>
                        </div>
                        <div class="input" for="cateProduct">
                            <div class="input_title">Danh mục sản phẩm</div>
                            <select type="text" id="cateProduct" name="cateProduct" class="input_lable" required>
                                <option value="">Choose one category</option> <!-- Để trống -->
                                @foreach($categories as $category)
                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input" for="promotionProduct">
                            <div class="input_title">Sự kiện khuyến mãi</div>
                            <select type="text" id="promotionProduct" name="promotionProduct" class="input_lable">
                                <option value="">Choose one promotion</option> <!-- Để trống -->
                                @foreach($promotions as $promotion)
                                <option value="{{ $promotion['id'] }}">{{ $promotion['name'] }}--sale:{{ $promotion->percent_promotion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="div"></div>
                    <div class="input" for="detailProduct">
                        <div class="input_title">Mô tả sản phẩm</div>
                        <textarea type="text" id="detailProduct" name="detailProduct" class="input_lable" placeholder="Nhập mô tả sản phẩm" required></textarea>
                    </div>
                    <div class="input" for="notelProduct">
                        <div class="input_title">Lưu ý sản phẩm</div>
                        <textarea type="text" id="noteProduct" name="noteProduct" class="input_lable" placeholder="Nhập lưu ý sản phẩm" required></textarea>
                    </div>
                    <div class="input" for="allIngredientProduct">
                        <div class="input_title">Thành phần cụ thể sản phẩm</div>
                        <textarea type="text" id="allIngredientProduct" name="allIngredientProduct" class="input_lable" placeholder="Nhập thành phần cụ thể sản phẩm" required></textarea>
                    </div>
                    <div class="input" for="HTUProduct">
                        <div class="input_title">Hướng dẫn sử dụng</div>
                        <textarea type="text" id="HTUProduct" name="HTUProduct" class="input_lable" placeholder="Nhập hướng dẫn sử dụng sản phẩm" required></textarea>
                    </div>
                    <div class="div"></div>
                    <div class="input" for="stockProduct">
                        <div class="input_title">Số lượng sản phẩm</div>
                        <input type="text" id="quantityProduct" name="quantityProduct" class="input_lable" placeholder="Nhập số lượng sản phẩm" required>
                    </div>
                    <div class="input" for="priceProduct">
                        <div class="input_title">Giá sản phẩm</div>
                        <input type="text" id="priceProduct" name="priceProduct" class="input_lable" placeholder="Nhập giá sản phẩm" required>
                    </div>
                    <div class="div"></div>
                    <div class="input">
                        <div class="input_title">Ảnh của sản phẩm</div>
                        <div class="list-image" id="listImage">
                            <!--This is image of product-->
                        </div>
                        <input type="file" id="imageInput" name="images[]" accept="image/*" multiple style="display: none" onchange="handleFileSelect(event, 'listImage')" required>
                        <button type="button" onclick="document.getElementById('imageInput').click()" class="button">
                            <div class="light-text" required>Thêm ảnh</div>
                        </button>
                        <a style="color:red;"> Vui lòng chọn ít nhất 1 ảnh</a>
                        <!--button thêm ảnh-->
                    </div>
                    <div class="div"></div>
                    <div class="confirm">
                        <button type="submit" class="button light-text" onclick="addProduct()">Thêm sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="detailProductTab" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Chỉnh sửa chi tiết sản phẩm</h2>
            </div>
            <div class="modal-body">
                <form id="updateproductForm" class="form_add-product">
                    <div id="idProduct-input" value="" placeholder="ID" hidden></div>
                    <div> Tên sản phẩm: <input type="text" id="nameProduct-input" value=""> </div>
                    <div> Tên thương hiệu: <input type="text" id="brandProduct-input" value=""> </div>
                    <div> Khối lượng sản phẩm: <input type="text" id="weightProduct-input" value=""> </div>
                    <div> Mùi hương: <input type="text" id="smellProduct-input" value=""> </div>
                    <div> Kết cấu: <input type="text" id="textureProduct-input" value=""> </div>
                    <div> Thành phần chính: <input type="text" id="ingreMainProduct-input" value=""> </div>
                    <div> Loại da: <input type="text" id="skinProduct-input" value=""> </div>
                    <div> Danh mục sản phẩm:
                        <select id="cateProduct-input">
                            <option value=""></option> <!-- Để trống -->
                            @foreach($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div> Sự kiện khuyến mãi:
                        <select id="promotionProduct-input">
                            <option value="">Không có</option> <!-- Để trống -->
                            @foreach($promotions as $promotion)
                            <option value="{{ $promotion['id'] }}">{{ $promotion['name'] }}--sale:{{ $promotion->percent_promotion}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div> Mô tả sản phẩm: <textarea id="detailProduct-input"></textarea> </div>
                    <div> Lưu ý sản phẩm: <textarea id="noteProduct-input"></textarea> </div>
                    <div> Thành phần cụ thể sản phẩm: <textarea id="allIngredientProduct-input"></textarea> </div>
                    <div> Hướng dẫn sử dụng: <textarea id="HTUProduct-input"></textarea> </div>
                    <div> Số lượng sản phẩm trong kho: <input type="text" id="quantityProduct-input" value=""> </div>
                    <div> Giá sản phẩm ban đầu: <input type="text" id="priceProduct-input" value=""> </div>
                    <div> Ảnh của sản phẩm:
                        <div class="list-image" id="listImage-input">
                            <!--This is image of product-->
                        </div>
                        <input type="file" id="imageInput-input" name="images[]" accept="image/*" multiple style="display: none" onchange="handleFileSelect(event, 'listImage-input')">
                        <button type="button" onclick="document.getElementById('imageInput-input').click()" class="button">
                            <div class="light-text">Thêm ảnh</div>
                        </button>
                    </div>
                    <div class="modal-body">
                        <button class="button light-text" onclick="updateProduct()" style="width:100%;">Lưu chỉnh sửa</button>
                        <button class="button light-text" onclick="deleteProduct()" style="width:100%;">Xóa sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!--container_cater-manager -->
<script src="{{ asset('backend/js/product.js') }}"></script>
@endsection