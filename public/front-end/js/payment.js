$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
            data.customer_id = '1'; // Thêm ID khách hàng tạm thời

            // Gửi dữ liệu đến server bằng AJAX
            $.ajax({
                url: orderForm.action,
                method: 'POST',
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

function removeProductFromSelect(productId) {
    const productItem = document.querySelector(`.product-items .product-details[value="${productId}"]`).closest('.product-items');
    if (productItem) {
        productItem.remove();
    } else {
        console.error('Product not found in the DOM');
    }
}
function processCashPayment() {
    // Collect form data
    let formData = new FormData(document.getElementById('order-form'));

    // Lấy thêm dữ liệu từ các trường id="total-price", id="discount-amount", id="shipping-fee"
    const totalPrice = document.getElementById('total-price').getAttribute('value');
    const discountAmount = document.getElementById('discount-amount').getAttribute('value');
    const shippingFee = document.getElementById('shipping-fee').getAttribute('value');
    const subtotal = document.getElementById('estimated_price').getAttribute('value');

    // Thêm dữ liệu vào formData
    formData.append('total_price', totalPrice);
    formData.append('discount_amount', discountAmount);
    formData.append('shipping_fee', shippingFee);
    formData.append('subtotal', subtotal);

    // Send data to server
    fetch('/home/customer/payment/submitorder', {
        method: 'POST',
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert('Đặt hàng thành công');
                // Chuyển hướng đến trang xác nhận đặt hàng thành công
                window.location.href = data.payment_url;
            } else {
                alert('Không thể đặt hàng, vui lòng thử lại');
                // Chuyển hướng đến trang thất bại
                // window.location.href = data.redirect_url;
            }
        })
        .catch(error => console.error('Error:', error));
}
function processVNPayPayment() {
    // Collect form data
    let formData = new FormData(document.getElementById('order-form'));

    // Lấy thêm dữ liệu từ các trường id="total-price", id="discount-amount", id="shipping-fee"
    const totalPrice = document.getElementById('total-price').getAttribute('value');
    const discountAmount = document.getElementById('discount-amount').getAttribute('value');
    const shippingFee = document.getElementById('shipping-fee').getAttribute('value');
    const subtotal = document.getElementById('estimated_price').getAttribute('value');

    // Thêm dữ liệu vào formData
    formData.append('total_price', totalPrice);
    formData.append('discount_amount', discountAmount);
    formData.append('shipping_fee', shippingFee);
    formData.append('subtotal', subtotal);

    fetch('/home/customer/VNPAYpayment', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.payment_url;
            } else {
                alert('Không thể tạo thanh toán VNPAY, vui lòng thử lại.');
            }
        })
        .catch(error => console.error('Error:', error));
}
document.getElementById('immediate-payment-button').addEventListener('click', function () {
    let paymentMethod = document.querySelector('select[name="payment_method"]').value;
    // Check if payment method is cash
    if (paymentMethod === 'cash') {
        processCashPayment();
    }
    if (paymentMethod === 'vnpay') {
        processVNPayPayment();
    }
    else {
        alert('Phương thức thanh toán không hợp lệ');
    }

});
// Chèn giá vận chuyển khi chọn phương thức vận chuyển
document.addEventListener('DOMContentLoaded', function () {
    const shippingMethodSelect = document.getElementById('shipping-method');
    const shippingFeeElement = document.getElementById('shipping-fee');

    // Giá mô phỏng cho mỗi phương thức vận chuyển
    const shippingFees = {
        'ahamove': 30000,
        'ghn': 35000,
        'ghtk': 25000,
        'grap': 40000
    };

    shippingMethodSelect.addEventListener('change', function () {
        const selectedMethod = shippingMethodSelect.value;
        const shippingFee = shippingFees[selectedMethod] || 0;

        // Cập nhật giá trị của phần tử <dd>
        shippingFeeElement.setAttribute('value', shippingFee);
        shippingFeeElement.textContent = shippingFee.toLocaleString('vi-VN') + ' VND';
    });
});
//Cập nhật giá trị tổng tiền khi thay đổi các giá trị khác
document.addEventListener('DOMContentLoaded', function () {
    const applyVoucherButton = document.getElementById('apply-voucher');
    const voucherCodeInput = document.getElementById('voucher-code');
    const discountAmountElement = document.getElementById('discount-amount');
    const estimatedPriceElement = document.getElementById('estimated_price');
    const shippingFeeElement = document.getElementById('shipping-fee');
    const totalPriceElement = document.getElementById('total-price');

    function calculateTotalPrice() {
        const estimatedPrice = parseInt(estimatedPriceElement.textContent.replace(/\./g, '').replace(' VND', ''), 10);
        const discountAmount = parseInt(discountAmountElement.textContent.replace(/\./g, '').replace(' VND', ''), 10);
        const shippingFee = parseInt(shippingFeeElement.textContent.replace(/\./g, '').replace(' VND', ''), 10);

        const totalPrice = estimatedPrice - discountAmount + shippingFee;
        totalPriceElement.textContent = totalPrice.toLocaleString('vi-VN') + ' VND';
        // cập nhật value cho totalPriceElement
        totalPriceElement.setAttribute('value', totalPrice);
    }

    applyVoucherButton.addEventListener('click', function () {
        const voucherCode = voucherCodeInput.value;
        const totalPrice = parseInt(estimatedPriceElement.textContent.replace(/\./g, ''), 10);
        const shippingFee = parseInt(shippingFeeElement.getAttribute('value'), 10);
        fetch('/home/customer/payment/apply-voucher', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            body: JSON.stringify({
                voucher_code: voucherCode,
                total_price: totalPrice,
                shipping_fee: shippingFee
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    discountAmountElement.setAttribute('value', data.discount);
                    discountAmountElement.textContent = data.discount.toLocaleString('vi-VN') + ' VND';
                    calculateTotalPrice();
                } else {
                    alert('Voucher không hợp lệ hoặc đã hết hạn.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Đã xảy ra lỗi khi áp dụng voucher. Vui lòng thử lại.');
            });
    });

    // Sử dụng MutationObserver để lắng nghe sự thay đổi của các trường
    const observer = new MutationObserver(calculateTotalPrice);

    observer.observe(discountAmountElement, { childList: true, subtree: true });
    observer.observe(shippingFeeElement, { childList: true, subtree: true });

    // Tính toán giá tổng ban đầu
    calculateTotalPrice();
});