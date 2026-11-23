-- phpMyAdmin SQL Dump
-- version 5.2.3deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 12 nov 2026 om 13:00
-- Serverversie: 8.4.11-0ubuntu0.26.04.1
-- PHP-versie: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Uren Registratie syteem`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employees`
--

CREATE TABLE `employees` (
  `employee_id` int NOT NULL,
  `ov_nummer` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `voornaam` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tussenvoegsel` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `achternaam` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `geboortedatum` date NOT NULL,
  `wachtwoord` varchar(255) COLLATE utf8mb4_general_ci DEFAULT 'wachtwoord',
  `functie` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'medewerker'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projects`
--

CREATE TABLE `projects` (
  `project_id` int NOT NULL,
  `project_nummer` int NOT NULL,
  `projectnaam` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `afgerond` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `timesheets`
--

CREATE TABLE `timesheets` (
  `timesheet_id` int NOT NULL,
  `employee_id` int NOT NULL,
  `project_id` int NOT NULL,
  `aantal_uren` time DEFAULT NULL,
  `omschrijving` text COLLATE utf8mb4_general_ci,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `ov_nummer` (`ov_nummer`),
  ADD KEY `idx_ov_nummer` (`ov_nummer`);

--
-- Indexen voor tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `idx_project_nummer` (`project_nummer`);

--
-- Indexen voor tabel `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`timesheet_id`),
  ADD KEY `idx_employee_id` (`employee_id`),
  ADD KEY `idx_project_id` (`project_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT voor een tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT voor een tabel `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `timesheet_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `timesheets`
--
ALTER TABLE `timesheets`
  ADD CONSTRAINT `fk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
