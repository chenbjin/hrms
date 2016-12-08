-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 12 月 19 日 15:51
-- 服务器版本: 5.5.34
-- PHP 版本: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `hrms`
--

-- --------------------------------------------------------

--
-- 表的结构 `attendance`
--

CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `remark` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `AttendenceInfo` (`staff_id`,`year`,`month`,`day`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=52 ;

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `type` varchar(20) NOT NULL DEFAULT 'system',
  `name` varchar(20) CHARACTER SET utf8 NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `cookies`
--

CREATE TABLE IF NOT EXISTS `cookies` (
  `staff_id` varchar(30) NOT NULL,
  `sso` varchar(40) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `ip` varchar(45) CHARACTER SET latin1 NOT NULL DEFAULT '0',
  `user_agent` varchar(300) CHARACTER SET latin1 NOT NULL,
  `expire` int(12) NOT NULL,
  PRIMARY KEY (`sso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `salary`
--

CREATE TABLE IF NOT EXISTS `salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `basic` int(11) NOT NULL,
  `fullAttendance` int(11) NOT NULL,
  `leave` int(11) NOT NULL DEFAULT '0',
  `absent` int(11) NOT NULL DEFAULT '0',
  `late` int(11) NOT NULL DEFAULT '0',
  `others` text NOT NULL,
  `final` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=436 ;

-- --------------------------------------------------------

--
-- 表的结构 `salarySummary`
--

CREATE TABLE IF NOT EXISTS `salarySummary` (
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `createTime` int(11) NOT NULL,
  `createUser` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`year`,`month`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position` varchar(200) NOT NULL,
  `baseSalary` int(11) NOT NULL,
  `tel` varchar(100) NOT NULL,
  `addr` tinytext NOT NULL,
  `employeDate` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=24 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
