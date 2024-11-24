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

    fetch(`/home/search/search?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            const productList = document.getElementById('product-list');
            productList.innerHTML = '';

            data.products.forEach(product => {
                let priceHtml;
                if (product.promotion && new Date() >= new Date(product.promotion.promotion_start) && new Date() <= new Date(product.promotion.promotion_end)) {
                    let discountedPrice = product.price - (product.price * product.promotion.percent_promotion / 100);
                    priceHtml = `
                        <h3>
                            <span>Giá: ${discountedPrice.toLocaleString('de-DE')}</span>
                            <span style="text-decoration: line-through;color: red;">${product.price.toLocaleString('de-DE')}</span>
                        </h3>
                        `;
                } else {
                    priceHtml = `<h3>Giá: ${product.price.toLocaleString('de-DE')}</h3>`;
                }
                const productCard = `
                    <div class="search-item">
                        <div class="product-search-card">
                            <div class="product-imge-card">
                                <img src="${product.images[0].image_path}" alt="${product.name}">
                            </div>
                            <div class="cards_contain">
                                <h3>
                                    <a class="cards_name-prod close-bt" href="/home/product/${product.id}" onclick="saveProductToLocalStorage('${product.id}')" >${product.name}</a>
                                </h3>
                                <div class="cards_desc-prod">${product.brand}</div>
                                <div class="product-detail_price">${priceHtml}</div>
                            </div>
                        </div>
                    </div>
                `;
                productList.insertAdjacentHTML('beforeend', productCard);
            });
        })
        .catch(error => console.error('Error:', error));
}