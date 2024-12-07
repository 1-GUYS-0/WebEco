-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 07, 2024 lúc 10:04 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `webeco`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `addresses`
--

INSERT INTO `addresses` (`id`, `customer_id`, `phone`, `address`, `province`, `district`, `ward`, `is_default`, `created_at`, `updated_at`) VALUES
(4, 7, '0915324638', '12AA', 'Hà Nội', 'Gia Lâm', 'kim-sơn', 1, '2024-11-19 10:08:47', '2024-11-19 10:08:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','sale') NOT NULL DEFAULT 'admin',
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`name`, `email`, `password`, `role`, `id`, `created_at`, `updated_at`) VALUES
('admin', 'dvq@gmail.com', '$2y$12$wVTVBjqIipGiNyvIqq1KguAFpnojoVPKZ7uEDYyRzqqCd8jfvdXs2', 'admin', 1, NULL, NULL),
('consultant', 'nv1@gmail.com', '$2y$12$15wjqYPsGC8DXx16XSyUw.iiuN7O39xL3/1eLZfezxUCBBBfYTYHi', 'sale', 2, NULL, NULL),
('NGUYEN VAN A', 'NV2@gmail.com', '$2y$12$y8h7jzfn8bGqybYhIVIo9uIGCWgHRbqrJZd/3gjOfHWC6QTBsLZeq', 'sale', 3, '2024-11-19 14:23:24', '2024-11-19 14:23:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `images_path` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `link_to` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `banners`
--

INSERT INTO `banners` (`id`, `title`, `images_path`, `start_date`, `end_date`, `link_to`, `created_at`, `updated_at`) VALUES
(1, 'Summer Sale', 'storage/banner_images/slide1.jpg', '2024-06-01', '2024-12-30', 'http://127.0.0.1:8000/home/promotion/first-promotion', '2024-11-19 08:26:03', '2024-11-19 09:36:31'),
(2, 'Naturel Beauty', 'storage/banner_images/slide2.jpg', '2023-12-01', '2024-12-31', 'https://example.com/winter-sale', '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(3, 'Winter Sale', 'storage/banner_images/slide2.jpg', '2024-12-01', '2024-12-31', 'https://example.com/winter-sale', '2024-11-19 08:26:03', '2024-11-19 08:26:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `created_at`, `updated_at`) VALUES
(2, 7, '2024-11-19 09:50:47', '2024-11-19 09:50:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(11, 2, 1, 1, '2024-11-21 00:26:17', '2024-11-21 00:26:17');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_category` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_category`, `created_at`, `updated_at`) VALUES
(1, 'Chăm sóc da', 1, NULL, '2024-11-19 14:00:46'),
(2, 'Chăm sóc tóc', NULL, NULL, NULL),
(3, 'Tắm và Dưỡng thể', NULL, NULL, NULL),
(4, 'Dưỡng môi', NULL, NULL, NULL),
(6, 'dm1', NULL, '2024-11-19 14:01:42', '2024-11-19 14:01:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`id`, `product_id`, `customer_id`, `rating`, `images`, `content`, `created_at`, `updated_at`) VALUES
(3, 2, 2, 5, NULL, 'Average product.', '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(4, 2, 2, 3, '[\"storage\\/comment_images\\/comment221.jpg\"]', 'Average product.', '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(5, 1, 7, 5, '[\"storage\\/comment_images\\/Ju1X2so2I4lHaduH9CEzqS9qtH3NXXUggPAQprbG.png\"]', 'sản phẩm tốt', '2024-11-20 05:28:42', '2024-11-20 05:28:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `number_phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'unverified',
  `verification_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `email_verified_at`, `number_phone`, `password`, `avatar_path`, `status`, `verification_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Alice', 'alice@gmail.com', NULL, '0123456701', '$2y$12$X3njBVT.fLecW6pQD.1TXuxT2oCT7s4jB3QDqqXwstKmr402X3Eh6', '/storage/avatar_customer/avatar_u3.webp', 'unverified', NULL, NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(7, 'robinson guys', '20166016@st.hcmuaf.edu.vn', '2024-11-19 09:23:09', '0915324638', '$2y$12$J1ewmlqg245yIn3R2Szb4eCQQgkI1DatdNFKBsp67ED4J8I1n9wzK', '/storage/avatar_customer/WKX4YWq3yzgldLyP2lS9iiKn0Rv5vz9YOrppDT5E.jpg', 'verified', NULL, NULL, '2024-11-19 09:22:41', '2024-11-21 01:49:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_password_resets`
--

CREATE TABLE `customer_password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1230, '0000_01_01_135227_create_customers_table', 1),
(1231, '0001_01_01_000000_create_users_table', 1),
(1232, '0001_01_01_000001_create_cache_table', 1),
(1233, '2024_08_01_021304_create_categories_table', 1),
(1234, '2024_08_01_172602_create_promotions_table', 1),
(1235, '2024_08_02_021547_create_products_table', 1),
(1236, '2024_09_23_145329_create_product_images_table', 1),
(1237, '2024_09_29_075445_create_banners_table', 1),
(1238, '2024_09_29_135359_create_addresses_table', 1),
(1239, '2024_09_29_135411_create_orders_table', 1),
(1240, '2024_09_29_135416_create_order_items_table', 1),
(1241, '2024_09_29_135422_create_payments_table', 1),
(1242, '2024_09_29_135423_create_vnpaypayments_table', 1),
(1243, '2024_09_29_135428_create_carts_table', 1),
(1244, '2024_09_29_135432_create_cart_items_table', 1),
(1245, '2024_10_02_035124_create_comments_table', 1),
(1246, '2024_10_04_145820_create_vouchers_table', 1),
(1247, '2024_10_07_034549_create_customer_password_resets_table', 1),
(1248, '2024_10_13_090535_create_admins_table', 1),
(1249, '2024_10_17_220231_create_refund_requests_table', 1),
(1250, '2024_10_19_171205_create_notifications_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`id`, `customer_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(2, 2, 'Thông báo mẫu', 'Đây là thông báo mẫu cho người dùng Alice', 0, '2024-11-19 08:26:04', '2024-11-19 08:26:04'),
(7, 7, 'Đăng ký thành công', 'Chào mừng khách hàng mới! tặng bạn mã giảm giá 25% trên tổng sản phẩm thanh toán, SP-50-30.', 0, '2024-11-19 09:22:44', '2024-11-19 09:22:44'),
(8, 7, 'Đơn hàng thành công', 'Đơn hàng số21của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-19 16:52:46', 0, '2024-11-19 09:52:46', '2024-11-19 09:52:46'),
(9, 7, 'Đơn hàng thành công', 'Đơn hàng số22của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-19 17:07:29', 0, '2024-11-19 10:07:29', '2024-11-19 10:07:29'),
(10, 7, 'Đơn hàng thành công', 'Đơn hàng số23của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-19 17:09:48', 0, '2024-11-19 10:09:48', '2024-11-19 10:09:48'),
(11, 7, 'Đơn hàng thành công', 'Đơn hàng số24 thánh toán VNPAY của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-19 17:14:09', 0, '2024-11-19 10:14:09', '2024-11-19 10:14:09'),
(12, 7, 'Yêu cầu hoàn trả đã được xác nhận', 'Yêu cầu hoàn trả cho đơn hàng #23 đã được xác nhận thành công. Shipper sẽ liên hệ với bạn để nhận lại hàng trong thời gian sớm nhất.', 0, '2024-11-19 14:13:37', '2024-11-19 14:13:37'),
(13, 7, 'Yêu cầu hoàn trả đã bị từ chối', 'Yêu cầu hoàn trả cho đơn hàng #23 đã bị từ chối. Lý do: quá thời gian', 0, '2024-11-19 14:14:06', '2024-11-19 14:14:06'),
(14, 7, 'Yêu cầu hoàn trả đã bị từ chối', 'Yêu cầu hoàn trả cho đơn hàng #23 đã bị từ chối. Lý do: quá thời gian', 0, '2024-11-19 14:14:11', '2024-11-19 14:14:11'),
(15, 7, 'Đơn hàng thành công', 'Đơn hàng số25của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-20 12:28:05', 0, '2024-11-20 05:28:05', '2024-11-20 05:28:05'),
(16, 7, 'Đơn hàng thành công', 'Đơn hàng số26của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-20 12:55:08', 1, '2024-11-20 05:55:08', '2024-11-20 05:55:24'),
(17, 7, 'Đơn hàng thành công', 'Đơn hàng số27của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-21 07:05:26', 0, '2024-11-21 00:05:26', '2024-11-21 00:05:26'),
(18, 7, 'Đơn hàng thành công', 'Đơn hàng số28của khách hàng: robinson guys đã được đặt thành công vào lúc 2024-11-21 07:25:57', 1, '2024-11-21 00:25:57', '2024-11-21 01:41:58');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `shipping_method` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `subtotal` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `order_quantity` int(11) NOT NULL,
  `status` enum('pending','shipping','completed','rated','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `name`, `address`, `phone`, `shipping_method`, `message`, `subtotal`, `discount`, `shipping`, `total_price`, `order_quantity`, `status`, `created_at`, `updated_at`) VALUES
(4, 2, 'Phạm Thị D', 'TP.HCM, Quận 7, Phường Tân Phong, 910 Đường D', '971236543', 'ahamove', 'Đóng gói cẩn thận', 800000, 10000.00, 30000, 820000, 5, 'completed', '2024-04-18 14:16:00', '2024-04-18 14:16:00'),
(6, 2, 'Vũ Thị F', 'Cần Thơ, Quận Ninh Kiều, Phường An Lạc, 101 Đường F', '921345678', 'ahamove', 'Không có ghi chú', 450000, 0.00, 30000, 480000, 3, 'completed', '2024-06-07 14:16:00', '2024-06-07 14:16:00'),
(7, 2, 'Nguyễn Văn G', 'Hà Nội, Quận Thanh Xuân, Phường Khương Đình, 222 Đường G', '977654321', 'GHN', 'Giao hàng giờ hành chính', 250000, 5000.00, 25000, 270000, 1, 'pending', '2024-07-15 14:16:00', '2024-07-15 14:16:00'),
(10, 2, 'Hoàng Thị J', 'Bình Dương, Thị Xã Dĩ An, Phường Dĩ An, 555 Đường J', '942223333', 'ahamove', 'Giao hàng sau 6h tối', 700000, 5000.00, 30000, 725000, 2, 'completed', '2024-10-09 14:16:00', '2024-10-09 14:16:00'),
(11, 2, 'Nguyễn Văn K', 'TP.HCM, Quận 4, Phường 12, 666 Đường K', '934445555', 'GHN', 'Không có ghi chú', 550000, 25000.00, 25000, 550000, 3, 'completed', '2024-01-10 14:16:00', '2024-01-10 14:16:00'),
(16, 2, 'Trần Thị P', 'Hải Phòng, Quận Ngô Quyền, Phường Đằng Lâm, 101 Đường P', '967112233', 'ahamove', 'Giao vào buổi tối', 950000, 20000.00, 30000, 960000, 4, 'completed', '2024-06-11 14:16:00', '2024-06-11 14:16:00'),
(17, 2, 'Hoàng Văn Q', 'Hà Nội, Quận Hoàn Kiếm, Phường Tràng Tiền, 222 Đường Q', '933334444', 'GHN', 'Đóng gói cẩn thận', 320000, 5000.00, 25000, 340000, 2, 'completed', '2024-07-10 14:16:00', '2024-07-10 14:16:00'),
(18, 2, 'Phạm Thị R', 'TP.HCM, Quận Bình Thạnh, Phường 26, 333 Đường R', '988887777', 'ahamove', 'Giao trước 11h trưa', 450000, 15000.00, 30000, 475000, 2, 'completed', '2024-08-22 14:16:00', '2024-08-22 14:16:00'),
(19, 2, 'Lê Văn S', 'Đà Nẵng, Quận Cẩm Lệ, Phường Khuê Trung, 444 Đường S', '912223334', 'GHN', 'Không có ghi chú', 260000, 5000.00, 25000, 280000, 1, 'completed', '2024-09-28 14:16:00', '2024-09-28 14:16:00'),
(20, 2, 'Nguyễn Thị T', 'Cần Thơ, Quận Bình Thủy, Phường Trà An, 555 Đường T', '932224444', 'ahamove', 'Giao hàng vào buổi chiều', 1800000, 20000.00, 30000, 1850000, 7, 'completed', '2024-10-20 14:16:00', '2024-10-20 14:16:00'),
(23, 7, 'robinson guys', 'Hà Nội, Gia Lâm, kim-sơn', '0915324638', 'ahamove', NULL, 144000, 0.00, 30000, 174000, 1, 'refunded', '2024-11-19 10:09:48', '2024-11-19 14:13:37'),
(24, 7, 'robinson guys', 'Hà Nội, Gia Lâm, kim-sơn', '0915324638', 'ahamove', NULL, 144000, 0.00, 30000, 174000, 1, 'pending', '2024-11-19 10:14:09', '2024-11-19 10:14:09'),
(25, 7, 'robinson guys', 'Hà Nội, Gia Lâm, kim-sơn', '0915324638', 'ahamove', NULL, 116000, 0.00, 30000, 146000, 1, 'rated', '2024-11-20 05:28:05', '2024-11-20 05:28:42'),
(26, 7, 'robinson guys', 'Hà Nội, Gia Lâm, kim-sơn', '0915324638', 'ghn', NULL, 116000, 0.00, 0, 116000, 1, 'completed', '2024-11-20 05:55:08', '2024-11-20 05:56:02'),
(27, 7, 'robinson guys', 'Hà Nội, Gia Lâm, kim-sơn', '0915324638', 'ghn', NULL, 116000, 58000.00, 35000, 93000, 1, 'pending', '2024-11-21 00:05:26', '2024-11-21 00:05:26'),
(28, 7, 'robinson guys', 'Hà Nội, Gia Lâm, kim-sơn', '0915324638', 'ahamove', NULL, 144000, 72000.00, 30000, 102000, 1, 'pending', '2024-11-21 00:25:57', '2024-11-21 00:25:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(6, 4, 6, 2, 150000, '2024-04-18 14:16:00', '2024-04-18 14:16:00'),
(7, 4, 7, 3, 120000, '2024-04-18 14:16:00', '2024-04-18 14:16:00'),
(9, 6, 3, 2, 250000, '2024-06-07 14:16:00', '2024-06-07 14:16:00'),
(10, 6, 4, 1, 125000, '2024-06-07 14:16:00', '2024-06-07 14:16:00'),
(11, 7, 1, 1, 300000, '2024-07-15 14:16:00', '2024-07-15 14:16:00'),
(16, 10, 7, 2, 240000, '2024-10-09 14:16:00', '2024-10-09 14:16:00'),
(17, 11, 8, 1, 40000, '2024-01-10 14:16:00', '2024-01-10 14:16:00'),
(18, 11, 2, 1, 45000, '2024-01-10 14:16:00', '2024-01-10 14:16:00'),
(19, 11, 3, 1, 40000, '2024-01-10 14:16:00', '2024-01-10 14:16:00'),
(27, 16, 1, 1, 450000, '2024-06-11 14:16:00', '2024-06-11 14:16:00'),
(28, 16, 2, 2, 400000, '2024-06-11 14:16:00', '2024-06-11 14:16:00'),
(29, 17, 3, 2, 460000, '2024-07-10 14:16:00', '2024-07-10 14:16:00'),
(30, 18, 4, 2, 310000, '2024-08-22 14:16:00', '2024-08-22 14:16:00'),
(31, 19, 5, 1, 280000, '2024-09-28 14:16:00', '2024-09-28 14:16:00'),
(32, 20, 6, 4, 1000000, '2024-10-20 14:16:00', '2024-10-20 14:16:00'),
(33, 20, 8, 3, 850000, '2024-10-20 14:16:00', '2024-10-20 14:16:00'),
(36, 23, 2, 1, 144000, '2024-11-19 10:09:48', '2024-11-19 10:09:48'),
(37, 24, 2, 1, 144000, '2024-11-19 10:14:09', '2024-11-19 10:14:09'),
(38, 25, 1, 1, 116000, '2024-11-20 05:28:05', '2024-11-20 05:28:05'),
(39, 26, 1, 1, 116000, '2024-11-20 05:55:08', '2024-11-20 05:55:08'),
(40, 27, 1, 1, 116000, '2024-11-21 00:05:26', '2024-11-21 00:05:26'),
(41, 28, 2, 1, 144000, '2024-11-21 00:25:57', '2024-11-21 00:25:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `status` enum('unpaid','paid','refund') NOT NULL DEFAULT 'unpaid',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `amount`, `status`, `payment_date`, `created_at`, `updated_at`) VALUES
(4, 4, 'cash', 270000, 'paid', '2024-04-18 14:16:00', '2024-04-18 14:16:00', '2024-04-18 14:16:00'),
(6, 6, 'cash', 375000, 'unpaid', '2024-06-07 14:16:00', '2024-06-07 14:16:00', '2024-06-07 14:16:00'),
(7, 7, 'cash', 300000, 'paid', '2024-07-15 14:16:00', '2024-07-15 14:16:00', '2024-07-15 14:16:00'),
(10, 10, 'cash', 480000, 'paid', '2024-10-09 14:16:00', '2024-10-09 14:16:00', '2024-10-09 14:16:00'),
(11, 11, 'cash', 125000, 'paid', '2024-01-10 14:16:00', '2024-01-10 14:16:00', '2024-01-10 14:16:00'),
(16, 16, 'cash', 850000, 'paid', '2024-06-11 14:16:00', '2024-06-11 14:16:00', '2024-06-11 14:16:00'),
(17, 17, 'cash', 460000, 'paid', '2024-07-10 14:16:00', '2024-07-10 14:16:00', '2024-07-10 14:16:00'),
(18, 18, 'cash', 620000, 'paid', '2024-08-22 14:16:00', '2024-08-22 14:16:00', '2024-08-22 14:16:00'),
(19, 19, 'cash', 280000, 'paid', '2024-09-28 14:16:00', '2024-09-28 14:16:00', '2024-09-28 14:16:00'),
(20, 20, 'cash', 1850000, 'paid', '2024-10-20 14:16:00', '2024-10-20 14:16:00', '2024-10-20 14:16:00'),
(23, 23, 'cash', 174000, 'unpaid', '2024-11-19 10:09:48', '2024-11-19 10:09:48', '2024-11-19 10:09:48'),
(24, 24, 'vnpay', 174000, 'paid', '2024-11-19 10:14:09', '2024-11-19 10:14:09', '2024-11-19 10:14:09'),
(25, 25, 'cash', 146000, 'unpaid', '2024-11-20 05:28:05', '2024-11-20 05:28:05', '2024-11-20 05:28:05'),
(26, 26, 'cash', 116000, 'unpaid', '2024-11-20 05:55:08', '2024-11-20 05:55:08', '2024-11-20 05:55:08'),
(27, 27, 'cash', 93000, 'unpaid', '2024-11-21 00:05:26', '2024-11-21 00:05:26', '2024-11-21 00:05:26'),
(28, 28, 'cash', 102000, 'unpaid', '2024-11-21 00:25:57', '2024-11-21 00:25:57', '2024-11-21 00:25:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `smell` varchar(255) DEFAULT NULL,
  `texture` varchar(255) DEFAULT NULL,
  `htu` text DEFAULT NULL,
  `ingredient` text DEFAULT NULL,
  `main_ingredient` varchar(255) DEFAULT NULL,
  `skin` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `categories_id` bigint(20) UNSIGNED DEFAULT NULL,
  `total_rating` decimal(3,2) DEFAULT NULL,
  `total_purchase_quantity` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `promotion_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `brand`, `name`, `weight`, `type`, `price`, `description`, `smell`, `texture`, `htu`, `ingredient`, `main_ingredient`, `skin`, `stock`, `categories_id`, `total_rating`, `total_purchase_quantity`, `note`, `promotion_id`, `created_at`, `updated_at`) VALUES
(1, 'cocoon', 'Nước tẩy trang bí đao 140ml', '140ml', 'Tẩy Trang', 145000, 'Làn da dầu và mụn rất nhạy cảm nên cần ược thiết kế một loại nước tẩy trang phù hợp. Với công nghệ Micellar, nước tẩy trang bí ao giúp làm sạch hiệu quả lớp trang iểm, bụi bẩn và dầu thừa, mang lại làn da sạch hoàn toàn và dịu nhẹ.', 'Mùi tinh dầu tràm trà thoang thoảng', 'Dạng nước trong suốt không màu', 'Thấm ều sản phẩm lên bông tẩy trang, nhẹ nhàng lau khắp mặt ể làm sạch lớp trang iểm và bụi bẩn. Dịu nhẹ cho vùng môi và mắt.', 'Aqua/Water, Polyglyceryl-4 Laurate/Sebacate, Polyglyceryl-4 Caprylate/Caprate, Betaine, Benincasa Cerifera Fruit Extract, Centella Asiatica Extract, o-Cymen-5-ol, Propanediol, Glycereth-26, Glycerin, Trisodium Ethylenediamine Disuccinate, Sodium Lactate, Cetylpyridinium Chloride, Melaleuca Alternifolia Leaf Oil, Lactic Acid', 'Với chiết xuất bí ao, Rau má và Tràm trà', 'Da dầu, da mụn, da hỗn hợp thiên dầu', 87, 1, 5.00, 13, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', 1, '2024-11-19 08:26:03', '2024-11-21 00:05:26'),
(2, 'cocoon', 'Dầu tẩy trang hoa hồng 140ml', '140ml', 'Tẩy Trang', 180000, 'Dầu tẩy trang hoa hồng giúp làm sạch sâu lớp trang iểm, bụi bẩn và dầu thừa, dưỡng ẩm mà không ể lại cảm giác nhờn rít khó chịu.', 'Mùi hoa hồng thoang thoảng', 'Dạng dầu trong suốt không màu', 'N/A', 'GLYCERIN, AQUA/WATER, PEG-7 GLYCERYL COCOATE, C15-19 ALKANE, GLYCERETH-26, POLYSORBATE 20, ROSA DAMASCENA FLOWER OIL, TOCOPHERYL ACETATE, CARAMEL', 'Dầu hoa hồng và Vitamin E', 'Da khô, Da hỗn hợp thiên khô, Da thường', 89, 1, 4.00, 11, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', 1, '2024-11-19 08:26:03', '2024-11-21 00:25:57'),
(3, 'cocoon', 'Nước tẩy trang hoa hồng 140ml', '140ml', 'Tẩy Trang', 155000, 'Một công thức có tỉ lệ cân bằng từ nước cất hoa hồng hữu cơ, vitamin B5 và astaxanthin hoà quyện trong hệ nhũ hoá siêu nhỏ giúp tẩy sạch lớp trang iểm lâu trôi chỉ trong một bước, hỗ trợ cấp ẩm, làm mềm và làm dịu, mang lại làn da sạch sẽ và tươi mới.', 'Sản phẩm không có hương liệu', 'Dạng dầu và nước', 'Lắc ều. Thấm sản phẩm lên bông tẩy trang, nhẹ nhàng lau khắp mặt ể làm sạch lớp trang iểm và bụi bẩn. Dịu nhẹ cho vùng môi và mắt.', 'Aqua, Isohexadecane, Cyclopentasiloxane, Isononyl Isononanoate, Sodium Lactate, Rosa Damascena Flower Water, Polyglyceryl-4 Laurate/Sebacate, Polyglyceryl-4 Caprylate/Caprate, Caprylic/Capric Triglyceride, Haematococcus Pluvialis Extract, Rosmarinus Officinalis Leaf Extract, Panthenol, Glycerin, Hydroxymethoxyphe - Nyl Decanone, Trisodium Ethylenediamine Disuccinate, Lactic Acid, Cetylpyridinium Chloride.', 'Nước cất hoa hồng hữu cơ, Vitamin B5 & Astaxanthin', 'Mọi loại da', 93, 1, NULL, 7, 'Tránh ánh nắng mặt trời', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(4, 'cocoon', 'Gel bí ao rửa mặt 140ml', '140ml', 'Sữa Rửa Mặt', 195000, 'Với các thành phần gồm bí ao, rau má, tràm trà, bổ sung thêm Vitamin B3, B5 và Betaine. Gel bí ao có pH 5.5 giúp làm sạch sâu bụi bẩn và dầu thừa, làm giảm việc hình thành mụn mà vẫn giữ ược ộ ẩm mịn tự nhiên và không gây khô da sau khi sử dụng.', 'Mùi tràm trà thoang thoảng', 'Gel trong mờ màu nâu vàng', 'Lấy một lượng vừa ủ mát-xa nhẹ nhàng trên da ướt. Rửa sạch lại với nước. Dùng buổi sáng và tối.', 'Water/Aqua, Potassium Laureth Phosphate, Cocamidopropyl Betaine, Acrylates/Steareth-20 Methacrylate Copolymer, Sodium Cocoyl Glycinate, Cocoyl Methyl Glucamide, PEG-7-Glyceryl Cocoate, Glycerin, Benincasa Cerifera Fruit Extract, Salicylic Acid, Niacinamide, Panthenol, Centella Asiatica Extract , Betaine, Propanediol, Butylene Glycol, PEG-120 Methyl Glucose Dioleate, Molasses, Glycereth-26, Sodium Lactate, Sodium Hydroxide, Polysorbate 20, Melaleuca Alternifolia Leaf Oil, Rosmarinus Officinalis Leaf Oil, Lavandula Angustifolia Flower Oil, Allantoin, Ethylhexylglycerin, Phenoxyethanol, Xanthan gum, Menthyl Lactate, Trisodium Ethylenediamine Disuccinate', 'Với rau má và Tràm trà', 'Da dầu, da mụn, da hỗn hợp thiên dầu', 95, 1, NULL, 5, 'Tránh ể sản phẩm vào mắt', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(5, 'cocoon', 'Gel rửa mặt hoa hồng 140ml', '140ml', 'Sữa Rửa Mặt', 195000, 'Với công thức dịu nhẹ không sulfate, ây là sản phẩm rửa mặt lý tưởng hàng ngày giúp làm sạch bụi bẩn và các tạp chất mà không làm mất i ộ ẩm cần thiết của da, giúp bổ sung ẩm và mang lại làn da mềm mịn sau khi sử dụng.', 'Mùi hoa hồng thoang thoảng', 'Gel trong suốt không màu', '', 'Aqua/Water, Sodium Cocoyl Glycinate, Disodium Laureth Sulfosuccinate, Cocamidopropyl Betaine, Glycerin, Rosa Damascena Flower Water, Coco-Glucoside, PEG-120 Methyl Glucose Triisostearate, Cocoyl Methyl Glucamide, Sodium PEG-7 Olive Oil Carboxylate, PEG-7 Glyceryl Cocoate, Rosa Damascena Extract, Betaine, Propanediol, Glycereth-26, Allantoin, Butylene Glycol, PEG-120 Methyl Glucose Dioleate, Ethylhexylglycerin, Trisodium Ethylenediamine Disuccinate, Citric Acid, Phenoxyethanol, Caramel.', 'Nước cất hoa hồng hữu cơ, Betaine, Chiết xuất hoa hồng', 'Da khô, Da hỗn hợp thiên khô, Da thường', 95, 1, NULL, 5, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(6, 'cocoon', 'Sữa rửa mặt nghệ Hưng Yên 140ml', '140ml', 'Sữa Rửa Mặt', 195000, 'Với công thức dịu nhẹ không Sulfate, sữa rửa mặt từ nghệ Hưng Yên giúp làm sạch hiệu quả mà không gây khô da, ồng thời hỗ trợ làm sạch tế bào chết, mang lại làn da ều màu, mềm mịn và tươi sáng rạng rỡ.', 'Mùi nghệ thoang thoảng', 'Dạng sữa màu vàng nhạt', '', 'Aqua/Water, Disodium Cocoyl Glutamate, Potassium Laureth Phosphate, Sodium Laurylglucosides Hydroxypropylsulfonate, Lactic Acid, Glycerin, Polysorbate 20, PEG-120 Methyl Glucose Dioleate, Cetearyl Alcohol, Curcuma Longa (Turmeric) Root Extract, Glycolic Acid, Beta-Carotene, Daucus Carota Sativa (Carrot) Root Extract, Betaine, Allantoin, Propanediol, Glycereth-26, Cocoyl Methyl Glucamide, Ethylhexylglycerin, Xanthan Gum, Tocopherol, Glycine Soja (Soybean) Oil, Trisodium Ethylenediamine Disuccinate, Sodium Benzoate, Eucalyptus Globulus Leaf Oil, Potassium Sorbate, Phenoxyethanol.', 'Chiết xuất nghệ, cà rốt và AHA', 'Mọi loại da', 93, 1, NULL, 7, 'Khuyến khích dùng vào buổi tối. Nếu dùng vào buổi sáng nên dùng kèm kem chống nắng', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(7, 'cocoon', 'Nước dưỡng tóc sa-chi 140ml', '140ml', 'Nước Dưỡng Tóc', 145000, 'Nước dưỡng từ dầu sa-chi kết hợp với HA và các axit amin sẽ bao phủ toàn bộ mái tóc giúp cấp ẩm nhanh, củng cố và bảo vệ lớp sừng của tóc, từ ó phục hồi hư tổn giúp tóc trở nên ẩm mềm, chắc khoẻ ầy sức sống', 'Sản phẩm có mùi nhẹ nhàng của tinh dầu hương thảo, phong lữ, bạc hà thư giãn.', 'Dạng lỏng dễ thẩm thấu vào tóc và da dầu.', '', 'Water, Glycerin, PEG-12 Dimethicone, Plukenetia Volubilis (Inca Inchi) Seed Oil, Panthenol, Hydrolyzed Wheat Protein, Sodium Hyaluronate, Sodium Pca, Sodium Lactate, Arginine, Aspartic Acid, Pca, Glycine, Alanine, Serine, Valine, Proline, Threonine, Isoleucine, Histidine, Phenylalanine, Xylitylglucoside, Anhydroxylitol, Maltitol, Xylitol, Pelvetia Canaliculata Extract, Glycolic Acid, Tromethamine, Trisodium Ethylenediamine Disuccinate, PEG-40 Hydrogenated Castor Oil, PEG-7 Glyceryl Cocoate, Phenoxyethanol, Mentha Piperita Oil, Ocimum Gratissimum Herb Oil, Pelargonium Graveolens Oil, Parfum, Ethylhexylglycerin.', 'Dầu sa-chi, HA và axít amin', 'Mọi loại tóc', 95, 2, NULL, 5, 'Tránh dùng vùng mắt, chỉ dùng ngoài da.', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(8, 'cocoon', 'Nước dưỡng tóc tinh dầu bưởi 140ml', '140ml', 'Nước Dưỡng Tóc', 165000, 'Sản phẩm treatment dành cho tóc, phù hợp với tình trạng tóc rụng, tóc yếu, tóc thưa mỏng. Sản phẩm có thành phần từ tinh dầu bưởi Việt Nam truyền thống, Xylishine, Vitamin B5, Baicapil và Bisabolol. Nước dưỡng tóc tinh dầu bưởi giúp ngăn ngừa 60% nguyên nhân rụng tóc, làm gia tăng mật ộ của tóc, từ ó giúp tóc dày lên trông thấy. ồng thời, sản phẩm còn giúp nuôi dưỡng da ầu và cung cấp ộ ẩm cho tóc.', 'Mùi tinh dầu bưởi và tinh dầu bạc hà thanh mát', 'Gồm 2 lớp: lớp tinh dầu và lớp dung dịch dưỡng', '', 'Water, Isododecane, C15-19 Alkane, Glycerin, Citrus Grandis Peel Oil, Xylitylglucoside, Anhydroxylitol, Maltitol, Xylitol, Pelvetia Canaliculata Extract, Propanediol, Arginine, Lactic Acid, Glycine Soja Germ Extract, Triticum Vulgare Germ Extract, Scutellaria Baicalensis Root Extract, Bisabolol, Gluconolactone, Calcium Gluconate, Panthenol, Betaine, Citrus Aurantium Dulcis Peel Oil, Mentha Piperita Oil, Sodium Polyacrylate Starch, Glycereth-26, Phenyl Trimethicone, Caprylyl Methicone, Trisodium Ethylenediamine Disuccinate, Ethyhexylglycerin, Bht, Phenoxyethanol, Sodium Benzoate.', 'Tinh dầu vỏ bưởi nguyên chất, Vitamin B5 (Panthenol), Xylishine, Baicapil, Bisabolol.', 'Tóc yếu gãy rụng', 94, 2, NULL, 6, 'Tránh ể sản phẩm tiếp xúc với mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(9, 'cocoon', 'Dầu gội bưởi refill không sulfate 500ml', '500ml', 'Dầu Gội', 375000, 'Từ tinh dầu vỏ bưởi Việt Nam truyền thống kết hợp với vitamin B5, hoạt chất dưỡng ẩm Xylishine™ cùng công thức dịu nhẹ không chứa sulfate, dầu gội bưởi giúp làm sạch tóc và giảm gãy rụng, mang lại mái tóc en dày, chắc khoẻ và mượt mà', 'Mùi tinh dầu bưởi thơm mát', 'Dạng gel trong mờ màu trắng ngà', '', 'Aqua/Water, Sodium Cocoyl Isethionate, Sodium Laurylglucosides Hydroxypropylsulfonate, Glycerin, Disodium Laureth Sulfosuccinate, Cocamidopropyl Betaine, PEG-12 Dimethicone, PEG-7 Glyceryl Cocoate, Dimethicone, Citrus Grandis Peel Oil, Panthenol, Amodimethicone, Epilobium Angustifolium Flower/Leaf/Stem Extract, Thymus Vulgaris (Thyme) Extract, Triticum Vulgare (Wheat) Seed Extract, Cocoyl Methyl Glucamide, Calcium Pantothenate, Pyridoxine Hcl, Sodium PCA, Sodium Lactate, Arginine, Aspartic Acid, PCA, Glycine, Alanine, Serine, Valine, Proline, Threonine, Isoleucine, Histidine, Phenylalanine, Xylitylglucoside, Anhydroxylitol, Maltitol, Xylitol, Pelvetia Canaliculata Extract, Propanediol, Bis-(Isostearoyl/Oleoyl Isopropyl) Dimonium Methosulfate, Trisodium Ethylenediamine Disuccinate, Acrylates/C10-30 Alkyl Acrylate Crosspolymer, Cocamide MEA, Parfum, Polysorbate-20, Xanthan Gum, PEG-120 Methyl Glucose Dioleate, PEG-45M, Laureth-23, Polyquaternium-10, Laureth-4, Trideceth-10, Sodium Hydroxide, Phenoxyethanol, Ethylhexylglycerin.', 'Tinh dầu bưởi, Vitamin B5,  Xylishine™ và  Axít amin', 'Mọi loại tóc', 100, 2, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(10, 'cocoon', 'Gel tắm bí ao 310ml', '500ml', 'Sữa Tắm', 245000, 'Giúp da sạch mịn màng và giảm mụn lưng. Tinh dầu sả chanh giảm mùi cơ thể, tạo cảm giác sảng khoái, thư giãn', 'Mùi tinh dầu sả thư giãn', 'Gel màu vàng nhạt', '', 'Aqua/Water, Myristic Acid, Sodium Laureth Sulfate, Glycerin, Cocamidopropyl Betaine, Potassium Hydroxide, Lauric Acid, Sodium Cocoyl Glycinate, Cocamide Mea, Sodium Methyl Cocoyl Taurate, PEG-7 Glyceryl Cocoate, Polyquaternium-39, Benincasa Cerifera (Bí ao) Fruit Extract, Cymbopogon Citratus (Sả chanh) Leaf Oil, PEG-120 Methyl Glucose Dioleate, Mentha Piperita (Bạc hà) Oil, Stearic Acid, PEG-12 Dimethicone, O-Cymen-5-OL, PEG-45M, Tocopheryl Acetate, Trisodium Ethylenediamine Disuccinate, Phenoxyethanol, Ethylhexylglycerin.', 'Với chiết xuất bí ao, Tinh dầu sả chanh và Tinh dầu bạc hà', 'Da cơ thể có mụn', 100, 3, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(11, 'cocoon', 'Gel tắm khuynh diệp & bạc hà 500ml', '45g', 'Sữa Tắm', 245000, 'Vận dụng liệu pháp mùi hương từ tinh dầu khuynh diệp, bạc hà, kết hợp với vitamin B5 và hoạt chất dưỡng ẩm Betaine, Gel tắm sẽ làm sạch nhẹ nhàng và giữ cho làn da cơ thể luôn mềm mại, ồng thời giúp thư giãn, giải tỏa căng thẳng và mang lại một tinh thần thông suốt.', 'Mùi tinh dầu khuynh diệp và bạc hà thư giãn', 'Gel trong suốt không màu', '', '', 'Với tinh dầu thiên nhiên, Vitamin B5 (panthenol) và Betaine', 'Mọi loại da', 100, 3, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(12, 'cocoon', 'Xà phòng rửa tay khuynh diệp & bạc hà hình chú thỏ 45g', '45g', 'Sữa Tắm', 59000, 'Với dầu dừa, Tinh chất khuynh diệp, Bạc hà và Vitamin E, xà phòng rửa tay tạo bọt nhẹ nhàng giúp làm sạch vi khuẩn, bảo vệ ôi tay luôn sạch sẽ, thơm tho.', 'Mùi tinh khuynh diệp & bạc hà thanh mát, thư giãn', 'Dạng xà phòng trắng ục', '', 'COCOS NUCIFERA (COCONUT) OIL, AQUA/WATER, SODIUM HYDROXIDE, GLYCERIN,EUCA-LYPTUS GLOBULUS LEAF OIL, MENTHA PIPERITA OIL, TOCOPHERYL ACETATE.', 'Tinh dầu khuynh diệp, Tinh dầu bạc hà', 'Mọi loại da', 100, 3, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(13, 'cocoon', 'Bơ dưỡng thể cà phê ắk Lắk 200ml', '200ml', 'Dưỡng Thể', 215000, 'Dầu cà phê ắk Lắk rất giàu cafein, kết hợp với dầu mù u và bơ cacao, tất cả hòa quyện nên một thể bơ sánh mịn giúp dưỡng ẩm, làm mềm và chống oxi hóa, mang lại làn da cơ thể luôn mượt mà, tươi mới rạng rỡ.', 'Mùi thơm ặc trưng của dầu cà phê ắk Lắk \r\nvà bơ ca cao Tiền Giang', 'Dạng bơ ặc, sánh mịn màu trắng ngà', '', 'Aqua/Water, Caprylic/Capric Triglyceride, Glyceryl Stearate, Cetearyl Alcohol, C10-18 Triglycerides, Ceteareth-20, Ceteareth-12, Glycerin, Dicaprylyl Carbonate, Cetyl Palmitate, Cyclopentasiloxane, Coffea Arabica (Coffee) Seed Oil, Calophyllum Inophyllum Seed Oil, Theobroma Cacao (Cocoa) Seed Butter, Behenyl Alcohol, Niacinamide, Butyrospermum Parkii (Shea) Butter, Pentylene Glycol, Cetyl Alcohol, Macadamia Ternifolia Seed Oil, Carthamus Tinctorius (Safflower) Seed Oil, C15-19 Alkane, Tocopherol, Dimethiconol, Hydroxyethyl Acrylate/Sodium Acryloyldimethyl Taurate Copolymer, Xanthan Gum, BHT, Ethylhexylglycerin, Parfum, Trisodium Ethylenediamine Disuccinate, Phenoxyethanol, Caramel, Lactic Acid.', 'Dầu cà phê, Dầu mù u, Bơ ca cao', 'Mọi loại da cơ thể', 100, 3, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(14, 'cocoon', 'Sữa dưỡng thể khuynh diệp & bạc hà 140ml', '140ml', 'Dưỡng Thể', 95000, 'Với cấu trúc mềm mịn, thẩm thấu nhanh và không nhờn rít, sữa dưỡng thể giúp nuôi dưỡng, cấp ẩm, ồng thời giúp thư giãn và mang lại làn da tươi mới.', 'Mùi tinh khuynh diệp & bạc hà thanh mát, thư giãn', 'Dạng sữa có màu trắng ngà', '', 'Aqua/Water, Glyceryl Stearate, Cetearyl Alcohol, Cetyl Palmitate, Ceteareth-12, Ceteareth-20, Caprylic/Capric Triglyceride, Oryza Sativa (Rice) Bran Oil, C10-18 Triglycerides, Dicaprylyl Carbonate, Butyrospermum Parkii (Shea) Butter, Panthenol, Niacinamide, Betaine, Allantoin, Glycereth-26, Tocopherol, Glycerin, Ethylhexylglycerin, Butylene Glycol, Hydroxyacetophenone, Pentylene Glycol, Acrylates/C10-30 Alkyl Acrylate Crosspolymer, Dimethicone/Vinyl Dimethicone Crosspolymer, Trisodium Ethylenediamine Disuccinate, Sodium Hydroxide, Cyclopentasiloxane, Eucalyptus Globulus Leaf Oil, Mentha Piperita Oil, Limonene, Pelargonium Graveolens Flower Oil, Phenoxyethanol.', 'Với Niacinamide (Vitamin B3), Dầu cám gạo và Bơ hạt mỡ', 'Mọi loại da', 100, 3, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(15, 'cocoon', 'Xịt thâm mụn lưng bí ao 140ml', '140ml', 'Xịt Cơ Thể', 265000, 'Sản phẩm nổi bật với thiết kế vòi xịt 360 ộ có khả năng hoạt ộng mọi góc ộ cùng công thức treatment không cồn hoàn hảo: chiết xuất bí ao, 2% BHA & 5% AHA giúp làm sạch mụn, làm mờ vết thâm và hạn chế mụn mới hình thành.', 'Mùi tràm trà, oải hương, bạc hà và hương thảo thoang thoảng dịu nhẹ', 'Dạng nước trong suốt', 'Lưu ý: Tránh tiếp xúc với mắt. Sản phẩm chứa axít alpha hydroxy (AHA) có thể làm tăng ộ nhạy cảm của da với ánh nắng mặt trời, do ó cần sử dụng kem chống nắng và tránh nắng trong quá trình sử dụng sản phẩm.', 'Aqua/Water, Lactic Acid, Cocamidopropyl Dimethylamine, Salicylic Acid, Glycerin, Propanediol, Benincasa Cerifera Fruit Extract, Glycolic Acid, O-Cymen-5-Ol, Butylene Glycol, Ethylhexylglycerin, Polysorbate 20, Melaleuca Alternifolia Leaf Oil, Lavandula Angustifolia Flower Oil, Rosmarinus Officinalis Leaf Oil, Mentha Piperita Oil, Trisodium Ethylenediamine Disuccinate, Sodium Hydroxide, Phenoxyethanol.', 'Chiết xuất bí ao, 2% BHA và 5% AHA', 'Người ang gặp vấn ề mụn tại vùng da lưng, ngực và các vùng da khác trên cơ thể', 100, 3, NULL, 0, 'Khuyến khích dùng vào buổi tối. Nếu dùng vào buổi sáng nên dùng kèm kem chống nắng. Trong tháng ầu sử dụng  bạn nên dùng 2-3 lần 1 tuần, xịt một lớp mỏng toàn lưng hoặc xịt ra tay và thoa toàn lưng', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(16, 'cocoon', 'Cà phê ắk Lắk làm sạch da chết môi 5g', '5g', 'Tẩy Da Chết Môi', 75000, 'Chúng tôi tự hào khi mang những hạt cà phê ắk Lắk ược rang xay bằng tay vào sản phẩm chăm sóc môi ặc biệt này, những hạt cà phê li ti hòa quyện vào dầu mắc-ca và bơ hạt mỡ sẽ nhẹ nhàng làm bong những tế bào da chết ở môi, em lại làn môi mềm và mịn màng.', 'Mùi thơm ặc trưng của cà phê ắk Lắk', 'Dạng thỏi son có nhiều hạt cà phê xay rất mịn', '', 'BUTYROSPERMUM PARKII BUTTER, MACADAMIA INTEGRIFOLIA SEED OIL, COFFEA ARABICA SEED POWDER, CARTHAMUS TINCTORIUS SEED OIL, SYNTHETIC WAX, C10-18 TRIGLYCERIDES, TOCO-PHERYL ACETATE, MENTHYL LACTATE', 'Với hạt cà phê nguyên chất xay mịn, dầu mắc - ca và bơ hạt mỡ', 'Da môi', 100, 4, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng ngoài da', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(17, 'cocoon', 'Son dưỡng dầu dừa Bến Tre 5g', '5g', 'Dưỡng Ẩm Môi', 32000, 'Giúp ôi môi mềm mượt, căng mọng, chống khô môi, nứt nẻ do thời tiết.', 'Mùi dầu dừa ặc trưng', 'Dạng thỏi có màu trắng ục', 'Dùng mỗi ngày ể ạt kết quả tốt nhất.', 'COCOS NUCIFERA (COCONUT) OIL, BIS-DIGLYCERYL POLYACYLADIPATE-2, SYNTHETIC BEESWAX, C15-19 ALKANE, BUTYROSPERMUM PARKII (SHEA) BUTTER, CANDELILLA CERA, TOCOPHERYL ACETATE', 'Với bơ hạt mỡ và Vitamin E', 'Da môi', 100, 4, NULL, 0, 'Tránh dùng vùng mắt, chỉ dùng cho da môi', NULL, '2024-11-19 08:26:03', '2024-11-19 08:26:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `image_path`, `image_type`, `created_at`, `updated_at`, `product_id`) VALUES
(1, '/storage/product_images/sp1-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 1),
(2, '/storage/product_images/sp1-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 1),
(3, '/storage/product_images/sp2-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 2),
(4, '/storage/product_images/sp2-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 2),
(5, '/storage/product_images/sp3-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 3),
(6, '/storage/product_images/sp3-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 3),
(7, '/storage/product_images/sp4-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 4),
(8, '/storage/product_images/sp4-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 4),
(9, '/storage/product_images/sp5-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 5),
(10, '/storage/product_images/sp5-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 5),
(11, '/storage/product_images/sp6-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 6),
(12, '/storage/product_images/sp6-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 6),
(13, '/storage/product_images/sp7-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 7),
(14, '/storage/product_images/sp7-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 7),
(15, '/storage/product_images/sp8-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 8),
(16, '/storage/product_images/sp8-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 8),
(17, '/storage/product_images/sp9-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 9),
(18, '/storage/product_images/sp9-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 9),
(19, '/storage/product_images/sp12-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 10),
(20, '/storage/product_images/sp12-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 10),
(21, '/storage/product_images/sp14-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 11),
(22, '/storage/product_images/sp14-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 11),
(23, '/storage/product_images/sp15-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 12),
(24, '/storage/product_images/sp15-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 12),
(25, '/storage/product_images/sp16-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 13),
(26, '/storage/product_images/sp16-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 13),
(27, '/storage/product_images/sp17-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 14),
(28, '/storage/product_images/sp17-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 14),
(29, '/storage/product_images/sp18-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 15),
(30, '/storage/product_images/sp18-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 15),
(31, '/storage/product_images/sp19-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 16),
(32, '/storage/product_images/sp19-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 16),
(33, '/storage/product_images/sp20-1.webp', 'cover', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 17),
(34, '/storage/product_images/sp20-2.webp', 'gallery', '2024-11-19 08:26:03', '2024-11-19 08:26:03', 17);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `percent_promotion` decimal(5,2) NOT NULL,
  `promotion_start` datetime NOT NULL,
  `promotion_end` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`id`, `name`, `percent_promotion`, `promotion_start`, `promotion_end`, `created_at`, `updated_at`) VALUES
(1, 'Summer Sale', 20.00, '2024-05-31 17:00:00', '2024-12-30 16:59:00', '2024-11-19 08:26:03', '2024-11-19 09:37:23'),
(2, 'Winter Sale', 30.00, '2024-12-01 00:00:00', '2024-12-31 23:59:59', '2024-11-19 08:26:03', '2024-11-19 08:26:03'),
(3, 'Black Friday', 50.00, '2024-11-29 00:00:00', '2024-11-29 23:59:59', '2024-11-19 08:26:03', '2024-11-19 08:26:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `refund_requests`
--

CREATE TABLE `refund_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `images_refund` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`images_refund`)),
  `status` enum('pending','accepted','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `refund_requests`
--

INSERT INTO `refund_requests` (`id`, `order_id`, `reason`, `details`, `images_refund`, `status`, `created_at`, `updated_at`) VALUES
(1, 23, 'Sản phẩm không đúng mô tả', 'test', '[\"\\/storage\\/refund_images\\/zEJ2RiEzivsDHtgP2jSXsUmif58BMiAcqSNMN7e1.jpg\"]', 'rejected', '2024-11-19 10:11:49', '2024-11-19 14:14:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `customer_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('bDmRTvxm55MkrDSCD6cbpKnnpyz447wGr8oIeE7S', NULL, NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiaHhialltSjFtYkRQUXhBWVJKZ29QVzF4cDR2MnpkdHVuemZMTldBVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lL25vdGlmaWNhdGlvbnMiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo1NToibG9naW5fY3VzdG9tZXJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo3O3M6ODoicHJvZHVjdHMiO2E6MTp7aTowO2E6NTp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czozNDoiTsaw4bubYyB04bqpeSB0cmFuZyBiw60gxJFhbyAxNDBtbCI7czo4OiJxdWFudGl0eSI7czoxOiIxIjtzOjU6InByaWNlIjtkOjExNjAwMDtzOjEwOiJpbWFnZV9wYXRoIjtzOjM0OiIvc3RvcmFnZS9wcm9kdWN0X2ltYWdlcy9zcDEtMS53ZWJwIjt9fX0=', 1732162146);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vnpaypayments`
--

CREATE TABLE `vnpaypayments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` bigint(20) UNSIGNED NOT NULL,
  `vnp_bank_code` varchar(255) NOT NULL,
  `vnp_amount` varchar(255) NOT NULL,
  `vnp_paydate` varchar(255) NOT NULL,
  `vnp_txn_ref` varchar(255) NOT NULL,
  `vnp_transaction_no` varchar(255) NOT NULL,
  `vnp_create_by_id` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vnpaypayments`
--

INSERT INTO `vnpaypayments` (`id`, `payment_id`, `vnp_bank_code`, `vnp_amount`, `vnp_paydate`, `vnp_txn_ref`, `vnp_transaction_no`, `vnp_create_by_id`, `created_at`, `updated_at`) VALUES
(1, 24, 'NCB', '17400000', '20241119171351', '20241119171257', '14682716', '7', '2024-11-19 10:14:09', '2024-11-19 10:14:09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `discount_amount` decimal(8,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `image_path` varchar(255) DEFAULT NULL,
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '23:59:59',
  `expiry_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `name`, `discount_amount`, `quantity`, `image_path`, `start_time`, `end_time`, `expiry_date`, `created_at`, `updated_at`) VALUES
(1, 'SP-10-00', 'Sale All Time', 50.00, 0, 'system/sp-10.webp', '00:00:00', '23:59:00', '2024-11-22', NULL, '2024-11-21 00:25:57'),
(2, 'SP-25-00', 'Sale All Time', 25.00, 50, 'system/sp-25.webp', '00:00:00', '23:59:59', '2024-12-19', NULL, NULL),
(3, 'SP-50-30', '9-12 Gold hours Sale', 50.00, 50, 'system/sp-50.webp', '09:00:00', '12:00:00', '2024-12-19', NULL, NULL),
(4, 'VC-100-00', '9-12 Gold hours Sale', 100.00, 50, 'system/vc-mp.webp', '09:00:00', '12:00:00', '2024-12-19', NULL, NULL),
(5, 'VC-50-00', 'Sale All Time', 50.00, 25, 'system/vc-50.webp', '00:00:00', '23:59:59', '2024-12-19', NULL, NULL),
(6, 'VC-25-00', 'Sale All Time', 25.00, 1, 'system/vc-25.webp', '00:00:00', '23:59:59', '2024-12-19', NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Chỉ mục cho bảng `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_cart_id_foreign` (`cart_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_parent_category_foreign` (`parent_category`);

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_product_id_foreign` (`product_id`),
  ADD KEY `comments_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD UNIQUE KEY `customers_number_phone_unique` (`number_phone`);

--
-- Chỉ mục cho bảng `customer_password_resets`
--
ALTER TABLE `customer_password_resets`
  ADD KEY `customer_password_resets_email_index` (`email`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_categories_id_foreign` (`categories_id`),
  ADD KEY `products_promotion_id_foreign` (`promotion_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refund_requests_order_id_foreign` (`order_id`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `1` (`customer_id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `vnpaypayments`
--
ALTER TABLE `vnpaypayments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vnpaypayments_payment_id_foreign` (`payment_id`);

--
-- Chỉ mục cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_code_unique` (`code`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1251;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `refund_requests`
--
ALTER TABLE `refund_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vnpaypayments`
--
ALTER TABLE `vnpaypayments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_category_foreign` FOREIGN KEY (`parent_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_categories_id_foreign` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `refund_requests`
--
ALTER TABLE `refund_requests`
  ADD CONSTRAINT `refund_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `vnpaypayments`
--
ALTER TABLE `vnpaypayments`
  ADD CONSTRAINT `vnpaypayments_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
