-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2021 at 06:34 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `iwww-sem`
--
CREATE DATABASE IF NOT EXISTS `iwww-sem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `iwww-sem`;

-- --------------------------------------------------------

--
-- Table structure for table `alt_address`
--

CREATE TABLE `alt_address` (
  `id_alt_address` int(11) NOT NULL,
  `id_order` int(11) NOT NULL,
  `alt_street` varchar(254) NOT NULL,
  `alt_city` varchar(254) NOT NULL,
  `alt_zip` int(7) NOT NULL,
  `alt_country` tinyint(3) UNSIGNED NOT NULL DEFAULT 32
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alt_address`
--

INSERT INTO `alt_address` (`id_alt_address`, `id_order`, `alt_street`, `alt_city`, `alt_zip`, `alt_country`) VALUES
(11, 210201374, 'Letců 17', 'Pardubice', 53002, 32);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `email` varchar(254) NOT NULL,
  `name` varchar(126) NOT NULL,
  `surname` varchar(126) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `street` varchar(126) NOT NULL,
  `city` varchar(126) NOT NULL,
  `zip` varchar(7) NOT NULL,
  `country` tinyint(3) UNSIGNED NOT NULL DEFAULT 32,
  `delivery` tinyint(3) UNSIGNED NOT NULL,
  `payment` tinyint(3) UNSIGNED NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `time`, `email`, `name`, `surname`, `phone`, `street`, `city`, `zip`, `country`, `delivery`, `payment`, `finished`) VALUES
(210201362, 1, '2021-02-01 16:58:27', 'admin@vinarna.cz', 'Lukáš', 'Janáček', '789456123', 'Hlavní 85', 'Medlešice, Chrudim', '53832', 32, 2, 2, 1),
(210201374, 16, '2021-02-01 17:01:50', 'vinarna@vinarna.cz', 'Laura', 'Světlá', '78965132', 'Programátorů 2006', 'Chrudim', '53839', 32, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `id_order` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `count` int(10) UNSIGNED NOT NULL,
  `price` float NOT NULL,
  `discount_price` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_products`
--

INSERT INTO `order_products` (`id_order`, `id_product`, `count`, `price`, `discount_price`) VALUES
(210201362, 4, 2, 269.9, NULL),
(210201362, 6, 3, 189.9, NULL),
(210201374, 7, 10, 39.9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_product` int(11) NOT NULL,
  `name` varchar(126) NOT NULL,
  `description` varchar(1022) NOT NULL,
  `picture` varchar(510) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(14) NOT NULL,
  `stock` tinyint(1) NOT NULL DEFAULT 0,
  `price` float NOT NULL,
  `discount_price` float DEFAULT NULL,
  `display` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_product`, `name`, `description`, `picture`, `quantity`, `unit`, `stock`, `price`, `discount_price`, `display`) VALUES
(1, 'Irsai Oliver', 'Je unikátní kabinetové víno. První mladé víno roku 2020. Bohaté, aromatické, šťavnaté a suché.', 'irsaiOliver.jpg', 1, 'ks', 1, 159.9, 119.9, 1),
(3, 'Rudé víno', 'Obyčejná láhev obyčejného červeného vína, za dostupnou cenu.', 'rudvno.webp', 1, 'ks', 1, 129.9, NULL, 1),
(4, 'Chardonnay Banrock', 'Lahodné víno Chardonnay od firmy Banrock.', 'chardonnaybanrock.jpg', 1, 'ks', 1, 269.9, NULL, 1),
(5, 'Merlot Banrock', 'Temné víno Merlot od společnosti Banrock.', 'merlotbanrock.jpg', 1, 'ks', 1, 299.9, NULL, 1),
(6, 'Medlešice - Mockup', 'Červené víno, přímo z Medlešic.', 'medleicemockup.jpg', 1, 'ks', 1, 189.9, NULL, 1),
(7, 'Červené víno', 'Perfetkní na svářáka, s trochou skořice.', 'ervenvno.jpg', 1, 'ks', 1, 39.9, NULL, 1),
(8, 'Rulandské modré', 'Tradiční rulandské modré víno.', 'rulandskmodr.jpg', 1, 'ks', 1, 149.9, NULL, 1),
(9, 'Rural Spine', 'Bílé víno Rural Spine, se sladkým nádechem.', 'ruralspine.jpg', 1, 'ks', 1, 229.9, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_tags`
--

CREATE TABLE `product_tags` (
  `id_product` int(11) NOT NULL,
  `id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product_tags`
--

INSERT INTO `product_tags` (`id_product`, `id_tag`) VALUES
(1, 1),
(1, 4),
(1, 6),
(1, 7),
(1, 8),
(3, 2),
(3, 5),
(3, 7),
(4, 1),
(4, 4),
(4, 7),
(4, 8),
(4, 17),
(4, 20),
(4, 29),
(5, 2),
(5, 4),
(5, 17),
(5, 20),
(5, 28),
(6, 2),
(6, 4),
(6, 7),
(6, 15),
(6, 16),
(6, 17),
(7, 2),
(7, 5),
(7, 7),
(8, 2),
(8, 20),
(9, 1),
(9, 4),
(9, 6),
(9, 22);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `name` varchar(62) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `name`, `value`) VALUES
(0, 'Uživatel', 100),
(1, 'Uživatel', 100),
(2, 'Správce produktů', 500),
(3, 'Administrátor', 1000),
(4, 'Správce objednávek', 750);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id_tag` int(11) NOT NULL,
  `text` varchar(126) NOT NULL,
  `priority` smallint(6) NOT NULL DEFAULT 0,
  `display` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id_tag`, `text`, `priority`, `display`) VALUES
(1, 'Bílé', 32000, 1),
(2, 'Červené', 32000, 1),
(3, 'Růžové', 32000, 1),
(4, 'Archivní', 1000, 1),
(5, 'Krabicové', 750, 1),
(6, 'Suché', 8000, 1),
(7, '2020', 29001, 1),
(8, 'Mladé víno', 6000, 1),
(15, 'Medlešice', 7000, 1),
(16, '2019', 29000, 1),
(17, '2018', 28999, 1),
(19, '2017', 28997, 1),
(20, '2016', 28900, 1),
(21, '2015', 28850, 1),
(22, '2014', 28800, 1),
(23, '2013', 19002, 1),
(24, '2012', 19001, 1),
(25, '2011', 19000, 1),
(26, '2009', 19000, 1),
(28, 'Merlot', 30001, 1),
(29, 'Chardonnay', 30000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `email` varchar(254) NOT NULL,
  `name` varchar(126) NOT NULL,
  `surname` varchar(126) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `street` varchar(126) DEFAULT NULL,
  `city` varchar(126) DEFAULT NULL,
  `zip` int(7) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `id_role` int(11) DEFAULT 1,
  `password` char(60) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `email`, `name`, `surname`, `phone`, `street`, `city`, `zip`, `country`, `id_role`, `password`, `active`) VALUES
(1, 'admin@vinarna.cz', 'Lukáš', 'Janáček', '789456123', 'Chrudim', 'Programátorů 2205', 53936, 0, 3, '$2y$13$V0TwjAAeLyANJpxSwB0.VO48D2HJwQwwDbe2uINX/aPM6WC03YuSC', 1),
(15, 'simon.c@vinarna.cz', 'Šimon', 'Čech', NULL, NULL, NULL, 0, 0, 3, '$2y$13$xm0bRU3Ptl1KSBNegh0DLOSUsN1oGbyi5OBfhR1QWcMEmRhrpWzJm', 1),
(16, 'vinarna@vinarna.cz', 'Laura', 'Světlá', NULL, NULL, NULL, 0, 0, 4, '$2y$13$wGXbHsbxcfTvQ0B1ymFPwOLM47H04Xf/kUbpnCtGj2U5BmdS/sfZe', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alt_address`
--
ALTER TABLE `alt_address`
  ADD PRIMARY KEY (`id_alt_address`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`id_order`,`id_product`),
  ADD KEY `id_product` (`id_product`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD PRIMARY KEY (`id_product`,`id_tag`),
  ADD KEY `id_tag` (`id_tag`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id_tag`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alt_address`
--
ALTER TABLE `alt_address`
  MODIFY `id_alt_address` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210201375;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alt_address`
--
ALTER TABLE `alt_address`
  ADD CONSTRAINT `alt_address_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_products_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE;

--
-- Constraints for table `product_tags`
--
ALTER TABLE `product_tags`
  ADD CONSTRAINT `product_tags_ibfk_1` FOREIGN KEY (`id_tag`) REFERENCES `tag` (`id_tag`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tags_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `products` (`id_product`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
