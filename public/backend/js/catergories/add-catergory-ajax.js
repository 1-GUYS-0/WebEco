$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Cài đặt token CSRF cho các yêu cầu AJAX

$(document).ready(function () {
    $('#categoryForm').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form reload trang
        //Lấy data từ các id
        const categoryName=$('#category_name').val();
        const parentCategory=$('#parent_category').val();
        // Tạo đối tượng chứa dữ liệu từ các trường input
        const formData = {
            category_name: categoryName,
            parent_category: parentCategory,
        };

        // AJAX request
        $.ajax({
            url: addCategoryUrl, // URL gửi dữ liệu được lấy từ biến trong file blade tương ứng
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