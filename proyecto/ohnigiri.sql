-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 18-06-2024 a las 21:29:27
-- Versión del servidor: 8.2.0
-- Versión de PHP: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ohnigiri`
--
CREATE DATABASE IF NOT EXISTS `ohnigiri` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci;
USE `ohnigiri`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

DROP TABLE IF EXISTS `citas`;
CREATE TABLE IF NOT EXISTS `citas` (
  `idCita` int NOT NULL AUTO_INCREMENT,
  `idUsuarioFK` int NOT NULL,
  `fecha_cita` date NOT NULL,
  `motivo_cita` text COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`idCita`),
  KEY `idUsuarioFK` (`idUsuarioFK`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `idUsuarioFK`, `fecha_cita`, `motivo_cita`) VALUES
(12, 26, '2024-06-19', 'Aa'),
(15, 26, '2024-06-19', 'Si'),
(16, 28, '2024-06-25', 'Prueba cita creada por admin para otro usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logins`
--

DROP TABLE IF EXISTS `logins`;
CREATE TABLE IF NOT EXISTS `logins` (
  `IdLogin` int NOT NULL AUTO_INCREMENT,
  `fecha_login` datetime NOT NULL,
  `idUsuarioFK` int NOT NULL,
  `usuario` varchar(12) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` varchar(8) COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`IdLogin`),
  KEY `idUsuarioFK` (`idUsuarioFK`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `logins`
--

INSERT INTO `logins` (`IdLogin`, `fecha_login`, `idUsuarioFK`, `usuario`, `password`, `role`) VALUES
(111, '2024-06-18 20:37:15', 28, 'Prueba123', '$2y$10$heuUjgn9.RO/eOZh03HztOf3jZBKsIIIOlbveOU3odWZ7CYm3q2Ye', 'usuario'),
(112, '2024-06-18 20:38:09', 26, 'Slytrox', '$2y$10$X/yNonNSzcCHehW7ByCgOeGk1NszPluT67.dnNOqZ/HFU1zzAUQLC', 'admin'),
(113, '2024-06-18 20:44:14', 36, 'Admin', '$2y$10$5KSSt6.gUQ.6a7P/rU9Jme0Satx5XZvPDNy1VDsE4zLxIyRdTRbuq', 'admin'),
(115, '2024-06-18 21:00:10', 38, 'ultimotest', '$2y$10$7QyXpCUpTvaIww0QUQQ9/eHNILcoU.mrj0.E0SrlQlrjinvtrSq6q', 'usuario'),
(116, '2024-06-18 21:16:00', 26, 'Slytrox', '$2y$10$X/yNonNSzcCHehW7ByCgOeGk1NszPluT67.dnNOqZ/HFU1zzAUQLC', 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias`
--

DROP TABLE IF EXISTS `noticias`;
CREATE TABLE IF NOT EXISTS `noticias` (
  `idNoticia` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `cuerpo` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `idUserFK` int NOT NULL,
  PRIMARY KEY (`idNoticia`),
  KEY `idUserFK` (`idUserFK`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `cuerpo`, `imagen`, `fecha`, `idUserFK`) VALUES
(4, 'Apertura pagina web!', '¡Bienvenido al apartado de noticias, donde el futuro les haremos saber las últimas novedades, ya sea nuevo platillos, eventos de tiempo limitado, ofertas y un largo etcétera!', 'imagenes/6668789c1a794.png', '2024-06-11 20:37:08', 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `IdUsuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `apellidos` varchar(45) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(60) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `telefono` varchar(9) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_alta` date NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sexo` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_nacimiento`, `fecha_alta`, `direccion`, `sexo`) VALUES
(26, 'Gabriel', 'Vich', 'Gabr@correo.com', '123123123', '2002-12-04', '2024-06-11', 'aa', 'hombre'),
(28, 'Abejorro', 'apellido cambiado', 'correoaAaa@homt.com', '123123123', '2024-06-03', '2024-06-11', 'direccion cambiada', 'hombre'),
(36, 'Admin', 'prueba', 'admin@correo.es', '123123123', '2024-05-26', '2024-06-18', 'Correo cambiado desde Slytrox', 'hombre'),
(38, 'UltimaPrueba', '123456789123456789123456789123456789123456789', 'gab@ges.es', '123123123', '2024-05-26', '2024-06-18', 'Calle', 'hombre');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`idUsuarioFK`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`idUsuarioFK`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`idUserFK`) REFERENCES `usuarios` (`IdUsuario`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
