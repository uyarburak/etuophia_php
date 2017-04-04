-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 05 Ara 2016, 14:17:20
-- Sunucu sürümü: 5.7.12-log
-- PHP Sürümü: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `etuophia`
--
CREATE DATABASE IF NOT EXISTS `etuophia` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `etuophia`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTENT` varchar(255) DEFAULT NULL,
  `COMMENT_TIME` datetime DEFAULT NULL,
  `IS_ANONYMOUS` tinyint(1) NOT NULL,
  `MEMBER_ID` int(11) DEFAULT NULL,
  `PARENT_ID` int(11) DEFAULT NULL,
  `TOPIC_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`COMMENT_ID`),
  KEY `FK_ov92ga6qt0qqlrfo0hyqa5d8c` (`MEMBER_ID`),
  KEY `FK_448bdgrgop2rr50g5ncwq0d3n` (`PARENT_ID`),
  KEY `FK_qhx2u4trqgvy5233ni51gs18y` (`TOPIC_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

--
-- Tetikleyiciler `comment`
--
DROP TRIGGER IF EXISTS `TOPIC_MODIFIED_UPDATE`;
DELIMITER $$
CREATE TRIGGER `TOPIC_MODIFIED_UPDATE` BEFORE INSERT ON `comment` FOR EACH ROW UPDATE topic
    SET LAST_MODIFIED = NEW.COMMENT_TIME
     WHERE TOPIC_ID = NEW.TOPIC_ID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `COURSE_CODE` varchar(15) NOT NULL,
  `DESCRIPTION` varchar(255) DEFAULT NULL,
  `SYLLABUS` varchar(255) DEFAULT NULL,
  `COURSE_TITLE` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`COURSE_CODE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
CREATE TABLE IF NOT EXISTS `enrollment` (
  `IS_ADMIN` bit(1) DEFAULT NULL,
  `MEMBER_ID` int(11) NOT NULL,
  `COURSE_ID` varchar(15) NOT NULL,
  PRIMARY KEY (`COURSE_ID`,`MEMBER_ID`),
  KEY `FK_frl5yv5jcarpkf6f5j5io36g1` (`MEMBER_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `homework`
--

DROP TABLE IF EXISTS `homework`;
CREATE TABLE IF NOT EXISTS `homework` (
  `HW_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DEADLINE_TIME` datetime NOT NULL,
  `LOCK_TYPE` bit(2) NOT NULL DEFAULT b'0',
  `RESOURCE_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`HW_ID`),
  KEY `FK_ngdsc36gwiio8ypi02vbvhl4b` (`RESOURCE_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `instructor`
--

DROP TABLE IF EXISTS `instructor`;
CREATE TABLE IF NOT EXISTS `instructor` (
  `OFFICE` varchar(255) DEFAULT NULL,
  `TEL` varchar(255) DEFAULT NULL,
  `WEBSITE` varchar(255) DEFAULT NULL,
  `M_ID` int(11) NOT NULL,
  PRIMARY KEY (`M_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `member`
--

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
  `M_ID` int(11) NOT NULL AUTO_INCREMENT,
  `SEX` char(1) DEFAULT NULL,
  `IMAGE_URL` varchar(255) DEFAULT NULL,
  `MAIL` varchar(255) DEFAULT NULL,
  `NAME` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`M_ID`),
  UNIQUE KEY `MAIL` (`MAIL`)
) ENGINE=InnoDB AUTO_INCREMENT=4912 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `NEWS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `TITLE` varchar(255) NOT NULL,
  `SUMMARY` varchar(255) NOT NULL,
  `URL` varchar(255) NOT NULL,
  `IMAGE_URL` varchar(255) NOT NULL,
  `IS_ACTIVE` tinyint(1) NOT NULL,
  PRIMARY KEY (`NEWS_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `read_history`
--

DROP TABLE IF EXISTS `read_history`;
CREATE TABLE IF NOT EXISTS `read_history` (
  `LAST_READ` datetime DEFAULT NULL,
  `MEMBER_ID` int(11) NOT NULL,
  `TOPIC_ID` int(11) NOT NULL,
  PRIMARY KEY (`MEMBER_ID`,`TOPIC_ID`),
  KEY `FK_80orgvj05sho966vyt171bqy5` (`TOPIC_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `resource`
--

DROP TABLE IF EXISTS `resource`;
CREATE TABLE IF NOT EXISTS `resource` (
  `RESOURCE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `UPLOAD_TIME` datetime DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `COMMITTED_HW_ID` int(11) DEFAULT NULL,
  `COURSE_ID` varchar(15) DEFAULT NULL,
  `MEMBER_ID` int(11) DEFAULT NULL,
  `RESOURCE_TITLE` varchar(255) NOT NULL,
  `TYPE` tinyint(4) NOT NULL COMMENT '0:GENERAL;1:HW;2:LECTURE-NOTES:3:HW-SOLUTIONS;4:UNLISTED;5:COMMITTED',
  PRIMARY KEY (`RESOURCE_ID`),
  UNIQUE KEY `COMMITTED_HW_ID` (`COMMITTED_HW_ID`,`MEMBER_ID`),
  KEY `FK_7vkxfd3l5vnxen802j22jlux8` (`COURSE_ID`),
  KEY `FK_h255j10qrls4vjq6hfmpn8e9x` (`MEMBER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `DEPARTMENT` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `STUDENT_ID` varchar(10) DEFAULT NULL,
  `YEAR` tinyint(4) DEFAULT NULL,
  `M_ID` int(11) NOT NULL,
  PRIMARY KEY (`M_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE IF NOT EXISTS `topic` (
  `TOPIC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTENT` longtext,
  `CREATE_TIME` datetime DEFAULT NULL,
  `TITLE` varchar(255) DEFAULT NULL,
  `IS_LOCKED` tinyint(1) NOT NULL,
  `LAST_MODIFIED` datetime,
  `COURSE_ID` varchar(15) DEFAULT NULL,
  `MEMBER_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`TOPIC_ID`),
  KEY `FK_k52f3n661xu6m55biq2tbhmfo` (`COURSE_ID`),
  KEY `FK_aor45cakt2pystrwpcao4ryia` (`MEMBER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_448bdgrgop2rr50g5ncwq0d3n` FOREIGN KEY (`PARENT_ID`) REFERENCES `comment` (`COMMENT_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_ov92ga6qt0qqlrfo0hyqa5d8c` FOREIGN KEY (`MEMBER_ID`) REFERENCES `member` (`M_ID`),
  ADD CONSTRAINT `FK_qhx2u4trqgvy5233ni51gs18y` FOREIGN KEY (`TOPIC_ID`) REFERENCES `topic` (`TOPIC_ID`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `enrollment`
--
ALTER TABLE `enrollment`
  ADD CONSTRAINT `FK_frl5yv5jcarpkf6f5j5io36g1` FOREIGN KEY (`MEMBER_ID`) REFERENCES `member` (`M_ID`),
  ADD CONSTRAINT `FK_hwugcj2f5bnrvx0tc3qckadhy` FOREIGN KEY (`COURSE_ID`) REFERENCES `course` (`COURSE_CODE`);

--
-- Tablo kısıtlamaları `homework`
--
ALTER TABLE `homework`
  ADD CONSTRAINT `FK_ngdsc36gwiio8ypi02vbvhl4b` FOREIGN KEY (`RESOURCE_ID`) REFERENCES `resource` (`RESOURCE_ID`);

--
-- Tablo kısıtlamaları `instructor`
--
ALTER TABLE `instructor`
  ADD CONSTRAINT `FK_7d961y2sdl3tj4bhpuo3qf4tu` FOREIGN KEY (`M_ID`) REFERENCES `member` (`M_ID`);

--
-- Tablo kısıtlamaları `read_history`
--
ALTER TABLE `read_history`
  ADD CONSTRAINT `FK_80orgvj05sho966vyt171bqy5` FOREIGN KEY (`TOPIC_ID`) REFERENCES `topic` (`TOPIC_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_iu0arf8xxqtgcgthx7r75o20w` FOREIGN KEY (`MEMBER_ID`) REFERENCES `member` (`M_ID`);

--
-- Tablo kısıtlamaları `resource`
--
ALTER TABLE `resource`
  ADD CONSTRAINT `FK_1qhgnc40pifqxxckn64kni5j0` FOREIGN KEY (`COMMITTED_HW_ID`) REFERENCES `homework` (`HW_ID`),
  ADD CONSTRAINT `FK_7vkxfd3l5vnxen802j22jlux8` FOREIGN KEY (`COURSE_ID`) REFERENCES `course` (`COURSE_CODE`),
  ADD CONSTRAINT `FK_h255j10qrls4vjq6hfmpn8e9x` FOREIGN KEY (`MEMBER_ID`) REFERENCES `member` (`M_ID`);

--
-- Tablo kısıtlamaları `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `FK_pvifu279f7d1qpmcvulnc4vcb` FOREIGN KEY (`M_ID`) REFERENCES `member` (`M_ID`);

--
-- Tablo kısıtlamaları `topic`
--
ALTER TABLE `topic`
  ADD CONSTRAINT `FK_aor45cakt2pystrwpcao4ryia` FOREIGN KEY (`MEMBER_ID`) REFERENCES `member` (`M_ID`),
  ADD CONSTRAINT `FK_k52f3n661xu6m55biq2tbhmfo` FOREIGN KEY (`COURSE_ID`) REFERENCES `course` (`COURSE_CODE`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
