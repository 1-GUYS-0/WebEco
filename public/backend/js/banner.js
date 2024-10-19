$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function showTab(idTab, bannerJson) {
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    if (idTab === 'detailBanner' && Object.keys(bannerJson).length > 0) {
        showDetailBanner(idTab, bannerJson);
        // Hiển thị modal
        modal.style.display = 'block';
    }
    if (idTab === 'addBanner') {
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
function showDetailBanner(tabId, bannerJson) {
    const banner = JSON.parse(bannerJson);

    // Lấy phần tử detailBanner
    const detailBanner = document.getElementById(tabId);

    // Hiển thị thông tin banner
    document.getElementById('idBanner').value = banner.id;
    document.getElementById('titleBanner').value = banner.title;
    document.getElementById('startDateBanner').value = banner.start_date;
    document.getElementById('endDateBanner').value = banner.end_date;
    document.getElementById('linkToBanner').value = banner.link_to;


    // Cập nhật hình ảnh banner
    const listImageBanner = document.getElementById('listImageBanner');
    listImageBanner.innerHTML = banner.images_path ? 
        `<div class="image-block" style="width:6.25rem;">
            <img class="cards-image" src="/${banner.images_path}" />
            <div class="close-icon">
                <button type="button" class="material-symbols-outlined" onclick="removeImage(this)">close</button>
            </div>
        </div>` : 'N/A';
}
function updateBanner(){
    $('#detailBannerForm').off('submit').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form reload trang

        // Lấy data từ các id trong detailBanner
        const formData = new FormData(this);
        console.log(formData);
        // AJAX request để lưu thông tin banner và hình ảnh
        $.ajax({
            url: `/admin/banners/update-banner`, // URL gửi dữ liệu
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert(response.success);
                    // reset lại trang
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra trong quá trình gửi dữ liệu banner.');
                console.log(xhr.responseText);
            }
        });
    });
}
function addBanner() {
    $('#addBannerForm').off('submit').submit(function (event) {
        event.preventDefault(); // Ngăn chặn form reload trang

        // Lấy data từ các id trong addBanner
        const formData = new FormData(this);
        console.log(formData);

        // AJAX request để lưu thông tin banner và hình ảnh
        $.ajax({
            url: `/admin/banners/add-banner`, // URL gửi dữ liệu
            method: 'POST',
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response.success) {
                    alert(response.success);
                    // reset lại trang
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra trong quá trình gửi dữ liệu banner.');
                console.log(xhr.responseText);
            }
        });
    });
}