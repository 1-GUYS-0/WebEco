document.addEventListener('DOMContentLoaded', function () {
    const selectElement = document.getElementById('nanalystTime');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    selectElement.addEventListener('change', function () {
        const selectedValue = selectElement.value;

        fetch('/admin/dashboard/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ filter: selectedValue })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật giao diện với dữ liệu mới
                document.getElementById('newOrdersCount').textContent = data.newOrdersCount;
                document.getElementById('todayOrdersCount').textContent = data.todayOrdersCount;
                document.getElementById('newCustomersCount').textContent = data.newCustomersCount;
                document.getElementById('todayRevenue').textContent = data.todayRevenue;
                document.getElementById('totalRevenue').textContent = data.totalRevenue;
            } else {
                alert('Không tìm thấy dữ liệu.');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});