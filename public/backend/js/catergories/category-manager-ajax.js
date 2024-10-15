$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Cài đặt token CSRF cho các yêu cầu AJAX

function showTab(idTab, dataCategoryJson) {
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    if (idTab === 'detailCategory' && Object.keys(dataCategoryJson).length > 0) {
        editCategory(dataCategoryJson);
        // Hiển thị modal
        modal.style.display = 'block';
    }
    if (idTab === 'addCategory') {
        // Hiển thị modal
        modal.style.display = 'block';
    }
    // Đóng modal khi nhấn vào nút đóng
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    });

    // Đóng modal khi nhấn ra ngoài modal
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}
function editCategory(dataCategoryJson) {
    const dataCategory = JSON.parse(dataCategoryJson);
    const name = document.getElementById('category-name');
    const parent = document.getElementById('category-parent');
    const id = document.getElementById('category-id');
    // Điền các giá trị của danh mục vào các trường trong tab editDetail
    name.value = dataCategory.name;
    parent.value = dataCategory.parent_category;
    id.value = dataCategory.id;
}
// Hàm xác nhận xóa danh mục
function deleteCategory() {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) {
        const idCategory = document.getElementById('category-id').value;
        $.ajax({
            url: `/admin/categories/delete-category/${idCategory}`,
            method: 'POST',
            success: function (response) {
                if (response.success) {
                    alert(response.success);
                    location.reload(); // Reload lại toàn bộ trang sau khi xóa thành công
                } else {
                    alert(response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred while deleting the category.');
            }
        });
    }
}
// Hàm xác nhận lưu danh mục đã chỉnh sửa
function saveEditCategory() {
    const idCategory = document.getElementById('category-id').value;
    const name = document.getElementById('category-name').value;
    const parent = document.getElementById('category-parent').value;
    $.ajax({
        url: `/admin/categories/edit-category/${idCategory}`,
        method: 'POST',
        data: {
            name: name,
            parent: parent
        },
        success: function (response) {
            if (response.success) {
                alert(response.success);
                location.reload(); // Reload lại toàn bộ trang sau khi lưu thành công
            } else {
                alert(response.error);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while saving the category.');
        }
    });
}
// Hàm tạo mới danh mục
$(document).ready(function () {
    $('#categoryForm').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form reload trang
        //Lấy data từ các id
        const categoryName = $('#category_name').val();
        const parentCategory = $('#parent_category').val();
        // Tạo đối tượng chứa dữ liệu từ các trường input
        const formData = {
            category_name: categoryName,
            parent_category: parentCategory,
        };

        // AJAX request
        $.ajax({
            url: `/admin/categories/add-category`, // URL gửi dữ liệu được lấy từ biến trong file blade tương ứng
            method: 'POST',
            contentType: 'application/json', // Thiết lập Content-Type là application/json
            data: JSON.stringify(formData), // Chuyển đối tượng thành chuỗi JSON
            success: function (response) {
                alert('Dữ liệu đã được gửi thành công!');
                console.log(response);
                location.reload(); // Reload lại toàn bộ trang sau khi xóa thành công
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra trong quá trình gửi dữ liệu.');
                console.log(xhr.responseText);
            }
        });
    });
});


