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
//slide

let currentSlide = 0;
function changeSlide(direction) {
    const slides = document.querySelectorAll('.slide');
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    const offset = -currentSlide * 100;
    document.querySelector('.slides').style.transform = `translateX(${offset}%)`;
}
//show-cart

function toggleCart() {
    const cartSidebar = document.getElementById('cart-sidebar');
    const overlay = document.getElementById('overlay');
    console.log(cartSidebar.style.width);
    if (cartSidebar.style.width === '0px' || cartSidebar.style.width === '') {
        cartSidebar.style.width = '400px'; // Độ rộng của sidebar khi mở
        overlay.style.display = 'block'; // Hiển thị overlay
        cartSidebar.style.borderWidth = '0.2rem';   // Hiển thị viền của sidebar
    } else {
        cartSidebar.style.width = '0';
        overlay.style.display = 'none'; // Ẩn overlay
    }
}