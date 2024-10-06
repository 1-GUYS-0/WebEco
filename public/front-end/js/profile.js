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

function confirmReceived() {
    alert('Order confirmed as received.');
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
function previewAvatar(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('avatarPreview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Chức năng gửi yêu cầu edit
function updateProfile(info) {
    const formData = new FormData();
    
    if (info === 'name') {
        const newValue = prompt(`NHập giá ${info} mới của bạn:`);
        const name = newValue;
        formData.append('name', name);
    } else if (info === 'phone') {
        const newValue = prompt(`NHập giá ${info} mới của bạn:`);
        const phone = newValue;
        formData.append('phone', phone);
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

    $.ajax({
        url: update_profile,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            alert('Thông tin đã được cập nhật thành công.');
            location.reload();
        },
        error: function(xhr) {
            alert('Có lỗi xảy ra. Vui lòng thử lại.');
            console.log(xhr.responseText);
        }
    });
}

// Chức năng thay đổi avatar
