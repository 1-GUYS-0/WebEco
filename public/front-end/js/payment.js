$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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

function removeProductFromSelect(productId) {
    const productItem = document.querySelector(`.product-details .inputProductId[value="${productId}"]`).closest('.product-items');
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
    const voucher_code = document.getElementById('voucher-code').value;

    // Thêm dữ liệu vào formData
    formData.append('total_price', totalPrice);
    formData.append('discount_amount', discountAmount);
    formData.append('shipping_fee', shippingFee);
    formData.append('subtotal', subtotal);
    if (discountAmount !=null) {
        formData.append('voucher_code', voucher_code);
    }
    // Send data to server
    fetch('/home/payment/submitorder', {
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
                window.location.href = data.redictCashPayment_url;
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

    fetch('/home/payment/VNPAYpayment', {
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
    console.log(paymentMethod);
    // Check if payment method is cash
    
    if (paymentMethod === 'cash') {
        processCashPayment();
    }
    else if (paymentMethod === 'vnpay') {
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
        fetch('/home/payment/apply-voucher', {
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

// document.addEventListener('DOMContentLoaded', function () {
//     const choseAddress = document.getElementById('choseAddress');
//     const provinceSelect = document.getElementById('province');
//     const districtSelect = document.getElementById('district');
//     const wardSelect = document.getElementById('ward');
//     const phoneInput = document.getElementById('myNumber');
//     const addressInput = document.getElementById('myAddress');

//     if (provinceSelect && districtSelect && wardSelect && phoneInput && addressInput) {
//                     // Định nghĩa hàm selectOption
//         function selectOption(selectElement, value) {
//             const options = selectElement.options;
//             for (let i = 0; i < options.length; i++) {
//                 if (options[i].value === value) {
//                     selectElement.selectedIndex = i;
//                     break;
//                 }
//             }
//         }
//         // Lắng nghe sự kiện thay đổi của thẻ <select>
//         choseAddress.addEventListener('change', function () {
//             const selectedValue = this.value;
//             const values = selectedValue.split(',');
//             console.log(values);
//             if (values.length === 5) {
//                 const [province, district, ward, phone, address] = values;
//                 // Chọn dữ liệu cho các trường <select>
//                 selectOption(provinceSelect, province);
//                 loadAddressData(function(data) {
//                     console.log('Dữ liệu sau khi chọn tỉnh:', data);
//                 });

//                 selectOption(districtSelect, district);
//                 loadAddressData(function(data) {
//                     console.log('Dữ liệu sau khi chọn quận:', data);
//                 });

//                 selectOption(wardSelect, ward);
//                 loadAddressData(function(data) {
//                     console.log('Dữ liệu sau khi chọn phường:', data);
//                 });
//                 // Điền dữ liệu vào các trường tương ứng
//                 phoneInput.value = phone;
//                 addressInput.value = address;
//             } else {
//                 console.error('Dữ liệu không hợp lệ');
//             }
//         });
//     }
// }
// );
