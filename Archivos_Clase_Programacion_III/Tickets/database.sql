<--Contraseñas para ambos
//usuario@gmail.com = 54321
//tecnico@gmail.com = 54321

//Hice bastantes pruebas para encriptar la contraseña como usted nos enseño con el mismo archivo,
//pero no me dejaba ingresar, la deje plana por eso.

CREATE DATABASE IF NOT EXISTS sistema_tickets;
USE sistema_tickets;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(250) NOT NULL,
    rol ENUM('usuario', 'tecnico') NOT NULL
);

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    departamento VARCHAR(100) DEFAULT 'Sistemas',
    prioridad ENUM('Baja', 'Media', 'Alta') NOT NULL,
    estado ENUM('Pendiente', 'En Proceso', 'Resuelto') DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Juan Usuario', 'usuario@gmail.com', '12345', 'usuario'),
('Pedro Tecnico', 'tecnico@gmail.com', '12345', 'tecnico');


INSERT INTO tickets (id_usuario, titulo, descripcion, departamento, prioridad, estado) VALUES
(1, 'No enciende la impresora', 'La impresora del departamento no responde', 'Contabilidad', 'Alta', 'Pendiente'),
(1, 'Fallo en correo', 'No puedo enviar correos a clientes', 'Ventas', 'Media', 'En Proceso'),
(1, 'Pantalla parpadea', 'El monitor presenta parpadeos constantes', 'Recursos Humanos', 'Baja', 'Resuelto');