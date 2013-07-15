-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 10-10-2012 a las 18:23:28
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pahlito_maker`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `[prefix]access`
--

CREATE TABLE IF NOT EXISTS `[prefix]access` (
  `group_id` int(20) NOT NULL,
  `table_name` varchar(255) NOT NULL,
  `action_name` varchar(255) NOT NULL,
  PRIMARY KEY (`group_id`,`table_name`,`action_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `[prefix]config_log`
--

CREATE TABLE IF NOT EXISTS `[prefix]config_log` (
  `config_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) NOT NULL,
  `config` text NOT NULL,
  `config_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`config_id`),
  KEY `config_date` (`config_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `[prefix]groups`
--

CREATE TABLE IF NOT EXISTS `[prefix]groups` (
  `group_id` int(20) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `[prefix]groups`
--

INSERT INTO `[prefix]groups` (`group_id`, `group_name`) VALUES
(1, 'SuperAdmin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `[prefix]users`
--

CREATE TABLE IF NOT EXISTS `[prefix]users` (
  `user_id` int(20) NOT NULL AUTO_INCREMENT,
  `user_email` varchar(255) NOT NULL,
  `user_pass` varchar(32) NOT NULL,
  `group_id` int(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `[prefix]users`
--

INSERT INTO `[prefix]users` (`user_id`, `user_email`, `user_pass`, `group_id`) VALUES
(1, '[user_email]', '[user_pass]', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
