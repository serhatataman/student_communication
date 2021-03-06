-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 23 May 2017, 23:11:05
-- Sunucu sürümü: 10.1.21-MariaDB
-- PHP Sürümü: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `gtdatabase`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `channel`
--

CREATE TABLE `channel` (
  `ID` varchar(6) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Password` varchar(11) DEFAULT NULL,
  `Owner_ID` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `channel`
--

INSERT INTO `channel` (`ID`, `Name`, `Password`, `Owner_ID`) VALUES
('CEN123', 'System Programming', '1234', '2012123027'),
('CEN215', 'Network Design', 'CEN215_2017', '2012123027'),
('CEN300', 'JAVA', 'CEN300_2017', '2010123027'),
('CEN430', 'Database Management Systems', 'CEN430_2017', '2010123027');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `channel_news`
--

CREATE TABLE `channel_news` (
  `Channel_ID` varchar(6) DEFAULT NULL,
  `Headline` text,
  `Story` text,
  `Name` varchar(30) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `channel_news`
--

INSERT INTO `channel_news` (`Channel_ID`, `Headline`, `Story`, `Name`, `Email`, `Date`) VALUES
('CEN123', 'About: JAVA', 'Tomorrow will be java quiz !', 'Buse Ozyildirim', 'buse@gmail.com', '2017-04-25 21:51:32');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact_info`
--

CREATE TABLE `contact_info` (
  `Name` varchar(20) DEFAULT NULL,
  `Surname` varchar(20) DEFAULT NULL,
  `Email` varchar(30) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `Type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `contact_info`
--

INSERT INTO `contact_info` (`Name`, `Surname`, `Email`, `Phone`, `Type`) VALUES
('Dia', 'Abdulkarim', 'dia@gmail.com', '03223552126', 'Moderator');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `instructor`
--

CREATE TABLE `instructor` (
  `ID` varchar(10) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `instructor`
--

INSERT INTO `instructor` (`ID`, `Password`, `Name`, `Surname`, `Email`, `Phone`) VALUES
('2010123027', '1234', 'Emre', 'Kilinc', 'emre@gmail.com', '5211232456'),
('2012123027', '1234', 'Kahraman', 'Alp', 'hero@gmail.com', '05431234567');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `news`
--

CREATE TABLE `news` (
  `headline` text NOT NULL,
  `story` text NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `news`
--

INSERT INTO `news` (`headline`, `story`, `name`, `email`, `date`) VALUES
('About: Artificial Neural Networks Slides', 'Everyone have to come lesson tomorrow !', 'serhat', 'serhatataman13@gmail.com', '2017-04-19 01:12:08'),
('About: Database Design', 'Students must install SQL Database for lessons.', 'Ahmet', 'serhatataman13@hotmail.com', '2017-04-19 02:27:42'),
('About', 'asdsdsada', 'sd', 'serhatataman13@hotmail.com', '2017-04-19 14:12:46');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student`
--

CREATE TABLE `student` (
  `ID` varchar(10) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Surname` varchar(20) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `student`
--

INSERT INTO `student` (`ID`, `Password`, `Name`, `Surname`, `Email`, `Phone`) VALUES
('2012000111', '1234', 'Serhat', 'Ataman', 'serhatataman13@gmail.com', '5444344414'),
('2012000112', '1234', 'Ali imran', 'ATAMAN', 'aliimran@gmail.com', '123456789');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `student_channel`
--

CREATE TABLE `student_channel` (
  `Student_ID` varchar(10) DEFAULT NULL,
  `Channel_ID` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `student_channel`
--

INSERT INTO `student_channel` (`Student_ID`, `Channel_ID`) VALUES
('2012000111', 'CEN123'),
('2012000111', 'CEN300'),
('2012000112', 'CEN123'),
('2012000112', 'CEN300');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Owner_ID` (`Owner_ID`);

--
-- Tablo için indeksler `channel_news`
--
ALTER TABLE `channel_news`
  ADD KEY `Channel_ID` (`Channel_ID`);

--
-- Tablo için indeksler `instructor`
--
ALTER TABLE `instructor`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `student_channel`
--
ALTER TABLE `student_channel`
  ADD KEY `Student_ID` (`Student_ID`),
  ADD KEY `Channel_ID` (`Channel_ID`);

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `channel`
--
ALTER TABLE `channel`
  ADD CONSTRAINT `channel_ibfk_1` FOREIGN KEY (`Owner_ID`) REFERENCES `instructor` (`ID`);

--
-- Tablo kısıtlamaları `channel_news`
--
ALTER TABLE `channel_news`
  ADD CONSTRAINT `channel_news_ibfk_1` FOREIGN KEY (`Channel_ID`) REFERENCES `channel` (`ID`);

--
-- Tablo kısıtlamaları `student_channel`
--
ALTER TABLE `student_channel`
  ADD CONSTRAINT `student_channel_ibfk_1` FOREIGN KEY (`Student_ID`) REFERENCES `student` (`ID`),
  ADD CONSTRAINT `student_channel_ibfk_2` FOREIGN KEY (`Channel_ID`) REFERENCES `channel` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
