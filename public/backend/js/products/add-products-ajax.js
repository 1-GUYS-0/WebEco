$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Cài đặt token CSRF cho các yêu cầu AJAX

$(document).ready(function () {
    $('#productForm').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form reload trang
        //Lấy data từ các id
        const nameProduct = $('#nameProduct').val();
        const priceProduct = $('#priceProduct').val();
        const smellProduct = $('#smellProduct').val();
        const textureProduct = $('#textureProduct').val();
        const ingreMainProduct = $('#ingreMainProduct').val();
        const skinProduct = $('#skinProduct').val();
        const cateProduct = $('#cateProduct').val();
        const parentCateProduct = $('#parentCateProduct').val();
        const detailProduct = $('#detailProduct').val();
        const noteProduct = $('#noteProduct').val();
        const specificDetailProduct = $('#specificDetailProduct').val();
        // Tạo đối tượng chứa dữ liệu từ các trường input
        const formData = {
            name_product: nameProduct,
            price_product: priceProduct,
            smell_product: smellProduct,
            texture_product: textureProduct,
            ingre_main_product: ingreMainProduct,
            skin_product: skinProduct,
            cate_product: cateProduct,
            parent_cate_product: parentCateProduct,
            detail_product: detailProduct,
            note_product: noteProduct,
            specific_detail_product: specificDetailProduct
        };
        console.log(formData);
        // AJAX request
        $.ajax({
            url: addProductUrl, // URL gửi dữ liệu được lấy từ biến trong file blade tương ứng
            method: 'POST',
            contentType: 'application/json', // Thiết lập Content-Type là application/json
            data: JSON.stringify(formData), // Chuyển đối tượng thành chuỗi JSON
            success: function (response) {
                alert('Dữ liệu đã được gửi thành công!');
                console.log(response);
                $('#categoryForm').load(location.href + ' #categoryForm');
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra trong quá trình gửi dữ liệu.');
                console.log(xhr.responseText);
            }
        });
    });
});
// Thêm hình ảnh
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('imageInput').addEventListener('change', function (event) {
        const file = event.target.files[0]; // Lấy tệp đầu tiên từ danh sách các tệp đã chọn
        if (file) {
            const reader = new FileReader(); // Tạo một đối tượng FileReader để chuẩn bị đọc tệp
            reader.onload = function(e) { //lắng nghe sự kiện reader.readAsDataURL hoàn thành khi tệp đã được đọc mới thực thi
                const listImage = document.getElementById('listImage'); // Lấy phần tử danh sách hình ảnh
                const newImageBlock = document.createElement('div'); // Tạo một khối hình ảnh mới
                newImageBlock.className = 'image-block';
                newImageBlock.innerHTML = `
                    <img class="cards-image" src="${e.target.result}" />
                    <div class="close-icon">
                        <button type="button" class="material-symbols-outlined" onclick="removeImage(this)">close</button>
                    </div>
                `;
                listImage.appendChild(newImageBlock); // Thêm khối hình ảnh mới vào danh sách
            };
            reader.readAsDataURL(file); // mã hóa dữ liệu tệp thành chuỗi base64 để web Đọc tệp dưới dạng URL dữ liệu tức
        }
    });
});
// Xóa hình ảnh
function removeImage(button) {
    const imageBlock = button.closest('.image-block');
    imageBlock.remove();
}