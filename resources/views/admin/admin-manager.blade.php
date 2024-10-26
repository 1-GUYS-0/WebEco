@extends('admin.part.layout-app')
@section('content')
<div class="container_cater-manager">
    <div class="title_feature">
        <p class="body-bold">Admin manager</p>
    </div> <!--tittle của chức năng-->
    <div class="search-box">
        <div class="search-bar">
        <div>
                <button type="button" class="material-symbols-outlined" onclick="search('adminTable')">search</button>
            </div>
            <div class="input" for="inputSearch">
                <input type="text" id="inputSearch" class="input_lable" placeholder="Tìm kiếm">
            </div>
        </div>
        <div class="new-catergory">
            <button type="button" class="button">
                <a class="light-text" onclick="showTab('addAdmin')"> Add new Admin</a>
            </button>
        </div>
    </div> <!-- thanh search-->
    <div class=" container-table">
        <table id="adminTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên nhận viên</th>
                    <th>email</th>
                    <th>Chức vụ</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                <tr>
                    <td>{{ $admin->id }}</td>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email}}</td>
                    <td>{{ $admin->role}}</td>
                    <td>
                        <button class="edit-button" onclick="showTab('detailAdmin','{{ $admin->id }}')">
                            Chỉnh sửa
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table><!--bảng data-->
    </div>
    <div class="div black"></div>
    <div id="addAdmin" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Add new Admin</h2>
            </div>
            <div class="modal-body">
                <p>Tên nhân viên: <input id="admin-name-add"></p>
                <p>Email: <input id="admin-email-add" autocomplete="new-email"></p>
                <p>Mật khẩu: <input id="admin-password-add" type="password" autocomplete="new-password"></p>
                <p>Chức vụ:
                    <select id="admin-role-add">
                        <option value="admin">Admin</option>
                        <option value="sale">Sale</option>
                    </select>
                </p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="addAdmin()" style="width:100%;">Thêm Admin</button>
            </div>
        </div>
    </div>

    <div id="detailAdmin" class="tab">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close-btn">&times;Thoát</span>
                <h2>Detail Admin</h2>
            </div>
            <div class="modal-body">
                <p>ID: <span id="admin-id"></span></p>
                <p>Tên nhân viên: <input id="admin-name"></p>
                <p>Email: <input id="admin-email"></p>
                <p>Chức vụ: 
                    <select id="admin-role">
                        <option value="admin">Admin</option>
                        <option value="sale">Sale</option>
                    </select>
                </p>
            </div>
            <div class="modal-body">
                <button class="button light-text" onclick="updateAdmin()" style="width:100%;">Lưu chỉnh sửa</button>
                <button class="button light-text" onclick="deleteAdmin()" style="width:100%;">Xóa Admin</button>
            </div>
        </div>
    </div>

</div> <!--container_cater-manager -->
@endsection
<script src="{{asset('backend/js/admin.js')}}"></script>