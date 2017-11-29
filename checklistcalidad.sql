-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2017 at 06:07 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `checklistcalidad`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE IF NOT EXISTS `checklist` (
  `che_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `che_emp_id` int(10) unsigned NOT NULL,
  `che_nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `che_activo` int(10) unsigned NOT NULL,
  `che_tipo` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`che_id`),
  KEY `che_emp_id` (`che_emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `checklist`
--

INSERT INTO `checklist` (`che_id`, `che_emp_id`, `che_nombre`, `che_activo`, `che_tipo`) VALUES
(15, 3, 'Agentes de Ventas', 1, 0),
(16, 4, 'Fastfood', 1, 0),
(20, 3, 'Amnetek', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `empresas`
--

CREATE TABLE IF NOT EXISTS `empresas` (
  `emp_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `emp_nombre` varchar(50) NOT NULL,
  `emp_fecha_alta` date NOT NULL,
  `emp_activa` int(11) NOT NULL,
  `usu_clave` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `empresas`
--

INSERT INTO `empresas` (`emp_id`, `emp_nombre`, `emp_fecha_alta`, `emp_activa`, `usu_clave`) VALUES
(3, ' Innotek', '2015-01-28', 1, 'LASALLE'),
(4, 'Grupo Alcon', '2016-03-14', 1, 'GALCON'),
(10, 'Gramedia', '2017-09-13', 1, 'GRAMEDIA');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist`
--
ALTER TABLE `checklist`
  ADD CONSTRAINT `CheckList_ibfk_1` FOREIGN KEY (`che_emp_id`) REFERENCES `empresas` (`emp_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
