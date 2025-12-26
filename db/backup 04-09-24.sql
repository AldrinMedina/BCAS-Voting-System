-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 02:53 PM
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
(1, 'Admin', '$2y$10$1K5nOPdFk4avDpTTljY9hu5rGuWsP7QIFifSIMBOJqvp.0Eiy07Uy', 'Admin', '', '246626009_764120481653539_1874714275795037679_n-removebg-preview (1).png', '2018-04-02');

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

-- --------------------------------------------------------

--
-- Table structure for table `party`
--

CREATE TABLE `party` (
  `id` int(11) NOT NULL,
  `partylist` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `party`
--

INSERT INTO `party` (`id`, `partylist`) VALUES
(2, 'PADAYON'),
(3, 'SMART');

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
(8, 'President', 1, 1),
(9, 'Vice President', 1, 2),
(10, 'Secretary', 1, 3),
(11, 'Treasurer', 1, 4),
(12, 'Auditor', 1, 5),
(13, 'Peace Officer', 1, 6),
(14, 'PIO', 1, 7),
(15, '1st Year Representative', 1, 8),
(16, '2nd Year Representative', 1, 9),
(17, '3rd Year Representative', 1, 10),
(18, '4th Year Representative', 1, 11);

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
  `photo` varchar(150) NOT NULL,
  `voted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `photo`, `voted`) VALUES
(18, '2024-021', '$2y$10$zYzKhEZrzV0trFlGq8fFU.N97ECWUni.v3YqCPkqTaucuF91NVMW.', 'ASHLEY NICOLE', 'LASHERAS', '', 1),
(21, '2024-091', '$2y$10$LJ8fjdty1vC987L7f34nge7amyhbG1.DlZ9sQWoUH4T4t8MaDxHd2', 'Hans', 'Solis', '', 1),
(22, '2024-993', '$2y$10$.E8i3lcmCP6wtN.YDFy0lOqSkOXZZAc2qxXzITOQKVMFXNyda8zkO', 'Irish', 'Rosita', '', 1),
(24, '20241001', '$2y$10$SI1uEcQa20onzRysxdVHn.XENoXTEtqkBEVsXjhQIFctZ.nKnHLsy', 'Clancy Eayah', 'Baculo', '', 1),
(26, '2024-1002', '$2y$10$tMQDZtGTMfkV71dzNCicAueux.1CCNQowugTtO.gN7x3BoogC4UNi', 'Joshua ', 'Oseña', '', 1),
(27, '2024-1000', '$2y$10$XGBBwNBTB7sTrqdCUyxMSOoeyPe0u4N6NaFh0AaP7ykjMJUlegzDW', 'Hansleigh', 'Peregrina', '', 1),
(28, '2024-054', '$2y$10$WE44A03.kcAKutsrGahR3e85A88iU7TvjC/GfwBTV5k2WHe7CidNK', 'Cejay', 'Sarmiento', '', 1),
(29, '2024_019', '$2y$10$Rphqx88hMRC8LPjHc6W/BuIOmzmt1r.4OH8nqTcfTJ2omhL02/YWG', 'Justine Vincent ', 'Liwanag', '', 1),
(30, '2024-092', '$2y$10$8I/8XAJP1LBx1z65dueaOuZLMebLCFl8ZRM9Ch37ch//W8Bmur.Ou', 'Romel', 'Navarro', '', 1),
(31, '2024-041', '$2y$10$TQDJBIUkxX7NucrgEoQ19eivSVn.8zVwKWE6JJ/tCNnmDouuEx/WW', 'John Kenneth', 'De Jesus', '', 1),
(32, '2024-058', '$2y$10$CVJ5BHrklvDKcSFBXFGu8.y3.1gx2AXjAadeIgoi6rxzEqvadlLRq', 'jhon aaron ', 'panti', '', 1),
(33, '2024-038', '$2y$10$jZCAYTFWMfbGnm..fMzy1uRVtikwHiqpnfJ4tD3QFhiZ2XOLGqNF2', 'NINO JUSTIN', 'Mendoza', '', 1),
(34, '2024-020', '$2y$10$jS7KQX1Z2Gi3WNqxHkka8O75LrtVIvnBLmaQCjB2qOsAjk3Yv7SXu', 'Francesca Venice ', 'Orense', '', 1),
(35, '2024 994', '$2y$10$QAb393Hdk8Aighqvt35o7ewSByqdEnka42LsxyzDVdsyE9vMdIV.e', 'Yohveneil ', 'Zaplan', '', 1),
(36, '2024-047', '$2y$10$C7Q1ti5FED3ZDywJw/Zea.Alm3HH2/BylX/02rPjo7il3z66jVury', 'Paul Deniel ', 'Postrero', '', 1),
(38, '2024-035', '$2y$10$mxiUk5OJGXKtbXwIlTO/wOwnXhgKq6LdTPKCmiY5umFW9/ai8njkG', 'Mark Dharen Errl', 'Mariano', '', 1),
(39, '2024082', '$2y$10$J3OHyIxBWIxBzFfBrIp0euI4g17gvTsMNfkJsVgr1kheJzIIYGXAO', 'Rovic Javie B.', 'Javen', '', 1),
(40, '2024-046', '$2y$10$bhM2wtmpKgbadluj3gSEt.BxDZgC63rHpz/bEzIH5QlGIt6UZUV9W', 'James Louel', 'Bautista', '', 1),
(41, '20243995', '$2y$10$QrZdN/mdggXGN9UtFIPAoeOXBiQZiYi2okt2ajzmx6e/GTiZ87zAe', 'Miko', 'Silva', '', 1),
(43, '2024-033', '$2y$10$bscITrzgKn1zcwP/NZmymeYGREe8eA0R74een1X2xKK9EfEE5Pgfq', 'Mikey', 'Contreras', '', 1),
(44, '2024-032', '$2y$10$vQ4fhAf7E42W/esUTInQ4uKz97JzqavDzjZN70PypGYdSQVekeBvG', 'Janiel Ashley', 'Jallores', '', 1),
(45, '2024-076', '$2y$10$o2VBWyKED3.4prPNbZshce4PoOlEHmUMJ9.JhQIXWNAC2jaC..IQe', 'Lendzy Joreine', 'Escalona', '', 1),
(47, '2022-028', '$2y$10$XRE1Q4uZTeJ68.PPD4mITe.e.nsevS2iXFwWXGD4nDn8M/8uAuYUe', 'Joy', 'Espina', '', 1),
(48, '2024-049', '$2y$10$FsbaqBfavVY.jAh6saeOI.KF0PbriYw7D1SgzvP569G.SmMSPk.76', 'Karl Noen', 'Inciong', '', 1),
(49, '2024-018', '$2y$10$Mt4NNIad6ITUx.7c9/SHFe36qU/k2UbTZaBgnL32VbQDBzcYsJ/um', 'Tyron', 'Punzalan', '', 1),
(50, '2024-075', '$2y$10$dCVM2I4.oybHT3pgEyILruFN09domeYGpwX3C2q0w96lq1QigyJDq', 'John Arron', 'Binay', '', 1),
(51, '2024-040', '$2y$10$FtMC4e57mOVFJjIHWPpJmuSuaANcrZ.SC5jOoTGabkRy.Bu2Hl7Gy', 'Kien Daryl', 'Japlos', '', 1),
(53, '2024-057', '$2y$10$B9Rsr0xxymZTvmX0tFnK/Oem4JGce9OeJY2t0YJlvwNo8XpuYDidG', 'John Paulo', 'Navela', '', 1),
(54, '2024-036', '$2y$10$xU7uCOktFsWl9RZa.inKFOyy3nPPRmHtOedaQafnRrgD.wMyqKLua', 'Jordane Adrielle', 'Taguinod', '', 1),
(55, '2024-056', '$2y$10$AZtuoOBmoBk.4Yb45tDxYeVI9czB9wWPIhtSiIx13rXJZvDKD4nuS', 'REYNIEL IVAN', 'MOIRGADO', '', 1),
(58, '2024996', '$2y$10$NCpUClpi4r.y/pC/t3zd7.BFP8qNXj2JzGm4alxKNRfpcHzja87HS', 'Wexitter', 'Arcilla', '', 1),
(59, '2024-061', '$2y$10$hpCHsXxGjQzAcpAiLV9b4.4k0pKOUqeY/TQuczpUk8NuEI37wYRSy', 'Carl Justin', 'Lonzame', '', 1),
(61, '2024-079', '$2y$10$/DyTcFD/0vUlR4hD271bP.wHDR9zx/gdU5NGWcLQyfyQn6oGdbgFq', 'jade lorraine', 'umali', '', 1),
(62, '2024-1006', '$2y$10$/QNJ.I1psLuyhEOk4TzZfuZnYYTT0veBBtOvYmB3z9mjPO1bwQM6K', 'Aldrine', 'Gabriel', '', 1),
(63, '2024-991', '$2y$10$5m3OPerSnHHQE22jBGThUe6KYR1likqh9tqI5QD88C1jWjt7X.evi', 'Erick Vienai', 'Agustin', '', 1),
(67, '2024-087', '$2y$10$7X2r1ZCkLYGAx.4rC3I1B.awVuzEnwAL/1B.apVIq.vhJfiwVITzS', 'John Marc', 'Adoc', '', 1),
(68, '2024009', '$2y$10$Zmq6AXQVs7/bu/6/fJ2u7uYAQJ4Hmw/uHg3ckCXp8QxWxmjMARahW', 'JOHN PAUL', 'NECOR', '', 1),
(69, '2024-992', '$2y$10$h5chjEmAe6iha5DSSg9x8u6HqxFvspXSHS4g8NV0YO6Z32j4UR9PC', 'Angelo', 'Leyesa', '', 1),
(70, '20249976', '$2y$10$5HibW6Glrevb51C6C8MEZuF8BpMXwzXlTOypFHKY04Hhb.mvKT6dO', 'James mathew', 'Landicho', '', 1),
(71, '2024-042', '$2y$10$.JOBUaaVXUYJCAId7K7sge.Aw5Rcp2bFt.zerjSLIa1432jHU1RCO', 'Neil Rion', 'Dela Cruz', '', 1),
(72, '2024-085', '$2y$10$NEpeTJeo6NdHb2L/C9phD.UerRUP5VbxzGhixEqOUbEhBfZi5hnA2', 'PATRICK', 'SOLIS', '', 1),
(73, '2024-1003', '$2y$10$pJrMxN1Nu78P1UaHRLnt/e/41bK8x6O3dQBlCkEkzUkSmGjZJSlli', 'KIRBY JOSEF', 'ATIENZA', '', 1),
(74, '2024-1004', '$2y$10$LJf3Ko/6G7ZUlJJQ/3lmm.mt3Zdkk/.178i2QOcjOAMbN13V.MSta', 'Rodelyn', 'Almonte', '', 1),
(76, '2024-1005', '$2y$10$iGRe0FfWLWo0S6x49BlBzu0wNGifSogg1iE7Z9VsHrS.nYc/yZrgW', 'Nikko', 'Sarmiento', '', 1),
(77, '2024060', '$2y$10$/iGIucJCgsvjBOqt3c65GerAHlMRufxrRMnHwfflGlX7lH902/Wfy', 'loren', 'perez', '', 1),
(80, '2022-018', '$2y$10$0MqqTfSLBzznc21093MoX.ZfiTNHatI3iOYtOhYjDQ6IOIilwk4am', 'Aldrin', 'Medina', '', 0),
(81, '2022-001', '2022-001', 'Franz', 'Ataguan', '', 0),
(82, '2022-005', '2022-005', 'Franz', 'Ataguan', '', 1);

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
(711, 58, 20, 8),
(712, 58, 21, 9),
(713, 58, 22, 10),
(714, 58, 23, 11),
(715, 58, 24, 12),
(716, 58, 25, 13),
(717, 58, 26, 14),
(718, 58, 27, 15),
(719, 58, 28, 16),
(720, 58, 29, 17),
(721, 58, 30, 18),
(722, 51, 20, 8),
(723, 51, 21, 9),
(724, 51, 22, 10),
(725, 51, 23, 11),
(726, 51, 24, 12),
(727, 51, 25, 13),
(728, 51, 26, 14),
(729, 51, 27, 15),
(730, 51, 28, 16),
(731, 51, 29, 17),
(732, 51, 30, 18),
(733, 73, 20, 8),
(734, 73, 21, 9),
(735, 73, 22, 10),
(736, 73, 23, 11),
(737, 73, 24, 12),
(738, 73, 25, 13),
(739, 73, 26, 14),
(740, 73, 27, 15),
(741, 73, 28, 16),
(742, 73, 29, 17),
(743, 73, 30, 18),
(744, 49, 20, 8),
(745, 49, 21, 9),
(746, 49, 22, 10),
(747, 49, 23, 11),
(748, 49, 24, 12),
(749, 49, 25, 13),
(750, 49, 26, 14),
(751, 49, 27, 15),
(752, 49, 28, 16),
(753, 49, 29, 17),
(754, 49, 30, 18),
(755, 22, 20, 8),
(756, 22, 21, 9),
(757, 22, 22, 10),
(758, 22, 23, 11),
(759, 22, 24, 12),
(760, 22, 25, 13),
(761, 22, 26, 14),
(762, 22, 27, 15),
(763, 22, 28, 16),
(764, 22, 29, 17),
(765, 22, 30, 18),
(766, 39, 20, 8),
(767, 39, 21, 9),
(768, 39, 22, 10),
(769, 39, 23, 11),
(770, 39, 24, 12),
(771, 39, 25, 13),
(772, 39, 26, 14),
(773, 39, 27, 15),
(774, 39, 28, 16),
(775, 39, 29, 17),
(776, 39, 30, 18),
(777, 71, 20, 8),
(778, 71, 21, 9),
(779, 71, 22, 10),
(780, 71, 23, 11),
(781, 71, 24, 12),
(782, 71, 25, 13),
(783, 71, 26, 14),
(784, 71, 27, 15),
(785, 71, 28, 16),
(786, 71, 29, 17),
(787, 71, 30, 18),
(788, 26, 20, 8),
(789, 26, 21, 9),
(790, 26, 22, 10),
(791, 26, 23, 11),
(792, 26, 24, 12),
(793, 26, 25, 13),
(794, 26, 26, 14),
(795, 26, 27, 15),
(796, 26, 28, 16),
(797, 26, 29, 17),
(798, 26, 30, 18),
(799, 35, 20, 8),
(800, 35, 21, 9),
(801, 35, 22, 10),
(802, 35, 23, 11),
(803, 35, 24, 12),
(804, 35, 25, 13),
(805, 35, 26, 14),
(806, 35, 27, 15),
(807, 35, 28, 16),
(808, 35, 29, 17),
(809, 35, 30, 18),
(810, 77, 20, 8),
(811, 77, 21, 9),
(812, 77, 22, 10),
(813, 77, 23, 11),
(814, 77, 24, 12),
(815, 77, 25, 13),
(816, 77, 26, 14),
(817, 77, 27, 15),
(818, 77, 28, 16),
(819, 77, 29, 17),
(820, 77, 30, 18),
(821, 50, 20, 8),
(822, 50, 21, 9),
(823, 50, 22, 10),
(824, 38, 20, 8),
(825, 50, 23, 11),
(826, 38, 21, 9),
(827, 50, 24, 12),
(828, 38, 22, 10),
(829, 50, 25, 13),
(830, 38, 23, 11),
(831, 50, 26, 14),
(832, 38, 24, 12),
(833, 50, 27, 15),
(834, 38, 25, 13),
(835, 50, 28, 16),
(836, 38, 26, 14),
(837, 50, 29, 17),
(838, 38, 27, 15),
(839, 50, 30, 18),
(840, 38, 28, 16),
(841, 38, 29, 17),
(842, 38, 30, 18),
(843, 27, 20, 8),
(844, 27, 21, 9),
(845, 27, 22, 10),
(846, 27, 23, 11),
(847, 27, 24, 12),
(848, 27, 25, 13),
(849, 27, 26, 14),
(850, 27, 27, 15),
(851, 27, 28, 16),
(852, 27, 29, 17),
(853, 27, 30, 18),
(854, 45, 20, 8),
(855, 45, 21, 9),
(856, 45, 22, 10),
(857, 45, 23, 11),
(858, 45, 24, 12),
(859, 45, 25, 13),
(860, 45, 26, 14),
(861, 45, 27, 15),
(862, 45, 28, 16),
(863, 45, 29, 17),
(864, 45, 30, 18),
(865, 53, 20, 8),
(866, 53, 21, 9),
(867, 53, 22, 10),
(868, 53, 23, 11),
(869, 53, 24, 12),
(870, 70, 20, 8),
(871, 53, 25, 13),
(872, 70, 21, 9),
(873, 53, 26, 14),
(874, 70, 22, 10),
(875, 53, 27, 15),
(876, 70, 23, 11),
(877, 53, 28, 16),
(878, 70, 24, 12),
(879, 53, 29, 17),
(880, 70, 25, 13),
(881, 53, 30, 18),
(882, 70, 26, 14),
(883, 70, 27, 15),
(884, 59, 20, 8),
(885, 70, 28, 16),
(886, 59, 21, 9),
(887, 70, 29, 17),
(888, 59, 22, 10),
(889, 59, 23, 11),
(890, 70, 30, 18),
(891, 59, 24, 12),
(892, 59, 25, 13),
(893, 59, 26, 14),
(894, 59, 27, 15),
(895, 59, 28, 16),
(896, 59, 29, 17),
(897, 59, 30, 18),
(898, 48, 20, 8),
(899, 48, 21, 9),
(900, 48, 22, 10),
(901, 48, 23, 11),
(902, 48, 24, 12),
(903, 48, 25, 13),
(904, 48, 26, 14),
(905, 48, 27, 15),
(906, 48, 28, 16),
(907, 48, 29, 17),
(908, 48, 30, 18),
(909, 34, 20, 8),
(910, 34, 21, 9),
(911, 34, 22, 10),
(912, 34, 23, 11),
(913, 34, 24, 12),
(914, 43, 20, 8),
(915, 34, 25, 13),
(916, 43, 21, 9),
(917, 34, 26, 14),
(918, 43, 22, 10),
(919, 34, 27, 15),
(920, 43, 23, 11),
(921, 34, 28, 16),
(922, 43, 24, 12),
(923, 34, 29, 17),
(924, 43, 25, 13),
(925, 34, 30, 18),
(926, 43, 26, 14),
(927, 43, 27, 15),
(928, 54, 20, 8),
(929, 43, 28, 16),
(930, 54, 21, 9),
(931, 43, 29, 17),
(932, 54, 22, 10),
(933, 43, 30, 18),
(934, 54, 23, 11),
(935, 54, 24, 12),
(936, 54, 25, 13),
(937, 54, 26, 14),
(938, 54, 27, 15),
(939, 54, 28, 16),
(940, 54, 29, 17),
(941, 32, 20, 8),
(942, 54, 30, 18),
(943, 32, 21, 9),
(944, 32, 22, 10),
(945, 32, 23, 11),
(946, 24, 20, 8),
(947, 32, 24, 12),
(948, 24, 21, 9),
(949, 32, 25, 13),
(950, 24, 22, 10),
(951, 32, 26, 14),
(952, 24, 23, 11),
(953, 32, 27, 15),
(954, 24, 24, 12),
(955, 32, 28, 16),
(956, 24, 25, 13),
(957, 32, 29, 17),
(958, 24, 26, 14),
(959, 32, 30, 18),
(960, 24, 27, 15),
(961, 24, 28, 16),
(962, 24, 29, 17),
(963, 24, 30, 18),
(964, 31, 20, 8),
(965, 31, 21, 9),
(966, 31, 22, 10),
(967, 31, 23, 11),
(968, 31, 24, 12),
(969, 31, 25, 13),
(970, 31, 26, 14),
(971, 31, 27, 15),
(972, 31, 28, 16),
(973, 31, 29, 17),
(974, 31, 30, 18),
(975, 47, 20, 8),
(976, 47, 21, 9),
(977, 47, 22, 10),
(978, 47, 23, 11),
(979, 47, 24, 12),
(980, 47, 25, 13),
(981, 47, 26, 14),
(982, 47, 27, 15),
(983, 47, 28, 16),
(984, 47, 29, 17),
(985, 29, 20, 8),
(986, 47, 30, 18),
(987, 29, 21, 9),
(988, 29, 22, 10),
(989, 29, 23, 11),
(990, 29, 24, 12),
(991, 29, 25, 13),
(992, 29, 26, 14),
(993, 29, 27, 15),
(994, 29, 28, 16),
(995, 29, 29, 17),
(996, 29, 30, 18),
(997, 63, 20, 8),
(998, 63, 21, 9),
(999, 63, 22, 10),
(1000, 63, 23, 11),
(1001, 63, 24, 12),
(1002, 63, 25, 13),
(1003, 63, 26, 14),
(1004, 63, 27, 15),
(1005, 63, 28, 16),
(1006, 63, 29, 17),
(1007, 63, 30, 18),
(1008, 21, 20, 8),
(1009, 21, 21, 9),
(1010, 21, 22, 10),
(1011, 21, 23, 11),
(1012, 21, 24, 12),
(1013, 21, 25, 13),
(1014, 21, 26, 14),
(1015, 21, 27, 15),
(1016, 21, 28, 16),
(1017, 21, 29, 17),
(1018, 21, 30, 18),
(1019, 28, 20, 8),
(1020, 28, 21, 9),
(1021, 28, 22, 10),
(1022, 28, 23, 11),
(1023, 28, 24, 12),
(1024, 28, 25, 13),
(1025, 28, 26, 14),
(1026, 28, 27, 15),
(1027, 28, 28, 16),
(1028, 28, 29, 17),
(1029, 28, 30, 18),
(1030, 44, 20, 8),
(1031, 44, 21, 9),
(1032, 44, 22, 10),
(1033, 44, 23, 11),
(1034, 44, 24, 12),
(1035, 44, 25, 13),
(1036, 44, 26, 14),
(1037, 44, 27, 15),
(1038, 44, 28, 16),
(1039, 44, 29, 17),
(1040, 44, 30, 18),
(1041, 41, 20, 8),
(1042, 41, 21, 9),
(1043, 41, 22, 10),
(1044, 41, 23, 11),
(1045, 41, 24, 12),
(1046, 41, 25, 13),
(1047, 41, 26, 14),
(1048, 41, 27, 15),
(1049, 41, 28, 16),
(1050, 41, 29, 17),
(1051, 41, 30, 18),
(1052, 33, 20, 8),
(1053, 33, 21, 9),
(1054, 33, 22, 10),
(1055, 33, 23, 11),
(1056, 33, 24, 12),
(1057, 33, 25, 13),
(1058, 33, 26, 14),
(1059, 33, 27, 15),
(1060, 33, 28, 16),
(1061, 55, 20, 8),
(1062, 33, 29, 17),
(1063, 55, 21, 9),
(1064, 33, 30, 18),
(1065, 55, 22, 10),
(1066, 55, 23, 11),
(1067, 55, 24, 12),
(1068, 55, 25, 13),
(1069, 55, 26, 14),
(1070, 55, 27, 15),
(1071, 55, 28, 16),
(1072, 55, 29, 17),
(1073, 55, 30, 18),
(1074, 61, 20, 8),
(1075, 61, 21, 9),
(1076, 61, 22, 10),
(1077, 61, 23, 11),
(1078, 61, 24, 12),
(1079, 61, 25, 13),
(1080, 61, 26, 14),
(1081, 61, 27, 15),
(1082, 61, 28, 16),
(1083, 61, 29, 17),
(1084, 61, 30, 18),
(1085, 68, 20, 8),
(1086, 68, 21, 9),
(1087, 68, 22, 10),
(1088, 68, 23, 11),
(1089, 68, 24, 12),
(1090, 68, 25, 13),
(1091, 68, 26, 14),
(1092, 68, 27, 15),
(1093, 68, 28, 16),
(1094, 68, 29, 17),
(1095, 68, 30, 18),
(1096, 30, 20, 8),
(1097, 30, 21, 9),
(1098, 69, 20, 8),
(1099, 30, 22, 10),
(1100, 69, 21, 9),
(1101, 30, 23, 11),
(1102, 69, 22, 10),
(1103, 30, 24, 12),
(1104, 69, 23, 11),
(1105, 30, 25, 13),
(1106, 69, 24, 12),
(1107, 30, 26, 14),
(1108, 69, 25, 13),
(1109, 30, 27, 15),
(1110, 69, 26, 14),
(1111, 30, 28, 16),
(1112, 69, 27, 15),
(1113, 30, 29, 17),
(1114, 69, 28, 16),
(1115, 30, 30, 18),
(1116, 69, 29, 17),
(1117, 69, 30, 18),
(1118, 72, 20, 8),
(1119, 72, 21, 9),
(1120, 72, 22, 10),
(1121, 72, 23, 11),
(1122, 72, 24, 12),
(1123, 72, 25, 13),
(1124, 72, 26, 14),
(1125, 72, 27, 15),
(1126, 72, 28, 16),
(1127, 72, 29, 17),
(1128, 72, 30, 18),
(1129, 76, 20, 8),
(1130, 76, 21, 9),
(1131, 76, 22, 10),
(1132, 76, 23, 11),
(1133, 76, 24, 12),
(1134, 76, 25, 13),
(1135, 76, 26, 14),
(1136, 76, 27, 15),
(1137, 76, 28, 16),
(1138, 76, 29, 17),
(1139, 76, 30, 18),
(1140, 18, 20, 8),
(1141, 18, 21, 9),
(1142, 18, 22, 10),
(1143, 18, 23, 11),
(1144, 18, 24, 12),
(1145, 18, 25, 13),
(1146, 18, 26, 14),
(1147, 18, 27, 15),
(1148, 18, 28, 16),
(1149, 18, 29, 17),
(1150, 18, 30, 18),
(1151, 36, 20, 8),
(1152, 36, 21, 9),
(1153, 36, 22, 10),
(1154, 36, 23, 11),
(1155, 36, 24, 12),
(1156, 36, 25, 13),
(1157, 36, 26, 14),
(1158, 36, 27, 15),
(1159, 36, 28, 16),
(1160, 36, 29, 17),
(1161, 36, 30, 18),
(1162, 74, 20, 8),
(1163, 74, 21, 9),
(1164, 74, 22, 10),
(1165, 74, 23, 11),
(1166, 74, 24, 12),
(1167, 74, 25, 13),
(1168, 74, 26, 14),
(1169, 74, 27, 15),
(1170, 74, 28, 16),
(1171, 74, 29, 17),
(1172, 74, 30, 18),
(1173, 62, 20, 8),
(1174, 62, 21, 9),
(1175, 62, 22, 10),
(1176, 62, 23, 11),
(1177, 62, 24, 12),
(1178, 62, 25, 13),
(1179, 62, 26, 14),
(1180, 62, 27, 15),
(1181, 62, 28, 16),
(1182, 62, 29, 17),
(1183, 62, 30, 18),
(1184, 67, 20, 8),
(1185, 67, 21, 9),
(1186, 67, 22, 10),
(1187, 67, 23, 11),
(1188, 67, 24, 12),
(1189, 67, 25, 13),
(1190, 67, 26, 14),
(1191, 67, 27, 15),
(1192, 67, 28, 16),
(1193, 67, 29, 17),
(1194, 67, 30, 18),
(1195, 40, 20, 8),
(1196, 40, 21, 9),
(1197, 40, 22, 10),
(1198, 40, 23, 11),
(1199, 40, 24, 12),
(1200, 40, 25, 13),
(1201, 40, 26, 14),
(1202, 40, 27, 15),
(1203, 40, 28, 16),
(1204, 40, 29, 17),
(1205, 40, 30, 18),
(1217, 82, 31, 8),
(1218, 82, 32, 9),
(1219, 82, 33, 10),
(1220, 82, 34, 11),
(1221, 82, 35, 12),
(1222, 82, 36, 13),
(1223, 82, 37, 14),
(1224, 82, 38, 15),
(1225, 82, 39, 16),
(1226, 82, 40, 17),
(1227, 82, 41, 18);

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
-- Indexes for table `party`
--
ALTER TABLE `party`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1228;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
