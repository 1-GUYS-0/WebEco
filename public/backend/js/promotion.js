function showTab(idTab, promotionJson) {
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    if (idTab === 'detailPromotion' && promotionJson.length > 0) {
        // showDetailBanner(idTab, bannerJson);
        showDetail(promotionJson)
        // Hiển thị modal
        modal.style.display = 'block';
    }
    if (idTab === 'addPromotion') {
        // Hiển thị modal
        modal.style.display = 'block';
    }
    // Đóng modal khi nhấn vào nút đóng
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    });
    // Đóng modal khi nhấn ra ngoài modal
    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

function showDetail(promotionId) {
    fetch(`/admin/promotions/${promotionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('promotion-id').innerText = data.promotion.id;
                document.getElementById('promotion-name').value = data.promotion.name;
                document.getElementById('promotion-percent').value = data.promotion.percent_promotion;
                // Định dạng ngày giờ cho thẻ input kiểu datetime-local
                const promotionStart = new Date(data.promotion.promotion_start);
                const promotionEnd = new Date(data.promotion.promotion_end);

                const formattedStart = promotionStart.toISOString().slice(0, 16);
                const formattedEnd = promotionEnd.toISOString().slice(0, 16);

                document.getElementById('promotion-start').value = formattedStart;
                document.getElementById('promotion-end').value = formattedEnd;
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
        });
}
function addPromotion() {
    const name = document.getElementById('promotion-name-add').value;
    const percent = document.getElementById('promotion-percent-add').value;
    const start = document.getElementById('promotion-start-add').value;
    const end = document.getElementById('promotion-end-add').value;

    const data = {
        name: name,
        percent_promotion: percent,
        promotion_start: start,
        promotion_end: end
    };

    fetch('/admin/promotions/add', {
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
function updatePromotion() {
    const promotionId = document.getElementById('promotion-id').innerText;
    const name = document.getElementById('promotion-name').value;
    const percent = document.getElementById('promotion-percent').value;
    const start = document.getElementById('promotion-start').value;
    const end = document.getElementById('promotion-end').value;

    const data = {
        id: promotionId,
        name: name,
        percent_promotion: percent,
        promotion_start: start,
        promotion_end: end
    };

    fetch(`/admin/promotions/update`, {
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
function deletePromotion() {
    const promotionId = document.getElementById('promotion-id').innerText;

    fetch(`/admin/promotions/delete`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: promotionId })
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