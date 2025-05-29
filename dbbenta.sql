-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 28, 2025 at 04:10 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbbenta`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cartid` int(11) NOT NULL AUTO_INCREMENT,
  `quantity` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`cartid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `cart`
--


-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryid` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `name`) VALUES
(1, 'Phones'),
(2, 'Laptops'),
(3, 'Headphones'),
(4, 'Gaming'),
(5, 'Cameras'),
(6, 'Wearables');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `itemid` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` int(11) NOT NULL,
  `itemname` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `image` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `categoryid`, `itemname`, `price`, `image`, `quantity`, `description`) VALUES
(1, 1, 'iPhone 15 Pro Max', '65999', 'uploads/p1.jpg', 25, 'Latest iPhone with A17 Pro chip, titanium design, and advanced camera system. Perfect for photography and gaming with 256GB storage.'),
(2, 1, 'Samsung Galaxy S24 Ultra', '62999', 'uploads/p2.jpg', 30, 'Premium Android flagship with S Pen, 200MP camera, and AI features. Built for productivity and creativity with 512GB storage.'),
(3, 1, 'Google Pixel 8 Pro', '45999', 'uploads/p3.jpg', 20, 'Pure Android experience with advanced AI photography and Magic Eraser. Best computational photography in the market.'),
(4, 1, 'OnePlus 12', '38999', 'uploads/p4.jpg', 35, 'Fast charging flagship with Snapdragon 8 Gen 3 and 100W SuperVOOC charging. Perfect balance of performance and price.'),
(5, 1, 'Xiaomi 14 Pro', '34999', 'uploads/p5.jpg', 40, 'Premium specs at affordable price. Leica camera system with 50MP main sensor and 120W wireless charging.'),
(6, 2, 'MacBook Air M3 13-inch', '68999', 'uploads/l1.jpg', 15, 'Ultra-thin laptop with M3 chip and 18-hour battery life. Perfect for students and professionals with 8GB RAM and 256GB SSD.'),
(7, 2, 'ASUS ROG Strix G15', '65999', 'uploads/l2.jpg', 18, 'Gaming laptop with RTX 4060, AMD Ryzen 7, and 144Hz display. Built for high-performance gaming with RGB keyboard.'),
(8, 3, 'Sony WH-1000XM5', '18999', 'uploads/h1.jpg', 50, 'Industry-leading noise cancellation with 30-hour battery life. Perfect for travel and work with multipoint connectivity.'),
(9, 3, 'Apple AirPods Pro 2nd Gen', '12999', 'uploads/h2.jpg', 60, 'Premium wireless earbuds with adaptive transparency, spatial audio, and up to 6 hours of listening time with ANC.'),
(10, 4, 'PlayStation 5', '29999', 'uploads/g1.jpg', 20, 'Next-gen gaming console with 4K gaming at 120fps, lightning-fast SSD, and DualSense controller with haptic feedback.'),
(11, 5, 'Canon EOS R6 Mark II', '155999', 'uploads/c1.jpg', 8, 'Full-frame mirrorless camera with 24.2MP sensor and dual pixel autofocus. Professional photography made easy with 4K video.'),
(12, 5, 'Sony Alpha A7 IV', '149999', 'uploads/c2.jpg', 10, 'Versatile full-frame camera with 33MP sensor, perfect for photo and video content creation with 5-axis stabilization.'),
(13, 5, 'GoPro Hero 12 Black', '24999', 'uploads/c3.jpg', 40, 'Ultimate action camera with 5.3K video, HyperSmooth 6.0 stabilization, and waterproof design up to 10m.'),
(14, 6, 'Apple Watch Series 9', '21999', 'uploads/w1.jpg', 35, 'Most advanced Apple Watch with health monitoring, fitness tracking, and double tap gesture. 18-hour battery life.'),
(15, 6, 'Samsung Galaxy Watch 6', '15999', 'uploads/w2.jpg', 40, 'Android smartwatch with comprehensive health tracking, sleep coaching, and 40-hour battery life with always-on display.');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE IF NOT EXISTS `transaction` (
  `transactionid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `ordereddate` datetime NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  `shippingfee` decimal(10,0) NOT NULL,
  `totalamount` decimal(10,0) NOT NULL,
  `deliveryaddress` text NOT NULL,
  `contactnumber` int(11) NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transaction`
--


-- --------------------------------------------------------

--
-- Table structure for table `transactionitem`
--

CREATE TABLE IF NOT EXISTS `transactionitem` (
  `transactionitemid` int(11) NOT NULL AUTO_INCREMENT,
  `transactionid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `subtotal` decimal(10,0) NOT NULL,
  PRIMARY KEY (`transactionitemid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transactionitem`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` text NOT NULL,
  `lastname` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `contactnumber` int(11) NOT NULL,
  `createddate` datetime NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `firstname`, `lastname`, `password`, `email`, `address`, `contactnumber`, `createddate`) VALUES
(1, 'Joshua', 'Zara', '12345', 'josh2@gmail.com', 'SAS Philippines, 21st Floor Equitable Bank Tower, 8751 Paseo de Roxas St., Makati City, 1226, Philippines', 54476762, '2025-05-28 15:53:57');
