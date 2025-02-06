-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-02-2025 a las 12:48:22
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `projectdwes_2term`
--
DROP DATABASE IF EXISTS `projectdwes_2term`;
CREATE DATABASE IF NOT EXISTS `projectdwes_2term` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projectdwes_2term`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `accactivation`
--

CREATE TABLE `accactivation` (
  `idUser` int(10) NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  `expiration` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comment`
--

CREATE TABLE `comment` (
  `idComment` int(11) NOT NULL,
  `commentedPost` int(10) NOT NULL,
  `commentedComment` int(10) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `likes` int(6) NOT NULL DEFAULT 0,
  `dislikes` int(6) NOT NULL DEFAULT 0,
  `postingTime` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `post`
--

CREATE TABLE `post` (
  `idPost` int(10) NOT NULL,
  `idPoster` int(10) NOT NULL,
  `likes` int(6) NOT NULL DEFAULT 0,
  `dislikes` int(6) NOT NULL,
  `postingTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `commentAmount` int(6) NOT NULL DEFAULT 0,
  `contentRoute` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profile`
--

CREATE TABLE `profile` (
  `userName` varchar(16) NOT NULL,
  `idUser` int(10) NOT NULL,
  `bio` varchar(255) NOT NULL,
  `followers` int(6) NOT NULL,
  `following` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `role`
--

CREATE TABLE `role` (
  `idRole` int(1) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `role`
--

INSERT INTO `role` (`idRole`, `name`) VALUES
(2, 'ROLE_ADMIN'),
(0, 'ROLE_NOTV'),
(1, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `idUser` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` int(9) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthDate` date NOT NULL,
  `role` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`idUser`, `name`, `surname`, `email`, `phoneNumber`, `password`, `birthDate`, `role`) VALUES
(1, 'alex', 'mayo', 'alexmayo@example.com', 666677778, '$2y$13$XpbqfMlxwVTwq1X2wPogDOG3DkpQdygg4JxQyFhwqNAQacxdm/hqi', '2003-01-03', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `accactivation`
--
ALTER TABLE `accactivation`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `FK_IdU_UIdU` (`idUser`);

--
-- Indices de la tabla `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`idComment`),
  ADD KEY `FK_CC_PIdP` (`commentedComment`),
  ADD KEY `FK_CP_UIdP` (`commentedPost`);

--
-- Indices de la tabla `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`idPost`),
  ADD KEY `FK_IdP_UIdU` (`idPoster`);

--
-- Indices de la tabla `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`userName`),
  ADD KEY `FK_IdU_UIdU` (`idUser`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`),
  ADD KEY `FK_UR_IdR` (`role`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comment`
--
ALTER TABLE `comment`
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `idPost` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `accactivation`
--
ALTER TABLE `accactivation`
  ADD CONSTRAINT `FK_IdU_UIdU` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_CC_PIdP` FOREIGN KEY (`commentedComment`) REFERENCES `comment` (`idComment`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CP_UIdP` FOREIGN KEY (`commentedPost`) REFERENCES `post` (`idPost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FK_IdP_UIdU` FOREIGN KEY (`idPoster`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `FK_PIdU_UIdU` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_UR_IdR` FOREIGN KEY (`role`) REFERENCES `role` (`idRole`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- DATOS POR DEFECTO
--
INSERT INTO `user` (`idUser`, `name`, `surname`, `email`, `phoneNumber`, `password`, `birthDate`, `role`) VALUES (NULL, 'Ivan', 'Money Gang', 'shadow_purpleWizzardMoneyGang@shadowgoverment.com', '666666666', '$2y$13$8wOBV5Vee3zj23aCDiKVQ.Fe4rPpO2nK8fXnKPuQ5I7f7JuMnFUWi', '2005-06-15', '1');

INSERT INTO `user` (`idUser`, `name`, `surname`, `email`, `phoneNumber`, `password`, `birthDate`, `role`) VALUES (NULL, 'Ivan', 'Money Gang', 'shadow_purpleWizzardMoneyGang@shadowgoverment.com', '666666666', '$2y$13$8wOBV5Vee3zj23aCDiKVQ.Fe4rPpO2nK8fXnKPuQ5I7f7JuMnFUWi', '2005-06-15', '1');

INSERT INTO `user` (`idUser`, `name`, `surname`, `email`, `phoneNumber`, `password`, `birthDate`, `role`) VALUES (NULL, 'Ivan', 'Money Gang', 'shadow_purpleWizzardMoneyGang@shadowgoverment.com', '666666666', '$2y$13$8wOBV5Vee3zj23aCDiKVQ.Fe4rPpO2nK8fXnKPuQ5I7f7JuMnFUWi', '2005-06-15', '1');
