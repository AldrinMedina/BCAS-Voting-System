-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2024 at 04:25 AM
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
(1, 'Admin', '$2y$10$6ORaEOo3l8wc.eBQcYbBS.6tmBjKLPmQk5jt0VUBHDFuLQs48dQK6', 'Franz', 'Ataguan', '246626009_764120481653539_1874714275795037679_n-removebg-preview (1).png', '2018-04-02');

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
(20, 8, 'Yvan', 'Kalalo', '', 2),
(21, 9, 'Phrynz ', 'Villanueva', '', 2),
(22, 10, 'Klyde Ashley ', 'Hernandez', '', 2),
(23, 11, 'Aldrin', 'Medina', '', 2),
(24, 12, 'Aira Lei', 'Bio', '', 2),
(25, 13, 'Angelo', 'Hain', '', 2),
(26, 14, 'Ezekiel', 'Pingol', '', 2),
(27, 15, 'Regine ', 'Tiburio', '', 2),
(28, 16, 'May Ann', 'Corona', '', 2),
(29, 17, 'Isaih', 'Jordan', '', 2),
(30, 18, 'Hannah Lyka', 'Alop', '', 2);

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
(0, 'Did not vote');

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
  `year` int(255) NOT NULL,
  `course` int(11) NOT NULL,
  `voted` tinyint(1) NOT NULL,
  `photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `year`, `course`, `voted`, `photo`) VALUES
(1, '2024-008', '', 'LLOYD MENDOZA', 'PARAYNO', 7, 2, 0, ''),
(2, '2024-064', '', ' QUEENETH ZARASPE', 'BATHAN', 7, 2, 0, ''),
(3, '2024-015', '', ' JASMINE D', 'CARPIO', 7, 2, 0, ''),
(4, '2024-007', '', ' JESSICA ALBARICO', 'DURAN', 7, 2, 0, ''),
(5, '2024-005', '', 'ALYSSA MYKA METRILLO', 'EJE', 7, 2, 0, ''),
(6, '2024-006', '', 'JAMAICA OSEÑA', 'INCIONG', 7, 2, 0, ''),
(7, '2024-013', '', 'ALZEA ORUA', 'KATIMBANG', 7, 2, 0, ''),
(8, '2024-014', '', 'ANGELICA RIVERO', 'MANALO', 7, 2, 0, ''),
(9, '2024-012', '', 'ELOISA SISCAR', 'MANALO', 7, 2, 0, ''),
(10, '2024-028', '', ' LOUIS OROZCO', 'PEJI', 7, 4, 0, ''),
(11, '2024-048', '', ' RAYMARK LATAGAN', 'NUEVO', 7, 4, 0, ''),
(12, '2024-080', '', ' JEBOY PUNZALAN', 'UMALI', 7, 4, 0, ''),
(13, '2024-088', '', ' SHAINE ADIELINE DE TORRES', 'LATAG', 7, 4, 0, ''),
(14, '2024-045', '', ' JORGIE POYAWAN', 'CLEOFE', 7, 4, 0, ''),
(15, '2024-062', '', ' ROMEL OROLFO', 'LUYA', 7, 4, 0, ''),
(16, '2024-025', '', ' REEZE AALA', 'ALCANTARA', 7, 4, 0, ''),
(17, '2024-090', '', ' AILENE MAYANO', 'ALE', 7, 4, 0, ''),
(18, '2024-027', '', ' JESSA LUCAÑAS', 'CALINGASAN', 7, 4, 0, ''),
(19, '2024-026', '', ' ANGELICA FAITH CABACES', 'MALALUAN', 7, 4, 0, ''),
(20, '2024-1001', '', ' ANGEL JOY', 'NAPADAWAN', 7, 4, 0, ''),
(21, '2024-043', '', ' GLEZELLE ANN DE VILLA', 'SOLIS', 7, 4, 0, ''),
(22, '2024-065', '', ' PAOLO SUAREZ ', 'ALINA', 7, 5, 0, ''),
(23, '2024-067', '', ' ACE LAWRENCE BERMILLO ', 'AQUINO', 7, 5, 0, ''),
(24, '2024-095', '', ' JASPER ARCEL MALALUAN ', 'BINAY', 7, 5, 0, ''),
(25, '2024-066', '', ' JAN CHARISTIAN OROZO ', 'CALINISAN', 7, 5, 0, ''),
(26, '2024-022', '', ' JOHN LESTER REYES ', 'DE CHAVEZ', 7, 5, 0, ''),
(27, '2024-003', '', ' MARK JULIUS MAQUINTO  ', 'DE LA VEGA', 7, 5, 0, ''),
(28, '2024-084', '', 'JAMES CEDRICK AGUILA  ', 'LIAC', 7, 5, 0, ''),
(29, '2024-055', '', ' SIMON KYLE GUEVARRA', 'OROSCO', 7, 5, 0, ''),
(30, '2024-071', '', ' PAUL DEXTER BEKING ', 'SILVA', 7, 5, 0, ''),
(31, '2024-093', '', ' NIKKI CALIG-ONAN ', 'AGUADO', 7, 5, 0, ''),
(32, '2024-004', '', ' ELISABETH ZARA  ', 'ALBA', 7, 5, 0, ''),
(33, '2024-072', '', ' MARIA MIKAYLA MONTEALTO ', 'ALBOTRA', 7, 5, 0, ''),
(34, '2024-029', '', ' CLARISSA JAVIER ', 'BELO', 7, 5, 0, ''),
(35, '2024-094', '', ' ANDREA RAMOS ', 'DALISAY', 7, 5, 0, ''),
(36, '2024-037', '', ' MA. ANGELICA B. ', 'DE ASIS', 7, 5, 0, ''),
(37, '2024-073', '', ' FRANCINE BAUTISTA', 'DEL ROSARIO', 7, 5, 0, ''),
(38, '2024-030', '', ' HAZEL DE OCAMPO ', 'DEL ROSARIO', 7, 5, 0, ''),
(39, '2024-053', '', ' SOFIA DENISE BISCOCHO', 'DIMAANO', 7, 5, 0, ''),
(40, '2024-089', '', ' JHERVILE DE ROXAS', 'INCIONG', 7, 5, 0, ''),
(41, '2024-039', '', ' JHERYLLE DE ROXAS ', 'INCIONG', 7, 5, 0, ''),
(42, '2024-002', '', ' ALLYSA  CARABLE  ', 'KALALO', 7, 5, 0, ''),
(43, '2024-052', '', ' CLARISSE CARLAN ', 'MAGCAWAS', 7, 5, 0, ''),
(44, '2024-011', '', ' RICA MAE VILLANUEVA ', 'PACULBA', 7, 5, 0, ''),
(45, '2024-031', '', ' ANDRIEN BIANCA MELGAREJO ', 'REYES', 7, 5, 0, ''),
(46, '2024-050', '', ' SHELVIE AIRA MANALO ', 'RIEGO', 7, 5, 0, ''),
(47, '2024-016', '', ' FELICITY MAHRIE RAMOS ', 'ROSALES', 7, 5, 0, ''),
(48, '2024-010', '', ' LYRA JEN ARROYO ', 'SALAZAR', 7, 5, 0, ''),
(49, '2024-017', '', ' REGINE DIMAYUGA ', 'TIBURIO', 7, 5, 0, ''),
(50, '2024-087', '', ' JOHN MARC VELASCO', 'ADOC', 7, 3, 0, ''),
(51, '2024-096', '', ' ERICK VIENAI TIBAYAN', 'AGUSTIN', 7, 3, 0, ''),
(52, '2024-074', '', ' WEIXTTER CRISTINOR', 'ARCILLA', 7, 3, 0, ''),
(53, '2024-023', '', ' KIRBY JOSEF PORILLO', 'ATIENZA', 7, 3, 0, ''),
(54, '2024-046', '', ' JAMES LOUEL DE GALA', 'BAUTISTA', 7, 3, 0, ''),
(55, '2024-075', '', ' JOHN ARRON MALALUAN', 'BINAY', 7, 3, 0, ''),
(56, '2024-041', '', ' JOHN KENNETH AQUINO', 'DE JESUS', 7, 3, 0, ''),
(57, '2024-042', '', ' NEIL RION N.', 'DELA CRUZ', 7, 3, 0, ''),
(58, '2024-063', '', ' ALDRINE DE OCAMPO', 'GABRIEL', 7, 3, 0, ''),
(59, '2024-049', '', ' KARL NOEN AGUSTIN', 'INCIONG', 7, 3, 0, ''),
(60, '2024-040', '', ' KIEN DARYL METRILLO', 'JAPLOS', 7, 3, 0, ''),
(61, '2024-082', '', ' ROVIC JAVIE BARCENILLA', 'JAVEN', 7, 3, 0, ''),
(62, '2024-068', '', ' JAMES MATHEW A.', 'LANDICHO', 7, 3, 0, ''),
(63, '2024-097', '', ' ANGELO SALAZAR', 'LEYESA', 7, 3, 0, ''),
(64, '2024-019', '', ' JUSTINE VINCENT DE OCAMPO', 'LIWANAG', 7, 3, 0, ''),
(65, '2024-061', '', ' CARL JUSTIN LANDICHO', 'LONZAME', 7, 3, 0, ''),
(66, '2024-035', '', ' MARK DHAREN ERRL QUITLONG', 'MARIANO', 7, 3, 0, ''),
(67, '2024-038', '', ' NIÑO JUSTIN MANALO', 'MENDOZA', 7, 3, 0, ''),
(68, '2024-056', '', ' REYNIEL IVAN BABADILLA', 'MORGADO', 7, 3, 0, ''),
(69, '2024-092', '', ' ROMEL MILITSALA', 'NAVARRO', 7, 3, 0, ''),
(70, '2024-057', '', ' JOHN PAULO ROSITA', 'NAVELA', 7, 3, 0, ''),
(71, '2024-009', '', ' JOHN PAUL MANCENIDO', 'NECOR', 7, 3, 0, ''),
(72, '2024-086', '', ' JOSHUA JAVIER', 'OSEÑA', 7, 3, 0, ''),
(73, '2024-058', '', ' JHON AARON CERUELAS', 'PANTI', 7, 3, 0, ''),
(74, '2024-070', '', ' WILLIAM HANSLEIGH', 'PEREGRINA', 7, 3, 0, ''),
(75, '2024-047', '', ' PAUL DENIEL P.', 'POSTRERO', 7, 3, 0, ''),
(76, '2024-018', '', ' TYRON MENDOZA', 'PUNZALAN', 7, 3, 0, ''),
(77, '2024-054', '', ' CEJAY ADONA', 'SARMIENTO', 7, 3, 0, ''),
(78, '2024-051', '', ' NIKKO SUAREZ', 'SARMIENTO', 7, 3, 0, ''),
(79, '2024-024', '', ' MIKO SUAREZ', 'SILVA', 7, 3, 0, ''),
(80, '2024-085', '', ' JHON PATRICK MANALO', 'SOLIS', 7, 3, 0, ''),
(81, '2024-091', '', ' JONATHAN HANS SARIO', 'SOLIS', 7, 3, 0, ''),
(82, '2024-069', '', ' YOHVENEIL NAYVE', 'ZAPLAN', 7, 3, 0, ''),
(83, '2024-001', '', ' RODELYN CLAVIDO', 'ALMONTE', 7, 3, 0, ''),
(84, '2024-081', '', ' CLANCY EAYAN MANALO', 'BACULO', 7, 3, 0, ''),
(85, '2024-033', '', ' MIKEY FONTANILLA', 'CONTRERAS', 7, 3, 0, ''),
(86, '2024-076', '', ' LENDZY JOREINE ORZO', 'ESCALONA', 7, 3, 0, ''),
(87, '2024-032', '', ' JANIEL ASHLEY GARCIA', 'JALLORES', 7, 3, 0, ''),
(88, '2024-021', '', ' ASHLEY NICOLE BABADILLA', 'LASHERAS', 7, 3, 0, ''),
(89, '2024-020', '', ' FRANCESCA VENICE MAYA', 'ORENSE', 7, 3, 0, ''),
(90, '2024-060', '', ' LOREN VERDADERO', 'PEREZ', 7, 3, 0, ''),
(91, '2024-077', '', ' IRISH GUTIERREZ', 'ROSITA', 7, 3, 0, ''),
(92, '2024-078', '', ' JHAZMEINE FRONDA', 'SOLIS', 7, 3, 0, ''),
(93, '2024-036', '', ' JORDANE ADRIELLE ROVELO', 'TAGUINOD', 7, 3, 0, ''),
(94, '2024-079', '', ' JADE LORRAINE EYAS', 'UMALI', 7, 3, 0, ''),
(95, '2023-001', '', ' ANGELO SEBHAZTIAN MANIGBAS', 'HAIN', 8, 4, 0, ''),
(96, '2023-010', '', ' KIAN FRATE MAGCAMIT', 'PADOLINA', 8, 4, 0, ''),
(97, '2023-031', '', ' JOBERT MARCELINO', 'ROCAFORT', 8, 4, 0, ''),
(98, '2023-015', '', ' ANGELEE METRILLO', 'AVENIDO', 8, 4, 0, ''),
(99, '2023-018', '', ' MARY MELCHIZEDEK TIBAYAN', 'LAJARA', 8, 4, 0, ''),
(100, '2023-007', '', ' MARY MAE MIRAN', 'MANALO', 8, 4, 0, ''),
(101, '2023-066', '', ' MA. DIMPLE CASTILLO', 'MARALIT', 8, 4, 0, ''),
(102, '2023-057', '', ' KATRINA LORRAINE MARANAN', 'MORADA', 8, 4, 0, ''),
(103, '2023-005', '', ' GWENDALYN JOSELLE DIMAANO', 'OROLFO', 8, 4, 0, ''),
(104, '2023-006', '', ' ROSEZL MADRAZO', 'REYES', 8, 4, 0, ''),
(105, '2023-062', '', ' KARL ANTHONY KASILAG', 'HOSEÑA', 8, 5, 0, ''),
(106, '2023-014', '', ' RAFAEL SEMILLA', 'LANDICHO', 8, 5, 0, ''),
(107, '2023-025', '', ' RALPH LUIS SARMIENTO', 'MAGPANTAY', 8, 5, 0, ''),
(108, '2023-044', '', ' PIA FRANCO', 'ALCANTARA', 8, 5, 0, ''),
(109, '2023-041', '', ' ANGELA AGUILAR', 'BADONG', 8, 5, 0, ''),
(110, '2023-036', '', ' DIANE GAYLE SOLIDUM', 'BASMAYOR', 8, 5, 0, ''),
(111, '2023-008', '', ' JONIELLA CARPO', 'CARPIO', 8, 5, 0, ''),
(112, '2023-034', '', ' MAY ANN VILLANUEVA', 'CORONA', 8, 5, 0, ''),
(113, '2023-028', '', ' CATHLYN MERCADO', 'DE LUNA', 8, 5, 0, ''),
(114, '2023-038', '', ' KATHERINE GARCIA', 'JAPLOS', 8, 5, 0, ''),
(115, '2024-034', '', ' PAULA RAINMIEL REYES', 'MACASAET', 8, 5, 0, ''),
(116, '2023-067', '', ' MA. ANGELICA', 'MANLANOT', 8, 5, 0, ''),
(117, '2023-032', '', ' MA. XANDRA VIANCA ORIHUELA', 'MARALIT', 8, 5, 0, ''),
(118, '2023-076', '', ' EZEKIELA ESTHER', 'PINGOL', 8, 5, 0, ''),
(119, '2023-026', '', ' JAYZL MADRAZO', 'REYES', 8, 5, 0, ''),
(120, '2023-074', '', ' CATE-ASHLY SARMIENTO', 'SALSONA', 8, 5, 0, ''),
(121, '2023-037', '', ' ROSEMEL ANN TABABA', 'TENORIO', 8, 5, 0, ''),
(122, '2023-053', '', ' HEINRICH VON ADISON SAN JUAN', 'ANDAYA', 8, 3, 0, ''),
(123, '2023-013', '', ' RENDELL', 'ANGELES', 8, 3, 0, ''),
(124, '2023-063', '', ' RAIKIE TROY RAFOLS', 'ARANDA', 8, 3, 0, ''),
(125, '2023-069', '', ' PAUL VIER RENZ LANTO', 'DE TORRES', 8, 3, 0, ''),
(126, '2023-009', '', ' KEN ISAAC MENDOZA', 'DIMACULANGAN', 8, 3, 0, ''),
(127, '2023-077', '', ' HERNANDO GABRIEL SUBOL', 'HERNANDEZ', 8, 3, 0, ''),
(128, '2023-027', '', ' KLYDE ASHLY GONZALES', 'HERNANDEZ', 8, 3, 0, ''),
(129, '2023-019', '', ' GEOFF LORENZ TORIO', 'LANDICHO', 8, 3, 0, ''),
(130, '2023-051', '', ' RENSON JAY VILLANUEVA', 'LESCANO', 8, 3, 0, ''),
(131, '2023-060', '', ' LAWRENCE JOHN MORADA', 'LUCINA', 8, 3, 0, ''),
(132, '2023-048', '', ' JOHN MARK RABINO', 'MACABUHAY', 8, 3, 0, ''),
(133, '2023-047', '', ' CHRISTOPER EVANGELISTA', 'MANALO', 8, 3, 0, ''),
(134, '2023-039', '', ' AERON JADE BAYANI', 'MIRANDILLA', 8, 3, 0, ''),
(135, '2023-003', '', ' RODERICK JR. TAGUBAT', 'PALACI', 8, 3, 0, ''),
(136, '2023-017', '', ' JORNYKHEL KYLE TIBAYAN', 'PARCIA', 8, 3, 0, ''),
(137, '2023-059', '', ' NIEL BRIAN BACLIG', 'RESTUM', 8, 3, 0, ''),
(138, '2023-021', '', ' PAUL KENNETH BEKING', 'SILVA', 8, 3, 0, ''),
(139, '2023-075', '', ' DWYANE MARC RODRIGUEZ', 'VALMADRID', 8, 3, 0, ''),
(140, '2023-068', '', ' JOHN PAULO CUEVAS', 'VERGARA', 8, 3, 0, ''),
(141, '2023-030', '', ' ALDRICH JASON ALVAREZ', 'VILLAGONZALO', 8, 3, 0, ''),
(142, '2023-070', '', ' MANISHA MARIABELLA MONTEALTO', 'ALBOTRA', 8, 3, 0, ''),
(143, '2023-002', '', ' JEANLYN MENDOZA', 'BAUTISTA', 8, 3, 0, ''),
(144, '2023-033', '', ' GECYMAE ROSALES', 'DAGPA', 8, 3, 0, ''),
(145, '2023-022', '', ' FIARA ALEXIA LUCERO', 'DE LEON', 8, 3, 0, ''),
(146, '2023-073', '', ' EOWYN DESPOJO', 'LALUNA', 8, 3, 0, ''),
(147, '2022-004', '', ' ALYANAH JENELLE INAMARGA', 'ABANILLA', 9, 4, 0, ''),
(148, '2022-015', '', ' MA. KASSANDRA GARCIA', 'CARAAN', 9, 4, 0, ''),
(149, '2022-052', '', ' ELOISA JANE CIRUELAS', 'DIMAYUGA', 9, 4, 0, ''),
(150, '2022-029', '', ' KHEANNA ROSAURA MALABAG', 'LIAC', 9, 4, 0, ''),
(151, '2022-026', '', ' ANGELICA POLIDARIO', 'MANALO', 9, 4, 0, ''),
(152, '2022-020', '', ' ZELTHEA JASMINE SEÑO', 'SEMBRANO', 9, 4, 0, ''),
(153, '2023-064', '', ' MARK JOHN ROY LIM', 'GULANG', 9, 5, 0, ''),
(154, '2022-054', '', ' PHRYNZ LEYNARD TIBAYAN', 'VILLANUEVA', 9, 5, 0, ''),
(155, '2022-036', '', ' CAZLEY ZYRINE MERCADO', 'ALVAREZ', 9, 5, 0, ''),
(156, '2022-011', '', ' MARIELLA FRANCINE BACOTO', 'ATIENZA', 9, 5, 0, ''),
(157, '2022-014', '', ' FLORIELYN MAE DELA CRUZ', 'BANAWA', 9, 5, 0, ''),
(158, '2022-034', '', ' ALIEZA MARIE VERGARA', 'BOA', 9, 5, 0, ''),
(159, '2022-007', '', ' ALYSON HONOR', 'MANALO', 9, 5, 0, ''),
(160, '2023-078', '', ' ALEA NICOLE HERNANDEZ', 'MARASIGAN', 9, 5, 0, ''),
(161, '2022-023', '', ' SHEENA ROSE ORTEGA', 'MARTIN', 9, 5, 0, ''),
(162, '2022-008', '', ' KIANA MARIE SEMBRANO', 'SAÑOSA', 9, 5, 0, ''),
(163, '2022-045', '', ' ASHLEY YVONNE CAPONPON', 'TIBAYAN', 9, 5, 0, ''),
(164, '2022-017', '', ' DANIEL ESTRADA', 'AGUAYO', 9, 3, 0, ''),
(165, '2022-012', '', ' JOHN MARCO CISCAR', 'ARRIOLA', 9, 3, 0, ''),
(166, '2022-001', '', ' FRANZ GABRIELLE TISBE', 'ATAGUAN', 9, 3, 0, ''),
(167, '2022-037', '', ' LAWRENCE PAOLO MERCADO', 'CAGUICLA', 9, 3, 0, ''),
(168, '2022-024', '', ' CHRIS ALLEN TIQUIS', 'CARANDANG', 9, 3, 0, ''),
(169, '2022-030', '', ' EARL GRAYFERD TIBAYAN', 'DE GUZMAN', 9, 3, 0, ''),
(170, '2022-025', '', ' JOROSS GONZALES', 'DE LA VEGA', 9, 3, 0, ''),
(171, '2022-048', '', ' LANCE CHRISTIAN ORENSE', 'DE VILLA', 9, 3, 0, ''),
(172, '2022-035', '', ' TRISTAN METRILLO', 'GONZALES', 9, 3, 0, ''),
(173, '2022-022', '', ' ISAIH DIMABASA', 'JORDAN', 9, 3, 0, ''),
(174, '2022-019', '', ' MARK ANGELO DE CASTRO', 'MANALO', 9, 3, 0, ''),
(175, '2022-018', '', ' ALDRIN CARANDANG', 'MEDINA', 9, 3, 1, ''),
(176, '2022-032', '', ' GIOVANNI PAOLO JAPLOS', 'ONA', 9, 3, 0, ''),
(177, '2022-010', '$2y$10$XTo/WGQi1K6F7hzi2I0wA.b7rBXAIEJqsVhaMWkr2SjPm7CCU9xhO', ' JOHN CARLO BANDAGOSA', 'PALOMILLO', 9, 3, 0, ''),
(178, '2022-013', '', 'ARGEL JOSEPH DE MAALA', 'TAMBONG ', 9, 3, 0, ''),
(179, '2022-050', '', ' EHLA JOY EVANGELISTA', 'BABADILLA', 9, 3, 0, ''),
(180, '2022-003', '', ' SHAINA BULGADO', 'BORRES', 9, 3, 0, ''),
(181, '2022-049', '', ' MIKAYLA JELL PASTOR', 'CALIBO', 9, 3, 0, ''),
(182, '2022-028', '', ' JOY FRUELDA', 'ESPIÑA', 9, 3, 0, ''),
(183, '2022-002', '', ' STEFHANNIE KASILAG', 'MALUJIE', 9, 3, 0, ''),
(184, '2022-031', '', ' ROXANNE GAMBOA', 'RECIO', 9, 3, 0, ''),
(185, '2022-009', '', ' JOSZHEIL AUBREY', 'REYES', 9, 3, 0, ''),
(186, '2021-022', '', ' LOREN JOY MONTOYA', 'SAYAS', 9, 3, 0, ''),
(187, '2021-012', '', ' HANNAH LYKA DOTON', 'ALOP', 10, 4, 0, ''),
(188, '2021-030', '', ' MARICHOU BAGTAS', 'GALVAN', 10, 4, 0, ''),
(189, '2021-023', '', ' FRANCES KAYE', 'OÑATE', 10, 4, 0, ''),
(190, '2021-011', '', ' CATHLEEN VERGARA', 'SANDOVAL', 10, 4, 0, ''),
(191, '2021-045', '', ' RIAH ABIGAIL RAMOS', 'ARANDA', 10, 5, 0, ''),
(192, '2021-019', '', ' RYNE AMORIELLE SARMIENTO', 'MAGPANTAY', 10, 5, 0, ''),
(193, '2021-001', '', ' MARY ALLAINE MANALO ', 'ORENSE', 10, 5, 0, ''),
(194, '2021-049', '', ' SHIELA MAY VERZOSA ', 'RAMIREZ', 10, 5, 0, ''),
(195, '2018-030', '', ' JIM RICHARD APELO', 'ANDAL', 10, 2, 0, ''),
(196, '2020-002', '', ' HAZEL CABANAG', 'HERNANDEZ', 10, 2, 0, ''),
(197, '2021-041', '', ' ALFRANCIS WACKO CASTILLO', 'CASTILLO', 10, 3, 0, ''),
(198, '2021-016', '', ' ANGELO JULIEAN', 'CRUZAT', 10, 3, 0, ''),
(199, '2021-060', '', ' BRENT JAY ORENSE', 'DE LEON', 10, 3, 0, ''),
(200, '2021-025', '', ' JAVIE TIBAYAN', 'DE LEON', 10, 3, 0, ''),
(201, '2021-035', '', ' JAMES CARL ESPLANA', 'DIMAALIHAN', 10, 3, 0, ''),
(202, '2020-029', '', ' JUSTIN LANCE LACORTE', 'HERNANDEZ', 10, 3, 0, ''),
(203, '2021-014', '', ' YVAN LUNA', 'KALALO', 10, 3, 0, ''),
(204, '2021-007', '', ' JOHN MARK DE LEON', 'MANALO', 10, 3, 0, ''),
(205, '2019-028', '', ' EDWARDO', 'ORA-A JR.', 10, 3, 0, ''),
(206, '2021-053', '', ' ZHEILWINN VINCENT', 'REYES', 10, 3, 0, ''),
(207, '2021-050', '', ' CARL ADE SARMIENTO', 'SALSONA', 10, 3, 0, ''),
(208, '2021-044', '', ' JHON PABLO IBATAN', 'TIQUIS', 10, 3, 0, ''),
(209, '2021-032', '', ' MARK EDCEL AUSTRIA', 'ZARA', 10, 3, 0, ''),
(210, '2021-046', '', ' AIRA LEI MERCED', 'BIO', 10, 3, 0, ''),
(211, '2021-015', '', ' LYKA MAE PASAJOL', 'LALOG', 10, 3, 0, ''),
(212, '2021-036', '', ' CASSANDRA ORENSE', 'ORZO', 10, 3, 0, ''),
(213, '2021-027', '', ' IRA MAE ESLETA', 'SARMIENTO', 10, 3, 0, '');

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
(726, 175, 20, 8),
(727, 175, 21, 9),
(728, 175, 22, 10),
(729, 175, 23, 11),
(730, 175, 24, 12),
(731, 175, 25, 13),
(732, 175, 26, 14),
(733, 175, 0, 17);

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
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `voters`
--
ALTER TABLE `voters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=734;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
