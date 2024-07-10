-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 04:37 PM
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
  `EndDate` datetime DEFAULT NULL,
  `Duration` varchar(255) DEFAULT NULL,
  `CreatorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`ContestID`, `Title`, `Description`, `StartTime`, `EndDate`, `Duration`, `CreatorID`) VALUES
(1, 'Monthly Challenge June', 'A programming contest to test your skills in various algorithms and data structures.', '2024-06-01 09:00:00', '2024-06-30 23:59:59', '0000-00-00 00:00:00', 1),
(2, 'Weekly Coding Marathon', 'A week-long coding marathon to solve as many problems as possible.', '2024-06-07 00:00:00', '2024-06-13 23:59:59', '0000-00-00 00:00:00', 2),
(3, 'Weekend Algorithm Sprint', 'A weekend contest focused on algorithmic challenges.', '2024-06-15 10:00:00', '2024-06-16 18:00:00', '0000-00-00 00:00:00', 3),
(4, 'Summer Hackathon', 'Join us for a summer hackathon to build innovative projects.', '2024-07-01 08:00:00', '2024-07-07 20:00:00', '0000-00-00 00:00:00', 4),
(5, 'Beginner Bootcamp', 'A contest designed for beginners to get started with competitive programming.', '2024-06-10 12:00:00', '2024-06-10 18:00:00', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `LanguageID` int(11) NOT NULL,
  `LanguageName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`LanguageID`, `LanguageName`) VALUES
(1, 'Python'),
(2, 'Java'),
(3, 'C++'),
(4, 'JavaScript'),
(5, 'Ruby');

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
  `ProblemNumber` varchar(20) NOT NULL,
  `Note` text DEFAULT NULL,
  `TimeLimit` int(11) DEFAULT NULL,
  `MemoryLimit` int(11) DEFAULT NULL,
  `RatedFor` int(11) DEFAULT NULL,
  `AuthorID` int(11) DEFAULT NULL,
  `CreationDate` datetime DEFAULT NULL,
  `TagID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`ProblemID`, `Name`, `PlmDescription`, `InputSpecification`, `OutputSpecification`, `ProblemNumber`, `Note`, `TimeLimit`, `MemoryLimit`, `RatedFor`, `AuthorID`, `CreationDate`, `TagID`) VALUES
(1, 'Sum of Two Numbers', 'Calculate the sum of two given numbers.', 'Two integers a and b.', 'A single integer representing the sum of a and b.', 'P001', 'Basic arithmetic problem.', 1, 128, 1000, 1, '2024-06-01 10:00:00', '1'),
(2, 'String Reversal', 'Reverse a given string.', 'A single string s.', 'A single string which is the reverse of s.', 'P002', 'String manipulation problem.', 2, 256, 1200, 2, '2024-06-02 11:15:00', '2'),
(3, 'Prime Number Check', 'Determine if a given number is prime.', 'An integer n.', 'A single line with \"YES\" or \"NO\".', 'P003', 'Number theory problem.', 1, 128, 1500, 1, '2024-06-03 09:30:00', '3'),
(4, 'Matrix Multiplication', 'Multiply two matrices.', 'Two matrices A and B.', 'Matrix C which is the product of A and B.', 'P004', 'Matrix algebra problem.', 5, 512, 1800, 3, '2024-06-04 12:45:00', '4'),
(5, 'Graph Traversal', 'Implement BFS and DFS on a graph.', 'A graph represented as an adjacency list.', 'The order of nodes visited in BFS and DFS.', 'P005', 'Graph theory problem.', 3, 1024, 2000, 4, '2024-06-05 14:00:00', '5');

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
('Bronze', 0, 999),
('Gold', 2000, 2999),
('Platinum', 3000, 3999),
('Silver', 1000, 1999);

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
(1, 1, 2400, 2500, 100, 1, '2024-06-30'),
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
  `LanguageID` int(11) DEFAULT NULL,
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
(1, 1, 1, 1, 1, '2024-06-01 10:00:00', '2024-06-01 10:01:00', 1, 128, 'print(sum(map(int, input().split())))', 'Accepted', 100),
(2, 2, 1, 2, 2, '2024-06-01 11:00:00', '2024-06-01 11:01:30', 1, 256, 's = input()\nprint(s[::-1])', 'Accepted', 100),
(3, 3, 2, 3, 3, '2024-06-07 09:30:00', '2024-06-07 09:32:00', 2, 128, 'def is_prime(n):\n  if n <= 1: return False\n  for i in range(2, int(n**0.5) + 1):\n    if n % i == 0: return False\n  return True\nprint(\"YES\" if is_prime(int(input())) else \"NO\")', 'Accepted', 100),
(4, 4, 2, 4, 4, '2024-06-07 10:45:00', '2024-06-07 10:47:00', 5, 512, 'def matrix_mult(A, B):\n  return [[sum(a*b for a, b in zip(A_row, B_col)) for B_col in zip(*B)] for A_row in A]\nprint(matrix_mult(A, B))', 'Accepted', 100),
(5, 5, 3, 1, 1, '2024-06-15 10:15:00', '2024-06-15 10:17:00', 3, 1024, 'from collections import deque\n def bfs(graph, start):\n  visited = []\n  queue = deque([start])\n  while queue:\n    vertex = queue.popleft()\n    if vertex not in visited:\n      visited.append(vertex)\n      queue.extend(set(graph[vertex]) - set(visited))\n  return visited\nprint(bfs(graph, start))', 'Accepted', 100);

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
(1, 'Math'),
(2, 'Strings'),
(3, 'Number Theory'),
(4, 'Matrix'),
(5, 'Graph');

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
  `Profile_Picture_File_Location` varchar(255) DEFAULT NULL,
  `User_Role` varchar(20) DEFAULT NULL,
  `RatingID` int(11) DEFAULT NULL,
  `DateJoined` datetime DEFAULT NULL,
  `RatingCategory` varchar(50) DEFAULT NULL,
  `LastVisited` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Handle`, `Name`, `Email`, `User_Password`, `Profile_Picture_File_Location`, `User_Role`, `RatingID`, `DateJoined`, `RatingCategory`, `LastVisited`) VALUES
(1, 'johndoe', 'John Doe', 'john.doe@example.com', 'password123', '/images/johndoe.jpg', 'admin', 1, '2024-01-15 10:30:00', 'Gold', 10),
(2, 'janesmith', 'Jane Smith', 'jane.smith@example.com', 'password456', '/images/janesmith.jpg', 'user', 2, '2023-12-20 08:15:00', 'Silver', 15),
(3, 'bobjones', 'Bob Jones', 'bob.jones@example.com', 'password789', NULL, 'moderator', 3, '2024-03-22 14:45:00', 'Bronze', 8),
(4, 'alicebrown', 'Alice Brown', 'alice.brown@example.com', 'passwordabc', '/images/alicebrown.jpg', 'user', 4, '2023-11-10 09:05:00', 'Platinum', 20),
(5, 'charlieblack', 'Charlie Black', 'charlie.black@example.com', 'passworddef', NULL, 'user', 5, '2024-02-18 12:50:00', 'Gold', 5),
(6, 'Taju366', 'Kazi Zannatul', 'kazizannatultajrin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, NULL, NULL, NULL, NULL, NULL);

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
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`LanguageID`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`ProblemID`),
  ADD KEY `AuthorID` (`AuthorID`),
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
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `LanguageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `testcases`
--
ALTER TABLE `testcases`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  ADD CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `submissions_ibfk_4` FOREIGN KEY (`LanguageID`) REFERENCES `languages` (`LanguageID`);

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
