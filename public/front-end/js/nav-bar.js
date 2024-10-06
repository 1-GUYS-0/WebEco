$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//menu
document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.getElementById('menu_icon');
    const hidemenu = document.getElementById('hide-menu_icon');
    const navMenu = document.querySelector('.nav-bar_menu');

    // Định nghĩa hàm toggleMenu
    function toggleMenu() {
        navMenu.classList.toggle('active');
        menuIcon.classList.toggle('hide');
        hidemenu.classList.toggle('active');
    }

    // Gán hàm toggleMenu cho sự kiện click của menuIcon và hidemenu
    menuIcon.addEventListener('click', toggleMenu);
    hidemenu.addEventListener('click', toggleMenu);
});


//show-cart
function toggleCart() {
    const cartSidebar = document.getElementById('cart-sidebar');
    const overlay = document.getElementById('overlay');
    console.log(cartSidebar.style.width);
    if (cartSidebar.style.width === '0px' || cartSidebar.style.width === '') {
        cartSidebar.style.width = '500px'; // Độ rộng của sidebar khi mở
        overlay.style.display = 'block'; // Hiển thị overlay
        cartSidebar.style.borderWidth = '0.2rem';   // Hiển thị viền của sidebar
        fetchCartItems();
    } else {
        cartSidebar.style.width = '0';
        overlay.style.display = 'none'; // Ẩn overlay
        cartSidebar.style.borderWidth = '0'; // Ẩn viền của sidebar
    }
}
function myProfile() {
    window.location.href = '/home/customer/profile';
}
// Thêm sự kiện click cho nút prev và next
document.addEventListener('DOMContentLoaded', function () {
    // Lấy tất cả các nút remove, add và các input number-order
    const removeButtons = document.querySelectorAll('.quantity-controls button:first-child');
    const addButtons = document.querySelectorAll('.quantity-controls button:last-child');
    const numberOrderInputs = document.querySelectorAll('.quantity-controls .number-order');

    if (removeButtons && addButtons && numberOrderInputs) {
        // Thêm sự kiện click cho các nút remove
        removeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const numberOrderElement = this.nextElementSibling; // Lấy ra số lượng hiện tại thông qua element kế tiếp của nút remove
                let currentValue = parseInt(numberOrderElement.value);
                if (currentValue > 1) {
                    numberOrderElement.value = currentValue - 1;
                }
            });
        });

        // Thêm sự kiện click cho các nút add
        addButtons.forEach(button => {
            button.addEventListener('click', function () {
                const numberOrderElement = this.previousElementSibling; // Lấy ra số lượng hiện tại thông qua element trước của nút add
                let currentValue = parseInt(numberOrderElement.value);
                numberOrderElement.value = currentValue + 1;
            });
        });

        // Thêm sự kiện input cho các ô nhập số lượng
        numberOrderInputs.forEach(input => {
            input.addEventListener('input', function () {
                let currentValue = parseInt(this.value);
                if (isNaN(currentValue) || currentValue < 1) {
                    this.value = 1; // Đặt giá trị tối thiểu là 1 nếu giá trị nhập vào không hợp lệ
                }
            });
        });
    }
});

