-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2017 at 06:31 PM
-- Server version: 5.6.17-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mobileeg_maindb`
--

-- --------------------------------------------------------

--
-- Table structure for table `phonebook`
--

CREATE TABLE IF NOT EXISTS `phonebook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8 NOT NULL,
  `number` varchar(150) CHARACTER SET utf8 NOT NULL,
  `adddate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  `isactive` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `phonebook`
--

INSERT INTO `phonebook` (`id`, `name`, `number`, `adddate`, `updatedate`, `isactive`) VALUES
(1, 'john1', '010000010', '2017-09-07 00:00:00', '0000-00-00 00:00:00', 1),
(2, 'tester2', '012000012', '2017-09-07 00:00:00', '0000-00-00 00:00:00', 1),
(3, 'john2', '010000010', '2017-09-07 00:00:00', '0000-00-00 00:00:00', 1),
(4, 'tester4', '012000012', '2017-09-07 00:00:00', '2017-09-07 02:00:00', 1),
(5, 'samia3', '010000103', '2017-09-07 00:00:00', '0000-00-00 00:00:00', 1),
(6, 'mona4', '012000004', '2017-09-07 00:00:00', '0000-00-00 00:00:00', 0),
(7, 'samia5', '010000103', '2017-09-07 00:00:00', '0000-00-00 00:00:00', 1),
(8, 'mona6', '012000004', '2017-09-07 00:00:00', '0000-00-00 00:00:00', 1),
(9, 'Hany9', '019000009', '2017-09-07 03:00:00', '0000-00-00 00:00:00', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
