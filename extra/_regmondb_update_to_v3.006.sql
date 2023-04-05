-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 30, 2023 at 07:37 PM
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

-- increase form object max size 
ALTER TABLE `forms` CHANGE `data_json` `data_json` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- increase graphs object max size 
ALTER TABLE `graphs` CHANGE `data_json` `data_json` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

-- rename db table graphs to templates
RENAME TABLE `graphs` TO `templates`;

-- rename is_axis to template_type + add comment
ALTER TABLE `templates` CHANGE `is_axis` `template_type` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0=forms_templates, 1=axis, 2=groups_templates';


-- delete Sports_Groups and Body_Height - RangeOfValues(100->250) cm 
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 1;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 2;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 3;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 4;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 5;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 6;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 7;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 8;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 9;
DELETE FROM `dropdowns` WHERE `dropdowns`.`id` = 10;

-- delete field for_forms
ALTER TABLE `dropdowns` DROP `for_forms`;

-- delete field can_del_edit
ALTER TABLE `dropdowns` DROP `can_del_edit`;

-- rename idd to parent_id
ALTER TABLE `dropdowns` CHANGE `idd` `parent_id` INT(11) NULL DEFAULT '0';

-- rename sport_group_id to parent_id
ALTER TABLE `sports` CHANGE `sport_group_id` `parent_id` INT(11) NULL DEFAULT '1';

-- add options
ALTER TABLE `sports` ADD `options` VARCHAR(64) NULL AFTER `name`;

-- empty table sports
TRUNCATE TABLE `sports`;

-- table sports entries 
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


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
