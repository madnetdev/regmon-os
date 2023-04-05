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
  `group_id` smallint(6) NOT NULL DEFAULT '0',
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
(11, 0, 'RPE-Skala (10 Stufen)', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(12, 11, NULL, '0__Ruhe', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(13, 11, NULL, '1__Sehr leicht', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(14, 11, NULL, '2__Leicht', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(15, 11, NULL, '3__Moderat', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(16, 11, NULL, '4__Schon härter', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(17, 11, NULL, '5__Hart', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(18, 11, NULL, '6__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(19, 11, NULL, '7__Sehr hart', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(20, 11, NULL, '8__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(21, 11, NULL, '9__Wirklich sehr hart', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(22, 11, NULL, '10__Maximal (mehr geht nicht)', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(23, 0, 'sRPE (BO Basketball)', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(24, 23, NULL, '0__Ruhe', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(25, 23, NULL, '1__Sehr, sehr leicht', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(26, 23, NULL, '2__Leicht', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(27, 23, NULL, '3__Mäßig', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(28, 23, NULL, '4__Etwas schwer', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(29, 23, NULL, '5__Schwer', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(30, 23, NULL, '6__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(31, 23, NULL, '7__Sehr schwer', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(32, 23, NULL, '8__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(33, 23, NULL, '9__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(34, 23, NULL, '10__Maximal', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(35, 0, 'Likert 0-6', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(36, 35, NULL, '0__trifft gar nicht zu', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(37, 35, NULL, '1__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(38, 35, NULL, '2__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(39, 35, NULL, '3__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(40, 35, NULL, '4__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(41, 35, NULL, '5__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(42, 35, NULL, '6__trifft voll zu', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(43, 0, 'Bewertung_Allgemein_0bis10', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(44, 43, NULL, '1__sehr schlecht', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(45, 43, NULL, '2__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(46, 43, NULL, '3__schlecht', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(47, 43, NULL, '4__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(48, 43, NULL, '5__mittelmäßig', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(49, 43, NULL, '6__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(50, 43, NULL, '7__gut', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(51, 43, NULL, '8__', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(52, 43, NULL, '9__sehr gut', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(53, 0, 'Trainingseinheiten', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(54, 53, NULL, '1__Athletiktraining', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(55, 53, NULL, '2__Techniktraining', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(56, 53, NULL, '3__Rehatraining', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(57, 53, NULL, '4__Keine Einheit', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(58, 0, 'Regeneration_Eishockey', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(59, 58, NULL, '1__Cool Down Aktivitäten (z.B. Auslaufen, Radfahren Ergometer)', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(60, 58, NULL, '2__Eigenmassage (Foam Roll)', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(61, 58, NULL, '3__Stretching/Nachdehnen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(62, 58, NULL, '4__Flüssigkeitszufuhr', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(63, 58, NULL, '5__Eisbad', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(64, 58, NULL, '6__Musik', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(65, 58, NULL, '7__Nahrungssupplemente', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(66, 58, NULL, '8__Atemtechniken', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(67, 58, NULL, '9__Kaltwasserdusche', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(68, 58, NULL, '10__Massage durch Physio', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(69, 58, NULL, '11__Kontrastdusche (heiß und kalt im Wechsel)', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(70, 58, NULL, '12__Kompressionskleidung', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(71, 58, NULL, '13__Progressive Muskelentspannung', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(72, 58, NULL, '14__Nahrungsaufnahme', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(73, 58, NULL, '15__Elektromyostimulation (EMS)', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(74, 58, NULL, '16__Schlafen/Ruhen (einschließlich Kurzschlaf)', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(75, 58, NULL, '17__Sauna', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(76, 58, NULL, '18__Vibration und Vibrationsmassage', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(77, 58, NULL, '19__Aktive Erholung im Schwimmbad/Whirlpool', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(78, 58, NULL, '20__Akupunktur', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(79, 58, NULL, '21__Debriefing (Strukturiertes Gespräch mit dem Trainer)', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(80, 58, NULL, '22__Kältekammer', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(81, 58, NULL, '23__Medikamentöse Maßnahmen', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(82, 58, NULL, '24__Meditation', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00');

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
  `data_json` text,
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
(3, 'Kurzskala Erholung und Beanspruchung', 'KEB (alt, mit neu zusammenführen!)', 1, 'Beanspruchung,Erholung,Fragebogen,Psychometrie', '{\"title\":\"Kurzskala Erholung und Beanspruchung (KEB Handy)\",\"timer\":{\"has\":false,\"min\":\"0\"},\"pages\":[{\"no\":1,\"title\":\"Kurzskala Erholung und Beanspruchung (KEB)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"><b>Kurzskala Erholung&nbsp;</b></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Im Folgenden geht es um verschiedene Facetten deines derzeitigen Erholungszustandes. Die Ausprägung \\\"trifft voll zu\\\" symbolisiert dabei den besten von dir jemals erreichten Erholungszustand.&nbsp;\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Körperliche Leistungsfähigkeit</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">kraftvoll,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">leistungsfähig,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">energiegeladen,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">voller Power</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":1,\"name\":\"Körperliche Leistungsfähigkeit (KL)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Mentale Leistungsfähigkeit</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">aufmerksam,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">aufnahmefähig,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">konzentriert,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">mental hellwach</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":8,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":2,\"name\":\"Mentale Leistungsfähigkeit (ML)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":9,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":10,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b>Emotionale Ausgeglichenheit</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">zufrieden,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">ausgeglichen,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">gut gelaunt,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">alles im Griff habend</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":11,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":3,\"name\":\"Emotionale Ausgeglichenheit (EA)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":12,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":13,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b>Allgemeiner Erholungszustand</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">erholt,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">ausgeruht,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär locker,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">körperlich entspannt</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":14,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":4,\"name\":\"Allgemeiner Erholungszustand (AE)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":15,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"><b>Kurzskala Beanspruchung&nbsp;</b></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2>\",\"width\":\"100\"}]},{\"no\":16,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Im Folgenden geht es um verschiedene Facetten deines derzeitigen Beanspruchungszustandes. Die Ausprägung \\\"trifft voll zu\\\" symbolisiert dabei den höchsten von dir jemals erreichten Beanspruchungszustand.&nbsp;\",\"width\":\"100\"}]},{\"no\":17,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":18,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Muskuläre Beanspruchung</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär überanstrengt,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär ermüdet,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär übersäuert,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär verhärtet</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":19,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":5,\"name\":\"Muskuläre Beanspruchung (MB)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":20,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":21,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Aktivierungsmangel</b><h3><span style=\\\"font-weight: normal;\\\"><sub><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i></sub><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">unmotiviert,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">antriebslos,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">lustlos,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">energielos</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":22,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":6,\"name\":\"Aktivierungsmangel (AM)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":23,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":24,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Emotionale Unausgeglichenheit</b><h3><span style=\\\"font-weight: normal;\\\"><sub><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i></sub><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">bedrückt,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">gestresst,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">genervt,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">leicht reizbar</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":25,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":7,\"name\":\"Emotionale Unausgeglichenheit (EU)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":26,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":27,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Allgemeiner Beanspruchungszustand</b><h3><span style=\\\"font-weight: normal;\\\"><sub><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i></sub><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">geschafft,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">entkräftet,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">überlastet,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">körperlich platt</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":28,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":8,\"name\":\"Allgemeiner Beanspruchungszustand (AB)\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"Körperliche Leistungsfähigkeit (KL)\",\"_RadioButtons\"],\"2\":[\"Mentale Leistungsfähigkeit (ML)\",\"_RadioButtons\"],\"3\":[\"Emotionale Ausgeglichenheit (EA)\",\"_RadioButtons\"],\"4\":[\"Allgemeiner Erholungszustand (AE)\",\"_RadioButtons\"],\"5\":[\"Muskuläre Beanspruchung (MB)\",\"_RadioButtons\"],\"6\":[\"Aktivierungsmangel (AM)\",\"_RadioButtons\"],\"7\":[\"Emotionale Unausgeglichenheit (EU)\",\"_RadioButtons\"],\"8\":[\"Allgemeiner Beanspruchungszustand (AB)\",\"_RadioButtons\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(4, 'Trainingsdokumentation', 'Trainingsdokumentation Eishockey Frauen (DEB)', 1, 'Training,Eishockey,DEB,Nationalmannschaft,Frauen', '{\"title\":\"Trainingsdokumentation\",\"timer\":{\"has\":false,\"min\":\"0\"},\"pages\":[{\"no\":1,\"title\":\"Dokumentation Eishockeytraining\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<div style=\\\"text-align: center;\\\"><img src=\\\"https://upload.wikimedia.org/wikipedia/commons/d/de/Logo_des_Deutschen_Eishockey-Bundes_e.V.png\\\" alt=\\\"\\\" width=\\\"300\\\" height=\\\"300\\\"><hr></div><div style=\\\"text-align: center;\\\"><span class=\\\"main_font\\\">Wie lange hast Du \\\"on-ice\\\" und \\\"off-ice\\\" in den untenstehenden Kategorien traini</span>ert?<br><hr><span class=\\\"main_font\\\"></span></div>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h1>ON-ICE</h1>\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Techniktraining\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":1,\"name\":\"Dauer Techniktraining (on-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Taktiktraining\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":2,\"name\":\"Dauer Taktiktraining (on-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":5,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Konditionstraining\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":3,\"name\":\"Dauer Konditionstraining (on-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":6,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Spielformen\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":4,\"name\":\"Dauer Spielformen (on-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":7,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"kombiniertes Training\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":5,\"name\":\"Dauer kombiniertes Training (on-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":8,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><h1>OFF-ICE</h1>\",\"width\":\"100\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Beschleunigungstraining\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":6,\"name\":\"Dauer Beschleunigungstraining (off-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":10,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Krafttraining\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":7,\"name\":\"Dauer Krafttraining (off-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":11,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Ausdauertraining\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":8,\"name\":\"Dauer Ausdauertraining (off-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":12,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"kombiniertes Training\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":9,\"name\":\"Dauer kombiniertes Training (off-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"33\"}]},{\"no\":13,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"freies Training\",\"align\":\"left\",\"width\":\"30\"},{\"type\":\"_Number\",\"no\":2,\"unid\":10,\"name\":\"Dauer freies Training (off-ice)\",\"placeholder\":\"hier Minuten eintragen\",\"required\":\"0\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":14,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"30\"},{\"type\":\"_Text\",\"no\":2,\"unid\":11,\"name\":\"Art des freien Trainings\",\"placeholder\":\"hier Art eintragen (z.B. Jogging, etc.)\",\"required\":\"0\",\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Art des freien Trainings\",\"align\":\"left\",\"width\":\"20\"}]},{\"no\":15,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\"text-align: center;\\\">Wie anstrengend war die Trainingseinheit?<br></div><hr>\",\"width\":\"100\"}]},{\"no\":16,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":12,\"name\":\"subjektives Belastungsempfinden (RPE)\",\"has_title\":\"1\",\"title\":\"Subjektives Belastungsempfinden\",\"talign\":\"left\",\"rdd\":\"11\",\"color\":\"1\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":17,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><p style=\\\"text-align: center;\\\">Möchtes Du noch etwas hinzufügen?<br></p><hr>\",\"width\":\"100\"}]},{\"no\":18,\"items\":[{\"type\":\"_Textarea\",\"no\":1,\"unid\":13,\"name\":\"zusätzliche Informationen\",\"placeholder\":\"Hier kannst Du Kommentare oder zusätzliche Informationen eintragen (optional)\",\"required\":\"0\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"Dauer Techniktraining (on-ice)\",\"_Number\"],\"2\":[\"Dauer Taktiktraining (on-ice)\",\"_Number\"],\"3\":[\"Dauer Konditionstraining (on-ice)\",\"_Number\"],\"4\":[\"Dauer Spielformen (on-ice)\",\"_Number\"],\"5\":[\"Dauer kombiniertes Training (on-ice)\",\"_Number\"],\"6\":[\"Dauer Beschleunigungstraining (off-ice)\",\"_Number\"],\"7\":[\"Dauer Krafttraining (off-ice)\",\"_Number\"],\"8\":[\"Dauer Ausdauertraining (off-ice)\",\"_Number\"],\"9\":[\"Dauer kombiniertes Training (off-ice)\",\"_Number\"],\"10\":[\"Dauer freies Training (off-ice)\",\"_Number\"],\"11\":[\"Art des freien Trainings\",\"_Text\"],\"12\":[\"subjektives Belastungsempfinden (RPE)\",\"_RadioButtons\"],\"13\":[\"zusätzliche Informationen\",\"_Textarea\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(5, 'Schlafdokumentation (kurz)', 'Schlafdokumentation (minimal)', 1, 'Erholung,Psychometrie,Schlaf', '{\"title\":\"Schlafdokumentation\",\"timer\":{\"has\":false,\"min\":\"0\"},\"pages\":[{\"no\":1,\"title\":\"Dokumentation Deiner Nacht / Deines Schlafs\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\"text-align: center;\\\">Wie lange hast Du geschlafen?<br><hr></div>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Period\",\"no\":1,\"unid\":1,\"name\":\"Schlafdauer\",\"placeholder_from\":\"von\",\"placeholder_to\":\"bis\",\"placeholder\":\"Schlafdauer hier eintragen\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\"text-align: center;\\\">Wie hast Du geschlafen?<br></div><hr>\",\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":2,\"name\":\"Schlafqualität\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"43\",\"color\":\"0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\"text-align: center;\\\">Möchtest Du noch etwas hinzufügen?<br></div><hr>\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Textarea\",\"no\":1,\"unid\":3,\"name\":\"zusätzlicher Kommentar Schlafdokumentation\",\"placeholder\":\"Hier kannst Du Kommentare oder zusätzliche Informationen eintragen (optional)\",\"required\":\"0\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"Schlafdauer\",\"_Period\"],\"2\":[\"Schlafqualität\",\"_RadioButtons\"],\"3\":[\"zusätzlicher Kommentar Schlafdokumentation\",\"_Textarea\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(6, 'Ruheherzfrequenz', 'Ruheherzfrequenz', 1, 'Erholung,Herzfrequenz', '{\"title\":\"Ruheherzfrequenz\",\"timer\":{\"has\":false,\"min\":\"0\"},\"pages\":[{\"no\":1,\"title\":\"Erfassung der Ruheherzfrequenz\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<div style=\\\"text-align: center;\\\"><span class=\\\"main_font\\\"></span><hr><span class=\\\"main_font\\\">Die Ruheherzfrequenz sollte <strong>morgens direkt nach dem Erwachen und liegend </strong>gemessen werden. Wenn Du keine Pulsuhr benutzt, dann zähle <strong>30 Sekunden </strong>lang deine Herzschläge und <strong>verdoppele die Zahl</strong>.</span><hr><span class=\\\"main_font\\\"></span></div>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Ruheherzfrequenz\",\"align\":\"left\",\"width\":\"25\"},{\"type\":\"_Number\",\"no\":2,\"unid\":1,\"name\":\"Ruheherzfrequenz\",\"placeholder\":\"hier Ruheherzfrequenz [bpm] eintragen\",\"required\":\"1\",\"min\":\"0\",\"max\":\"120\",\"decimal\":false,\"width\":\"50\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"1/min\",\"align\":\"left\",\"width\":\"25\"}]},{\"no\":3,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<hr><div style=\\\"text-align: center;\\\">Möchtest Du noch etwas hinzufügen?<br><hr></div>\",\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Textarea\",\"no\":1,\"unid\":2,\"name\":\"zusätzliche Information Ruheherzfrequenz\",\"placeholder\":\"Hier kannst Du Kommentare oder zusätzliche Informationen eintragen (optional)\",\"required\":\"0\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"Ruheherzfrequenz\",\"_Number\"],\"2\":[\"zusätzliche Information Ruheherzfrequenz\",\"_Textarea\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(7, 'Regenerationsmaßnahmen', 'Regenerationsmaßnahmen Eishockey', 1, 'Eishockey,Regeneration', '{\"title\":\"Regenerationsmaßnahmen\",\"timer\":{\"has\":false,\"min\":\"0\"},\"pages\":[{\"no\":1,\"title\":\"Angaben zu durchgeführter Regeneration\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<div style=\\\"text-align: center;\\\"><img src=\\\"https://upload.wikimedia.org/wikipedia/commons/d/de/Logo_des_Deutschen_Eishockey-Bundes_e.V.png\\\" alt=\\\"\\\" width=\\\"300\\\" height=\\\"300\\\"><hr></div><div style=\\\"text-align: center;\\\"><span class=\\\"main_font\\\">Bitte gib unten Informationen zu den von Dir durchgeführten Regenerationsmaßnahmen an:</span><br><hr><span class=\\\"main_font\\\"></span></div>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"1. Maßnahme\",\"align\":\"left\",\"width\":\"20\"},{\"type\":\"_Dropdown\",\"no\":2,\"unid\":1,\"name\":\"Regenerationsmaßnahme (1)\",\"opt\":\"Wähle eine Option\",\"dd\":\"58\",\"color\":\"0\",\"required\":\"1\",\"width\":\"40\"},{\"type\":\"_Text\",\"no\":3,\"unid\":2,\"name\":\"weitere Informationen zur 1. Regenerationsmaßnahme\",\"placeholder\":\"weitere Informationen (z.B. Dauer)\",\"required\":\"0\",\"width\":\"40\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"2. Maßnahme\",\"align\":\"left\",\"width\":\"20\"},{\"type\":\"_Dropdown\",\"no\":2,\"unid\":3,\"name\":\"Regenerationsmaßnahme (2)\",\"opt\":\"Wähle eine Option\",\"dd\":\"58\",\"color\":\"0\",\"required\":\"0\",\"width\":\"40\"},{\"type\":\"_Text\",\"no\":3,\"unid\":4,\"name\":\"weitere Informationen zur 2. Regenerationsmaßnahme\",\"placeholder\":\"weitere Informationen (z.B. Dauer)\",\"required\":\"0\",\"width\":\"40\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"3. Maßnahme\",\"align\":\"left\",\"width\":\"20\"},{\"type\":\"_Dropdown\",\"no\":2,\"unid\":5,\"name\":\"Regenerationsmaßnahme (3)\",\"opt\":\"Wähle eine Option\",\"dd\":\"58\",\"color\":\"0\",\"required\":\"0\",\"width\":\"40\"},{\"type\":\"_Text\",\"no\":3,\"unid\":6,\"name\":\"weitere Informationen zur 3. Regenerationsmaßnahme\",\"placeholder\":\"weitere Informationen (z.B. Dauer)\",\"required\":\"0\",\"width\":\"40\"}]},{\"no\":5,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<div style=\\\"text-align: center;\\\"><hr>Möchtes Du noch etwas hinzufügen?<br><hr></div>\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Textarea\",\"no\":1,\"unid\":7,\"name\":\"zusätzliche Informationen Dokumentation Regeneration\",\"placeholder\":\"Hier kannst Du Kommentare oder zusätzliche Informationen eintragen (optional)\",\"required\":\"0\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"Regenerationsmaßnahme (1)\",\"_Dropdown\"],\"2\":[\"weitere Informationen zur 1. Regenerationsmaßnahme\",\"_Text\"],\"3\":[\"Regenerationsmaßnahme (2)\",\"_Dropdown\"],\"4\":[\"weitere Informationen zur 2. Regenerationsmaßnahme\",\"_Text\"],\"5\":[\"Regenerationsmaßnahme (3)\",\"_Dropdown\"],\"6\":[\"weitere Informationen zur 3. Regenerationsmaßnahme\",\"_Text\"],\"7\":[\"zusätzliche Informationen Dokumentation Regeneration\",\"_Textarea\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');
INSERT INTO `forms` (`id`, `name`, `name2`, `status`, `tags`, `data_json`, `data_names`, `created`, `created_by`, `modified`, `modified_by`) VALUES
(8, 'Kurzskala Erholung und Beanspruchung (KEB)', 'offizielles REGman-Formular (KEB)', 1, 'AggFa,Beanspruchung,Erholung,Fragebogen,Psychometrie', '{\"title\":\"KEB (neu, aktuelle Version) (Kurzskala Erholung und Beanspruchung (KEB))\",\"timer\":{\"has\":\"1\",\"min\":\"5\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"3\",\"title\":\"Kurzskala Erholung und Beanspruchung (KEB)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Hinweise zur Bearbeitung des Fragebogens\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<p>Auf der nächsten Seite finden sich eine Reihe von Aussagen, die sich auf Ihr körperliches und seelisches Befinden beziehen. Bitte überlegen Sie bei jeder Aussage, in welchem Maße diese auf Sie zutrifft. <br></p><p>Zur Beurteilung steht Ihnen eine siebenfach abgestufte Skala zur Verfügung. <br></p>\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Körperliche Leistungsfähigkeit</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">kraftvoll,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">leistungsfähig,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">energiegeladen,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">voller Power</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":1,\"name\":\"KEB_Beispiel\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"0\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<p>Bitte denken Sie nicht zu lange über eine Aussage nach, sondern treffen Sie möglichst spontan eine Wahl.</p><p>Überlegen Sie bitte nicht, welche Beantwortung möglicherweise auf den ersten Blick einen bestimmten Eindruck vermittelt, sondern stufen Sie die Aussagen so ein, wie es für Sie persönlich am ehesten zutrifft. Es gibt dabei keine richtigen oder falschen Antworten. <br></p>\",\"width\":\"100\"}]}]},{\"no\":2,\"display_times\":\"0\",\"title\":\"Kurzskala Erholung und Beanspruchung (KEB)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"><b>Kurzskala Erholung&nbsp;</b></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Im Folgenden geht es um verschiedene Facetten deines derzeitigen Erholungszustandes. Die Ausprägung \\\"trifft voll zu\\\" symbolisiert dabei den besten von dir jemals erreichten Erholungszustand.&nbsp;\",\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Körperliche Leistungsfähigkeit</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">kraftvoll,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">leistungsfähig,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">energiegeladen,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">voller Power</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":5,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":2,\"name\":\"Körperliche Leistungsfähigkeit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Mentale Leistungsfähigkeit</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">aufmerksam,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">aufnahmefähig,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">konzentriert,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">mental hellwach</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":8,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":3,\"name\":\"Mentale Leistungsfähigkeit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":9,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":10,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b>Emotionale Ausgeglichenheit</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">zufrieden,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">ausgeglichen,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">gut gelaunt,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">alles im Griff habend</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":11,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":4,\"name\":\"Emotionale Ausgeglichenheit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":12,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":13,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b>Allgemeiner Erholungszustand</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">erholt,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">ausgeruht,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär locker,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">körperlich entspannt</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":14,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":5,\"name\":\"Allgemeiner Erholungszustand\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":15,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"><b>Kurzskala Beanspruchung&nbsp;</b></span></h2><hr><h2 style=\\\"text-align: center;\\\"><span style=\\\"background-color: transparent;\\\"></span></h2>\",\"width\":\"100\"}]},{\"no\":16,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"Im Folgenden geht es um verschiedene Facetten deines derzeitigen Beanspruchungszustandes. Die Ausprägung \\\"trifft voll zu\\\" symbolisiert dabei den höchsten von dir jemals erreichten Beanspruchungszustand.&nbsp;\",\"width\":\"100\"}]},{\"no\":17,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":18,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Muskuläre Beanspruchung</b><h3><span style=\\\"font-weight: normal;\\\"><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär überanstrengt,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär ermüdet,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär übersäuert,&nbsp;</i><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">muskulär verhärtet</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":19,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":6,\"name\":\"Muskuläre Beanspruchung\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":20,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":21,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Aktivierungsmangel</b><h3><span style=\\\"font-weight: normal;\\\"><sub><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i></sub><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">unmotiviert,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">antriebslos,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">lustlos,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">energielos</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":22,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":7,\"name\":\"Aktivierungsmangel\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":23,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":24,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Emotionale Unausgeglichenheit</b><h3><span style=\\\"font-weight: normal;\\\"><sub><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i></sub><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">bedrückt,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">gestresst,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">genervt,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">leicht reizbar</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":25,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":8,\"name\":\"Emotionale Unausgeglichenheit\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":26,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":27,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<b> Allgemeiner Beanspruchungszustand</b><h3><span style=\\\"font-weight: normal;\\\"><sub><i style=\\\"font-size: 12.75px; color: inherit; background-color: transparent;\\\">z.B.&nbsp;</i></sub><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">geschafft,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">entkräftet,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">überlastet,&nbsp;</i><i style=\\\"font-size: 12.75px; vertical-align: sub; color: inherit; background-color: transparent;\\\">körperlich platt</i></span></h3><h4><span style=\\\"font-weight: normal;\\\"><sub><span style=\\\"vertical-align: super;\\\"><i></i></span><i style=\\\"\\\"><p style=\\\"\\\"></p></i></sub><p style=\\\"vertical-align: super;\\\"></p></span></h4>\",\"width\":\"100\"}]},{\"no\":28,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":9,\"name\":\"Allgemeiner Beanspruchungszustand\",\"has_title\":\"0\",\"title\":\"\",\"talign\":\"left\",\"rdd\":\"35\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]}]}]}', '{\"1\":[\"KEB_Beispiel\",\"_RadioButtons\"],\"2\":[\"Körperliche Leistungsfähigkeit\",\"_RadioButtons\"],\"3\":[\"Mentale Leistungsfähigkeit\",\"_RadioButtons\"],\"4\":[\"Emotionale Ausgeglichenheit\",\"_RadioButtons\"],\"5\":[\"Allgemeiner Erholungszustand\",\"_RadioButtons\"],\"6\":[\"Muskuläre Beanspruchung\",\"_RadioButtons\"],\"7\":[\"Aktivierungsmangel\",\"_RadioButtons\"],\"8\":[\"Emotionale Unausgeglichenheit\",\"_RadioButtons\"],\"9\":[\"Allgemeiner Beanspruchungszustand\",\"_RadioButtons\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(9, 'Trainingsdokumentation', 'Trainingsdokumentation (SC Freiburg)', 1, 'Training,Training Load', '{\"title\":\"Trainingsdokumentation (SC Freiburg) (Trainingsdokumentation)\",\"timer\":{\"has\":true,\"min\":\"15\"},\"pages\":[{\"no\":1,\"title\":\"Trainingsdokumentation \",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Html\",\"no\":1,\"text\":\"<div style=\\\"text-align: center;\\\"><img src=\\\"https://upload.wikimedia.org/wikipedia/de/f/f1/SC-Freiburg_Logo-neu.svg\\\" alt=\\\"\\\" width=\\\"200\\\" height=\\\"200\\\"></div>\",\"width\":\"100\"}]},{\"no\":2,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":3,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":1,\"name\":\"sRPE_Fußball\",\"has_title\":\"1\",\"title\":\"Wie war das Fußballtraining?\",\"talign\":\"left\",\"rdd\":\"23\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Dauer der Trainingseinheit\",\"align\":\"left\",\"width\":\"33\"},{\"type\":\"_Number\",\"no\":2,\"unid\":2,\"name\":\"Trainingsminuten_Fußball\",\"placeholder\":\"\",\"required\":\"1\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"33\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"33\"}]},{\"no\":5,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":6,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":3,\"name\":\"Trainingsdoku_zusätzliche Einheit\",\"has_title\":\"1\",\"title\":\"Welche zusätzliche Trainingseinheit hast du gemacht?\",\"talign\":\"center\",\"rdd\":\"53\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":7,\"items\":[{\"type\":\"_Space\",\"no\":1,\"width\":\"100\"}]},{\"no\":8,\"items\":[{\"type\":\"_RadioButtons\",\"no\":1,\"unid\":4,\"name\":\"sRPE_zusätzliche Einheit\",\"has_title\":\"1\",\"title\":\"Wie war die zusätzliche Trainingseinheit\",\"talign\":\"left\",\"rdd\":\"23\",\"has_color\":\"0\",\"color\":\"0|0\",\"required\":\"1\",\"width\":\"100\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Dauer der Trainingseinheit\",\"align\":\"left\",\"width\":\"33\"},{\"type\":\"_Number\",\"no\":2,\"unid\":5,\"name\":\"Trainingsminuten_zusätzliche Einheit\",\"placeholder\":\"\",\"required\":\"1\",\"min\":\"0\",\"max\":\"300\",\"decimal\":false,\"width\":\"33\"},{\"type\":\"_Label\",\"no\":3,\"label\":\"Minuten\",\"align\":\"left\",\"width\":\"33\"}]}]}]}', '{\"1\":[\"sRPE_Fußball\",\"_RadioButtons\"],\"2\":[\"Trainingsminuten_Fußball\",\"_Number\"],\"3\":[\"Trainingsdoku_zusätzliche Einheit\",\"_RadioButtons\"],\"4\":[\"sRPE_zusätzliche Einheit\",\"_RadioButtons\"],\"5\":[\"Trainingsminuten_zusätzliche Einheit\",\"_Number\"]}', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(10, 'test1', 'test1', 1, '', '{\"title\":\"test1 (test1)\",\"timer\":{\"has\":\"0\",\"min\":\"10\",\"period\":\"sec\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Page Test\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Text\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":1,\"name\":\"text\",\"placeholder\":\"text\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Textarea\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Textarea\",\"no\":2,\"unid\":2,\"name\":\"textarea\",\"placeholder\":\"textarea\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Number\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":3,\"name\":\"number\",\"placeholder\":\"number\",\"required\":\"0\",\"min\":\"\",\"max\":\"\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Html\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Html\",\"no\":2,\"text\":\"\",\"width\":\"50\"}]},{\"no\":5,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Date\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Date\",\"no\":2,\"unid\":4,\"name\":\"Date\",\"placeholder\":\"Date\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":6,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Time\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Time\",\"no\":2,\"unid\":5,\"name\":\"Time\",\"placeholder\":\"Time\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":7,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Period\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Period\",\"no\":2,\"unid\":6,\"name\":\"Period\",\"placeholder_from\":\"from\",\"placeholder_to\":\"to\",\"placeholder\":\"Period\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":8,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Dropdown\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_Dropdown\",\"no\":2,\"unid\":7,\"name\":\"Dropdown\",\"opt\":\"Select an Option\",\"dd\":\"58\",\"has_color\":\"0\",\"color\":\"120|0\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Radio\",\"align\":\"left\",\"bold\":\"0\",\"width\":\"50\"},{\"type\":\"_RadioButtons\",\"no\":2,\"unid\":8,\"name\":\"Radio\",\"has_title\":\"1\",\"title\":\"Radio Desc\",\"talign\":\"center\",\"rdd\":\"53\",\"has_color\":\"0\",\"color\":\"120|0\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":10,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"accordion 1\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Accordion\",\"no\":1,\"accType\":false,\"width\":\"100\",\"Panels\":[{\"type\":\"_Accordion_Panel\",\"no\":1,\"acc_no\":1,\"label\":\"\",\"align\":\"left\",\"bold\":\"0\",\"open\":false,\"Rows\":[{\"no\":1,\"items\":[{\"type\":\"_Line\",\"no\":1,\"width\":\"100\"}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]}]},{\"no\":11,\"items\":[]}]}]}', '{\"1\":[\"text\",\"_Text\"],\"2\":[\"textarea\",\"_Textarea\"],\"3\":[\"number\",\"_Number\"],\"4\":[\"Date\",\"_Date\"],\"5\":[\"Time\",\"_Time\"],\"6\":[\"Period\",\"_Period\"],\"7\":[\"Dropdown\",\"_Dropdown\"],\"8\":[\"Radio\",\"_RadioButtons\"]}', '2023-03-14 18:29:50', 'admin', '2023-03-23 16:13:05', 'admin');

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
(1, 4, 2, 1, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(2, 6, 5, 1, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(3, 5, 4, 2, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(4, 3, 4, 3, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(5, 7, 3, 1, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(6, 8, 4, 1, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(7, 9, 2, 2, 1, NULL, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `forms_data`
--

CREATE TABLE `forms_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `group_id` smallint(6) NOT NULL DEFAULT '0',
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
  `template_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=forms_templates, 1=axis, 2=groups_templates',
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
(1, 1, 'Demo Group 1', 1, '', '3,4', '2_4,2_9,4_8,4_5,4_3,5_6,3_7', '2_4,4_8', NULL, '2023-02-25 00:00:00', '2023-02-26 18:49:43'),
(2, 1, 'Demo Group 2', 3, 'privatekey2', '3', '2_4,2_9,4_8,4_5,4_3,5_6,3_7', '2_4,4_8', NULL, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(3, 1, 'Demo Group 3', 3, 'privatekey3', '3', '2_4,2_9,4_8,4_5,4_3,5_6,3_7', '2_4,4_8', NULL, '2023-02-25 00:00:00', '2023-02-25 00:00:00');

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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `account` varchar(50) NOT NULL,
  `uname` varchar(50) NOT NULL,
  `passwd` varchar(60) DEFAULT NULL,
  `location_id` tinyint(1) NOT NULL DEFAULT '0',
  `group_id` smallint(6) NOT NULL DEFAULT '0',
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
(1, 'admin', 'admin', 'c4b95c4dad6f4bec7643d9788f249516', 1, 1, 'Admin', 'Admin', '1980-01-01', 'Volleyball', 0, '187 cm', 'email@domain.com', NULL, 99, 1, NULL, 1, '2023-02-26 19:26:25', 3, '127.0.0.1', '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(2, 'user', 'DemoLocation', 'c4b95c4dad6f4bec7643d9788f249516', 1, 1, 'Admin', 'Location', '1980-01-01', 'Volleyball', 0, '190 cm', 'email@domain.com', NULL, 50, 1, NULL, 1, NULL, 0, '', '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(3, 'user', 'DemoGroupAdmin', 'c4b95c4dad6f4bec7643d9788f249516', 1, 1, 'Admin', 'Group', '1980-01-01', 'Volleyball', 0, '190 cm', 'email@domain.com', NULL, 45, 1, NULL, 1, NULL, 0, '', '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(4, 'user', 'DemoGroupAdmin2', 'c4b95c4dad6f4bec7643d9788f249516', 1, 1, 'Admin (reduced)', 'Group', '1980-01-01', 'Volleyball', 0, '187 cm', 'email@domain.com', NULL, 40, 1, NULL, 1, NULL, 0, '', '2023-02-25 00:00:00', '2023-02-25 00:00:00');

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
(1, 1, 1, '2_4,2_9,4_8,4_5,4_3,5_6,3_7', 1, '2023-02-25 00:00:00', 'admin', '2023-02-26 18:49:55', 'admin'),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `forms2categories`
--
ALTER TABLE `forms2categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `forms_data`
--
ALTER TABLE `forms_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
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