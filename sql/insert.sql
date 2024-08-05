-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 23, 2024 at 10:08 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `export`
--

--
-- Dumping data for table `addcart`
--

INSERT INTO `addcart` (`id`, `p_id`, `u_id`, `price`, `qty`, `total`) VALUES
(27, 35, 'admin', 26, 1, 26),
(29, 35, '1', 26, 20, 520);

--
-- Dumping data for table `food_cat`
--

INSERT INTO `food_cat` (`id`, `catnm`, `sub_cat`) VALUES
(57, 'Dania glowne', ''),
(58, 'Salatki', ''),
(59, 'Salatki', ''),
(60, 'Napoje', ''),
(61, 'Sniadania', ''),
(62, 'Desery', '');

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `category`, `sub_cat`, `title`, `description`, `price`, `image`) VALUES
(14, 'Salatki', '', 'Salatka', 'Salatka z pomidorem', 14, 'mimg/best-salad-7.jpg'),
(35, 'Dania glowne', '', 'Grillowany kurczak', 'Kurczak z warzywami', 26, 'mimg/grilled_chicken.jpg'),
(36, 'Desery', '', 'Ciasto czekoladowe', '', 16, 'mimg/chocolate_cake.jpg'),
(37, 'Napoje', '', 'Cola zero', '', 7, 'mimg/cola-zero.jpeg'),
(40, 'Sniadania', '', 'Jajecznica', 'Swieza jajecznica', 14, 'mimg/jajecznica.png');

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `u_id`, `name`, `email`, `address`, `phone`, `total`, `created_at`) VALUES
(1, 6, 'anna', 'anna@gmail.com', 'lodz', '111222333', 21565.00, '2024-06-22 09:36:02');

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `p_id`, `qty`, `price`, `total`, `created_at`) VALUES
(1, 1, 14, 1521, 14.00, 21294.00, '2024-06-22 09:36:02'),
(2, 1, 35, 6, 26.00, 156.00, '2024-06-22 09:36:02'),
(3, 1, 36, 5, 16.00, 80.00, '2024-06-22 09:36:02'),
(4, 1, 37, 5, 7.00, 35.00, '2024-06-22 09:36:02');

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `userid`, `password`, `email`) VALUES
(1, 'admin', 'admin', 'abc@yahoo.com'),
(2, 'aa', 'bb', 'cc@y.com'),
(5, 'abcd', 'asdf', 'abc@yahoo.com'),
(6, '1', '1', '1@ddd.com');

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `date`, `time`, `person`, `name`, `email`, `phone`, `table_id`, `user_id`) VALUES
(47, '2024-08-11', '18:00:00', 2, 'anna', 'anna@gmail.com', '222333444', 1, 6);

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `name`, `review`, `description`) VALUES
(5, 'Szczepan', 'Wysmienite', 'mniam'),
(6, 'Andrzejek', 'Bardzo Dobre', 'am ama am'),
(7, 'Sylwia', 'Slabe', 'niedobre'),
(8, 'Ania', 'Bardzo Dobre', 'ok'),
(9, 'Anna', 'Wysmienite', 'super'),
(10, 'Anna', 'Wysmienite', 'super'),
(11, 'Adam', 'Bardzo dobra', 'sss');

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `capacity`) VALUES
(1, 7),
(2, 10),
(3, 2),
(4, 2),
(5, 2),
(6, 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
