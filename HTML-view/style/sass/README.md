**File css chính sẽ nằm ở main.css**
/utility
    Bao gồm các file đơn cấu trúc, như 1 kho lưu trữ
/visual_test
    Nơi xem thử các liên kết hoặc chuyển đổi css có thành công và có lỗi gì không.
/global
    Đây là nơi các đoạn code phức tạp đa cấu trúc được lưu trữ và sữ dụng cục bộ. Trong đây có 2 phần là code cấu trúc tái sử dụng được lưu trong /x_custom-struture và được link về 1 nguồn gốc là share_link, đây cũng là nơi link với utility. Các file link trong share_link chỉ được là những đoạn tái sử dụng(@mixin). Phần thứ hai là code dùng cho cục bộ lưu vào global.
/custom
    lưu trữ các đoạn code riêng biệt, có tính độc bản hoặc ít lặp lại trong cách trang khác nhau
/main
    là nơi cuối cùng tổng hợp tất cả các code css, nó không chứa các @mixin