-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-06-2026 a las 03:21:17
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
-- Base de datos: `exa1_autos_seminuevos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

DROP TABLE IF EXISTS `marcas`;
CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_marca` varchar(100) NOT NULL,
  `pais_origen` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre_marca`, `pais_origen`) VALUES
(1, 'TOYOTA', 'MEXICO'),
(2, 'HONDA', 'EE.UU');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

DROP TABLE IF EXISTS `vehiculos`;
CREATE TABLE IF NOT EXISTS `vehiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(20) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `id_marca` int NOT NULL,
  `anio` int NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado_activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `placa` (`placa`),
  KEY `id_marca` (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`id`, `placa`, `modelo`, `id_marca`, `anio`, `precio`, `estado_activo`) VALUES
(1, '32HYT2', 'Land Cruiser', 1, 2024, 1500000.00, 1),
(3, 'HYT', 'CIVIC', 2, 2019, 500000.00, 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
