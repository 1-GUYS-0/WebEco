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

function confirmDelete(orderId, orderPayment) {
    console.log(orderPayment);
    if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?')) {
        let url = '';
        if (orderPayment === "cash") {
            url = `/home/orders/${orderId}/delete/cash`;
        } else if (orderPayment === "vnpay") {
            url = `/home/orders/${orderId}/delete/vnpay`;
        } else {
            alert('Đơn hàng không thể hủy. Vui lòng sử dụng chatbot để được hỗ trợ.');
            return;
        }

        fetch(url, {
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
        fetch(`/home/orders/${orderId}/completed`, {
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
function previewAvatar(event, containerId) {
    var files = event.target.files;
    var container = document.getElementById(containerId);
    console.log(files);
    console.log(containerId);
    // Xóa các hình ảnh hiện tại trong container
    container.innerHTML = '';

    for (var i = 0; i < files.length; i++) {
        var file = files[i];
        var reader = new FileReader();

        reader.onload = (function (file) {
            return function (e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('avatarPreview');
                container.appendChild(img);
            };
        })(file);

        reader.readAsDataURL(file);
    }
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
        url: '/home/profile/update',
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
        window.location.href = `/home/orders/${orderId}/review`;
    }
}

function showDetailOrder(orderId) {
    // Lấy chi tiết đơn hàng từ server (giả sử bạn có API để lấy chi tiết đơn hàng)
    fetch(`/home/orders/orderdetail/${orderId}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Định dạng giá tiền
            function formatPrice(price) {
                return new Intl.NumberFormat('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                }).format(price).replace('₫', 'VND');
            }
            // Kiểm tra trạng thái đơn hàng
            let statusText = data.status;
            if (data.status === 'pending') {
                statusText = 'đang giao';
            } else if (data.status === 'shipping') {
                statusText = 'đang giao';
            } else if (data.status === 'completed') {
                statusText = 'đã giao';
            } else if (data.status === 'rated') {
                statusText = 'đã đánh giá';
            } else if (data.status === 'cancelled') {
                statusText = 'đã hủy';
            }
            
            //Kiểm tra yêu cầu hoàn hàng
            let returnRequest = '';
            if (data.refund_request){
                if (data.refund_request.status === 'pending') {
                    returnRequest = 'Chờ xác nhận';
                }
                else if (data.refund_request.status === 'accepted') {
                    returnRequest = 'Đã chấp nhận';
                }
                else if (data.refund_request.status === 'rejected') {
                    returnRequest = 'Đã từ chối';
                }
                else {
                    returnRequest = 'Không yêu cầu';
                }
            };
            // Kiểm tra phương thức thanh toán
            let paymentMethod = data.payment.payment_method;
            if (data.payment.payment_method === 'cash') {
                paymentMethod = `
                <p>Bạn thanh toán bằng tiền mặt</p>
                <p> Vui lòng chuẩn bị đủ số tiền  ${formatPrice(data.total_price)} khi nhận hàng`;
            } else if (data.payment.payment_method === 'vnpay') {
                paymentMethod = `
                <p>Bạn thanh toán bằng VNPay</p>
                <p> Số tiền ${formatPrice(data.total_price)} đã được thanh toán qua cổng thanh toán VNPAY</p>`;
            }
            // Kiểm tra yêu cầu hoàn hàng
            // let returnRequest = data.return_request;

            // Định dạng ngày tháng
            const orderDate = new Date(data.created_at);
            const formattedDate = orderDate.toLocaleDateString('vi-VN', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
            });
            // Tạo danh sách sản phẩm
            let productListHTML = '';
            data.order_items.forEach(item => {
                productListHTML += `
                                <div class="order-product-item">
                                    <img src="${item.product.images[0].image_path}" alt="${item.product.name}">
                                    <p>Tên sản phẩm: ${item.product.name}</p>
                                    <p>Số lượng: ${item.quantity}</p>
                                    <p>Giá: ${formatPrice(item.price * item.quantity)}</p>
                                </div>
                            `;
            });
            // Hiển thị chi tiết đơn hàng trong popup
            var orderDetailContent = document.getElementById('order-detail-content');
            orderDetailContent.innerHTML = `
                <div>
                    <h3>Mã đơn hàng: ${data.id}</h3>
                    <div>
                        <p> Tên khách hàng: ${data.name}</p>
                        <p>Địa chỉ nhận hàng: ${data.address}</p>
                        <p>Số điện thoại: ${data.phone}</p>
                    </div>
                    <div>
                        <p>Trạng thái đơn hàng: ${statusText}</p>
                    </div>
                    <div>
                        <p>Đơn vị vận chuyển: ${data.shipping_method}</p>
                        <p>Phí vận chuyển: ${formatPrice(data.shipping)}</p>
                        <p>Giảm giá: ${formatPrice(data.discount)}</p>
                    </div>
                    <div>
                        <p>Tổng tiền: ${formatPrice(data.total_price)}</p>
                        <p>Ngày đặt hàng: ${formattedDate}</p>
                    </div>
                </div>
                <div>
                    <h3>Danh sách sản phẩm</h3>
                    <div class="order-products-list ">
                        ${productListHTML}
                    </div>
                </div>
                <div>
                    <h3>Phương thức thanh toán:</h3>
                    ${paymentMethod}
                </div>
                <div>
                    <h3>Yêu cầu hoàn trả hàng</h3>
                    <p>Trạng thái yêu cầu: ${returnRequest}</p>
                </div>
            `;
            // Hiển thị popup
            var popup = document.getElementById('order-detail-popup');
            popup.style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
}

function closeOrderDetailPopup() {
    var popup = document.getElementById('order-detail-popup');
    popup.style.display = 'none';
}

// Đóng popup khi click ra ngoài
window.onclick = function (event) {
    var popup = document.getElementById('order-detail-popup');
    if (event.target == popup) {
        popup.style.display = 'none';
    }
}
function showPopupReturn(popupId, orderId) {

    document.getElementById(popupId).style.display = "block";
    document.getElementById('returnProductId').value = orderId;
}
function submitReturnRequest() {
    // Lấy dữ liệu từ form
    var orderId = document.getElementById('returnProductId').value;
    var reason = document.getElementById('returnProduct').value;
    var details = document.getElementById('returnReason').value;
    var images = document.getElementById('returnImage').files;

    // Tạo đối tượng FormData để gửi dữ liệu
    var formData = new FormData();
    formData.append('order_id', orderId);
    formData.append('reason', reason);
    formData.append('details', details);

    // Thêm các tệp hình ảnh vào FormData
    for (var i = 0; i < images.length; i++) {
        formData.append('images_refund[]', images[i]);
    }

    // Gửi yêu cầu trả hàng đến server
    fetch('/home/orders/return', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Gửi yêu cầu trả hàng thành công.');
                // Đóng popup hoặc thực hiện các hành động khác nếu cần
                closePopup('returnProductPopup');
            } else {
                alert('Đã xảy ra lỗi khi xử lý yêu cầu trả hàng.');
            }
        })
        .catch(error => console.error('Error:', error));
}