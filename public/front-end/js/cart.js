$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function addToCart(productId) {
    console.log('Add to cart:', productId);
    $.ajax({
        url: '/home/cart/add',
        method: 'POST',
        data: {
            product_id: productId,
            quantity: 1 // Số lượng mặc định là 1
        },
        success: function (response) {
            if (response.success) {
                alert('Sản phẩm đã được thêm vào giỏ hàng');
            } else {
                alert('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
            }
        },

        error: function (error) {
            // Kiểm tra nếu response có chứa message
            if (error.responseJSON && error.responseJSON.message) {
                console.error('Error adding product to cart:', error);
                alert('Lỗi: ' + error.responseJSON.message);
            } else {
                console.error(error.responseJSON.message);
            }
        }
    });
}
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
                        <img src="/${item.product.images[0].image_path}" alt="${item.product.name}" class="product-image_selected" />
                        <div class="product-details" value= "${item.product_id}">
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
                                <span class="price">${(item.product.price * item.quantity).toLocaleString('vi-VN')} VND</span>
                            </div>
                        </div>
                        <button class="remove-button" type="button" onclick="removeProductFromCart(${item.product_id})">
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
        url: `/home/cart/update/${productId}`,
        method: 'POST',
        data: {
            change: change
        },
        success: function (response) {
            if (response.success) {
                fetchCartItems();
            } else {
                alert(response.message);
            }
        },
        error: function (error) {
            console.error('Error updating cart:', error);
            alert('An error occurred. Please try again.');
        }
    });
}

function proceedToPayment() {
    const cartItems = document.querySelectorAll('#cart-items .product-items');
    const products = [];

    cartItems.forEach(item => {
        const productId = item.querySelector('.product-details').getAttribute('value');
        const quantity = item.querySelector('.number-order').textContent;
        const priceText = item.querySelector('.price').textContent.replace(' VND', '').replace(/\./g, '');
        const price = parseInt(priceText, 10) / quantity;
        const imageUrl = item.querySelector('.product-image_selected').getAttribute('src'); // Lấy URL hình ảnh từ thuộc tính 'src'

        products.push({
            id: productId,
            quantity: quantity,
            price: price,
            image: imageUrl // Thêm URL hình ảnh vào đối tượng sản phẩm
        });
    });
    console.log('Products:', products);

    $.ajax({
        url: '/home/payment',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ products: products }),
        success: function (data) {
            if (data.success) {
                window.location.href = '/home/payment';
            } else {
                alert('Có lỗi xảy ra khi chuyển đến trang thanh toán');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
        }
    });
}

function removeProductFromCart(productId) {
    const productItem = document.querySelector(`.product-items .product-details[value="${productId}"]`).closest('.product-items');

    if (productItem) {
        $.ajax({
            url: `/home/cart/remove/${productId}`,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ product_id: productId }),
            success: function (data) {
                productItem.remove();
                if (data.success) {
                    alert('Sản phẩm đã được xóa khỏi giỏ hàng');
                } else {
                    alert('Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    } else {
        console.error('Product not found in cart');
    }
}