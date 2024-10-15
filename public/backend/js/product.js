$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function showTab(idTab, productJson, categoriesJson, promotionsJson) {
    console.log(promotionsJson);
    console.log(idTab);
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    if (idTab === 'detailProduct' && Object.keys(productJson).length > 0 && Object.keys(categoriesJson).length > 0) {
        showDetailProduct(productJson, categoriesJson, promotionsJson);
        // Hiển thị modal
        modal.style.display = 'block';
    }
    if (idTab === 'addProduct') {
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
// hàm thêm hình ảnh
function handleFileSelect(event, listImageId) {
    const files = event.target.files; // Lấy danh sách các tệp đã chọn
    if (files) {
        for (let i = 0; i < files.length; i++) {
            const file = files[i]; // Lấy từng tệp trong danh sách
            const reader = new FileReader(); // Tạo một đối tượng FileReader để chuẩn bị đọc tệp
            reader.onload = function (e) { // Lắng nghe sự kiện reader.readAsDataURL hoàn thành khi tệp đã được đọc mới thực thi
                const listImage = document.getElementById(listImageId); // Lấy phần tử danh sách hình ảnh theo ID
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
            reader.readAsDataURL(file); // Mã hóa dữ liệu tệp thành chuỗi base64 để web đọc tệp dưới dạng URL dữ liệu
        }
    }
}
// Xóa hình ảnh
function removeImage(button) {
    const imageBlock = button.closest('.image-block');
    imageBlock.remove();
}

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
        const desProduct = $('#desProduct').val();
        const noteProduct = $('#noteProduct').val();
        const allIngredientProduct = $('#allIngredientProduct').val();
        const htuProduct = $('#HTUProduct').val();
        const quantityProduct = $('#quantityProduct').val();
        const promotionProduct = $('#promotionProduct').val();
        const brandProduct = $('#brandProduct').val();
        const weightProduct = $('#weightProduct').val();
        // Tạo đối tượng FormData để gửi dữ liệu sản phẩm và hình ảnh
        const formData = new FormData();
        formData.append('name_product', nameProduct);
        formData.append('price_product', priceProduct);
        formData.append('smell_product', smellProduct);
        formData.append('texture_product', textureProduct);
        formData.append('ingre_main_product', ingreMainProduct);
        formData.append('skin_product', skinProduct);
        formData.append('cate_product', cateProduct);
        formData.append('des_product', desProduct);
        formData.append('note_product', noteProduct);
        formData.append('all_ingredient_product', allIngredientProduct);
        formData.append('htu_product', htuProduct);
        formData.append('quantity_product', quantityProduct);
        formData.append('promotion_id',promotionProduct);
        formData.append('brand_product',brandProduct);
        formData.append('weight_product',weightProduct);

        // Thêm hình ảnh vào FormData
        const files = $('#imageInput-input')[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        formData.append('image_type', "product");
        console.log(formData);
        // AJAX request để lưu thông tin sản phẩm và hình ảnh
        $.ajax({
            url: `/admin/products/add-product`, // URL gửi dữ liệu được lấy từ biến trong file blade tương ứng
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert(response.success);
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

function showDetailProduct(productJson, categoriesJson, promotionsJson) {
    const product = JSON.parse(productJson);
    console.log(product);
    const categories = JSON.parse(categoriesJson);
    console.log(categories);
    console.log(promotionsJson);
    const promotions = JSON.parse(promotionsJson);

    // Hiển thị thông tin sản phẩm
    document.getElementById('idProduct-input').value = product.id;
    document.getElementById('nameProduct-input').value = product.name;
    document.getElementById('brandProduct-input').value = product.brand;
    document.getElementById('weightProduct-input').value = product.weight;
    document.getElementById('smellProduct-input').value = product.smell;
    document.getElementById('textureProduct-input').value = product.texture;
    document.getElementById('ingreMainProduct-input').value = product.main_ingredient;
    document.getElementById('skinProduct-input').value = product.skin;
    document.getElementById('detailProduct-input').value = product.description;
    document.getElementById('noteProduct-input').value = product.note;
    document.getElementById('allIngredientProduct-input').value = product.ingredient;
    document.getElementById('HTUProduct-input').value = product.htu;
    document.getElementById('quantityProduct-input').value = product.stock;
    document.getElementById('priceProduct-input').value = product.price;

    // Cập nhật danh mục sản phẩm
    const cateProductSelect = document.getElementById('cateProduct-input');
    cateProductSelect.innerHTML = categories.map(category => 
        `<option value="${category.id}" ${category.id === product.category_id ? 'selected' : ''}>${category.name}</option>`
    ).join('');

    // Cập nhật sự kiện khuyến mãi
    const promotionProductSelect = document.getElementById('promotionProduct-input');
    promotionProductSelect.innerHTML = promotions.map(promotion => 
        `<option value="${promotion.id}" ${promotion.id === product.promotion_id ? 'selected' : ''}>${promotion.name}--sale:${promotion.percent_promotion}</option>`
    ).join('');

    // Cập nhật hình ảnh sản phẩm
    const listImage = document.getElementById('listImage-input');
    listImage.innerHTML = product.images.map(image => 
        `<div class="image-block" style="width:6.25rem;">
            <img class="cards-image" src="/${image.image_path}" />
            <div class="close-icon">
                <button type="button" class="material-symbols-outlined" onclick="removeImage(this)">close</button>
            </div>
        </div>`).join('');
}

$(document).ready(function () {
    $('#updateproductForm').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form reload trang

        // Lấy data từ các id trong detailProduct
        const id = $('#idProduct-input').val();
        const nameProduct = $('#nameProduct-input').val();
        const priceProduct = $('#priceProduct-input').val();
        const smellProduct = $('#smellProduct-input').val();
        const textureProduct = $('#textureProduct-input').val();
        const ingreMainProduct = $('#ingreMainProduct-input').val();
        const skinProduct = $('#skinProduct-input').val();
        const cateProduct = $('#cateProduct-input').val();
        const desProduct = $('#detailProduct-input').val();
        const noteProduct = $('#noteProduct-input').val();
        const allIngredientProduct = $('#allIngredientProduct-input').val();
        const htuProduct = $('#HTUProduct-input').val();
        const quantityProduct = $('#quantityProduct-input').val();
        const promotionProduct = $('#promotionProduct-input').val();
        const brandProduct = $('#brandProduct-input').val();
        const weightProduct = $('#weightProduct-input').val();

        // Tạo đối tượng FormData để gửi dữ liệu sản phẩm và hình ảnh
        const formData = new FormData();
        formData.append('name_product', nameProduct);
        formData.append('price_product', priceProduct);
        formData.append('smell_product', smellProduct);
        formData.append('texture_product', textureProduct);
        formData.append('ingre_main_product', ingreMainProduct);
        formData.append('skin_product', skinProduct);
        formData.append('cate_product', cateProduct);
        formData.append('des_product', desProduct);
        formData.append('note_product', noteProduct);
        formData.append('all_ingredient_product', allIngredientProduct);
        formData.append('htu_product', htuProduct);
        formData.append('quantity_product', quantityProduct);
        formData.append('promotion_id', promotionProduct);
        formData.append('brand_product', brandProduct);
        formData.append('weight_product', weightProduct);

        // Thêm hình ảnh vào FormData
        const files = $('#imageInput-input')[0].files;
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }
        formData.append('image_type', "product");
        console.log(formData);
        
        // AJAX request để lưu thông tin sản phẩm và hình ảnh
        $.ajax({
            url: `/admin/product/update-product/${id}`, // URL gửi dữ liệu được lấy từ biến trong file blade tương ứng
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert(response.success);
                    $('#detailProductForm')[0].reset(); // Reset form sau khi gửi thành công
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