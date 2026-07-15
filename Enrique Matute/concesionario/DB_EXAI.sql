-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para concesionario
CREATE DATABASE IF NOT EXISTS `concesionario` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `concesionario`;

-- Volcando estructura para tabla concesionario.marcas
CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_marca` varchar(50) NOT NULL,
  `pais_origen` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla concesionario.marcas: ~4 rows (aproximadamente)
INSERT INTO `marcas` (`id`, `nombre_marca`, `pais_origen`) VALUES
	(1, 'Toyota', 'Japón'),
	(2, 'Honda', 'Japón'),
	(3, 'Ford', 'Estados Unidos'),
	(4, 'Volkswagen', 'Alemania');

-- Volcando estructura para tabla concesionario.vehiculos
CREATE TABLE IF NOT EXISTS `vehiculos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `placa` varchar(15) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `id_marca` int DEFAULT NULL,
  `anio` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `estado_activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `placa` (`placa`),
  KEY `id_marca` (`id_marca`),
  CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `marcas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Volcando datos para la tabla concesionario.vehiculos: ~6 rows (aproximadamente)
INSERT INTO `vehiculos` (`id`, `placa`, `modelo`, `id_marca`, `anio`, `precio`, `estado_activo`) VALUES
	(1, 'HED3348', 'SUV', 1, 2026, 120000.00, 0),
	(3, 'NAP4455', 'pickup', 3, 2015, 20000.00, 0),
	(4, 'AUG7705', 'Offroad', 4, 2021, 14000.00, 1),
	(5, 'ENR4456', 'Raptor', 3, 2013, 11250.00, 1),
	(6, 'BER5708', 'Hastback', 2, 2015, 8200.00, 1),
	(7, 'LMR9918', 'TRD', 1, 2027, 60000.00, 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
