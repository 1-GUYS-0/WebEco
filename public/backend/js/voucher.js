function showTab(idTab, voucherJson) {
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    if (idTab === 'detailVoucher' && voucherJson.length > 0) {
        showDetail(voucherJson);
        modal.style.display = 'block';
    }
    if (idTab === 'addVoucher') {
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

function showDetail(voucherId) {
    fetch(`/admin/vouchers/${voucherId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('voucher-id').innerText = data.voucher.id;
                document.getElementById('voucher-code').value = data.voucher.code;
                document.getElementById('voucher-name').value = data.voucher.name;
                document.getElementById('voucher-percent').value = data.voucher.discount_amount;
                document.getElementById('voucher-quantity').value = data.voucher.quantity;

                const voucherStart = data.voucher.start_time;
                const voucherEnd = data.voucher.end_time;
                const voucherExpiry = data.voucher.expiry_date;

                const formattedStart = voucherStart.slice(0, 5); 
                const formattedEnd = voucherEnd.slice(0, 5);
                const formattedExpiry = voucherExpiry.slice(0, 16); ;

                document.getElementById('voucher-start').value = formattedStart;
                document.getElementById('voucher-end').value = formattedEnd;
                document.getElementById('voucher-expiry').value = formattedExpiry;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
        });
}

function addVoucher() {
    const code = document.getElementById('voucher-code-add').value;
    const name = document.getElementById('voucher-name-add').value;
    const percent = parseFloat(document.getElementById('voucher-percent-add').value); // Chuyển đổi sang số
    const quantity = parseInt(document.getElementById('voucher-quantity-add').value, 10); // Chuyển đổi sang số nguyên
    const start = document.getElementById('voucher-start-add').value;
    const end = document.getElementById('voucher-end-add').value;
    const expiry = document.getElementById('voucher-expiry-add').value;

    const data = {
        code: code,
        name: name,
        discount_amount: percent,
        quantity: quantity,
        start_time: start,
        end_time: end,
        expiry_date: expiry
    };

    fetch('/admin/vouchers/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
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

function updateVoucher() {
    const voucherId = document.getElementById('voucher-id').innerText;
    const code = document.getElementById('voucher-code').value;
    const name = document.getElementById('voucher-name').value;
    const percent = document.getElementById('voucher-percent').value;
    const quantity = document.getElementById('voucher-quantity').value;
    const start = document.getElementById('voucher-start').value;
    const end = document.getElementById('voucher-end').value;
    const expiry = document.getElementById('voucher-expiry').value;

    const data = {
        id: voucherId,
        code: code,
        name: name,
        discount_amount: percent,
        quantity: quantity,
        start_time: start,
        end_time: end,
        expiry_date: expiry
    };

    fetch(`/admin/vouchers/update`, {
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

function deleteVoucher() {
    const voucherId = document.getElementById('voucher-id').innerText;

    fetch(`/admin/vouchers/delete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: voucherId })
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