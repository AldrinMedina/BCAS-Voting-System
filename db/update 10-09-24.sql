-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 03:26 PM
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
(1, 'Admin', '$2y$10$6ORaEOo3l8wc.eBQcYbBS.6tmBjKLPmQk5jt0VUBHDFuLQs48dQK6', 'BCAS', 'Admin', '246626009_764120481653539_1874714275795037679_n-removebg-preview (1).png', '2018-04-02');

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
(20, 8, 'Yvan', 'Kalalo', '24623d7a-5bd1-4751-b303-e9e610cc8977.jfif', 2),
(21, 9, 'Phrynz ', 'Villanueva', '1df87d97-a1dc-4c36-8314-6aec60de117e.jfif', 2),
(22, 10, 'Klyde Ashley ', 'Hernandez', '277fa8b4-efb4-4e7b-be7f-23245cdbee5d.jfif', 2),
(23, 11, 'Aldrin', 'Medina', '51eec330-275e-4c28-a917-99edeb4f39a5.jfif', 2),
(24, 12, 'Aira Lei', 'Bio', 'f54aa96b-9552-45b4-9f3e-2963109d0597.jfif', 2),
(25, 13, 'Angelo', 'Hain', 'dba63431-4aff-4894-9369-854aaab477f0.jfif', 2),
(26, 14, 'Ezekiela', 'Pingol', '938c8d44-e9da-43d3-b950-17e732417474.jfif', 2),
(27, 15, 'Regine ', 'Tiburio', 'fd8ccd63-0b93-44ee-af35-113974dedff1.jfif', 2),
(28, 16, 'May Ann', 'Corona', 'b2af03f3-657a-4f7b-8c74-64a2c0a47511.jfif', 2),
(29, 17, 'Isaih', 'Jordan', 'IMG_20221205_144605_475.jpg', 2),
(30, 18, 'Hannah Lyka', 'Alop', 'cc817fc9-a5b9-4784-8b11-52638bbad81e.jfif', 2),
(53, 8, 'Loren', 'Sayas', '', 3),
(54, 9, 'Marco', 'Arriola', '', 3),
(55, 10, 'Earl', 'De Guzman', '', 3),
(56, 11, 'Shaina', 'Borres', '', 3),
(57, 12, 'Stefhanie', 'Malujie', '', 3),
(58, 13, 'Lance', 'De Villa', '', 3),
(59, 14, 'Allen', 'Carandang', '', 3),
(60, 17, 'Roxanne', 'Recio', '', 3),
(61, 16, 'Niel Brian', 'Restum', '', 3);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `description`) VALUES
(2, 'BSA'),
(3, 'BSIT\r\n'),
(4, 'BSED/BEED'),
(5, 'BSBA\r\n');

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
(3, 'FORCE');

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
-- Table structure for table `sad`
--

CREATE TABLE `sad` (
  `id` int(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `created_on` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sad`
--

INSERT INTO `sad` (`id`, `username`, `password`, `firstname`, `lastname`, `created_on`) VALUES
(5, 'superadmin', '$2y$10$PwKnskCETIUiv27wgiH8KO2wOHsl5iQ5eLEEzBpLajrEp3l16C3iy', 'Realm', 'Expansion', '2024-09-08');

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
  `year` int(255) NOT NULL,
  `course` int(11) NOT NULL,
  `voted` tinyint(1) NOT NULL,
  `photo` varchar(150) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `year`, `course`, `voted`, `photo`, `status`) VALUES
(1, '2024-008', '', 'LLOYD MENDOZA', 'PARAYNO', 7, 2, 0, '', 1),
(2, '2024-064', '', ' QUEENETH ZARASPE', 'BATHAN', 7, 2, 0, '', 1),
(3, '2024-015', '', ' JASMINE D', 'CARPIO', 7, 2, 0, '', 1),
(4, '2024-007', '', ' JESSICA ALBARICO', 'DURAN', 7, 2, 0, '', 1),
(5, '2024-005', '', 'ALYSSA MYKA METRILLO', 'EJE', 7, 2, 0, '', 1),
(6, '2024-006', '', 'JAMAICA OSEÑA', 'INCIONG', 7, 2, 0, '', 1),
(7, '2024-013', '', 'ALZEA ORUA', 'KATIMBANG', 7, 2, 0, '', 1),
(8, '2024-014', '', 'ANGELICA RIVERO', 'MANALO', 7, 2, 0, '', 1),
(9, '2024-012', '', 'ELOISA SISCAR', 'MANALO', 7, 2, 0, '', 1),
(10, '2024-028', '', ' LOUIS OROZCO', 'PEJI', 7, 4, 0, '', 1),
(11, '2024-048', '', ' RAYMARK LATAGAN', 'NUEVO', 7, 4, 0, '', 1),
(12, '2024-080', '', ' JEBOY PUNZALAN', 'UMALI', 7, 4, 0, '', 1),
(13, '2024-088', '', ' SHAINE ADIELINE DE TORRES', 'LATAG', 7, 4, 0, '', 1),
(14, '2024-045', '', ' JORGIE POYAWAN', 'CLEOFE', 7, 4, 0, '', 1),
(15, '2024-062', '', ' ROMEL OROLFO', 'LUYA', 7, 4, 0, '', 1),
(16, '2024-025', '', ' REEZE AALA', 'ALCANTARA', 7, 4, 0, '', 1),
(17, '2024-090', '', ' AILENE MAYANO', 'ALE', 7, 4, 0, '', 1),
(18, '2024-027', '', ' JESSA LUCAÑAS', 'CALINGASAN', 7, 4, 0, '', 1),
(19, '2024-026', '', ' ANGELICA FAITH CABACES', 'MALALUAN', 7, 4, 0, '', 1),
(20, '2024-1001', '', ' ANGEL JOY', 'NAPADAWAN', 7, 4, 0, '', 1),
(21, '2024-043', '', ' GLEZELLE ANN DE VILLA', 'SOLIS', 7, 4, 0, '', 1),
(22, '2024-065', '', ' PAOLO SUAREZ ', 'ALINA', 7, 5, 0, '', 1),
(23, '2024-067', '', ' ACE LAWRENCE BERMILLO ', 'AQUINO', 7, 5, 0, '', 1),
(24, '2024-095', '', ' JASPER ARCEL MALALUAN ', 'BINAY', 7, 5, 0, '', 1),
(25, '2024-066', '', ' JAN CHARISTIAN OROZO ', 'CALINISAN', 7, 5, 0, '', 1),
(26, '2024-022', '', ' JOHN LESTER REYES ', 'DE CHAVEZ', 7, 5, 0, '', 1),
(27, '2024-003', '', ' MARK JULIUS MAQUINTO  ', 'DE LA VEGA', 7, 5, 0, '', 1),
(28, '2024-084', '', 'JAMES CEDRICK AGUILA  ', 'LIAC', 7, 5, 0, '', 1),
(29, '2024-055', '', ' SIMON KYLE GUEVARRA', 'OROSCO', 7, 5, 0, '', 1),
(30, '2024-071', '', ' PAUL DEXTER BEKING ', 'SILVA', 7, 5, 0, '', 1),
(31, '2024-093', '', ' NIKKI CALIG-ONAN ', 'AGUADO', 7, 5, 0, '', 1),
(32, '2024-004', '', ' ELISABETH ZARA  ', 'ALBA', 7, 5, 0, '', 1),
(33, '2024-072', '', ' MARIA MIKAYLA MONTEALTO ', 'ALBOTRA', 7, 5, 0, '', 1),
(34, '2024-029', '', ' CLARISSA JAVIER ', 'BELO', 7, 5, 0, '', 1),
(35, '2024-094', '', ' ANDREA RAMOS ', 'DALISAY', 7, 5, 0, '', 1),
(36, '2024-037', '', ' MA. ANGELICA B. ', 'DE ASIS', 7, 5, 0, '', 1),
(37, '2024-073', '', ' FRANCINE BAUTISTA', 'DEL ROSARIO', 7, 5, 0, '', 1),
(38, '2024-030', '', ' HAZEL DE OCAMPO ', 'DEL ROSARIO', 7, 5, 0, '', 1),
(39, '2024-053', '', ' SOFIA DENISE BISCOCHO', 'DIMAANO', 7, 5, 0, '', 1),
(40, '2024-089', '', ' JHERVILE DE ROXAS', 'INCIONG', 7, 5, 0, '', 1),
(41, '2024-039', '', ' JHERYLLE DE ROXAS ', 'INCIONG', 7, 5, 0, '', 1),
(42, '2024-002', '', ' ALLYSA  CARABLE  ', 'KALALO', 7, 5, 0, '', 1),
(43, '2024-052', '', ' CLARISSE CARLAN ', 'MAGCAWAS', 7, 5, 0, '', 1),
(44, '2024-011', '', ' RICA MAE VILLANUEVA ', 'PACULBA', 7, 5, 0, '', 1),
(45, '2024-031', '', ' ANDRIEN BIANCA MELGAREJO ', 'REYES', 7, 5, 0, '', 1),
(46, '2024-050', '', ' SHELVIE AIRA MANALO ', 'RIEGO', 7, 5, 0, '', 1),
(47, '2024-016', '', ' FELICITY MAHRIE RAMOS ', 'ROSALES', 7, 5, 0, '', 1),
(48, '2024-010', '', ' LYRA JEN ARROYO ', 'SALAZAR', 7, 5, 0, '', 1),
(49, '2024-017', '', ' REGINE DIMAYUGA ', 'TIBURIO', 7, 5, 0, '', 1),
(50, '2024-087', '', ' JOHN MARC VELASCO', 'ADOC', 7, 3, 0, '', 1),
(51, '2024-096', '', ' ERICK VIENAI TIBAYAN', 'AGUSTIN', 7, 3, 0, '', 1),
(52, '2024-074', '', ' WEIXTTER CRISTINOR', 'ARCILLA', 7, 3, 0, '', 1),
(53, '2024-023', '', ' KIRBY JOSEF PORILLO', 'ATIENZA', 7, 3, 0, '', 1),
(54, '2024-046', '', ' JAMES LOUEL DE GALA', 'BAUTISTA', 7, 3, 0, '', 1),
(55, '2024-075', '', ' JOHN ARRON MALALUAN', 'BINAY', 7, 3, 0, '', 1),
(56, '2024-041', '', ' JOHN KENNETH AQUINO', 'DE JESUS', 7, 3, 0, '', 1),
(57, '2024-042', '', ' NEIL RION N.', 'DELA CRUZ', 7, 3, 0, '', 1),
(58, '2024-063', '', ' ALDRINE DE OCAMPO', 'GABRIEL', 7, 3, 0, '', 1),
(59, '2024-049', '', ' KARL NOEN AGUSTIN', 'INCIONG', 7, 3, 0, '', 1),
(60, '2024-040', '', ' KIEN DARYL METRILLO', 'JAPLOS', 7, 3, 0, '', 1),
(61, '2024-082', '', ' ROVIC JAVIE BARCENILLA', 'JAVEN', 7, 3, 0, '', 1),
(62, '2024-068', '', ' JAMES MATHEW A.', 'LANDICHO', 7, 3, 0, '', 1),
(63, '2024-097', '', ' ANGELO SALAZAR', 'LEYESA', 7, 3, 0, '', 1),
(64, '2024-019', '', ' JUSTINE VINCENT DE OCAMPO', 'LIWANAG', 7, 3, 0, '', 1),
(65, '2024-061', '', ' CARL JUSTIN LANDICHO', 'LONZAME', 7, 3, 0, '', 1),
(66, '2024-035', '', ' MARK DHAREN ERRL QUITLONG', 'MARIANO', 7, 3, 0, '', 1),
(67, '2024-038', '', ' NIÑO JUSTIN MANALO', 'MENDOZA', 7, 3, 0, '', 1),
(68, '2024-056', '', ' REYNIEL IVAN BABADILLA', 'MORGADO', 7, 3, 0, '', 1),
(69, '2024-092', '', ' ROMEL MILITSALA', 'NAVARRO', 7, 3, 0, '', 1),
(70, '2024-057', '', ' JOHN PAULO ROSITA', 'NAVELA', 7, 3, 0, '', 1),
(71, '2024-009', '', ' JOHN PAUL MANCENIDO', 'NECOR', 7, 3, 0, '', 1),
(72, '2024-086', '', ' JOSHUA JAVIER', 'OSEÑA', 7, 3, 0, '', 1),
(73, '2024-058', '', ' JHON AARON CERUELAS', 'PANTI', 7, 3, 0, '', 1),
(74, '2024-070', '', ' WILLIAM HANSLEIGH', 'PEREGRINA', 7, 3, 0, '', 1),
(75, '2024-047', '', ' PAUL DENIEL P.', 'POSTRERO', 7, 3, 0, '', 1),
(76, '2024-018', '', ' TYRON MENDOZA', 'PUNZALAN', 7, 3, 0, '', 1),
(77, '2024-054', '', ' CEJAY ADONA', 'SARMIENTO', 7, 3, 0, '', 1),
(78, '2024-051', '', ' NIKKO SUAREZ', 'SARMIENTO', 7, 3, 0, '', 1),
(79, '2024-024', '', ' MIKO SUAREZ', 'SILVA', 7, 3, 0, '', 1),
(80, '2024-085', '', ' JHON PATRICK MANALO', 'SOLIS', 7, 3, 0, '', 1),
(81, '2024-091', '', ' JONATHAN HANS SARIO', 'SOLIS', 7, 3, 0, '', 1),
(82, '2024-069', '', ' YOHVENEIL NAYVE', 'ZAPLAN', 7, 3, 0, '', 1),
(83, '2024-001', '', ' RODELYN CLAVIDO', 'ALMONTE', 7, 3, 0, '', 1),
(84, '2024-081', '', ' CLANCY EAYAN MANALO', 'BACULO', 7, 3, 0, '', 1),
(85, '2024-033', '', ' MIKEY FONTANILLA', 'CONTRERAS', 7, 3, 0, '', 1),
(86, '2024-076', '', ' LENDZY JOREINE ORZO', 'ESCALONA', 7, 3, 0, '', 1),
(87, '2024-032', '', ' JANIEL ASHLEY GARCIA', 'JALLORES', 7, 3, 0, '', 1),
(88, '2024-021', '', ' ASHLEY NICOLE BABADILLA', 'LASHERAS', 7, 3, 0, '', 1),
(89, '2024-020', '', ' FRANCESCA VENICE MAYA', 'ORENSE', 7, 3, 0, '', 1),
(90, '2024-060', '', ' LOREN VERDADERO', 'PEREZ', 7, 3, 0, '', 1),
(91, '2024-077', '', ' IRISH GUTIERREZ', 'ROSITA', 7, 3, 0, '', 1),
(92, '2024-078', '', ' JHAZMEINE FRONDA', 'SOLIS', 7, 3, 0, '', 1),
(93, '2024-036', '', ' JORDANE ADRIELLE ROVELO', 'TAGUINOD', 7, 3, 0, '', 1),
(94, '2024-079', '', ' JADE LORRAINE EYAS', 'UMALI', 7, 3, 0, '', 1),
(95, '2023-001', '', ' ANGELO SEBHAZTIAN MANIGBAS', 'HAIN', 8, 4, 0, '', 1),
(96, '2023-010', '', ' KIAN FRATE MAGCAMIT', 'PADOLINA', 8, 4, 0, '', 1),
(97, '2023-031', '', ' JOBERT MARCELINO', 'ROCAFORT', 8, 4, 0, '', 1),
(98, '2023-015', '', ' ANGELEE METRILLO', 'AVENIDO', 8, 4, 0, '', 1),
(99, '2023-018', '', ' MARY MELCHIZEDEK TIBAYAN', 'LAJARA', 8, 4, 0, '', 1),
(100, '2023-007', '', ' MARY MAE MIRAN', 'MANALO', 8, 4, 0, '', 1),
(101, '2023-066', '', ' MA. DIMPLE CASTILLO', 'MARALIT', 8, 4, 0, '', 1),
(102, '2023-057', '', ' KATRINA LORRAINE MARANAN', 'MORADA', 8, 4, 0, '', 1),
(103, '2023-005', '', ' GWENDALYN JOSELLE DIMAANO', 'OROLFO', 8, 4, 0, '', 1),
(104, '2023-006', '', ' ROSEZL MADRAZO', 'REYES', 8, 4, 0, '', 1),
(105, '2023-062', '', ' KARL ANTHONY KASILAG', 'HOSEÑA', 8, 5, 0, '', 1),
(106, '2023-014', '', ' RAFAEL SEMILLA', 'LANDICHO', 8, 5, 0, '', 1),
(107, '2023-025', '', ' RALPH LUIS SARMIENTO', 'MAGPANTAY', 8, 5, 0, '', 1),
(108, '2023-044', '', ' PIA FRANCO', 'ALCANTARA', 8, 5, 0, '', 1),
(109, '2023-041', '', ' ANGELA AGUILAR', 'BADONG', 8, 5, 0, '', 1),
(110, '2023-036', '', ' DIANE GAYLE SOLIDUM', 'BASMAYOR', 8, 5, 0, '', 1),
(111, '2023-008', '', ' JONIELLA CARPO', 'CARPIO', 8, 5, 0, '', 1),
(112, '2023-034', '', ' MAY ANN VILLANUEVA', 'CORONA', 8, 5, 0, '', 1),
(113, '2023-028', '', ' CATHLYN MERCADO', 'DE LUNA', 8, 5, 0, '', 1),
(114, '2023-038', '', ' KATHERINE GARCIA', 'JAPLOS', 8, 5, 0, '', 1),
(115, '2024-034', '', ' PAULA RAINMIEL REYES', 'MACASAET', 8, 5, 0, '', 1),
(116, '2023-067', '', ' MA. ANGELICA', 'MANLANOT', 8, 5, 0, '', 1),
(117, '2023-032', '', ' MA. XANDRA VIANCA ORIHUELA', 'MARALIT', 8, 5, 0, '', 1),
(118, '2023-076', '', ' EZEKIELA ESTHER', 'PINGOL', 8, 5, 0, '', 1),
(119, '2023-026', '', ' JAYZL MADRAZO', 'REYES', 8, 5, 0, '', 1),
(120, '2023-074', '', ' CATE-ASHLY SARMIENTO', 'SALSONA', 8, 5, 0, '', 1),
(121, '2023-037', '', ' ROSEMEL ANN TABABA', 'TENORIO', 8, 5, 0, '', 1),
(122, '2023-053', '', ' HEINRICH VON ADISON SAN JUAN', 'ANDAYA', 8, 3, 0, '', 1),
(123, '2023-013', '', ' RENDELL', 'ANGELES', 8, 3, 0, '', 1),
(124, '2023-063', '', ' RAIKIE TROY RAFOLS', 'ARANDA', 8, 3, 0, '', 1),
(125, '2023-069', '', ' PAUL VIER RENZ LANTO', 'DE TORRES', 8, 3, 0, '', 1),
(126, '2023-009', '', ' KEN ISAAC MENDOZA', 'DIMACULANGAN', 8, 3, 0, '', 1),
(127, '2023-077', '', ' HERNANDO GABRIEL SUBOL', 'HERNANDEZ', 8, 3, 0, '', 1),
(128, '2023-027', '', ' KLYDE ASHLY GONZALES', 'HERNANDEZ', 8, 3, 0, '', 1),
(129, '2023-019', '', ' GEOFF LORENZ TORIO', 'LANDICHO', 8, 3, 0, '', 1),
(130, '2023-051', '', ' RENSON JAY VILLANUEVA', 'LESCANO', 8, 3, 0, '', 1),
(131, '2023-060', '', ' LAWRENCE JOHN MORADA', 'LUCINA', 8, 3, 0, '', 1),
(132, '2023-048', '', ' JOHN MARK RABINO', 'MACABUHAY', 8, 3, 0, '', 1),
(133, '2023-047', '', ' CHRISTOPER EVANGELISTA', 'MANALO', 8, 3, 0, '', 1),
(134, '2023-039', '', ' AERON JADE BAYANI', 'MIRANDILLA', 8, 3, 0, '', 1),
(135, '2023-003', '', ' RODERICK JR. TAGUBAT', 'PALACI', 8, 3, 0, '', 1),
(136, '2023-017', '', ' JORNYKHEL KYLE TIBAYAN', 'PARCIA', 8, 3, 0, '', 1),
(137, '2023-059', '', ' NIEL BRIAN BACLIG', 'RESTUM', 8, 3, 0, '', 1),
(138, '2023-021', '', ' PAUL KENNETH BEKING', 'SILVA', 8, 3, 0, '', 1),
(139, '2023-075', '', ' DWYANE MARC RODRIGUEZ', 'VALMADRID', 8, 3, 0, '', 1),
(140, '2023-068', '', ' JOHN PAULO CUEVAS', 'VERGARA', 8, 3, 0, '', 1),
(141, '2023-030', '', ' ALDRICH JASON ALVAREZ', 'VILLAGONZALO', 8, 3, 0, '', 1),
(142, '2023-070', '', ' MANISHA MARIABELLA MONTEALTO', 'ALBOTRA', 8, 3, 0, '', 1),
(143, '2023-002', '', ' JEANLYN MENDOZA', 'BAUTISTA', 8, 3, 0, '', 1),
(144, '2023-033', '', ' GECYMAE ROSALES', 'DAGPA', 8, 3, 0, '', 1),
(145, '2023-022', '', ' FIARA ALEXIA LUCERO', 'DE LEON', 8, 3, 0, '', 1),
(146, '2023-073', '', ' EOWYN DESPOJO', 'LALUNA', 8, 3, 0, '', 1),
(147, '2022-004', '', ' ALYANAH JENELLE INAMARGA', 'ABANILLA', 9, 4, 0, '', 1),
(148, '2022-015', '', ' MA. KASSANDRA GARCIA', 'CARAAN', 9, 4, 0, '', 1),
(149, '2022-052', '', ' ELOISA JANE CIRUELAS', 'DIMAYUGA', 9, 4, 0, '', 1),
(150, '2022-029', '', ' KHEANNA ROSAURA MALABAG', 'LIAC', 9, 4, 0, '', 1),
(151, '2022-026', '', ' ANGELICA POLIDARIO', 'MANALO', 9, 4, 0, '', 1),
(152, '2022-020', '', ' ZELTHEA JASMINE SEÑO', 'SEMBRANO', 9, 4, 0, '', 1),
(153, '2023-064', '', ' MARK JOHN ROY LIM', 'GULANG', 9, 5, 0, '', 1),
(154, '2022-054', '', ' PHRYNZ LEYNARD TIBAYAN', 'VILLANUEVA', 9, 5, 0, '', 1),
(155, '2022-036', '', ' CAZLEY ZYRINE MERCADO', 'ALVAREZ', 9, 5, 0, '', 1),
(156, '2022-011', '', ' MARIELLA FRANCINE BACOTO', 'ATIENZA', 9, 5, 0, '', 1),
(157, '2022-014', '', ' FLORIELYN MAE DELA CRUZ', 'BANAWA', 9, 5, 0, '', 1),
(158, '2022-034', '', ' ALIEZA MARIE VERGARA', 'BOA', 9, 5, 0, '', 1),
(159, '2022-007', '', ' ALYSON HONOR', 'MANALO', 9, 5, 0, '', 1),
(160, '2023-078', '', ' ALEA NICOLE HERNANDEZ', 'MARASIGAN', 9, 5, 0, '', 1),
(161, '2022-023', '', ' SHEENA ROSE ORTEGA', 'MARTIN', 9, 5, 0, '', 1),
(162, '2022-008', '', ' KIANA MARIE SEMBRANO', 'SAÑOSA', 9, 5, 0, '', 1),
(163, '2022-045', '', ' ASHLEY YVONNE CAPONPON', 'TIBAYAN', 9, 5, 0, '', 1),
(164, '2022-017', '', ' DANIEL ESTRADA', 'AGUAYO', 9, 3, 0, '', 1),
(165, '2022-012', '', ' JOHN MARCO CISCAR', 'ARRIOLA', 9, 3, 0, '', 1),
(166, '2022-001', '', ' FRANZ GABRIELLE TISBE', 'ATAGUAN', 9, 3, 0, '', 1),
(167, '2022-037', '', ' LAWRENCE PAOLO MERCADO', 'CAGUICLA', 9, 3, 0, '', 1),
(168, '2022-024', '', ' CHRIS ALLEN TIQUIS', 'CARANDANG', 9, 3, 0, '', 1),
(169, '2022-030', '', ' EARL GRAYFERD TIBAYAN', 'DE GUZMAN', 9, 3, 0, '', 1),
(170, '2022-025', '', ' JOROSS GONZALES', 'DE LA VEGA', 9, 3, 0, '', 1),
(171, '2022-048', '', ' LANCE CHRISTIAN ORENSE', 'DE VILLA', 9, 3, 0, '', 1),
(172, '2022-035', '', ' TRISTAN METRILLO', 'GONZALES', 9, 3, 0, '', 1),
(173, '2022-022', '', ' ISAIH DIMABASA', 'JORDAN', 9, 3, 0, '', 1),
(174, '2022-019', '', ' MARK ANGELO DE CASTRO', 'MANALO', 9, 3, 0, '', 1),
(175, '2022-018', '', ' ALDRIN CARANDANG', 'MEDINA', 9, 3, 0, '', 1),
(176, '2022-032', '', ' GIOVANNI PAOLO JAPLOS', 'ONA', 9, 3, 0, '', 1),
(177, '2022-010', '$2y$10$XTo/WGQi1K6F7hzi2I0wA.b7rBXAIEJqsVhaMWkr2SjPm7CCU9xhO', ' JOHN CARLO BANDAGOSA', 'PALOMILLO', 9, 3, 0, '', 1),
(178, '2022-013', '', 'ARGEL JOSEPH DE MAALA', 'TAMBONG ', 9, 3, 0, '', 1),
(179, '2022-050', '', ' EHLA JOY EVANGELISTA', 'BABADILLA', 9, 3, 0, '', 1),
(180, '2022-003', '', ' SHAINA BULGADO', 'BORRES', 9, 3, 0, '', 1),
(181, '2022-049', '', ' MIKAYLA JELL PASTOR', 'CALIBO', 9, 3, 0, '', 1),
(182, '2022-028', '', ' JOY FRUELDA', 'ESPIÑA', 9, 3, 0, '', 1),
(183, '2022-002', '', ' STEFHANNIE KASILAG', 'MALUJIE', 9, 3, 0, '', 1),
(184, '2022-031', '', ' ROXANNE GAMBOA', 'RECIO', 9, 3, 0, '', 1),
(185, '2022-009', '', ' JOSZHEIL AUBREY', 'REYES', 9, 3, 0, '', 1),
(186, '2021-022', '', ' LOREN JOY MONTOYA', 'SAYAS', 9, 3, 0, '', 1),
(187, '2021-012', '', ' HANNAH LYKA DOTON', 'ALOP', 10, 4, 0, '', 1),
(188, '2021-030', '', ' MARICHOU BAGTAS', 'GALVAN', 10, 4, 0, '', 1),
(189, '2021-023', '', ' FRANCES KAYE', 'OÑATE', 10, 4, 0, '', 1),
(190, '2021-011', '', ' CATHLEEN VERGARA', 'SANDOVAL', 10, 4, 0, '', 1),
(191, '2021-045', '', ' RIAH ABIGAIL RAMOS', 'ARANDA', 10, 5, 0, '', 1),
(192, '2021-019', '', ' RYNE AMORIELLE SARMIENTO', 'MAGPANTAY', 10, 5, 0, '', 1),
(193, '2021-001', '', ' MARY ALLAINE MANALO ', 'ORENSE', 10, 5, 0, '', 1),
(194, '2021-049', '', ' SHIELA MAY VERZOSA ', 'RAMIREZ', 10, 5, 0, '', 1),
(195, '2018-030', '', ' JIM RICHARD APELO', 'ANDAL', 10, 2, 0, '', 1),
(196, '2020-002', '', ' HAZEL CABANAG', 'HERNANDEZ', 10, 2, 0, '', 1),
(197, '2021-041', '', ' ALFRANCIS WACKO CASTILLO', 'CASTILLO', 10, 3, 0, '', 1),
(198, '2021-016', '', ' ANGELO JULIEAN', 'CRUZAT', 10, 3, 0, '', 1),
(199, '2021-060', '', ' BRENT JAY ORENSE', 'DE LEON', 10, 3, 0, '', 1),
(200, '2021-025', '', ' JAVIE TIBAYAN', 'DE LEON', 10, 3, 0, '', 1),
(201, '2021-035', '', ' JAMES CARL ESPLANA', 'DIMAALIHAN', 10, 3, 0, '', 1),
(202, '2020-029', '', ' JUSTIN LANCE LACORTE', 'HERNANDEZ', 10, 3, 0, '', 1),
(203, '2021-014', '', ' YVAN LUNA', 'KALALO', 10, 3, 0, '', 1),
(204, '2021-007', '', ' JOHN MARK DE LEON', 'MANALO', 10, 3, 0, '', 1),
(205, '2019-028', '', ' EDWARDO', 'ORA-A JR.', 10, 3, 0, '', 1),
(206, '2021-053', '', ' ZHEILWINN VINCENT', 'REYES', 10, 3, 0, '', 1),
(207, '2021-050', '', ' CARL ADE SARMIENTO', 'SALSONA', 10, 3, 0, '', 1),
(208, '2021-044', '', ' JHON PABLO IBATAN', 'TIQUIS', 10, 3, 0, '', 1),
(209, '2021-032', '', ' MARK EDCEL AUSTRIA', 'ZARA', 10, 3, 0, '', 1),
(210, '2021-046', '', ' AIRA LEI MERCED', 'BIO', 10, 3, 0, '', 1),
(211, '2021-015', '', ' LYKA MAE PASAJOL', 'LALOG', 10, 3, 0, '', 1),
(212, '2021-036', '', ' CASSANDRA ORENSE', 'ORZO', 10, 3, 0, '', 1),
(213, '2021-027', '', ' IRA MAE ESLETA', 'SARMIENTO', 10, 3, 0, '', 1);

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

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`id`, `description`) VALUES
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
-- Indexes for table `sad`
--
ALTER TABLE `sad`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `party`
--
ALTER TABLE `party`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sad`
--
ALTER TABLE `sad`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=964;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
