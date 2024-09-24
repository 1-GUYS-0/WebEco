@extends('admin.part.layout-app')
@section('content')
<div class="container_add-product">
    <div class="title_feature">
        <p class="body-bold">Add Catergory</p>
    </div>
    <div class="form_add-product">
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
<script>
    const addCategoryUrl = "{{ route('categories.add-category') }}";
</script>
<script src="{{asset('backend/js/catergories/add-catergory-ajax.js')}}" defer></script>

@endsection