-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 11, 2013 at 08:33 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ISGB24`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE IF NOT EXISTS `tbladmin` (
  `username` varchar(20) COLLATE utf8_swedish_ci NOT NULL,
  `password` char(64) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblartist`
--

CREATE TABLE IF NOT EXISTS `tblartist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `picture` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `changedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `picture` (`picture`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=78 ;

--
-- Dumping data for table `tblartist`
--

INSERT INTO `tblartist` (`id`, `name`, `picture`, `changedate`) VALUES
(76, 'AC/DC', 'acdc.jpg', '2013-09-25 09:36:46'),
(77, 'Laleh', 'laleh.jpg', '2013-11-04 13:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `tblcomment`
--

CREATE TABLE IF NOT EXISTS `tblcomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_swedish_ci NOT NULL,
  `songid` int(11) NOT NULL,
  `insertdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `comment_fkey` (`songid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=124 ;

--
-- Dumping data for table `tblcomment`
--

INSERT INTO `tblcomment` (`id`, `text`, `songid`, `insertdate`) VALUES
(120, 'Wheels Ã¤r bÃ¤st!', 22, '2013-11-06 08:12:07'),
(121, 'Wheels rules!', 22, '2013-11-06 08:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `tblsong`
--

CREATE TABLE IF NOT EXISTS `tblsong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `sound` varchar(100) COLLATE utf8_swedish_ci NOT NULL,
  `count` int(11) NOT NULL,
  `artistid` int(11) NOT NULL,
  `changedate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sound` (`sound`),
  KEY `song_fkey` (`artistid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tblsong`
--

INSERT INTO `tblsong` (`id`, `title`, `sound`, `count`, `artistid`, `changedate`) VALUES
(22, 'Wheels', 'wheels.ogg', 22, 76, '2013-09-27 06:58:09'),
(23, 'Colors', 'colors.ogg', 5, 77, '2013-11-04 10:57:26');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcomment`
--
ALTER TABLE `tblcomment`
  ADD CONSTRAINT `comment_fkey` FOREIGN KEY (`songid`) REFERENCES `tblsong` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tblsong`
--
ALTER TABLE `tblsong`
  ADD CONSTRAINT `song_fkey` FOREIGN KEY (`artistid`) REFERENCES `tblartist` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
