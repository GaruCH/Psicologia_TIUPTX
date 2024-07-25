-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-07-2024 a las 11:10:02
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `psico`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `creacion` timestamp NULL DEFAULT NULL,
  `actualizacion` timestamp NULL DEFAULT NULL,
  `eliminacion` datetime DEFAULT NULL,
  `estatus_paciente` tinyint(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
  `id_paciente` int(11) NOT NULL,
  `referencia` varchar(100) DEFAULT NULL,
  `tipo_atencion` varchar(100) DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `numero_expediente` int(11) DEFAULT NULL,
  `id_subcate` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`creacion`, `actualizacion`, `eliminacion`, `estatus_paciente`, `id_paciente`, `referencia`, `tipo_atencion`, `observaciones`, `numero_expediente`, `id_subcate`) VALUES
('2024-07-18 06:07:13', '2024-07-18 06:07:13', NULL, 2, 28, NULL, NULL, NULL, NULL, 439);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psicologos`
--

CREATE TABLE `psicologos` (
  `creacion` timestamp NULL DEFAULT NULL,
  `actualizacion` timestamp NULL DEFAULT NULL,
  `eliminacion` datetime DEFAULT NULL,
  `estatus_psicologo` tinyint(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
  `id_psicologo` int(11) NOT NULL,
  `numero_trabajador_psicologo` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `psicologos`
--

INSERT INTO `psicologos` (`creacion`, `actualizacion`, `eliminacion`, `estatus_psicologo`, `id_psicologo`, `numero_trabajador_psicologo`) VALUES
(NULL, '2024-07-24 12:10:48', NULL, 2, 2, 123),
('2024-07-22 09:23:12', '2024-07-24 12:34:50', NULL, 2, 33, 1),
('2024-07-23 00:07:33', '2024-07-24 11:44:09', NULL, 2, 34, 444),
('2024-07-25 06:37:30', '2024-07-25 10:08:47', NULL, 2, 35, 230);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `creacion` timestamp NULL DEFAULT NULL,
  `actualizacion` timestamp NULL DEFAULT NULL,
  `eliminacion` datetime DEFAULT NULL,
  `estatus_rol` tinyint(1) NOT NULL DEFAULT 2,
  `id_rol` int(3) NOT NULL,
  `rol` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`creacion`, `actualizacion`, `eliminacion`, `estatus_rol`, `id_rol`, `rol`) VALUES
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 496, 'Paciente'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 521, 'Psicologo'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 749, 'Superadmin'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 846, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategorias`
--

CREATE TABLE `subcategorias` (
  `creacion` timestamp NULL DEFAULT NULL,
  `actualizacion` timestamp NULL DEFAULT NULL,
  `eliminacion` datetime DEFAULT NULL,
  `estatus_subcate` tinyint(1) NOT NULL DEFAULT 2,
  `id_subcate` int(3) NOT NULL,
  `subcategoria` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subcategorias`
--

INSERT INTO `subcategorias` (`creacion`, `actualizacion`, `eliminacion`, `estatus_subcate`, `id_subcate`, `subcategoria`) VALUES
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 411, 'Invitado'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 426, 'Empleado'),
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 439, 'Alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_atencion`
--

CREATE TABLE `tipos_atencion` (
  `creacion` timestamp NULL DEFAULT NULL,
  `actualizacion` timestamp NULL DEFAULT NULL,
  `eliminacion` datetime DEFAULT NULL,
  `estatus_tipo_atencion` tinyint(1) NOT NULL DEFAULT 2,
  `id_tipo_atencion` int(3) NOT NULL,
  `tipo_atencion` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_atencion`
--

INSERT INTO `tipos_atencion` (`creacion`, `actualizacion`, `eliminacion`, `estatus_tipo_atencion`, `id_tipo_atencion`, `tipo_atencion`) VALUES
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 111, 'Primera vez'),
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 122, 'Subsecuente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_referencias`
--

CREATE TABLE `tipos_referencias` (
  `creacion` timestamp NULL DEFAULT NULL,
  `actualizacion` timestamp NULL DEFAULT NULL,
  `eliminacion` datetime DEFAULT NULL,
  `estatus_tipo_referencia` tinyint(1) NOT NULL DEFAULT 2,
  `id_tipo_referencia` int(3) NOT NULL,
  `tipo_referencia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipos_referencias`
--

INSERT INTO `tipos_referencias` (`creacion`, `actualizacion`, `eliminacion`, `estatus_tipo_referencia`, `id_tipo_referencia`, `tipo_referencia`) VALUES
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 211, 'Servicio Médico'),
('2024-07-23 01:48:36', '2024-07-23 01:48:36', NULL, 2, 222, 'Tutor'),
('2024-07-23 01:50:15', '2024-07-23 01:50:15', NULL, 2, 233, 'Director Carrera'),
('2024-07-23 01:50:15', '2024-07-23 01:50:15', NULL, 2, 244, 'Otro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `creacion` timestamp NULL DEFAULT NULL,
  `actualizacion` timestamp NULL DEFAULT NULL,
  `eliminacion` datetime DEFAULT NULL,
  `estatus_usuario` tinyint(1) NOT NULL DEFAULT 2 COMMENT '2-> Habilitado, -1-> Deshabilitado',
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `ap_paterno_usuario` varchar(50) NOT NULL,
  `ap_materno_usuario` varchar(50) NOT NULL,
  `sexo_usuario` tinyint(1) NOT NULL,
  `edad_usuario` tinyint(2) NOT NULL,
  `email_usuario` varchar(70) NOT NULL,
  `password_usuario` varchar(64) NOT NULL,
  `imagen_usuario` varchar(100) DEFAULT NULL,
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `id_rol` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`creacion`, `actualizacion`, `eliminacion`, `estatus_usuario`, `id_usuario`, `nombre_usuario`, `ap_paterno_usuario`, `ap_materno_usuario`, `sexo_usuario`, `edad_usuario`, `email_usuario`, `password_usuario`, `imagen_usuario`, `reset_token`, `reset_expires`, `id_rol`) VALUES
('2024-06-25 07:36:10', '2024-06-25 07:36:10', NULL, 2, 1, 'Superadmin', 'Paterno', 'Materno', 2, 24, 'superadmin@psico.com', 'e34f92a20532a873cb3184398070b4b82a8fa29cf48572c203dc5f0fa6158231', NULL, NULL, NULL, 749),
('2024-06-25 07:36:10', '2024-07-25 04:45:27', NULL, 2, 2, 'Juan Briyan', 'Rios', 'Avila', 2, 23, 'admin@psico.com', '43595c4e96b33bb446c3756b992c1004ed6aa51c2b9ab99ea9b91ae44f0f967a', 'b2bbc7a8b728e201a00fc02246e2aaf08c8cb8adfb2dbefc566fb6681147b9ba.jpg', NULL, NULL, 521),
('2024-07-18 06:07:13', '2024-07-23 00:33:29', NULL, 2, 28, 'Gabriel', 'Cervantes', 'Hernández', 2, 18, 'gabrielch1805@gmail.com', '711aad8351b4679c58994c7dd004378804d88a036c0f6e28b2ae9888163a84e9', NULL, NULL, NULL, 496),
('2024-07-22 03:24:52', '2024-07-22 03:24:52', NULL, 2, 29, 'Uriel', 'Cervantes', 'Hernández', 2, 0, 'uriel1003@gmail.com', '711aad8351b4679c58994c7dd004378804d88a036c0f6e28b2ae9888163a84e9', '5533c7173c306c70a6980c1808c091ea817f5314a7c2fc975c4db89d397814ec.png', NULL, NULL, 846),
('2024-07-22 09:23:12', '2024-07-24 12:34:50', NULL, 2, 33, 'Diana', 'Martinez', 'Lopez', 1, 22, 'DianaML@gmail.com', '711aad8351b4679c58994c7dd004378804d88a036c0f6e28b2ae9888163a84e9', 'aca5572566a3ba0f4b2f615a55f35098fe4fdee6f12ea460f6987bebda2898bb.jpg', NULL, NULL, 521),
('2024-07-23 00:07:33', '2024-07-25 04:42:06', NULL, 2, 34, 'Lupita', 'Mora', 'Flores', 1, 22, 'lupita84@gmail.com', 'bba40d5999b8651287681dcff6e52a84317ca43d4481b7ac02fb211f49cc4c31', '620ed7e1db075150806d05f42e9d42f72c514c6c8eb00c880456a7ef22ecea3b.jpeg', NULL, NULL, 521),
('2024-07-25 06:37:30', '2024-07-25 10:08:47', NULL, 2, 35, 'Mauricio', 'Arenas', 'Nombre', 2, 25, 'gabrieltec35@gmail.com', '7b8e7d5856492c32f23d08ddeb89d92fcd14d916f0569e8744f9f2221ed87b81', NULL, NULL, NULL, 521);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`),
  ADD KEY `id_subcate` (`id_subcate`);

--
-- Indices de la tabla `psicologos`
--
ALTER TABLE `psicologos`
  ADD PRIMARY KEY (`id_psicologo`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `subcategorias`
--
ALTER TABLE `subcategorias`
  ADD PRIMARY KEY (`id_subcate`);

--
-- Indices de la tabla `tipos_atencion`
--
ALTER TABLE `tipos_atencion`
  ADD PRIMARY KEY (`id_tipo_atencion`);

--
-- Indices de la tabla `tipos_referencias`
--
ALTER TABLE `tipos_referencias`
  ADD PRIMARY KEY (`id_tipo_referencia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD CONSTRAINT `paciente_ibfk_1` FOREIGN KEY (`id_paciente`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `paciente_ibfk_2` FOREIGN KEY (`id_subcate`) REFERENCES `subcategorias` (`id_subcate`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `psicologos`
--
ALTER TABLE `psicologos`
  ADD CONSTRAINT `psicologos_ibfk_1` FOREIGN KEY (`id_psicologo`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
