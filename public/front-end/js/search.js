function filterProducts() {
    const category = document.getElementById('category').value;
    const skinType = document.getElementById('skin_type').value;
    const rating = document.getElementById('rating').value;
    const searchName = document.getElementById('search_name').value;
    const priceOrder = document.getElementById('price_order').value;

    const params = new URLSearchParams({
        category: category,
        skin_type: skinType,
        rating: rating,
        search_name: searchName,
        price_order: priceOrder
    });

    fetch(`/home/customer/search?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';

            data.products.forEach(product => {
                const productCard = `
                    <div class="search-item">
                        <div class="product-search-card">
                            <div class="product-imge-card">
                                <img src="/${product.images[0].image_path}" alt="${product.name}">
                            </div>
                            <div class="cards_contain">
                                <a class="cards_name-prod" href="/home/customer/product/${product.id}">${product.name}</a>
                                <div class="cards_desc-prod">${product.description}</div>
                                <div class="cards_price-prod">${product.price} VND</div>
                            </div>
                        </div>
                    </div>
                `;
                productList.insertAdjacentHTML('beforeend', productCard);
            });
        })
        .catch(error => console.error('Error:', error));
}