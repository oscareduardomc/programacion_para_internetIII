-- Base de datos para el Sistema de Tickets de Soporte

CREATE DATABASE IF NOT EXISTS sistema_tickets
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sistema_tickets;

-- =====================================================
-- TABLA: usuarios
-- =====================================================

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'tecnico') NOT NULL DEFAULT 'usuario'
);

-- =====================================================
-- TABLA: tickets
-- =====================================================

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    departamento VARCHAR(100) NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta') NOT NULL DEFAULT 'Baja',
    estado ENUM('Pendiente', 'En Proceso', 'Resuelto') NOT NULL DEFAULT 'Pendiente',
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_tickets_usuarios
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =====================================================
-- USUARIOS DE PRUEBA (clave: 123456)
-- =====================================================

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Usuario de Prueba', 'usuario@empresa.com', '$2y$12$qSsE9IUDRwhCyCQtEa4Od.mCsVKz7vuVFoKqedn1B7MWaaT6AsjnO', 'usuario'),
('Tecnico de Prueba', 'tecnico@empresa.com', '$2y$12$CGtBP4axBUjUWeCQlextTeYt/fTY2zH95hzMtCcDIj3CAPf3Gihy2', 'tecnico');

-- =====================================================
-- TICKETS DE PRUEBA
-- =====================================================

INSERT INTO tickets (id_usuario, titulo, descripcion, departamento, prioridad, estado, fecha_creacion) VALUES
(1, 'Computadora no enciende', 'La PC de contabilidad no prende al presionar el boton de encendido.', 'Sistemas', 'Alta', 'Pendiente', '2026-08-01 08:30:00'),
(1, 'Problema con el correo', 'No recibo correos del servidor desde ayer en la tarde.', 'Sistemas', 'Media', 'En Proceso', '2026-08-02 10:15:00'),
(1, 'Solicitud de impresora', 'Se necesita una impresora nueva en el area de recepcion.', 'RRHH', 'Baja', 'Resuelto', '2026-08-03 14:45:00');
