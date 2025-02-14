-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-02-2025 a las 12:23:01
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
  `idUser` int(10) NOT NULL,
  `commPost` int(10) NOT NULL,
  `commComment` int(10) DEFAULT NULL,
  `content` varchar(255) NOT NULL,
  `likes` int(6) NOT NULL DEFAULT 0,
  `dislikes` int(6) NOT NULL DEFAULT 0,
  `postingTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comment`
--

INSERT INTO `comment` (`idComment`, `idUser`, `commPost`, `commComment`, `content`, `likes`, `dislikes`, `postingTime`) VALUES
(1, 5, 1, NULL, 'Qué chulo', 1, 0, '2025-02-13 23:00:00'),
(2, 1, 1, 1, 'Muchas gracias :)', 1, 0, '2025-02-13 23:00:00'),
(3, 3, 1, NULL, 'Qué horror', 0, 2, '2025-02-14 11:10:35'),
(4, 1, 1, 3, 'Borde :/', 0, 1, '2025-02-14 11:11:23'),
(5, 1, 3, NULL, 'Feo feísimo', 1, 1, '2025-02-14 11:12:47'),
(6, 3, 3, 5, 'Como tú', 0, 2, '2025-02-14 11:13:21'),
(7, 5, 3, 5, 'Pues a mí me parece bonito', 1, 1, '2025-02-14 11:14:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `friendship`
--

CREATE TABLE `friendship` (
  `idFriendship` int(50) NOT NULL,
  `idRequestor` int(10) NOT NULL,
  `idRequested` int(10) NOT NULL,
  `frState` int(1) NOT NULL,
  `frDate` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `friendship`
--

INSERT INTO `friendship` (`idFriendship`, `idRequestor`, `idRequested`, `frState`, `frDate`) VALUES
(1, 1, 3, 2, '2025-02-14 12:16:23'),
(2, 3, 5, 2, '2025-02-14 12:16:23'),
(3, 5, 1, 2, '2025-02-14 12:16:23');

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

--
-- Volcado de datos para la tabla `post`
--

INSERT INTO `post` (`idPost`, `idPoster`, `likes`, `dislikes`, `postingTime`, `commentAmount`, `contentRoute`) VALUES
(1, 1, 7, 223, '2025-02-14 11:01:59', 4, '/userData/1/posts/1.png'),
(2, 2, 2, 0, '2025-02-14 11:01:59', 0, '/userData/2/posts/2.png'),
(3, 3, 203, 7, '2025-02-14 11:01:59', 3, '/userData/3/posts/3.png'),
(4, 4, 58, 0, '2025-02-14 11:01:59', 0, '/userData/4/posts/4.png'),
(5, 5, 556, 3, '2025-02-14 11:01:59', 0, '/userData/5/posts/5.png'),
(6, 6, 4, 77, '2025-02-14 11:01:59', 0, '/userData/6/posts/6.png');

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

--
-- Volcado de datos para la tabla `profile`
--

INSERT INTO `profile` (`userName`, `idUser`, `bio`, `followers`, `following`) VALUES
('alexmayo', 1, 'Cuenta principal y de administración de Álex Mayo.', 55, 33),
('nvr', 2, 'Cuenta secundaria de Álex Mayo.', 2, 5),
('ivanarroyo', 3, 'Cuenta principal y de administración de Iván Arroyo.', 334, 112),
('shadowgang', 4, 'Cuenta secundaria de Iván Arroyo.', 29, 0),
('danimvals', 5, 'Hello, I am new to ShadowGram!', 5223, 35),
('videosboy', 6, 'Hello, I am new to ShadowGram!', 98, 97);

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
-- Estructura de tabla para la tabla `state`
--

CREATE TABLE `state` (
  `idState` int(1) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `state`
--

INSERT INTO `state` (`idState`, `name`) VALUES
(2, 'ACCEPTED'),
(0, 'NONEXISTENT'),
(1, 'PENDING');

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
(1, 'Álex', 'Mayo Martín', 'amayom@email.es', 666677778, '$2y$13$XpbqfMlxwVTwq1X2wPogDOG3DkpQdygg4JxQyFhwqNAQacxdm/hqi', '2003-01-03', 2),
(2, 'navarra', 'nvr', 'navarra@email.es', 666000666, '$2y$13$ps9Sj.E7KeQXmzGdENuWQeawzypCQ0hBKfkTDUWR0xVEH2ZhWyvRG', '2004-07-06', 1),
(3, 'Iván', 'Arroyo González', 'iarroyog@email.es', 611222333, '$2y$13$a8WgyPYafSj6S/RSF1AzoOwRbB.LOF9f96NB536N7alXckMGFwxU.', '2005-05-18', 2),
(4, 'monstah', 'shadowgang', 'monstah@email.es', 611222222, '$2y$13$OLEjIMcFKn7Us8w33Q003ey2rQ76mtnpaI3J7.aV/9nyhAZiKTwhi', '2006-02-14', 1),
(5, 'Dani Manu', 'Vals Simón', 'dmvalss@email.es', 666555444, '$2y$13$rlR5ngTqZQyEaQojPktgIefcIVuAx/QCrGHPzJBoxEywb060KpLbm', '2005-12-16', 2),
(6, 'manuela', 'videosboy', 'manuela@email.es', 666555555, '$2y$13$whDwwHWMuin.4q9iJrXS.Ou1IEJVyV9aBHH8/XnolX5U6t9qRNIbq', '2006-12-30', 1);

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
  ADD KEY `FK_CC_PIdP` (`commComment`),
  ADD KEY `FK_CP_UIdP` (`commPost`),
  ADD KEY `FK_CIdU_UIdU` (`idUser`);

--
-- Indices de la tabla `friendship`
--
ALTER TABLE `friendship`
  ADD PRIMARY KEY (`idFriendship`),
  ADD KEY `FK_IdRor_UIdU` (`idRequestor`),
  ADD KEY `FK_IdRed_UIdU` (`idRequested`),
  ADD KEY `FK_FrS_SIdS` (`frState`);

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
  ADD PRIMARY KEY (`idUser`) USING BTREE,
  ADD UNIQUE KEY `userName` (`userName`),
  ADD KEY `FK_IdU_UIdU` (`idUser`);

--
-- Indices de la tabla `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`idState`),
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
  MODIFY `idComment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `friendship`
--
ALTER TABLE `friendship`
  MODIFY `idFriendship` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `post`
--
ALTER TABLE `post`
  MODIFY `idPost` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  ADD CONSTRAINT `FK_CC_CIdC` FOREIGN KEY (`commComment`) REFERENCES `comment` (`idComment`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CIdU_UIdU` FOREIGN KEY (`idUser`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_CP_PIdP` FOREIGN KEY (`commPost`) REFERENCES `post` (`idPost`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `friendship`
--
ALTER TABLE `friendship`
  ADD CONSTRAINT `FK_FrS_SIdS` FOREIGN KEY (`frState`) REFERENCES `state` (`idState`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdRed_UIdU` FOREIGN KEY (`idRequested`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_IdRor_UIdU` FOREIGN KEY (`idRequestor`) REFERENCES `user` (`idUser`) ON DELETE CASCADE ON UPDATE CASCADE;

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
