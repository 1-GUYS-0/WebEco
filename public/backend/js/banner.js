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

function showDetailBanner(bannerId) {
    fetch(`/admin/banners/${bannerId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                document.getElementById('idBanner').innerText = data.banner.id;
                document.getElementById('titleBanner').value = data.banner.title;
                document.getElementById('startDateBanner').value = data.banner.start_date;
                document.getElementById('endDateBanner').value = data.banner.end_date;
                document.getElementById('linkToBanner').value = data.banner.link_to;

                const listImageBanner = document.getElementById('listImageBanner');
                listImageBanner.innerHTML = `<img src="${data.banner.images_path}" />`;

                showTab('detailBanner');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
        });
}

function addBanner() {
    const title = document.getElementById('titleBanner-input').value;
    const startDate = document.getElementById('startDateBanner-input').value;
    const endDate = document.getElementById('endDateBanner-input').value;
    const linkTo = document.getElementById('linkToBanner-input').value;
    const imageInput = document.getElementById('imageInput-input').files[0];

    const formData = new FormData();
    formData.append('title', title);
    formData.append('start_date', startDate);
    formData.append('end_date', endDate);
    formData.append('link_to', linkTo);
    formData.append('image', imageInput);

    fetch('/admin/banners/add', {
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

function updateBanner() {
    const bannerId = document.getElementById('idBanner').innerText;
    const title = document.getElementById('titleBanner').value;
    const startDate = document.getElementById('startDateBanner').value;
    const endDate = document.getElementById('endDateBanner').value;
    const linkTo = document.getElementById('linkToBanner').value;
    const imageInput = document.getElementById('imageInput').files[0];

    const formData = new FormData();
    formData.append('id', bannerId);
    formData.append('title', title);
    formData.append('start_date', startDate);
    formData.append('end_date', endDate);
    formData.append('link_to', linkTo);
    if (imageInput) {
        formData.append('image', imageInput);
    }

    fetch('/admin/banners/update', {
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

function deleteBanner() {
    const bannerId = document.getElementById('idBanner').innerText;

    fetch('/admin/banners/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: bannerId })
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