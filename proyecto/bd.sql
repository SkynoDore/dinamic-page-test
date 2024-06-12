-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 11-06-2024 a las 20:43:16
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `idUsuarioFK`, `fecha_cita`, `motivo_cita`) VALUES
(9, 29, '2024-06-18', 'A'),
(10, 26, '2024-06-12', 'Prueba');

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
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `logins`
--

INSERT INTO `logins` (`IdLogin`, `fecha_login`, `idUsuarioFK`, `usuario`, `password`, `role`) VALUES
(78, '0000-00-00 00:00:00', 26, 'Slytrox', '$2y$10$bijmcGvgL1ck6RCS9xrUYOoTow/qpvCwLWE8MgWr7VuO1wjES0U4q', 'admin'),
(79, '2024-06-11 15:50:08', 26, 'Slytrox', '$2y$10$bijmcGvgL1ck6RCS9xrUYOoTow/qpvCwLWE8MgWr7VuO1wjES0U4q', 'admin'),
(80, '0000-00-00 00:00:00', 27, 'usuario123', '$2y$10$CRT9VeHpwuAgVibYPSShKumeGFbQU7I9CokvNL3XVu1IXtjC3n3ua', 'usuario'),
(81, '0000-00-00 00:00:00', 28, 'Prueba123', '$2y$10$2BdQgKgP2ARuTIyfMob4H.vPgTRU.JSSBtIPqekJ3LQwhGdKKNfAu', 'usuario'),
(82, '0000-00-00 00:00:00', 29, 'asddDE', '$2y$10$G50SbXhu8xG8CjWHhzyzW./2.itbVZNXrrCWVijP9.vMF2Mrxq72O', 'usuario'),
(83, '2024-06-11 16:19:22', 26, 'Slytrox', '$2y$10$bijmcGvgL1ck6RCS9xrUYOoTow/qpvCwLWE8MgWr7VuO1wjES0U4q', 'admin'),
(84, '2024-06-11 20:40:03', 28, 'Prueba123', '$2y$10$2BdQgKgP2ARuTIyfMob4H.vPgTRU.JSSBtIPqekJ3LQwhGdKKNfAu', 'usuario');

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

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
  `nombre` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `apellidos` varchar(30) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `telefono` varchar(9) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `fecha_alta` date NOT NULL,
  `direccion` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `sexo` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`IdUsuario`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`IdUsuario`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_nacimiento`, `fecha_alta`, `direccion`, `sexo`) VALUES
(26, 'Gabriel', 'Suarez', 'gabriel@correo.com', '123123123', '2002-12-04', '2024-06-11', 'Informacion condifencial', 'hombre'),
(27, 'Usuario', 'Ejemplo', 'asdgaseE@correo.com', '123123123', '2000-12-12', '2024-06-11', 'aa', 'hombre'),
(28, 'Abejorro', 'asdasd', '123@homt.com', '123123123', '2024-06-03', '2024-06-11', 'Aasda', 'hombre'),
(29, 'Prueba', 'ejemplo', 'asd@asd.com', '123123123', '2024-05-28', '2024-06-11', 'AAAAAAA', 'hombre');

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
