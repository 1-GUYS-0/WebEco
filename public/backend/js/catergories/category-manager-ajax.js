$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
// Cài đặt token CSRF cho các yêu cầu AJAX

$(document).ready(function () {
    $('.delete-category').click(function () {
        const categoryId = $(this).data('id');
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: `/categories/delete-category/${categoryId}`,
                method: 'DELETE',
                success: function (response) {
                    if (response.success) {
                        alert(response.success);
                        location.reload(); // Reload lại toàn bộ trang sau khi xóa thành công

                    } else {
                        alert(response.error);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the category.');
                }
            });
        }
    });
});