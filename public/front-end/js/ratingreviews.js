document.addEventListener('DOMContentLoaded', function () {
    var ratingsDataElement = document.getElementById('ratings-data');
    var averageRatingDataElement = document.getElementById('average-rating-data');
    var totalRatingsDataElement = document.getElementById('total-ratings-data');

    var ratingsData = JSON.parse(ratingsDataElement.textContent);
    var averageRating = JSON.parse(averageRatingDataElement.textContent);
    var totalRatings = JSON.parse(totalRatingsDataElement.textContent);

    // Cập nhật tổng số sao đánh giá và tổng số đánh giá
    document.querySelector('.rating-summary h1').textContent = `${averageRating}/5`;
    document.querySelector('.rating-summary p').textContent = `${totalRatings} reviews`;

    // Cập nhật chi tiết số đánh giá cho mỗi sao
    for (var i = 1; i <= 5; i++) {
        var ratingCount = ratingsData[i] || 0;
        var percentage = (ratingCount / totalRatings) * 100;

        document.querySelector(`.rating-row:nth-child(${6 - i}) .rating-count`).textContent = ratingCount;
        document.querySelector(`.rating-row:nth-child(${6 - i}) .fill`).style.width = `${percentage}%`;
    }
});