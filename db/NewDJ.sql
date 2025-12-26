-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 02, 2024 at 11:19 AM
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
-- Database: `votesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `created_on` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `photo`, `created_on`) VALUES
(1, 'Admin', 'Alpha', 'Franz', 'Ataguan', '246626009_764120481653539_1874714275795037679_n-removebg-preview (1).png', '2018-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `platform` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `firstname`, `lastname`, `photo`, `platform`) VALUES
(21, 11, 'Yvan', 'Kalalo', 'logo.png', 'PADAYON'),
(23, 12, 'Phrynz', 'Villanueva', '', 'PADAYON'),
(24, 13, 'Klyde Ashley', 'Hernandez', '', 'PADAYON'),
(25, 14, 'Aldrin ', 'Medina', '', 'PADAYON'),
(26, 15, 'Aira Lei', 'Bio', '', 'PADAYON'),
(27, 16, 'Angelo', 'Hain', '', 'PADAYON'),
(28, 17, 'Ezekiel', 'Pingol', '', 'PADAYON'),
(29, 19, 'May Ann', 'Corona', '', 'PADAYON'),
(30, 20, 'Isaih', 'Jordan', '', 'PADAYON'),
(31, 21, 'Hannah Lyka', 'Alop', '', 'PADAYON'),
(32, 11, 'Aamina', 'Hunter', '', 'SMART'),
(33, 12, 'Dhruv', 'Krueger', '', 'SMART'),
(34, 13, 'Lottie', 'Carlson', '', 'SMART'),
(35, 14, 'Blake', 'Oryan', '', 'SMART'),
(36, 15, 'Marwa', 'Higgins', '', 'SMART'),
(37, 16, 'Leo', 'Macdonald', '', 'SMART'),
(38, 17, 'Abdul', 'Bird', '', 'SMART'),
(39, 18, 'Mariyah', 'Morales', '', 'SMART'),
(40, 19, 'Maisha', 'Neal', '', 'SMART'),
(41, 20, 'Joe', 'Larson', '', 'SMART'),
(42, 21, 'Juan', 'Juan', '', 'SMART');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `Id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`Id`, `description`) VALUES
(1, 'HUMSS'),
(2, 'STEM'),
(3, 'BSIT\r\n'),
(4, 'BSED'),
(5, 'BSBA\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `max_vote` int(11) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `description`, `max_vote`, `priority`) VALUES
(11, 'President', 1, 1),
(12, 'Vice President', 1, 2),
(13, 'Secretary', 1, 3),
(14, 'Treasurer', 1, 4),
(15, 'Auditor', 1, 5),
(16, 'Peace Officer', 1, 6),
(17, 'PIO', 1, 7),
(18, '1st Year Representative', 1, 8),
(19, '2nd Year Representative', 1, 9),
(20, '3rd Year Representative', 1, 10),
(21, '4th Year Representative', 1, 11);

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

CREATE TABLE `voters` (
  `id` int(11) NOT NULL,
  `voters_id` varchar(15) NOT NULL,
  `password` varchar(60) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `year` text NOT NULL,
  `course` text NOT NULL,
  `voted` tinyint(1) NOT NULL,
  `photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `year`, `course`, `voted`, `photo`) VALUES
(32, '33', '$2y$10$J9GKkdY4boJGIgqzQ370D.obKxDEOF2UJdae9aDDH.UqPH0BCoW2O', 'Aldrin', 'Medina', '9', '3', 0, ''),
(33, '34', 'Potato', 'Alpha', 'Jordan', '8', '3', 0, ''),
(34, '35', 'Potato', 'Beta', 'Jordan', '9', '3', 0, ''),
(35, '36', 'Potato', 'Charlie', 'Jordan', '8', '3', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `voters_id` int(11) NOT NULL,
  `candidate_id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `voters_id`, `candidate_id`, `position_id`) VALUES
(646, 34, 21, 11),
(647, 34, 23, 12),
(648, 35, 32, 11),
(649, 35, 23, 12);

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `Id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`Id`, `description`) VALUES
(1, 'Grade-7\r\n'),
(2, 'Grade-8\r\n'),
(3, 'Grade-9\r\n'),
(4, 'Grade-10'),
(5, 'Grade-11\r\n'),
(6, 'Grade-12'),
(7, '1st-Year College\r\n'),
(8, '2nd-Year College'),
(9, '3rd-Year College\r\n'),
(10, '4th-Year College\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `voters`
--
ALTER TABLE `voters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=650;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
