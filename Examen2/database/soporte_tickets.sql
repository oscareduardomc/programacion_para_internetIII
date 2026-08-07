-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-08-2026 a las 02:28:21
-- Versión del servidor: 8.4.7
-- Versión de PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `soporte_tickets`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `departamento` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioridad` enum('Baja','Media','Alta') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Media',
  `estado` enum('Pendiente','En Proceso','Resuelto') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_tickets_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id`, `id_usuario`, `titulo`, `descripcion`, `departamento`, `prioridad`, `estado`, `fecha_creacion`) VALUES
(1, 2, 'PC no enciende', 'La computadora del área de ventas no enciende desde esta mañana.', 'Ventas', 'Alta', 'Resuelto', '2026-08-06 19:08:52'),
(3, 2, 'correo no funciona', 'No puedo acceder a mi correo corporativo.', 'Recursos Humanos', 'Baja', 'Pendiente', '2026-08-06 19:08:52'),
(4, 2, 'pantalla no funciona', 'se apaga sola', 'ventas', 'Media', 'Pendiente', '2026-08-06 19:31:31'),
(6, 2, 'pantalla no funciona', 'se apaga', 'Bodega', 'Alta', 'Pendiente', '2026-08-06 20:26:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('usuario','tecnico') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'usuario',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`, `estado`, `fecha_creacion`) VALUES
(1, 'Tecnico Soporte', 'tecnico@soporte.com', '$2y$10$ZRP4eyb2C1m6NQOZLkrVleeaCEK1coa8JvgPa6Mh/F0nw.rWJNnfa', 'tecnico', 1, '2026-08-06 19:08:52'),
(2, 'Marcos Rios', 'usuario@soporte.com', '$2y$10$U1Og7XhqhZ/Z7wOp2n2cHezpbGAUAoz9c7.6IPPPvWML5s6lX4P4y', 'usuario', 1, '2026-08-06 19:08:52');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
