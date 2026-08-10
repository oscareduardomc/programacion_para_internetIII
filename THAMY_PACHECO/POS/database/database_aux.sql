USE punto_venta;

-- ============================================
-- TABLA: PROVEEDORES
-- ============================================

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


-- ============================================
-- TABLA: EMPRESA
-- ============================================

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

INSERT INTO empresa (nombre) VALUES ('Mi Empresa');


-- ============================================
-- TABLA: MOVIMIENTOS DE INVENTARIO
-- ============================================

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
