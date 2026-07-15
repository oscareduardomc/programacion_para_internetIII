-- CREAR BASE DE DATOS
CREATE DATABASE taller;
USE taller;

-- TABLA DE CATEGORIAS
CREATE TABLE categorias_respuestos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- TABLA DE REPUESTOS
CREATE TABLE respuestos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo_pieza VARCHAR(30) NOT NULL UNIQUE,
    nombre VARCHAR(120) NOT NULL,
    id_categoria INT NOT NULL,
    stock INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    estado_activo TINYINT(1) DEFAULT 1,
    CONSTRAINT fk_categoria
    FOREIGN KEY (id_categoria) REFERENCES categorias_respuestos(id)
);

-- CATEGORIAS INICIALES
INSERT INTO categorias_respuestos (nombre_categoria, descripcion) VALUES
('Motor', 'Repuestos de motor'),
('Frenos', 'Sistema de frenos'),
('Suspension', 'Amortiguadores y resortes'),
('Electrico', 'Partes electricas');

-- REPUESTOS INICIALES
INSERT INTO respuestos (codigo_pieza, nombre, id_categoria, stock, precio) VALUES
('MTR-001', 'Bujia de encendido', 1, 10, 25.00),
('MTR-002', 'Filtro de aceite', 1, 0, 35.00),
('FRN-001', 'Pastilla de freno', 2, 25, 45.50),
('FRN-002', 'Disco de freno', 2, 4, 80.00),
('SUS-001', 'Amortiguador delantero', 3, 5, 120.00),
('ELE-001', 'Bateria 12V', 4, 8, 200.00);
