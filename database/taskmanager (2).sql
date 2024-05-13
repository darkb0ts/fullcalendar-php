-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2024 at 08:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `timebase_sys`
--

-- --------------------------------------------------------

--
-- Table structure for table `taskmanager`
--

CREATE TABLE `taskmanager` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `notallowed` date NOT NULL,
  `timing` time NOT NULL,
  `colour` varchar(30) NOT NULL,
  `audio` varchar(250) NOT NULL,
  `audioname` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `taskmanager`
--

INSERT INTO `taskmanager` (`id`, `event_id`, `message`, `startdate`, `enddate`, `notallowed`, `timing`, `colour`, `audio`, `audioname`) VALUES
(277, 6, 'prasanna', '2024-09-07', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(278, 6, 'prasanna', '2024-09-08', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(279, 6, 'prasanna', '2024-09-09', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(280, 6, 'prasanna', '2024-09-10', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(281, 6, 'prasanna', '2024-09-11', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(282, 6, 'prasanna', '2024-09-12', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(283, 6, 'prasanna', '2024-09-13', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(284, 6, 'prasanna', '2024-09-14', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(285, 6, 'prasanna', '2024-09-15', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(286, 6, 'prasanna', '2024-09-16', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(287, 6, 'prasanna', '2024-09-17', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(288, 6, 'prasanna', '2024-09-18', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(289, 6, 'prasanna', '2024-09-19', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(290, 6, 'prasanna', '2024-09-20', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(291, 6, 'prasanna', '2024-09-21', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(292, 6, 'prasanna', '2024-09-22', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(293, 6, 'prasanna', '2024-09-23', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(294, 6, 'prasanna', '2024-09-24', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(295, 6, 'prasanna', '2024-09-25', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(296, 6, 'prasanna', '2024-09-26', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(297, 6, 'prasanna', '2024-09-27', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(298, 6, 'prasanna', '2024-09-28', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(299, 6, 'prasanna', '2024-09-29', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(300, 6, 'prasanna', '2024-09-30', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(301, 6, 'prasanna', '2024-10-01', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(302, 6, 'prasanna', '2024-10-02', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(303, 6, 'prasanna', '2024-10-03', '2024-10-03', '0000-00-00', '05:18:00', '#00c281', 'upload/663a06e1adcdc.mp3', 'satranga.mp3'),
(304, 7, 'prasanna', '2024-05-27', '2024-05-27', '0000-00-00', '05:20:00', '#4324b2', 'upload/663a0763be31f.mp3', 'satranga.mp3'),
(331, 8, 'gukesh', '2024-05-07', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(332, 8, 'gukesh', '2024-05-08', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(333, 8, 'gukesh', '2024-05-09', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(334, 8, 'gukesh', '2024-05-10', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(335, 8, 'gukesh', '2024-05-11', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(336, 8, 'gukesh', '2024-05-12', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(337, 8, 'gukesh', '2024-05-13', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(338, 8, 'gukesh', '2024-05-14', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(340, 8, 'gukesh', '2024-05-17', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(342, 8, 'gukesh', '2024-05-19', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(343, 8, 'gukesh', '2024-05-20', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(345, 8, 'gukesh', '2024-05-22', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(346, 8, 'gukesh', '2024-05-23', '2024-05-31', '2024-05-15', '00:02:00', '#98c814', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(348, 8, 'gukesh', '2024-05-25', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(349, 8, 'gukesh', '2024-05-26', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(350, 8, 'gukesh', '2024-05-27', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(351, 8, 'gukesh', '2024-05-28', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(352, 8, 'gukesh', '2024-05-29', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(353, 8, 'gukesh', '2024-05-30', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3'),
(354, 8, 'gukesh', '2024-05-31', '2024-05-31', '2024-05-15', '22:00:00', '#17de6d', 'upload/663a1e5f2a52d.mp3', 'gulabi_sadi.mp3');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `taskmanager`
--
ALTER TABLE `taskmanager`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `taskmanager`
--
ALTER TABLE `taskmanager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
