function showTab(idTab, adminJson) {
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    if (idTab === 'detailAdmin' && adminJson.length > 0) {
        showDetail(adminJson);
        modal.style.display = 'block';
    }
    if (idTab === 'addAdmin') {
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

function showDetail(adminId) {
    fetch(`/admin/admins/${adminId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('admin-id').innerText = data.admin.id;
                document.getElementById('admin-name').value = data.admin.name;
                document.getElementById('admin-email').value = data.admin.email;
                document.getElementById('admin-role').value = data.admin.role;

                // Set the role select options
                const roleSelect = document.getElementById('admin-role');
                roleSelect.innerHTML = `
                    <option value="admin" ${data.admin.role === 'admin' ? 'selected' : ''}>Admin</option>
                    <option value="sale" ${data.admin.role === 'sale' ? 'selected' : ''}>Sale</option>
                `;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
        });
}
function addAdmin() {
    const name = document.getElementById('admin-name-add').value;
    const email = document.getElementById('admin-email-add').value;
    const password = document.getElementById('admin-password-add').value;
    const role = document.getElementById('admin-role-add').value;

    const data = {
        name: name,
        email: email,
        password: password,
        role: role
    };

    fetch('/admin/admins/add', {
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
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}

function updateAdmin() {
    const adminId = document.getElementById('admin-id').innerText;
    const name = document.getElementById('admin-name').value;
    const email = document.getElementById('admin-email').value;
    const role = document.getElementById('admin-role').value;

    const data = {
        id: adminId,
        name: name,
        email: email,
        role: role
    };

    fetch(`/admin/admins/update`, {
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
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}

function deleteAdmin() {
    const adminId = document.getElementById('admin-id').innerText;

    fetch(`/admin/admins/delete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: adminId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}