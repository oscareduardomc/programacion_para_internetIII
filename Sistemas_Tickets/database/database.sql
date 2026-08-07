CREATE DATABASE sistemas_tickets;

USE sistemas_tickets;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'tecnico') NOT NULL
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    descripcion TEXT NOT NULL,
    prioridad ENUM('Baja', 'Media', 'Alta') NOT NULL,
    estado ENUM('Pendiente', 'En Proceso', 'Resuelto') NOT NULL DEFAULT 'Pendiente',
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_tickets_usuarios
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
);





INSERT INTO usuarios(nombre,email,password,rol)
VALUES('Juan Pérez','juanperez@gmail.com','$2y$10$w.s7Ecy8jTZWchxyljqokumyoMUcStAZC.WNUy9RjQ40b.jQb69YS','usuario'),
('María López','lopez25@gmail.com','$2y$10$2l33/sVEuUZ2VWbMEE/KG.kfBRya4B1cuDG6WNISSW5RMvxpgCws6','tecnico');


#contraseñas 12345678.. para usuario,  y 12345678 para tecnico las cree usando el prueba.php

INSERT INTO tickets
(id_usuario,titulo,descripcion,prioridad,estado)
VALUES

(1, 'No puedo iniciar sesión','El sistema indica contraseña incorrecta aunque las credenciales son válidas.','Alta','Pendiente'),
(1,'Error al imprimir reporte','El reporte de ventas no genera el archivo PDF.', 'Media','En Proceso'),
(1,'Actualizar navegador','Se requiere actualizar Google Chrome en el equipo de trabajo.','Baja','Resuelto');


SELECT * FROM usuarios;


SELECT * FROM tickets;


