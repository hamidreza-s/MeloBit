-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2012 at 10:45 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `page_id`, `link`, `position`, `access_level`) VALUES
(1, 'Contact', 0, '/contact', 1, 'public');


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`customer_id` int(11) NOT NULL,
	`sms_content` varchar(200) NOT NULL,
	`order_date` int(11) NOT NULL,
	`test_phone`  varchar(25) DEFAULT NULL,
	`order_status` boolean NOT NULL DEFAULT 0,
	`control_status`  boolean NOT NULL DEFAULT 0,
	`dispatch_status` boolean NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

CREATE TABLE IF NOT EXISTS `destinations` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`order_id` int(11) NOT NULL,
	`destination_type` varchar(25) NOT NULL,
	`destination_value` text NOT NULL,
	`dispatch_date` int(11) NOT NULL,
	`destinations_quantity` int(11) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

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
	`deposit_fee`  int(15) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `field`) VALUES
(1, 'none', 'none');







