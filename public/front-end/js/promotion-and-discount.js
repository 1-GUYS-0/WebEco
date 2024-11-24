function copyCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        alert('Đã sao chép mã: ' + code);
    }).catch(err => {
        console.error('Lỗi khi sao chép mã: ', err);
    });
}
document.addEventListener('DOMContentLoaded', function () {
    if (document.getElementById('9-12-hour-discounts') === null) {
        return;
    }
    else {
        var startTime = '09:00:00';
        var endTime = '12:00:00';

        var endDateTime = new Date();
        var [endHours, endMinutes, endSeconds] = endTime.split(':');
        endDateTime.setHours(endHours);
        endDateTime.setMinutes(endMinutes);
        endDateTime.setSeconds(endSeconds);

        var countdownElement = document.getElementById('countdown');
        var interval = setInterval(function () {
            var now = new Date().getTime();
            var distance = endDateTime - now;

            if (distance > 0) {
                clearInterval(interval);
                countdownElement.innerHTML = "Chưa đến thời gian khuyến mãi, hãy quay lại sau!";
                return;
            }

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdownElement.innerHTML = hours + "h " + minutes + "m " + seconds + "s ";
        }, 1000);
    }
});