-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 26, 2020 alle 23:05
-- Versione del server: 10.4.11-MariaDB
-- Versione PHP: 7.4.8

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dessertshop`
--
CREATE DATABASE IF NOT EXISTS `dessertshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dessertshop`;

-- --------------------------------------------------------

--
-- Struttura della tabella `dessert`
--

DROP TABLE IF EXISTS `dessert`;
CREATE TABLE IF NOT EXISTS `dessert` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(256) NOT NULL,
  `Price` decimal(19,2) NOT NULL,
  `Date_Sell` date DEFAULT NULL,
  `Obsolete` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dump dei dati per la tabella `dessert`
--

INSERT INTO `dessert` (`Id`, `Name`, `Price`, `Date_Sell`, `Obsolete`) VALUES
(4, 'Torta Paradiso', '1.00', NULL, 0),
(5, 'Kinder Pingui', '4.00', '2020-09-26', 0),
(6, 'Cheesecake', '12.00', '2020-09-27', 0),
(7, 'Torta di pane', '24.57', '2020-09-25', 0),
(8, 'Crostata', '2341.21', '2020-09-23', 1),
(9, 'A modo mio', '1321.00', '2020-09-24', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `ingredient`
--

DROP TABLE IF EXISTS `ingredient`;
CREATE TABLE IF NOT EXISTS `ingredient` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(256) NOT NULL,
  `Amount` int(11) NOT NULL,
  `UM` varchar(24) NOT NULL,
  `Dessert_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`),
  KEY `Dessert_ID` (`Dessert_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`) VALUES
(1, 'luana@teletu.it', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$L2ZiTEFHVENwQlVJeUxQUQ$CeGQ7gDUSKtFtpZfLp1cRYZlEkv9XOH/KcOkWQ5QayQ', 'Luana');

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `Dessert_ID` FOREIGN KEY (`Dessert_ID`) REFERENCES `dessert` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
