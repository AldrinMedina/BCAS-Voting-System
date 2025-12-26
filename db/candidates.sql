-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 02:56 PM
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
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `partylist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `position_id`, `firstname`, `lastname`, `photo`, `partylist_id`) VALUES
(20, 8, 'Yvan', 'Kalalo', '246626009_764120481653539_1874714275795037679_n-removebg-preview (1).png', 2),
(21, 9, 'Phrynz ', 'Villanueva', '', 2),
(22, 10, 'Klyde Ashley ', 'Hernandez', '', 2),
(23, 11, 'Aldrin', 'Medina', '', 2),
(24, 12, 'Aira Lei', 'Bio', '', 2),
(25, 13, 'Angelo', 'Hain', '', 2),
(26, 14, 'Ezekiel', 'Pingol', '', 2),
(27, 15, 'Regine ', 'Tiburio', '', 2),
(28, 16, 'May Ann', 'Corona', '', 2),
(29, 17, 'Isaih', 'Jordan', '', 2),
(30, 18, 'Hannah Lyka', 'Alop', '', 2),
(31, 8, 'Zaina', 'Sutton', '', 3),
(32, 9, 'Ifan', 'Buchanan', '', 3),
(33, 10, 'Janice ', 'Jacobs', '', 3),
(34, 11, 'Ammar', 'Massey', '', 3),
(35, 12, 'Aidan', 'Estes', '', 3),
(36, 13, 'Luna', 'Rios', '', 3),
(37, 14, 'Isabella', 'Benson', '', 3),
(38, 15, 'Marina', 'Schultz', '', 3),
(39, 16, 'Lillie', 'King', '', 3),
(40, 17, 'Tammy', 'Mayo', '', 3),
(41, 18, 'Franz', 'Ataguan', '', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidates`
--
ALTER TABLE `candidates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
