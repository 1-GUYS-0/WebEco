function generateStars(rating) {
    let starsHtml = '';
    for (let i = 0; i < rating; i++) {
        starsHtml += '<img src="/system/star.png" alt="star">';
    }
    return starsHtml;
}
function openTab(event, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content-rv");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tab-button-rv");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active-rv", "");
    }
    document.getElementById(tabName).style.display = "block";
    event.currentTarget.className += " active-rv";
}

function applyFilters() {
    var timeSort = document.getElementById("timeSort-rv").value;
    var starFilter = document.getElementById("starFilter-rv").value;
    var productId = document.getElementById("productId-rv").textContent;
    
    console.log("Applying filters: Time Sort - " + timeSort + ", Star Filter - " + starFilter);
    
    fetch(`/home/product/${productId}/review/filter`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            timeSort: timeSort,
            starFilter: starFilter
        })
    })
    .then(response => response.json())
    .then(data => {
        // Update the reviews list with the filtered data
        console.log(data);
        updateReviews(data.comments);
        // updateImages(data.comments);
        // Implement the logic to update the reviews list in the DOM
    })
    .catch(error => console.error('Error:', error));
}

function updateReviews(comments) {
    var reviewsList = document.querySelector('.reviews-list-rv');
    reviewsList.innerHTML = ''; // Clear existing reviews

    comments.forEach(comment => {
        var reviewHtml = `
            <div class="review">
                <div>
                    <img class="user-pic" src="/${comment.customer.avatar_path}" alt="${comment.customer.name}" />
                </div>
                <div class="comment_content">
                    <div class="review-meta">
                        <div class="user-info">
                            <h5 class="user-name">${comment.customer.name}</h5>
                            <h6 class="review-date">${new Date(comment.created_at).toLocaleDateString()}</h6>
                        </div>
                        <div class="stars">
                            ${generateStars(comment.rating)}
                        </div>
                    </div>
                    <div class="review-text">
                        ${comment.content}
                    </div>
                    ${comment.images ? `
                    <div class="review_images">
                        ${JSON.parse(comment.images).map(image => `
                        <div class="size_review_images">
                            <img class="size_review_images" src="${image}" alt="Comment Image">
                        </div>`).join('')}
                    </div>` : ''}
                </div>
            </div>
        `;
        reviewsList.insertAdjacentHTML('beforeend', reviewHtml);
    });
}

function updateImages(comments) {
    var imagesList = document.getElementById('images-rv');
    imagesList.innerHTML = ''; // Clear existing images

    comments.forEach(comment => {
        if (comment.images) {
            JSON.parse(comment.images).forEach(image => {
                var imageHtml = `
                    <div class="image-item-rv">
                        <img src="${image}" alt="Review Image">
                        <span class="image-date-rv">${new Date(comment.created_at).toLocaleDateString()}</span>
                    </div>
                `;
                imagesList.insertAdjacentHTML('beforeend', imageHtml);
            });
        }
    });
}
// Initialize the first tab as active
document.addEventListener("DOMContentLoaded", function() {
    document.getElementsByClassName("tab-button-rv")[0].click();
});