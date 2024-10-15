@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Add Catergories</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <span class="material-symbols-outlined" onclick="search('categoryTable')">search</span>
            </div>
            <div class="input" for="inputSearch">
                <input type="text" id="inputSearch" class="input_lable" placeholder="Search for catergory">
            </div>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" onclick="showTab('addCategory',{})"> Add new catergory</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <table id="categoryTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>ID danh mục cha tương ứng</th>
                <th>Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categoriesIBL as $category)
            <tr>
                <td>{{ $category['id'] }}</td>
                <td>{{ $category['name'] }}</td>
                <td>{{ $category['parent_category'] }}</td>
                <td>
                    <button class="edit-button" onclick="showTab('detailCategory', '{{ json_encode($category) }}')">Chỉnh sửa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table><!--bảng data-->
    <div class="div black"></div>

    <div id="detailCategory" class="tab">
        <div class="modal-content">
            <span class="close-btn">&times;Thoát</span>
            <h2>Chi tiết danh mục</h2>
            <div id="category-id" value="{{ $category['id'] }}" placeholder="ID" hidden></div>
            <div> Tên danh mục: <input id="category-name" value="" placeholder="Tên danh mục"> </div>
            <div> Tên danh mục cha: <input id="category-parent" value="" placeholder="Tên danh mục cha"> </div>
            <button type class="button light-text" onclick="saveEditCategory()">Lưu chỉnh sửa</button>
            <button class="button light-text" onclick="deleteCategory()">Xóa danh mục</button>
            </tr>
        </div>
    </div>
    <div id="addCategory" class="tab">
        <div class="modal-content">
            <span class="close-btn">&times;Thoát</span>
            <h2>Thêm danh mục</h2>
            <form id="categoryForm" class="form_add-product">
                <div class="wrap_input">
                    <div class="input">
                        <div class="input_title">Tên danh mục</div>
                        <input type="text" id="category_name" name="category_name" class="input_lable" placeholder="Nhập tên danh mục sản phẩm">
                    </div>
                    <div class="input">
                        <div class="input_title">Tên danh mục cha thuộc về</div>
                        <select id="parent_category" name="parent_category" class="input_lable">
                            <option value="">No Parent</option> <!-- Để trống -->
                            @foreach($categoriesIBL as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="div"></div>
                <div class="confirm">
                    <button type="submit" class="button light-text">Xác nhận gữi</button>
                </div>
            </form>
        </div>
    </div>
</div> <!--container_cater-manager -->
<script src="{{asset('backend/js/catergories/category-manager-ajax.js')}}" defer></script>
@endsection