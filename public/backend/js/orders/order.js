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
    fetchOrderDetails(orderId);
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
