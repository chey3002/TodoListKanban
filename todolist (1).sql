-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-10-2023 a las 03:38:10
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `todolist`
--
CREATE DATABASE IF NOT EXISTS `todolist` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `todolist`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_tarea`
--

CREATE TABLE IF NOT EXISTS `estado_tarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estado_tarea`
--

INSERT INTO `estado_tarea` (`id`, `nombre`, `descripcion`) VALUES
(1, 'ToDo', 'Tarea por hacer'),
(2, 'En progreso', 'Tarea en desarrollo'),
(3, 'Revisión', 'Tarea en revisión'),
(4, 'Hecho', 'Tarea completada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablero`
--

CREATE TABLE IF NOT EXISTS `tablero` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tablero`
--

INSERT INTO `tablero` (`id`, `nombre`, `user_id`) VALUES
(1, 'Tablero 1', 1),
(2, 'Tablero 2', 4),
(4, 'kanban', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE IF NOT EXISTS `tarea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado_id` int(11) DEFAULT NULL,
  `tablero_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `estado_id` (`estado_id`),
  KEY `tablero_id` (`tablero_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tarea`
--

INSERT INTO `tarea` (`id`, `nombre`, `descripcion`, `estado_id`, `tablero_id`) VALUES
(2, 'Crear Crud personas', 'Realizar la tarea de crear crud de personas', 1, 1),
(3, 'Crear Crud Tableros', 'asdasd asdasdasd asd', 2, 1),
(5, 'Crud Tareas1', 'hacer un crud que cree tareas', 4, 1),
(6, 'Crud Tareas2', 'hacer un crud que cree tareas', 3, 1),
(7, 'Crud Tareas3', 'este es un texto de prueba', 1, 1),
(8, 'tarea 1', 'esta es una tarea de todo', 1, 2),
(9, 'tarea 2', 'esta es otra tarea de todo', 1, 2),
(10, 'esta es una tarea en progreso', 'estoy en progreso', 2, 2),
(11, 'tarea finalizada 1', 'se termino hace unos días', 4, 2),
(12, 'tarea finalizada 2', 'terminado por Pepito', 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `nombre`, `descripcion`) VALUES
(1, 'usuario', 'Usuario manager'),
(2, 'lector', 'Lector');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tipo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipo_id` (`tipo_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `tipo_id`) VALUES
(1, 'usuario1', '$2y$10$agOv1l8pUlpJEf2TDMBiQO1jMhI.xxTepAmgB9wP.r4V7U2wYsYV6', 1),
(2, 'lector1', '$2y$10$iSej0fhpK.imdHyrrVVPAeMp.oFNmAVGPWWebAp4O2gu7dlbB0W36', 2),
(4, 'Carlos', '$2y$10$aNqOY4I5wla0KnIF.oA3nuZ64MoI0nz1kSNKge69KMMNkGBJFv/oK', 1),
(5, 'Juan', '$2y$10$cvgT8/UeW9r7G28/di83Du.RVno/0.F06iYZ.cboikecb1QMv9I3a', 2),
(6, 'Pepito', '$2y$10$1q5E.cpBpf9oO0.QmDxxzePDXc4iSeScbJjRaKzgavhj1frP1jayq', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tablero`
--
ALTER TABLE `tablero`
  ADD CONSTRAINT `tablero_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`estado_id`) REFERENCES `estado_tarea` (`id`),
  ADD CONSTRAINT `tarea_ibfk_2` FOREIGN KEY (`tablero_id`) REFERENCES `tablero` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `tipo_usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
