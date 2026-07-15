-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 26, 2026 at 02:34 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examen_agencia`
--

-- --------------------------------------------------------

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_general_ci NOT NULL,
  `id_cliente` int NOT NULL,
  `presupuesto` decimal(10,2) NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  `estado_activo` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proyectos`
--

INSERT INTO `proyectos` (`id`, `titulo`, `descripcion`, `id_cliente`, `presupuesto`, `fecha_entrega`, `estado_activo`) VALUES
(1, 'Panel 500w Remplazo', 'Panel reemplazo 500w', 1, 5000.00, '2026-07-02 00:00:00', 1),
(2, 'MI Danado', 'Solicitar inspeccion de Micro Inversor', 2, 550.00, '2026-08-13 00:00:00', 0),
(4, 'Instalacion de ATS', 'Instalacion de switch de transferencia automatico', 1, 1500.00, '2026-07-29 00:00:00', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
