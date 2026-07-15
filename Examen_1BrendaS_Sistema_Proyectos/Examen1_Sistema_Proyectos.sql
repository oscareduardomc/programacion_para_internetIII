CREATE DATABASE sistema_proyectos;
USE sistema_proyectos;

-- Tabla clientes
CREATE TABLE clientes(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_empresa VARCHAR(100) NOT NULL,
    correo_contacto VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    activo TINYINT(1) DEFAULT 1
);

-- Tabla proyectos
CREATE TABLE proyectos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT,
    id_cliente INT NOT NULL,
    presupuesto DECIMAL(10,2),
    fecha_entrega DATE,
    activo TINYINT(1) DEFAULT 1,

    FOREIGN KEY(id_cliente)
    REFERENCES clientes(id)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

-- Datos de prueba

INSERT INTO clientes(nombre_empresa,correo_contacto,telefono)
VALUES
('Tech Solutions','contacto@tech.com','98765432'),
('Innovate Studio','innovate@gmail.com','99887766');

INSERT INTO proyectos
(titulo,descripcion,id_cliente,presupuesto,fecha_entrega)
VALUES
('Sistema Inventario','Control de inventario',1,20000,'2026-08-15'),

('Página Web','Sitio empresarial',2,15000,'2026-09-10');