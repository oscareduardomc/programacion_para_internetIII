-- -------------------------------------------------------------
-- TablePlus 7.2.2(722)
--
-- https://tableplus.com/
--
-- Database: examen
-- Generation Time: 2026-06-25 20:50:13.1620
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_empresa` varchar(255) NOT NULL,
  `correo_contacto` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `proyectos`;
CREATE TABLE `proyectos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `presupuesto` decimal(10,2) NOT NULL,
  `fecha_entrega` datetime NOT NULL,
  `id_cliente` int NOT NULL,
  `estado_activo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `clientes` (`id`, `nombre_empresa`, `correo_contacto`, `telefono`) VALUES
(2, 'segundo cliente', 'segundocliente@gmail.com', '22222222'),
(3, 'tercer cliente', 'tercercliente@gmail.com', '33333333'),
(4, 'cuarto cliente', 'cuartocliente@gmail.com', '44444444');

INSERT INTO `proyectos` (`id`, `titulo`, `descripcion`, `presupuesto`, `fecha_entrega`, `id_cliente`, `estado_activo`) VALUES
(3, 'cuarto titulo', 'descripciont cuarto titulo', 44444.00, '2026-12-29 00:00:00', 4, 1);



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;