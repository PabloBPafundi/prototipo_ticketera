-- Crear la base de datos
CREATE DATABASE prototipo_bd;

-- Seleccionar la base de datos recién creada
USE prototipo_bd;


CREATE TABLE permiso (
id_permiso INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
permiso VARCHAR(75) NOT NULL,
descripcionPermiso VARCHAR(75) NOT NULL

);

CREATE TABLE jerarquia (
id_jerarquia INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
rol VARCHAR(60) NOT NULL

);

CREATE TABLE departamento (
id_departamento INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
nombre VARCHAR(60) NOT NULL,
descripcion VARCHAR(255)

);


CREATE TABLE empleado (

id_empleado INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
nombre VARCHAR(75),
apellido VARCHAR(75),
nroDNI VARCHAR(75),
nroContacto VARCHAR(75),
activo BOOLEAN DEFAULT 1,
usuario VARCHAR(75),
usuarioCampana VARCHAR(75),
mail_laboral VARCHAR(75),
fecha_hora_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,

fk_id_jerarquia INT,
 fk_id_departamento INT,
 
 FOREIGN KEY (fk_id_departamento) REFERENCES departamento (id_departamento),
FOREIGN KEY (fk_id_jerarquia) REFERENCES jerarquia (id_jerarquia)



);



CREATE TABLE empleado_permiso (
id_empleado_permiso INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
fk_id_permiso INT NOT NULL,
fk_id_empleado INT NOT NULL,

FOREIGN KEY (fk_id_permiso) REFERENCES permiso (id_permiso),
FOREIGN KEY (fk_id_empleado) REFERENCES empleado (id_empleado)

);


CREATE TABLE ticket (

id_ticket INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
descripcion_tecnico VARCHAR(255),
fechaHora_inicio DATETIME,
fechaHora_cierre DATETIME,
tipo_inconveniente VARCHAR(255),
fecha_hora_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
comentario_solicitante VARCHAR (255),
ubicacionLaboral VARCHAR(255),
nroElevado VARCHAR(255),
estado_resolucion VARCHAR(255),
estado_gestion_agente BOOLEAN,
posicionLaboral  VARCHAR(255),
proveedorInternet VARCHAR (255),
idRemoteDesktop VARCHAR (75),


fk_id_tecnico INT,
fk_id_empleado INT,

FOREIGN KEY (fk_id_tecnico) REFERENCES empleado (id_empleado),
FOREIGN KEY (fk_id_empleado) REFERENCES empleado (id_empleado)


);



INSERT INTO departamento (nombre, descripcion) VALUES
('Sin campaña', 'Empleado sin campaña de la empresa'),
('Retención Movil', 'Retención Móvil'),
('Retención Fija', 'Retención Fija'),
('Ventas OUT', 'Ventas OUT'),
('Ventas IN', 'Ventas IN'),
('HBO', 'HBO'),
('Star', 'Star'),
('Adultos', 'Adultos'),
('Retencion Clarín 365', 'Retención Clarín 365'),
('Clarín 365', 'Clarín 365'),
('Zurich', 'Zurich'),
('Sistemas', 'Sistemas'),
('RRHH', 'RRHH'),
('Capacitacion', 'Capacitacion'),
('Pfizer', 'Pfizer');


INSERT INTO jerarquia (rol) VALUES
('S/ Rol'),
('Ejecutivo de Ventas'),
('TeamLeader Ventas'),
('Coordinador'),
('Capacitador'),
('Jefe de Area'),
('Supervidor'),
('HelpDesk');