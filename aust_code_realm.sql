-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2024 at 09:59 AM
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
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 10, 'dasdadasdasd', '2024-07-27 05:37:26'),
(2, 2, 10, 'saSADSAD', '2024-07-27 05:38:25'),
(3, 1, 1, 'dsaadasdasdasdasdasdasd', '2024-07-27 06:34:25'),
(4, 1, 1, 'dsaadasdasdasdasdasdasd', '2024-07-27 06:34:55');

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
(25, 1, 'hello', '2024-07-15 03:03:18', 10);

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
(1, 13),
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
(4, 'Sorting', 'Explore various sorting algorithms.', '../../images/Sorting.jfif', '2024-07-12 13:06:12', 1),
(5, 'ML', 'about machine learning', 'https://blog.daway.in/wp-content/uploads/2024/01/1_cG6U1qstYDijh9bPL42e-Q.jpg', '2024-07-15 16:04:41', 10),
(6, 'PHP', 'php full course', 'https://www.thedroptimes.com/sites/thedroptimes.com/files/2024-04/php-card.png', '2024-07-17 07:40:59', 10),
(7, 'JavaScript Tutorial Full Course - Beginner to Pro (2024)', '\r\n✅ Don\'t worry if you\'re halfway through the course or finished the course, you can skip the lessons you already finished and take the final test to get your Certificate.\r\n❤️ Thanks for supporting SuperSimpleDev!', 'https://www.tutorialrepublic.com/lib/images/javascript-illustration.png', '2024-07-17 07:47:21', 10),
(8, 'AJAX Tutorial', 'Using AJAX the data could be passed between the browser and server using XMLHttpRequest API without complete reload of the entire webpage', 'https://miro.medium.com/v2/resize:fit:1400/1*QuMR4e-gMbOomdrQQZXtUg.jpeg', '2024-07-17 07:50:03', 10),
(9, 'Deep Learning for Computer Vision with Python and TensorFlow – Complete Course', 'Learn the basics of computer vision with deep learning and how to implement the algorithms using Tensorflow.', 'https://images.ctfassets.net/3viuren4us1n/14l8OD8yRKAV7hi6qiAH9r/56ab584206079397eaa939fd81315163/Computer_vision_3.jpg', '2024-07-17 07:52:43', 10),
(10, 'asdasda', 'dasdadasd', 'https://assets.skyfilabs.com/images/blog/what-is-computer-vision.webp', '2024-07-17 07:53:11', 10);

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
  `AuthorID` int(11) DEFAULT NULL,
  `sampleTestNo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`ProblemID`, `Name`, `PlmDescription`, `InputSpecification`, `OutputSpecification`, `ProblemNumber`, `Note`, `TimeLimit`, `MemoryLimit`, `RatedFor`, `AuthorID`, `sampleTestNo`) VALUES
(1, 'Sum of Two Numbers', 'Calculate the sum of two given numbers.', 'Two integers a and b.', 'A single integer representing the sum of a and b.', 'P001', 'Basic arithmetic problem.', 1, 512000, 1000, 1, 1),
(2, 'String Reversal', '<p>Reverse a given string.</p>', '<p>A single string s.</p>', '<p>A single string which is the reverse of s.</p>', 'P002', '<p>String manipulation problem.</p>', 2, 512000, 1200, 7, 2),
(3, 'Prime Number Check', 'Determine if a given number is prime.', 'An integer n.', 'A single line with \"YES\" or \"NO\".', 'P003', 'Number theory problem.', 1, 512000, 1500, 1, 1),
(4, 'Matrix Multiplication', 'Multiply two matrices.', 'Two matrices A and B.', 'Matrix C which is the product of A and B.', 'P004', 'Matrix algebra problem.', 5, 512000, 1800, 3, 1),
(5, 'Graph Traversal', 'Implement BFS and DFS on a graph.', 'A graph represented as an adjacency list.', 'The order of nodes visited in BFS and DFS.', 'P005', 'Graph theory problem.', 3, 512000, 2000, 4, 1),
(6, 'Double Ended Queue', 'A queue is a data structure based on the principle of \'First In First Out\' (FIFO). There are two ends; one end can be used only to insert an item and the other end to remove an item. A Double Ended Queue is a queue where you can insert an item in both sides as well as you can delete an item from either side.\r\n\r\nThere are mainly four operations available to a double ended queue. They are:\r\n\r\n![Double Ended Queue](CDN_BASE_URL/6c444093f691ab00de2df3aef0808e5d?v=1720739565)\r\n\r\n1. `pushLeft()` inserts an item to the left end of the queue with the exception that the queue is not full.\r\n2. `pushRight()` inserts an item to the right end of the queue with the exception that the queue is not full.\r\n3. `popLeft()` removes an item from the left end of the queue with the exception that the queue is not empty.\r\n4. `popRight()` removes an item from the right end of the queue with the exception that the queue is not empty.\r\n\r\nNow you are given a queue and a list of commands, you have to report the behavior of the queue.', 'Input starts with an integer **T (&le; 20)**, denoting the number of test cases.Each case starts with a line containing two integers **n, m (1 &le; n &le; 10, 1 &le; m &le; 100)**, where **n** denotes the size of the queue and **m** denotes the number of commands. Each of the next **m** lines contains a command which is one of:\r\n\r\n| Operation | Action |\r\n|------------------|--------------------------------------------------------------------|\r\n| pushLeft  **x**  | pushes  **x (-100 &le; x &le; 100)**  to the left end of the queue |\r\n| pushRight **x** | pushes **x (-100 &le; x &le; 100)** to the right end of the queue |\r\n| popLeft               | pops an item from the left end of the queue |\r\n| popRight             | pops an item from the right end of the queue |', 'For each case, print the case number in a line. Then for each operation, show its corresponding output as shown in the sample. Be careful about spelling.', 'A', '', 1, 512000, 1000, 7, 1),
(13, 'Distinct Numbers', '<p>You are given a list of <span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">nn</span><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord mathnormal\">n</span></span></span></span></span> integers, and your task is to calculate the number of <em>distinct</em> values in the list.</p>', '<p>The first input line has an integer&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em>: the number of values.</p>\r\n<p>The second line has <span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">nn</span><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord mathnormal\">n</span></span></span></span></span> integers <span class=\"math inline\"><span class=\"katex\"><em><span class=\"katex-mathml\" style=\"font-family: \'book antiqua\', palatino, serif;\">x<sub>1</sub>,x<sub>2</sub>,&hellip;,x<sub>n</sub></span></em><sub><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord\"><span class=\"msupsub\"><span class=\"vlist-t vlist-t2\"><span class=\"vlist-r\"><span class=\"vlist-s\">​</span></span></span></span></span></span></span></sub></span></span>.</p>', '<p>Print one integer: the number of distinct values.</p>\r\n<h3 id=\"constraints\"><span style=\"font-family: arial, helvetica, sans-serif;\">Constraints</span></h3>\r\n<h3 id=\"constraints\"></h3>\r\n<ul>\r\n<li><span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em> &le; 2&sdot;10<sup>5</sup></span></span></span></li>\r\n<li><span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">x<sub>i</sub></span></em><sub> </sub>&le; 10<sup>9</sup></span></span></span></li>\r\n</ul>', '1', '', 1, 512000, 800, 7, 1),
(14, 'Ferris Wheel', '<p>There are <span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>n</em></span> children who want to go to a Ferris wheel, and your task is to find a gondola for each child.</p>\r\n<p>Each gondola may have one or two children in it, and in addition, the total weight in a gondola may not exceed&nbsp;<span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>x</em></span>. You know the weight of every child.</p>\r\n<p>What is the minimum number of gondolas needed for the children?</p>', '<p>The first input line contains two integers&nbsp;<span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>x</em></span>&nbsp;and&nbsp;<span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>x</em></span>: the number of children and the maximum allowed weight.</p>\r\n<p>The next line contains&nbsp;<span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>n</em></span>&nbsp;integers <span class=\"math inline\"><span class=\"katex\"><em><span class=\"katex-mathml\" style=\"font-family: \'book antiqua\', palatino, serif;\">p<sub>1</sub>,p<sub>2</sub>,&hellip;,p<sub>n</sub></span></em><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord\"><span class=\"msupsub\"><span class=\"vlist-t vlist-t2\"><span class=\"vlist-r\"><span class=\"vlist-s\">​</span></span></span></span></span></span></span></span></span>: the weight of each child.</p>', '<p>Print one integer: the minimum number of gondolas.</p>\r\n<h3 id=\"constraints\"><span style=\"font-family: arial, helvetica, sans-serif;\">Constraints</span></h3>\r\n<ul>\r\n<li><span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; <span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>n </em></span>&le; 2&sdot;10<sup>5</sup></span></span></span></li>\r\n<li><span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; <span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>x</em></span> &le; 10<sup>9</sup></span></span></span></li>\r\n<li><span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">p<sub>i </sub></span></em>&le; <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">x</span></em></span></span></span></li>\r\n</ul>', '2', '', 1, 512000, 1000, 6, 1),
(15, 'Dice Combinations', '<p>Your task is to count the number of ways to construct sum&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em> by throwing a dice one or more times. Each throw produces an outcome between <span style=\"font-family: \'book antiqua\', palatino, serif;\">1 </span>and&nbsp;<span style=\"font-family: \'book antiqua\', palatino, serif;\">6</span>.</p>\r\n<p>For example, if <span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\"><em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em>=<span style=\"font-family: \'book antiqua\', palatino, serif;\">3</span></span></span></span>, there are&nbsp;<span style=\"font-family: \'book antiqua\', palatino, serif;\">4</span>&nbsp;ways:</p>\r\n<ul>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1+1+1</span></span></span></li>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1+2</span></span></span></li>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">2+1</span></span></span></li>\r\n<li><span style=\"font-family: \'book antiqua\', palatino, serif;\">3</span></li>\r\n</ul>\r\n<h1 id=\"input\"></h1>', '<p>The only input line has an integer&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em>.</p>', '<p>Print the number of ways modulo<span style=\"font-family: \'book antiqua\', palatino, serif;\"> 10<sup>9</sup>+7.</span></p>\r\n<h3 id=\"constraints\">Constraints</h3>\r\n<ul>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; n &le; 10<sup>6</sup></span></span></span></li>\r\n</ul>', '3', '', 1, 512000, 1200, 6, 1),
(16, 'Minimizing Coins', '<p>Consider a money system consisting of&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em> coins. Each coin has a positive integer value. Your task is to produce a sum of money <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">x</span></em>&nbsp;using the available coins in such a way that the number of coins is minimal.</p>\r\n<p>For example, if the coins are <span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">{1,5,7}</span></span></span>&nbsp;and the desired sum is <span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">11</span></span></span>, an optimal solution is <span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">5+5+1</span></span></span> which requires&nbsp;<span style=\"font-family: \'book antiqua\', palatino, serif;\">3</span> coins.</p>', '<p>The first input line has two integers&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em> and <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">x</span></em>: the number of coins and the desired sum of money.</p>\r\n<p>The second line has&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em>&nbsp;distinct integers <em><span style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">c<sub>1</sub>,c<sub>2</sub>,&hellip;,c<sub>n</sub></span><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord\"><span class=\"msupsub\"><span class=\"vlist-t vlist-t2\"><span class=\"vlist-r\"><span class=\"vlist-s\">​</span></span></span></span></span></span></span></span></span>:</span></em> the value of each coin.</p>', '<p>Print one integer: the minimum number of coins. If it is not possible to produce the desired sum, print <span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">&minus;1</span></span></span>.</p>\r\n<h3 id=\"constraints\">Constraints</h3>\r\n<ul>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; n &le; 100</span></span></span></li>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; x &le; 10<sup>6</sup></span></span></span></li>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; c<sub>i</sub> &le; 10<sup>6</sup></span></span></span></li>\r\n</ul>', '4', '', 1, 512000, 1200, 6, 1),
(17, 'Labyrinth', '<p>You are given a map of a labyrinth, and your task is to find a path from start to end. You can walk left, right, up and down.</p>', '<p>The first input line has two integers&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em> and <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">m</span></em>: the height and width of the map.</p>\r\n<p>Then there are <span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">nn</span><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord mathnormal\">n</span></span></span></span></span> lines of <span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">mm</span><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord mathnormal\">m</span></span></span></span></span> characters describing the labyrinth. Each character is <code>.</code> (floor), <code>#</code> (wall), <code>A</code> (start), or <code>B</code> (end). There is exactly one <code>A</code> and one <code>B</code> in the input.</p>', '<p>First print \"YES\", if there is a path, and \"NO\" otherwise.</p>\r\n<p>If there is a path, print the length of the shortest such path and its description as a string consisting of characters <code>L</code> (left), <code>R</code> (right), <code>U</code> (up), and <code>D</code> (down). You can print any valid solution.</p>\r\n<h1 id=\"constraints\">Constraints</h1>\r\n<ul>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; <em>n,m</em> &le; 1000</span></span></span></li>\r\n</ul>', '5', '', 1, 512000, 1300, 6, 1),
(18, 'Distance Queries', '<p>You are given a tree consisting of&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em>&nbsp;nodes.</p>\r\n<p>Your task is to process&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">q</span></em>queries of the form: what is the distance between nodes&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">a</span></em> and <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">b</span></em>?</p>', '<p>The first input line contains two integers&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">n</span></em> and <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">q</span></em>: the number of nodes and queries. The nodes are numbered <span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1,2,&hellip;,<em>n<sub>1</sub></em></span></span></span><em>.</em></p>\r\n<p>Then there are <em><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">n&minus;</span></span></span></em><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\"><span style=\"font-family: \'book antiqua\', palatino, serif;\">1</span></span></span></span> lines describing the edges. Each line contains two integers <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">a</span></em> and <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">b</span></em>: there is an edge between nodes&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">a</span></em> and <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">b</span></em>.</p>\r\n<p>Finally, there are&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">q</span></em> lines describing the queries. Each line contains two integer <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">a</span></em> and <em><span style=\"font-family: \'book antiqua\', palatino, serif;\">b</span></em>: what is the distance between nodes&nbsp;<em><span style=\"font-family: \'book antiqua\', palatino, serif;\">a</span></em> and <span style=\"font-family: \'book antiqua\', palatino, serif;\"><em>b</em></span>?</p>', '<p>Print <span class=\"math inline\"><span class=\"katex\"><span class=\"katex-mathml\">qq</span><span class=\"katex-html\" aria-hidden=\"true\"><span class=\"base\"><span class=\"mord mathnormal\">q</span></span></span></span></span> integers: the answer to each query.</p>\r\n<h3>Constraints</h3>\r\n<ul>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le; <em>n,q</em> &le; 2&sdot;10<sup>5</sup></span></span></span></li>\r\n<li style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"math inline\" style=\"font-family: \'book antiqua\', palatino, serif;\"><span class=\"katex\"><span class=\"katex-mathml\">1 &le;&nbsp;<em>a,b</em> &le; <em>n</em></span></span></span></li>\r\n</ul>', '6', '', 1, 512000, 1400, 6, 1);

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
(3, 3),
(3, 4),
(4, 2),
(4, 3),
(5, 1),
(5, 2),
(14, 12),
(14, 13),
(15, 3),
(16, 3),
(17, 5),
(18, 6),
(6, 1),
(6, 3),
(13, 1),
(13, 12),
(13, 13),
(2, 1),
(2, 63);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` text DEFAULT NULL,
  `error_log` text DEFAULT NULL,
  `problem_description` text NOT NULL,
  `attempted_solutions` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `video_id`, `user_id`, `title`, `code`, `error_log`, `problem_description`, `attempted_solutions`, `created_at`) VALUES
(1, 1, 10, 'i dont know', '', '', 'sdadasdkjodyudijanhodiuashd', '', '2024-07-27 05:37:17'),
(2, 1, 10, 'i dont know', 'sdaaaaadsadad', 'dasdasdasdasd', 'sdadasdkjodyudijanhodiuashd', 'ddasdada', '2024-07-27 05:38:13'),
(3, 1, 10, 'having isssue with my life', '.qa-nav {\r\n			padding: 10px;\r\n		}\r\n\r\n		.tab-content {\r\n			padding: 20px;\r\n		}\r\n\r\n		.question, .answer {\r\n			border: 1px solid #ddd;\r\n			padding: 10px;\r\n			margin-bottom: 10px;\r\n			border-radius: 5px;\r\n		}\r\n		\r\n		pre code {\r\n			display: block;\r\n			background-color: #f8f9fa;\r\n			border: 1px solid #e9ecef;\r\n			border-radius: 4px;\r\n			padding: 10px;\r\n			white-space: pre-wrap;\r\n			word-wrap: break-word;\r\n		}', 'error: life not found', 'i am not finding my life', '- did a flip(failed missarebly)\r\n- jump off the roof(didnt got scared)', '2024-07-27 06:08:04');

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
(2, 2, 1, 10, 'well done', '2024-07-15 03:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `SubmissionID` int(11) NOT NULL,
  `ProblemID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL,
  `LanguageID` varchar(55) DEFAULT NULL,
  `SubmissionTime` datetime DEFAULT NULL,
  `JudgeTime` datetime DEFAULT NULL,
  `TimeTaken` float DEFAULT NULL,
  `MemoryUsed` int(11) DEFAULT NULL,
  `Code` text DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`SubmissionID`, `ProblemID`, `UserID`, `LanguageID`, `SubmissionTime`, `JudgeTime`, `TimeTaken`, `MemoryUsed`, `Code`, `Status`, `Score`) VALUES
(1, 1, 1, '1', '2024-06-01 10:00:00', '2024-06-01 10:01:00', 1, 128, 'print(sum(map(int, input().split())))', 'Accepted', 100),
(2, 2, 2, '2', '2024-06-01 11:00:00', '2024-06-01 11:01:30', 1, 256, 's = input()\nprint(s[::-1])', 'Accepted', 100),
(3, 3, 3, '3', '2024-06-07 09:30:00', '2024-06-07 09:32:00', 2, 128, 'def is_prime(n):\n  if n <= 1: return False\n  for i in range(2, int(n**0.5) + 1):\n    if n % i == 0: return False\n  return True\nprint(\"YES\" if is_prime(int(input())) else \"NO\")', 'Accepted', 100),
(4, 4, 4, '4', '2024-06-07 10:45:00', '2024-06-07 10:47:00', 5, 512, 'def matrix_mult(A, B):\n  return [[sum(a*b for a, b in zip(A_row, B_col)) for B_col in zip(*B)] for A_row in A]\nprint(matrix_mult(A, B))', 'Accepted', 100),
(5, 1, 7, '1', '2024-06-15 10:15:00', '2024-06-15 10:17:00', 3, 1024, 'from collections import deque\n def bfs(graph, start):\n  visited = []\n  queue = deque([start])\n  while queue:\n    vertex = queue.popleft()\n    if vertex not in visited:\n      visited.append(vertex)\n      queue.extend(set(graph[vertex]) - set(visited))\n  return visited\nprint(bfs(graph, start))', 'Accepted', 100),
(30, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-25 07:26:04', '2024-07-25 07:26:04', 0, 884, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<a+b<<endl;\r\n    return 0;\r\n}', 'Accepted', 100),
(31, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-25 07:29:59', '2024-07-25 07:29:59', 0, 1068, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<a+b<<endl;\r\n    return 0;\r\n}', 'Accepted', 0),
(32, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-25 07:31:28', '2024-07-25 07:31:28', 0, 1008, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<a+b<<endl;\r\n    return 0;\r\n}', 'Accepted', 100),
(33, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-25 07:31:58', '2024-07-25 07:31:58', 0, 996, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<9<<endl;\r\n    return 0;\r\n}', 'Wrong Answer on test', 100),
(34, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-26 05:43:10', '2024-07-26 05:43:10', 0, 0, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<9<<endl;\r\n    return 0;\r\n}', 'Processing on testcase 2', 100),
(35, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-26 05:46:36', '2024-07-26 05:46:36', 0, 7888, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<9<<endl;\r\n    return 0;\r\n}', 'Wrong Answer on testcase 2', 100),
(36, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-26 06:04:19', '2024-07-26 06:04:19', 0, 7576, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<9<<endl;\r\n    return 0;\r\n}', 'Wrong Answer on testcase 2', NULL),
(37, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-26 06:09:25', '2024-07-26 06:09:25', 0, 984, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<9<<endl;\r\n    return 0;\r\n}', 'Wrong Answer on testcase 2', 100),
(38, 1, 7, 'C++ (GCC 7.4.0)', '2024-07-26 06:14:19', '2024-07-26 06:14:19', 0, 1000, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int a,b;\r\n    cin>>a>>b;\r\n    cout<<9<<endl;\r\n    return 0;\r\n}', 'Wrong Answer on testcase 2', 100),
(47, 13, 7, 'C++ (GCC 7.4.0)', '2024-08-02 06:29:33', '2024-08-02 06:29:33', 1, 11348, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int n;\r\n    cin>>n;\r\n    set<int> s;\r\n    int a=0;\r\n    ff(i,n){\r\n        int x;\r\n        cin>>x;\r\n        s.insert(x);\r\n    }\r\n    ff(j,n){\r\n        ff(i,10005){\r\n            a++;\r\n        }\r\n    }\r\n    cout<<s.size()<<endl;\r\n    return 0;\r\n}', 'Time Limit Exceeded on testcase 2', 100),
(48, 13, 7, 'C++ (GCC 7.4.0)', '2024-08-02 06:30:27', '2024-08-02 06:30:27', 0, 10208, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int n;\r\n    cin>>n;\r\n    set<int> s;\r\n    ff(i,n){\r\n        int x;\r\n        cin>>x;\r\n        s.insert(x);\r\n    }\r\n    cout<<s.size()<<endl;\r\n    return 0;\r\n}', 'Accepted', 100),
(51, 13, 7, 'C++ (GCC 7.4.0)', '2024-08-02 06:32:40', '2024-08-02 06:32:40', 0, 1560, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int n;\r\n    cin>>n;\r\n    set<int> s;\r\n    int a[5];\r\n    ff(i,n){\r\n        int x;\r\n        cin>>a[x];\r\n        s.insert(x);\r\n    }\r\n    cout<<s.size()<<endl;\r\n    return 0;\r\n}', 'Wrong Answer on testcase 2', 100),
(52, 13, 7, 'C++ (GCC 7.4.0)', '2024-08-02 06:33:43', '2024-08-02 06:33:43', 0, 1292, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int n;\r\n    cin>>n;\r\n    set<int> s;\r\n    int a[5];\r\n    ff(i,n){\r\n        int x;\r\n        cin>>x;\r\n        a[1000000000]=x;\r\n        s.insert(x);\r\n    }\r\n    cout<<s.size()<<endl;\r\n    return 0;\r\n}', 'Runtime Error (NZEC) on testcase 1', 100),
(56, 13, 7, 'C++ (GCC 7.4.0)', '2024-08-02 06:47:03', '2024-08-02 06:47:03', 0.128, 12196, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    int n;\r\n    cin>>n;\r\n    set<int> s;\r\n    int a=0;\r\n    ff(i,n){\r\n        int x;\r\n        cin>>x;\r\n        s.insert(x);\r\n    }\r\n    cout<<s.size()<<endl;\r\n    return 0;\r\n}', 'Accepted', 100),
(57, 2, 7, 'C++ (GCC 7.4.0)', '2024-08-04 07:51:20', '2024-08-04 07:51:20', 0.003, 1296, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    string s;\r\n    cin>>s;\r\n    reverse(all(s));\r\n    cout<<s<<endl;\r\n    return 0;\r\n}', 'Wrong Answer on testcase 2', 100),
(58, 2, 7, 'C++ (GCC 7.4.0)', '2024-08-04 07:52:47', '2024-08-04 07:52:47', 0.003, 1024, '#include<bits/stdc++.h>\r\nusing namespace std;\r\n#define M        1000000007\r\n#define INF      1e18+9\r\n#define PI       acos(-1.0)\r\n#define ll       long long int\r\n#define ull      unsigned long long int\r\n#define all(x)   (x).begin(), (x).end()\r\n#define pb       push_back\r\n#define tc         \\\r\n        int tcase,tno; \\\r\n        cin >> tcase;  \\\r\n        for(tno=1;tno<=tcase;tno++)\r\n#define pcn         cout<<\"Case \"<<tno<<\":\"<<endl;\r\n#define ff(i,n)     for(ll i=0;i<n;i++)\r\n\r\n\r\nint main(){\r\n    ios_base:: sync_with_stdio(false);cin.tie(NULL);cout.tie(NULL);\r\n    string s;\r\n    cin>>s;\r\n    reverse(all(s));\r\n    cout<<s<<endl;\r\n    return 0;\r\n}', 'Accepted', 100);

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
(60, 'other'),
(62, 'Digit Dp'),
(63, 'Demo tag');

-- --------------------------------------------------------

--
-- Table structure for table `testcases`
--

CREATE TABLE `testcases` (
  `ID` int(11) NOT NULL,
  `Input` text DEFAULT NULL,
  `Output` text DEFAULT NULL,
  `ProblemID` int(11) DEFAULT NULL,
  `testCaseNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testcases`
--

INSERT INTO `testcases` (`ID`, `Input`, `Output`, `ProblemID`, `testCaseNo`) VALUES
(29, '../problems/13/input_1.txt', '../problems/13/output_1.txt', 13, 1),
(32, '../problems/2/input_1.txt', '../problems/2/output_1.txt', 2, 1),
(33, '../problems/2/input_2.txt', '../problems/2/output_2.txt', 2, 2),
(34, '../problems/2/input_3.txt', '../problems/2/output_3.txt', 2, 3);

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
  `CurrentRating` int(11) DEFAULT 0,
  `DateJoined` datetime DEFAULT NULL,
  `RatingCategory` varchar(255) DEFAULT 'Novice',
  `DateOfBirth` date DEFAULT NULL,
  `MaxRating` int(11) DEFAULT 0,
  `Institution` varchar(255) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Handle`, `Name`, `Email`, `User_Password`, `Profile_Picture`, `User_Role`, `CurrentRating`, `DateJoined`, `RatingCategory`, `DateOfBirth`, `MaxRating`, `Institution`, `Gender`) VALUES
(1, 'johndoe', 'John Doe', 'john.doe@example.com', 'password123', '/images/johndoe.jpg', 'admin', 0, '2024-01-15 10:30:00', 'Novice', NULL, 0, NULL, NULL),
(2, 'janesmith', 'Jane Smith', 'jane.smith@example.com', 'password456', '/images/janesmith.jpg', 'user', 0, '2023-12-20 08:15:00', 'Novice', NULL, 0, NULL, NULL),
(3, 'bobjones', 'Bob Jones', 'bob.jones@example.com', 'password789', NULL, 'moderator', 0, '2024-03-22 14:45:00', 'Novice', NULL, 0, NULL, NULL),
(4, 'alicebrown', 'Alice Brown', 'alice.brown@example.com', 'passwordabc', '/images/alicebrown.jpg', 'user', 0, '2023-11-10 09:05:00', 'Novice', NULL, 0, NULL, NULL),
(5, 'charlieblack', 'Charlie Black', 'charlie.black@example.com', 'passworddef', NULL, 'user', 0, '2024-02-18 12:50:00', 'Novice', NULL, 0, NULL, NULL),
(6, 'Taju366', 'Kazi Zannatul', 'kazizannatultajrin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', NULL, 'admin', 0, NULL, 'Novice', NULL, 0, NULL, NULL),
(7, 'AfnanRakib', 'Rakib Hasan', 'afnanrakib476@gmail.com', '202cb962ac59075b964b07152d234b70', '../images/uploads/profile_pictures/7.jpg', 'admin', 0, '2024-07-08 20:33:14', 'Novice', '2001-10-14', 0, 'AUST', 'male'),
(9, 'rakib476', 'Afnan Rakib', 'rakib.cse.20210204027@aust.edu', '827ccb0eea8a706c4c34a16891f84e7b', NULL, 'user', 0, '2024-07-12 15:34:54', 'Novice', NULL, 0, NULL, NULL),
(10, 'ditto', 'shahriar rahaman', 'diptobhuiyan1999@gmail.com', 'e807f1fcf82d132f9bb018ca6738a19f', NULL, 'user', 0, '2024-07-14 20:25:58', 'Novice', NULL, 0, NULL, NULL);

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
(10, 1, 'Longest Common Subsequence: Dynamic Programming', 'In this video I discuss the Longest Common Subsequence.', 'https://www.youtube.com/embed/Q0o9sU1r0FY?list=PLauivoElc3gimdmLcIIpafEkzGs4tCQmi', '2024-07-12 13:06:12', 1),
(16, 5, 'GPU bench-marking with image classification | Deep Learning Tutorial 17 (Tensorflow2.0, Python)', 'This video shows performance comparison of using a CPU vs NVIDIA TITAN RTX GPU for deep learning. We are using 60000 small images for classification. These images can be  classified in one of the 10 categories below,', 'https://www.youtube.com/embed/YmDaqXMIoeY?list=PLeo1K3hjS3us_ELKYSj_Fth2tIEkdKXvV', '2024-07-17 05:51:38', 10),
(17, 6, 'PHP Full Course for non-haters 🐘 (2023)', 'PHP tutorial for beginners full course\r\nThis video will give you and introduction PHP in 4 hours. Afterwords I would recommend learning about: Object Oriented Programming, Exception Handling, and PDO.', 'https://www.youtube.com/embed/zZ6vybT1HQs', '2024-07-17 07:42:08', 10),
(18, 10, 'leet code', 'hard kill me please', 'https://www.youtube.com/embed/aHZW7TuY_yo', '2024-07-17 07:54:01', 10);

-- --------------------------------------------------------

--
-- Table structure for table `video_documents`
--

CREATE TABLE `video_documents` (
  `id` int(11) NOT NULL,
  `video_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `video_documents`
--

INSERT INTO `video_documents` (`id`, `video_id`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'ohe bondhu!!', '2024-07-29 07:31:57', '2024-07-29 07:31:57'),
(5, 16, '<p>hello this is my first docs</p>', '2024-07-29 07:24:24', '2024-07-29 07:25:12'),
(6, 2, 'ohe bondhu!!', '2024-07-29 07:32:33', '2024-07-29 07:32:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `video_id` (`video_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ratinggraph`
--
ALTER TABLE `ratinggraph`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ContestID` (`ContestID`);

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
  ADD KEY `RatingID` (`CurrentRating`),
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
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `contests`
--
ALTER TABLE `contests`
  MODIFY `ContestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `ProblemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ratinggraph`
--
ALTER TABLE `ratinggraph`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `SubmissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `TagID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `testcases`
--
ALTER TABLE `testcases`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);

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
  ADD CONSTRAINT `contestproblems_ibfk_2` FOREIGN KEY (`ProblemID`) REFERENCES `problems` (`ProblemID`) ON DELETE CASCADE;

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
-- Constraints for table `problem_tags`
--
ALTER TABLE `problem_tags`
  ADD CONSTRAINT `problem_tags_ibfk_1` FOREIGN KEY (`ProblemID`) REFERENCES `problems` (`ProblemID`) ON DELETE CASCADE,
  ADD CONSTRAINT `problem_tags_ibfk_2` FOREIGN KEY (`TagID`) REFERENCES `tags` (`TagID`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `videos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `questions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`);

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
-- Constraints for table `testcases`
--
ALTER TABLE `testcases`
  ADD CONSTRAINT `testcases_ibfk_1` FOREIGN KEY (`ProblemID`) REFERENCES `problems` (`ProblemID`) ON DELETE CASCADE;

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
