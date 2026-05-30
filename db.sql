DROP DATABASE IF EXISTS votaciones_db;
CREATE DATABASE votaciones_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE votaciones_db;

CREATE TABLE roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre_rol VARCHAR(80) NOT NULL UNIQUE,
  descripcion VARCHAR(255) NOT NULL
);

CREATE TABLE usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  correo VARCHAR(120) NOT NULL UNIQUE,
  contrasena VARCHAR(255) NOT NULL,
  estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
  id_rol INT NOT NULL,
  FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
);

CREATE TABLE votaciones (
  id_votacion INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT NOT NULL,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  estado ENUM('Planificada','Activa','Cerrada','Anulada') DEFAULT 'Planificada'
);

CREATE TABLE mesas (
  id_mesa INT AUTO_INCREMENT PRIMARY KEY,
  numero_mesa VARCHAR(20) NOT NULL UNIQUE,
  centro_votacion VARCHAR(150) NOT NULL,
  municipio VARCHAR(100) NOT NULL,
  departamento VARCHAR(100) NOT NULL,
  estado ENUM('Abierta','Cerrada','En revisión') DEFAULT 'Abierta'
);

CREATE TABLE candidatos (
  id_candidato INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  partido VARCHAR(100) NOT NULL,
  cargo VARCHAR(100) NOT NULL,
  estado ENUM('Activo','Inactivo') DEFAULT 'Activo',
  id_votacion INT NOT NULL,
  FOREIGN KEY (id_votacion) REFERENCES votaciones(id_votacion) ON DELETE CASCADE
);

CREATE TABLE resultados (
  id_resultado INT AUTO_INCREMENT PRIMARY KEY,
  id_votacion INT NOT NULL,
  id_mesa INT NOT NULL,
  id_candidato INT NOT NULL,
  votos INT NOT NULL DEFAULT 0,
  observaciones VARCHAR(255) NULL,
  fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  id_usuario INT NULL,
  UNIQUE KEY unico_resultado (id_votacion,id_mesa,id_candidato),
  FOREIGN KEY (id_votacion) REFERENCES votaciones(id_votacion) ON DELETE CASCADE,
  FOREIGN KEY (id_mesa) REFERENCES mesas(id_mesa),
  FOREIGN KEY (id_candidato) REFERENCES candidatos(id_candidato),
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
);

INSERT INTO roles (nombre_rol, descripcion) VALUES
('Administrador','Acceso completo al sistema'),
('Operador','Gestiona votaciones, mesas, candidatos y resultados'),
('Digitador','Registra resultados de mesas electorales'),
('Consulta','Consulta reportes y resultados');

-- Todos los usuarios de prueba usan contraseña: admin123
INSERT INTO usuarios (nombre, correo, contrasena, id_rol) VALUES
('Administrador General','admin@votaciones.com','$2y$12$xPHdHYcn2I01255mtdjVNetwayJ9PDrtBJ8npxzGmQjWfkFm.e5A6',1),
('Operador Electoral','operador@votaciones.com','$2y$12$xPHdHYcn2I01255mtdjVNetwayJ9PDrtBJ8npxzGmQjWfkFm.e5A6',2),
('Digitador de Mesa','digitador@votaciones.com','$2y$12$xPHdHYcn2I01255mtdjVNetwayJ9PDrtBJ8npxzGmQjWfkFm.e5A6',3),
('Usuario Consulta','consulta@votaciones.com','$2y$12$xPHdHYcn2I01255mtdjVNetwayJ9PDrtBJ8npxzGmQjWfkFm.e5A6',4);

INSERT INTO votaciones(nombre,descripcion,fecha_inicio,fecha_fin,estado) VALUES
('Elección General 2026','Proceso electoral general para registro y consulta de resultados.','2026-05-01','2026-05-31','Activa'),
('Consulta Estudiantil','Votación interna para elegir representante estudiantil.','2026-05-10','2026-05-20','Cerrada');

INSERT INTO mesas(numero_mesa,centro_votacion,municipio,departamento,estado) VALUES
('001','Centro Educativo Zona 1','Guatemala','Guatemala','Abierta'),
('002','Instituto Central','Guatemala','Guatemala','Abierta'),
('003','Escuela Municipal','Mixco','Guatemala','Cerrada');

INSERT INTO candidatos(nombre,partido,cargo,id_votacion,estado) VALUES
('Ana López','Planilla Azul','Presidente',1,'Activo'),
('Carlos Méndez','Planilla Blanca','Presidente',1,'Activo'),
('María García','Planilla Innovación','Representante',2,'Activo'),
('José Pérez','Planilla Futuro','Representante',2,'Activo');

INSERT INTO resultados(id_votacion,id_mesa,id_candidato,votos,observaciones,id_usuario) VALUES
(1,1,1,120,'Acta ingresada correctamente',1),
(1,1,2,95,'Acta ingresada correctamente',1),
(1,2,1,140,'Sin observaciones',2),
(1,2,2,110,'Sin observaciones',2),
(2,3,3,80,'Mesa cerrada',1),
(2,3,4,65,'Mesa cerrada',1);
