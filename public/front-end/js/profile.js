$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Chức năng chuyển tab
function showTab(tabName) {
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-content > div').forEach(content => content.classList.remove('active'));

    document.querySelector(`.tab[onclick="showTab('${tabName}')"]`).classList.add('active');
    document.querySelector(`.${tabName}`).classList.add('active');
}

function confirmDelete(orderId) {
    if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
        fetch(`/orders/${orderId}/delete/cash`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Đơn hàng đã được hủy thành công.');
                location.reload(); // Reload the page to see the updated status
            } else {
                alert('Không thể hủy đơn hàng.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi hủy đơn hàng. Vui lòng thử lại sau.');
        });
    }
}

function confirmReceived(orderId) {
    if (confirm('Bạn có chắc chắn muốn xác nhận đã nhận được hàng không?')) {
        fetch(`/orders/${orderId}/completed/cash`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Đã xác nhận nhận hàng thành công.');
                location.reload(); // Reload the page to see the updated status
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi khi xác nhận nhận hàng. Vui lòng thử lại sau.');
        });
    }
}
// Các Chức năng editthông tin cá nhân

// Chức năng edit thông tin 
// Chức năng show/hide popup cho edit địa chỉ mặc định
function showPopup(popupId) {
    document.getElementById(popupId).style.display = "block";
}
function closePopup(popupId) {
    document.getElementById(popupId).style.display = "none";
}
// Chức năng review avatar
function previewAvatar(event) {
    var reader = new FileReader();
    reader.onload = function () {
        var output = document.getElementById('avatarPreview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Chức năng gửi yêu cầu edit
function updateProfile(info) {
    const formData = new FormData();

    if (info === 'name') {
        const newValue = prompt(`NHập ${info} mới của bạn:`);
        const name = newValue;
        if (name) {
            formData.append('name', name);
        }
        console.log(name);
    } else if (info === 'phone') {
        const newValue = prompt(`NHập ${info} mới của bạn:`);
        const phone = newValue;
        if (phone) {
            formData.append('phone', phone);
        }
    } else if (info === 'address') {
        const addressSelect = document.getElementById('address');
        const address = addressSelect.options[addressSelect.selectedIndex].value;
        formData.append('default_address_id', address);
    } else if (info === 'avatar') {
        const avatar = document.getElementById('avatar').files[0];
        if (avatar) {
            formData.append('avatar', avatar);
        }
    }
    // Chuyển đổi FormData thành JSON
    function formDataToJson(formData) {
        const jsonObject = {};
        formData.forEach((value, key) => {
            jsonObject[key] = value;
        });
        return JSON.stringify(jsonObject);
    }
    // Chuyển đổi formData thành JSON
    const jsonString = formDataToJson(formData);
    console.log(jsonString);
    if (jsonString === '{}') {
        return alert('Vui lòng nhập thông tin mới.');
    }
    else {
        $.ajax({
            url: update_profile,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                alert('Thông tin đã được cập nhật thành công.');
                location.reload();
            },
            error: function (xhr) {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                console.log(xhr.responseText);
            }
        });
    }
}
// Chức năng thêm các trường địa chỉ
document.addEventListener('DOMContentLoaded', function () {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    if (provinceSelect && districtSelect && wardSelect) {
        // Hàm để tải dữ liệu JSON
        function loadAddressData(callback) {
            $.getJSON('/front-end/js/plugin/address-vn.json', function (data) {
                callback(data);
            }).fail(function () {
                console.error('Không thể tải dữ liệu địa chỉ.');
            });
        }

        // Sử dụng dữ liệu sau khi tải
        loadAddressData(function (data) {
            // Cập nhật các giá trị trong <option> của thẻ <select> cho tỉnh/thành phố
            data.forEach(province => {
                const option = document.createElement('option');
                option.value = province.Name;
                option.textContent = province.Name;
                provinceSelect.appendChild(option);
            });

            provinceSelect.addEventListener('change', function () // Lắng nghe sự kiện khi chọn tỉnh/thành phố
            {
                const selectedProvince = data.find(province => province.Name === this.value); // Tìm tỉnh/thành phố được chọn
                if (selectedProvince) {
                    const districts = selectedProvince.District;
                    districtSelect.innerHTML = '<option value="" disabled selected hidden>Chọn 1 Quận/Huyện</option>'; // Reset giá trị của <select> quận/huyện
                    wardSelect.innerHTML = '<option value="" disabled selected hidden>Chọn 1 Phường/Xã</option>'; // Reset giá trị của <select> phường/xã

                    districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.Name;
                        option.textContent = district.Name;
                        districtSelect.appendChild(option);
                    });
                } else {
                    console.error(`Province ${this.value} not found in data`);
                }
            });

            districtSelect.addEventListener('change', function () {
                const selectedProvince = data.find(province => province.Name === provinceSelect.value);
                const selectedDistrict = selectedProvince.District.find(district => district.Name === this.value);
                if (selectedDistrict) {
                    const wards = selectedDistrict.Ward;
                    wardSelect.innerHTML = '<option value="" disabled selected hidden>Chọn 1 Phường/Xã</option>';

                    wards.forEach(ward => {
                        const option = document.createElement('option');
                        option.value = ward.Name.toLowerCase().replace(/ /g, '-');
                        option.textContent = ward.Name;
                        wardSelect.appendChild(option);
                    });
                } else {
                    console.error(`District ${this.value} not found in province ${provinceSelect.value}`);
                }
            });
        });
    }
});
// Chức năng thêm địa chỉ mới
function submitNewAddress() {
    const province = document.getElementById('province').value;
    const district = document.getElementById('district').value;
    const ward = document.getElementById('ward').value;
    const phone = document.getElementById('myNumber').value;
    const address = document.getElementById('myAddress').value;

    if (!province || !district || !ward || !phone || !address) {
        alert('Vui lòng điền đầy đủ thông tin.');
        return;
    }

    const addnewaddress = `${province}/${district}/${ward}/${phone}/${address}`;
    console.log(addnewaddress);
    $.ajax({
        url: '/home/customer/profile/update',
        type: 'POST',
        data: {
            addnewaddress: addnewaddress,
        },
        success: function (response) {
            alert('Thông tin đã được cập nhật thành công.');
            location.reload();
        },
        error: function (xhr) {
            alert('Đã xảy ra lỗi. Vui lòng thử lại.');
        }
    });
}
function showReviewForm(orderId) {
    if (confirm('Bạn có chắc chắn muốn đánh giá các sản phẩm cho đơn hàng này không?')) {
        window.location.href = `/orders/${orderId}/review`;
    }
}