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


-- Volcando estructura de base de datos para sistema_tickets
CREATE DATABASE IF NOT EXISTS `sistema_tickets` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistema_tickets`;

-- Volcando estructura para tabla sistema_tickets.tickets
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text NOT NULL,
  `prioridad` enum('Baja','Media','Alta') NOT NULL DEFAULT 'Media',
  `estado` enum('Pendiente','En Proceso','Resuelto') NOT NULL DEFAULT 'Pendiente',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_tickets_usuario` (`id_usuario`),
  CONSTRAINT `fk_tickets_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla sistema_tickets.tickets: ~6 rows (aproximadamente)
INSERT INTO `tickets` (`id`, `id_usuario`, `titulo`, `descripcion`, `prioridad`, `estado`, `fecha_creacion`) VALUES
	(1, 1, 'No enciende el monitor', 'El monitor de la sala 2 no enciende desde esta manana.', 'Alta', 'Pendiente', '2026-08-06 19:02:10'),
	(2, 1, 'Impresora sin tinta', 'La impresora de administracion marca error de tinta.', 'Media', 'Pendiente', '2026-08-06 19:02:10'),
	(3, 1, 'Internet lento', 'La conexion a internet esta muy lenta en el segundo piso.', 'Media', 'Resuelto', '2026-08-06 19:02:10'),
	(4, 1, 'Instalar Office', 'Se necesita instalar Office en la nueva computadora.', 'Baja', 'Pendiente', '2026-08-06 19:02:10'),
	(5, 1, 'Cambio de mouse', 'El mouse de recepcion ya no responde bien.', 'Baja', 'Resuelto', '2026-08-06 19:02:10'),
	(6, 1, 'cargador de la computadora portatil', 'el cargador de la computadora portatil, catga solo si se le busca lado, comprar uno nuevo', 'Alta', 'Pendiente', '2026-08-06 20:01:34');

-- Volcando estructura para tabla sistema_tickets.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('usuario','tecnico') NOT NULL DEFAULT 'usuario',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

-- Volcando datos para la tabla sistema_tickets.usuarios: ~2 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`) VALUES
	(1, 'Enrique Matute', 'enrique@correo.com', '$2y$10$3YkU37JtfUs2oYilp6owFecZ0rkA9GDuwKJQdr9pcUs4UNAE6Xa4e', 'usuario'),
	(2, 'Oscar Martinez', 'oscar@correo.com', '$2y$10$U1pvur2ZkqnYC4lSk2W1keS1DzzsAELf8EuwzLKraiPFNKgwe18Ui', 'tecnico');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
