-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 24, 2024 lúc 11:46 AM
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
-- Cơ sở dữ liệu: `quan_ly_thu_vien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `don_muon`
--

CREATE TABLE `don_muon` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` varchar(255) NOT NULL,
  `id_sach` int(11) NOT NULL,
  `ngay_muon` date NOT NULL,
  `trang_thai` enum('chua_duyet','da_duyet') DEFAULT 'chua_duyet'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `don_muon`
--

INSERT INTO `don_muon` (`id`, `id_nguoi_dung`, `id_sach`, `ngay_muon`, `trang_thai`) VALUES
(1, '1', 22, '2024-07-24', 'chua_duyet');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `muon_tra`
--

CREATE TABLE `muon_tra` (
  `id` int(11) NOT NULL,
  `id_nguoi_dung` int(11) DEFAULT NULL,
  `id_sach` int(11) DEFAULT NULL,
  `ngay_muon` date DEFAULT NULL,
  `ngay_tra` date DEFAULT NULL,
  `trang_thai` enum('muon','tra') DEFAULT 'muon'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `muon_tra`
--

INSERT INTO `muon_tra` (`id`, `id_nguoi_dung`, `id_sach`, `ngay_muon`, `ngay_tra`, `trang_thai`) VALUES
(6, 1, 1, '2024-07-01', '2024-07-10', 'tra'),
(7, 2, 2, '2024-07-05', '2024-07-15', 'muon'),
(8, 3, 1, '2024-07-08', '2024-07-18', 'tra'),
(9, 1, 2, '2024-07-10', NULL, 'muon'),
(10, 2, 1, '2024-07-12', '2024-07-24', 'tra');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoi_dung`
--

CREATE TABLE `nguoi_dung` (
  `id` int(11) NOT NULL,
  `ten_dang_nhap` varchar(50) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `vai_tro` enum('nguoi_dung','admin') DEFAULT 'nguoi_dung'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoi_dung`
--

INSERT INTO `nguoi_dung` (`id`, `ten_dang_nhap`, `mat_khau`, `vai_tro`) VALUES
(1, '1', '$2y$10$b9JtHkVtiCHf.U.myaQ/ZO5WJbJ0Jm1tp4Y/ss0fSHrqIyn/aygdu', 'nguoi_dung'),
(2, 'admin', '$2y$10$eh3V2QKQZ0341sV820DWjunnDkT1PqDpZjhlD9wCB3FpIoMvtltjq', 'admin'),
(3, 'user1', '123456', 'nguoi_dung'),
(4, 'user2', '123456', 'nguoi_dung'),
(5, 'user3', '123456', 'nguoi_dung'),
(6, 'user4', '$2y$10$RynFaA17pQW4iIPwsCGORORvBZYo72NlkoiIBK8I9aDNFPkjd36ve', 'nguoi_dung');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sach`
--

CREATE TABLE `sach` (
  `id` int(11) NOT NULL,
  `ten_sach` varchar(255) NOT NULL,
  `tac_gia` varchar(255) NOT NULL,
  `mo_ta` text DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `id_the_loai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sach`
--

INSERT INTO `sach` (`id`, `ten_sach`, `tac_gia`, `mo_ta`, `hinh_anh`, `id_the_loai`) VALUES
(1, 'Truyện Kiều', 'Nguyễn Du', 'Sách mới nhất', 'https://picitypigroup.com/wp-content/uploads/2023/06/Truyen-Kieu.jpg', 2),
(2, 'Chọc tới chủ tịch tổng tài', 'Phạm Thị ', 'Truyện tranh anime hay nhất', 'https://i.pinimg.com/736x/77/b9/50/77b9502b943bf9dff9085b076159d861.jpg', 5),
(3, 'Các triều đại Việt Nam', 'Đỗ Đức Hưng', 'Sách mô tả chi tiết tất cả các triều đại thời phong kiến Việt Nam', 'https://th.bing.com/th/id/OIP.qvIFwnI_cGXbg5wxP_Vq7AHaLU?rs=1&pid=ImgDetMain', 2),
(4, 'Kho tàng truyện cổ tích Việt Nam', 'Nguyễn Đổng Chí', 'Sách sưu tập tất cả các truyện cổ tích Việt Nam', 'https://cdn0.fahasa.com/media/catalog/product/t/_/t_p_3.jpg', 6),
(5, 'Thần thoại Việt Nam', 'Thu Nga', 'Sách sưu tập các câu truyện thần thoại của Việt Nam', 'https://th.bing.com/th/id/OIP.IeSP1YRR0BsgMeOzqpWKVQHaLa?w=1059&h=1632&rs=1&pid=ImgDetMain', 6),
(6, 'Nữa thế kỉ văn thơ Hồ Chí Minh', 'Gs. Phong Lê', 'Cuộc đời và các sáng tác văn thơ hay sưu tầm của chủ tịch Hồ Chí Minh', 'https://th.bing.com/th/id/OIP.NsJWm2ooqyh65yHGUXHFzAAAAA?w=400&h=615&rs=1&pid=ImgDetMain', 2),
(7, 'Tư tưởng Hồ Chí Minh', 'Gs. Trần Minh Tuyết', 'Các tư tưởng chính trị tuyệt vời của chủ tịch Hồ Chí Minh', 'https://th.bing.com/th/id/OIP.zqrUZJ5QPpLt3NYkDxqCvwAAAA?w=400&h=561&rs=1&pid=ImgDetMain', 2),
(8, 'Việt Nam sử lược', 'Trần Trọng Kim', 'Lịch sử Việt Nam tóm gọn trong đầu sách này', 'https://toplist.vn/images/800px/viet-nam-su-luoc-361597.jpg', 2),
(9, 'Atlat địa lý Việt Nam', 'Bộ giáo dục Việt Nam', 'Sách địa lý Việt Nam', 'https://th.bing.com/th/id/OIP.Ln8Z7TM1aZf9QIXvqLxJugHaKo?pid=ImgDet&w=187&h=268&c=7&dpr=1.3', 2),
(10, 'Tổng quan về sàn thương mại điện tử', 'Given', 'Sách sơ lược về các sàn thương mại điện tử Việt Nam', 'https://cdn-merchant.vinid.net/images/image_upload_1671454851_sach-kinh-doanh-online-5.jpg', 3),
(11, 'Khởi nghiệp du kích', 'Trần Thanh Phòng', 'Sách hướng dẫn khởi nghiệp cho các bạn trẻ', 'https://bstyle.vn/wp-content/uploads/2019/09/khoi-nghiep-du-kich-2.jpg', 3),
(12, '7 câu hỏi chiến lược', 'Robert Simon', 'Các câu hỏi phát triển trong chiến lược kinh doanh sơ lược trong cuốn sách này', 'https://cdn0.fahasa.com/media/flashmagazine/images/page_images/7_cau_hoi_chien_luoc___seven_strategy_questions/2020_10_08_15_12_26_1-390x510.jpg', 3),
(13, 'Những đối thủ châu Á', 'Philip Cotler', 'Sách phân tích thị trường cạnh tranh của nền kinh tế châu Á', 'https://cdn0.fahasa.com/media/catalog/product/n/x/nxbtre_full_25172022_031706_1.jpg', 3),
(14, 'Hạnh phúc trong công việc', 'Shaw Acho', 'Tìm kiếm nguồn cảm hứng trong công việc kinh doanh của bạn', 'https://th.bing.com/th/id/OIP.8kic1qk4zxyGzzudh0IEnwHaKL?w=873&h=1200&rs=1&pid=ImgDetMain', 2),
(15, 'Lại được gặp ', 'Việt Hòa', 'Truyện ngôn tình hay nhất Việt Nam', 'https://th.bing.com/th/id/OIP.DaIAot54odlUM5n9PG4wIAHaLR?rs=1&pid=ImgDetMain', 7),
(16, 'Vợ tôi lại làm nũng rồi', 'Tiểu Ưu Ưu', 'Xem những câu chuyện đáng yêu của người vợ trong cuốn sách này nào', 'https://th.bing.com/th/id/OIP.oZSYyl7StfzU1YeAhd4QmAHaJ4?w=720&h=960&rs=1&pid=ImgDetMain', 7),
(17, 'Vụng trộm không thể giấu', 'Hidden Low', 'Những câu chuyện của cặp đôi mới yêu thật lãng mạn ><', 'https://gamehow.net/upload/suckhoe_post/images/2023/06/01/1031/truyen-trau-gia-gam-co-non-9.jpg', 7),
(18, 'Trúc Mã của tôi', 'Hiền Lương', 'Thanh xuân gắn liền với một cô gái mang tên Trúc Mã', 'https://allinvn.net/_next/image?url=https:%2F%2Fapi.allinvn.net%2F1706683101559.webp&w=3840&q=40', 7),
(19, 'Xin hãy làm em trở lên xinh đẹp', 'Truyện V1', 'Các câu chuyện của cô gái yêu phải tổng tài lạnh lùng bá đạo', 'https://th.bing.com/th/id/OIP.SA-jUkpkR8VxeiCxLyOksAHaLH?rs=1&pid=ImgDetMain', 7),
(20, '3 người một mối tình', 'Truyện Audio Org', 'Drama lãng mạn giữa 3 người yêu nhau', 'https://truyenaudio.org/upload/pro/Ba-Nguoi-Mot-Moi-Tinh-Truyen-Ngan.jpg', 7),
(21, 'Tớ muốn ăn tụy của cậu', 'Sumino Yoru', 'Phim anime hay nhất 2019', 'https://th.bing.com/th/id/OIP.ANjFxt32IkfsOUw1Q9R9fQHaKb?w=660&h=930&rs=1&pid=ImgDetMain', 5),
(22, 'Dáng hình thanh âm', 'Yamada Naoko', 'Phim về cô gái khiếm thính và cậu bạn hay trêu chọc cậu', 'https://th.bing.com/th/id/OIP.thF-ngqKJFsdPfGHkY27wAAAAA?w=300&h=445&rs=1&pid=ImgDetMain', 1),
(23, 'Your Name', 'Shinkai Makoto', 'Tên của cậu là gì', 'https://th.bing.com/th/id/OIP.MzHXml7Dy8jKQoCODe9u0gAAAA?w=419&h=600&rs=1&pid=ImgDetMain', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the_loai`
--

CREATE TABLE `the_loai` (
  `id` int(11) NOT NULL,
  `ten_the_loai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `the_loai`
--

INSERT INTO `the_loai` (`id`, `ten_the_loai`) VALUES
(1, 'Kỹ năng sống'),
(2, 'Văn học'),
(3, 'Kinh doanh'),
(4, 'Lịch sử'),
(5, 'Anime'),
(6, 'Truyện cổ tích'),
(7, 'Truyện ngôn tình');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `don_muon`
--
ALTER TABLE `don_muon`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_dung` (`id_nguoi_dung`),
  ADD KEY `id_sach` (`id_sach`);

--
-- Chỉ mục cho bảng `muon_tra`
--
ALTER TABLE `muon_tra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_nguoi_dung` (`id_nguoi_dung`),
  ADD KEY `id_sach` (`id_sach`);

--
-- Chỉ mục cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ten_dang_nhap` (`ten_dang_nhap`);

--
-- Chỉ mục cho bảng `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_the_loai` (`id_the_loai`);

--
-- Chỉ mục cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `don_muon`
--
ALTER TABLE `don_muon`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `muon_tra`
--
ALTER TABLE `muon_tra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `nguoi_dung`
--
ALTER TABLE `nguoi_dung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `sach`
--
ALTER TABLE `sach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `the_loai`
--
ALTER TABLE `the_loai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `don_muon`
--
ALTER TABLE `don_muon`
  ADD CONSTRAINT `don_muon_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`ten_dang_nhap`),
  ADD CONSTRAINT `don_muon_ibfk_2` FOREIGN KEY (`id_sach`) REFERENCES `sach` (`id`);

--
-- Các ràng buộc cho bảng `muon_tra`
--
ALTER TABLE `muon_tra`
  ADD CONSTRAINT `muon_tra_ibfk_1` FOREIGN KEY (`id_nguoi_dung`) REFERENCES `nguoi_dung` (`id`),
  ADD CONSTRAINT `muon_tra_ibfk_2` FOREIGN KEY (`id_sach`) REFERENCES `sach` (`id`);

--
-- Các ràng buộc cho bảng `sach`
--
ALTER TABLE `sach`
  ADD CONSTRAINT `sach_ibfk_1` FOREIGN KEY (`id_the_loai`) REFERENCES `the_loai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
