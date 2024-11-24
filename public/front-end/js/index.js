//slide
let currentSlide = 0;
function changeSlide(direction,nameSlide) {
    if (document.getElementById(nameSlide)) {
        const slides = document.querySelectorAll('.slide');
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        const offset = -currentSlide * 100;
        document.querySelector('.slides').style.transform = `translateX(${offset}%)`;
    }
    else {
        console.log('Lỗi tại changeSlide()->index.js');
    }
}

// Lấy thông báo từ server và hiển thị
document.addEventListener('DOMContentLoaded', function () {
    fetchNotifications();
});

function fetchNotifications() {
    fetch('/home/notifications')
        .then(response => response.json())
        .then(data => {
            const notificationItems = document.getElementById('notification-items');
            const emptyMessage = document.getElementById('empty-notification-message');
            const notificationCount = document.getElementById('notification-count');

            notificationItems.innerHTML = '';
            // Lọc các thông báo chưa đọc
            const unreadNotifications = data.filter(notification => !notification.is_read);

            if (data.length > 0) {
                data.forEach(notification => {
                    const li = document.createElement('li');
                    li.textContent = notification.message;

                    // Thêm chữ "new" nếu thông báo chưa đọc
                    if (!notification.is_read) {
                        const newSpan = document.createElement('span');
                        newSpan.innerHTML = ' <h5 style="color:red;"><em>new!</em></h5>';
                        li.appendChild(newSpan);
                    }

                    li.onclick = () => markAsRead(notification.id);
                    notificationItems.appendChild(li);
                });
                emptyMessage.style.display = 'none';
                notificationCount.textContent = unreadNotifications.length;
                notificationCount.style.display = unreadNotifications.length > 0 ? 'inline' : 'none'; // Hiển thị số lượng thông báo nếu có thông báo chưa đọc
            } else {
                emptyMessage.style.display = 'block';
                notificationCount.style.display = 'none';
            }
        })
        .catch(error => console.error('Error:', error));
}

function markAsRead(id) {
    fetch(`/home/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchNotifications();
            }
        })
        .catch(error => console.error('Error:', error));
}