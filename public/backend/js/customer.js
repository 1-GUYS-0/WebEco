function showTab(idTab, customerJson) {
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    if (idTab === 'detailCustomer' && customerJson.length > 0) {
        showDetail(customerJson);
        modal.style.display = 'block';
    }
    if (idTab === 'addCustomer') {
        modal.style.display = 'block';
    }
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    });
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

function showDetail(customerId) {
    fetch(`/admin/customers/${customerId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('customer-id').innerText = data.customer.id;
                document.getElementById('customer-name').value = data.customer.name;
                document.getElementById('customer-phone').value = data.customer.number_phone;
                document.getElementById('customer-email').value = data.customer.email;
                document.getElementById('customer-status').value = data.customer.status;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
        });
}

function updateCustomer() {
    const customerId = document.getElementById('customer-id').innerText;
    const name = document.getElementById('customer-name').value;
    const phone = document.getElementById('customer-phone').value;
    const email = document.getElementById('customer-email').value;
    const status = document.getElementById('customer-status').value;

    const data = {
        id: customerId,
        name: name,
        number_phone: phone,
        email: email,
        status: status
    };

    fetch(`/admin/customers/update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            location.reload(); // Tải lại trang để cập nhật dữ liệu
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}

function deleteCustomer() {
    const customerId = document.getElementById('customer-id').innerText;

    fetch(`/admin/customers/delete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: customerId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert(data.message);
            location.reload(); // Tải lại trang để cập nhật dữ liệu
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}