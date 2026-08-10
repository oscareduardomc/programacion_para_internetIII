-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 07-08-2026 a las 02:06:24
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
-- Base de datos: `sistema_tickets_db`
--
CREATE DATABASE IF NOT EXISTS `sistema_tickets_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `sistema_tickets_db`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `prioridad` enum('Baja','Media','Alta') NOT NULL DEFAULT 'Media',
  `estado` enum('Pendiente','En Proceso','Resuelto') NOT NULL DEFAULT 'Pendiente',
  `fecha_creacion` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `tickets`
--

INSERT INTO `tickets` (`id`, `id_usuario`, `titulo`, `descripcion`, `departamento`, `prioridad`, `estado`, `fecha_creacion`) VALUES
(1, 1, 'El internet esta caido', 'Desde que hubo un bajón de luz nos hemos quedado sin internet', 'Recursos Humanos', 'Media', 'Resuelto', '2026-08-06 19:10:43'),
(2, 2, 'La impresora presenta problemas', 'No esta imprimiendo bien los documentos, esta imprimiendo hojas con códigos, no imprime el documento como es', 'Ventas', 'Alta', 'En Proceso', '2026-08-06 19:46:29'),
(3, 2, 'La laptop no enciende', 'Estaba trabajando  en ella, cuando se puso la pantalla en negro, intente volverla a encender del botón ya que el mouse vi que no aparecía en la pantalla, y ni presionando el botón de encendido para tratar de apagarla forzosamente  y luego volver a encenderla no encendio', 'Administración', 'Alta', 'Pendiente', '2026-08-06 19:57:15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','tecnico') NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`) VALUES
(1, 'THAMY PACHECO', 'thamy@gmail.com', '$2y$10$o8zanctHQBUomZY2AhWbO.EHAS06QWxdFT88c9TgCV5qQ691hVSs2', 'tecnico'),
(2, 'ASHLYN DIAZ', 'ashlyn@gmail.com', '$2y$10$3Ab.3QXi7CYyRUTdnWV2GOEj3jF0.qVIQ8q9uGLnxasrDbzRwdVz.', 'usuario');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
