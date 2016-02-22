-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 22, 2016 at 07:53 AM
-- Server version: 5.6.27-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `github`
--

-- --------------------------------------------------------

--
-- Table structure for table `reposTable`
--

CREATE TABLE IF NOT EXISTS `reposTable` (
`id` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `projectName` varchar(150) CHARACTER SET utf8 NOT NULL,
  `projectDesc` text CHARACTER SET utf8 NOT NULL,
  `projectURL` tinytext CHARACTER SET utf8 NOT NULL,
  `projectCreated` date NOT NULL,
  `projectUpdated` date NOT NULL,
  `projectStars` int(11) NOT NULL,
  `language` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=491 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reposTable`
--
ALTER TABLE `reposTable`
 ADD PRIMARY KEY (`projectID`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reposTable`
--
ALTER TABLE `reposTable`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=491;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
