-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2024 at 01:53 PM
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
(1, 'Admin', '$2y$10$FyCcelVOtJuoLb43ZpfM9OobWnuTNgea1eGIg42Y3sHI0hYmOqh4a', 'Franz', 'Ataguan', '246626009_764120481653539_1874714275795037679_n-removebg-preview (1).png', '2018-04-02');

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
(21, 11, 'Yvan', 'Kalalo', 'logo.png', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(23, 12, 'Phrynz', 'Villanueva', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(24, 13, 'Klyde Ashley', 'Hernandez', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(25, 14, 'Aldrin ', 'Medina', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(26, 15, 'Aira Lei', 'Bio', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(27, 16, 'Angelo', 'Hain', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(28, 17, 'Ezekiel', 'Pingol', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(29, 19, 'May Ann', 'Corona', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(30, 20, 'Isaih', 'Jordan', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(31, 21, 'Hannah Lyka', 'Alop', '', 'PADAYON - Pagasa, Ambisyon, Determinasyon, Aksyon, at Nagsusumikap'),
(32, 11, 'Aamina ', 'Hunter', '', 'Smart'),
(33, 12, 'Dhruv', 'Krueger', '', 'SMART'),
(34, 13, 'Lottie', 'Carlson', '', 'SMART'),
(35, 14, 'Blake', 'ORyan', '', 'SMART'),
(36, 15, 'Marwa', 'Higgins', '', 'SMART'),
(37, 16, 'Leo', 'Macdonald', '', 'SMART'),
(38, 17, 'Abdul', 'Bird', '', 'SMART'),
(39, 18, 'Mariyah', 'Morales', '', 'SMART'),
(40, 19, 'Maisha', 'Neal', '', 'SMART'),
(41, 20, 'Joe', 'Larson', '', 'SMART'),
(42, 21, 'Juan', 'Juan', '', 'SMART');

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
  `photo` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `voters`
--

INSERT INTO `voters` (`id`, `voters_id`, `password`, `firstname`, `lastname`, `photo`) VALUES
(11, 'uvDRySktd7c32Km', '$2y$10$Td07rL.FpNwyDvKc4elgQepKUymwQiKjeRWSmT9ctAezNsz0BFW0C', 'Raihie', 'Aranda', ''),
(12, 'CtRMnpXBrwdKmvl', '$2y$10$J2DdRYntBipoFnI3eTrn9O55xZKxKwyy9HXFuIvd/vAXqqB2D.NsC', 'Paul Keneth ', 'Silva', ''),
(13, 'xMqDI4AlkNXYphs', '$2y$10$vaKZYK8B2ugXZO8iUkLUq.dq.4zs2dGrJr6mT1d.C04kyKRaV.WEm', 'Aeron Jade', 'Mirandilla', ''),
(14, 'V6EhxrA5mQkYF3u', '$2y$10$Swrw.keH0J49r5t75KVfGOpsNUe5wwiAVyPmq6nhB6LoHtwFBaIa6', 'Paul Vier', 'De Torres', ''),
(15, 'MZRTq4h8Owzm56y', '$2y$10$0HlUJ/f2NV2z6aWzmYdPl.l8gImcamXYuFXhHArKw65.3pOCyStMW', 'Roderick', 'Palaci', ''),
(16, 'k3HIQZgvLcjeBiF', '$2y$10$7OeO05WMUzi1Xh3z.ra/memFQjTfJLgtda7rhaN4XUckFuqq/3fyK', 'Christoper', 'Manalo', ''),
(17, 'yzNUubgljsO8Bq2', '$2y$10$j5eoer6QEsRE5JxPcS8DZO5A9Er3t0/utVGzx1X2csnLEEqZYNfIW', 'Ashley', 'Hernandez', ''),
(18, 'NmuCvSKRIUrYyg2', '$2y$10$C23uiCkX1mDLRq65RK8JFO7lUfPzLuiR4cyBjFVOlh7ofLxDGgnsm', 'John Paulo', 'Vergara', ''),
(19, '2HZYq4Qm1fVTv5p', '$2y$10$ZlrGAEnGmzP2eEHMvAWV6exHue8fZB31lh6R84vrVca11P62/eEW6', 'Rendell ', 'Angeles', ''),
(20, 'tCyE39YhkadqST1', '$2y$10$AyPFunpo/NQvpKo2sC6LzugaNSa8TEOgLTD9pZJ70UtYlUAm1ceEq', 'Dwayne', 'Valmadrid', ''),
(21, 'Jp4qfvnAF3hxdUE', '$2y$10$wWHh2llCM1AUNsQeewDFeeLnUl.6R/ABgmed6aHhqiDjxUZjpZ1Ra', 'Gecymae', 'Dagpa', ''),
(23, 'QZTmDF6NIVWBbdk', '$2y$10$IYHvKrQ5cQltMz/qtmgUYeleEMtGPKI7WySnZWbaMP/vL.zJsywR2', 'Aldrich Jason', 'Villagonzalo', ''),
(24, 'xikaXSV7RBquYDs', '$2y$10$IPJNjWcet3igxBo3SVw2BOq7ddJYyjEz3/CchBifK81GjRfGSMR3G', 'Jeanlyn', 'Bautista', ''),
(25, 'Y7aSPd6bqwCzJeh', '$2y$10$YCeR/aYvmzjJenaTYkAm6OuJS5TmqOCq7c5Wj2nC9.Z1..QCdN2Rq', 'Eowyn', 'Laluna', ''),
(26, 'UvJx681gyo75Bp3', '$2y$10$yNwgJ9jZ9vj75MfsQZUUyu0g3XkwK9pBKdWNFAhMkZ.K3trnxkkw2', 'Geoff Lorenz', 'Landicho', ''),
(27, 'do3FY4ke7Epn1NP', '$2y$10$MiXDAuWU9VLmu8HBmhdoUeG//OoGV/GQYG3WkbEPyWS/GtqKrZ8PS', 'Fiara', 'De Leon', ''),
(28, 'bmT7weuEHKY2MCa', '$2y$10$ZVyZWFPp8cOouuAdpP2zZ.Ix5t7douum7SaTgVMFAmePb1eSPgOQq', 'Bella', 'Albotra', ''),
(29, 'AJsIH7Dm9GYChy4', '$2y$10$NVrLZS/mIjpgnVQltCBI4eVbf3cBJb7lOTVbk1jjfGituYoq5t8HG', 'Ken', 'Dimaculangan', ''),
(30, 'cZpHakUeNOMyqEl', '$2y$10$/YKqhztHwnnLR.BgjVskz.7aWgNaE2hTNd3X62yJvV1DxmsizmMBS', 'Lawrence', 'Lucina', ''),
(31, 'uPkYH4Ee6AJ1j3D', '$2y$10$5YFP0C6onpOkDmU4h4CoieKiwNkukcAUpMqHc1sSZyn1otHvHfCye', 'JM', 'Macabuhay', ''),
(32, 'NzcIEO8KReqbZCx', '$2y$10$J9GKkdY4boJGIgqzQ370D.obKxDEOF2UJdae9aDDH.UqPH0BCoW2O', 'Aldrin', 'Medina', '');

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
(394, 15, 21, 11),
(395, 15, 23, 12),
(396, 15, 24, 13),
(397, 15, 25, 14),
(398, 15, 26, 15),
(399, 15, 27, 16),
(400, 15, 28, 17),
(401, 15, 39, 18),
(402, 15, 29, 19),
(403, 15, 30, 20),
(404, 15, 31, 21),
(405, 16, 21, 11),
(406, 16, 23, 12),
(407, 16, 24, 13),
(408, 16, 25, 14),
(409, 16, 26, 15),
(410, 16, 27, 16),
(411, 16, 28, 17),
(412, 16, 39, 18),
(413, 16, 29, 19),
(414, 16, 30, 20),
(415, 16, 31, 21),
(416, 13, 21, 11),
(417, 13, 23, 12),
(418, 13, 24, 13),
(419, 13, 25, 14),
(420, 13, 26, 15),
(421, 13, 27, 16),
(422, 13, 28, 17),
(423, 13, 39, 18),
(424, 13, 29, 19),
(425, 13, 30, 20),
(426, 13, 31, 21),
(427, 23, 21, 11),
(428, 23, 23, 12),
(429, 23, 24, 13),
(430, 23, 25, 14),
(431, 23, 26, 15),
(432, 23, 27, 16),
(433, 23, 28, 17),
(434, 23, 39, 18),
(435, 23, 29, 19),
(436, 23, 30, 20),
(437, 23, 31, 21),
(438, 27, 21, 11),
(439, 27, 23, 12),
(440, 27, 24, 13),
(441, 27, 25, 14),
(442, 17, 21, 11),
(443, 27, 26, 15),
(444, 17, 23, 12),
(445, 27, 27, 16),
(446, 17, 24, 13),
(447, 27, 28, 17),
(448, 17, 25, 14),
(449, 27, 39, 18),
(450, 17, 26, 15),
(451, 27, 29, 19),
(452, 17, 27, 16),
(453, 27, 30, 20),
(454, 17, 28, 17),
(455, 27, 31, 21),
(456, 17, 39, 18),
(457, 17, 29, 19),
(458, 17, 30, 20),
(459, 17, 31, 21),
(460, 21, 21, 11),
(461, 21, 23, 12),
(462, 21, 24, 13),
(463, 21, 25, 14),
(464, 21, 26, 15),
(465, 21, 27, 16),
(466, 21, 28, 17),
(467, 21, 39, 18),
(468, 21, 29, 19),
(469, 21, 30, 20),
(470, 21, 31, 21),
(471, 14, 21, 11),
(472, 14, 23, 12),
(473, 14, 24, 13),
(474, 14, 25, 14),
(475, 14, 26, 15),
(476, 14, 27, 16),
(477, 14, 28, 17),
(478, 14, 39, 18),
(479, 14, 29, 19),
(480, 14, 30, 20),
(481, 14, 31, 21),
(482, 30, 21, 11),
(483, 30, 23, 12),
(484, 30, 24, 13),
(485, 30, 25, 14),
(486, 30, 26, 15),
(487, 19, 21, 11),
(488, 30, 27, 16),
(489, 19, 23, 12),
(490, 30, 28, 17),
(491, 19, 24, 13),
(492, 30, 39, 18),
(493, 19, 25, 14),
(494, 30, 29, 19),
(495, 19, 26, 15),
(496, 30, 30, 20),
(497, 19, 27, 16),
(498, 30, 31, 21),
(499, 19, 28, 17),
(500, 19, 39, 18),
(501, 19, 29, 19),
(502, 19, 30, 20),
(503, 19, 31, 21),
(504, 11, 21, 11),
(505, 11, 23, 12),
(506, 11, 24, 13),
(507, 11, 25, 14),
(508, 11, 26, 15),
(509, 11, 27, 16),
(510, 11, 28, 17),
(511, 11, 39, 18),
(512, 11, 29, 19),
(513, 11, 30, 20),
(514, 11, 31, 21),
(515, 26, 21, 11),
(516, 26, 23, 12),
(517, 26, 24, 13),
(518, 26, 25, 14),
(519, 26, 26, 15),
(520, 26, 27, 16),
(521, 26, 28, 17),
(522, 26, 39, 18),
(523, 26, 29, 19),
(524, 26, 30, 20),
(525, 26, 31, 21),
(526, 28, 21, 11),
(527, 28, 23, 12),
(528, 28, 24, 13),
(529, 29, 21, 11),
(530, 28, 25, 14),
(531, 29, 23, 12),
(532, 28, 26, 15),
(533, 29, 24, 13),
(534, 28, 27, 16),
(535, 29, 25, 14),
(536, 28, 28, 17),
(537, 29, 26, 15),
(538, 28, 39, 18),
(539, 29, 28, 17),
(540, 28, 29, 19),
(541, 29, 39, 18),
(542, 28, 30, 20),
(543, 29, 29, 19),
(544, 28, 31, 21),
(545, 29, 30, 20),
(546, 29, 31, 21),
(547, 25, 21, 11),
(548, 25, 23, 12),
(549, 25, 24, 13),
(550, 25, 25, 14),
(551, 25, 26, 15),
(552, 25, 27, 16),
(553, 25, 28, 17),
(554, 25, 29, 19),
(555, 24, 21, 11),
(556, 24, 23, 12),
(557, 24, 24, 13),
(558, 24, 25, 14),
(559, 24, 26, 15),
(560, 24, 27, 16),
(561, 24, 28, 17),
(562, 24, 39, 18),
(563, 24, 29, 19),
(564, 24, 30, 20),
(565, 24, 31, 21),
(566, 31, 21, 11),
(567, 31, 23, 12),
(568, 31, 24, 13),
(569, 31, 25, 14),
(570, 31, 26, 15),
(571, 31, 27, 16),
(572, 31, 28, 17),
(573, 31, 39, 18),
(574, 31, 29, 19),
(575, 31, 30, 20),
(576, 31, 31, 21),
(577, 20, 21, 11),
(578, 20, 23, 12),
(579, 20, 24, 13),
(580, 20, 25, 14),
(581, 20, 26, 15),
(582, 20, 27, 16),
(583, 20, 28, 17),
(584, 20, 39, 18),
(585, 20, 29, 19),
(586, 20, 30, 20),
(587, 20, 31, 21),
(588, 18, 21, 11),
(589, 18, 23, 12),
(590, 18, 24, 13),
(591, 18, 25, 14),
(592, 18, 26, 15),
(593, 18, 27, 16),
(594, 18, 28, 17),
(595, 18, 39, 18),
(596, 18, 29, 19),
(597, 18, 30, 20),
(598, 18, 31, 21),
(599, 12, 21, 11),
(600, 12, 23, 12),
(601, 12, 24, 13),
(602, 12, 25, 14),
(603, 12, 26, 15),
(604, 12, 27, 16),
(605, 12, 28, 17),
(606, 12, 39, 18),
(607, 12, 29, 19),
(608, 12, 30, 20),
(609, 12, 31, 21),
(610, 32, 21, 11),
(611, 32, 23, 12),
(612, 32, 24, 13),
(613, 32, 25, 14),
(614, 32, 26, 15),
(615, 32, 27, 16),
(616, 32, 28, 17),
(617, 32, 29, 19),
(618, 32, 30, 20),
(619, 32, 31, 21);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=620;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
