-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 06:55 PM
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
-- Table structure for table `contestproblems`
--

CREATE TABLE `contestproblems` (
  `ContestID` int(11) NOT NULL,
  `ProblemID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contestproblems`
--

INSERT INTO `contestproblems` (`ContestID`, `ProblemID`) VALUES
(1, 1),
(1, 2),
(2, 3),
(2, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE `contests` (
  `ContestID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `StartTime` datetime DEFAULT NULL,
  `EndTime` datetime DEFAULT NULL,
  `Duration` varchar(255) DEFAULT NULL,
  `CreatorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`ContestID`, `Title`, `Description`, `StartTime`, `EndTime`, `Duration`, `CreatorID`) VALUES
(1, 'Monthly Challenge June', 'A programming contest to test your skills in various algorithms and data structures.', '2024-07-07 09:00:00', '2024-08-07 23:59:59', '30 Days', 1),
(2, 'Weekly Coding Marathon', 'A week-long coding marathon to solve as many problems as possible.', '2024-06-07 00:00:00', '2024-06-13 23:59:59', '7 Days', 2),
(3, 'Weekend Algorithm Sprint', 'A weekend contest focused on algorithmic challenges.', '2024-06-15 10:00:00', '2024-06-16 18:00:00', '1 Day', 3),
(4, 'Summer Hackathon', 'Join us for a summer hackathon to build innovative projects.', '2024-08-01 08:00:00', '2024-08-07 20:00:00', '7 Days', 4),
(5, 'Beginner Bootcamp', 'A contest designed for beginners to get started with competitive programming.', '2024-06-10 12:00:00', '2024-06-10 18:00:00', '6 Hours', 1);

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE `problems` (
  `ProblemID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `PlmDescription` text DEFAULT NULL,
  `InputSpecification` text DEFAULT NULL,
  `OutputSpecification` text DEFAULT NULL,
  `ProblemNumber` varchar(20) DEFAULT NULL,
  `Note` text DEFAULT NULL,
  `TimeLimit` int(11) DEFAULT NULL,
  `MemoryLimit` int(11) DEFAULT NULL,
  `RatedFor` int(11) DEFAULT NULL,
  `AuthorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`ProblemID`, `Name`, `PlmDescription`, `InputSpecification`, `OutputSpecification`, `ProblemNumber`, `Note`, `TimeLimit`, `MemoryLimit`, `RatedFor`, `AuthorID`) VALUES
(1, 'Sum of Two Numbers', 'Calculate the sum of two given numbers.', 'Two integers a and b.', 'A single integer representing the sum of a and b.', 'P001', 'Basic arithmetic problem.', 1, 128, 1000, 1),
(2, 'String Reversal', 'Reverse a given string.', 'A single string s.', 'A single string which is the reverse of s.', 'P002', 'String manipulation problem.', 2, 256, 1200, 2),
(3, 'Prime Number Check', 'Determine if a given number is prime.', 'An integer n.', 'A single line with \"YES\" or \"NO\".', 'P003', 'Number theory problem.', 1, 128, 1500, 1),
(4, 'Matrix Multiplication', 'Multiply two matrices.', 'Two matrices A and B.', 'Matrix C which is the product of A and B.', 'P004', 'Matrix algebra problem.', 5, 512, 1800, 3),
(5, 'Graph Traversal', 'Implement BFS and DFS on a graph.', 'A graph represented as an adjacency list.', 'The order of nodes visited in BFS and DFS.', 'P005', 'Graph theory problem.', 3, 1024, 2000, 4);

-- --------------------------------------------------------

--
-- Table structure for table `problem_tags`
--

CREATE TABLE `problem_tags` (
  `ProblemID` int(11) DEFAULT NULL,
  `TagID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problem_tags`
--

INSERT INTO `problem_tags` (`ProblemID`, `TagID`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 3),
(3, 4),
(4, 2),
(4, 3),
(5, 1),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ratingdistribution`
--

CREATE TABLE `ratingdistribution` (
  `RatingCategory` varchar(50) NOT NULL,
  `MinimumRating` int(11) DEFAULT NULL,
  `MaximumRating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratingdistribution`
--

INSERT INTO `ratingdistribution` (`RatingCategory`, `MinimumRating`, `MaximumRating`) VALUES
('Expert', 800, 1199),
('Grandmaster', 1600, 2400),
('Master', 1200, 1599),
('Novice', 0, 400),
('Specialist', 400, 799);

-- --------------------------------------------------------

--
-- Table structure for table `ratinggraph`
--

CREATE TABLE `ratinggraph` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `PrevRating` int(11) DEFAULT NULL,
  `NewRating` int(11) DEFAULT NULL,
  `ChangedRating` int(11) DEFAULT NULL,
  `ContestID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratinggraph`
--

INSERT INTO `ratinggraph` (`ID`, `UserID`, `PrevRating`, `NewRating`, `ChangedRating`, `ContestID`, `Date`) VALUES
(2, 2, 1700, 1800, 100, 1, '2024-06-30'),
(3, 3, 1400, 1500, 100, 2, '2024-06-13'),
(4, 4, 2100, 2200, 100, 2, '2024-06-13'),
(5, 5, 1900, 2000, 100, 3, '2024-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `RatingID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `TotalScore` int(11) DEFAULT NULL,
  `Ranking` int(11) DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings`
--

INSERT INTO `ratings` (`RatingID`, `UserID`, `TotalScore`, `Ranking`, `LastUpdated`) VALUES
(1, 1, 2500, 1, '2024-07-01 10:00:00'),
(2, 2, 1800, 2, '2024-07-01 10:00:00'),
(3, 3, 1500, 3, '2024-07-01 10:00:00'),
(4, 4, 2200, 4, '2024-07-01 10:00:00'),
(5, 5, 2000, 5, '2024-07-01 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `SubmissionID` int(11) NOT NULL,
  `ProblemID` int(11) DEFAULT NULL,
  `ContestID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `LanguageID` varchar(55) DEFAULT NULL,
  `SubmissionTime` datetime DEFAULT NULL,
  `JudgeTime` datetime DEFAULT NULL,
  `TimeTaken` int(11) DEFAULT NULL,
  `MemoryUsed` int(11) DEFAULT NULL,
  `Code` text DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`SubmissionID`, `ProblemID`, `ContestID`, `UserID`, `LanguageID`, `SubmissionTime`, `JudgeTime`, `TimeTaken`, `MemoryUsed`, `Code`, `Status`, `Score`) VALUES
(1, 1, 1, 1, '1', '2024-06-01 10:00:00', '2024-06-01 10:01:00', 1, 128, 'print(sum(map(int, input().split())))', 'Accepted', 100),
(2, 2, 1, 2, '2', '2024-06-01 11:00:00', '2024-06-01 11:01:30', 1, 256, 's = input()\nprint(s[::-1])', 'Accepted', 100),
(3, 3, 2, 3, '3', '2024-06-07 09:30:00', '2024-06-07 09:32:00', 2, 128, 'def is_prime(n):\n  if n <= 1: return False\n  for i in range(2, int(n**0.5) + 1):\n    if n % i == 0: return False\n  return True\nprint(\"YES\" if is_prime(int(input())) else \"NO\")', 'Accepted', 100),
(4, 4, 2, 4, '4', '2024-06-07 10:45:00', '2024-06-07 10:47:00', 5, 512, 'def matrix_mult(A, B):\n  return [[sum(a*b for a, b in zip(A_row, B_col)) for B_col in zip(*B)] for A_row in A]\nprint(matrix_mult(A, B))', 'Accepted', 100),
(5, 5, 3, 1, '1', '2024-06-15 10:15:00', '2024-06-15 10:17:00', 3, 1024, 'from collections import deque\n def bfs(graph, start):\n  visited = []\n  queue = deque([start])\n  while queue:\n    vertex = queue.popleft()\n    if vertex not in visited:\n      visited.append(vertex)\n      queue.extend(set(graph[vertex]) - set(visited))\n  return visited\nprint(bfs(graph, start))', 'Accepted', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `TagID` int(11) NOT NULL,
  `TagName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`TagID`, `TagName`) VALUES
(1, 'arrays'),
(2, 'strings'),
(3, 'dynamic programming'),
(4, 'greedy algorithms'),
(5, 'graph theory'),
(6, 'tree algorithms'),
(7, 'number theory'),
(8, 'mathematics'),
(9, 'combinatorics'),
(10, 'geometry'),
(11, 'bit manipulation'),
(12, 'sorting'),
(13, 'searching'),
(14, 'recursion'),
(15, 'backtracking'),
(16, 'hashing'),
(17, 'heap'),
(18, 'stack'),
(19, 'queue'),
(20, 'linked list'),
(21, 'binary search tree'),
(22, 'depth-first search'),
(23, 'breadth-first search'),
(24, 'disjoint set union'),
(25, 'segment tree'),
(26, 'binary indexed tree'),
(27, 'trie'),
(28, 'divide and conquer'),
(29, 'brute force'),
(30, 'simulation'),
(31, 'game theory'),
(32, 'modular arithmetic'),
(33, 'bitmask'),
(34, 'sieve of eratosthenes'),
(35, 'matrix'),
(36, 'flood fill'),
(37, 'two pointers'),
(38, 'sliding window'),
(39, 'topological sort'),
(40, 'graph coloring'),
(41, 'shortest path'),
(42, 'minimum spanning tree'),
(43, 'flow network'),
(44, 'line sweep'),
(45, 'geometry sweep'),
(46, 'string matching'),
(47, 'suffix array'),
(48, 'prefix sum'),
(49, 'fenwick tree'),
(50, 'range query'),
(51, 'data structures'),
(52, 'algorithms'),
(53, 'optimization'),
(54, 'probability'),
(55, 'statistics'),
(56, 'game theory'),
(57, 'competitive programming'),
(58, 'interactive problems'),
(59, 'implementation'),
(60, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `testcases`
--

CREATE TABLE `testcases` (
  `ID` int(11) NOT NULL,
  `InputFileLocation` varchar(255) DEFAULT NULL,
  `OutputFileLocation` varchar(255) DEFAULT NULL,
  `ProblemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testcases`
--

INSERT INTO `testcases` (`ID`, `InputFileLocation`, `OutputFileLocation`, `ProblemID`) VALUES
(1, '/testcases/P001/input1.txt', '/testcases/P001/output1.txt', 1),
(2, '/testcases/P002/input1.txt', '/testcases/P002/output1.txt', 2),
(3, '/testcases/P003/input1.txt', '/testcases/P003/output1.txt', 3),
(4, '/testcases/P004/input1.txt', '/testcases/P004/output1.txt', 4),
(5, '/testcases/P005/input1.txt', '/testcases/P005/output1.txt', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Handle` varchar(50) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) NOT NULL,
  `User_Password` varchar(255) NOT NULL,
  `Profile_Picture` varchar(255) DEFAULT NULL,
  `User_Role` varchar(20) DEFAULT 'user',
  `RatingID` int(11) DEFAULT NULL,
  `DateJoined` datetime DEFAULT NULL,
  `RatingCategory` varchar(50) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `MaxRating` int(11) DEFAULT 0,
  `Institution` varchar(255) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Handle`, `Name`, `Email`, `User_Password`, `Profile_Picture`, `User_Role`, `RatingID`, `DateJoined`, `RatingCategory`, `DateOfBirth`, `MaxRating`, `Institution`, `Gender`) VALUES
(1, 'johndoe', 'John Doe', 'john.doe@example.com', 'password123', '/images/johndoe.jpg', 'admin', 1, '2024-01-15 10:30:00', 'Gold', NULL, 0, NULL, NULL),
(2, 'janesmith', 'Jane Smith', 'jane.smith@example.com', 'password456', '/images/janesmith.jpg', 'user', 2, '2023-12-20 08:15:00', 'Silver', NULL, 0, NULL, NULL),
(3, 'bobjones', 'Bob Jones', 'bob.jones@example.com', 'password789', NULL, 'moderator', 3, '2024-03-22 14:45:00', 'Bronze', NULL, 0, NULL, NULL),
(4, 'alicebrown', 'Alice Brown', 'alice.brown@example.com', 'passwordabc', '/images/alicebrown.jpg', 'user', 4, '2023-11-10 09:05:00', 'Platinum', NULL, 0, NULL, NULL),
(5, 'charlieblack', 'Charlie Black', 'charlie.black@example.com', 'passworddef', NULL, 'user', 5, '2024-02-18 12:50:00', 'Gold', NULL, 0, NULL, NULL),
(6, 'Taju366', 'Kazi Zannatul', 'kazizannatultajrin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'user', NULL, NULL, 'Novice', NULL, 0, NULL, NULL),
(7, 'AfnanRakib', 'Rakib Hasan', 'afnanrakib476@gmail.com', '202cb962ac59075b964b07152d234b70', '../images/uploads/profile_pictures/7.jpg', 'user', NULL, '2024-07-08 20:33:14', NULL, '0000-00-00', 0, '', 'male'),
(9, 'rakib476', 'Afnan Rakib', 'rakib.cse.20210204027@aust.edu', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'user', NULL, '2024-07-12 15:34:54', NULL, NULL, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contestproblems`
--
ALTER TABLE `contestproblems`
  ADD PRIMARY KEY (`ContestID`,`ProblemID`),
  ADD KEY `ProblemID` (`ProblemID`);

--
-- Indexes for table `contests`
--
ALTER TABLE `contests`
  ADD PRIMARY KEY (`ContestID`),
  ADD KEY `CreatorID` (`CreatorID`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`ProblemID`),
  ADD KEY `AuthorID` (`AuthorID`);

--
-- Indexes for table `problem_tags`
--
ALTER TABLE `problem_tags`
  ADD KEY `ProblemID` (`ProblemID`),
  ADD KEY `TagID` (`TagID`);

--
-- Indexes for table `ratingdistribution`
--
ALTER TABLE `ratingdistribution`
  ADD PRIMARY KEY (`RatingCategory`);

--
-- Indexes for table `ratinggraph`
--
ALTER TABLE `ratinggraph`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ContestID` (`ContestID`);

--
-- Indexes for table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`RatingID`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`SubmissionID`),
  ADD KEY `ProblemID` (`ProblemID`),
  ADD KEY `ContestID` (`ContestID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `LanguageID` (`LanguageID`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`TagID`);

--
-- Indexes for table `testcases`
--
ALTER TABLE `testcases`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProblemID` (`ProblemID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Handle` (`Handle`),
  ADD KEY `RatingID` (`RatingID`),
  ADD KEY `RatingCategory` (`RatingCategory`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `ContestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `ProblemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ratinggraph`
--
ALTER TABLE `ratinggraph`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ratings`
--
ALTER TABLE `ratings`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `SubmissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `testcases`
--
ALTER TABLE `testcases`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contestproblems`
--
ALTER TABLE `contestproblems`
  ADD CONSTRAINT `contestproblems_ibfk_1` FOREIGN KEY (`ContestID`) REFERENCES `contests` (`ContestID`),
  ADD CONSTRAINT `contestproblems_ibfk_2` FOREIGN KEY (`ProblemID`) REFERENCES `problems` (`ProblemID`);

--
-- Constraints for table `contests`
--
ALTER TABLE `contests`
  ADD CONSTRAINT `contests_ibfk_1` FOREIGN KEY (`CreatorID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `problem_tags`
--
ALTER TABLE `problem_tags`
  ADD CONSTRAINT `problem_tags_ibfk_1` FOREIGN KEY (`ProblemID`) REFERENCES `problems` (`ProblemID`),
  ADD CONSTRAINT `problem_tags_ibfk_2` FOREIGN KEY (`TagID`) REFERENCES `tags` (`TagID`);

--
-- Constraints for table `ratinggraph`
--
ALTER TABLE `ratinggraph`
  ADD CONSTRAINT `ratinggraph_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `ratinggraph_ibfk_2` FOREIGN KEY (`ContestID`) REFERENCES `contests` (`ContestID`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`ProblemID`) REFERENCES `problems` (`ProblemID`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`ContestID`) REFERENCES `contests` (`ContestID`),
  ADD CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `testcases`
--
ALTER TABLE `testcases`
  ADD CONSTRAINT `testcases_ibfk_1` FOREIGN KEY (`ProblemID`) REFERENCES `problems` (`ProblemID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RatingID`) REFERENCES `ratings` (`RatingID`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`RatingCategory`) REFERENCES `ratingdistribution` (`RatingCategory`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
