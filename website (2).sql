-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 05:45 PM
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
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `paragraph` text NOT NULL,
  `background_url` text DEFAULT NULL,
  `logo_url` text DEFAULT NULL,
  `github_link` text DEFAULT NULL,
  `linkedin_link` text DEFAULT NULL,
  `email_link` text DEFAULT NULL,
  `h1_content` varchar(255) DEFAULT '',
  `h2_content` varchar(255) DEFAULT '',
  `namez` varchar(255) DEFAULT NULL,
  `background_color` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `paragraph`, `background_url`, `logo_url`, `github_link`, `linkedin_link`, `email_link`, `h1_content`, `h2_content`, `namez`, `background_color`) VALUES
(1, 'hend rostom', '', '', '', '', '', 'dddddd', 'ekejkede', 'inker', '#dd9898');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `filename`, `filepath`, `upload_date`) VALUES
(1, 'linked.png', 'uploads/linked.png', '2024-06-25 12:31:10'),
(2, '62e43b686dc200.93921524_1.png', 'uploads/62e43b686dc200.93921524_1.png', '2024-06-25 12:47:09'),
(3, 'basant.jpg', 'uploads/basant.jpg', '2024-06-25 12:47:38'),
(4, 'basant_1.jpg', 'uploads/basant_1.jpg', '2024-06-25 12:51:05'),
(5, 'basant_2.jpg', 'uploads/basant_2.jpg', '2024-06-25 12:52:14'),
(6, 'basant_3.jpg', 'uploads/basant_3.jpg', '2024-06-25 12:52:55'),
(7, 'basant_4.jpg', 'uploads/basant_4.jpg', '2024-06-25 12:52:59'),
(8, 'basant.jpg', 'uploads/basant.jpg', '2024-06-25 15:08:49'),
(9, 'basant_1.jpg', 'uploads/basant_1.jpg', '2024-06-25 15:10:00'),
(10, 'basant_2.jpg', 'uploads/basant_2.jpg', '2024-06-25 15:10:53'),
(11, 'basant_3.jpg', 'uploads/basant_3.jpg', '2024-06-25 15:12:29'),
(12, 'basant_4.jpg', 'uploads/basant_4.jpg', '2024-06-25 15:14:34');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `url` text DEFAULT NULL,
  `content_id` int(11) DEFAULT NULL,
  `logo_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`id`, `type`, `url`, `content_id`, `logo_url`) VALUES
(3, 'inker', 'http://www.facebook.com', 1, 'ffjfff');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `timestamp`) VALUES
(1, 'ziaeldeep84@gmail.com', '2024-06-25 00:52:22'),
(2, 'gufytfy@jknj.jkkj', '2024-06-25 00:52:50'),
(3, 'ziaeldeep8ssssss4@gmail.com', '2024-06-25 15:17:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `links`
--
ALTER TABLE `links`
  ADD CONSTRAINT `links_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `content` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
