-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2023 at 11:55 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestorempresadb`
--

-- --------------------------------------------------------

--
-- Table structure for table `departamentos`
--

CREATE TABLE `departamentos` (
  `IDdepartamento` int(11) NOT NULL,
  `Nomedepartamento` varchar(30) NOT NULL,
  `CustoTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departamentos`
--

INSERT INTO `departamentos` (`IDdepartamento`, `Nomedepartamento`, `CustoTotal`) VALUES
(33339, 'Departamento IT', 0),
(33350, 'Departamento HR', 0),
(33356, 'Departamento Jogadores de CS', 0);

-- --------------------------------------------------------

--
-- Table structure for table `salarios`
--

CREATE TABLE `salarios` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(100) NOT NULL,
  `SalBruto` double NOT NULL,
  `SegSocial` double NOT NULL,
  `IRS` double NOT NULL,
  `SubAlim` double NOT NULL,
  `Mes` varchar(12) NOT NULL,
  `Ano` int(11) NOT NULL,
  `SalLiquido` double DEFAULT NULL,
  `SSEmpresa` double NOT NULL,
  `CustoTotal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salarios`
--

INSERT INTO `salarios` (`ID`, `Nome`, `SalBruto`, `SegSocial`, `IRS`, `SubAlim`, `Mes`, `Ano`, `SalLiquido`, `SSEmpresa`, `CustoTotal`) VALUES
(1, 'admin', 1700, 187, 221, 115.5, '09', 2023, 1407.5, 221, 1921),
(1, 'admin', 1500, 165, 195, 115.5, '07', 2023, 1255.5, 195, 1695),
(1, 'admin', 1600, 176, 208, 115.5, '08', 2023, 1331.5, 208, 1808),
(3, 'admin2', 1500, 165, 195, 115.5, '07', 2023, 1255.5, 195, 1695),
(7, 'user2', 1500, 165, 195, 115.5, '07', 2023, 1255.5, 195, 1695),
(7, 'user2', 4000, 440, 640, 115.5, '1', 2023, 3035.5, 520, 4520),
(1, 'admin', 1500, 165, 195, 115.5, '7', 2023, 1255.5, 195, 1695);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `DataNasc` varchar(20) NOT NULL,
  `NIF` int(11) NOT NULL,
  `IBAN` varchar(50) NOT NULL,
  `Tel` int(11) NOT NULL,
  `Telf` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Morada` varchar(150) NOT NULL,
  `Localidade` varchar(50) NOT NULL,
  `CodigoPostal` varchar(15) NOT NULL,
  `IDdepartamento` int(11) NOT NULL,
  `Funcao` varchar(50) NOT NULL,
  `Estado` tinyint(1) NOT NULL,
  `Admin` tinyint(1) NOT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `username`, `DataNasc`, `NIF`, `IBAN`, `Tel`, `Telf`, `Email`, `Morada`, `Localidade`, `CodigoPostal`, `IDdepartamento`, `Funcao`, `Estado`, `Admin`, `Password`) VALUES
(1, 'admin', '1-01-1990', 99999999, '8888888888', 999999999, 999999999, 'qualquercoisa@mail.com', 'morada2', 'localidade2', '2222-222', 33339, 'trabalhar', 1, 1, 'password'),
(2, 'user', '01-01-1990', 999999999, '8888888888', 999999999, 999999999, 'fake@email.com', 'morada2', 'localidade2', '2222-222', 33350, 'trabalhar', 1, 0, 'password'),
(3, 'admin2', '10-10-97', 7777777, '7777777777', 777777777, 777777777, 'mail@mail.com', 'morada aqui', 'localidade aqui', '5555555', 33356, 'limpar o chão', 1, 1, 'password'),
(7, 'user2', '5555-05-05', 11111111, '11111111111111', 555555555, 555555555, '1111111111111@111111', '11111111111111111', 'locationlocation', '5555-555', 33350, 'trabalhador', 1, 0, 'password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`IDdepartamento`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `IDdepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33359;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
