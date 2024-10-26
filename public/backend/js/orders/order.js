document.addEventListener('DOMContentLoaded', function () {
    const editOrder = document.querySelectorAll('.edit-button');
    const modal = document.getElementById('editModal');
    const closeModal = document.querySelector('.close-btn');
    const orderStatus = document.getElementById('orderStatus');
    const saveButton = document.getElementById('saveButton');

    editOrder.forEach(button => {
        button.addEventListener('click', function () {
            const order = JSON.parse(this.getAttribute('data-order'));

            // Điền các giá trị của đơn hàng vào các trường trong modal
            orderStatus.value = order.status;
            saveButton.setAttribute('data-order-id', order.id);

            // Hiển thị modal
            modal.style.display = 'block';
        });
    });

    // Đóng modal khi nhấn vào nút đóng
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Đóng modal khi nhấn ra ngoài modal
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
    // Save button click event
    saveButton.addEventListener('click', handleSaveButtonClick);
});

function handleSaveButtonClick() {
    const orderId = this.getAttribute('data-order-id');
    const status = document.getElementById('orderStatus').value;

    fetch(`/admin/orders/${orderId}/edit`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Cập nhật thành công');
                document.getElementById('editModal').style.display = 'none';
                location.reload(); // Reload the page to see the updated status
            } else {
                alert('Cập nhật lỗi');
            }
        })
        .catch(error => console.error('Error:', error));
}
function showDetail(idTab, orderId) {
    const modal = document.getElementById(idTab);
    const closeModal = modal.querySelector('.close-btn');
    const saveButton = modal.querySelector('#saveButton');
    if (idTab === 'detailOrder') {
        fetchOrderDetails(orderId);
    }
    if (idTab === 'refundOrderDetail') {
        getRefundDetails(orderId);
    }

    // Đóng modal khi nhấn vào nút đóng
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    // Đóng modal khi nhấn ra ngoài modal
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

function fetchOrderDetails(orderId) {
    fetch(`/admin/orders/${orderId}/detail`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const order = data.order;
                const vnpaypayment = data.vnpaypayment;
                const payment = data.payment;

                // Lấy phần tử detailOrder
                const detailOrder = document.getElementById('detailOrder');

                // Hiển thị thông tin đơn hàng
                document.getElementById('orderId').value = order.id;
                document.getElementById('customerName').value = order.customer.name;
                document.getElementById('orderDate').value = new Date(order.created_at).toLocaleDateString('vi-VN');
                document.getElementById('orderStatu').value = order.status;
                document.getElementById('totalPrice').value = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.total_price);
                document.getElementById('paymentMethod').value = payment.payment_method;
                document.getElementById('orderQuantity').value = order.order_quantity;
                // Xóa các thẻ div bên trong detailProductOrder trước khi thêm hình ảnh
                const detailProductOrder = document.getElementById('detailProductOrder');
                while (detailProductOrder.firstChild) {
                    detailProductOrder.removeChild(detailProductOrder.firstChild);
                }
                // Lặp qua các sản phẩm trong order.order_items và tạo các phần tử HTML tương ứng
                order.order_items.forEach(item => {
                    const productDiv = document.createElement('div');
                    productDiv.classList.add('detail-product');
                    const productImage = document.createElement('img');
                    productImage.src = `/${item.product.images[0].image_path}` || '{{asset("backend/asset/dashboard/logo.png")}}';
                    productImage.id = 'imageProductOrder';

                    const productName = document.createElement('h6');
                    productName.textContent = item.product.name;
                    productName.id = 'nameProductOrder';

                    const productQuantity = document.createElement('h6');
                    productQuantity.textContent = `Số lượng: ${item.quantity}`;
                    productQuantity.id = 'quantityProductOrder';

                    productDiv.appendChild(productImage);
                    productDiv.appendChild(productName);
                    productDiv.appendChild(productQuantity);

                    detailProductOrder.appendChild(productDiv);
                });
                if (vnpaypayment !== null) {
                    const tabAnotherPayment = document.getElementById('infor-another-payment')
                    document.getElementById('vnp_bank_code').value = vnpaypayment.vnp_bank_code;
                    document.getElementById('vnp_transaction_no').value = vnpaypayment.vnp_transaction_no;
                    tabAnotherPayment.style.display = 'block'
                }
                // Hiển thị modal
                detailOrder.style.display = 'block';
            } else {
                alert('Không tìm thấy đơn hàng.');
            }
        })
        .catch(error => console.error('Error:', error));
}
// Hàm định dạng ngày
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString(undefined, options);
}
function getRefundDetails(orderId) {
    fetch(`/admin/orders/${orderId}/detailrefund`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Refund details:', data.refund);
                // Điền dữ liệu vào form
                document.getElementById('refundId').value = data.refund.id;
                document.getElementById('refundCustomerName').value = data.refund.order.name;
                document.getElementById('refundOrderId').value = data.refund.order_id;
                document.getElementById('refundStatus').value = data.refund.status;
                document.getElementById('refundDate').value = formatDate(data.refund.created_at);

                // Hiển thị hình ảnh mô tả chi tiết yêu cầu
                const detailProductRefund = document.getElementById('detailProductRefund');
                detailProductRefund.style.display = 'flex';
                detailProductRefund.style.flexDirection = 'row';
                detailProductRefund.style.flexWrap = 'wrap';
                detailProductRefund.style.gap = '1rem';
                detailProductRefund.innerHTML = ''; // Xóa nội dung cũ
                // Chuyển đổi chuỗi JSON thành mảng
                const images = JSON.parse(data.refund.images_refund);

                images.forEach(image => {
                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'detail-product';
                    imageContainer.style.width = '150px'; 
                    imageContainer.style.border = '0.2rem solid #000';
                    imageContainer.style.display = 'flex';
                    imageContainer.style.justifyContent= 'center';
                    imageContainer.style.borderRadius = '1rem';
                    const img = document.createElement('img');
                    img.src = image;
                    img.alt = 'Refund Image';
                    img.style.width = '100px'; 
                    img.style.height = '100px'; 
    
                    // Thêm sự kiện click để phóng to hình ảnh
                    img.addEventListener('click', () => {
                        const modal = document.createElement('div');
                        modal.style.position = 'fixed';
                        modal.style.top = '0';
                        modal.style.left = '0';
                        modal.style.width = '100%';
                        modal.style.height = '100%';
                        modal.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
                        modal.style.display = 'flex';
                        modal.style.justifyContent = 'center';
                        modal.style.alignItems = 'center';
                        modal.style.zIndex = '1000';
    
                        const modalImg = document.createElement('img');
                        modalImg.src = image;
                        modalImg.style.maxWidth = '90%';
                        modalImg.style.maxHeight = '90%';
    
                        modal.appendChild(modalImg);
    
                        // Đóng modal khi nhấn vào
                        modal.addEventListener('click', () => {
                            document.body.removeChild(modal);
                        });
    
                        document.body.appendChild(modal);
                    });
    
                    imageContainer.appendChild(img);
                    detailProductRefund.appendChild(imageContainer);
                });

                // Hiển thị modal
                document.getElementById('refundOrderDetail').style.display = 'block';
            } else {
                console.error('Error:', data.message);
                alert('Refund request not found.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while fetching refund details.');
        });
}
function confirmRefund() {
    const refundId = document.getElementById('refundId').value;
    fetch(`/admin/orders/${refundId}/refund/confirm`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Xác nhận hoàn trả thành công');
                document.getElementById('refundOrderDetail').style.display = 'none';
                location.reload(); // Reload the page to see the updated status
            } else {
                alert('Xác nhận hoàn trả lỗi');
            }
        })
        .catch(error => console.error('Error:', error));
}
function rejectRefund() {
    const refundId = document.getElementById('refundId').value;
    const reason = document.getElementById('rejectReason').value;
    fetch('/rejectRefund', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ refundId: refundId, reason: reason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            // Cập nhật giao diện hoặc thực hiện các hành động khác
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}

