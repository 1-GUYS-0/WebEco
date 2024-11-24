function showTab(idTab) {
    const closeModalButtons = document.querySelectorAll('.close-btn');
    const modal = document.getElementById(idTab);
    modal.style.display = 'block';

    closeModalButtons.forEach(button => {
        button.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
}

function showDetailProduct(productId) {
    fetch(`/admin/products/${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const product = data.product;
                const categories = data.categories;
                const promotions = data.promotions;

                // Hiển thị thông tin sản phẩm
                document.getElementById('idProduct-input').value = product.id;
                document.getElementById('nameProduct-input').value = product.name;
                document.getElementById('brandProduct-input').value = product.brand;
                document.getElementById('weightProduct-input').value = product.weight;
                document.getElementById('smellProduct-input').value = product.smell;
                document.getElementById('textureProduct-input').value = product.texture;
                document.getElementById('ingreMainProduct-input').value = product.main_ingredient;
                document.getElementById('skinProduct-input').value = product.skin;
                document.getElementById('detailProduct-input').value = product.description;
                document.getElementById('noteProduct-input').value = product.note;
                document.getElementById('allIngredientProduct-input').value = product.ingredient;
                document.getElementById('HTUProduct-input').value = product.htu;
                document.getElementById('quantityProduct-input').value = product.stock;
                document.getElementById('priceProduct-input').value = product.price;

                // Cập nhật danh mục sản phẩm
                const cateProductSelect = document.getElementById('cateProduct-input');
                cateProductSelect.innerHTML = categories.map(category => 
                    `<option value="${category.id}" ${category.id === product.category_id ? 'selected' : ''}>${category.name}</option>`
                ).join('');

                // Cập nhật sự kiện khuyến mãi
                const promotionProductSelect = document.getElementById('promotionProduct-input');
                promotionProductSelect.innerHTML = `<option value="">Không khuyến mãi</option>`;
                promotionProductSelect.innerHTML += promotions.map(promotion => 
                    `<option value="${promotion.id}" ${promotion.id === product.promotion_id ? 'selected' : ''}>${promotion.name}--sale:${promotion.percent_promotion}</option>`
                ).join('');

                
                const listImage = document.getElementById('listImage-input');
                listImage.innerHTML = '';
                data.product.images.forEach(image => {
                    const img = document.createElement('img');
                    img.src = `${image.image_path}`;
                    listImage.appendChild(img);
                });

                showTab('detailProductTab');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
        });
}

function handleFileSelect(event, elementId) {
    const files = event.target.files;
    const listImage = document.getElementById(elementId);
    listImage.innerHTML = '';

    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            listImage.appendChild(img);
        };

        reader.readAsDataURL(file);
    }
}

function updateProduct() {
    const productId = document.getElementById('idProduct-input').value;
    const name = document.getElementById('nameProduct-input').value;
    const brand = document.getElementById('brandProduct-input').value;
    const weight = document.getElementById('weightProduct-input').value;
    const smell = document.getElementById('smellProduct-input').value;
    const texture = document.getElementById('textureProduct-input').value;
    const mainIngredient = document.getElementById('ingreMainProduct-input').value;
    const skin = document.getElementById('skinProduct-input').value;
    const detail = document.getElementById('detailProduct-input').value;
    const note = document.getElementById('noteProduct-input').value;
    const allIngredient = document.getElementById('allIngredientProduct-input').value;
    const htu = document.getElementById('HTUProduct-input').value;
    const quantity = document.getElementById('quantityProduct-input').value;
    const price = document.getElementById('priceProduct-input').value;
    const categoryId = document.getElementById('cateProduct-input').value;
    const promotionId = document.getElementById('promotionProduct-input').value;
    const images = document.getElementById('imageInput-input').files;

    const formData = new FormData();
    formData.append('id', productId);
    formData.append('nameProduct', name);
    formData.append('brandProduct', brand);
    formData.append('weightProduct', weight);
    formData.append('smellProduct', smell);
    formData.append('textureProduct', texture);
    formData.append('ingreMainProduct', mainIngredient);
    formData.append('skinProduct', skin);
    formData.append('detailProduct', detail);
    formData.append('noteProduct', note);
    formData.append('allIngredientProduct', allIngredient);
    formData.append('HTUProduct', htu);
    formData.append('quantityProduct', quantity);
    formData.append('priceProduct', price);
    formData.append('cateProduct', categoryId);
    formData.append('promotionProduct', promotionId);

    for (let i = 0; i < images.length; i++) {
        formData.append('images[]', images[i]);
    }

    fetch('/admin/products/update', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}

function deleteProduct() {
    const productId = document.getElementById('idProduct-input').value;

    fetch('/admin/products/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}

function addProduct() {
    const name = document.getElementById('nameProduct').value;
    const brand = document.getElementById('brandProduct').value;
    const weight = document.getElementById('weightProduct').value;
    const smell = document.getElementById('smellProduct').value;
    const texture = document.getElementById('textureProduct').value;
    const mainIngredient = document.getElementById('ingreMainProduct').value;
    const skin = document.getElementById('skinProduct').value;
    const detail = document.getElementById('detailProduct').value;
    const note = document.getElementById('noteProduct').value;
    const allIngredient = document.getElementById('allIngredientProduct').value;
    const htu = document.getElementById('HTUProduct').value;
    const quantity = document.getElementById('quantityProduct').value;
    const price = document.getElementById('priceProduct').value;
    const categoryId = document.getElementById('cateProduct').value;
    const promotionId = document.getElementById('promotionProduct').value;
    const images = document.getElementById('imageInput').files;

    const formData = new FormData();
    formData.append('nameProduct', name);
    formData.append('brandProduct', brand);
    formData.append('weightProduct', weight);
    formData.append('smellProduct', smell);
    formData.append('textureProduct', texture);
    formData.append('ingreMainProduct', mainIngredient);
    formData.append('skinProduct', skin);
    formData.append('detailProduct', detail);
    formData.append('noteProduct', note);
    formData.append('allIngredientProduct', allIngredient);
    formData.append('HTUProduct', htu);
    formData.append('quantityProduct', quantity);
    formData.append('priceProduct', price);
    formData.append('cateProduct', categoryId);
    formData.append('promotionProduct', promotionId);

    for (let i = 0; i < images.length; i++) {
        formData.append('images[]', images[i]);
    }

    fetch('/admin/products/add', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
    });
}