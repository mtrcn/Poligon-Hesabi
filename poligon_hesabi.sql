-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2010 at 10:15 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poligon_hesabi`
--

-- --------------------------------------------------------

--
-- Table structure for table `ph_projects`
--

CREATE TABLE IF NOT EXISTS `ph_projects` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(11) NOT NULL,
  `tag` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `num_points` int(4) NOT NULL,
  `id` text COLLATE utf8_unicode_ci NOT NULL,
  `angle` text COLLATE utf8_unicode_ci NOT NULL,
  `azimuth` text COLLATE utf8_unicode_ci NOT NULL,
  `distance` text COLLATE utf8_unicode_ci NOT NULL,
  `x` text COLLATE utf8_unicode_ci NOT NULL,
  `y` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ph_users`
--

CREATE TABLE IF NOT EXISTS `ph_users` (
  `uid` bigint(11) NOT NULL,
  `oauth_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `oauth_token_secret` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
