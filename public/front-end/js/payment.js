document.addEventListener('DOMContentLoaded', function () {
    // Lấy tất cả các nút remove, add và các input number-order
    const removeButtons = document.querySelectorAll('.quantity-controls button:first-child');
    const addButtons = document.querySelectorAll('.quantity-controls button:last-child');
    const numberOrderInputs = document.querySelectorAll('.quantity-controls .number-order');

    if (removeButtons && addButtons && numberOrderInputs) {
        // Thêm sự kiện click cho các nút remove
        removeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const numberOrderElement = this.nextElementSibling; // Lấy ra số lượng hiện tại thông qua element kế tiếp của nút remove
                let currentValue = parseInt(numberOrderElement.value);
                if (currentValue > 1) {
                    numberOrderElement.value = currentValue - 1;
                }
            });
        });

        // Thêm sự kiện click cho các nút add
        addButtons.forEach(button => {
            button.addEventListener('click', function () {
                const numberOrderElement = this.previousElementSibling; // Lấy ra số lượng hiện tại thông qua element trước của nút add
                let currentValue = parseInt(numberOrderElement.value);
                numberOrderElement.value = currentValue + 1;
            });
        });

        // Thêm sự kiện input cho các ô nhập số lượng
        numberOrderInputs.forEach(input => {
            input.addEventListener('input', function () {
                let currentValue = parseInt(this.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    this.value = 1; // Đặt giá trị tối thiểu là 1 nếu giá trị nhập vào không hợp lệ
                }
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    if (provinceSelect && districtSelect && wardSelect) {
        const data = {
            hcm: {
                districts: {
                    'quan1': ['Phường 1', 'Phường 2', 'Phường 3'],
                    'quan2': ['Phường A', 'Phường B', 'Phường C']
                }
            },
            danang: {
                districts: {
                    'hai-chau': ['Phường Hải Châu 1', 'Phường Hải Châu 2'],
                    'thanh-khe': ['Phường Thanh Khê 1', 'Phường Thanh Khê 2']
                }
            },
            hanoi: {
                districts: {
                    'hoan-kiem': ['Phường Hàng Bạc', 'Phường Hàng Bồ'],
                    'dong-da': ['Phường Cát Linh', 'Phường Hàng Bột']
                }
            }
        };

        provinceSelect.addEventListener('change', function () {
            const province = this.value;
            if (data[province]) {
                const districts = data[province].districts;
                districtSelect.innerHTML = '<option value="" disabled selected hidden>Chọn 1 Quận/Huyện</option>';
                wardSelect.innerHTML = '<option value="" disabled selected hidden>Chọn 1 Phường/Xã</option>';

                for (const district in districts) {
                    const option = document.createElement('option');
                    option.value = district;
                    option.textContent = district.replace(/-/g, ' ');
                    districtSelect.appendChild(option);
                }
            } else {
                console.error(`Province ${province} not found in data`);
            }
        });

        districtSelect.addEventListener('change', function () {
            const province = provinceSelect.value;
            const district = this.value;
            if (data[province] && data[province].districts[district]) {
                const wards = data[province].districts[district];
                wardSelect.innerHTML = '<option value="" disabled selected hidden>Chọn 1 Phường/Xã</option>';

                wards.forEach(ward => {
                    const option = document.createElement('option');
                    option.value = ward.toLowerCase().replace(/ /g, '-');
                    option.textContent = ward;
                    wardSelect.appendChild(option);
                });
            } else {
                console.error(`District ${district} not found in province ${province}`);
            }
        });
    }

    // Thêm sự kiện submit cho form
    const orderForm = document.getElementById('order-form');
    if (orderForm) {
        orderForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Ngăn chặn hành vi submit mặc định

            // Lấy dữ liệu từ form
            const formData = new FormData(orderForm);
            console.log('Form data:', [formData]);
            const data = {};
            // Chuyển dữ liệu từ FormData sang object
            formData.forEach((value, key) => {
                if (key.endsWith('[]')) {
                    const cleanKey = key.slice(0, -2); // Xóa 2 ký tự cuối cùng của key bởi vì key kết thúc bằng '[]' trong trường hợp như price[] hoặc quantity[]
                    if (!data[cleanKey]) {
                        data[cleanKey] = []; // Khởi tạo mảng nếu chưa tồn tại dành cho key có dạng price[] hoặc quantity[]
                    }
                    data[cleanKey].push(value);
                } else {
                    data[key] = value; // Gán giá trị cho key trong object data nếu key không phải dạng price[] hoặc quantity[]
                }
            });
            // Thêm dữ liệu tạm thời vào đối tượng data
            data.customer_id = 'temporary_customer_id'; // Thêm ID khách hàng tạm thời

            // Gửi dữ liệu đến server bằng AJAX
            $.ajax({
                url: orderForm.action,
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Lấy CSRF token từ form
                },
                data: JSON.stringify(data),
                success: function (result) {
                    console.log('Success:', result);
                    // Xử lý kết quả trả về từ server
                },
                error: function (error) {
                    console.error('Error:', error);
                    // Xử lý lỗi
                }
            });
        });
    }
});