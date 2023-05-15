-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 26, 2023 at 07:37 PM
-- Server version: 5.7.38
-- PHP Version: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `regmondb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '1',
  `name` varchar(64) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `color` char(7) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `sort`, `name`, `status`, `color`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 0, 2, 'Diagnostik', 1, '#f2f2f2', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(2, 0, 1, 'Training und Wettkampf', 1, '#5B9BD5', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(3, 0, 3, 'Regeneration', 1, '#70AD47', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(4, 1, 1, 'Psychometrie', 1, '#ED7D31', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(5, 1, 2, 'Physiologie und Leistung', 1, '#A5A5A5', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '0',
  `isAllDay` tinyint(1) NOT NULL DEFAULT '1',
  `showInGraph` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `comments` text,
  `color` char(25) NOT NULL DEFAULT '',
  `created` datetime DEFAULT NULL,
  `created_end` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) DEFAULT NULL,
  `type` varchar(24) DEFAULT NULL,
  `options` varchar(128) DEFAULT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `color` char(25) NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dropdowns`
--

CREATE TABLE `dropdowns` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `options` varchar(64) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dropdowns`
--

INSERT INTO `dropdowns` (`id`, `parent_id`, `name`, `options`, `status`, `created`, `modified`) VALUES
(1, 0, 'Dropdown Demo StringValue', NULL, 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00'),
(2, 1, NULL, 'Option 1', 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00'),
(3, 1, NULL, 'Option 2', 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00'),
(4, 1, NULL, 'Option 3', 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00'),
(5, 0, 'Dropdown Demo Value__String', NULL, 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00'),
(6, 5, NULL, '1__Option 1', 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00'),
(7, 5, NULL, '2__Option 2', 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00'),
(8, 5, NULL, '3__Option 3', 1, '2023-04-10 00:00:00', '2023-04-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `name2` varchar(64) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `tags` text,
  `data_json` mediumtext,
  `data_names` text,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`id`, `name`, `name2`, `status`, `tags`, `data_json`, `data_names`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 'Trainingseinheit (Polar)', 'Polar-Import Standardformular', 1, 'Herzfrequenz,Training,Polar,Wearables,Import', '{\"title\":\"Polar-Import Standardformular (Trainingseinheit (Polar))\",\"timer\":{\"has\":\"0\",\"min\":\"0\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Importierte Trainingseinheit (Polar)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Name\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":1,\"name\":\"Name\",\"placeholder\":\"Name\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Sport\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":2,\"name\":\"Sport\",\"placeholder\":\"Sport\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Datum\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Date\",\"no\":2,\"unid\":3,\"name\":\"Datum\",\"placeholder\":\"Datum\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Startzeit\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Time\",\"no\":2,\"unid\":4,\"name\":\"Startzeit\",\"placeholder\":\"Startzeit\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":5,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Dauer [min]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":5,\"name\":\"Dauer [min]\",\"placeholder\":\"Dauer [min]\",\"required\":\"1\",\"min\":\"0\",\"max\":\"600\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":6,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Distanz [km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":6,\"name\":\"Distanz [km]\",\"placeholder\":\"Distanz [km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"150\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":7,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Herzfrequenz [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":7,\"name\":\"Durchschnittliche Herzfrequenz [bpm]\",\"placeholder\":\"Durchschnittliche Herzfrequenz [bpm]\",\"required\":\"0\",\"min\":\"60\",\"max\":\"220\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":8,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Geschwindigkeit [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":8,\"name\":\"Durchschnittliche Geschwindigkeit [km/h]\",\"placeholder\":\"Durchschnittliche Geschwindigkeit [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Geschwindigkeit [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":9,\"name\":\"Maximale Geschwindigkeit [km/h]\",\"placeholder\":\"Maximale Geschwindigkeit [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":10,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Geschwindigkeit [min/km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":10,\"name\":\"Durchschnittliche Geschwindigkeit [min/km]\",\"placeholder\":\"Durchschnittliche Geschwindigkeit [min/km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":11,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Geschwindigkeit [min/km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":11,\"name\":\"Maximale Geschwindigkeit [min/km]\",\"placeholder\":\"Maximale Geschwindigkeit [min/km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":12,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Kalorien\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":12,\"name\":\"Kalorien\",\"placeholder\":\"Kalorien\",\"required\":\"0\",\"min\":\"0\",\"max\":\"10000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":13,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Anteil Fettverbrennung [%]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":13,\"name\":\"Anteil Fettverbrennung [%]\",\"placeholder\":\"Anteil Fettverbrennung [%]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":14,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Frequenz [rpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":14,\"name\":\"Durchschnittliche Frequenz [rpm]\",\"placeholder\":\"Durchschnittliche Frequenz [rpm]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":15,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Schrittlänge [cm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":15,\"name\":\"Durchschnittliche Schrittlänge [cm]\",\"placeholder\":\"Durchschnittliche Schrittlänge [cm]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"200\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":16,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Lauf Index\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":16,\"name\":\"Lauf Index\",\"placeholder\":\"Lauf Index\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":17,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Training Load\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":17,\"name\":\"Training Load\",\"placeholder\":\"Training Load\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":18,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Aufstieg [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":18,\"name\":\"Aufstieg [m]\",\"placeholder\":\"Aufstieg [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":19,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Abstieg [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":19,\"name\":\"Abstieg [m]\",\"placeholder\":\"Abstieg [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":20,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Power [W]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":20,\"name\":\"Durchschnittliche Power [W]\",\"placeholder\":\"Durchschnittliche Power [W]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":21,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Power [W]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":21,\"name\":\"Maximale Power [W]\",\"placeholder\":\"Maximale Power [W]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"5000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":22,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Kommentar\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Textarea\",\"no\":2,\"unid\":22,\"name\":\"Kommentar\",\"placeholder\":\"Kommentar\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":23,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Körperhöhe [cm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":23,\"name\":\"Körperhöhe [cm]\",\"placeholder\":\"Körperhöhe [cm]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":24,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Körpergewicht [kg]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":24,\"name\":\"Körpergewicht [kg]\",\"placeholder\":\"Körpergewicht [kg]\",\"required\":\"0\",\"min\":\"20\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":25,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Herzfrequenz [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":25,\"name\":\"Maximale Herzfrequenz [bpm]\",\"placeholder\":\"Maximale Herzfrequenz [bpm]\",\"required\":\"0\",\"min\":\"100\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":26,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Minimale Herzfrequenz [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":26,\"name\":\"Minimale Herzfrequenz [bpm]\",\"placeholder\":\"Minimale Herzfrequenz [bpm]\",\"required\":\"0\",\"min\":\"30\",\"max\":\"150\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":27,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Sauerstoffaufnahme\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":27,\"name\":\"Maximale Sauerstoffaufnahme\",\"placeholder\":\"Maximale Sauerstoffaufnahme\",\"required\":\"0\",\"min\":\"0\",\"max\":\"150\",\"decimal\":false,\"width\":\"50\"}]}]}]}', '{\"1\":[\"Name\",\"_Text\"],\"2\":[\"Sport\",\"_Text\"],\"3\":[\"Datum\",\"_Date\"],\"4\":[\"Startzeit\",\"_Time\"],\"5\":[\"Dauer [min]\",\"_Number\"],\"6\":[\"Distanz [km]\",\"_Number\"],\"7\":[\"Durchschnittliche Herzfrequenz [bpm]\",\"_Number\"],\"8\":[\"Durchschnittliche Geschwindigkeit [km/h]\",\"_Number\"],\"9\":[\"Maximale Geschwindigkeit [km/h]\",\"_Number\"],\"10\":[\"Durchschnittliche Geschwindigkeit [min/km]\",\"_Number\"],\"11\":[\"Maximale Geschwindigkeit [min/km]\",\"_Number\"],\"12\":[\"Kalorien\",\"_Number\"],\"13\":[\"Anteil Fettverbrennung [%]\",\"_Number\"],\"14\":[\"Durchschnittliche Frequenz [rpm]\",\"_Number\"],\"15\":[\"Durchschnittliche Schrittlänge [cm]\",\"_Number\"],\"16\":[\"Lauf Index\",\"_Number\"],\"17\":[\"Training Load\",\"_Number\"],\"18\":[\"Aufstieg [m]\",\"_Number\"],\"19\":[\"Abstieg [m]\",\"_Number\"],\"20\":[\"Durchschnittliche Power [W]\",\"_Number\"],\"21\":[\"Maximale Power [W]\",\"_Number\"],\"22\":[\"Kommentar\",\"_Textarea\"],\"23\":[\"Körperhöhe [cm]\",\"_Number\"],\"24\":[\"Körpergewicht [kg]\",\"_Number\"],\"25\":[\"Maximale Herzfrequenz [bpm]\",\"_Number\"],\"26\":[\"Minimale Herzfrequenz [bpm]\",\"_Number\"],\"27\":[\"Maximale Sauerstoffaufnahme\",\"_Number\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(2, 'Trainingseinheit (Garmin)', 'Garmin-Import Standardformular', 1, 'Herzfrequenz,Import,Training,Wearables,Garmin', '{\"title\":\"Garmin-Import Standardformular (Trainingseinheit (Garmin))\",\"timer\":{\"has\":\"0\",\"min\":\"0\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Importierte Trainingseinheit (Garmin)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Aktivitätstyp\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":1,\"name\":\"Aktivitätstyp\",\"placeholder\":\"Aktivitätstyp\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Datum\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Date\",\"no\":2,\"unid\":2,\"name\":\"Datum\",\"placeholder\":\"Datum\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Startzeit\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Time\",\"no\":2,\"unid\":3,\"name\":\"Startzeit\",\"placeholder\":\"Startzeit\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Favorit\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":4,\"name\":\"Favorit\",\"placeholder\":\"Favorit\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":5,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Titel\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":5,\"name\":\"Titel\",\"placeholder\":\"Titel\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":6,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Distanz [km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":6,\"name\":\"Distanz [km]\",\"placeholder\":\"Distanz [km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":7,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Kalorien\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":7,\"name\":\"Kalorien\",\"placeholder\":\"Kalorien\",\"required\":\"0\",\"min\":\"0\",\"max\":\"10000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":8,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Dauer [min]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":8,\"name\":\"Dauer [min]\",\"placeholder\":\"Dauer [min]\",\"required\":\"1\",\"min\":\"0\",\"max\":\"600\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Herzfrequenz [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":9,\"name\":\"Durchschnittliche Herzfrequenz [bpm]\",\"placeholder\":\"Durchschnittliche Herzfrequenz [bpm]\",\"required\":\"0\",\"min\":\"60\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":10,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Herzfrequenz [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":10,\"name\":\"Maximale Herzfrequenz [bpm]\",\"placeholder\":\"Maximale Herzfrequenz [bpm]\",\"required\":\"0\",\"min\":\"60\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":11,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Aerober Trainingseffekt\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":11,\"name\":\"Aerober Trainingseffekt\",\"placeholder\":\"Aerober Trainingseffekt\",\"required\":\"0\",\"min\":\"0\",\"max\":\"10\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":12,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Schrittfrequenz (Laufen)\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":12,\"name\":\"Durchschnittliche Schrittfrequenz (Laufen)\",\"placeholder\":\"Durchschnittliche Schrittfrequenz (Laufen)\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":13,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Schrittfrequenz (Laufen)\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":13,\"name\":\"Maximale Schrittfrequenz (Laufen)\",\"placeholder\":\"Maximale Schrittfrequenz (Laufen)\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":14,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Geschwindigkeit [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":14,\"name\":\"Durchschnittliche Geschwindigkeit [km/h]\",\"placeholder\":\"Durchschnittliche Geschwindigkeit [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"200\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":15,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximale Geschwindigkeit [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":15,\"name\":\"Maximale Geschwindigkeit [km/h]\",\"placeholder\":\"Maximale Geschwindigkeit [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"200\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":16,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Positiver Höhenunterschied [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":16,\"name\":\"Positiver Höhenunterschied [m]\",\"placeholder\":\"Positiver Höhenunterschied [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"5000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":17,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Negativer Höhenunterschied [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":17,\"name\":\"Negativer Höhenunterschied [m]\",\"placeholder\":\"Negativer Höhenunterschied [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"5000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":18,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliche Schrittlänge [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":18,\"name\":\"Durchschnittliche Schrittlänge [m]\",\"placeholder\":\"Durchschnittliche Schrittlänge [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":19,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Durchschnittliches vertikales Verhältnis\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":19,\"name\":\"Durchschnittliches vertikales Verhältnis\",\"placeholder\":\"Durchschnittliches vertikales Verhältnis\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]}]}]}', '{\"1\":[\"Aktivitätstyp\",\"_Text\"],\"2\":[\"Datum\",\"_Date\"],\"3\":[\"Startzeit\",\"_Time\"],\"4\":[\"Favorit\",\"_Text\"],\"5\":[\"Titel\",\"_Text\"],\"6\":[\"Distanz [km]\",\"_Number\"],\"7\":[\"Kalorien\",\"_Number\"],\"8\":[\"Dauer [min]\",\"_Number\"],\"9\":[\"Durchschnittliche Herzfrequenz [bpm]\",\"_Number\"],\"10\":[\"Maximale Herzfrequenz [bpm]\",\"_Number\"],\"11\":[\"Aerober Trainingseffekt\",\"_Number\"],\"12\":[\"Durchschnittliche Schrittfrequenz (Laufen)\",\"_Number\"],\"13\":[\"Maximale Schrittfrequenz (Laufen)\",\"_Number\"],\"14\":[\"Durchschnittliche Geschwindigkeit [km/h]\",\"_Number\"],\"15\":[\"Maximale Geschwindigkeit [km/h]\",\"_Number\"],\"16\":[\"Positiver Höhenunterschied [m]\",\"_Number\"],\"17\":[\"Negativer Höhenunterschied [m]\",\"_Number\"],\"18\":[\"Durchschnittliche Schrittlänge [m]\",\"_Number\"],\"19\":[\"Durchschnittliches vertikales Verhältnis\",\"_Number\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(3, 'Demo Form', 'Demo Form', 1, '', '{\"title\":\"Demo Form (Demo Form)\",\"timer\":{\"has\":\"0\",\"min\":\"10\",\"period\":\"sec\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Page Test\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Text\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":1,\"name\":\"text\",\"placeholder\":\"text\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Textarea\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Textarea\",\"no\":2,\"unid\":2,\"name\":\"textarea\",\"placeholder\":\"textarea\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Number\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":3,\"name\":\"number\",\"placeholder\":\"number\",\"required\":\"0\",\"min\":\"\",\"max\":\"\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Html\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Html\",\"no\":2,\"text\":\"\",\"width\":\"50\"}]},{\"no\":5,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Date\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Date\",\"no\":2,\"unid\":4,\"name\":\"Date\",\"placeholder\":\"Date\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":6,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Time\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Time\",\"no\":2,\"unid\":5,\"name\":\"Time\",\"placeholder\":\"Time\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":7,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Period\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Period\",\"no\":2,\"unid\":6,\"name\":\"Period\",\"placeholder_from\":\"from\",\"placeholder_to\":\"to\",\"placeholder\":\"Period\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":8,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Dropdown\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Dropdown\",\"no\":2,\"unid\":7,\"name\":\"Dropdown\",\"opt\":\"Select an Option\",\"dd\":\"58\",\"has_color\":\"0\",\"color\":\"120|0\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Radio\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_RadioButtons\",\"no\":2,\"unid\":8,\"name\":\"Radio\",\"has_title\":\"1\",\"title\":\"Radio Desc\",\"talign\":\"center\",\"rdd\":\"53\",\"has_color\":\"0\",\"color\":\"120|0\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":10,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"accordion 1\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]},{\"no\":11,\"items\":[]}]}]}', '{\"1\":[\"text\",\"_Text\"],\"2\":[\"textarea\",\"_Textarea\"],\"3\":[\"number\",\"_Number\"],\"4\":[\"Date\",\"_Date\"],\"5\":[\"Time\",\"_Time\"],\"6\":[\"Period\",\"_Period\"],\"7\":[\"Dropdown\",\"_Dropdown\"],\"8\":[\"Radio\",\"_RadioButtons\"]}', '2023-03-14 18:29:50', 'admin', '2023-03-23 16:13:05', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `forms2categories`
--

CREATE TABLE `forms2categories` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `stop_date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forms2categories`
--

INSERT INTO `forms2categories` (`id`, `form_id`, `category_id`, `sort`, `status`, `stop_date`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 2, 1, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(2, 2, 2, 2, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(3, 3, 5, 1, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `forms_data`
--

CREATE TABLE `forms_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `res_json` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `created_end` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE `templates` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `location_id` smallint(6) NOT NULL DEFAULT '0',
  `group_id` smallint(6) NOT NULL DEFAULT '0',
  `form_id` int(11) NOT NULL DEFAULT '0',
  `template_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=forms_templates, 1=axis_templates, 2=groups_templates',
  `name` varchar(128) DEFAULT NULL,
  `data_json` text,
  `GlobalView` tinyint(1) NOT NULL DEFAULT '1',
  `GlobalEdit` tinyint(1) NOT NULL DEFAULT '0',
  `LocationView` tinyint(1) NOT NULL DEFAULT '1',
  `LocationEdit` tinyint(1) NOT NULL DEFAULT '0',
  `GroupView` tinyint(1) NOT NULL DEFAULT '1',
  `GroupEdit` tinyint(1) NOT NULL DEFAULT '0',
  `TrainerView` tinyint(1) NOT NULL DEFAULT '1',
  `TrainerEdit` tinyint(1) NOT NULL DEFAULT '0',
  `Private` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `templates`
--

INSERT INTO `templates` (`id`, `user_id`, `location_id`, `group_id`, `form_id`, `template_type`, `name`, `data_json`, `GlobalView`, `GlobalEdit`, `LocationView`, `LocationEdit`, `GroupView`, `GroupEdit`, `TrainerView`, `TrainerEdit`, `Private`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 1, 1, 0, 1, ' Auto Y-Achse', '{\"axis\":[{\"id\":\"axis_\",\"name\":\"\",\"color\":\"\",\"min\":\"\",\"max\":\"\",\"pos\":\"false\",\"grid\":\"0\"}]}', 1, 0, 1, 0, 1, 0, 1, 0, 0, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `private_key` varchar(64) DEFAULT NULL,
  `admins_id` varchar(64) NOT NULL DEFAULT '',
  `forms_select` varchar(512) NOT NULL DEFAULT '',
  `forms_standard` varchar(512) NOT NULL DEFAULT '',
  `stop_date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `location_id`, `name`, `status`, `private_key`, `admins_id`, `forms_select`, `forms_standard`, `stop_date`, `created`, `modified`) VALUES
(1, 1, 'Demo Group 1', 1, '', '3,4', '5_3', '', NULL, '2023-02-25 00:00:00', '2023-02-26 18:49:43'),
(2, 1, 'Demo Group 2', 3, 'privatekey2', '3', '', '', NULL, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(3, 1, 'Demo Group 3', 3, 'privatekey3', '3', '', '', NULL, '2023-02-25 00:00:00', '2023-02-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `admin_id` int(11) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `status`, `admin_id`, `created`, `modified`) VALUES
(1, 'Demo Location', 1, 2, '2023-02-26 00:00:00', '2023-02-26 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `ip` varchar(15) NOT NULL,
  `date` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_blocks`
--

CREATE TABLE `login_blocks` (
  `ip` varchar(15) NOT NULL,
  `expire` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sports`
--

CREATE TABLE `sports` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT '1',
  `name` varchar(64) DEFAULT NULL,
  `options` varchar(64) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sports`
--

INSERT INTO `sports` (`id`, `parent_id`, `name`, `options`, `status`, `created`, `modified`) VALUES
(1, 0, 'Ohne Zuordnung', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(2, 0, 'Kraft und Fitness', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(3, 0, 'Individualsportarten', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(4, 0, 'Mannschaftssportarten', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(5, 0, 'Trendsportarten', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(6, 0, 'Kampfsport', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(7, 0, 'Rückschlagspiele', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(11, 1, NULL, 'Keine', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(12, 1, NULL, 'Eiskunstlauf', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(13, 1, NULL, 'Kunstradfahren', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(14, 1, NULL, 'Tanzen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(15, 1, NULL, 'Rudern', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(16, 1, NULL, 'Sportstudent', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(17, 2, NULL, 'Fitness', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(18, 2, NULL, 'Kraftsport', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(19, 2, NULL, 'Krafttraining', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(20, 2, NULL, 'Kraft-Fitness', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(21, 3, NULL, 'Voltigieren', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(22, 3, NULL, 'Gewichtheben', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(23, 3, NULL, 'Crossfit', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(24, 3, NULL, 'Kickboxen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(25, 3, NULL, 'Geräteturnen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(26, 3, NULL, 'Moderner Fünfkampf', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(27, 3, NULL, 'Kanu', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(28, 3, NULL, 'Klettern', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(29, 3, NULL, 'Kunstturnen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(30, 3, NULL, 'Jogging / Laufen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(31, 3, NULL, 'Leichtathletik', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(32, 3, NULL, 'Mountainbike', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(33, 3, NULL, 'Radsport', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(34, 3, NULL, 'Schwimmen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(35, 3, NULL, 'Turnen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(36, 3, NULL, 'Triathlon', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(37, 4, NULL, 'Basketball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(38, 4, NULL, 'Fußball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(39, 4, NULL, 'Handball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(40, 4, NULL, 'Wasserball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(41, 4, NULL, 'Eishockey', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(42, 5, NULL, 'Curling', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(43, 5, NULL, 'Paragliding', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(44, 5, NULL, 'Kitesurfen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(45, 5, NULL, 'Windsurfen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(46, 5, NULL, 'Tauchen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(47, 5, NULL, 'Parkour', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(48, 5, NULL, 'Snowboarding', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(49, 6, NULL, 'Judo', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(50, 6, NULL, 'Thaiboxen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(51, 6, NULL, 'Taekwondo', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(52, 6, NULL, 'Ju-Jutsu', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(53, 6, NULL, 'Jiu jitsu', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(54, 7, NULL, 'Volleyball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(55, 7, NULL, 'Tennis', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(56, 7, NULL, 'Tischtennis', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(57, 7, NULL, 'Beachvolleyball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(58, 7, NULL, 'Badminton', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(32) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `templates_axis`
--

CREATE TABLE `templates_axis` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) DEFAULT NULL,
  `data_json` text,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `templates_axis`
--

INSERT INTO `templates_axis` (`id`, `user_id`, `location_id`, `group_id`, `name`, `data_json`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 1, 1, ' Auto Y-Achse', '{\"axis\":{\"id\":\"axis_\",\"name\":\"\",\"color\":\"\",\"min\":\"\",\"max\":\"\",\"pos\":\"false\",\"grid\":\"0\"}}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `templates_forms`
--

CREATE TABLE `templates_forms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `form_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) DEFAULT NULL,
  `data_json` mediumtext,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `templates_results`
--

CREATE TABLE `templates_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `location_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) DEFAULT NULL,
  `data_json` mediumtext,
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `account` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `passwd` varchar(255) DEFAULT NULL,
  `location_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `sport` varchar(50) DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `body_height` varchar(10) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `telephone` varchar(32) DEFAULT NULL,
  `level` int(4) NOT NULL DEFAULT '0',
  `status` smallint(3) NOT NULL DEFAULT '0',
  `permissions` varchar(255) DEFAULT NULL,
  `dashboard` tinyint(1) NOT NULL DEFAULT '1',
  `lastlogin` datetime DEFAULT NULL,
  `logincount` int(11) NOT NULL DEFAULT '0',
  `last_ip` varchar(15) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 PACK_KEYS=1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `account`, `uname`, `passwd`, `location_id`, `group_id`, `lastname`, `firstname`, `birth_date`, `sport`, `sex`, `body_height`, `email`, `telephone`, `level`, `status`, `permissions`, `dashboard`, `lastlogin`, `logincount`, `last_ip`, `created`, `modified`) VALUES
(1, 'admin', 'admin', '$2y$10$kg8vhoAyKcCrNzUH2NzGDu6zgZ1B1H6W2.E00TlzW8dEq1WROhBbK', 1, 1, 'Admin', 'Admin', '1980-01-01', 'Volleyball', 0, '187 cm', 'email@domain.com', NULL, 99, 1, NULL, 1, '2023-02-26 19:26:25', 3, '127.0.0.1', '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(2, 'user', 'DemoLocation', '$2y$10$kg8vhoAyKcCrNzUH2NzGDu6zgZ1B1H6W2.E00TlzW8dEq1WROhBbK', 1, 1, 'Admin', 'Location', '1980-01-01', 'Volleyball', 0, '190 cm', 'email@domain.com', NULL, 50, 1, NULL, 1, NULL, 0, '', '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(3, 'user', 'DemoGroupAdmin', '$2y$10$kg8vhoAyKcCrNzUH2NzGDu6zgZ1B1H6W2.E00TlzW8dEq1WROhBbK', 1, 1, 'Admin', 'Group', '1980-01-01', 'Volleyball', 0, '190 cm', 'email@domain.com', NULL, 45, 1, NULL, 1, NULL, 0, '', '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(4, 'user', 'DemoGroupAdmin2', '$2y$10$kg8vhoAyKcCrNzUH2NzGDu6zgZ1B1H6W2.E00TlzW8dEq1WROhBbK', 1, 1, 'Admin (reduced)', 'Group', '1980-01-01', 'Volleyball', 0, '187 cm', 'email@domain.com', NULL, 40, 1, NULL, 1, NULL, 0, '', '2023-02-25 00:00:00', '2023-02-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users2forms`
--

CREATE TABLE `users2forms` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `form_id` int(11) NOT NULL DEFAULT '0',
  `template_id` smallint(6) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users2groups`
--

CREATE TABLE `users2groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `forms_select` varchar(256) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '9',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users2groups`
--

INSERT INTO `users2groups` (`id`, `user_id`, `group_id`, `forms_select`, `status`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(1, 1, 1, NULL, 1, '2023-02-25 00:00:00', 'admin', '2023-02-26 18:49:55', 'admin'),
(2, 1, 2, NULL, 1, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(3, 1, 3, NULL, 1, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(4, 3, 1, NULL, 1, '2023-02-26 16:13:03', 'Auto_Init', '2023-02-26 16:13:03', 'Auto_Init'),
(5, 4, 1, NULL, 1, '2023-02-26 16:13:03', 'Auto_Init', '2023-02-26 16:13:03', 'Auto_Init');

-- --------------------------------------------------------

--
-- Table structure for table `users2trainers`
--

CREATE TABLE `users2trainers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0',
  `trainer_id` int(11) NOT NULL DEFAULT '0',
  `forms_select_read` varchar(256) DEFAULT NULL,
  `forms_select_write` varchar(256) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '9',
  `created` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`);

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`);

--
-- Indexes for table `dropdowns`
--
ALTER TABLE `dropdowns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms2categories`
--
ALTER TABLE `forms2categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `form_id` (`form_id`,`category_id`);

--
-- Indexes for table `forms_data`
--
ALTER TABLE `forms_data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`),
  ADD KEY `user_id_2` (`user_id`,`form_id`,`group_id`);

--
-- Indexes for table `templates`
--
ALTER TABLE `templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sports`
--
ALTER TABLE `sports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `templates_axis`
--
ALTER TABLE `templates_axis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`);

--
-- Indexes for table `templates_forms`
--
ALTER TABLE `templates_forms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`);

--
-- Indexes for table `templates_results`
--
ALTER TABLE `templates_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`group_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`,`uname`);

--
-- Indexes for table `users2forms`
--
ALTER TABLE `users2forms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`group_id`,`category_id`,`form_id`);

--
-- Indexes for table `users2groups`
--
ALTER TABLE `users2groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`group_id`);

--
-- Indexes for table `users2trainers`
--
ALTER TABLE `users2trainers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`group_id`,`trainer_id`),
  ADD KEY `user_id_2` (`user_id`,`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dropdowns`
--
ALTER TABLE `dropdowns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forms2categories`
--
ALTER TABLE `forms2categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forms_data`
--
ALTER TABLE `forms_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `templates`
--
ALTER TABLE `templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sports`
--
ALTER TABLE `sports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates_axis`
--
ALTER TABLE `templates_axis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `templates_forms`
--
ALTER TABLE `templates_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `templates_results`
--
ALTER TABLE `templates_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users2forms`
--
ALTER TABLE `users2forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users2groups`
--
ALTER TABLE `users2groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users2trainers`
--
ALTER TABLE `users2trainers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
