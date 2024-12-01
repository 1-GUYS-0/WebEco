//slide
let currentSlide = 0;
function changeSlide(direction) {
    if (document.getElementById('slide-banner')) {
        const slides = document.querySelectorAll('.slide');
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        const offset = -currentSlide * 100;
        document.querySelector('.slides').style.transform = `translateX(${offset}%)`;
    }
    else {
        console.log('Lỗi tại changeSlide()->index.js');
    }
}

// Lấy thông tin sản phẩm từ Local Storage và hiển thị sản phẩm liên quan
function displayRelatedProducts() {
    let viewedProducts = JSON.parse(localStorage.getItem('viewedProducts')) || [];
    if (viewedProducts.length === 0) {
        document.querySelector('.interested-product_list').innerHTML = '<p>Không có sản phẩm được xem gần đây. Hãy khám phá thêm để chúng tôi hiểu bạn hơn!</p>';
    }
    else {
        // Loại bỏ các giá trị trùng lặp bằng cách sử dụng Set
        let uniqueViewedProducts = [...new Set(viewedProducts)];

        if (uniqueViewedProducts.length > 0) {
            // Gửi AJAX request đến server để lấy danh sách sản phẩm liên quan
            fetch('/home/product/interested', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ productIds: uniqueViewedProducts })
            })
                .then(response => response.json())
                .then(data => {
                    // Hàm tạo chuỗi HTML cho các ngôi sao đánh giá
                    function generateRatingStars(totalRating) {
                        let starsHtml = '';
                        for (let i = 0; i < totalRating; i++) {
                            starsHtml += '<img src="/system/star.png" alt="star">';
                        }
                        return starsHtml;
                    }
                    // Hiển thị danh sách sản phẩm liên quan
                    let productsContainer = document.querySelector('.interested-product_list');
                    productsContainer.innerHTML = '';
                    data.products.forEach(product => {
                        let productElement = document.createElement('div');
                        productElement.className = 'interested-product_item';
                        productElement.innerHTML = `
                        <div class="card-image">
                            <img class="product-detail_image" src="${product.images[0].image_path}" alt="${product.name}">
                        </div>
                        <div class="cards_contain">
                            <div class="product-detail_rating">
                                ${generateRatingStars(product.total_rating)}
                            </div>
                            <h3>
                                <a class="cards_name-prod close-bt" href="/home/product/${product.id}" onclick="saveProductToLocalStorage('${product.id}')" >${product.name}</a>
                            </h3>
                            <div class="cards_desc-prod">
                                ${product.description}
                            </div>
                            <div class="cards_price-prod">${product.price}</div>
                        </div>
                    `;
                        productsContainer.appendChild(productElement);
                    });
                });
        }
    }
}
// Gọi hàm hiển thị sản phẩm liên quan khi trang được tải
document.addEventListener('DOMContentLoaded', displayRelatedProducts);
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