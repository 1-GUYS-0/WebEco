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
function showDetail(idTab) {
    console.log(idTab);
    const modal = document.getElementById(idTab);
    const closeModal = modal.querySelector('.close-btn');
    const saveButton = modal.querySelector('#saveButton');
    modal.style.display = 'block';
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
