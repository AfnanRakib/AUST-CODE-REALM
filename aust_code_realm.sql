-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2024 at 03:49 PM
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
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `video_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `video_id`, `content`, `created_at`, `user_id`) VALUES
(1, 1, 'hello\r\n', '2024-07-12 07:39:21', 1),
(2, 1, 'Great video!', '2024-07-12 07:47:23', 2),
(7, 1, 'l]palsd]plas]\\sdl]a[sld][asd', '2024-07-14 15:27:46', 1),
(22, 1, 'awdsw', '2024-07-15 02:45:57', 10),
(23, 1, 'hello', '2024-07-15 02:46:10', 10),
(24, 1, 'asdas', '2024-07-15 02:46:15', 10),
(25, 1, 'hello', '2024-07-15 03:03:18', 10),
(26, 1, 'wakanda forever', '2024-07-15 13:37:26', 10);

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
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `image_url`, `created_at`, `user_id`) VALUES
(1, 'Dynamic Programming', 'Learn dynamic programming techniques.', '../../images/DynamicPrograming.png', '2024-07-12 13:06:12', 1),
(2, 'Arrays 101', 'Master array manipulation and algorithms.', '../../images/Arrays 101.png', '2024-07-12 13:06:12', 1),
(3, 'SQL Language', 'Learn database querying with SQL.', '../../images/SQL Language.png', '2024-07-12 13:06:12', 1),
(4, 'Sorting', 'Explore various sorting algorithms.', '../../images/Sorting.jfif', '2024-07-12 13:06:12', 1);

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
(5, 'Graph Traversal', 'Implement BFS and DFS on a graph.', 'A graph represented as an adjacency list.', 'The order of nodes visited in BFS and DFS.', 'P005', 'Graph theory problem.', 3, 1024, 2000, 4),
(6, 'Double Ended Queue', 'A queue is a data structure based on the principle of \'First In First Out\' (FIFO). There are two ends; one end can be used only to insert an item and the other end to remove an item. A Double Ended Queue is a queue where you can insert an item in both sides as well as you can delete an item from either side.\r\n\r\nThere are mainly four operations available to a double ended queue. They are:\r\n\r\n![Double Ended Queue](CDN_BASE_URL/6c444093f691ab00de2df3aef0808e5d?v=1720739565)\r\n\r\n1. `pushLeft()` inserts an item to the left end of the queue with the exception that the queue is not full.\r\n2. `pushRight()` inserts an item to the right end of the queue with the exception that the queue is not full.\r\n3. `popLeft()` removes an item from the left end of the queue with the exception that the queue is not empty.\r\n4. `popRight()` removes an item from the right end of the queue with the exception that the queue is not empty.\r\n\r\nNow you are given a queue and a list of commands, you have to report the behavior of the queue.', 'Input starts with an integer **T (&le; 20)**, denoting the number of test cases.Each case starts with a line containing two integers **n, m (1 &le; n &le; 10, 1 &le; m &le; 100)**, where **n** denotes the size of the queue and **m** denotes the number of commands. Each of the next **m** lines contains a command which is one of:\r\n\r\n| Operation | Action |\r\n|------------------|--------------------------------------------------------------------|\r\n| pushLeft  **x**  | pushes  **x (-100 &le; x &le; 100)**  to the left end of the queue |\r\n| pushRight **x** | pushes **x (-100 &le; x &le; 100)** to the right end of the queue |\r\n| popLeft               | pops an item from the left end of the queue |\r\n| popRight             | pops an item from the right end of the queue |', 'For each case, print the case number in a line. Then for each operation, show its corresponding output as shown in the sample. Be careful about spelling.', 'A', NULL, 1, 65536, 1000, 7),
(8, 'aaa', '<table style=\"border-collapse: collapse; width: 100%; border-width: 1px; background-color: #bfedd2; border-color: #000000;\" border=\"1\"><colgroup><col style=\"width: 49.958%;\"><col style=\"width: 49.958%;\"></colgroup>\r\n<tbody>\r\n<tr>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">adfadsfasf</td>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">sfaf</td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">asfasfasf</td>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">asfasdfasf</td>\r\n</tr>\r\n</tbody>\r\n</table>', '<p>&sum;A<sub>3</sub></p>', '<p>sdgsdgsagdsdafg<br>DFWSD<br>FSD<br>FSD<br>F<br>SADF<br>ASDF</p>', '111', '<p>gsdfgdfghg</p>', 1, 123, 1000, 7),
(9, '12132', '<p>asdsfdsfasfafasf<br>SAFAF<br>AS<br><img src=\"https://study.com/cimages/videopreview/videopreview-full/uj16yqmbw4.jpg\" alt=\"\" width=\"715\" height=\"402\"></p>\r\n<p>fsdfsdfsdfsdfsd</p>\r\n<p>dfssd</p>\r\n<p>f</p>\r\n<p>sf</p>\r\n<p>sdf</p>\r\n<p>&nbsp;</p>\r\n<table style=\"border-collapse: collapse; width: 100%; border-width: 1px; background-color: #bfedd2; border-color: #000000;\" border=\"1\"><colgroup><col style=\"width: 49.958%;\"><col style=\"width: 49.958%;\"></colgroup>\r\n<tbody>\r\n<tr>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">adfadsfasf</td>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">sfaf</td>\r\n</tr>\r\n<tr>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">asfasfasf</td>\r\n<td style=\"border-width: 1px; border-color: rgb(0, 0, 0);\">asfasdfasf</td>\r\n</tr>\r\n</tbody>\r\n</table>', '<p style=\"text-align: center;\">wrqrfb eryt<a href=\"https://www.google.co.uk/\"><strong>eryER</strong></a><br><a href=\"https://www.google.co.uk/\"><strong>YGHRASDYDRYHG</strong></a><br><a href=\"https://www.google.co.uk/\"><strong>DRGYHDRF</strong></a><br><a href=\"https://www.google.co.uk/\"><strong>GYH</strong></a><br>GD<br>GF</p>\r\n<p>ef</p>\r\n<p>wedf</p>\r\n<p><span style=\"background-color: rgb(241, 196, 15);\">ewf</span></p>\r\n<p dir=\"rtl\"><span style=\"background-color: rgb(241, 196, 15);\">sedfsdfsdfsdfsdfsdfsdfsdfsdfsd</span></p>', '<p>ryhdfhhedrf</p>', '2113', '<p>dsgdfgbdfghdhdf</p>', 1, 1213, 1324, 7);

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
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `comment_id`, `video_id`, `user_id`, `content`, `created_at`) VALUES
(1, 25, 1, 10, 'hi', '2024-07-15 03:03:24'),
(2, 2, 1, 10, 'well done', '2024-07-15 03:23:34'),
(3, 26, 1, 10, 'rip black panther', '2024-07-15 13:37:47');

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
(9, 'rakib476', 'Afnan Rakib', 'rakib.cse.20210204027@aust.edu', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'user', NULL, '2024-07-12 15:34:54', NULL, NULL, 0, NULL, NULL),
(10, 'ditto', 'shahriar rahaman', 'diptobhuiyan1999@gmail.com', 'e807f1fcf82d132f9bb018ca6738a19f', NULL, 'user', NULL, '2024-07-14 20:25:58', NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `course_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `youtube_embed_url` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `course_id`, `title`, `description`, `youtube_embed_url`, `created_at`, `user_id`) VALUES
(1, 1, 'DYNAMIC PROGRAMMING ULTIMATE COURSE OVERVIEW', 'In this video I discuss an overview of my full Upcoming Dynamic Programming Course.', 'https://www.youtube.com/embed/xeeo6nhq9IY?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(2, 1, 'Introduction to Dynamic Programming', 'In this video I discuss what is dynamic programming, how I approach its problems, what is bottom up/top down approach, what is memoisation.', 'https://www.youtube.com/embed/u7DdPBAJttU?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(3, 1, 'Frog 1 & 2: Atcoder 1D DP Questions', 'In this video I discuss Frog1 and Frog2 questions in Educational DP series of Atcoder along with their proper explanations and code.', 'https://www.youtube.com/embed/mnuBvHbMNJM?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(4, 1, 'Longest Increasing Subsequence (LIS)', 'In this video I discuss longest increasing subsequence problem of dynamic programming and also solve related leetcode question.', 'https://www.youtube.com/embed/mNrzyuus2h4?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(5, 1, 'Coin Change 1 & 2 : Leetcode DP Questions', 'In this video I discuss longest Coin Change 1 and Coin Change 2 problems of Leetcode in detail along with their explanation and code.', 'https://www.youtube.com/embed/PoTE56n_It8?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(6, 1, 'Knapsack Concept and Variations: Dynamic Programming', 'In this video I discuss the knapsack concept various questions related to it and what is general concept of thinking around them.', 'https://www.youtube.com/embed/o0NtrkItjws?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(7, 1, 'Knapsack 2 Atcoder Tutorial With Code: Dynamic Programming', 'In this video I discuss the Knapsack 2 problem of atcoder with proper explanation along with code.', 'https://www.youtube.com/embed/gHVtY5raAQg?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(8, 1, 'ROD CUTTING: Dynamic Programming', 'In this video I discuss the Rod cutting dynamic programming with proper explanation along with code. It is an example of unbounded knapsack.', 'https://www.youtube.com/embed/KnzlqtUDfIc?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(9, 1, 'SUBSET SUM & PARTITION PROBLEM : Dynamic Programming', 'In this video I discuss the how to find if sum is a subset sum in a given array and also Leetcode Partition Equal Subset Problem using dynamic programming with proper explanation along with code. It is an example of 0-1 knapsack.', 'https://www.youtube.com/embed/G46kdLkQ_Sw?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(10, 1, 'Longest Common Subsequence: Dynamic Programming', 'In this video I discuss the Longest Common Subsequence.', 'https://www.youtube.com/embed/Q0o9sU1r0FY?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `ContestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `ProblemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);

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
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);

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
-- Constraints for table `replies`
--
ALTER TABLE `replies`
  ADD CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `replies_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `replies_ibfk_3` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
