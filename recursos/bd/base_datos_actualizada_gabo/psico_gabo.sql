DROP DATABASE IF EXISTS psico;
CREATE DATABASE IF NOT EXISTS psico DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

USE psico;

/*----------------------------------------------------------------
------------------------------------------------------------------
-----------------------TABLAS NIVEL 1-----------------------------
------------------------------------------------------------------
------------------------------------------------------------------*/

CREATE TABLE roles (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  estatus_rol tinyint(1) NOT NULL DEFAULT 2,
  id_rol int(3) NOT NULL PRIMARY KEY,
  rol varchar(30) NOT NULL
) ENGINE=InnoDB;

-- ROLES 
-- -- 749 : SUPERADMIN
-- -- 846 : ADMIN
-- -- 521 : PSICOLOGO
-- -- 496 : PACIENTE


INSERT INTO roles (creacion, actualizacion, eliminacion, estatus_rol, id_rol, rol) VALUES
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 496, 'Paciente'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 521, 'Psicologo'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 749, 'Superadmin'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 846, 'Administrador');



CREATE TABLE tipos_atencion (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  estatus_tipo_atencion tinyint(1) NOT NULL DEFAULT 2,
  id_tipo_atencion int(3) NOT NULL PRIMARY KEY,
  tipo_atencion varchar(30) NOT NULL
) ENGINE=InnoDB;

-- TIPO DE ATENCION
-- -- 111 : Primera vez
-- -- 122 : Subsecuente

INSERT INTO tipos_atencion (creacion, actualizacion, eliminacion, estatus_tipo_atencion, id_tipo_atencion, tipo_atencion) VALUES
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 111, 'Primera vez'),
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 122, 'Subsecuente');

CREATE TABLE tipos_referencias (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  estatus_tipo_referencia tinyint(1) NOT NULL DEFAULT 2,
  id_tipo_referencia int(3) NOT NULL PRIMARY KEY,
  tipo_referencia varchar(30) NOT NULL
) ENGINE=InnoDB;

-- TIPO DE REFERENCIA
-- -- 211 : Servicio Médico
-- -- 222 : Tutor
-- -- 233 : Director Carrera
-- -- 244 : Otro


INSERT INTO tipos_referencias (creacion, actualizacion, eliminacion, estatus_tipo_referencia, id_tipo_referencia, tipo_referencia) VALUES
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 211, 'Servicio Médico'),
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 222, 'Tutor'),
('2024-07-23 01:50:15', '2024-07-23 01:50:15', NULL, 2, 233, 'Director Carrera'),
('2024-07-23 01:50:15', '2024-07-23 01:50:15', NULL, 2, 244, 'Otro');


DROP TABLE IF EXISTS subcategorias;
CREATE TABLE subcategorias (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  estatus_subcate tinyint(1) NOT NULL DEFAULT 2,
  id_subcate int(3) NOT NULL PRIMARY KEY,
  subcategoria varchar(30) NOT NULL
) ENGINE=InnoDB;

-- SUBCATEGORIAS 
-- -- 439 : ALUMNO
-- -- 426 : EMPLEADO
-- -- 411 : INVITADO

INSERT INTO subcategorias (creacion, actualizacion, eliminacion, estatus_subcate, id_subcate, subcategoria) VALUES
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 411, 'Invitado'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 426, 'Empleado'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 439, 'Alumno');


CREATE TABLE dias (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  estatus_dia tinyint(1) NOT NULL DEFAULT 2 COMMENT '1-> Habilitado, -1-> Deshabilitado',
  id_dia int(3) NOT NULL  PRIMARY KEY,
  nombre_dia varchar(10) NOT NULL
) ENGINE=InnoDB;

-- DIAS
-- -- 001 : LUNES
-- -- 002 : MARTES
-- -- 003 : MIERCOLES
-- -- 004 : JUEVES
-- -- 005 : VIERNES
-- -- 006 : SABADO


INSERT INTO dias (creacion, actualizacion, eliminacion, estatus_dia, id_dia, nombre_dia) VALUES
('2024-07-30 02:41:28', '2024-07-30 02:41:28', NULL, 2, 1, 'Lunes'),
('2024-07-30 02:41:28', '2024-07-30 02:41:28', NULL, 2, 2, 'Martes'),
('2024-07-30 02:41:28', '2024-07-30 02:41:28', NULL, 2, 3, 'Miércoles'),
('2024-07-30 02:41:28', '2024-07-30 02:41:28', NULL, 2, 4, 'Jueves'),
('2024-07-30 02:41:28', '2024-07-30 02:41:28', NULL, 2, 5, 'Viernes'),
('2024-07-30 02:41:28', '2024-07-30 02:41:28', NULL, 2, 6, 'Sábado');

-- PROGRAMA EDUCATIVO

CREATE TABLE programa_educativo (
  creacion TIMESTAMP NULL DEFAULT NULL,
  actualizacion TIMESTAMP NULL DEFAULT NULL,
  eliminacion DATETIME DEFAULT NULL,
  estatus_programa TINYINT(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
  id_programa INT(3) NOT NULL PRIMARY KEY,
  nombre_programa VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Insertar programas educativos
INSERT INTO programa_educativo (creacion, actualizacion, eliminacion, estatus_programa, id_programa, nombre_programa) VALUES
('2024-07-30 03:00:00', '2024-07-30 03:00:00', NULL, 2, 10, 'Ingeniería en Biotecnología'),
('2024-07-30 03:00:00', '2024-07-30 03:00:00', NULL, 2, 20, 'Ingeniería Mecatrónica'),
('2024-07-30 03:00:00', '2024-07-30 03:00:00', NULL, 2, 30, 'Ingeniería Industrial'),
('2024-07-30 03:00:00', '2024-07-30 03:00:00', NULL, 2, 40, 'Ingeniería en Tecnologías de la Información'),
('2024-07-30 03:00:00', '2024-07-30 03:00:00', NULL, 2, 50, 'Ingeniería Financiera');
('2024-07-30 03:00:00', '2024-07-30 03:00:00', NULL, 2, 60, 'Ingeniería Química');
('2024-07-30 03:00:00', '2024-07-30 03:00:00', NULL, 2, 70, 'Ingeniería en Sitemas Automotrices');

-- ÁREA

CREATE TABLE area (
  creacion TIMESTAMP NULL DEFAULT NULL,
  actualizacion TIMESTAMP NULL DEFAULT NULL,
  eliminacion DATETIME DEFAULT NULL,
  estatus_area TINYINT(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
  id_area INT(3) NOT NULL PRIMARY KEY,
  nombre_area VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Insertar áreas
INSERT INTO area (creacion, actualizacion, eliminacion, estatus_area, id_area, nombre_area) VALUES
('2024-07-30 03:15:00', '2024-07-30 03:15:00', NULL, 2, 1, 'Administrativo'),
('2024-07-30 03:15:00', '2024-07-30 03:15:00', NULL, 2, 2, 'Docente');

/*----------------------------------------------------------------
------------------------------------------------------------------
-----------------------TABLAS NIVEL 2-----------------------------
------------------------------------------------------------------
----------------------------------------------------------------*/



CREATE TABLE usuarios (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  estatus_usuario tinyint(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
  id_usuario int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nombre_usuario varchar(50) NOT NULL,
  ap_paterno_usuario varchar(50) NOT NULL,
  ap_materno_usuario varchar(50) NOT NULL,
  sexo_usuario tinyint(1) NOT NULL,
  edad_usuario tinyint(2) NOT NULL,
  email_usuario varchar(70) NOT NULL,
  password_usuario varchar(64) NOT NULL,
  imagen_usuario varchar(100) DEFAULT NULL,
  reset_token varchar(100) DEFAULT NULL,
  reset_expires datetime DEFAULT NULL,
  id_rol int(3) NOT NULL,
  FOREIGN KEY (id_rol) REFERENCES `roles` (id_rol) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO usuarios (creacion, actualizacion, eliminacion, estatus_usuario, id_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario, sexo_usuario, edad_usuario, email_usuario, password_usuario, imagen_usuario, reset_token, reset_expires, id_rol) VALUES
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 1, 'Superadmin', 'Paterno', 'Materno', 2, 24, 'superadmin@psico.com', 'e34f92a20532a873cb3184398070b4b82a8fa29cf48572c203dc5f0fa6158231', NULL, NULL, NULL, 749),
('2024-06-25 07:36:10', '2024-07-25 04:45:27', NULL, 2, 2, 'Juan Briyan', 'Rios', 'Avila', 2, 23, 'admin@psico.com', '43595c4e96b33bb446c3756b992c1004ed6aa51c2b9ab99ea9b91ae44f0f967a', 'b2bbc7a8b728e201a00fc02246e2aaf08c8cb8adfb2dbefc566fb6681147b9ba.jpg', NULL, NULL, 521),
('2024-07-18 06:07:13', '2024-07-23 00:33:29', NULL, 2, 3, 'Gabriel', 'Cervantes', 'Hernández', 2, 18, 'gabrielch1805@gmail.com', '711aad8351b4679c58994c7dd004378804d88a036c0f6e28b2ae9888163a84e9', NULL, NULL, NULL, 496),
('2024-07-22 03:24:52', '2024-07-22 03:24:52', NULL, 2, 4, 'Uriel', 'Cervantes', 'Hernández', 2, 0, 'gabux81@gmail.com', '711aad8351b4679c58994c7dd004378804d88a036c0f6e28b2ae9888163a84e9', '5533c7173c306c70a6980c1808c091ea817f5314a7c2fc975c4db89d397814ec.png', NULL, NULL, 846);

CREATE TABLE psicologos (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  id_psicologo int(11) NOT NULL PRIMARY KEY,
  numero_trabajador_psicologo int(3) DEFAULT NULL,
  FOREIGN KEY (id_psicologo) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO psicologos (creacion, actualizacion, eliminacion, estatus_psicologo, id_psicologo, numero_trabajador_psicologo) VALUES
('2024-07-25 06:37:30', '2024-07-25 10:08:47', NULL, 2, 2, 230);

CREATE TABLE paciente (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  id_paciente int(11) NOT NULL PRIMARY KEY,
  observaciones text DEFAULT NULL,
  numero_expediente int(11) DEFAULT NULL,
  id_tipo_referencia int(3) DEFAULT NULL,
  id_tipo_atencion int(3) NOT NULL DEFAULT 111 COMMENT '111 -> Primera vez, -122 -> Subsecuente',
  id_subcate int(3) NOT NULL,
  FOREIGN KEY (id_paciente) REFERENCES usuarios (id_usuario) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_tipo_referencia) REFERENCES tipos_referencias (id_tipo_referencia) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_tipo_atencion) REFERENCES tipos_atencion (id_tipo_atencion) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_subcate) REFERENCES subcategorias (id_subcate) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO paciente (creacion, actualizacion, eliminacion, estatus_paciente, id_paciente, referencia, tipo_atencion, observaciones, numero_expediente, id_subcate) VALUES
('2024-07-18 06:07:13', '2024-07-18 06:07:13', NULL, 2, 3, NULL, NULL, NULL, NULL, 439);



/*----------------------------------------------------------------
------------------------------------------------------------------
-----------------------TABLAS NIVEL 3-----------------------------
------------------------------------------------------------------
----------------------------------------------------------------*/


CREATE TABLE horarios_psicologos (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  estatus_horario tinyint(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
  id_horario int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  id_psicologo int(11) NOT NULL,
  id_dia int(3) NOT NULL,
  turno_entrada time NOT NULL,
  turno_salida time NOT NULL,
  FOREIGN KEY (id_dia) REFERENCES dias (id_dia) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_psicologo) REFERENCES psicologos (id_psicologo) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO horarios_psicologos (creacion, actualizacion, eliminacion, estatus_horario, id_horario, id_psicologo, id_dia, turno_entrada, turno_salida) VALUES
('2024-07-30 02:43:27', '2024-07-30 02:43:27', NULL, 2, 1, 2, 1, '07:00:00', '19:00:00');


CREATE TABLE alumno (
  creacion TIMESTAMP NULL DEFAULT NULL,
  actualizacion TIMESTAMP NULL DEFAULT NULL,
  eliminacion DATETIME DEFAULT NULL,
  id_paciente INT(11) NOT NULL PRIMARY KEY,
  matricula INT(10) NOT NULL,
  id_programa INT(3) NOT NULL,
  id_subcate INT(3) NOT NULL,
  FOREIGN KEY (id_paciente) REFERENCES paciente (id_paciente) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_programa) REFERENCES programa_educativo (id_programa) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_subcate) REFERENCES subcategorias (id_subcate) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE administrativo (
  creacion TIMESTAMP NULL DEFAULT NULL,
  actualizacion TIMESTAMP NULL DEFAULT NULL,
  eliminacion DATETIME DEFAULT NULL,
  id_paciente INT(11) NOT NULL PRIMARY KEY,
  numero_trabajador_administrativo INT(3) NOT NULL,
  id_area INT(3) NOT NULL,
  id_subcate INT(3) NOT NULL,
  FOREIGN KEY (id_paciente) REFERENCES paciente (id_paciente) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_area) REFERENCES area (id_area) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_subcate) REFERENCES subcategorias (id_subcate) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE invitado (
  creacion timestamp NULL DEFAULT NULL,
  actualizacion timestamp NULL DEFAULT NULL,
  eliminacion datetime DEFAULT NULL,
  id_paciente int(11) NOT NULL PRIMARY KEY,
  identificador varchar(50) NOT NULL,
  id_subcate int(3) NOT NULL,
  FOREIGN KEY (id_paciente) REFERENCES paciente (id_paciente) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (id_subcate) REFERENCES subcategorias (id_subcate) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;
