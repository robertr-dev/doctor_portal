-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 29, 2020 at 07:36 AM
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
-- Database: `healthcare`
--
CREATE DATABASE IF NOT EXISTS `healthcare` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `healthcare`;

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `patient_name` varchar(25) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `doctor_name` varchar(25) NOT NULL,
  `admission_date` varchar(25) NOT NULL,
  `admission_time` varchar(25) NOT NULL,
  `severity` varchar(25) NOT NULL,
  `admission_comments` text NOT NULL,
  `doctor_comments` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `patient_id`, `patient_name`, `doctor_id`, `doctor_name`, `admission_date`, `admission_time`, `severity`, `admission_comments`, `doctor_comments`) VALUES
(2, 15, 'Paul Gower', 28, 'Robert Rutter', '2020-11-15', '01:21', 'Important', 'He keeps talking about how rich he is                  \r\n                ', 'He is a millionaire after all '),
(3, 16, 'Jeff Charles', 28, 'Robert Rutter', '2020-11-15', '02:22', 'Critical', 'Dry mouth caused by eating too many biscuits without water                  \r\n                ', 'Jeff came in extremely dehydrated but after an hour of IV fluids he is doing better. Will update again when his condition improves.'),
(4, 14, 'Jane Doe', 29, 'Rock Star', '2020-11-15', '01:25', 'Critical', 'Jane has a cold. How unfortunate                  \r\n                ', 'After a thorough investigation I discovered Jane was faking it.'),
(12, 13, 'John Wick', 0, '', '2020-11-15', '19:13', 'Important', 'He looks just like Keanu Reeves', ''),
(23, 17, 'Ennis Wright', 0, '', '2020-11-17', '10:34', 'Critical', '<p>\r\n<br />\r\nYou can use HTML tags to format your admission and doctor comments into a more readable format.\r\n<ul>\r\n<li>Symptom 1</li>\r\n<li>Symptom 2</li>\r\n<li>Symptom 3</li>\r\n</ul>\r\n<i>Lorem ipsum lorem ipsum lorem ipsum</i>\r\n<br />\r\n</p>                  \r\n                ', '');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `name`) VALUES
(13, 'John Wick'),
(14, 'Jane Doe'),
(15, 'Paul Gower'),
(16, 'Jeff Charles'),
(17, 'Ennis Wright'),
(20, 'Jane Asparagus'),
(21, 'Shrek');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
