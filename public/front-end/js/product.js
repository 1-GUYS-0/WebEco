$(document).ready(function() {
    // Định nghĩa function loadMoreProducts
    function loadMoreProducts() {
        var page = $('#load-more').data('page'); // Lấy giá trị của data-page
        console.log('Page:', page);
        $.ajax({
            url: loadmore_product, // URL của API endpoint
            type: 'GET',
            data: { page: page }, // Gửi tham số page
            beforeSend: function() {
                $('#load-more').text('Loading...');
            },

            success: function(data) { // Sử dụng callback function để lấy dữ liệu trả về
                checkDataResponse(data, page); // Gọi hàm checkDataResponse với dữ liệu trả về và trang hiện tại
            },
            error: function(xhr, status, error) {
                alert('Error: ' + xhr.responseJSON.error); // Hiển thị hộp thoại thông báo lỗi
                console.error(xhr.responseText);
                console.error(status);
                $('#load-more').text('Load More');
            }
        });
    }

    // Đây là function kiểm tra dữ liệu trả về từ API
    function checkDataResponse(data, page) {
        if (data.trim()) {
            $('#product-list').append(data); // Chèn dữ liệu vào danh sách sản phẩm
            $('#load-more').data('page', page + 1); // Tăng giá trị của data-page lên 1
            $('#load-more').text('Load More');
        } else {
            $('#load-more').text('Hide All !'); // Thay đổi văn bản của nút
            $('#load-more').off('click'); // Loại bỏ sự kiện click hiện tại
            $('#load-more').click(function() { // Thêm sự kiện click mới
                $('#product-list .trending-prods_cards').slice(3).hide(); // Ẩn tất cả ngoại trừ 3 dữ liệu đầu tiên
                $('#load-more').text('Load More'); // Đặt lại văn bản của nút
                $('#load-more').data('page', 2); // Đặt lại giá trị của data-page
                $('#load-more').off('click'); // Loại bỏ sự kiện click hiện tại
                $('#load-more').click(loadMoreProducts); // Đặt lại sự kiện click ban đầu
            });
        }
    }

    // Gán function loadMoreProducts cho sự kiện click của nút load-more
    $('#load-more').click(loadMoreProducts);
});

// function checkScroll() // Kiểm tra vị trí cuộn của trang web và gọi hàm loadMoreProducts nếu cần thiết để tải thêm sản phẩm
// {
//     if ($(window).scrollTop() + $(window).height() >= $(document).height() - 300) {
//         loadMoreProducts();
//     }
// }