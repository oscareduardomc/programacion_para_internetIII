
-- CREAR BASE DE DATOS
CREATE DATABASE IF NOT EXISTS tickets_soporte;
USE tickets_soporte;

-- TABLA USUARIOS
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario','tecnico') NOT NULL
);

-- USUARIO NORMAL (SIN HASH)
INSERT INTO usuarios (nombre, email, password, rol)
VALUES ('Daniel', 'daniel@localhost.com', '1234', 'usuario');

-- USUARIO TÉCNICO (SIN HASH)
INSERT INTO usuarios (nombre, email, password, rol)
VALUES ('Tecnico Demo', 'tecnico@localhost.com', 'admin123', 'tecnico');

-- TABLA TICKETS
DROP TABLE IF EXISTS tickets;

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('Baja','Media','Alta') NOT NULL,
    estado ENUM('Pendiente','En Proceso','Resuelto') NOT NULL DEFAULT 'Pendiente',
    departamento VARCHAR(100) NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT NOW(),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- TICKET 1 (YA LO TENÍAS)
INSERT INTO tickets (id_usuario, titulo, descripcion, prioridad, estado, departamento)
VALUES (1, 'Prueba del sistema', 'Ticket de prueba', 'Alta', 'Pendiente', 'Soporte');

-- TICKET 2 (USUARIO NORMAL)
INSERT INTO tickets (id_usuario, titulo, descripcion, prioridad, estado, departamento)
VALUES (1, 'Impresora no imprime', 'La impresora Epson no responde.', 'Alta', 'Pendiente', 'Soporte');

-- TICKET 3 (TÉCNICO)
INSERT INTO tickets (id_usuario, titulo, descripcion, prioridad, estado, departamento)
VALUES (2, 'Error en sistema', 'El técnico reporta que el sistema no carga.', 'Media', 'En Proceso', 'Sistemas');
