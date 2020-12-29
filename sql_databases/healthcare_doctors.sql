-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2020 at 07:35 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `healthcare_doctors`
--
CREATE DATABASE IF NOT EXISTS `healthcare_doctors` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `healthcare_doctors`;

-- --------------------------------------------------------

--
-- Table structure for table `login_tokens`
--

CREATE TABLE `login_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_tokens`
--

CREATE TABLE `password_tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `token` char(64) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `password` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `password`) VALUES
(28, 'rrdev', 'Robert Rutter', '$2y$10$4ELm3YPoHj59N.k511guce9EB//LMwNWYUqyjk.HYmnWLsif8IgQu'),
(29, 'techlead', 'Rock Star', '$2y$10$Q/zheAztTYrAFZrKsOQWcO1g0H.hU8NUPH6Qb1/y6Hv76b.UXXTNW'),
(30, 'wooxrs', 'Woox RS', '$2y$10$xFXusHNElZIp2/zBv1kVGeibX2m5iwjvhxUnoca88.Sm/y1VjuLmS'),
(31, 'example123abc', 'Example Doctor', '$2y$10$n7zQAeLLNCyYeUkSEAb3A.6Y97xdg24J.r7yN/Su7Cd3ZlOBwOIQW'),
(32, 'big_egg', 'Big Egg', '$2y$10$rS/gG8yFT0J8JCGTHyUA9eNXZYg4SY9u67wPE5zkFMlQlJgIWt5qC'),
(33, 'genghis_khan', 'Genghis Khan', '$2y$10$GHHDTn8VAcz/O6Ky9vwK5eOvpC0O2vwV7h.bI54Jk2JoE/ida/Ni.'),
(34, 'video', 'Magnus Carlsen', '$2y$10$tjQfIWrrloNCDJUyTysgfe/zJPkueS2R4XY/i3zKscJPqjXPPc/tm'),
(38, 'farquad', 'Lord Farquad', '$2y$10$1nJMLWPm62GR.H4.GPhOpufYCyWBSWVj9/jMzJG61S9kdxBuwt4rS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `password_tokens`
--
ALTER TABLE `password_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_tokens`
--
ALTER TABLE `login_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `password_tokens`
--
ALTER TABLE `password_tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_tokens`
--
ALTER TABLE `login_tokens`
  ADD CONSTRAINT `login_tokens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
