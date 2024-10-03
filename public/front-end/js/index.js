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
