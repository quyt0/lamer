-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 30, 2025 at 03:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lamer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'Phúc', 'dphuc2304@gmail.com', 'Quán rất chill nước rất ngon nhé hehehe', '2025-03-30 13:33:13'),
(2, 'Chử Đức Anh', 'anhcd@example.com', 'Tôi thấy quán này vừa đẹp vừa beautiful', '2025-03-30 13:38:30');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_time` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `username`, `fullname`, `phone`, `total_price`, `order_time`) VALUES
(1, 'lamer', 'La\'mer', '', 60000.00, '2025-03-30 15:05:08'),
(2, 'test3', 'test lần 3', '0987654321', 60000.00, '2025-03-30 15:27:47'),
(3, 'lethuy', 'Trương Lệ Thuỳ', '0978123456', 315000.00, '2025-03-30 16:27:20'),
(4, 'anhcdTest', 'anhcdTest', '0123456789', 75000.00, '2025-03-30 16:32:17'),
(5, 'lethuy', 'Trương Lệ Thuỳ', '0978123456', 90000.00, '2025-03-30 17:42:22');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 19, 'Thịt chó', 2, 15000.00),
(2, 1, 18, 'Kẹo ke', 1, 15000.00),
(3, 1, 16, 'Hướng dương', 1, 15000.00),
(4, 2, 19, 'Thịt chó', 1, 15000.00),
(5, 2, 18, 'Kẹo ke', 2, 15000.00),
(6, 2, 17, 'Bỏng ngô', 1, 15000.00),
(7, 3, 18, 'Kẹo ke', 1, 15000.00),
(8, 3, 17, 'Bỏng ngô', 1, 15000.00),
(9, 3, 16, 'Hướng dương', 1, 15000.00),
(10, 3, 19, 'Thịt chó', 1, 15000.00),
(11, 3, 1, 'Cà phê nâu nóng', 1, 15000.00),
(12, 3, 2, 'Cà phê nâu đá', 14, 15000.00),
(13, 3, 3, 'Cà phê đen nóng', 1, 15000.00),
(14, 3, 6, 'Cà phê muối', 1, 15000.00),
(15, 4, 18, 'Kẹo ke', 2, 15000.00),
(16, 4, 19, 'Thịt chó', 1, 15000.00),
(17, 4, 17, 'Bỏng ngô', 1, 15000.00),
(18, 4, 16, 'Hướng dương', 1, 15000.00),
(19, 5, 1, 'Cà phê nâu nóng', 1, 15000.00),
(20, 5, 2, 'Cà phê nâu đá', 1, 15000.00),
(21, 5, 3, 'Cà phê đen nóng', 1, 15000.00),
(22, 5, 6, 'Cà phê muối', 1, 15000.00),
(23, 5, 5, 'Cà phê dừa', 1, 15000.00),
(24, 5, 4, 'Cà phê đen đá', 1, 15000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `image_name`, `price`, `description`) VALUES
(1, 'Cà phê nâu nóng', 'Cà phê', 'naunong.jpg', 15000.00, 'Ly cà phê nâu nóng bốc khói nghi ngút, đậm đà vị phin, ngọt dịu từ sữa – như một sáng Hà Nội, chậm rãi mà đầy chất tình. Một khởi đầu ấm áp cho bất kỳ câu chuyện nào.'),
(2, 'Cà phê nâu đá', 'Cà phê', 'nauda.jpg', 15000.00, 'Cà phê nâu đá – mát lạnh, đậm vị, tỉnh người. Mỗi ngụm như một cú wake-up call giữa trưa hè. La\'mer gọi bạn trở lại với guồng sống... đầy cảm hứng.'),
(3, 'Cà phê đen nóng', 'Cà phê', 'dennong.jpg', 15000.00, 'Đậm sâu, nồng nàn và nguyên bản – cà phê đen nóng là lựa chọn của những tâm hồn trầm lặng nhưng đầy nội lực. Không ngọt, nhưng hậu vị để lại rất khó quên.'),
(4, 'Cà phê đen đá', 'Cà phê', 'denda.jpg', 15000.00, 'Không sữa. Không dịu dàng. Chỉ có đá lạnh và vị đắng nguyên bản – dành cho người thích đối diện với cuộc sống như nó vốn là.'),
(5, 'Cà phê dừa', 'Cà phê', 'cafedua.jpg', 15000.00, 'Khi vị đắng cà phê gặp béo mượt của dừa – La’mer cho bạn một ly cà phê dừa mát lạnh, ngọt ngào mà vẫn đủ tỉnh táo. Một cú chill đúng điệu giữa ngày nắng nóng.'),
(6, 'Cà phê muối', 'Cà phê', 'cafemuoi.jpg', 15000.00, 'Một chút muối để đậm đà hơn, một chút sữa để dịu lại vị đắng. Cà phê muối là sự cân bằng đầy bất ngờ – như cách cuộc sống đôi khi cần một chút mặn để thấy ngọt thêm.'),
(7, 'Trà xanh vị chanh', 'Trà', 'trachanh.jpeg', 15000.00, 'Mát lạnh, thanh nhẹ, thơm dịu như một cái ôm từ mùa hè. Trà xanh vị chanh của La’mer không làm bạn giật mình, chỉ làm bạn yêu đời hơn từng chút một.'),
(8, 'Trà chanh trân châu', 'Trà', 'trachanhtranchau.jpg', 15000.00, ''),
(9, 'Trà chanh nha đam', 'Trà', 'trachanhnhadam.jpg', 15000.00, ''),
(10, 'Trà xanh vị đào', 'Trà', 'tradao.jpg', 15000.00, ''),
(11, 'Kem ốc quế', 'Kem tươi', 'kemocque.jpg', 15000.00, ''),
(12, 'Kem đào', 'Kem tươi', 'kemdao.jpg', 15000.00, ''),
(13, 'Kem vani', 'Kem tươi', 'kemvani.jpg', 15000.00, ''),
(14, 'Kem sicula', 'Kem tươi', 'kemsocola.png', 15000.00, ''),
(15, 'Kem dâu', 'Kem tươi', 'kemdau.webp', 15000.00, ''),
(16, 'Hướng dương', 'Khác', 'huongduong.jpg', 15000.00, 'Nhâm nhi vài hạt hướng dương, nghe bản nhạc cũ, ngắm người quen mà chẳng cần nói gì. Thế là đủ một buổi La’mer yên bình.'),
(17, 'Bỏng ngô', 'Khác', 'bongngo.jpg', 15000.00, 'Một ly bỏng ngô giòn tan – dành cho những buổi La’mer nhẹ nhàng như bộ phim bạn chẳng muốn tua. Vị ngon không cần hiệu ứng đặc biệt.'),
(18, 'Kẹo Kera', 'Khác', 'keo.jpg', 16000.00, 'Ngọt ngào như một ánh mắt. Một viên kẹo nhỏ, gói trọn cả tuổi thơ, gợi nhớ những ngày rong chơi không âu lo.'),
(19, 'Thịt chó', 'Khác', 'thitcho.jpg', 15000.00, 'Món ăn huyền thoại cho những buổi chiều se lạnh. Thơm nức mũi, đậm đà, khiến bạn phải thốt lên: \'Chắc gì La\'mer có bán thật không?\' – Nhưng biết đâu đấy...');

-- --------------------------------------------------------

--
-- Table structure for table `userdata`
--

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` int(11) DEFAULT -1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdata`
--

INSERT INTO `userdata` (`id`, `username`, `fullname`, `phone`, `password`, `role`) VALUES
(1, 'phucdd', 'phúc', '', '$2y$10$VWmhhMUYBerch7suvEIa9uxE8Q2hx5EoXPg/ea22Ba62naO06eThy', 1),
(2, 'lamer', 'La\'mer', '', '$2y$10$.c5sn4W.r4x4DyDWBvff7udswc8zmYQHgzcaWvCbnsVGfFoIOtoZK', 2),
(3, 'thuymaihehe', 'thùymaitest', '', '$2y$10$q/wJOwsaou1LRjMWenL6Z.756SbKkGLrW4BqP4ajmEdNbveVuT7Nm', 0),
(4, 'Thuymai', 'Đỗ Thuỳ Mai', '', '$2y$10$4NcJz55Bfxm5FNMx4nCKE.xLRGELgiflc6p4q8hL.Tub1B1dETjhu', 1),
(5, 'ngochuyen', 'Ngọc Huyền', '', '$2y$10$wzb5oXLqPzNpb0qGtF.r0.XWE8w9ViJXiCIOFStXVU.i3vJ4haG/a', 0),
(6, 'hienann.h', 'Nguyễn Hiền Anh', '', '$2y$10$rRL7NzDfzyzizt7uewwizujMvs89G16JmpcPe.FTVndp5EYvg4Zqm', 1),
(7, 'nmai_', 'Mai', '', '$2y$10$ThKhTP8/l12HgrXimtLJuOemVQbM4/7gemz05Currq8V8Ykg.LI9K', 0),
(8, 'Cocainit', 'Cocainit', '', '$2y$10$ZX8zbOzAxZRzt8xe6BNi6OQ/R92ov1EpYxZP4601cDqp1tYgPE4vO', 1),
(9, 'duy', 'duy', '', '$2y$10$uFMpzd1SwrhHzE1HP4l1Ae5Fcw/Kxp4wuc4Azo0TRCqbiyXO7M1Yq', 0),
(10, 'Dhdnfbdb', 'Hdkdndb', '', '$2y$10$/ed30TWUaSH/aHP43WI5bevYQcELCozHS9omtPpOUFuWW36quEpiq', 0),
(11, 'Phúc ngáo', 'No name', '', '$2y$10$pK/ANe/ArHAOudvNRijAue.3Kcz7r.x7oabXJwvxifAu0Wqwc.Tgi', 0),
(12, 'test1', 'Test lần 1', '', '$2y$10$pRZCNpV0Px2GoFopKI.BxuQFeBht8ynI.QHg7xLLIqd/DO2T9RkPa', 0),
(13, 'test2', 'Test lần 2', '', '$2y$10$OXk8w6yRexfXj10dlKTb/eQFOH3ouMtURsNSXsX/zpMEIMXDWht0K', -1),
(15, 'diuuu', 'Nguyễn Diệu Linh', '', '$2y$10$WdFnmRU/W46XS28bmvKjnuh3QGIyH2SxnBtGhhHgYzxV/nAdoPmpa', 0),
(16, 'manh', 'Măn', '', '$2y$10$FE7MbGiDdmoxFd9CCXyviufJmuusRYx4hWLH45gU.A4RBLP5hb1TW', 0),
(17, 'test3', 'test lần 3', '0987654322', '$2y$10$7/Os6..OmFvV0Nmepa/puOvHYP95AfuGgCLtUCZRArTeQxamQJCxu', 0),
(18, 'lethuy', 'Trương Lệ Thuỳ', '0987654321', '$2y$10$tps7fxGlgrNcguh9JrA5Een3a5T3JnQrfrDyNfIVOR3CTb7oPDw.e', 0),
(19, 'anhcdTest', 'anhcdTest', '0123456789', '$2y$10$H3wsM57pFw0DX1eL0bko3.diAZZCOlJ3EgUFsNBVwgLZU2j7n/ORy', 1),
(20, 'nhanvien', 'Nhân viên vip', '0123456789', '$2y$10$jBoYXtm/6VhJ5mTB5j6FGenII03aF30uGPl8ggsWOWoqhSSc.wX0a', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userdata`
--
ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `userdata`
--
ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
