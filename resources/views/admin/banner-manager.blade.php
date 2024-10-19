@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Banner manager</p>
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
                <a class="light-text" onclick="showTab('addBanner')"> Add new catergory</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên banner</th>
                    <th>hình ảnh</th>
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
                    <td>{{ $banner->title}}</td>
                    <td>
                        <div class="size_review_images">
                            <img src=" {{ !empty($banner->images_path) ? asset($banner->images_path) : 'N/A' }} " /> <!--kiểm tra xem có tồn tại images không và có hình ảnh không-->
                        </div>
                    </td>
                    <td>{{ $banner->start_date}}</td>
                    <td>{{ $banner->start_date }}</td>
                    <td>{{ $banner->link_to}}</td>
                    <td>
                        <button class="edit-button" onclick="showTab('detailBanner','{{json_encode( $banner)}}')">
                            Chỉnh sửa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
    <div id="detailBanner" class="tab">
        <div class="modal-content">
            <form id="detailBannerForm" class="form_add-product">
                <span class="close-btn">&times;Thoát</span>
                <h2>Chỉnh sửa và chi tiết banner</h2>
                <input id="idBanner" name="id_banner" value="" hidden>
                <div> Tên banner: <input type="text" id="titleBanner" name="title_banner" value=""> </div>
                <div> Ngày bắt đầu: <input type="date" id="startDateBanner" name="start-date_banner" value=""> </div>
                <div> Ngày kết thúc: <input type="date" id="endDateBanner" name="end-date_banner" value=""> </div>
                <div> Link liên kết: <input type="text" id="linkToBanner" name="link_banner" value=""> </div>
                <div> Hình ảnh:
                    <div class="list-image" id="listImageBanner">
                        <!--This is image of banner-->
                    </div>
                    <input type="file" id="imageInput" name="images[]" accept="image/*" multiple style="display: none"  onchange="handleFileSelect(event, 'listImageBanner')">
                    <button type="button" onclick="document.getElementById('imageInput').click()" class="button">
                        <div class="light-text">Thêm ảnh</div>
                    </button>
                    <a style="color:red;"> Vui lòng chọn duy nhất 1 ảnh</a>
                </div>
                <button class="button light-text" onclick=" updateBanner()" style="width:100%;">Lưu chỉnh sửa</button>
                <button class="button light-text" onclick="deleteCategory()" style="width:100%;">Xóa danh mục</button>
            </form>
        </div>
    </div>
    <div id="addBanner" class="tab">
        <div class="modal-content">
            <form id="addBannerForm" class="form_add-product">
                <span class="close-btn">&times;Thoát</span>
                <h2>Thêm banner mới</h2>

                <div> Tên banner: <input type="text" id="titleBanner-input" name="title_banner" value=""> </div>
                <div> Ngày bắt đầu: <input type="date" id="startDateBanner-input" name="start-date_banner" value=""> </div>
                <div> Ngày kết thúc: <input type="date" id="endDateBanner-input" name="end-date_banner" value=""> </div>
                <div> Link liên kết: <input type="text" id="linkToBanner-input" name="link_banner" value=""> </div>
                <div> Hình ảnh:
                    <div class="list-image" id="listImageBanner-input">
                        <!--This is image of banner-->
                    </div>
                    <input type="file" id="imageInput-input" name="image" accept="image/*" style="display: none"  onchange="handleFileSelect(event, 'listImageBanner-input')">
                    <button type="button" onclick="document.getElementById('imageInput-input').click()" class="button">
                        <div class="light-text">Thêm ảnh</div>
                    </button>
                    <a style="color:red;"> Vui lòng chọn duy nhất 1 ảnh</a>
                </div>
                <button class="button light-text" onclick=" addBanner() " style="width:100%;">Tạo banner mới</button>
            </form>
        </div>
    </div>
</div> <!--container_cater-manager -->
<script src="{{asset('backend/js/banner.js')}}"></script>
@endsection