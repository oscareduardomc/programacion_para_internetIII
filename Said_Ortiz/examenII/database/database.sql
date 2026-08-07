CREATE DATABASE IF NOT EXISTS soporte_tickets
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE soporte_tickets;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'tecnico') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta') NOT NULL DEFAULT 'Media',
    estado ENUM('Pendiente', 'En Proceso', 'Resuelto') NOT NULL DEFAULT 'Pendiente',
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Contraseña para ambos usuarios: 123456
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Bertilia Molina', 'bertilia@empresa.com', '$2y$10$NwI1nTUplx1eQ8i3qnFrhOLyST3SZD9WS6CetsHzaXL5xPTedoFE6', 'usuario'),
('Said Ortiz', 'said@empresa.com', '$2y$10$NwI1nTUplx1eQ8i3qnFrhOLyST3SZD9WS6CetsHzaXL5xPTedoFE6', 'tecnico');

INSERT INTO tickets (id_usuario, titulo, descripcion, prioridad, estado, fecha_creacion) VALUES
(1, 'No puedo acceder al correo', 'Departamento: Sistemas. Mi cuenta corporativa no permite iniciar sesión.', 'Alta', 'Pendiente', '2026-08-06 09:15:00'),
(1, 'Impresora sin conexión', 'Departamento: Administración. La impresora del área contable aparece desconectada.', 'Media', 'En Proceso', '2026-08-06 10:30:00'),
(1, 'Solicitud de software', 'Departamento: Ventas. Necesito instalar el paquete Office en mi equipo.', 'Baja', 'Resuelto', '2026-08-05 14:00:00');
