-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 01, 2012 at 04:15 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jcpbadges`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_items`
--

CREATE TABLE IF NOT EXISTS `ci_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item_type` tinyint(4) NOT NULL,
  `item_img` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `item_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `ci_items`
--

INSERT INTO `ci_items` (`item_id`, `item_name`, `item_type`, `item_img`, `item_status`) VALUES
(1, 'name only', 1, 'medias/images/items/white-name.png', 1),
(2, 'name w/ title', 2, 'medias/images/items/white-nametitle.png', 1),
(3, 'generic (no name)', 3, 'medias/images/items/white-csr.png', 1),
(4, 'silver, name only', 1, 'medias/images/items/silver-name.png', 0),
(5, 'silver, name & title', 2, 'medias/images/items/silver-nametitle.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ci_orders`
--

CREATE TABLE IF NOT EXISTS `ci_orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `order_shipping` text COLLATE utf8_unicode_ci NOT NULL,
  `order_total` int(11) NOT NULL,
  `order_items` text COLLATE utf8_unicode_ci NOT NULL,
  `order_date` int(11) NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ci_orders`
--

INSERT INTO `ci_orders` (`order_id`, `store_id`, `order_shipping`, `order_total`, `order_items`, `order_date`) VALUES
(9, 1, 'a:5:{s:4:"attn";s:9:"jony tri ";s:7:"address";s:18:"821 N Central Expy";s:4:"city";s:5:"Plano";s:5:"state";s:2:"TX";s:3:"zip";s:5:"75075";}', 1, 'a:1:{i:0;a:5:{s:5:"style";s:19:"white, name & title";s:6:"itemId";s:1:"2";s:4:"name";s:5:"asdkf";s:5:"title";s:7:"aklsdfj";s:8:"fastener";i:1;}}', 1343621227),
(10, 1, 'a:5:{s:4:"attn";s:3:"abc";s:7:"address";s:18:"821 N Central Expy";s:4:"city";s:5:"Plano";s:5:"state";s:2:"TX";s:3:"zip";s:5:"75075";}', 1, 'a:1:{i:0;a:4:{s:5:"style";s:16:"white, name only";s:6:"itemId";s:1:"1";s:4:"name";s:4:"asdf";s:8:"fastener";i:1;}}', 1343622911),
(11, 1, 'a:5:{s:4:"attn";s:3:"abc";s:7:"address";s:18:"821 N Central Expy";s:4:"city";s:5:"Plano";s:5:"state";s:2:"TX";s:3:"zip";s:5:"75075";}', 3, 'a:3:{i:0;a:5:{s:5:"style";s:9:"name only";s:6:"itemId";s:1:"1";s:4:"name";s:0:"";s:8:"fastener";s:8:"Magnetic";s:11:"spk_spanish";s:2:"No";}i:1;a:6:{s:5:"style";s:13:"name w/ title";s:6:"itemId";s:1:"2";s:4:"name";s:6:"asdfdf";s:5:"title";s:11:"lead expert";s:8:"fastener";s:8:"Magnetic";s:11:"spk_spanish";s:2:"No";}i:2;a:6:{s:5:"style";s:13:"name w/ title";s:6:"itemId";s:1:"2";s:4:"name";s:7:"asdfsdf";s:5:"title";s:25:"licensed optician manager";s:8:"fastener";s:8:"Magnetic";s:11:"spk_spanish";s:2:"No";}}', 1343746836);

-- --------------------------------------------------------

--
-- Table structure for table `ci_stores`
--

CREATE TABLE IF NOT EXISTS `ci_stores` (
  `store_id` int(11) NOT NULL AUTO_INCREMENT,
  `store_number` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `store_password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `store_attn` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `store_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_city` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `store_state` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `store_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ci_stores`
--

INSERT INTO `ci_stores` (`store_id`, `store_number`, `store_password`, `store_attn`, `store_address`, `store_city`, `store_state`, `store_zip`) VALUES
(1, '1000', '006b683484a324d8aa6f37bbd7bbfbbe', 'abc', '821 N Central Expy', 'Plano', 'TX', '75075');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
