$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let currentSlide = 0;
function changeSlide(direction) {
    if (document.getElementById('slide-product')) {
        const slides = document.querySelectorAll('.card-image_slide');
        currentSlide = (currentSlide + direction + slides.length) % slides.length;
        const offset = -currentSlide * 100;
        document.querySelector('.slides').style.transform = `translateX(${offset}%)`;
    }
    else {
        console.log('lỗi tại changeSlide()->product-detail.js');
    }
}

