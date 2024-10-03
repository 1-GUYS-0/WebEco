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

function addToCart(productId) {
    console.log('Add to cart:', productId);
    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            product_id: productId,
            quantity: 1 // Số lượng mặc định là 1
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
            } else {
                alert('Failed to add product to cart');
            }
        },
        error: function(error) {
            console.error('Error adding product to cart:', error);
            alert('An error occurred. Please try again.');
        }
    });
}