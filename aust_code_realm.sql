-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2024 at 04:39 PM
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
  `Profile_Picture` longblob NOT NULL,
  `User_Role` varchar(20) DEFAULT NULL,
  `RatingID` int(11) DEFAULT NULL,
  `DateJoined` datetime DEFAULT NULL,
  `RatingCategory` varchar(50) DEFAULT NULL,
  `LastVisited` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Handle`, `Name`, `Email`, `User_Password`, `Profile_Picture`, `User_Role`, `RatingID`, `DateJoined`, `RatingCategory`, `LastVisited`) VALUES
(1, 'johndoe', 'John Doe', 'john.doe@example.com', 'password123', 0x2f696d616765732f6a6f686e646f652e6a7067, 'admin', 1, '2024-01-15 10:30:00', 'Gold', 10),
(2, 'janesmith', 'Jane Smith', 'jane.smith@example.com', 'password456', 0x2f696d616765732f6a616e65736d6974682e6a7067, 'user', 2, '2023-12-20 08:15:00', 'Silver', 15),
(3, 'bobjones', 'Bob Jones', 'bob.jones@example.com', 'password789', '', 'moderator', 3, '2024-03-22 14:45:00', 'Bronze', 8),
(4, 'alicebrown', 'Alice Brown', 'alice.brown@example.com', 'passwordabc', 0x2f696d616765732f616c69636562726f776e2e6a7067, 'user', 4, '2023-11-10 09:05:00', 'Platinum', 20),
(5, 'charlieblack', 'Charlie Black', 'charlie.black@example.com', 'passworddef', '', 'user', 5, '2024-02-18 12:50:00', 'Gold', 5),
(6, 'Taju366', 'Kazi Zannatul', 'kazizannatultajrin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', NULL, NULL, NULL, NULL, NULL),
(7, 'AfnanRakib', 'Rakib Hasan', 'afnanrakib476@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 0x89504e470d0a1a0a0000000d49484452000001c7000001d80806000000387c23fc000000017352474200aece1ce90000000467414d410000b18f0bfc6105000000097048597300000ec400000ec401952b0e1b000028e749444154785eeddd079c54e5d5c7f1b32c2cbd2c481790a68020a0a0a88888626fd168ec0a1a156c31fada1282a0b107b042a222c6a85862c518bb280a46507a910e82f4deeb3be7f2ac2c67efbd33b333b3ececfcbe7ce6c33c77d72db3b2fffbb4f364ed8e100000f0ab52ee6f0000e0108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e0000188423000006e10800804138020060108e00001859bb23dc7314d2f6dd3b65dbae1ddedfe9202bf227a754b6e4649596ec2cee8f00c0221ce3f4d9ea69f2feca093266dd1c59bc758d2cdcbacabd253d55ca2e2b7573aac9816573a55b6e0b39ab465b695ba9817b2b006426c231066f2dff41febd629c7cb072a2acddb1d95d2db91a95ab21e71ed05e2eaa75a474aad2c45d0580cc4138867867c58f72d79c7fcb8c4d4bdc95cc73ce01ede4912617c8c1156abb2b0050f2118e3ea647c2f0fa9f5e92916b66b82b99ad745629b9b1fe89d2a7d19952bd4c457715004a2ec2319f55db374abff9efc9338bbe901dbb77b9abc8a3c1787fe3dfc875758f97525959ee2a00943c84a3a30b6b2e99faac8c5a3bd35d811f5de97a67c353a5df41e7484ea9d2ee2a00942c846384ae3c3d6ff2d3f2cbb6b5ee0aa23929b7950c6f75add42853c95d01809223e3c3f1b95fbe961b66beeced53447c0e2a7780bcd5bab7b4afd4d05d01809221a37780cfdcbc546e9bfd3ac15848f3b6ac909b66be9236c50f002056191b8e2bb66f9033263e21eb3260df622a7db37696f4fee95fae05002543c686e3ed911ea3f61c91381d9a1eb6e41bd70280f49791e1a8bfc85f5cf2ad6b211974de56875901a024c8b8705cb475b537cf88e4dab4739b5c397da86b01407acbb870d41e8e6ef647f27db5e6278657b15f8c1f3fde3d039223a3c2517b8d5a3c1ca93364f148f70c283aefbcf38e7b0624474685e3938b3ea72c5c8a7db76e8e575401282af3e6cdf31e4032654c38ea5ebce1cbfee75a48a5218bbf74cf80d4d35ee3bbefbeeb5a4072644c38ea70eafc2d2b5d0ba9f4e6f271b271e756d702524b8371cd9a350cad22a932261cf56cc6546898535d3a546c249d2b35f51ee9a04df97abf7ebdfaf5974d7201710dc64f564f752d2075befcf24befa11e7ffc71ef6f201932a6b6ea4163ee4c5acf5103e5ce3adde592ea1ddd95bd72c7dfee9e155f239af592634d907fb076b23cbce46399b479b1bb92985b0e3c490635bbc8b580d438e184137e0d47f5f6db6fcbb9e79eeb5a40e16544cf51b76e242b18351027b4bac73718d3d919555bcb5787fc3112fa27bb2b89f99283a2916283060dda2718558f1e3dbc2156205119118e7a56633268203eddf077ae5532dd1509c7647c8f93372e92dd913f402ae8fce2adb7deea5a7b69306a6f928044a232221c176f4bfc1f8af6ac4a7a30e6d19b805e358f73adc2d9b97b97acdbb1c5b580e419366c98d7430ca205010848242a23c2714d124ede78a0fed9ee5966d0e1d5aad9e55dab70b6ecdaee9e01c9d1af5fbf98864e3520dbb76f5f60d81588554684e3a604b715684f4a17e10459b7738b7cb361b6f74807bae846bfd685db56bb2b05693026a3f70824c38b2fbe288d1b37967befbdd75d894e0b03680f52c3942201885746ac567d72d16772f3cc575d2b7e2f37ee21a7573dd4b5f675cfa27765f0f2af5d2b49be5d20d2f733d730869d2f52bf8a6b244e878bffd5f82ad7da9786689719035c2b7e733b3d2407953bc0b580d86890cd9f3fdfeb1deadca23e923144daae5d3bb9eaaaabbcbfd5f1c71feffd0df8c9889e6356e44f225a97afeb9eedebd55563931f8ceaf339223b22bd2ebfc717c92dcda65b3834e0fde87ec844ecca8c5d4248b2830e3a481a356a2455ab56fdf5910c791f53fb036ddbb67557017f19118e890a1a52d56049ba4ddbf7f41c8324391cd5a890e1e0b0e16420553420bb76edea6dd7d09ee4175f7ce1855b615c79e595b27af56aaf07aa3d47fdb8d5aa55736f05fc118e0958bb33f1853e057c3d4f6473c8429639ab457e4aeea1c2611bff1be6e4ba67c0fea381a6213970e04077253aed1dce9d3bd75bdd4a18225e846371f3c55cf724440a7a8f403af8c31ffee0f522a30db59e73ce39de4a55ed81028541381627ab223dd1718b5c23c4979100653e0f194a7b91615b3474a18d0ea1d25b44223262b5ea538b3e979b66bee25af15bddee31f76c5f67cd1a1c3a5f17b7b7a6883c39c635a218709a48fbc416cce4978aef71f6510f4a93f2355d0b853175ea5419356a946bedab49932672d24927b956e6f12b06a043a91a9c2521183f5f3dddab34e5a7539526726495c6ae8554201c635064e178d30891c94b5d238a335b88dc76ac6b242e5dc271e3c68df2dd77dfc98c193364f1e2c5b261c306c9c9c9f17e19ea505bf3e6cde588238e90ead54bc642a27ffce31f72dd75d7b9d6be2ebae82279f5d5c26f512a09b4173972e448d7126fc855af95043da7bf202f2cf9c6b5f6d5a7d199d2bf3105d65389708c419184e3a2752297bde11a31a85a4ee48d8b44ca64bb0b8929cee1b879f366193e7cb8bcf6da6bde2fc22d5ba297a56bd1a2859c7cf2c9f29bdffcc61b66cbca4a6c3bcffe92cee118f6cbdd4f99ac6ca956ba82d4caa92c1d2b37966eb92de4c29a1d438f54cbab84a3f4e75c922ae2108efb17738ec585ee6df4533ae047b4361210637e768d9269dbb66d3278f06069d9b2a5f4ecd9533efae8a39882514d9f3e5d9e78e209af428a0eb5bdf7de7bee2d28aeb6efde29cbb7af97291b17cbb048285c31ed796930faffe4e1051f06ee99d50dfdbaf846e9621d205908c7e2c26f056ab31a917ffdfe05083c2578d5ea679f7d26ad5bb796debd7b7bd552123169d224ef17e8902143dc15a40b0dcbbbe6fc5b3afff890f7dc8f9edfa843ea9ce38864221c8b83192b44e6fad439ed502ff2a8ef1a3eb458c0c66dae5132ecdab54bfefad7bfcaa9a79e2a3367ce74571357ae5c39ef63223d8d5e375b4e993050d6f91c22a0738c0423928d702c0e8286543b1c28d231f208b27587c85725a7a0f2f6eddbe5820b2e903ffff9cfb26347e47b4b22ad8cc29eb7f4f6e3860572c79c375d6b2ffdb9f2b345b2118efb9bcea58cf4d9f85fa18cc861b5459ae48ad40b29341e4bd1803471fdf5d7cb5b6fbde55ac9a3bdc63befbcd3b590ce86fe324a666d5ee65a7be9cd0f904c84631429af2dfae32f224b37b8463eba87316f256aa790dee30f8b45566e728de44bf44cc758e9514443870e75add8942a554a6ad7aeed2db839ecb0c3a456ad5aee2dfba2d758fce496ae20bbbb3e273b8f7f56d6747e52be697fb73cd2f4b7d2a85c0df71efe74d1ceebcbbe77adbdf8f922d908c728eeacd3dd3d2b2829db3802875423e198e7c806ee898f9d7a5247e2bd473d93d2cff5099ee9188bd1a347cb7df7dde75ae134006fbdf556f9f8e38f65d3a64db264c9126f39ff84091364e9d2a5defe475de19ab7d78d5e63f1562a2b4baa962e2fc7546d2affd7e05499d0e15e6951a18e7babbf4f574f73cf80d4211c03688fe9e986bff30e3af63339a45877ccb6ed8c246cc04accfc738dedeb8a54cc710d1f5f26be6a35e88491ce959acafbcd7aa5ac07a9db6c6fbffd766f214e18dde8dfa74f1ff9e9a79f64c08001d2bd7b77295bb6ac7beb5e071f7cb0373cab9bc1bff9e61baf474aaf227d68503ed0e43cd7f2f7f3d6e043ba8164211c7de839861a0841c1a85e59557068276e6316eed9af68e93c63fe038d73b223bdc790a1d529cb4416ae758dc2093b7e4b037242ab7bbcbf934d4f78fff6db6f5dcb5f6e6eaeb74fb17ffffe719ded77cc31c7d06b4c43a7e4b676cffcad08d8d2012413e16868206a30861df4bb70dbea48388e75ad0404ed533cca6718f5e890a15595e09e470dc76f428689b5e7a8afcb9d754e765792e36f7ffb9b7be64fe7155f7ef96539e59453dc15947415b273bc6a3941ca944a4e5528200ce1984faf9ac77943a9d186107b2f189ef8598e1bb6898c8ef41cfd74f20942bd16542d4705cd5dc6a1f782d702e71ef3dc1509477d8d92e1ebafbf96c993c30f8cbef9e69be5b4d34e73ada2a7b55cf36ab8a6820e272f5bb64c56ad5ae50d311785b56bd7ca2fbffce255202a8e166d5ded2dbc0952a37425f72c7ebb237f966e5be73d76ee0e1fca8f9756f159b26d6da467bbc1fb3cc5ddd65d3b64f1d635b223ced741df5f7f461b776e75574a266aab3a7aa7baacedc3aee54f83e3d2b92f246721ce873f893cf2b56be4532d12ccffbe3872dbe2530bf48e8f44be0f2919f7ccd9222d13ab65aa3de611cd7a4b95ec72ee8abf3a13eff2fe718589565bf54f7ffa933cf0c003ae55900ea16a21809a358bee640fadcdf9c1071f78c1ad957574d14f9e0a152a78ab62bb74e922679e79a61c775ce1162b6969bb7ffef39fdee799366d9ab7bf53e9bc6aa74e9dbc5eb2d653ad51a346526aabce9e3ddb7b3f2dbfa78b97f207bdaef6d5e1e76eddbac9e5975f1ed7b0753461b54175b5eaaace4fb8d6beee9f3f42facc7dc7b50abaa8d691f26aab6b5d2bba2fd64c97d7967d2f9fae9e2af3b7acfc350cb2227fea95ad26c7566d2667d6384c2ea975946467c5d75fd05277cffdf2b57cb072a2ccd9b2fcd7c02d1df938ed2a359453abb7969b0f3c516a96a9ec1532787bf98fdedbadd615ebc915758e71ad3de2adadfae6f271f2bf75fe8bf34eaede4a4eca6d255b766d97c77ffe54feb5748cf7b56b88eba2a83a3955bdaff58ada47cbf1d50e71ffd55e5a7c61f0e22fbdb27e33372ffbf5fbd4d7af6be4fd6fa8d7cd5b545592108e4ef5c83fd6d9adfbbb96bf2e3306849e9a1f97fffbafc8589fe3684e691ee99e75710de3bde92203430a395fd03ad2fd3bca350a4fb7af8c68d64b1ae4e4ba2b05359ed447d644e93d470b47fd85ac0b6782fcfef7bff7c2a1288c1831c2abcc33664c8c4786456848f6eddbd7fb3e62a105d4f586e0e9a79f8eda6bd35346f4eb295dba74a1c3517ba3faf53df7dc7331d5a4d530d695c077dd75976467273e745998701c1109990ba70c91cdbb825f9f175af490abea443f9166c2868572ebacd7bc708c45c372d5e581c6e7c9a5b53bb92bc136eddc267f9cfd9a3c1f09c6683daf8ad965a5ff41e74402335b6e99e5fff33aab465b79afcd4daeb547bce118edfd4fabd1462e9dfaacccddb2c25df57759e4fb7fbaf9a552a5f49e11b42fd7ccf0eadc2edcbaca6b07f95dad8ef28f83aff8f5bf4b770cab3aeb631822d06d0d4959b5a9fb12757fa31fbf21d53cc7368cdcce849c2ea18720ef4afc5e47b7af8405a3dabc7b4f6f271153a64c71cffc15c53ca30e9bf6ead54bce3aebacb882517df5d557deaa595df4132dec34a8747878e0c081310d67ae59b3466eb8e10679f4d147dd95f868aff7d8638f95a79e7a2ae662ed2b57aef4aa13e969263ad49b4adb76eff436f46bb8e4ddbc7618779f9c35e989d0603ca04c25ef977034da333ae6c707630e46b560cb2ab96cda7372cd8c1743875c75d8b4ebf847e4ef8b47c63424a9c38fb7cd7e5d1e5918b921de4f3e5b334d4e1cffb7a8c1a8f4b53b6bf293de30b1ee29ed3ee16f51835169effce48903437f7ee9847074748ee3e1251fbb963f5dacf340fdb35d2b013a3fa8fb13fde8cad4f191e0f47be88ad48621c35ecb37ee290a9080b0ed2b795e5d3536ea906a341a10d17e01ebb153a9a443a6891624d739c3471e79442ebef8e2c092773a6c7ade79e7ed73ee60ac66cd9ae59ec56ee2c489def14d3a7c5b189f7ffeb99c7ffef95e4f37553430ae9e31cc0b220d460dc871eba317987fb0c9f952be54c8b6a6080dadcb2321a7bdbbc2d0c0be61e6cbaeb5af6d91ffef4f9f3848be5f1f7fd9469da7db5fbe5d3b3baed0fa6acd4f72eee4a7bc9b8578e624bf5b37471e9cff1fd74a6f84633e0f45c2f19e45efba963f0d8e07ebef3922a7d0c25696fee913915b23ff73053de6af71ef1820818539ba20299660d4054989ca3f971724950716eb6c82069a9efe910c5af6eeda6bfde7c1fef297bf142a180b438b22e81996ab57fbff22d67da03a5cad3dc4b039c651a346c91d77dce15ac583cec95d53377c9ef793d55343a750da576ae87d8c5b0e3c494ecc6de9cd3bfad1807d69e968d7da4b6bbb162618d3d1fb2b27842e8c0aa2373a41478ca513c2d118bc3c72d7b8e035d7f2a7c3ab615b3d422d8884dbb4e5ae91025a54606bfcff43eb7071b46d1adab34e4630aa4a95a2af38d461be5419366c584c673cea56129d8bd3bfa379e18517bcb9cbfc162c582083060d72ad70952b578ee9750973cf3df7c89c39fe3748b7dc728bd7abd4795cad48a48b82a64e9d2a1d3a7470efb12f7dbfa08f55d4aeadd745861e125e3f557b75d7cdf8a7ef2f740dc1e70eb9527ee8f0177936f2f7a06617c9a76d6f93afdadf2195b20b169350fde6bdb7cff0aa0e493eb328788e3cbf72a5ca841ed2bcbf1c51b991f4acdb592ea8d9c15b2414abb6951ac8e5b58f96f36b1e21d5cb547457fdaddeb12972039178d5aefd8d70f4a11bfcf504fcb06d0dbd6a062c9a8926095b2e42addf2a327a816bc4ee92ea1d42e753f586417bd6c9a20b4d3474c214664831163aa4abd576c2e890eeebafbf2eebd7af97152b5678db1f5e7ae9a5a8d57674fe31ff1a373d7039da9c9fce2dea10e8ba75ebbccfa7f3858529a4adc1a74515fce869f9baa7d45615aa57af9ef77df9d1d7e9f9e79f77adfd434bc9bddbfa46f9fbc157445d49aa3d96a039b5ab22bdceab7d7a9d9dab360facc8337bf372f9cfaa49ae25f2d8c28fa2f6a47ad43956a674ec2f9bbb0c962d5d86c88f1dfaca8531cc911685479b5e20638fe823cf476e325e3ff47a99dbe92139a15af4a90bfdefc647be8f7fb6bc5ade3cb497cc3dea21e954a5897babbf3931cc6d1677846300ddae71e6ac670203f2f4aa87ba6771d24533a95688820017870ca7ea8d42522a0219871e1afe1a7ef8e187ee5972e99cdaa2453e2b851d0d12addaa3c767e9f60da53dbacb2ebbccbbdebc7973ef9a1fed897dfffdded74ab76b8479f6d967bd4533871cb277f9bc1ef2acbdd0871e7ac85d898d86795019be56ad5ac98f3ffe2863c78e2df0d0ad1d3adcea475fabfde5d603bbcbb423ef97b30f68e7ae847b75d9ffdcb38274d5f49875737c1f8dcb05afa8fe78d5de4563ba5d23cc93cd2f91a12d7a48ab8a7b4795da457a5cafb5ba4eee3d28096b1512d0a6e281727b837d17b8e92a5aed4de784f4708f8a84a0fdef7435aa066cd8cdcaaaed1bddb3f4453886d06d1b7707cc416a2f2bee133ba62e8b3e67980cdf2ddcd3838c43d030b10ea526655fa78f8e1dc3efa8df78e30dafd7966cfffd6ff8aac1bffffdef5ec93a3f75ebd6f5c22c4c5ea8fffcf3cfa18b627431d035d75ce35a05692f5417d6c42aecfbd22a43fa7a073db466ad1f0dcfad5b93bfd95bb7729c57f370d7f23764f1c898e7f7966d5b1fbaa047f74d1efdc303be0f5d211be47f6e7850f747ea2348f7dc567263fde02d3d7d23e1d8b1f2feabf17b5c35ff1b3abd69382c129c41745ed68fde00342fef7f0a8e4a768185fd81708c22ace668c328db1d0a08ead1552b27f2f819224f9c19fbe3b090930b74ce31498720a72a1855b4ca37baa844f7fa25dbfcf9c1bf44b5d7a6611146b76fd4af5fdfb50a9a376fcf6bbf706140052447f7294613cbfbe4d18209c9a62b705335f73bac454f39b8426dd72a485757ea8a49ade212cdec2dcb52529546b76da8b06054b1ec8dbca476e27b900bab46e9e07942dddf19246caa25daf162e98e708c22e132717974ff61d0906a97c81da5865d9bc82f8a581f2745a9469160add5a270c2092748b366cd5ccb9fced9bdf34e70b594c2d0a3ad823469123e97a2b2b2b2a469d3e0d73fefe3470b95583e572cefa3746854e72c532155e15839bb9c3787a5c37b413418cf9efc64d46d085ab62d15f28607f3423248f3f2917f9351348be17df687ec42c640bcd584d20de15854c62d8afc0b0bd8be70426cbf00f7715c2450c36aadfef0cb9e7d8fc598ae00d5c52861740ead478f1e5ee9b364295f3ef86e38962d262aecfdf2e629f52cc930b17cae58bf1efd5cbac8298896a5d39277857924ba82368cce850d3ef832d7f2a7c3a55aa1254c8552c101abb4245ab7dc16713fba54db3317abab4fc36cdc157de8b9a4d7222d6908c7a212742071ddca226dc30f77f5a543b147040fed89ae984c83dea356a7095be0a2b45a8c56b079f0c107630e0ba5e739fa2d6ad17aa241c68d1b17758e4dabdde8cad02075eaecf97946ab09fbdd77dfb967c1a21de795478331ecfbd202eeefbfff7ea11e8d1b37761f2535748bc0f5f5f61c4e1d44eb86f69d17bc07b95ed9f09ab0ff6a798d7cd6f6f6b81fba5256d5cec977849c8f6fd7465f593d6a6df287bd913a846351d039c0af03e600bb457a8d6125e1c21c1f65823f28908b11dd5a10cb3e40ad32a37bf87455a79eeba89bd4f30a76e7a7f38943870ef5e6053b77ee2cfdfaf5fb750e304fbb76c1ab1f759ef3c9279f742d7f1ad26125e00e3f7ccf4213fd5ac37a5d5a9947833f88ce59eaf7122bed1d068965d5a9eec94cc5e29b583cdeeca2a80b56ee9b37428607ac486d55a19e542bbda7c7eee7c37c5b32824cdfb4c43d2ba855c5baa1fb16872c1e19ba4273de9615f2e292d86e74503c108e45e1dbf97b8ea8f2a3e158583ab45a36a440f4f4e545b33a3641a79f7eba57f03a16ba02548b69eb891855aa5491860d1b7a61a481a72b49751fe2d5575f2d9f7efaa9f7febac7f0e187f73d6d457ba161740fa41609b07488576b9d3ef6d863ee4a41da83d3a148a5439d1ad04134b4b5ac9c56b5b1748fa7ae668d67be2fecfbd2fd8f9f7cf2896b15347af4686f2152cb962de599679e89b91e6bb2e876827fb7ee2d35ca04df4ce8821b2d3937d66705abce7f9d563df890e47be7bd2773360717df18f4f32772e8f77da4fdd87ef2d6f21fdcd5bdb4649d6e6b08a2739ea74f7adc77f1d08c48e89e367190ac8f721c1c8a17c2b12804f5e09ad71069924089b44a392247062fc3f6a4bae8409268809d7d767c7bc1f417b8f6ae74ffde8409137c434669d0e5ef3d6a009c7aeaa9ae55907e5c9de73cf2c823bddeea800103bc6d151ac0d14aaa5d7ae9a552abd6de25ee575e79a57be64f4f25d18203fa7efa1ae830f025975ce21d8da5df573c2ebcf0c2c08542dacb3ee38c33e4a69b6ef28673b587ace7546a0ffc8f7ffca374eddad5ab753b77ee5c6f1e585fa3788a96274383b2d5bde1cfb0851e5a2ff59c8015acba1f4f8f5ff2a3ef7ff8b8fe5ed51b3daa497b791a961a84a74c1ce89ddea125cfc66f5828e74f7946da8ebdd71bcacdaf679de01b1da575459bffef1eb960ca60eff36820ebd7dae6fbbea1bd52144f8463aae97e43dd77e8a75b12ce3f3b3eca7c509a846399326564f8f0e1293989c3aff7a83d403d3f318c6ee6d721d4db6ebbcd2b2eae956bc2e83153f67c4a0d2c0dba305a7d474bb9e9515177df7db7770c55618a7eeb42a3fbefbfdfb50ad280d4c0d3e157ad5babdb51b407ee775288de4c6890ea4d4151d23305ffdc684fcf3b48d00ad6c32b37922b6aef7b26627e6b776cf602abf5f77f911adfdc224dbfbbdb0bc2fc1bfdf34cdcf0b317722f2fdd7b528bce8d465b95aae1ada1aa9f4703f2bd15e30b559f14fb1fe1986a23233d966d3eff38f40e379121d53cc73414a910b292eee7b5225382b72e1427facb5d1780e8229d64b3bd47ddcf3878f060d74a9c0ea1bef2ca2b5e39b6fc7445ae96600b5b219b4cba2f32d621ea6874ce5487b08b5adf83ce9253aa87574fd215ac574e2b381fabe7107648d266fbd3f5fcc37cfb17b557aa25d4f46074947c8463aa05ad183dbcae48adf002be31291f09c6b03320d5e7c57f614e1eed41ea9c97f69ec236dac74b7b8fb62878cf9e3dbd7d94fa3913a105c3b53e695051032decad411cb6d52288cea3c64be744c32aefc442f79feaeb95ca9351826445febcd2f2dad0cde9ea8de563bd1e5a7e15b27364449b9be5b04a51a61ba2d02d1c6fb42a7893a635459f8a0470d0f06d986805bb51bc108ea9b46c63f0a1c627266148354fb4a1d59191700c3a3fb298d21e900e63eab05e5029b758e9a1bf5ae3f4c61bf72ccbcf4f870e75de2fa8b66834ba8845e7f07efbdbdfba2bfe744e51cbe1051d11e547e71ec316ff04d1deaad66cd555b7797b2ee371eeb9e77adb60a2156848250d92370fed1df5648bfef3def70ed9cd4fb75d8c39fc9e98aad658a5b34a79c759e9360e0d5a3f7a42888677d0dbfd9c73403b79ace985ae857440382620acb49247e7fbfcce352b1bf907af2b4d93e5a848cfb172c826e8959b44c6061f821c76fcd6826dfbef80560d455da0327bf66caf87a7157562ed7de9aa553db7507fc9eba2135d111b44c353835857741e7df4d1518fa7d2afa15bb76ede198e63c68cf116afc44243470b936baf2e2cb47438538768b51eaa3d45231e7a33a0b55d7bf7eeedcd8786d161615d1dfbf1c71fcbdb6fbfbdcfa2a2fd45b7760c6c165e3e4f57b0f69cf1428115acbaba5417f78c6a7f979c94db2a6a3517add6a3e745ea91567a9c95866498dfd5ea28338efcab57122eac70b7f67e5f68d143de697da394cd8a7fe400fb4fd6eefce7eb94507a944dd801a8d14c6cf52769e05347355907ffee6f77d53939f02cc7dcf1b7bb67f19b7dd4835e61e364d25596ba8a73ca94295e51722d99a6e5dc2a56ace86dbed7506cd3a68db7c5a3b074fb8486aa86b26ef8d7d26cba5f518718b587a9db33e2e901fad18fa9db4db4e0b7ae12d5a15dfdfa8f39e6186f1856bfa764d205377a93a0c50bf4f36931057dcdb47080ae96d59b021d1e2ea97475ea7f574d96599b97c9f2edebbd45321a885a1fb44dc5fa726cd5e6510331886ed1f8cfca49de968da5dbd77973927573aa7a43b33a0cabc3c4483f84630c5e6edc23f0882a3db563c8f2af5d2bfd9c51b5b5fcabb1ffd98193372f96e3660c70adf8a5221c01a02864c4b06a61ef08f3849dccf160fd73645e9bfbe4fd66bdbc473ad0af59bfd609adee090c4695e8891c8559b40000c541468463a24baff5a0df8521736f3af7d8b95253ef910e748e51bfd6b0f328f590e7444ffecf618e05409aca88700cabb918aba0438f4baa87967c94f0715d610b1500a038cb8870ac5926f185063ab47ac382d75cab64d385468393308f5a253bfcc8260028ae32221ceb950d5fc61e2b1d5e2de901f9f0928f93b20257f79ad1730490ae32221c75b976b4c34a63a501d976ea035eefaa24f9cfda29d265c68084e719f3e8127600485719b19543751dffa88c5c33c3b5924717b5d42a5359cab9c52789aef02c0aba2027af80816ef25fba639d6cddb5c36b27cbc066bf933f1cd8ddb50020bd644c38de3f7f84f499fb8e6b21d52675ec27ad2b26af362a0014a58c1856555a67914a1545a36da506042380b49631e1d8b8dc01d2bd7a2bd7422a5d57ef78f70c00d253c684a3ba9539b094cb2d5d41aeaa137ce02c00a4838c0a473d40b56585f8cfc743ecae8df41af5440400486719158e3ae7785fe3735d0bc95629bbacdc58bf9b6b0140facaa87054e7d73cc23b7814c9f768d30be4c0b2891d4c0c00c541c685a31a72f0e5522727b1f3f8b0af6eb92de4fa7a5d5d0b00d25b4686a306a39e128ee4d05271afb4bcd6b50020fd656438aa13735b4a7fe61f93e2f556d77b0109002545c686a3ead3e84cb9a06607d742610c6dd143ba543bd8b500a064c8e87054c35af464814e213ddeec62e951e758d702809223636aab46d37fdefbd2775e661d685c5835ca54f2865275110e00944484633e1fae9a243da70f9325dbd6ba2bb08ea8dc48de6e7d8334285bdd5d0180928770343418ef98fda6bcb474b4bb0255213b47fa363a5bee6878aabb02002517e11860d4da99f28759c365dcfaf9ee4ae6babcf6d1f24093f3d8e00f2063108e51bcbeec7bb96ffe0899bc7191bb9239b416ed634d2fe4f829001987708cd1f44d4be4bd15e3e5ed153fc8987573dcd592a5627659e99edb4aceab79b89c51fd30a95ea6a27b0b006416c2b110d6eed81c09cb5f64e5f68db272c70659bd7d93acdab1d1bbbe3bf2a7b8cbce2ae51d2d55ab4c15a95ababcd4888460cd3295bd438a01008423000005647c110000002cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c010030084700000cc211000083700400c0201c01003008470000f621f2ff1229a7d8bc096f100000000049454e44ae426082, NULL, NULL, NULL, NULL, NULL);

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
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
