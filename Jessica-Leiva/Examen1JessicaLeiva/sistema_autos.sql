-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 26-06-2026 a las 04:34:10
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
-- Base de datos: `sistema_autos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre_marca` varchar(100) NOT NULL,
  `pais_origen` varchar(100) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre_marca`, `pais_origen`, `activo`) VALUES
(1, 'Toyota', 'Japón', 1),
(2, 'Honda', 'Japón', 1),
(3, 'Nissan', 'Japón', 1),
(4, 'Mazda', 'Japón', 1),
(5, 'Hyundai', 'Corea del Sur', 1),
(6, 'Kia', 'Corea del Sur', 1),
(7, 'Ford', 'Estados Unidos', 1),
(8, 'Chevrolet', 'Estados Unidos', 1),
(9, 'Volkswagen', 'Alemania', 1),
(10, 'BMW', 'Alemania', 1),
(11, 'Mercedes-Benz', 'Alemania', 1),
(12, 'Audi', 'Alemania', 1),
(13, 'Renault', 'Francia', 1),
(14, 'Peugeot', 'Francia', 1),
(15, 'Tesla', 'Estados Unidos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `id` int(11) NOT NULL,
  `placa` varchar(20) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `id_marca` int(11) NOT NULL,
  `fecha_vehiculo` year(4) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado_activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `fk_marca` (`id_marca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `fk_marca` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
