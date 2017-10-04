-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 04. okt 2017 ob 22.08
-- Različica strežnika: 10.1.21-MariaDB
-- Različica PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `csharp`
--

-- --------------------------------------------------------

--
-- Struktura tabele `data`
--

CREATE TABLE `data` (
  `ID` int(10) NOT NULL,
  `contributor_ID` int(10) DEFAULT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci,
  `answer` text CHARACTER SET utf8 COLLATE utf8_slovenian_ci,
  `tag` varchar(40) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `upload_ID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabele `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `content` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabele `users`
--

CREATE TABLE `users` (
  `ID` int(10) NOT NULL,
  `name` varchar(25) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `surname` varchar(25) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `username` varchar(25) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `password` varchar(25) CHARACTER SET utf8 COLLATE utf8_slovenian_ci DEFAULT NULL,
  `permission_level` int(10) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Odloži podatke za tabelo `users`
--

INSERT INTO `users` (`ID`, `name`, `surname`, `email`, `username`, `password`, `permission_level`) VALUES
(6, 'Uroš', 'Vaupotič', 'uros.vaupotic@gmail.com', 'uros123', 'uros123', 2);

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `contributor_ID` (`contributor_ID`),
  ADD KEY `upload_ID` (`upload_ID`);

--
-- Indeksi tabele `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`);

--
-- Indeksi tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `data`
--
ALTER TABLE `data`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT tabele `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT tabele `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`contributor_ID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `data_ibfk_2` FOREIGN KEY (`upload_ID`) REFERENCES `upload` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
