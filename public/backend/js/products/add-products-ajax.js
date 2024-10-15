$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Cài đặt token CSRF cho các yêu cầu AJAX

$(document).ready(function () {
    $('#productForm').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form reload trang

        // Lấy data từ các id
        const nameProduct = $('#nameProduct').val();
        const priceProduct = $('#priceProduct').val();
        const smellProduct = $('#smellProduct').val();
        const textureProduct = $('#textureProduct').val();
        const ingreMainProduct = $('#ingreMainProduct').val();
        const skinProduct = $('#skinProduct').val();
        const cateProduct = $('#cateProduct').val();
        const detailProduct = $('#detailProduct').val();
        const noteProduct = $('#noteProduct').val();
        const allIngredientProduct = $('#allIngredientProduct').val();
        const htuProduct = $('#HTUProduct').val();
        const quantityProduct = $('#quantityProduct').val();

        // Validate dữ liệu
        if (!nameProduct) {
            alert('Vui lòng nhập tên sản phẩm.');
            return;
        }
        if (!priceProduct || isNaN(priceProduct) || priceProduct <= 0) {
            alert('Vui lòng nhập giá sản phẩm hợp lệ.');
            return;
        }
        if (!smellProduct) {
            alert('Vui lòng nhập mùi hương của sản phẩm.');
            return;
        }
        if (!textureProduct) {
            alert('Vui lòng nhập kết cấu của sản phẩm.');
            return;
        }
        if (!ingreMainProduct) {
            alert('Vui lòng nhập thành phần chính của sản phẩm.');
            return;
        }
        if (!skinProduct) {
            alert('Vui lòng nhập loại da phù hợp với sản phẩm.');
            return;
        }
        if (!cateProduct) {
            alert('Vui lòng chọn danh mục sản phẩm.');
            return;
        }
        if (!detailProduct) {
            alert('Vui lòng nhập chi tiết sản phẩm.');
            return;
        }
        if (!noteProduct) {
            alert('Vui lòng nhập ghi chú sản phẩm.');
            return;
        }
        if (!allIngredientProduct) {
            alert('Vui lòng nhập tất cả thành phần của sản phẩm.');
            return;
        }
        if (!htuProduct) {
            alert('Vui lòng nhập hướng dẫn sử dụng sản phẩm.');
            return;
        }
        if (!quantityProduct || isNaN(quantityProduct) || quantityProduct <= 0) {
            alert('Vui lòng nhập số lượng sản phẩm hợp lệ.');
            return;
        }

        // Tạo đối tượng FormData để gửi dữ liệu sản phẩm và hình ảnh
        const formData = new FormData();
        formData.append('name_product', nameProduct);
        formData.append('price_product', priceProduct);
        formData.append('smell_product', smellProduct);
        formData.append('texture_product', textureProduct);
        formData.append('ingre_main_product', ingreMainProduct);
        formData.append('skin_product', skinProduct);
        formData.append('cate_product', cateProduct);
        formData.append('detail_product', detailProduct);
        formData.append('note_product', noteProduct);
        formData.append('all_ingredient_product', allIngredientProduct);
        formData.append('htu_product', htuProduct);
        formData.append('quantity_product', quantityProduct);

        // Thêm hình ảnh vào FormData
        const files = $('#imageInput')[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        formData.append('image_type', "product");
        console.log(formData);
        // AJAX request để lưu thông tin sản phẩm và hình ảnh
        $.ajax({
            url: addProductUrl, // URL gửi dữ liệu được lấy từ biến trong file blade tương ứng
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert('Sản phẩm và ảnh đã được thêm thành công!');
                    console.log(response);
                    $('#productForm')[0].reset(); // Reset form sau khi gửi thành công
                    $('#listImage').empty(); // Xóa danh sách hình ảnh đã hiển thị
                }
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra trong quá trình gửi dữ liệu sản phẩm.');
                console.log(xhr.responseText);
            }
        });
    });
});

