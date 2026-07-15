CREATE DATABASE sistema_empleados;
USE sistema_empleados;

CREATE TABLE empleados(
	id INT AUTO_INCREMENT PRIMARY KEY ,
	nombre VARCHAR(100) NOT NULL,
	puesto VARCHAR(50) NOT NULL, 
	salario DECIMAL(10, 2) NOT NULL,
	fecha_ingreso TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	


);