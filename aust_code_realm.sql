-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 05:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aust_code_realm`
--

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE `contests` (
  `id` int(11) NOT NULL,
  `contest_name` varchar(255) NOT NULL,
  `start_time` datetime NOT NULL,
  `duration` varchar(50) NOT NULL,
  `status` enum('upcoming','running','past') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `contest_name`, `start_time`, `duration`, `status`) VALUES
(1, 'Example Contest 1', '2024-07-01 18:00:00', '2 hours', 'past'),
(2, 'Example Contest 2', '2024-06-25 12:00:00', '1.5 hours', 'past'),
(3, 'Example Contest 3', '2024-06-20 14:00:00', '3 hours', 'past'),
(4, 'Example Contest 4', '2024-07-10 10:00:00', '2 hours', 'upcoming'),
(5, 'Example Contest 5', '2024-06-23 16:00:00', '2 hours', 'past'),
(6, 'Example Contest 6', '2024-06-22 18:00:00', '1 hour', 'past'),
(7, 'Example Contest 7', '2024-07-15 20:00:00', '4 hours', 'upcoming'),
(8, 'Example Contest 8', '2024-06-26 22:00:00', '2 hours', 'past'),
(9, 'Example Contest 9', '2024-06-24 08:00:00', '1.5 hours', 'past');

-- --------------------------------------------------------

--
-- Table structure for table `contest_problems`
--

CREATE TABLE `contest_problems` (
  `contest_id` int(11) DEFAULT NULL,
  `problem_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contest_problems`
--

INSERT INTO `contest_problems` (`contest_id`, `problem_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 2),
(2, 3),
(2, 4),
(3, 3),
(3, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `problem_name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `problem_name`, `rating`, `tags`) VALUES
(1, 'Problem 1', 1200, 'Math, Greedy'),
(2, 'Problem 2', 1000, 'DP, Math'),
(3, 'Problem 3', 800, 'Greedy'),
(4, 'Problem 4', 1500, 'Math'),
(5, 'Problem 5', 2000, 'Graph'),
(6, 'Problem 6', 900, 'String'),
(7, 'Problem 7', 1100, 'DP'),
(8, 'Problem 8', 1300, 'Math, Graph'),
(9, 'Problem 9', 1400, 'Graph'),
(10, 'Problem 10', 1600, 'DP'),
(11, 'Problem 11', 1700, 'String'),
(12, 'Problem 12', 1800, 'Graph'),
(13, 'Problem 13', 1900, 'Math'),
(14, 'Problem 14', 1200, 'Greedy'),
(15, 'Problem 15', 800, 'String'),
(16, 'Problem 16', 1000, 'Math'),
(17, 'Problem 17', 1200, 'DP'),
(18, 'Problem 18', 1400, 'Graph'),
(19, 'Problem 19', 1600, 'String'),
(20, 'Problem 20', 1800, 'Math'),
(21, 'Problem 21', 2000, 'Graph, DP'),
(22, 'Problem 1', 800, 'math'),
(23, 'Problem 2', 1000, 'greedy,dp'),
(24, 'Problem 3', 1200, 'graph,dfs'),
(25, 'Problem 4', 1500, 'math,geometry'),
(26, 'Problem 5', 1800, 'dp,bitmask'),
(27, 'Jadur sohor', 1000, 'Math');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fullname`, `address`) VALUES
(5, 'AfnanRakib', 'afnanrakib476@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Rakib Hasan', 'aaaaaaaaaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contests`
--
ALTER TABLE `contests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contest_problems`
--
ALTER TABLE `contest_problems`
  ADD KEY `contest_id` (`contest_id`),
  ADD KEY `problem_id` (`problem_id`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contest_problems`
--
ALTER TABLE `contest_problems`
  ADD CONSTRAINT `contest_problems_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`),
  ADD CONSTRAINT `contest_problems_ibfk_2` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
