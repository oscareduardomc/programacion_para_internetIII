CREATE DATABASE IF NOT EXISTS gestion;
USE gestion;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL
);

CREATE TABLE proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    id_cliente INT NOT NULL,
    presupuesto DECIMAL(12,2) NOT NULL,
    fecha_entrega DATE NOT NULL,
    activo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id)
);

INSERT INTO clientes (nombre, correo, telefono) VALUES
('Ivan Cell #1', 'ivancell123@gmail.com', '9901-0001'),
('Anthony Cell', 'anthonycell12@gmail.com', '9810-0342'),
('Mercadito', 'mercadito123@gmail.com', '3342-1287');
