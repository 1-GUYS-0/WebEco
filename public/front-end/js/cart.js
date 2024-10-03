$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// show-cart 
function fetchCartItems() {
    $.ajax({
        url: showCart,
        method: 'GET',
        success: function (response) {
            const cartItems = document.getElementById('cart-items');
            const emptyCartMessage = document.getElementById('empty-cart-message');
            cartItems.innerHTML = ''; // Xóa hết các sản phẩm trong giỏ hàng trước khi thêm mới

            if (response.length === 0) {
                emptyCartMessage.style.display = 'block';
            } else {
                emptyCartMessage.style.display = 'none';
                response.forEach(item => {
                    console.log('Item:', item);
                    const productItem = document.createElement('li');
                    productItem.classList.add('product-items'); //
                    // Kiểm tra xem product và images có tồn tại hay không
                    const product = item.product;
                    const imagePath = (product && product.images && product.images.length > 0) ? product.images[0].image_path : 'default-image.jpg';
                    productItem.innerHTML = `
                        <img src="/storage/${item.product.images[0].image_path}" alt="${item.product.name}" class="product-image_selected" />
                        <div class="product-details">
                            <a class="cards_name-prod">${item.product.name}</a>
                            <div class="quantity-controls">
                                <button type="button" onclick="updateQuantity(${item.product_id}, -1)">
                                    <span class="material-symbols-outlined">remove</span>
                                </button>
                                <div class="number-order">${item.quantity}</div>
                                <button type="button" onclick="updateQuantity(${item.product_id}, 1)">
                                    <span class="material-symbols-outlined">add</span>
                                </button>
                            </div>
                            <div>
                                <span class="price">${item.product.price} VND</span>
                            </div>
                        </div>
                        <button type="button" onclick="removeFromCart(${item.product_id})">
                            <span class="material-symbols-outlined">cancel</span>
                        </button>
                    `;

                    cartItems.appendChild(productItem);
                });
            }
        }
    });
}

function updateQuantity(productId, change) {
    $.ajax({
        url: `/cart/update/${productId}`,
        method: 'POST',
        data: {
            change: change
        },
        success: function(response) {
            if (response.success) {
                fetchCartItems();
            } else {
                alert(response.message);
            }
        },
        error: function(error) {
            console.error('Error updating cart:', error);
            alert('An error occurred. Please try again.');
        }
    });
}
// function updateQuantity(productId, change) {
//     $.ajax({
//         url: `/update-cart/${productId}`,
//         method: 'POST',
//         data: {
//             _token: $('meta[name="csrf-token"]').attr('content'),
//             change: change
//         },
//         success: function(response) {
//             fetchCartItems();
//         }
//     });
// }

// function removeFromCart(productId) {
//     $.ajax({
//         url: `/remove-from-cart/${productId}`,
//         method: 'GET',
//         success: function(response) {
//             fetchCartItems();
//         }
//     });
// }