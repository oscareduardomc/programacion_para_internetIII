-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 26-06-2026 a las 02:54:55
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
-- Base de datos: `taller_repuestos`
--
CREATE DATABASE IF NOT EXISTS `taller_repuestos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `taller_repuestos`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias_repuesto`
--

DROP TABLE IF EXISTS `categorias_repuesto`;
CREATE TABLE IF NOT EXISTS `categorias_repuesto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_categoria` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias_repuesto`
--

INSERT INTO `categorias_repuesto` (`id`, `nombre_categoria`, `descripcion`) VALUES
(1, 'Motor', NULL),
(2, 'Frenos', NULL),
(3, 'Suspensión', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repuestos`
--

DROP TABLE IF EXISTS `repuestos`;
CREATE TABLE IF NOT EXISTS `repuestos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo_pieza` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_categoria` int NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `precio` decimal(10,2) NOT NULL,
  `estado_activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `codigo_pieza` (`codigo_pieza`),
  KEY `id_categoria` (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `repuestos`
--

INSERT INTO `repuestos` (`id`, `codigo_pieza`, `nombre`, `id_categoria`, `stock`, `precio`, `estado_activo`) VALUES
(1, '54545', 'bateria', 2, 4, 55.00, 0),
(3, '545455', 'bateria', 1, 4, 55.00, 0),
(4, '455r45', 'barilla de alambre', 2, 5, 225.00, 1),
(7, '485754', 'frenos para carrros', 2, 54, 1000.00, 1),
(8, '45785', 'alambre', 1, 4, 45.00, 0),
(9, '45785555', 'Martillo', 1, 6, 250.00, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
