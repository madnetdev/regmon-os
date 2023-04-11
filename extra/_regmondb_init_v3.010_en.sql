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
(1, 0, 2, 'Diagnosis', 1, '#f2f2f2', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(2, 0, 1, 'Training and Competition', 1, '#5B9BD5', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(3, 0, 3, 'Regeneration', 1, '#70AD47', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(4, 1, 1, 'Psychometry', 1, '#ED7D31', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin'),
(5, 1, 2, 'Physiology and Performance', 1, '#A5A5A5', '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');

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
(1, 'Training Session (Polar)', 'Polar Import Standard Form', 1, 'Heart Rate,Import,Training,Wearables,Polar', '{\"title\":\"Polar Import Standard Form (Training Session (Polar))\",\"timer\":{\"has\":\"0\",\"min\":\"0\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Imported Training Session (Polar)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Name\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":1,\"name\":\"Name\",\"placeholder\":\"Name\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Sport\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":2,\"name\":\"Sport\",\"placeholder\":\"Sport\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Date\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Date\",\"no\":2,\"unid\":3,\"name\":\"Date\",\"placeholder\":\"Date\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Start Time\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Time\",\"no\":2,\"unid\":4,\"name\":\"Start Time\",\"placeholder\":\"Start Time\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":5,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Period [min]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":5,\"name\":\"Period [min]\",\"placeholder\":\"Period [min]\",\"required\":\"1\",\"min\":\"0\",\"max\":\"600\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":6,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Total Distance [km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":6,\"name\":\"Total Distance [km]\",\"placeholder\":\"Total Distance [km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"150\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":7,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Heart Rate [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":7,\"name\":\"Average Heart Rate [bpm]\",\"placeholder\":\"Average Heart Rate [bpm]\",\"required\":\"0\",\"min\":\"60\",\"max\":\"220\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":8,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Speed [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":8,\"name\":\"Average Speed [km/h]\",\"placeholder\":\"Average Speed [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Speed [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":9,\"name\":\"Maximum Speed [km/h]\",\"placeholder\":\"Maximum Speed [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":10,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Pace [min/km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":10,\"name\":\"Average Pace [min/km]\",\"placeholder\":\"Average Pace [min/km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":11,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Pace [min/km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":11,\"name\":\"Maximum Pace [min/km]\",\"placeholder\":\"Maximum Pace [min/km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":12,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Calories\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":12,\"name\":\"Calories\",\"placeholder\":\"Calories\",\"required\":\"0\",\"min\":\"0\",\"max\":\"10000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":13,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Fat percentage of calories [%]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":13,\"name\":\"Fat percentage of calories [%]\",\"placeholder\":\"Fat percentage of calories [%]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":14,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average cadence [rpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":14,\"name\":\"Average cadence [rpm]\",\"placeholder\":\"Average cadence [rpm]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":15,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average stride length [cm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":15,\"name\":\"Average stride length [cm]\",\"placeholder\":\"Average stride length [cm]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"200\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":16,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Running index\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":16,\"name\":\"Running index\",\"placeholder\":\"Running index\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":17,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Training Load\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":17,\"name\":\"Training Load\",\"placeholder\":\"Training Load\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":18,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Ascent [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":18,\"name\":\"Ascent [m]\",\"placeholder\":\"Ascent [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":19,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Descent [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":19,\"name\":\"Descent [m]\",\"placeholder\":\"Descent [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":20,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Power [W]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":20,\"name\":\"Average Power [W]\",\"placeholder\":\"Average Power [W]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":21,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Power [W]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":21,\"name\":\"Maximum Power [W]\",\"placeholder\":\"Maximum Power [W]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"5000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":22,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Notes\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Textarea\",\"no\":2,\"unid\":22,\"name\":\"Notes\",\"placeholder\":\"Notes\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":23,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Height [cm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":23,\"name\":\"Height [cm]\",\"placeholder\":\"Height [cm]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":24,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Weight [kg]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":24,\"name\":\"Weight [kg]\",\"placeholder\":\"Weight [kg]\",\"required\":\"0\",\"min\":\"20\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":25,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Heart Rate [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":25,\"name\":\"Maximum Heart Rate [bpm]\",\"placeholder\":\"Maximum Heart Rate [bpm]\",\"required\":\"0\",\"min\":\"100\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":26,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Minimale Heart Rate [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":26,\"name\":\"Minimale Heart Rate [bpm]\",\"placeholder\":\"Minimale Heart Rate [bpm]\",\"required\":\"0\",\"min\":\"30\",\"max\":\"150\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":27,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Oxygen Uptake\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":27,\"name\":\"Maximum Oxygen Uptake\",\"placeholder\":\"Maximum Oxygen Uptake\",\"required\":\"0\",\"min\":\"0\",\"max\":\"150\",\"decimal\":false,\"width\":\"50\"}]}]}]}', '{\"1\":[\"Name\",\"_Text\"],\"2\":[\"Sport\",\"_Text\"],\"3\":[\"Date\",\"_Date\"],\"4\":[\"Start Time\",\"_Time\"],\"5\":[\"Period [min]\",\"_Number\"],\"6\":[\"Total Distance [km]\",\"_Number\"],\"7\":[\"Average Heart Rate [bpm]\",\"_Number\"],\"8\":[\"Average Speed [km/h]\",\"_Number\"],\"9\":[\"Maximum Speed [km/h]\",\"_Number\"],\"10\":[\"Average Pace [min/km]\",\"_Number\"],\"11\":[\"Maximum Pace [min/km]\",\"_Number\"],\"12\":[\"Calories\",\"_Number\"],\"13\":[\"Fat percentage of calories [%]\",\"_Number\"],\"14\":[\"Average cadence [rpm]\",\"_Number\"],\"15\":[\"Average stride length [cm]\",\"_Number\"],\"16\":[\"Running index\",\"_Number\"],\"17\":[\"Training Load\",\"_Number\"],\"18\":[\"Ascent [m]\",\"_Number\"],\"19\":[\"Descent [m]\",\"_Number\"],\"20\":[\"Average Power [W]\",\"_Number\"],\"21\":[\"Maximum Power [W]\",\"_Number\"],\"22\":[\"Notes\",\"_Textarea\"],\"23\":[\"Height [cm]\",\"_Number\"],\"24\":[\"Weight [kg]\",\"_Number\"],\"25\":[\"Maximum Heart Rate [bpm]\",\"_Number\"],\"26\":[\"Minimale Heart Rate [bpm]\",\"_Number\"],\"27\":[\"Maximum Oxygen Uptake\",\"_Number\"]}', '2023-04-10 21:01:19', 'admin', '2023-04-10 21:01:19', 'admin'),
(2, 'Training Session (Garmin)', 'Garmin Import Standard Form', 1, 'Heart Rate,Import,Training,Wearables,Garmin', '{\"title\":\"Garmin Import Standard Form (Training Session (Garmin))\",\"timer\":{\"has\":\"0\",\"min\":\"0\",\"period\":\"min\"},\"days\":{\"has\":\"0\",\"arr\":[1,2,3,4,5,6,7]},\"pages\":[{\"no\":1,\"display_times\":\"0\",\"title\":\"Imported Training Session (Garmin)\",\"title_center\":true,\"rows\":[{\"no\":1,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Activity Type\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":1,\"name\":\"Activity Type\",\"placeholder\":\"Activity Type\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":2,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Date\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Date\",\"no\":2,\"unid\":2,\"name\":\"Date\",\"placeholder\":\"Date\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":3,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Start Time\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Time\",\"no\":2,\"unid\":3,\"name\":\"Start Time\",\"placeholder\":\"Start Time\",\"required\":\"1\",\"width\":\"50\"}]},{\"no\":4,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Favourite\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":4,\"name\":\"Favourite\",\"placeholder\":\"Favourite\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":5,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Title\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Text\",\"no\":2,\"unid\":5,\"name\":\"Title\",\"placeholder\":\"Title\",\"required\":\"0\",\"width\":\"50\"}]},{\"no\":6,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Distance [km]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":6,\"name\":\"Distance [km]\",\"placeholder\":\"Distance [km]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":7,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Calories\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":7,\"name\":\"Calories\",\"placeholder\":\"Calories\",\"required\":\"0\",\"min\":\"0\",\"max\":\"10000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":8,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Period [min]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":8,\"name\":\"Period [min]\",\"placeholder\":\"Period [min]\",\"required\":\"1\",\"min\":\"0\",\"max\":\"600\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":9,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Heart Rate [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":9,\"name\":\"Average Heart Rate [bpm]\",\"placeholder\":\"Average Heart Rate [bpm]\",\"required\":\"0\",\"min\":\"60\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":10,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Heart Rate [bpm]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":10,\"name\":\"Maximum Heart Rate [bpm]\",\"placeholder\":\"Maximum Heart Rate [bpm]\",\"required\":\"0\",\"min\":\"60\",\"max\":\"250\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":11,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Aerobic Training Effect\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":11,\"name\":\"Aerobic Training Effect\",\"placeholder\":\"Aerobic Training Effect\",\"required\":\"0\",\"min\":\"0\",\"max\":\"10\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":12,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Step Frequency (Running)\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":12,\"name\":\"Average Step Frequency (Running)\",\"placeholder\":\"Average Step Frequency (Running)\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":13,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Step Frequency (Running)\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":13,\"name\":\"Maximum Step Frequency (Running)\",\"placeholder\":\"Maximum Step Frequency (Running)\",\"required\":\"0\",\"min\":\"0\",\"max\":\"500\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":14,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Speed [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":14,\"name\":\"Average Speed [km/h]\",\"placeholder\":\"Average Speed [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"200\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":15,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Maximum Speed [km/h]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":15,\"name\":\"Maximum Speed [km/h]\",\"placeholder\":\"Maximum Speed [km/h]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"200\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":16,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Positive Height Difference [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":16,\"name\":\"Positive Height Difference [m]\",\"placeholder\":\"Positive Height Difference [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"5000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":17,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Negative Height Difference [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":17,\"name\":\"Negative Height Difference [m]\",\"placeholder\":\"Negative Height Difference [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"5000\",\"decimal\":false,\"width\":\"50\"}]},{\"no\":18,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Stride Length [m]\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":18,\"name\":\"Average Stride Length [m]\",\"placeholder\":\"Average Stride Length [m]\",\"required\":\"0\",\"min\":\"0\",\"max\":\"3\",\"decimal\":true,\"width\":\"50\"}]},{\"no\":19,\"items\":[{\"type\":\"_Label\",\"no\":1,\"label\":\"Average Vertical Ratio\",\"align\":\"left\",\"bold\":\"1\",\"width\":\"50\"},{\"type\":\"_Number\",\"no\":2,\"unid\":19,\"name\":\"Average Vertical Ratio\",\"placeholder\":\"Average Vertical Ratio\",\"required\":\"0\",\"min\":\"0\",\"max\":\"100\",\"decimal\":true,\"width\":\"50\"}]}]}]}', '{\"1\":[\"Activity Type\",\"_Text\"],\"2\":[\"Date\",\"_Date\"],\"3\":[\"Start Time\",\"_Time\"],\"4\":[\"Favourite\",\"_Text\"],\"5\":[\"Title\",\"_Text\"],\"6\":[\"Distance [km]\",\"_Number\"],\"7\":[\"Calories\",\"_Number\"],\"8\":[\"Period [min]\",\"_Number\"],\"9\":[\"Average Heart Rate [bpm]\",\"_Number\"],\"10\":[\"Maximum Heart Rate [bpm]\",\"_Number\"],\"11\":[\"Aerobic Training Effect\",\"_Number\"],\"12\":[\"Average Step Frequency (Running)\",\"_Number\"],\"13\":[\"Maximum Step Frequency (Running)\",\"_Number\"],\"14\":[\"Average Speed [km/h]\",\"_Number\"],\"15\":[\"Maximum Speed [km/h]\",\"_Number\"],\"16\":[\"Positive Height Difference [m]\",\"_Number\"],\"17\":[\"Negative Height Difference [m]\",\"_Number\"],\"18\":[\"Average Stride Length [m]\",\"_Number\"],\"19\":[\"Average Vertical Ratio\",\"_Number\"]}', '2023-04-10 21:01:23', 'admin', '2023-04-10 21:01:23', 'admin'),
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
(1, 1, 1, 1, 0, 1, ' Auto Y-Axis', '{\"axis\":[{\"id\":\"axis_\",\"name\":\"\",\"color\":\"\",\"min\":\"\",\"max\":\"\",\"pos\":\"false\",\"grid\":\"0\"}]}', 1, 0, 1, 0, 1, 0, 1, 0, 0, '2023-02-25 00:00:00', 'admin', '2023-02-25 00:00:00', 'admin');

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
(1, 0, 'Without Sport Group', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(2, 0, 'Strength and Fitness', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(3, 0, 'Individual Sports', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(4, 0, 'Team Sports', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(5, 0, 'Trend Sports', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(6, 0, 'Martial Arts', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(7, 0, 'Racquet Games', NULL, 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(11, 1, NULL, 'Nothing', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(12, 1, NULL, 'Figure Skating', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(13, 1, NULL, 'Artistic Cycling', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(14, 1, NULL, 'Dance', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(15, 1, NULL, 'Rowing', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(16, 1, NULL, 'Sports Student', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(17, 2, NULL, 'Fitness', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(18, 2, NULL, 'Weight Training', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(19, 2, NULL, 'Weight Training', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(20, 2, NULL, 'Strength-Fitness', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(21, 3, NULL, 'Vaulting', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(22, 3, NULL, 'Weightlifting', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(23, 3, NULL, 'Crossfit', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(24, 3, NULL, 'Kickboxing', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(25, 3, NULL, 'Apparatus Gymnastics', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(26, 3, NULL, 'Modern Pentathlon', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(27, 3, NULL, 'Canoe', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(28, 3, NULL, 'Climb', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(29, 3, NULL, 'Artistic Gymnastics', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(30, 3, NULL, 'Jogging / Running', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(31, 3, NULL, 'Athletics', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(32, 3, NULL, 'Mountain Bike', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(33, 3, NULL, 'Cycling', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(34, 3, NULL, 'Swimming', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(35, 3, NULL, 'Gymnastics', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(36, 3, NULL, 'Triathlon', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(37, 4, NULL, 'Basketball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(38, 4, NULL, 'Football', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(39, 4, NULL, 'Handball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(40, 4, NULL, 'Water Polo', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(41, 4, NULL, 'Ice Hockey', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(42, 5, NULL, 'Curling', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(43, 5, NULL, 'Paragliding', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(44, 5, NULL, 'Kite Surfing', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(45, 5, NULL, 'Windsurfing', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(46, 5, NULL, 'Dive', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(47, 5, NULL, 'Parkour', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(48, 5, NULL, 'Snowboarding', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(49, 6, NULL, 'Judo', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(50, 6, NULL, 'Thai Boxing', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(51, 6, NULL, 'Taekwondo', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(52, 6, NULL, 'Ju-Jutsu', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(53, 6, NULL, 'Jiu jitsu', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(54, 7, NULL, 'Volleyball', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(55, 7, NULL, 'Tennis', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
(56, 7, NULL, 'Table Tennis', 1, '2023-02-25 00:00:00', '2023-02-25 00:00:00'),
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
