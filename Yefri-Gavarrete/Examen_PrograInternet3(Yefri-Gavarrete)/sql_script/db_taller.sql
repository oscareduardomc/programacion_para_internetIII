CREATE DATABASE taller_db
USE taller_db;

CREATE TABLE categoria_repuesto(
	id INT AUTO_INCREMENT PRIMARY KEY,
	nombre_categoria VARCHAR(100) NOT NULL,
	descripcion VARCHAR(100) NOT NULL
);



CREATE TABLE repuestos(
	id INT AUTO_INCREMENT PRIMARY KEY ,
	codigo_pieza VARCHAR(50) NOT NULL UNIQUE,
	nombre VARCHAR(100) NOT NULL, 
	id_categoria INT NOT NULL,
	stock INT NOT NULL,
	precio DECIMAL(10, 2) NOT NULL,
	estado_activo TINYINT(1) DEFAULT 1,
	FOREIGN KEY (id_categoria) REFERENCES categoria_repuesto(id)

);