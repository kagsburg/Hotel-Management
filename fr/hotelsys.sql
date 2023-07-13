-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2017 at 07:06 PM
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
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullnames` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `img` varchar(4) NOT NULL,
  `level` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `fullnames`, `username`, `password`, `email`, `img`, `level`, `status`) VALUES
(5, 'leave sys hr', 'mkula admin', '3ed8447b1e527b071b0079c3c1b771ed', 'andymawanda@gmail.com', 'jpg', 1, 1),
(8, 'content creator', 'contentcreator', '3ed8447b1e527b071b0079c3c1b771ed', 'contentcreator@gmail.com', 'jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `announcement_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `department_id` int(11) NOT NULL,
  `announcement` mediumtext NOT NULL,
  `viewed` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`announcement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `department_id`, `announcement`, `viewed`, `status`) VALUES
(1, 'The New company Policy for the pharmacy', 2, '<h2><u>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut</u></h2>\n\n<p>labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n\n<p>Curabitur pretium tincidunt lacus. Nulla gravida orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna nisl, mollis quis, molestie eu, feugiat in, orci. In hac habitasse platea dictumst.</p>\n', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `attendance_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `workingday_id` int(11) NOT NULL,
  `checkin` varchar(50) NOT NULL,
  `checkout` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`attendance_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendance_id`, `employee_id`, `workingday_id`, `checkin`, `checkout`, `status`) VALUES
(1, 2, 2, '09:30 AM', '02:30 PM', 0),
(2, 3, 2, '10:34 AM', '04:52 PM', 0),
(3, 3, 4, '11:15 AM', '05:04 PM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `barorders`
--

CREATE TABLE IF NOT EXISTS `barorders` (
  `barorder_id` int(11) NOT NULL AUTO_INCREMENT,
  `guest` int(11) NOT NULL,
  `table` varchar(100) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`barorder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `barorders`
--

INSERT INTO `barorders` (`barorder_id`, `guest`, `table`, `timestamp`, `creator`, `status`) VALUES
(10, 12, '13', 1485869275, 1, 1),
(11, 0, '3', 1486840637, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `barorder_drinks`
--

CREATE TABLE IF NOT EXISTS `barorder_drinks` (
  `drinkorder_id` int(11) NOT NULL AUTO_INCREMENT,
  `barorder_id` int(11) NOT NULL,
  `drink_id` int(11) NOT NULL,
  `charge` int(11) NOT NULL,
  `items` int(11) NOT NULL,
  `baround_id` int(11) NOT NULL,
  PRIMARY KEY (`drinkorder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `barorder_drinks`
--

INSERT INTO `barorder_drinks` (`drinkorder_id`, `barorder_id`, `drink_id`, `charge`, `items`, `baround_id`) VALUES
(20, 10, 3, 34000, 2, 1),
(21, 10, 2, 2500, 2, 1),
(22, 10, 3, 34000, 4, 2),
(23, 11, 3, 34000, 2, 3),
(24, 11, 2, 2500, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `barounds`
--

CREATE TABLE IF NOT EXISTS `barounds` (
  `baround_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `instructions` varchar(1000) NOT NULL,
  `attendant` varchar(100) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`baround_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `barounds`
--

INSERT INTO `barounds` (`baround_id`, `order_id`, `instructions`, `attendant`, `timestamp`) VALUES
(1, 10, 'Cold with some ice', 'Martha linda', 1485869275),
(2, 10, 'It has to be warm', 'mukisa', 1485870891),
(3, 11, '', 'Kenny', 1486840637);

-- --------------------------------------------------------

--
-- Table structure for table `barpayments`
--

CREATE TABLE IF NOT EXISTS `barpayments` (
  `barpayment_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`barpayment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `barpayments`
--

INSERT INTO `barpayments` (`barpayment_id`, `order_id`, `amount`, `creator`, `timestamp`) VALUES
(1, 11, 3000, 8, 1486842018),
(2, 11, 10000, 8, 1486940400);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`, `status`) VALUES
(1, 'employee monthly reports', 1);

-- --------------------------------------------------------

--
-- Table structure for table `checkoutdetails`
--

CREATE TABLE IF NOT EXISTS `checkoutdetails` (
  `checkoutdetails_id` int(11) NOT NULL AUTO_INCREMENT,
  `reserve_id` int(11) NOT NULL,
  `paidamount` int(11) NOT NULL,
  `totalbill` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`checkoutdetails_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `checkoutdetails`
--

INSERT INTO `checkoutdetails` (`checkoutdetails_id`, `reserve_id`, `paidamount`, `totalbill`, `timestamp`) VALUES
(4, 12, 409500, 1409500, 1486994142);

-- --------------------------------------------------------

--
-- Table structure for table `checkoutpayments`
--

CREATE TABLE IF NOT EXISTS `checkoutpayments` (
  `checkoutpayment_id` int(11) NOT NULL AUTO_INCREMENT,
  `checkout_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`checkoutpayment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `checkoutpayments`
--

INSERT INTO `checkoutpayments` (`checkoutpayment_id`, `checkout_id`, `amount`, `timestamp`) VALUES
(2, 4, 200000, 1486994142),
(3, 4, 209500, 1486994244);

-- --------------------------------------------------------

--
-- Table structure for table `costs`
--

CREATE TABLE IF NOT EXISTS `costs` (
  `cost_id` int(11) NOT NULL AUTO_INCREMENT,
  `cost_item` varchar(500) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`cost_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `costs`
--

INSERT INTO `costs` (`cost_id`, `cost_item`, `amount`, `date`, `creator`, `status`) VALUES
(1, 'Bath Tab Replacement in Room 234c', 345000, 1456786800, 1, 1),
(2, 'Replacing Tiles in Room 3456g', 234000, 1457823600, 1, 1),
(3, 'adding more drinks', 100000, 1460498400, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cylinders`
--

CREATE TABLE IF NOT EXISTS `cylinders` (
  `cylinder_id` int(11) NOT NULL AUTO_INCREMENT,
  `cylinder_type` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`cylinder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `cylinders`
--

INSERT INTO `cylinders` (`cylinder_id`, `cylinder_type`, `price`, `quantity`, `status`) VALUES
(1, '6kg Cylinder', 80000, 12, 1),
(2, '10kg Cylinder', 130000, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cylindersales`
--

CREATE TABLE IF NOT EXISTS `cylindersales` (
  `cylindersale_id` int(11) NOT NULL AUTO_INCREMENT,
  `cylinder_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`cylindersale_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `cylindersales`
--

INSERT INTO `cylindersales` (`cylindersale_id`, `cylinder_id`, `price`, `creator`, `timestamp`, `status`) VALUES
(8, 1, 80000, 1, 1460369478, 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department`, `status`) VALUES
(6, 'Reception', 1),
(7, 'Restaurant', 1);

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE IF NOT EXISTS `designations` (
  `designation_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`designation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `designations`
--

INSERT INTO `designations` (`designation_id`, `department_id`, `designation`, `status`) VALUES
(14, 6, 'Receptionist', 1),
(15, 6, 'Front Officer', 1);

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `docname` varchar(100) NOT NULL,
  `ext` varchar(5) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `cat_id`, `docname`, `ext`, `slug`, `status`) VALUES
(1, 1, 'August monthly report', 'docx', 'August monthly report_1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `drinkorders`
--

CREATE TABLE IF NOT EXISTS `drinkorders` (
  `drinkorder_id` int(11) NOT NULL AUTO_INCREMENT,
  `drink` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`drinkorder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `drinkorders`
--

INSERT INTO `drinkorders` (`drinkorder_id`, `drink`, `price`, `quantity`, `timestamp`, `creator`, `status`) VALUES
(3, 3, 34000, 2, 1457866946, 1, 1),
(4, 2, 7500, 3, 1457942243, 1, 1),
(5, 2, 5000, 2, 1457951390, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `drinks`
--

CREATE TABLE IF NOT EXISTS `drinks` (
  `drink_id` int(11) NOT NULL AUTO_INCREMENT,
  `drinkname` varchar(100) NOT NULL,
  `drinkprice` int(11) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`drink_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `drinks`
--

INSERT INTO `drinks` (`drink_id`, `drinkname`, `drinkprice`, `quantity`, `type`, `creator`, `status`) VALUES
(1, 'Soda', 4500, '1 litre', 'rest', 1, 1),
(2, 'Soda', 2500, '500ml', 'bar', 1, 1),
(3, 'Club Beer', 34000, '500ml', 'bar', 1, 1),
(4, 'Lemon Juice', 4500, 'glass', 'rest', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE IF NOT EXISTS `employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `ext` varchar(4) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `salary` int(11) NOT NULL,
  `start_date` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `fullname`, `gender`, `phone`, `email`, `ext`, `designation`, `salary`, `start_date`, `status`) VALUES
(8, 'Kitimbo Patrick', 'Male', '07684847328', 'kirabo@gmail.com', 'jpg', '14', 45000, 1420066800, 1),
(9, 'Mukisa Simon', 'Male', '077938475827', 'mukisa@gmail.com', 'jpg', '14', 2000000, 1391554800, 1);

-- --------------------------------------------------------

--
-- Table structure for table `employee_accounts`
--

CREATE TABLE IF NOT EXISTS `employee_accounts` (
  `activation_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `employeecode` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `cvext` varchar(5) NOT NULL,
  `imgext` varchar(4) NOT NULL,
  `level` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`activation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `employee_accounts`
--

INSERT INTO `employee_accounts` (`activation_id`, `employee_id`, `employeecode`, `password`, `cvext`, `imgext`, `level`, `status`) VALUES
(5, 3, 'mkula3', '3ed8447b1e527b071b0079c3c1b771ed', 'docx', 'jpg', 1, 1),
(6, 4, 'mkula4', '3ed8447b1e527b071b0079c3c1b771ed', 'docx', 'jpg', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gardenreservations`
--

CREATE TABLE IF NOT EXISTS `gardenreservations` (
  `gardenreservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(250) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `id_number` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `checkin` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`gardenreservation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gardenreservations`
--

INSERT INTO `gardenreservations` (`gardenreservation_id`, `fullname`, `phone`, `email`, `id_number`, `country`, `checkin`, `timestamp`, `creator`, `status`) VALUES
(4, 'Mukisa Samson', '07793847550', 'mukisa@gmail.com', '344i4i4i', 'Congo', 1457564400, 1457791804, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hallreservations`
--

CREATE TABLE IF NOT EXISTS `hallreservations` (
  `hallreservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(250) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `people` varchar(100) NOT NULL,
  `purpose` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `checkin` int(11) NOT NULL,
  `checkout` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`hallreservation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `hallreservations`
--

INSERT INTO `hallreservations` (`hallreservation_id`, `fullname`, `phone`, `people`, `purpose`, `country`, `checkin`, `checkout`, `description`, `timestamp`, `creator`, `status`) VALUES
(6, 'Salongo Musa', '07793847583', '22', 'breakfast', 'Uganda', 1485903600, 1486681200, 'We shall be having lunch there', 1486907183, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `laundry`
--

CREATE TABLE IF NOT EXISTS `laundry` (
  `laundry_id` int(11) NOT NULL AUTO_INCREMENT,
  `reserve_id` int(11) NOT NULL,
  `clothes` int(11) NOT NULL,
  `charge` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`laundry_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `laundry`
--

INSERT INTO `laundry` (`laundry_id`, `reserve_id`, `clothes`, `charge`, `creator`, `timestamp`, `status`) VALUES
(1, 8, 10, 20000, 1, 1485107080, 1),
(2, 8, 4, 10000, 1, 1484175600, 1),
(3, 12, 12, 20000, 1, 1486767600, 1);

-- --------------------------------------------------------

--
-- Table structure for table `leaves`
--

CREATE TABLE IF NOT EXISTS `leaves` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `dutyresume` int(11) NOT NULL,
  `awaycontact` varchar(100) NOT NULL,
  `file_ext` varchar(5) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `headapproval` int(11) NOT NULL,
  `hrapproval` int(11) NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `leaves`
--

INSERT INTO `leaves` (`leave_id`, `employee_id`, `startdate`, `enddate`, `type`, `dutyresume`, `awaycontact`, `file_ext`, `timestamp`, `headapproval`, `hrapproval`) VALUES
(10, 5, 1447196400, 1448578800, 'Sick Leave', 1448492400, '066948448', 'docx', 1448792849, 3, 0),
(11, 5, 1449702000, 1451084400, 'R & R Leave', 1451516400, '0774586737', '', 1449477311, 1, 0),
(12, 5, 1450911600, 1453330800, 'R & R Leave', 1453417200, '0779282818', '', 1450254786, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE IF NOT EXISTS `menuitems` (
  `menuitem_id` int(11) NOT NULL AUTO_INCREMENT,
  `menuitem` varchar(100) NOT NULL,
  `itemprice` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`menuitem_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `menuitems`
--

INSERT INTO `menuitems` (`menuitem_id`, `menuitem`, `itemprice`, `menu`, `creator`, `status`) VALUES
(1, 'Chips Plain', 25000, 1, 1, 1),
(2, 'Whole Chicken', 50000, 1, 1, 1),
(3, 'half pilao', 2000, 1, 1, 1),
(4, 'Pizza', 20000, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(100) NOT NULL,
  `message` mediumtext NOT NULL,
  `sender_id` int(11) NOT NULL,
  `reciever_id` int(11) NOT NULL,
  `sender_status` int(11) NOT NULL,
  `reciever_status` int(11) NOT NULL,
  `sender_level` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `subject`, `message`, `sender_id`, `reciever_id`, `sender_status`, `reciever_status`, `sender_level`, `timestamp`) VALUES
(4, 'how are you doing', 'I was saying that how are u doing<br>', 5, 3, 1, 1, 1, 1443348327),
(5, 'how are you doing', 'I was saying that how are u doing<br>', 5, 2, 1, 1, 1, 1443348327);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `notification` varchar(500) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `notification`, `leave_id`, `employee_id`, `timestamp`, `type`, `status`) VALUES
(1, 'Your Leave Request has been Approved', 10, 5, 1449407641, 1, 1),
(4, 'Your Leave Request Has Been Turned Down', 10, 5, 1449471385, 0, 1),
(5, 'Your Leave Request Has Been Turned Down', 10, 5, 1449474040, 0, 1),
(6, 'Your Leave Request has been Approved', 11, 5, 1449477355, 1, 1),
(7, 'Your Leave Request has been Approved', 11, 5, 1449477863, 1, 1),
(8, 'Your Leave Request Has Been Turned Down', 12, 5, 1450259316, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `guest` int(11) NOT NULL,
  `table` varchar(50) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `guest`, `table`, `timestamp`, `creator`, `status`) VALUES
(11, 12, '12', 1485852946, 1, 1),
(12, 12, '12', 1486810735, 1, 1),
(13, 0, '5', 1486834006, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

CREATE TABLE IF NOT EXISTS `reasons` (
  `reason_id` int(11) NOT NULL AUTO_INCREMENT,
  `leave_id` int(11) NOT NULL,
  `reason` varchar(1000) NOT NULL,
  PRIMARY KEY (`reason_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `reasons`
--

INSERT INTO `reasons` (`reason_id`, `leave_id`, `reason`) VALUES
(1, 10, 'its because i hate you'),
(2, 10, 'You need to first Accomplish the task ahead'),
(3, 12, 'Its because you still have work to do');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `room` varchar(20) NOT NULL,
  `checkin` int(11) NOT NULL,
  `checkout` int(11) NOT NULL,
  `actualcheckout` int(11) NOT NULL,
  `guests` int(11) NOT NULL,
  `paidby` varchar(50) NOT NULL,
  `orgname` varchar(100) NOT NULL,
  `orgcontact` varchar(50) NOT NULL,
  `creator` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`reservation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`reservation_id`, `firstname`, `lastname`, `phone`, `email`, `country`, `room`, `checkin`, `checkout`, `actualcheckout`, `guests`, `paidby`, `orgname`, `orgcontact`, `creator`, `timestamp`, `status`) VALUES
(7, 'Abisai', 'Kirabira', '07793847550', '', 'Germany', '2', 1456873200, 1458342000, 0, 0, '', '', '', 1, 1457775005, 2),
(8, 'Sun', 'Li', '07793847583', '', 'China', '2', 1483311600, 1486508400, 0, 2, 'organisation', 'World Health organisation', '0779282837', 1, 1460286134, 1),
(10, 'andy', 'mawanda', '0779282838', 'amawizzy@gmail.com', 'Uganda', '1', 1454626800, 1470348000, 0, 0, '', '', '', 1, 1461936396, 3),
(11, 'reserv', 'reserv', '059694498392', 'amawieur@gmail.com', 'Uganda', '2', 1465596000, 1487372400, 0, 2, '', '', '', 1, 1462523133, 0),
(12, 'Keza', 'silasi', '0784873827', 'kirabo@gmail.com', 'Uganda', '1', 1483311600, 1486854000, 1486681200, 1, 'individual', '', '', 8, 1485162977, 2);

-- --------------------------------------------------------

--
-- Table structure for table `restaurantorders`
--

CREATE TABLE IF NOT EXISTS `restaurantorders` (
  `restorder_id` int(11) NOT NULL AUTO_INCREMENT,
  `food_id` int(11) NOT NULL,
  `foodprice` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `order_id` int(11) NOT NULL,
  `restround_id` int(11) NOT NULL,
  PRIMARY KEY (`restorder_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

--
-- Dumping data for table `restaurantorders`
--

INSERT INTO `restaurantorders` (`restorder_id`, `food_id`, `foodprice`, `quantity`, `type`, `order_id`, `restround_id`) VALUES
(30, 1, 25000, 2, 'food', 11, 3),
(31, 3, 2000, 2, 'food', 11, 3),
(34, 4, 4500, 2, 'drink', 11, 3),
(37, 4, 20000, 1, 'food', 11, 4),
(39, 1, 4500, 1, 'drink', 11, 4),
(43, 4, 4500, 1, 'drink', 11, 5),
(45, 1, 25000, 1, 'food', 12, 6),
(46, 2, 50000, 1, 'food', 12, 6),
(49, 4, 4500, 1, 'drink', 12, 6),
(51, 1, 25000, 1, 'food', 13, 7),
(53, 4, 20000, 1, 'food', 13, 7),
(55, 1, 4500, 1, 'drink', 13, 7);

-- --------------------------------------------------------

--
-- Table structure for table `restpayments`
--

CREATE TABLE IF NOT EXISTS `restpayments` (
  `restpayment_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`restpayment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `restpayments`
--

INSERT INTO `restpayments` (`restpayment_id`, `order_id`, `amount`, `creator`, `timestamp`) VALUES
(1, 13, 9500, 1, 1486836133),
(2, 13, 10000, 1, 1486836220),
(3, 13, 10000, 1, 1486767600);

-- --------------------------------------------------------

--
-- Table structure for table `restrounds`
--

CREATE TABLE IF NOT EXISTS `restrounds` (
  `restround_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `instructions` varchar(1000) NOT NULL,
  `waiter` varchar(100) NOT NULL,
  `timtestamp` int(11) NOT NULL,
  PRIMARY KEY (`restround_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `restrounds`
--

INSERT INTO `restrounds` (`restround_id`, `order_id`, `instructions`, `waiter`, `timtestamp`) VALUES
(3, 11, 'Juice must be cold and bring some tomato sauce', 'Nakanwagi Winnie', 1485852946),
(4, 11, '', 'Moses', 1485865976),
(5, 11, '', 'Nakazzi Martha', 1486663054),
(6, 12, '', 'Mukisa simon', 1486810735),
(7, 13, 'Bring along with glasses', 'mugisha nathan', 1486834007);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` int(11) NOT NULL AUTO_INCREMENT,
  `roomnumber` varchar(30) NOT NULL,
  `type` int(11) NOT NULL,
  `creator` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `roomnumber`, `type`, `creator`, `status`) VALUES
(1, 'C3495', 3, 1, 1),
(2, '345B', 5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roomtypes`
--

CREATE TABLE IF NOT EXISTS `roomtypes` (
  `roomtype_id` int(11) NOT NULL AUTO_INCREMENT,
  `roomtype` varchar(50) NOT NULL,
  `charge` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`roomtype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `roomtypes`
--

INSERT INTO `roomtypes` (`roomtype_id`, `roomtype`, `charge`, `status`) VALUES
(3, 'Deluxe', 50000, 1),
(4, 'Executive Wing', 34500, 1),
(5, 'Deluxe Double', 145000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE IF NOT EXISTS `salaries` (
  `salary_id` int(11) NOT NULL AUTO_INCREMENT,
  `designation_id` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`salary_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`salary_id`, `designation_id`, `salary`, `status`) VALUES
(6, 7, 650000, 1),
(7, 8, 230000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sitereserves`
--

CREATE TABLE IF NOT EXISTS `sitereserves` (
  `reserve_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `number` varchar(80) NOT NULL,
  `type` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `checkin` int(11) NOT NULL,
  `checkout` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`reserve_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `stockmeasurements`
--

CREATE TABLE IF NOT EXISTS `stockmeasurements` (
  `measurement_id` int(11) NOT NULL AUTO_INCREMENT,
  `measurement` varchar(200) NOT NULL,
  PRIMARY KEY (`measurement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stockmeasurements`
--

INSERT INTO `stockmeasurements` (`measurement_id`, `measurement`) VALUES
(1, 'Kg'),
(2, 'Sacks'),
(3, 'Crates');

-- --------------------------------------------------------

--
-- Table structure for table `stock_items`
--

CREATE TABLE IF NOT EXISTS `stock_items` (
  `stockitem_id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_item` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `measurement` varchar(50) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`stockitem_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `stock_items`
--

INSERT INTO `stock_items` (`stockitem_id`, `stock_item`, `quantity`, `measurement`, `status`) VALUES
(1, 'Rice', 9, '2', 1),
(2, 'Sodas', 18, '3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `temp`
--

CREATE TABLE IF NOT EXISTS `temp` (
  `temp_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `code` varchar(100) NOT NULL,
  PRIMARY KEY (`temp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `employee` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `level` int(1) NOT NULL,
  `status` int(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `employee`, `username`, `password`, `role`, `level`, `status`) VALUES
(1, 8, 'andymawanda', '3ed8447b1e527b071b0079c3c1b771ed', 'manager', 1, 1),
(18, 9, 'receptionist', '0a9b3767c8b9b69cea129110e8daeda2', 'Receptionist', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `workingdays`
--

CREATE TABLE IF NOT EXISTS `workingdays` (
  `workingday_id` int(11) NOT NULL AUTO_INCREMENT,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`workingday_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `workingdays`
--

INSERT INTO `workingdays` (`workingday_id`, `date`) VALUES
(2, 1439251200),
(4, 1441843200),
(5, 1438992000);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
