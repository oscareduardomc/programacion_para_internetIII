CREATE DATABASE IF NOT EXISTS tickets
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tickets;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    correo VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'tecnico') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    departamento VARCHAR(100) NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta') NOT NULL DEFAULT 'Media',
    estado ENUM('Pendiente', 'En Proceso', 'Resuelto') NOT NULL DEFAULT 'Pendiente',
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_tickets_usuario
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =====================================================
-- DATOS DE PRUEBA
-- =====================================================

-- Usuario: emezachavez39@gmail.com / password usuario123
-- Tecnico: mezae8625@gmail.com / password tecnico123

INSERT INTO usuarios (nombre, correo, password, rol) VALUES
('Eduardo Meza', 'emezachavez39@gmail.com', '$2b$10$snjoh7G2scKi8X7vnnA7B.Cum2L7YKA86UUgGcbHOY9kskCvU84hq', 'usuario'),
('Hector Chavez', 'mezae8625@gmail.com', '$2b$10$rULx1zl32mC6kIMgmPAVIeCESEmeENw97CueQMJAAQTTcpmfjYzPe', 'tecnico');

INSERT INTO tickets (id_usuario, titulo, descripcion, departamento, prioridad, estado, fecha_creacion) VALUES
(1, 'No puedo acceder al correo institucional', 'Al intentar iniciar sesion en el correo me sale un error de contrasena incorrecta aunque la cambie ayer.', 'Sistemas', 'Alta', 'Pendiente', NOW()),
(1, 'Problemas de Conexion', 'Actualementes esta super lento el internet', 'Soporte Tecnico', 'Media', 'En Proceso', NOW()),
(1, 'Problemas al cargar las paginas', 'No cargan los productos en las paginas determinadas', 'Ventas', 'Baja', 'Resuelto', NOW());
