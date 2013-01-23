-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 26, 2012 at 02:25 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `armaghan`
--

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE IF NOT EXISTS `bugs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `description` text,
  `priority` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `field` varchar(50) NOT NULL,
  `contact_number_1` varchar(25) DEFAULT NULL,
  `contact_number_2` varchar(25) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `field`, `contact_number_1`, `contact_number_2`, `address`) VALUES
(1, 'N/A', 'N/A', 'N/A', 'N/A', 'N/A'),
(2, 'Ø§ÛŒØ±Ø§Ù† Ø®ÙˆØ¯Ø±Ùˆ', 'N/A', '02148228135', '02148228231', 'ØªÙ‡Ø±Ø§Ù†ØŒ Ú©ÛŒÙ„ÙˆÙ…ØªØ± 14 Ø¬Ø§Ø¯Ù‡ Ù…Ø®ØµÙˆØµØŒ Ø´Ø±Ú©Øª Ø§ÛŒØ±Ø§Ù† Ø®ÙˆØ¯Ø±Ùˆ'),
(3, 'Ø§Ø±Ù…ØºØ§Ù†', 'N/A', '02185657412', '02158456321', 'Ø§ÛŒØ±Ø§Ù†ØŒ ØªÙ‡Ø±Ø§Ù†ØŒ Ù…ÛŒØ¯Ø§Ù† Ø§Ù†Ù‚Ù„Ø§Ø¨ØŒ ØªÙ‚Ø§Ø·Ø¹ ÙÙ„Ø³Ø·ÛŒÙ†'),
(4, 'Ø³Ø§ÛŒÙ¾Ø§', 'N/A', '02145856523', '02148228231', 'Ø§ÛŒØ±Ø§Ù†ØŒ ØªÙ‡Ø±Ø§Ù†ØŒ Ú©ÛŒÙ„ÙˆÙ…ØªØ± 16 Ø¬Ø§Ø¯Ù‡ Ù…Ø®ØµÙˆØµØŒ Ø´Ø±Ú©Øª Ø³Ø§ÛŒÙ¾Ø§');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contact_number_1` varchar(25) DEFAULT NULL,
  `contact_number_2` varchar(25) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `company_id`, `first_name`, `last_name`, `contact_number_1`, `contact_number_2`, `address`) VALUES
(1, 2, 'Ø­Ù…ÛŒØ¯Ø±Ø¶Ø§', 'Ø³Ù„ÛŒÙ…Ø§Ù†ÛŒ', '02148228135', '02148228231', 'Ø§ÛŒØ±Ø§Ù†ØŒ ØªÙ‡Ø±Ø§Ù†ØŒ Ø®ÛŒØ§Ø¨Ø§Ù† Ø³ØªØ§Ø±Ø®Ø§Ù†ØŒ Ø®ÛŒØ§Ø¨Ø§Ù† Ú¯Ù„Ø§Ø¨ØŒ Ú©ÙˆÚ†Ù‡ Ø¨ÛŒØ¯Ú©ÛŒØŒ Ù¾Ù„Ø§Ú© 55'),
(2, 3, 'Ù…Ù‡Ø¯ÛŒ', 'ØµØ§Ù„Ø­ÛŒ', '02145856523', '02158456321', 'Ø§ÛŒØ±Ø§Ù†ØŒ ØªÙ‡Ø±Ø§Ù†ØŒ Ø®ÛŒØ§Ø¨Ø§Ù† Ø§Ù†Ù‚Ù„Ø§Ø¨ØŒ ØªÙ‚Ø§Ø·Ø¹ ÙÙ„Ø³Ø·ÛŒÙ†'),
(5, 4, 'Ø­Ø³ÛŒÙ†', 'Ø­Ø§ÙØ¸ÛŒ', '0214859653', '02145874532', 'Ø§ÛŒØ±Ø§Ù†ØŒ ØªÙ‡Ø±Ø§Ù†ØŒ Ø®ÛŒØ§Ø¨Ø§Ù† Ø¢Ø²Ø§Ø¯ÛŒØŒ Ú©ÙˆÚ†Ù‡ ØµØ§Ù„Ø­ÛŒØŒ Ù¾Ù„Ø§Ú© 5');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE IF NOT EXISTS `destinations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `destination_type` varchar(25) NOT NULL,
  `destination_value` text NOT NULL,
  `destination_order` varchar(25) NOT NULL,
  `destination_start` int(11) NOT NULL,
  `destination_end` int(11) NOT NULL,
  `destination_bulk_id` int(11) DEFAULT 0,
  `dispatch_date` int(11) NOT NULL,
  `destinations_quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `access_level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `page_id`, `link`, `position`, `access_level`) VALUES
(1, 'Contact', 0, '/contact', 1, 'public'),
(2, 'SMS Panel', 0, '/sms', 2, 'public');

-- --------------------------------------------------------

--
-- Table structure for table `menu_items`
--

CREATE TABLE IF NOT EXISTS `menu_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) DEFAULT NULL,
  `label` varchar(50) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `link` varchar(100) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `menu_items`
--

INSERT INTO `menu_items` (`id`, `menu_id`, `label`, `page_id`, `link`, `position`) VALUES
(1, 2, 'List of Companies', 0, '/sms/company', 1),
(2, 2, 'List of Customers', 0, '/sms/customer', 2),
(3, 2, 'List of Orders', 0, '/sms/order', 3);

-- --------------------------------------------------------

--
-- Table structure for table `nodes`
--

CREATE TABLE IF NOT EXISTS `nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) DEFAULT NULL,
  `node` varchar(50) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `nodes`
--

INSERT INTO `nodes` (`id`, `page_id`, `node`, `content`) VALUES
(1, 1, 'headline', NULL),
(2, 1, 'image', NULL),
(3, 1, 'description', NULL),
(4, 1, 'content', NULL),
(5, 1, 'headline_en', 'Test'),
(6, 1, 'image_en', NULL),
(7, 1, 'description_en', '<p>test</p>'),
(8, 1, 'content_en', '<p>test</p>'),
(9, 1, 'headline_fa', 'ØªØ³Øª'),
(10, 1, 'image_fa', NULL),
(11, 1, 'description_fa', '<p>ØªØ³Øª</p>'),
(12, 1, 'content_fa', '<p>ØªØ³Øª</p>');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sms_content` varchar(200) NOT NULL,
  `order_date` int(11) NOT NULL,
  `test_phone` varchar(25) DEFAULT NULL,
  `order_status` tinyint(1) NOT NULL DEFAULT '0',
  `control_status` tinyint(1) NOT NULL DEFAULT '0',
  `dispatch_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `namespace` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date_created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `parent_id`, `namespace`, `name`, `date_created`) VALUES
(1, 0, 'page', 'test', 1356439897);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `receipt_number` varchar(25) NOT NULL,
  `bank_account` varchar(25) NOT NULL,
  `deposit_date` int(11) NOT NULL,
  `depositor_name` varchar(50) NOT NULL,
  `deposit_fee` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `role` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'admin', 'administrator');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
