-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 07 月 09 日 14:10
-- 服务器版本: 5.5.31-0ubuntu0.13.04.1
-- PHP 版本: 5.4.9-4ubuntu2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cs`
--

-- --------------------------------------------------------

--
-- 表的结构 `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `imgUrl` tinytext NOT NULL,
  `title` tinytext NOT NULL,
  `content` tinytext NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `banner`
--

INSERT INTO `banner` (`ID`, `imgUrl`, `title`, `content`) VALUES
(1, 'http://www.bootcss.com/assets/img/bootstrap-mdo-sfmoma-01.jpg', 'test1', 'content'),
(2, 'http://www.bootcss.com/assets/img/bootstrap-mdo-sfmoma-02.jpg', 'test2', 'content2'),
(3, 'http://www.bootcss.com/assets/img/bootstrap-mdo-sfmoma-03.jpg', 'nice', 'content3');

-- --------------------------------------------------------

--
-- 表的结构 `coin`
--

CREATE TABLE IF NOT EXISTS `coin` (
  `user` varchar(20) NOT NULL,
  `type` text NOT NULL,
  `date` double NOT NULL,
  `num` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `subject` tinytext NOT NULL,
  `file` tinytext NOT NULL,
  `user` tinytext NOT NULL,
  `time` int(12) NOT NULL,
  `content` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `dandan`
--

CREATE TABLE IF NOT EXISTS `dandan` (
  `time` int(12) NOT NULL,
  `user` char(20) NOT NULL,
  `addr` tinytext NOT NULL,
  `remark` tinytext NOT NULL,
  `num` int(3) NOT NULL,
  `status` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `down`
--

CREATE TABLE IF NOT EXISTS `down` (
  `file` text NOT NULL,
  `time` int(11) NOT NULL,
  `ip` text NOT NULL,
  `user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `info`
--

CREATE TABLE IF NOT EXISTS `info` (
  `content` longtext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type` text NOT NULL,
  `subject` varchar(20) NOT NULL DEFAULT 'info',
  `date` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `user` tinytext NOT NULL,
  `time` int(12) NOT NULL,
  `content` text NOT NULL,
  `read` int(11) NOT NULL,
  `fromuser` char(33) NOT NULL DEFAULT 'system'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `resource`
--

CREATE TABLE IF NOT EXISTS `resource` (
  `name` varchar(80) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  `description` text,
  `ip` varchar(16) NOT NULL,
  `downloadtimes` int(5) NOT NULL,
  `user` varchar(20) NOT NULL,
  `comment` int(11) NOT NULL DEFAULT '0',
  `subject` char(33) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `subject` char(22) NOT NULL,
  `name` char(33) NOT NULL,
  `remark` text NOT NULL,
  UNIQUE KEY `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `nickname` varchar(18) NOT NULL,
  `password` text NOT NULL,
  `ip` text NOT NULL,
  `coin` int(11) NOT NULL DEFAULT '100',
  `checkdays` int(5) NOT NULL,
  `signature` text NOT NULL,
  `rank` int(11) NOT NULL,
  `email` tinytext NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `addInfo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `visitors`
--

CREATE TABLE IF NOT EXISTS `visitors` (
  `date` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `ua` text NOT NULL,
  `user` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `water`
--

CREATE TABLE IF NOT EXISTS `water` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `user` char(33) NOT NULL,
  `time` int(12) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
