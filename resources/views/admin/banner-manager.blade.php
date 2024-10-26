@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Banner manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
            <div>
                <button type="button" class="material-symbols-outlined" onclick="search('bannerTable')">search</button>
            </div>
            <div class="input" for="inputSearch">
                <input type="text" id="inputSearch" class="input_lable" placeholder="Tìm kiếm">
            </div>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" onclick="showTab('addBanner')"> Add new banner</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table id="bannerTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên banner</th>
                    <th>Hình ảnh</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Link liên kết</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($banners as $banner)
                <tr>
                    <td>{{ $banner->id }}</td>
                    <td>{{ $banner->title }}</td>
                    <td>
                        <div class="size_review_images">
                            <img src="{{ !empty($banner->images_path) ? asset($banner->images_path) : 'N/A' }}" />
                        </div>
                    </td>
                    <td>{{ $banner->start_date }}</td>
                    <td>{{ $banner->end_date }}</td>
                    <td>{{ $banner->link_to }}</td>
                    <td>
                        <button class="edit-button" onclick="showDetailBanner('{{ $banner->id }}')">
                            Chỉnh sửa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
    <div id="addBanner" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Thêm banner mới</h2>
            </div>
            <div class="modal-body">
                <p>Tên banner: <input id="titleBanner-input"></p>
                <p>Ngày bắt đầu: <input id="startDateBanner-input" type="date"></p>
                <p>Ngày kết thúc: <input id="endDateBanner-input" type="date"></p>
                <p>Link liên kết: <input id="linkToBanner-input"></p>
                <p>Hình ảnh:
                    <div class="list-image" id="listImageBanner-input">
                        <!--This is image of banner-->
                    </div>
                    <input type="file" id="imageInput-input" name="image" accept="image/*" style="display: none" onchange="handleFileSelect(event, 'listImageBanner-input')">
                    <button type="button" onclick="document.getElementById('imageInput-input').click()" class="button">
                        <div class="light-text">Thêm ảnh</div>
                    </button>
                    <a style="color:red;"> Vui lòng chọn duy nhất 1 ảnh</a>
                </p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="addBanner()" style="width:100%;">Tạo banner mới</button>
            </div>
        </div>
    </div>
    
    <div id="detailBanner" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Chỉnh sửa và chi tiết banner</h2>
            </div>
            <div class="modal-body">
                <p>ID: <span id="idBanner"></span></p>
                <p>Tên banner: <input id="titleBanner"></p>
                <p>Ngày bắt đầu: <input id="startDateBanner" type="date"></p>
                <p>Ngày kết thúc: <input id="endDateBanner" type="date"></p>
                <p>Link liên kết: <input id="linkToBanner"></p>
                <p>Hình ảnh:
                    <div class="list-image" id="listImageBanner">
                        <!--This is image of banner-->
                    </div>
                    <input type="file" id="imageInput" name="images[]" accept="image/*" multiple style="display: none" onchange="handleFileSelect(event, 'listImageBanner')">
                    <button type="button" onclick="document.getElementById('imageInput').click()" class="button">
                        <div class="light-text">Thêm ảnh</div>
                    </button>
                    <a style="color:red;"> Vui lòng chọn duy nhất 1 ảnh</a>
                </p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="updateBanner()" style="width:100%;">Lưu chỉnh sửa</button>
                <button class="button light-text" onclick="deleteBanner()" style="width:100%;">Xóa banner</button>
            </div>
        </div>
    </div>
</div> <!--container_cater-manager -->
<script src="{{asset('backend/js/banner.js')}}"></script>
@endsection