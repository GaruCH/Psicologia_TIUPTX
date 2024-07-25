DROP DATABASE IF EXISTS uptx;
CREATE DATABASE IF NOT EXISTS uptx DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE uptx;
--GRANT ALL PRIVILEGES ON perduptx.* TO 'useruptx'@'localhost' IDENTIFIED BY 'passworduptx123';

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
-- -- 521 : OPERADOR
-- -- 496 : JURÍDICO
-- -- 237 : SECRETARÍA ACADÉMICA
-- -- 194 : COORDINADOR

INSERT INTO roles (creacion, actualizacion, estatus_rol, id_rol, rol) VALUES
    (current_timestamp(), current_timestamp(), '2', 749, 'Superadmin'),
    (current_timestamp(), current_timestamp(), '2', 846, 'Administrador');

CREATE TABLE areas (
    creacion TIMESTAMP NULL DEFAULT NULL,
    actualizacion TIMESTAMP NULL DEFAULT NULL,
    eliminacion DATETIME DEFAULT NULL,
    estatus_area TINYINT(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
    id_area INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre_area VARCHAR(50) NOT NULL,
    acronimo_area VARCHAR(5) NULL DEFAULT NULL COMMENT 'ITI -> area en Tecnologías de la Información',
    extension_telefono_area  VARCHAR(5) NULL DEFAULT NULL,
    logo_area VARCHAR(100) NULL DEFAULT NULL,
    descripcion_area TEXT NULL DEFAULT NULL
)ENGINE=InnoDB;

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
    (current_timestamp(), current_timestamp(), '2', 'Superadmin', 'Paterno', 'Materno', 2, 'superadmin@perduptx.com', SHA2('superadmin123',0), NULL, 749),
    (current_timestamp(), current_timestamp(), '2', 'Admin', 'Paterno', 'Materno', 2, 'admin@perduptx.com', 'admin123', NULL, 846);

CREATE TABLE areas_usuarios (
    creacion TIMESTAMP NULL DEFAULT NULL,
    actualizacion TIMESTAMP NULL DEFAULT NULL,
    eliminacion DATETIME DEFAULT NULL,
    estatus_area_usuario TINYINT(1) NOT NULL DEFAULT 2 COMMENT '2 -> Área Actual, 1 -> Área de baja, -1 -> Usuario Deshabilitado ',
    id_area_usuario INT(3) NOT NULL PRIMARY KEY,
    id_area INT(3) NOT NULL,
    id_usuario INT(3) NOT NULL,
    descripcion_area_usuario TEXT NULL DEFAULT 'Sin decripción ...',
    FOREIGN KEY(id_area) REFERENCES areas (id_area) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(id_usuario) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
)ENGINE=InnoDB;
