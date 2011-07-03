-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2009 at 05:14 PM
-- Server version: 5.1.33
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `exambuff`
--

-- --------------------------------------------------------

--
-- Table structure for table `activations`
--

CREATE TABLE IF NOT EXISTS `activations` (
  `activationKey` varchar(12) NOT NULL DEFAULT '',
  `email` varchar(64) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`activationKey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastLoggedIn` int(10) NOT NULL DEFAULT '0',
  `failedLogins` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessmentFix`
--

CREATE TABLE IF NOT EXISTS `assessmentFix` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hadProblem` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE IF NOT EXISTS `assessments` (
  `script` int(11) NOT NULL DEFAULT '0',
  `marker` varchar(128) NOT NULL DEFAULT '',
  `markData` text NOT NULL,
  `status` enum('marking','unpaid','paid') NOT NULL DEFAULT 'marking',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `targets` text NOT NULL,
  `generalComment` text NOT NULL,
  KEY `marker` (`marker`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(128) NOT NULL DEFAULT '',
  `receiver` varchar(128) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `status` enum('waiting','sent','failed') NOT NULL DEFAULT 'waiting',
  `error` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `messageHTML` text NOT NULL,
  `replyTo` varchar(128) NOT NULL DEFAULT '',
  `method` enum('email','fbEmail') NOT NULL DEFAULT 'email',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `markers`
--

CREATE TABLE IF NOT EXISTS `markers` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) DEFAULT NULL,
  `username` varchar(128) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `subject` varchar(128) DEFAULT NULL,
  `institution` varchar(128) DEFAULT NULL,
  `status` enum('tutor','') NOT NULL DEFAULT 'tutor',
  `phdStatus` enum('authenticated','') NOT NULL DEFAULT 'authenticated',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `studentNum` varchar(128) NOT NULL DEFAULT '',
  `alertThreshold` smallint(6) DEFAULT NULL,
  `alertSubjects` varchar(255) DEFAULT NULL,
  `alertMax` smallint(6) DEFAULT NULL,
  `jobMin` smallint(6) DEFAULT NULL,
  `alertTime` varchar(4) DEFAULT NULL,
  `failedLogins` tinyint(4) NOT NULL DEFAULT '0',
  `lastLoggedIn` int(10) NOT NULL DEFAULT '0',
  `passwordResetKey` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE IF NOT EXISTS `marks` (
  `script` int(11) NOT NULL DEFAULT '0',
  `marker` varchar(128) NOT NULL DEFAULT '',
  `markData` text NOT NULL,
  `status` enum('marking','unpaid','paid') NOT NULL DEFAULT 'marking',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `targets` text NOT NULL,
  `generalComment` text NOT NULL,
  PRIMARY KEY (`script`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `fileName` varchar(128) NOT NULL DEFAULT '',
  `scriptKey` int(11) DEFAULT NULL,
  `oldFileName` varchar(128) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`fileName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(64) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `amount` float NOT NULL DEFAULT '0',
  `method` enum('paypal','direct') NOT NULL DEFAULT 'paypal',
  `scripts` varchar(255) NOT NULL DEFAULT '',
  `transactionID` varchar(19) NOT NULL DEFAULT '',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `queJobs`
--

CREATE TABLE IF NOT EXISTS `queJobs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `jobData` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `attempts` smallint(6) NOT NULL DEFAULT '0',
  `iterations` smallint(6) NOT NULL DEFAULT '0',
  `result` enum('completed','failed') NOT NULL DEFAULT 'completed',
  `error` text NOT NULL,
  `scheduled` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `scheduled` (`scheduled`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE IF NOT EXISTS `referrals` (
  `user` varchar(128) NOT NULL DEFAULT '',
  `referee` varchar(128) NOT NULL DEFAULT '',
  `ipRequested` varchar(16) NOT NULL DEFAULT '',
  `paypalRef` varchar(64) NOT NULL DEFAULT '',
  `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`referee`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `scripts`
--

CREATE TABLE IF NOT EXISTS `scripts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) NOT NULL DEFAULT '',
  `question` text,
  `subject` varchar(64) DEFAULT NULL,
  `pageKeys` text,
  `status` enum('active','paid','marking','marked') DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) DEFAULT NULL,
  `title` varchar(21) DEFAULT NULL,
  `password` varchar(64) NOT NULL DEFAULT '',
  `subject` varchar(128) DEFAULT NULL,
  `institution` varchar(128) DEFAULT NULL,
  `accountActive` binary(1) DEFAULT NULL,
  `activationKey` varchar(12) DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `ID` int(6) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `name` varchar(64) DEFAULT NULL,
  `password` varchar(64) NOT NULL DEFAULT '',
  `subject` varchar(128) DEFAULT NULL,
  `institution` varchar(128) DEFAULT NULL,
  `accountActive` enum('active','inactive','early') NOT NULL DEFAULT 'inactive',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `failedLogins` tinyint(4) NOT NULL DEFAULT '0',
  `lastLoggedIn` int(10) NOT NULL DEFAULT '0',
  `passwordResetKey` varchar(16) DEFAULT NULL,
  `type` enum('fbConnect','email') NOT NULL DEFAULT 'email',
  `fbEmail` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wages`
--

CREATE TABLE IF NOT EXISTS `wages` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `marker` varchar(128) NOT NULL DEFAULT '',
  `amount` float NOT NULL DEFAULT '0',
  `scripts` text NOT NULL,
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;


CREATE TABLE IF NOT EXISTS `offers` (
  `id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `value` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
