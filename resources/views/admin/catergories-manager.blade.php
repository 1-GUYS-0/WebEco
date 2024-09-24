@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Add Catergories</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <span class="material-symbols-outlined">search</span>
            </div>
            <form class="input" for="searchCatergpry">
                <input type="text" id="searchCatergpry" class="input_lable" placeholder="Search for catergory">
            </form>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" href="{{ route('categories.view_add-category') }}"> Add new catergory</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <table>
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
                    <a href="{{ route('categories.view_edit-category', ['id' => $category['id']]) }}" class="dark-text">Edit</a>
                    <button class="dark-text delete-category" data-id="{{ $category['id'] }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table><!--bảng data-->
    <div class="div black"></div>
</div> <!--container_cater-manager -->
<script src="{{asset('backend/js/catergories/category-manager-ajax.js')}}" defer></script>
@endsection