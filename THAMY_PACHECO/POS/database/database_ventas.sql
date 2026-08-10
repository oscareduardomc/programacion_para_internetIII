USE punto_venta;

-- ============================================
-- TABLA: FORMAS DE PAGO
-- ============================================

CREATE TABLE formas_pago (

    id_forma_pago INT AUTO_INCREMENT PRIMARY KEY,

    forma_pago VARCHAR(100) NOT NULL,

    estado TINYINT(1) DEFAULT 1

);

INSERT INTO formas_pago(forma_pago)
VALUES
('Efectivo'),
('Tarjeta'),
('Transferencia'),
('Crédito');


ALTER TABLE aperturas_caja
ADD diferencia DECIMAL(12,2) DEFAULT 0 AFTER monto_final;

-- ============================================
-- TABLA: CAJAS
-- ============================================

CREATE TABLE cajas(

    id_caja INT AUTO_INCREMENT PRIMARY KEY,

    nombre VARCHAR(100) NOT NULL,

    descripcion VARCHAR(255),

    estado TINYINT(1) DEFAULT 1

);

INSERT INTO cajas(nombre,descripcion)
VALUES
('Caja Principal','Caja Principal del Negocio');


-- ============================================
-- APERTURAS DE CAJA
-- ============================================

CREATE TABLE aperturas_caja(

    id_apertura INT AUTO_INCREMENT PRIMARY KEY,

    id_caja INT NOT NULL,

    id_usuario INT NOT NULL,

    fecha_apertura DATETIME NOT NULL,

    fecha_cierre DATETIME NULL,

    monto_inicial DECIMAL(12,2) NOT NULL,

    monto_final DECIMAL(12,2) DEFAULT NULL,

    estado ENUM('ABIERTA','CERRADA') DEFAULT 'ABIERTA',

    observacion TEXT,

    FOREIGN KEY(id_caja)
        REFERENCES cajas(id_caja),

    FOREIGN KEY(id_usuario)
        REFERENCES usuarios(id_usuario)

);


-- ============================================
-- VENTAS
-- ============================================

CREATE TABLE ventas(

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

    estado ENUM('ACTIVA','ANULADA')
    DEFAULT 'ACTIVA',

    FOREIGN KEY(id_cliente)
        REFERENCES clientes(id_cliente),

    FOREIGN KEY(id_usuario)
        REFERENCES usuarios(id_usuario),

    FOREIGN KEY(id_apertura)
        REFERENCES aperturas_caja(id_apertura),

    FOREIGN KEY(id_forma_pago)
        REFERENCES formas_pago(id_forma_pago)

);


-- ============================================
-- DETALLE VENTAS
-- ============================================

CREATE TABLE detalle_ventas(

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