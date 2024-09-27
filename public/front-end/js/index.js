//menu
document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.getElementById('menu-icon');
    console.log(menuIcon);
    const navMenu = document.querySelector('.nav-bar_menu');

    menuIcon.addEventListener('click', function () {
        navMenu.classList.toggle('active');
    });
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
    } else {
        cartSidebar.style.width = '0';
        overlay.style.display = 'none'; // Ẩn overlay
    }
}