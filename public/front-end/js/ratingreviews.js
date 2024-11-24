document.addEventListener('DOMContentLoaded', function () {
    var ratingsDataElement = document.getElementById('ratings-data');
    var ratingsData = JSON.parse(ratingsDataElement.getAttribute('data-rating'));

    var ratings = ratingsData.ratings;
    var averageRating = ratingsData.averageRating;
    var totalRatings = ratingsData.totalRatings;

    // Cập nhật tổng số sao đánh giá và tổng số đánh giá
    document.querySelector('.rating-summary h1').textContent = `${averageRating}/5`;
    document.querySelector('.rating-summary p').textContent = `${totalRatings} reviews`;

    // Cập nhật chi tiết số đánh giá cho mỗi sao
    for (var i = 1; i <= 5; i++) {
        var ratingCount = ratings[i] || 0;
        var percentage = (ratingCount / totalRatings) * 100;

        document.querySelector(`.rating-row:nth-child(${6 - i}) .rating-count`).textContent = ratingCount;
        document.querySelector(`.rating-row:nth-child(${6 - i}) .fill`).style.width = `${percentage}%`;
    }
});