-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2017 at 09:35 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hotelsys`
--

-- --------------------------------------------------------

--
-- Table structure for table `hoteltables`
--

CREATE TABLE IF NOT EXISTS `hoteltables` (
  `hoteltable_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` varchar(100) NOT NULL,
  `creator` int(11) NOT NULL,
  `area` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`hoteltable_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `hoteltables`
--

INSERT INTO `hoteltables` (`hoteltable_id`, `table_no`, `creator`, `area`, `status`) VALUES
(1, 'table2', 8, 'rest', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
