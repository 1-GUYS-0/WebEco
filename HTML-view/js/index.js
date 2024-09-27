//menu
document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.querySelector('.material-symbols-outlined');
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