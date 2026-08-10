-- ============================================================
-- SISTEMA PUNTO DE VENTA  |  BASE DE DATOS COMPLETA (UNIFICADA)
-- ============================================================
-- Importa SOLO este archivo (phpMyAdmin: Importar).
-- Es re-ejecutable: usa IF NOT EXISTS / INSERT IGNORE.
-- Orden correcto: primero las tablas padre y luego las que
-- dependen de ellas (foreign keys), y al final los datos.
-- ============================================================

CREATE DATABASE IF NOT EXISTS punto_venta
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE punto_venta;

-- ============================================================
-- 1. ROLES
-- ============================================================

CREATE TABLE IF NOT EXISTS roles (
    id_rol int AUTO_INCREMENT PRIMARY key,
    nombre varchar(100) not null UNIQUE,
    descripcion varchar(255),
    estado tinyint(1) not null default 1,
    fecha_creacion datetime not null DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- 2. PERMISOS
-- ============================================================

CREATE TABLE IF NOT EXISTS permisos (
    id_permiso int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(100) not null UNIQUE,
    descripcion varchar(255),
    estado tinyint(1) not null default 1,
    fecha_creacion datetime not null DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- 3. ROLES_PERMISOS (depende de roles y permisos)
-- ============================================================

CREATE TABLE IF NOT EXISTS roles_permisos (
    id_rol int not null,
    id_permiso int not null,
    PRIMARY KEY(id_rol, id_permiso),

    CONSTRAINT fk_roles_permisos_rol
    FOREIGN KEY (id_rol)
    REFERENCES roles(id_rol)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

    CONSTRAINT fk_roles_permisos_permiso
    FOREIGN KEY (id_permiso)
    REFERENCES permisos(id_permiso)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

-- ============================================================
-- 4. USUARIOS (depende de roles)
-- ============================================================

CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    usuario VARCHAR(100) NOT NULL UNIQUE,
    correo VARCHAR(150) UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    ultimo_acceso DATETIME NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuarios_roles
        FOREIGN KEY (id_rol)
        REFERENCES roles(id_rol)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- ============================================================
-- 5. CATEGORIAS
-- ============================================================

CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    categoria VARCHAR(150) not null unique,
    descripcion varchar(255),
    estado tinyint(1) not null DEFAULT 1,
    fecha_creacion datetime not null default CURRENT_TIMESTAMP,
    fecha_actualizacion datetime null on UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
-- 6. PRODUCTOS (depende de categorias)
-- ============================================================

CREATE TABLE IF NOT EXISTS productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(100) UNIQUE,
    codigo_barras VARCHAR(100) UNIQUE,
    nombre VARCHAR(200) NOT NULL,
    descripcion TEXT,
    id_categoria INT NOT NULL,
    precio_costo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    precio_venta DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    stock DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    stock_minimo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    stock_maximo DECIMAL(12,2) NULL,
    unidad_medida VARCHAR(50) NOT NULL DEFAULT 'Unidad',
    tipo ENUM('Producto','Servicio') NOT NULL DEFAULT 'Producto',
    imagen VARCHAR(255) NULL,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_productos_categorias
        FOREIGN KEY (id_categoria)
        REFERENCES categorias(id_categoria)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

-- ============================================================
-- 7. CLIENTES
-- ============================================================

CREATE TABLE IF NOT EXISTS clientes (
    id_cliente int AUTO_INCREMENT PRIMARY key,
    nombre varchar(200) not null,
    identidad varchar(50) UNIQUE,
    telefono varchar(50),
    correo varchar(50),
    direccion text,
    limite_credito decimal(12,2) not null DEFAULT 0.00,
    saldo_credito decimal(12,2) not null DEFAULT 0.00,
    estado tinyint(1) not null DEFAULT 1,
    fecha_creacion datetime not null DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
-- 8. PROVEEDORES
-- ============================================================

CREATE TABLE IF NOT EXISTS proveedores (
    id_proveedor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    contacto VARCHAR(150),
    telefono VARCHAR(50),
    email VARCHAR(100),
    direccion TEXT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
-- 9. EMPRESA
-- ============================================================

CREATE TABLE IF NOT EXISTS empresa (
    id_empresa INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    rtn VARCHAR(50),
    telefono VARCHAR(50),
    correo VARCHAR(100),
    direccion TEXT,
    pie_factura TEXT,
    estado TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================================
-- 10. FORMAS DE PAGO
-- ============================================================

CREATE TABLE IF NOT EXISTS formas_pago (
    id_forma_pago INT AUTO_INCREMENT PRIMARY KEY,
    forma_pago VARCHAR(100) NOT NULL,
    estado TINYINT(1) DEFAULT 1
);

-- ============================================================
-- 11. CAJAS
-- ============================================================

CREATE TABLE IF NOT EXISTS cajas (
    id_caja INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255),
    estado TINYINT(1) DEFAULT 1
);

-- ============================================================
-- 12. APERTURAS DE CAJA (depende de cajas y usuarios)
--     Nota: la columna 'diferencia' ya viene incluida aqui
--     (antes se agregaba con un ALTER desordenado).
-- ============================================================

CREATE TABLE IF NOT EXISTS aperturas_caja (
    id_apertura INT AUTO_INCREMENT PRIMARY KEY,
    id_caja INT NOT NULL,
    id_usuario INT NOT NULL,
    fecha_apertura DATETIME NOT NULL,
    fecha_cierre DATETIME NULL,
    monto_inicial DECIMAL(12,2) NOT NULL,
    monto_final DECIMAL(12,2) DEFAULT NULL,
    diferencia DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    estado ENUM('ABIERTA','CERRADA') DEFAULT 'ABIERTA',
    observacion TEXT,

    FOREIGN KEY(id_caja)
        REFERENCES cajas(id_caja),

    FOREIGN KEY(id_usuario)
        REFERENCES usuarios(id_usuario)
);

-- ============================================================
-- 13. VENTAS (depende de clientes, usuarios, aperturas_caja, formas_pago)
-- ============================================================

CREATE TABLE IF NOT EXISTS ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    numero_factura VARCHAR(30),
    id_cliente INT,
    id_usuario INT NOT NULL,
    id_apertura INT NOT NULL,
    fecha DATETIME NOT NULL,
    subtotal DECIMAL(12,2),
    impuesto DECIMAL(12,2),
    descuento DECIMAL(12,2),
    total DECIMAL(12,2),
    id_forma_pago INT NOT NULL,
    referencia VARCHAR(100),
    banco VARCHAR(100),
    estado ENUM('ACTIVA','ANULADA') DEFAULT 'ACTIVA',

    FOREIGN KEY(id_cliente)
        REFERENCES clientes(id_cliente),

    FOREIGN KEY(id_usuario)
        REFERENCES usuarios(id_usuario),

    FOREIGN KEY(id_apertura)
        REFERENCES aperturas_caja(id_apertura),

    FOREIGN KEY(id_forma_pago)
        REFERENCES formas_pago(id_forma_pago)
);

-- ============================================================
-- 14. DETALLE VENTAS (depende de ventas y productos)
-- ============================================================

CREATE TABLE IF NOT EXISTS detalle_ventas (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad DECIMAL(12,2),
    precio DECIMAL(12,2),
    impuesto DECIMAL(12,2),
    subtotal DECIMAL(12,2),

    FOREIGN KEY(id_venta)
        REFERENCES ventas(id_venta),

    FOREIGN KEY(id_producto)
        REFERENCES productos(id_producto)
);

-- ============================================================
-- 15. MOVIMIENTOS DE INVENTARIO (depende de productos y usuarios)
-- ============================================================

CREATE TABLE IF NOT EXISTS movimientos_inventario (
    id_movimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_producto INT NOT NULL,
    id_usuario INT NOT NULL,
    tipo_movimiento ENUM('ENTRADA', 'SALIDA', 'AJUSTE') NOT NULL,
    cantidad DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    stock_anterior DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    stock_nuevo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    motivo TEXT NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_mov_producto (id_producto),
    INDEX idx_mov_usuario (id_usuario)
);

-- ============================================================
-- ================== DATOS INICIALES =========================
-- ============================================================

INSERT IGNORE INTO roles (id_rol, nombre, descripcion) VALUES
(1, 'Administrador', 'Acceso total al sistema'),
(2, 'Cajero', 'Realiza ventas y operaciones de caja'),
(3, 'Supervisor', 'Supervisa operaciones y reportes');

INSERT IGNORE INTO permisos (nombre, descripcion) VALUES
('usuarios_ver', 'Ver usuarios'),
('usuarios_crear', 'Crear usuarios'),
('usuarios_editar', 'Editar usuarios'),
('usuarios_eliminar', 'Eliminar usuarios'),

('productos_ver', 'Ver productos'),
('productos_crear', 'Crear productos'),
('productos_editar', 'Editar productos'),
('productos_eliminar', 'Eliminar productos'),

('clientes_ver', 'Ver clientes'),
('clientes_crear', 'Crear clientes'),
('clientes_editar', 'Editar clientes'),
('clientes_eliminar', 'Eliminar clientes'),

('ventas_ver', 'Ver ventas'),
('ventas_crear', 'Crear ventas'),
('ventas_editar', 'Editar ventas'),
('ventas_anular', 'Anular ventas'),

('caja_ver', 'Ver caja'),
('caja_abrir', 'Abrir caja'),
('caja_cerrar', 'Cerrar caja'),

('reportes_ver', 'Ver reportes'),
('reportes_exportar', 'Exportar reportes');

INSERT IGNORE INTO roles_permisos (id_rol, id_permiso)
SELECT 1, id_permiso FROM permisos;

-- Permisos del rol Cajero
INSERT IGNORE INTO roles_permisos (id_rol, id_permiso)
SELECT 2, id_permiso FROM permisos
WHERE nombre IN ('ventas_ver', 'ventas_crear',
                 'caja_ver', 'caja_abrir', 'caja_cerrar',
                 'productos_ver', 'clientes_ver');

-- Permisos del rol Supervisor
INSERT IGNORE INTO roles_permisos (id_rol, id_permiso)
SELECT 3, id_permiso FROM permisos
WHERE nombre IN ('usuarios_ver',
                 'productos_ver', 'productos_crear', 'productos_editar',
                 'clientes_ver', 'clientes_crear', 'clientes_editar',
                 'ventas_ver', 'ventas_crear', 'ventas_anular',
                 'caja_ver', 'caja_abrir', 'caja_cerrar',
                 'reportes_ver', 'reportes_exportar');

INSERT IGNORE INTO categorias (id_categoria, categoria, descripcion) VALUES
(1, 'General', 'Categoría general de productos'),
(2, 'Bebidas', 'Gaseosas, aguas y jugos'),
(3, 'Snacks', 'Papitas, galletas y botanas'),
(4, 'Licores y Cervezas', 'Cervezas, rones y licores'),
(5, 'Abarrotes', 'Granos básicos, aceites y conservas'),
(6, 'Cigarrillos', 'Cigarrillos y tabaco');

-- ============================================================
-- PRODUCTOS DE EJEMPLO
-- (el producto 'Aceite Corazón' tiene stock bajo a proposito
--  para que el indicador "Stock Bajo" del dashboard se vea)
-- ============================================================

INSERT IGNORE INTO productos
(codigo, codigo_barras, nombre, descripcion, id_categoria,
 precio_costo, precio_venta, stock, stock_minimo, unidad_medida, tipo) VALUES
('00001', '7440000000011', 'Coca Cola 355ml', 'Gaseosa sabor cola, lata 355ml', 2,
 15.00, 18.00, 120, 20, 'Unidad', 'Producto'),
('00002', '7440000000028', 'Agua Purificada 1L', 'Agua embotellada 1 litro', 2,
 9.00, 12.00, 80, 15, 'Unidad', 'Producto'),
('00003', '7440000000035', 'Tortrix Salsa Verde 45g', 'Botana tortrix sabor salsa verde', 3,
 12.00, 15.00, 60, 10, 'Unidad', 'Producto'),
('00004', '7440000000042', 'Papas Sabritas 100g', 'Papas fritas sabor original', 3,
 20.00, 25.00, 50, 10, 'Unidad', 'Producto'),
('00005', '7440000000059', 'Cerveza Salva Vida 350ml', 'Cerveza hondureña 350ml', 4,
 30.00, 35.00, 96, 24, 'Unidad', 'Producto'),
('00006', '7440000000066', 'Cerveza Imperial 350ml', 'Cerveza hondureña 350ml', 4,
 30.00, 35.00, 96, 24, 'Unidad', 'Producto'),
('00007', '7440000000073', 'Arroz Corinto 1kg', 'Arroz blanco 1kg', 5,
 24.00, 28.00, 40, 10, 'Bolsa', 'Producto'),
('00008', '7440000000080', 'Frijoles Rojos 900g', 'Frijoles rojos en bolsa 900g', 5,
 25.00, 30.00, 35, 10, 'Bolsa', 'Producto'),
('00009', '7440000000097', 'Aceite Corazón 1L', 'Aceite vegetal 1 litro', 5,
 58.00, 65.00, 3, 10, 'Envase', 'Producto'),
('00010', '7440000000103', 'Huevo Blanco x unidad', 'Huevo blanco de rancho por unidad', 5,
 5.00, 6.00, 200, 50, 'Unidad', 'Producto');

-- ============================================================
-- CLIENTES DE EJEMPLO
-- ============================================================

INSERT IGNORE INTO clientes
(id_cliente, nombre, identidad, telefono, correo, direccion, limite_credito, saldo_credito, estado) VALUES
(1, 'María López', '05011994001234', '9990-1122', 'maria.lopez@mail.com', 'Col. Las Palmas, Tegucigalpa', 2000.00, 0.00, 1),
(2, 'Juan Pérez', '08011992005678', '9988-3344', 'juan.perez@mail.com', 'Barrio El Centro, San Pedro Sula', 1500.00, 0.00, 1),
(3, 'Tienda El Rosario', '08019998000234', '2234-8899', 'tienda.rosario@mail.com', 'Ave. 2, Comayagua', 5000.00, 0.00, 1);

-- ============================================================
-- PROVEEDORES DE EJEMPLO
-- ============================================================

INSERT IGNORE INTO proveedores
(id_proveedor, nombre, contacto, telefono, email, direccion, estado) VALUES
(1, 'Cervecería Hondureña', 'Lic. Carlos Mendoza', '2234-5678', 'ventas@cerveceria.hn', 'Zona Industrial, San Pedro Sula', 1),
(2, 'Coca Cola FEMSA Honduras', 'Ing. Rosa Aguilar', '2240-7788', 'comercial@kof.hn', 'Blvd. Morazán, Tegucigalpa', 1),
(3, 'Distribuidora Central S.A.', 'Sr. Pedro Turcios', '2552-3030', 'pedidos@distcentral.hn', 'Ave. Circunvalación, La Ceiba', 1);

INSERT IGNORE INTO usuarios (nombre, usuario, correo, password, id_rol)
VALUES ('Administrador', 'admin', 'admin@localhost.com',
        '$2y$12$aYdr8m/PslAdrNHf3tvWjO3tDE993xqPTEwzJoo52UTlgwxAHmJzW',
        1);

INSERT IGNORE INTO formas_pago (forma_pago) VALUES
('Efectivo'),
('Tarjeta'),
('Transferencia'),
('Crédito');

INSERT IGNORE INTO cajas (nombre, descripcion)
VALUES ('Caja Principal', 'Caja Principal del Negocio');

INSERT INTO empresa (nombre)
SELECT 'Mi Empresa'
WHERE NOT EXISTS (SELECT 1 FROM empresa);

-- ============================================================
-- VENTAS / FACTURAS DE EJEMPLO
-- Notas:
--  * La apertura de caja seed es CERRADA a proposito, para que
--    el flujo real "Abrir caja" siga funcionando normal.
--  * Venta 1 queda registrada HOY (NOW) para que el dashboard
--    muestre "Ventas Hoy" con datos.
--  * Todo usa INSERT...WHERE NOT EXISTS para que sea re-importable.
-- ============================================================

-- Apertura de caja de ejemplo (CERRADA)
INSERT INTO aperturas_caja
(id_apertura, id_caja, id_usuario, fecha_apertura, fecha_cierre,
 monto_inicial, monto_final, diferencia, estado, observacion)
SELECT 1, 1,
       (SELECT id_usuario FROM usuarios WHERE usuario = 'admin' LIMIT 1),
       DATE_SUB(NOW(), INTERVAL 1 DAY),
       DATE_SUB(NOW(), INTERVAL 1 DAY),
       1000.00, 1476.85, 0.00, 'CERRADA', 'Apertura de caja de ejemplo'
WHERE NOT EXISTS (SELECT 1 FROM aperturas_caja WHERE id_apertura = 1);

-- ---------- Venta 1: HOY, efectivo, clienta María López ----------

INSERT INTO ventas
(numero_factura, id_cliente, id_usuario, id_apertura, fecha,
 subtotal, impuesto, descuento, total, id_forma_pago, referencia, banco)
SELECT 'FAC-20260809100001', 1,
       (SELECT id_usuario FROM usuarios WHERE usuario = 'admin' LIMIT 1),
       1, NOW(),
       153.00, 22.95, 0.00, 175.95, 1, NULL, NULL
WHERE NOT EXISTS (SELECT 1 FROM ventas WHERE numero_factura = 'FAC-20260809100001');

INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio, subtotal)
SELECT v.id_venta, 2, 2, 18.00, 36.00
FROM ventas v
WHERE v.numero_factura = 'FAC-20260809100001'
  AND NOT EXISTS (SELECT 1 FROM detalle_ventas d WHERE d.id_venta = v.id_venta AND d.id_producto = 2);

INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio, subtotal)
SELECT v.id_venta, 3, 3, 15.00, 45.00
FROM ventas v
WHERE v.numero_factura = 'FAC-20260809100001'
  AND NOT EXISTS (SELECT 1 FROM detalle_ventas d WHERE d.id_venta = v.id_venta AND d.id_producto = 3);

INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio, subtotal)
SELECT v.id_venta, 10, 12, 6.00, 72.00
FROM ventas v
WHERE v.numero_factura = 'FAC-20260809100001'
  AND NOT EXISTS (SELECT 1 FROM detalle_ventas d WHERE d.id_venta = v.id_venta AND d.id_producto = 10);

-- ---------- Venta 2: hace 3 días, tarjeta, consumidor final ----------

INSERT INTO ventas
(numero_factura, id_cliente, id_usuario, id_apertura, fecha,
 subtotal, impuesto, descuento, total, id_forma_pago, referencia, banco)
SELECT 'FAC-20260806103000', NULL,
       (SELECT id_usuario FROM usuarios WHERE usuario = 'admin' LIMIT 1),
       1, DATE_SUB(NOW(), INTERVAL 3 DAY),
       266.00, 39.90, 0.00, 305.90, 2, 'TARJ-88291', 'BAC Credomatic'
WHERE NOT EXISTS (SELECT 1 FROM ventas WHERE numero_factura = 'FAC-20260806103000');

INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio, subtotal)
SELECT v.id_venta, 5, 6, 35.00, 210.00
FROM ventas v
WHERE v.numero_factura = 'FAC-20260806103000'
  AND NOT EXISTS (SELECT 1 FROM detalle_ventas d WHERE d.id_venta = v.id_venta AND d.id_producto = 5);

INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio, subtotal)
SELECT v.id_venta, 7, 2, 28.00, 56.00
FROM ventas v
WHERE v.numero_factura = 'FAC-20260806103000'
  AND NOT EXISTS (SELECT 1 FROM detalle_ventas d WHERE d.id_venta = v.id_venta AND d.id_producto = 7);
