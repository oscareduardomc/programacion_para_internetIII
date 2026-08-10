-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 10-08-2026 a las 16:47:00
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
-- Base de datos: `punto_venta`
--
CREATE DATABASE IF NOT EXISTS `punto_venta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `punto_venta`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aperturas_caja`
--

DROP TABLE IF EXISTS `aperturas_caja`;
CREATE TABLE IF NOT EXISTS `aperturas_caja` (
  `id_apertura` int NOT NULL AUTO_INCREMENT,
  `id_caja` int NOT NULL,
  `id_usuario` int NOT NULL,
  `fecha_apertura` datetime NOT NULL,
  `fecha_cierre` datetime DEFAULT NULL,
  `monto_inicial` decimal(12,2) NOT NULL,
  `monto_final` decimal(12,2) DEFAULT NULL,
  `diferencia` decimal(12,2) DEFAULT '0.00',
  `estado` enum('ABIERTA','CERRADA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ABIERTA',
  `observacion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_apertura`),
  KEY `id_caja` (`id_caja`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aperturas_caja`
--

INSERT INTO `aperturas_caja` (`id_apertura`, `id_caja`, `id_usuario`, `fecha_apertura`, `fecha_cierre`, `monto_inicial`, `monto_final`, `diferencia`, `estado`, `observacion`) VALUES
(1, 1, 1, '2026-08-06 10:24:08', '2026-08-06 10:52:44', 500.00, 57.50, -500.00, 'CERRADA', ''),
(2, 1, 1, '2026-08-06 10:53:59', '2026-08-06 10:57:27', 1000.00, 1726.16, -999.99, 'CERRADA', 'Las ventas solo fueron en efectivo'),
(3, 1, 1, '2026-08-06 11:01:20', '2026-08-06 11:08:44', 1000.00, 2624.95, 0.00, 'CERRADA', ''),
(4, 1, 2, '2026-08-08 17:18:50', '2026-08-08 17:22:01', 1500.00, 3777.00, 0.00, 'CERRADA', 'VENTA FINAL DEL DIA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

DROP TABLE IF EXISTS `cajas`;
CREATE TABLE IF NOT EXISTS `cajas` (
  `id_caja` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_caja`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id_caja`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Caja Principal', 'Caja Principal del Negocio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

DROP TABLE IF EXISTS `categorias`;
CREATE TABLE IF NOT EXISTS `categorias` (
  `id_categoria` int NOT NULL AUTO_INCREMENT,
  `categoria` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_categoria`),
  UNIQUE KEY `categoria` (`categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `categoria`, `descripcion`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'General', 'Categoría general de productos', 1, '2026-07-23 19:44:56', NULL),
(2, 'Lácteos', 'Productos derivados de la leche', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(3, 'Bebidas', 'Bebidas gaseosas, jugos y agua', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(4, 'Snacks', 'Botanas y aperitivos', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(5, 'Panadería', 'Panes y productos horneados', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(6, 'Limpieza', 'Productos para limpieza del hogar', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(7, 'Aseo Personal', 'Productos de higiene personal', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(8, 'Carnes', 'Carnes frescas y embutidos', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(9, 'Frutas', 'Frutas frescas', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(10, 'Verduras', 'Verduras frescas', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14'),
(11, 'Dulces', 'Confites y chocolates', 1, '2026-08-06 10:31:14', '2026-08-06 10:31:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `identidad` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `limite_credito` decimal(12,2) NOT NULL DEFAULT '0.00',
  `saldo_credito` decimal(12,2) NOT NULL DEFAULT '0.00',
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `identidad` (`identidad`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `identidad`, `telefono`, `correo`, `direccion`, `limite_credito`, `saldo_credito`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'BRENDA SIFONTES', '1502200258963', '98745612', 'brenda@gmail.com', 'Barrio la hoya', 2000.00, 0.00, 1, '2026-08-07 09:58:20', NULL),
(2, 'Carlos Espinoza', '1504200254781', '95487512', 'carlos@gmail.com', 'Barrio el centro', 2000.00, 0.00, 1, '2026-08-08 09:59:52', NULL),
(3, 'Dina Damas', '1503200215478', '96451236', 'dina@gmail.com', 'Barrio la primavera', 3000.00, 0.00, 1, '2026-08-09 10:01:31', NULL),
(4, 'Erick Alvarenga', '1502635298741', '96321548', 'erick@gmail.com', 'Barrio la pista', 2500.00, 0.00, 1, '2026-08-09 10:02:51', '2026-08-09 10:03:35'),
(5, 'Joel Gutierrez', '15024895789641', '98526341', 'joel@gmail.com', 'Barrio la colonia', 2000.00, 0.00, 1, '2026-08-09 10:03:51', NULL),
(6, 'THAMY PACHECO', '1503200202183', '98557787', 'thamy@gmail.com', 'Barrio zunilapa', 4000.00, 0.00, 1, '2026-08-09 10:04:42', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

DROP TABLE IF EXISTS `detalle_ventas`;
CREATE TABLE IF NOT EXISTS `detalle_ventas` (
  `id_detalle` int NOT NULL AUTO_INCREMENT,
  `id_venta` int NOT NULL,
  `id_producto` int NOT NULL,
  `cantidad` decimal(12,2) DEFAULT NULL,
  `precio` decimal(12,2) DEFAULT NULL,
  `impuesto` decimal(12,2) DEFAULT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_venta` (`id_venta`),
  KEY `id_producto` (`id_producto`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_ventas`
--

INSERT INTO `detalle_ventas` (`id_detalle`, `id_venta`, `id_producto`, `cantidad`, `precio`, `impuesto`, `subtotal`) VALUES
(1, 1, 1, 2.00, 25.00, NULL, 50.00),
(2, 2, 2, 3.00, 40.00, NULL, 120.00),
(3, 2, 4, 4.00, 30.00, NULL, 120.00),
(4, 3, 10, 2.00, 18.00, NULL, 36.00),
(5, 3, 7, 3.00, 105.00, NULL, 315.00),
(6, 3, 1, 2.00, 25.00, NULL, 50.00),
(7, 3, 5, 1.00, 85.00, NULL, 85.00),
(8, 3, 2, 3.00, 40.00, NULL, 120.00),
(9, 3, 4, 4.00, 30.00, NULL, 120.00),
(10, 4, 9, 2.00, 28.00, NULL, 56.00),
(11, 4, 7, 3.00, 105.00, NULL, 315.00),
(12, 4, 6, 2.00, 75.00, NULL, 150.00),
(13, 4, 8, 7.00, 30.00, NULL, 210.00),
(14, 4, 3, 2.00, 22.00, NULL, 44.00),
(15, 5, 6, 2.00, 320.00, NULL, 640.00),
(16, 5, 7, 1.00, 105.00, NULL, 105.00),
(17, 5, 10, 1.00, 18.00, NULL, 18.00),
(18, 6, 2, 2.00, 40.00, NULL, 80.00),
(19, 6, 7, 2.00, 105.00, NULL, 210.00),
(20, 6, 4, 3.00, 30.00, NULL, 90.00),
(21, 7, 4, 2.00, 30.00, NULL, 60.00),
(22, 7, 7, 2.00, 105.00, NULL, 210.00),
(23, 8, 5, 2.00, 85.00, NULL, 170.00),
(24, 8, 7, 4.00, 105.00, NULL, 420.00),
(25, 8, 2, 4.00, 57.00, NULL, 228.00),
(26, 8, 4, 4.00, 30.00, NULL, 120.00),
(27, 8, 3, 4.00, 30.00, NULL, 120.00),
(28, 8, 1, 2.00, 25.00, NULL, 50.00),
(29, 8, 6, 2.00, 320.00, NULL, 640.00),
(30, 8, 8, 4.00, 30.00, NULL, 120.00),
(31, 8, 9, 4.00, 28.00, NULL, 112.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE IF NOT EXISTS `empresa` (
  `id_empresa` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rtn` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correo` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `pie_factura` text COLLATE utf8mb4_unicode_ci,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_empresa`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id_empresa`, `nombre`, `rtn`, `telefono`, `correo`, `direccion`, `pie_factura`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'MI EMPRESA', '1503265896321', '98634512', 'miempresa@gmail.com', 'Voulevar la mora', 'MI EMPRESA', 1, '2026-08-07 09:27:32', '2026-08-09 09:27:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formas_pago`
--

DROP TABLE IF EXISTS `formas_pago`;
CREATE TABLE IF NOT EXISTS `formas_pago` (
  `id_forma_pago` int NOT NULL AUTO_INCREMENT,
  `forma_pago` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_forma_pago`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formas_pago`
--

INSERT INTO `formas_pago` (`id_forma_pago`, `forma_pago`, `estado`) VALUES
(1, 'Efectivo', 1),
(2, 'Tarjeta', 1),
(3, 'Transferencia', 1),
(4, 'Crédito', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos_inventario`
--

DROP TABLE IF EXISTS `movimientos_inventario`;
CREATE TABLE IF NOT EXISTS `movimientos_inventario` (
  `id_movimiento` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_usuario` int NOT NULL,
  `tipo_movimiento` enum('ENTRADA','SALIDA','AJUSTE') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` decimal(12,2) NOT NULL,
  `stock_anterior` decimal(12,2) NOT NULL,
  `stock_nuevo` decimal(12,2) NOT NULL,
  `motivo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_movimiento`),
  KEY `id_producto` (`id_producto`),
  KEY `id_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `movimientos_inventario`
--

INSERT INTO `movimientos_inventario` (`id_movimiento`, `id_producto`, `id_usuario`, `tipo_movimiento`, `cantidad`, `stock_anterior`, `stock_nuevo`, `motivo`, `fecha`) VALUES
(1, 10, 2, 'AJUSTE', 3.00, 91.00, 94.00, 'REMPLAZO DE PRODUCTO', '2026-08-08 16:47:29'),
(2, 8, 2, 'SALIDA', 2.00, 74.00, 72.00, 'SE DAÑARON', '2026-08-08 17:16:03'),
(3, 5, 2, 'ENTRADA', 10.00, 19.00, 29.00, 'COMPRA', '2026-08-08 17:17:05'),
(4, 2, 1, 'AJUSTE', 2.00, 33.00, 33.00, 'REMPLAZO', '2026-08-09 11:18:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

DROP TABLE IF EXISTS `permisos`;
CREATE TABLE IF NOT EXISTS `permisos` (
  `id_permiso` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_permiso`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id_permiso`, `nombre`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'usuarios_ver', 'Ver usuarios', 1, '2026-07-23 19:44:56'),
(2, 'usuarios_crear', 'Crear usuarios', 1, '2026-07-23 19:44:56'),
(3, 'usuarios_editar', 'Editar usuarios', 1, '2026-07-23 19:44:56'),
(4, 'usuarios_eliminar', 'Eliminar usuarios', 1, '2026-07-23 19:44:56'),
(5, 'productos_ver', 'Ver productos', 1, '2026-07-23 19:44:56'),
(6, 'productos_crear', 'Crear productos', 1, '2026-07-23 19:44:56'),
(7, 'productos_editar', 'Editar productos', 1, '2026-07-23 19:44:56'),
(8, 'productos_eliminar', 'Eliminar productos', 1, '2026-07-23 19:44:56'),
(9, 'clientes_ver', 'Ver clientes', 1, '2026-07-23 19:44:56'),
(10, 'clientes_crear', 'Crear clientes', 1, '2026-07-23 19:44:56'),
(11, 'clientes_editar', 'Editar clientes', 1, '2026-07-23 19:44:56'),
(12, 'clientes_eliminar', 'Eliminar clientes', 1, '2026-07-23 19:44:56'),
(13, 'ventas_ver', 'Ver ventas', 1, '2026-07-23 19:44:56'),
(14, 'ventas_crear', 'Crear ventas', 1, '2026-07-23 19:44:56'),
(15, 'ventas_editar', 'Editar ventas', 1, '2026-07-23 19:44:56'),
(16, 'ventas_anular', 'Anular ventas', 1, '2026-07-23 19:44:56'),
(17, 'caja_ver', 'Ver caja', 1, '2026-07-23 19:44:56'),
(18, 'caja_abrir', 'Abrir caja', 1, '2026-07-23 19:44:56'),
(19, 'caja_cerrar', 'Cerrar caja', 1, '2026-07-23 19:44:56'),
(20, 'reportes_ver', 'Ver reportes', 1, '2026-07-23 19:44:56'),
(21, 'reportes_exportar', 'Exportar reportes', 1, '2026-07-23 19:44:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo_barras` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `id_categoria` int NOT NULL,
  `precio_costo` decimal(12,2) NOT NULL DEFAULT '0.00',
  `precio_venta` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock_minimo` decimal(12,2) NOT NULL DEFAULT '0.00',
  `stock_maximo` decimal(12,2) DEFAULT NULL,
  `unidad_medida` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unidad',
  `tipo` enum('Producto','Servicio') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Producto',
  `imagen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_producto`),
  UNIQUE KEY `codigo` (`codigo`),
  UNIQUE KEY `codigo_barras` (`codigo_barras`),
  KEY `fk_productos_categorias` (`id_categoria`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo`, `codigo_barras`, `nombre`, `descripcion`, `id_categoria`, `precio_costo`, `precio_venta`, `stock`, `stock_minimo`, `stock_maximo`, `unidad_medida`, `tipo`, `imagen`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'P001', '750100000001', 'Leche Entera 1L', 'Leche entera pasteurizada', 1, 18.50, 25.00, 44.00, 10.00, 100.00, 'Litro', 'Producto', 'leche.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(2, 'P002', '750100000002', 'Coca Cola 2L', 'Bebida gaseosa', 2, 50.00, 57.00, 33.00, 10.00, 80.00, 'Botella', 'Producto', 'cocacola.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(3, 'P003', '750100000003', 'Papas Fritas 150g', 'Papas fritas sabor original', 3, 25.00, 30.00, 54.00, 15.00, 120.00, 'Bolsa', 'Producto', 'papas.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(4, 'P004', '750100000004', 'Pan Blanco', 'Pan de caja blanco', 4, 22.00, 30.00, 18.00, 10.00, 70.00, 'Unidad', 'Producto', 'pan.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(5, 'P005', '750100000005', 'Detergente 1Kg', 'Detergente en polvo', 5, 65.00, 85.00, 27.00, 5.00, 50.00, 'Kilogramo', 'Producto', 'detergente.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(6, 'P006', '750100000006', 'Shampoo 400ml', 'Shampoo para cabello normal', 6, 250.00, 320.00, 19.00, 5.00, 50.00, 'Unidad', 'Producto', 'shampoo.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(7, 'P007', '750100000007', 'Pechuga de Pollo', 'Pechuga fresca', 7, 80.00, 105.00, 15.00, 10.00, 60.00, 'Kilogramo', 'Producto', 'pollo.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(8, 'P008', '750100000008', 'Manzana Roja', 'Manzana importada', 8, 20.00, 30.00, 68.00, 20.00, 150.00, 'Kilogramo', 'Producto', 'manzana.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(9, 'P009', '750100000009', 'Tomate', 'Tomate fresco', 9, 18.00, 28.00, 64.00, 15.00, 120.00, 'Kilogramo', 'Producto', 'tomate.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:21:01'),
(10, 'P010', '750100000010', 'Chocolate en Barra', 'Chocolate con leche', 10, 12.00, 18.00, 94.00, 20.00, 150.00, 'Unidad', 'Producto', 'chocolate.jpg', 1, '2026-08-06 10:32:03', '2026-08-08 17:15:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE IF NOT EXISTS `proveedores` (
  `id_proveedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contacto` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_proveedor`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre`, `contacto`, `telefono`, `email`, `direccion`, `estado`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Cervecería Hondureña', 'Lic. Carlos Mendoza', '2234-5678', 'ventas@cerveceria.hn', 'Zona Industrial, San Pedro Sula', 1, '2026-08-09 10:23:45', NULL),
(2, 'Coca Cola FEMSA Honduras', 'Ing. Rosa Aguilar', '2240-7788', 'comercial@kof.hn', 'Blvd. Morazán, Tegucigalpa', 1, '2026-08-09 10:23:45', NULL),
(3, 'Distribuidora Central S.A.', 'Sr. Pedro Turcios', '2552-3030', 'pedidos@distcentral.hn', 'Ave. Circunvalación, La Ceiba', 1, '2026-08-09 10:23:45', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_rol` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rol`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'Administrador', 'Acceso total al sistema', 1, '2026-08-07 13:10:47'),
(2, 'Cajero', 'Realiza ventas y operaciones de caja', 1, '2026-08-07 13:10:47'),
(3, 'Supervisor', 'Supervisa operaciones y reportes', 1, '2026-08-07 13:10:47'),
(4, 'Guardia', 'Cuida el negocio', 1, '2026-08-08 18:04:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles_permisos`
--

DROP TABLE IF EXISTS `roles_permisos`;
CREATE TABLE IF NOT EXISTS `roles_permisos` (
  `id_rol` int NOT NULL,
  `id_permiso` int NOT NULL,
  PRIMARY KEY (`id_rol`,`id_permiso`),
  KEY `fk_roles_permisos_permiso` (`id_permiso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles_permisos`
--

INSERT INTO `roles_permisos` (`id_rol`, `id_permiso`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_rol` int NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `ultimo_acceso` datetime DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario` (`usuario`),
  UNIQUE KEY `correo` (`correo`),
  KEY `fk_usuarios_roles` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `usuario`, `correo`, `password`, `id_rol`, `estado`, `ultimo_acceso`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(1, 'Administrador', 'admin', 'admin@localhost.com', '$2y$10$N0CNfcszdEBBCsYGzjnrb.VROHIWeuhkr4ixJE7Eq92xl58K4f/yu', 1, 1, '2026-08-09 11:17:39', '2026-08-07 13:10:47', '2026-08-09 11:17:39'),
(2, 'THAMY PACHECO', 'thamy', 'thamy@gmail.com', '$2y$10$3TypnXy.ZHeAoPZ2V3GnCuUjif128RVP3YnQMda2n2xncUi8EuBhW', 3, 1, '2026-08-08 18:29:18', '2026-08-08 16:37:34', '2026-08-08 18:29:18'),
(3, 'ASHLYN PACHECO', 'ashlyn', 'ashlyn@gmail.com', '$2y$10$ScE64pzgyrh7ppVpZsLieex3GJHq7DsZW3xgE5yt8E3msBZ6cNK7a', 2, 1, NULL, '2026-08-08 16:38:12', NULL),
(4, 'ELIANI DIAZ', 'eliani', 'eliani@gmail.com', '$2y$10$mvv47K2CN83s2y/oP6i/BO6Nw38kc/ygNapwvJMmUT/FmjBbLubj6', 2, 1, NULL, '2026-08-08 16:39:01', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id_venta` int NOT NULL AUTO_INCREMENT,
  `numero_factura` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_cliente` int DEFAULT NULL,
  `id_usuario` int NOT NULL,
  `id_apertura` int NOT NULL,
  `fecha` datetime NOT NULL,
  `subtotal` decimal(12,2) DEFAULT NULL,
  `impuesto` decimal(12,2) DEFAULT NULL,
  `descuento` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `id_forma_pago` int NOT NULL,
  `referencia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banco` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` enum('ACTIVA','ANULADA') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'ACTIVA',
  PRIMARY KEY (`id_venta`),
  KEY `id_cliente` (`id_cliente`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_apertura` (`id_apertura`),
  KEY `id_forma_pago` (`id_forma_pago`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id_venta`, `numero_factura`, `id_cliente`, `id_usuario`, `id_apertura`, `fecha`, `subtotal`, `impuesto`, `descuento`, `total`, `id_forma_pago`, `referencia`, `banco`, `estado`) VALUES
(1, 'FAC-20260806163610640', NULL, 1, 1, '2026-08-06 10:36:10', 50.00, 7.50, 0.00, 57.50, 1, '', '', 'ACTIVA'),
(2, 'FAC-20260806163909995', NULL, 1, 1, '2026-08-06 10:39:09', 240.00, 36.00, 0.00, 276.00, 2, 'REF-00001', 'Banco Occidente', 'ACTIVA'),
(3, 'FAC-20260806165525440', NULL, 1, 2, '2026-08-06 10:55:25', 726.00, 108.90, 0.00, 834.90, 1, '', '', 'ACTIVA'),
(4, 'FAC-20260806165636765', NULL, 1, 2, '2026-08-06 10:56:36', 775.00, 116.25, 0.00, 891.25, 1, '', '', 'ACTIVA'),
(5, 'FAC-20260806170453338', NULL, 1, 3, '2026-08-06 11:04:53', 763.00, 114.45, 0.00, 877.45, 1, '', '', 'ACTIVA'),
(6, 'FAC-20260806170637575', NULL, 1, 3, '2026-08-06 11:06:37', 380.00, 57.00, 0.00, 437.00, 1, '', '', 'ACTIVA'),
(7, 'FAC-20260806170810249', NULL, 1, 3, '2026-08-06 11:08:10', 270.00, 40.50, 0.00, 310.50, 1, '', '', 'ACTIVA'),
(8, 'FAC-20260808232101118', NULL, 2, 4, '2026-08-08 17:21:01', 1980.00, 297.00, 0.00, 2277.00, 1, '', '', 'ACTIVA');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `roles_permisos`
--
ALTER TABLE `roles_permisos`
  ADD CONSTRAINT `fk_roles_permisos_permiso` FOREIGN KEY (`id_permiso`) REFERENCES `permisos` (`id_permiso`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_roles_permisos_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_roles` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
