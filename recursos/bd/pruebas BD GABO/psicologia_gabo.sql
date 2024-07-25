DROP DATABASE IF EXISTS psico;
CREATE DATABASE IF NOT EXISTS psico DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

GRANT ALL PRIVILEGES ON perduptx.* TO 'userpsico'@'localhost' IDENTIFIED BY 'passwordpsico123';

USE psico;

CREATE TABLE roles (
    creacion TIMESTAMP NULL DEFAULT NULL,
    actualizacion TIMESTAMP NULL DEFAULT NULL,
    eliminacion DATETIME DEFAULT NULL,
    estatus_rol TINYINT(1) NOT NULL DEFAULT 2,
    id_rol INT(3) NOT NULL PRIMARY KEY,
    rol VARCHAR(30) NOT NULL
)ENGINE=InnoDB;

-- ROLES 
-- -- 749 : SUPERADMIN
-- -- 846 : ADMIN
-- -- 521 : PSICOLOGO
-- -- 496 : PACIENTE - ALUMNO
-- -- 237 : EMPLEADO
-- -- 194 : INVITADO


INSERT INTO roles (creacion, actualizacion, estatus_rol, id_rol, rol) VALUES
    (current_timestamp(), current_timestamp(), '2', 749, 'Superadmin'),
    (current_timestamp(), current_timestamp(), '2', 846, 'Administrador'),
    (current_timestamp(), current_timestamp(), '2', 521, 'Psicologo'),
    (current_timestamp(), current_timestamp(), '2', 496, 'Paciente');

CREATE TABLE subcategorias (
    creacion TIMESTAMP NULL DEFAULT NULL,
    actualizacion TIMESTAMP NULL DEFAULT NULL,
    eliminacion DATETIME DEFAULT NULL,
    estatus_subcate TINYINT(1) NOT NULL DEFAULT 2,
    id_subcate INT(3) NOT NULL PRIMARY KEY,
    subcategoria VARCHAR(30) NOT NULL
)ENGINE=InnoDB;

-- SUBCATEGORIAS 
-- -- 439 : ALUMNO
-- -- 426 : EMPLEADO
-- -- 411 : INVITADO

INSERT INTO subcategorias (creacion, actualizacion, estatus_subcate, id_subcate, subcategoria) VALUES
    (current_timestamp(), current_timestamp(), '2', 439, 'Alumno'),
    (current_timestamp(), current_timestamp(), '2', 426, 'Empleado'),
    (current_timestamp(), current_timestamp(), '2', 411, 'Invitado');




CREATE TABLE usuarios (
    creacion TIMESTAMP NULL DEFAULT NULL,
    actualizacion TIMESTAMP NULL DEFAULT NULL,
    eliminacion DATETIME DEFAULT NULL,
    estatus_usuario TINYINT(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
    id_usuario INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50) NOT NULL,
    ap_paterno_usuario VARCHAR(50) NOT NULL,
    ap_materno_usuario VARCHAR(50) NOT NULL,
    sexo_usuario TINYINT(1) NOT NULL,
    email_usuario VARCHAR(70) NOT NULL,
    password_usuario VARCHAR(64) NOT NULL,
    imagen_usuario VARCHAR(100) DEFAULT NULL,
	id_rol INT(3) NOT NULL,
	FOREIGN KEY(id_rol) REFERENCES roles (id_rol) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;

INSERT INTO usuarios (creacion, actualizacion, estatus_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario, sexo_usuario, email_usuario, password_usuario, imagen_usuario, id_rol) VALUES
    (current_timestamp(), current_timestamp(), '2', 'Superadmin', 'Paterno', 'Materno', 2, 'superadmin@psico.com', SHA2('superadmin123',0), NULL, 749),
    (current_timestamp(), current_timestamp(), '2', 'Admin', 'Paterno', 'Materno', 2, 'admin@psico.com', 'admin123', NULL, 846);

CREATE TABLE paciente (
creacion TIMESTAMP NULL DEFAULT NULL,
actualizacion TIMESTAMP NULL DEFAULT NULL,
eliminacion DATETIME DEFAULT NULL,
estatus_paciente TINYINT(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
id_paciente int(11) NOT NULL PRIMARY KEY,
referencia varchar(100) DEFAULT NULL,
tipo_atencion varchar(100) DEFAULT NULL,
observaciones text DEFAULT NULL,
numero_expediente int(11) DEFAULT NULL,
id_subcate INT(3) NOT NULL,
FOREIGN KEY (id_paciente) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY(id_subcate) REFERENCES subcategorias(id_subcate) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE psicologos (
creacion TIMESTAMP NULL DEFAULT NULL,
actualizacion TIMESTAMP NULL DEFAULT NULL,
eliminacion DATETIME DEFAULT NULL,
estatus_psicologo TINYINT(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
id_psicologo int(11) NOT NULL PRIMARY KEY,
numero_trabajador_psicologo int(11) DEFAULT NULL,
FOREIGN KEY (id_psicologo) REFERENCES usuarios(id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE tipos_atencion (
    creacion TIMESTAMP NULL DEFAULT NULL,
    actualizacion TIMESTAMP NULL DEFAULT NULL,
    eliminacion DATETIME DEFAULT NULL,
    estatus_tipo_atencion TINYINT(1) NOT NULL DEFAULT 2,
    id_tipo_atencion INT(3) NOT NULL PRIMARY KEY,
    tipo_atencion VARCHAR(30) NOT NULL
)ENGINE=InnoDB;

-- TIPO DE ATENCION
-- -- 111 : Primera vez
-- -- 122 : Subsecuente

INSERT INTO tipos_atencion (creacion, actualizacion, estatus_tipo_atencion, id_tipo_atencion, tipo_atencion) VALUES
    (current_timestamp(), current_timestamp(), '2', 111, 'Primera vez'),
    (current_timestamp(), current_timestamp(), '2', 122, 'Subsecuente');


CREATE TABLE tipos_referencias (
    creacion TIMESTAMP NULL DEFAULT NULL,
    actualizacion TIMESTAMP NULL DEFAULT NULL,
    eliminacion DATETIME DEFAULT NULL,
    estatus_tipo_referencia TINYINT(1) NOT NULL DEFAULT 2,
    id_tipo_referencia INT(3) NOT NULL PRIMARY KEY,
    tipo_referencia VARCHAR(30) NOT NULL
)ENGINE=InnoDB;


-- TIPO DE REFERENCIA
-- -- 211 : Servicio Médico
-- -- 222 : Tutor
-- -- 233 : Director Carrera
-- -- 244 : Otro

INSERT INTO tipos_referencias (creacion, actualizacion, estatus_tipo_referencia, id_tipo_referencia, tipo_referencia) VALUES
    (current_timestamp(), current_timestamp(), '2', 211, 'Servicio Médico'),
    (current_timestamp(), current_timestamp(), '2', 222, 'Tutor');
    (current_timestamp(), current_timestamp(), '2', 233, 'Director Carrera');
    (current_timestamp(), current_timestamp(), '2', 244, 'Otro');
