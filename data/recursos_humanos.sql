-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2024 a las 11:21:47
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `recursos_humanos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id_actividad` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL,
  `actividad` varchar(250) NOT NULL,
  `prioridad` int(2) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignacionbeneficios`
--

CREATE TABLE `asignacionbeneficios` (
  `id_beneficio` int(11) NOT NULL,
  `idPersonal` int(11) DEFAULT NULL,
  `idNino` int(11) DEFAULT NULL,
  `idbeneficio` int(11) DEFAULT NULL,
  `horasExtra` int(11) DEFAULT NULL,
  `DiasFeriados` int(11) DEFAULT NULL,
  `fecha` int(11) NOT NULL,
  `hora` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencionmedica`
--

CREATE TABLE `atencionmedica` (
  `id_atencion` int(11) NOT NULL,
  `idPersonal` int(11) DEFAULT NULL,
  `idNino` int(11) DEFAULT NULL,
  `idMedico` int(11) DEFAULT NULL,
  `idPsicologo` int(11) DEFAULT NULL,
  `atencion` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ausenciajustificada`
--

CREATE TABLE `ausenciajustificada` (
  `id_ausencia` int(11) DEFAULT NULL,
  `idPersonal` int(11) NOT NULL,
  `idPermiso` int(11) NOT NULL,
  `fechaInicio` varchar(10) NOT NULL,
  `fechaFenal` varchar(10) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `beneficios`
--

CREATE TABLE `beneficios` (
  `id_beneficio` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `monto` float DEFAULT NULL,
  `lista` varchar(150) DEFAULT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacorasistema`
--

CREATE TABLE `bitacorasistema` (
  `id_bitacora` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `accion` varchar(250) NOT NULL,
  `cambio` varchar(250) NOT NULL,
  `direccionIP` varchar(15) NOT NULL,
  `´fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id_cargo` int(11) NOT NULL,
  `cargo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id_cargo`, `cargo`) VALUES
(1, 'Auxiliar I'),
(2, 'Auxiliar II'),
(3, 'Auxiliar III');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `id_ciudades` int(11) DEFAULT NULL,
  `idEstados` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosempleados`
--

CREATE TABLE `datosempleados` (
  `id_empleados` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL,
  `idEstatus` int(11) NOT NULL,
  `idCargo` int(11) NOT NULL,
  `idDependencia` int(11) NOT NULL,
  `idDepartamento` int(11) NOT NULL,
  `idGrp` int(11) DEFAULT NULL,
  `telefono` varchar(12) NOT NULL,
  `telOficina` varchar(12) DEFAULT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datosempleados`
--

INSERT INTO `datosempleados` (`id_empleados`, `idPersonal`, `idEstatus`, `idCargo`, `idDependencia`, `idDepartamento`, `idGrp`, `telefono`, `telOficina`, `fecha`, `hora`) VALUES
(1, 1, 1, 1, 1, 1, 1, '04128977094', '0243', '2024-05-07', '29:34:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosninos`
--

CREATE TABLE `datosninos` (
  `id_datosnino` int(11) NOT NULL,
  `idNino` int(11) NOT NULL,
  `certificadoEstudio` varchar(250) DEFAULT NULL,
  `certificadoNotas` varchar(250) DEFAULT NULL,
  `adtaNacimiento` varchar(250) DEFAULT NULL,
  `partidaNacimiento` varchar(250) DEFAULT NULL,
  `certificadoMedico` varchar(250) DEFAULT NULL,
  `certificadoDisca` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datospersonales`
--

CREATE TABLE `datospersonales` (
  `id_personal` int(11) NOT NULL,
  `primerNombre` text NOT NULL,
  `segundoNombre` text NOT NULL,
  `primerApellido` text NOT NULL,
  `segundoApellido` text NOT NULL,
  `cedula` int(10) NOT NULL,
  `estadoCivil` varchar(30) DEFAULT NULL,
  `firma` varchar(150) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `diaNacimiento` varchar(2) NOT NULL,
  `mesNacimiento` varchar(2) NOT NULL,
  `anoNacimiento` int(4) NOT NULL,
  `correo` varchar(200) DEFAULT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datospersonales`
--

INSERT INTO `datospersonales` (`id_personal`, `primerNombre`, `segundoNombre`, `primerApellido`, `segundoApellido`, `cedula`, `estadoCivil`, `firma`, `foto`, `diaNacimiento`, `mesNacimiento`, `anoNacimiento`, `correo`, `fecha`, `hora`) VALUES
(1, 'Jeison', 'Andres', 'Balduz', 'Gonzalez', 30012937, '1', NULL, NULL, '19', '8', 2024, 'jeisonbalduz12@gmail.com', '2024-05-07', '29:34:23'),
(21, 'hjjh', 'khhbjhj', 'khkhkj', 'kjjlkjlljk', 81960933, 'soltero', NULL, NULL, '01', '01', 2024, '@gmail.com', '2024-11-20', '11:17:41'),
(22, 'jljlkjkl', 'khhkkh', 'ljlkljljkjlk', 'lkjljkkl', 30322663, 'soltero', NULL, NULL, '01', '01', 2024, '@gmail.com', '2024-11-20', '11:19:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(100) NOT NULL,
  `codigoDepa` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `departamento`, `codigoDepa`) VALUES
(1, 'Informática', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `id_dependencia` int(11) NOT NULL,
  `dependencia` text NOT NULL,
  `idEstado` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`id_dependencia`, `dependencia`, `idEstado`, `codigo`) VALUES
(1, 'Coordinación Programa Turismo', 4, '447,304,021'),
(2, 'Coordinación Programa Penitenciario', 4, '447,306,021'),
(3, 'Centro Formación Comercial La Victoria', 4, '18'),
(4, 'Centro Formación Comercial Maracay', 4, '19'),
(5, 'Centro Formación Industrial El Limón', 4, '20'),
(6, 'Centro Polivalente Villa De Cura', 4, '21'),
(7, 'Centro De Formación Textil', 4, '22'),
(8, 'Centro Tecnologico Industrial La Victoria', 4, '23'),
(9, 'Centro Tecnológico Industrial Maracay', 4, '24'),
(10, 'Centro De Formación Construcción', 4, '25'),
(11, 'Centro Nacional De Mecánica Automotriz', 4, '26'),
(12, 'Centro Polivalente Bermudez', 4, '27'),
(13, 'Centro Polivalente Cagua', 4, '28'),
(14, 'Centro Polivalente Ocumare De La Costa', 4, '29'),
(15, 'C, F, S, A, La Providencia', 4, '30'),
(16, 'C, F, S, A, Colonia Tovar', 4, '31'),
(17, 'C, F, S, A, La Morita', 4, 'SIN-CDG'),
(18, 'C,F,S Construcción', 4, 'SIN-CDG'),
(19, 'C, F, S, Metal Minero La Victoria', 4, 'SIN-CDG'),
(20, 'C, F, S, Cema', 4, 'SIN-CDG'),
(21, 'C, F, S, Ocumare', 4, 'SIN-CDG'),
(22, 'C, F, S, Maracay', 4, 'SIN-CDG'),
(23, 'C, F, S, Textil', 4, 'SIN-CDG'),
(24, 'C, F, S, Bermudez', 4, 'SIN-CDG'),
(25, 'C, F, S, Cagua', 4, 'SIN-CDG'),
(26, 'C, F, S, Comercial La Victoria', 4, 'SIN-CDG'),
(27, 'C, F, S, El Limón', 4, 'SIN-CDG'),
(28, 'C, F, S, Metalminero Maracay', 4, 'SIN-CDG'),
(29, 'C, F, S, Programa Turismo', 4, 'SIN-CDG'),
(30, 'C, F, S, Villa Cura', 4, 'SIN-CDG'),
(31, 'CCFPI', 4, 'SIN-CDG'),
(32, 'Cema ', 4, 'SIN-CDG'),
(33, 'División De Administración', 4, '4'),
(34, 'División De Sercio Y Mantenimineto ', 4, '5'),
(35, 'División De Informatica', 4, '6'),
(36, 'División De Formacion Profesional', 4, '7'),
(37, 'División De Seguridad', 4, '8'),
(38, 'División De Talento Humano ', 4, '3'),
(39, 'Sede La Romana', 4, 'SIN-CDG'),
(40, 'Sede Regional Aragua ', 4, 'SIN-CDG'),
(41, 'Tributos Aragua', 4, 'SIN-CDG'),
(42, 'Unidad De Planificación', 4, '2'),
(43, 'Unidad De Tecnología Educativa', 4, '9'),
(44, 'Unidad De Adiestramiento De Empresa', 4, '13'),
(45, 'Unidad De Formación Delegada', 4, '14'),
(46, 'Unidad Programa Navional Aprendisaje', 4, '15'),
(47, 'Unidades Móviles', 4, '16'),
(48, 'Coordinación Programa Ferroviario', 4, '33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentacion`
--

CREATE TABLE `documentacion` (
  `id_doc` int(11) DEFAULT NULL,
  `idPersonal` int(11) NOT NULL,
  `tipoDoc` varchar(50) NOT NULL,
  `doc` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id_egreso` int(11) DEFAULT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL,
  `motivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id_estados` int(11) NOT NULL,
  `estado` text NOT NULL,
  `codigoISO` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id_estados`, `estado`, `codigoISO`) VALUES
(1, 'Amazonas', 'VE-X'),
(2, 'Anzoátegui', 'VE-B'),
(3, 'Apure', 'VE-C'),
(4, 'Aragua', 'VE-D'),
(5, 'Barinas', 'VE-E'),
(6, 'Bolívar', 'VE-F'),
(7, 'Carabobo', 'VE-G'),
(8, 'Cojedes', 'VE-H'),
(9, 'Delta Amacuro', 'VE-Y'),
(10, 'Falcón', 'VE-I'),
(11, 'Guárico', 'VE-J'),
(12, 'Lara', 'VE-K'),
(13, 'Mérida', 'VE-L'),
(14, 'Miranda', 'VE-M'),
(15, 'Monagas', 'VE-N'),
(16, 'Nueva Esparta', 'VE-O'),
(17, 'Portuguesa', 'VE-P'),
(18, 'Sucre', 'VE-R'),
(19, 'Táchira', 'VE-S'),
(20, 'Trujillo', 'VE-T'),
(21, 'La Guaira', 'VE-W'),
(22, 'Yaracuy', 'VE-U'),
(23, 'Zulia', 'VE-V'),
(24, 'Distrito Capital', 'VE-A'),
(25, 'Dependencias Federales', 'VE-Z');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus`
--

CREATE TABLE `estatus` (
  `id_estatus` int(11) NOT NULL,
  `estatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estatus`
--

INSERT INTO `estatus` (`id_estatus`, `estatus`) VALUES
(1, 'Contradado'),
(2, 'Cooperativa'),
(3, 'Coral'),
(4, 'Empleado'),
(5, 'Estudiante'),
(6, 'Jubilado'),
(7, 'Maestro'),
(8, 'Obrero'),
(9, 'Pasante'),
(10, 'Tributo'),
(11, 'Vigilancia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) DEFAULT NULL,
  `idPersonal` int(11) NOT NULL,
  `fiesta` varchar(250) NOT NULL,
  `motivo` varchar(250) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gradoprofesional`
--

CREATE TABLE `gradoprofesional` (
  `id_grado` int(11) DEFAULT NULL,
  `grado` varchar(50) NOT NULL,
  `pago` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialmedico`
--

CREATE TABLE `historialmedico` (
  `id_histomedico` int(11) NOT NULL,
  `idatencion` int(11) NOT NULL,
  `idMedicamentos` int(11) NOT NULL,
  `motivo` varchar(250) NOT NULL,
  `insidencia` varchar(150) NOT NULL,
  `diagnostico` varchar(250) NOT NULL,
  `antfermedades` varchar(150) NOT NULL,
  `fercronicas` varchar(150) NOT NULL,
  `medicamentosURG` varchar(150) NOT NULL,
  `cirugia` varchar(150) NOT NULL,
  `hospitalizacionP` varchar(150) NOT NULL,
  `alergias` varchar(150) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historialpsicologico`
--

CREATE TABLE `historialpsicologico` (
  `id_historialP` int(11) NOT NULL,
  `idAtencion` int(11) NOT NULL,
  `idHistorial` int(11) NOT NULL,
  `motivo` text NOT NULL,
  `gravedad` text NOT NULL,
  `enfermedades` varchar(100) NOT NULL,
  `medicamentosURG` varchar(100) NOT NULL,
  `diagnostico` varchar(250) NOT NULL,
  `accidentes` varchar(100) NOT NULL,
  `historialFamiliar` varchar(250) NOT NULL,
  `exmanenMental` varchar(150) NOT NULL,
  `genitograma` varchar(150) NOT NULL,
  `observaciones` varchar(250) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id_ingresos` int(11) DEFAULT NULL,
  `primerNombre` text NOT NULL,
  `segundoNombre` text NOT NULL,
  `primerApellido` text NOT NULL,
  `segundoApellido` text NOT NULL,
  `documentos` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicacmentos`
--

CREATE TABLE `medicacmentos` (
  `id_medicamentos` int(11) NOT NULL,
  `codigoBarra` varchar(13) NOT NULL,
  `nombre` text NOT NULL,
  `marca` varchar(100) NOT NULL,
  `laboratorio` varchar(100) NOT NULL,
  `presentacion` varchar(50) NOT NULL,
  `concentracion` varchar(50) NOT NULL,
  `disponibilidad` int(2) NOT NULL,
  `cantidad` int(6) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `memo`
--

CREATE TABLE `memo` (
  `id_motivo` int(11) DEFAULT NULL,
  `idUsuario` int(11) NOT NULL,
  `tipoMotivo` varchar(100) NOT NULL,
  `motivo` varchar(150) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municiopio`
--

CREATE TABLE `municiopio` (
  `id_municipio` int(11) DEFAULT NULL,
  `idEstado` int(11) NOT NULL,
  `municipio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ninos`
--

CREATE TABLE `ninos` (
  `id_ninos` int(11) DEFAULT NULL,
  `idPersonal` int(11) NOT NULL,
  `primerNombre` text NOT NULL,
  `segundoNombre` text NOT NULL,
  `primerApellido` text NOT NULL,
  `segundoApellido` text NOT NULL,
  `cedula` text NOT NULL,
  `edad` int(2) NOT NULL,
  `fechaNacimiento` varchar(10) NOT NULL,
  `tallaFranela` int(2) NOT NULL,
  `tallaPantalon` int(2) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parroquia`
--

CREATE TABLE `parroquia` (
  `id_parroquia` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `parroquia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `id_permisos` int(11) NOT NULL,
  `permiso` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_preguntas` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `pregunta1` varchar(100) NOT NULL,
  `pregunta2` varchar(100) NOT NULL,
  `pregunta3` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prescripcion`
--

CREATE TABLE `prescripcion` (
  `id_pre` int(11) NOT NULL,
  `idAtencion` int(11) NOT NULL,
  `idMedicamentos` int(11) NOT NULL,
  `dosis` varchar(50) NOT NULL,
  `frecuencia` varchar(50) NOT NULL,
  `duracion` varchar(50) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `idPreguntas` int(11) NOT NULL,
  `respuesta1` varchar(100) NOT NULL,
  `respuesta2` varchar(100) NOT NULL,
  `respuesta3` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id_solic` int(11) DEFAULT NULL,
  `idTiposolic` int(11) NOT NULL,
  `solicitud` int(11) NOT NULL,
  `fechaSolic` varchar(15) NOT NULL,
  `horaSolic` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sueldo`
--

CREATE TABLE `sueldo` (
  `id_sueldo` int(11) DEFAULT NULL,
  `idPersonal` int(11) NOT NULL,
  `idGrado` int(11) NOT NULL,
  `idBeneficio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiposolicitud`
--

CREATE TABLE `tiposolicitud` (
  `id_tiposolic` int(11) DEFAULT NULL,
  `solicitus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `translados`
--

CREATE TABLE `translados` (
  `id_translados` int(11) DEFAULT NULL,
  `idPersonal` int(11) NOT NULL,
  `idDependencia` int(11) NOT NULL,
  `idEstatus` int(11) NOT NULL,
  `idCargo` int(11) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicacion`
--

CREATE TABLE `ubicacion` (
  `id_perUbicacion` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `idCiudad` int(11) NOT NULL,
  `idMunicipio` int(11) NOT NULL,
  `idParroquia` int(11) NOT NULL,
  `calle` text NOT NULL,
  `vivienda` varchar(50) NOT NULL,
  `numVivienda` varchar(50) NOT NULL,
  `pisoVivienda` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `idEmpleado` int(11) DEFAULT NULL,
  `idRol` int(11) DEFAULT NULL,
  `nameUser` varchar(100) NOT NULL,
  `userPassword` varchar(150) NOT NULL,
  `permiso` int(3) DEFAULT NULL,
  `prioridad` int(2) DEFAULT NULL,
  `pin` int(5) DEFAULT NULL,
  `activo` int(1) DEFAULT NULL,
  `fotoPérfil` varchar(150) DEFAULT NULL,
  `fecha` varchar(10) DEFAULT NULL,
  `hora` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `idEmpleado`, `idRol`, `nameUser`, `userPassword`, `permiso`, `prioridad`, `pin`, `activo`, `fotoPérfil`, `fecha`, `hora`) VALUES
(1, 1, NULL, 'Jeison12345', 'ff2c1c5042200d8a7e6802fe3447281a6979e5b49a9c3ca3e9f24c6303486cf493ad4ffb6adac23930e60b17d5a13d19', NULL, NULL, NULL, 1, NULL, NULL, NULL),
(2, NULL, NULL, 'sdadsad', '704497014d865ec0e8943579b0778e59fe1f783ea764b65abfa8d69a2361af81cb57237fa89cee35a970d94a189b1d07', NULL, NULL, NULL, 1, NULL, NULL, NULL),
(3, NULL, NULL, 'sdad', '2c08f25c1ae670c122b99912cb51e74dbd55b8490d0c81e3055eaf14b91f66eca0cb8f86cd9c1ecbca8e206e75fc8d70', NULL, NULL, NULL, 1, NULL, NULL, NULL),
(4, NULL, NULL, 'add', '054368ecad6353295077dc9935cadbc0ec944a23c34b958963c58e27757b9ec6df37be91124270a52952def2ffc7d737', NULL, NULL, NULL, 1, NULL, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `atencionmedica`
--
ALTER TABLE `atencionmedica`
  ADD PRIMARY KEY (`id_atencion`);

--
-- Indices de la tabla `beneficios`
--
ALTER TABLE `beneficios`
  ADD PRIMARY KEY (`id_beneficio`);

--
-- Indices de la tabla `bitacorasistema`
--
ALTER TABLE `bitacorasistema`
  ADD PRIMARY KEY (`id_bitacora`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Indices de la tabla `datosempleados`
--
ALTER TABLE `datosempleados`
  ADD PRIMARY KEY (`id_empleados`),
  ADD KEY `idPersonal` (`idPersonal`),
  ADD KEY `idEstatus` (`idEstatus`),
  ADD KEY `idCargo` (`idCargo`),
  ADD KEY `idDependencia` (`idDependencia`),
  ADD KEY `idDepartamento` (`idDepartamento`),
  ADD KEY `idGrp` (`idGrp`);

--
-- Indices de la tabla `datosninos`
--
ALTER TABLE `datosninos`
  ADD PRIMARY KEY (`id_datosnino`);

--
-- Indices de la tabla `datospersonales`
--
ALTER TABLE `datospersonales`
  ADD PRIMARY KEY (`id_personal`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`id_dependencia`),
  ADD KEY `idEstado` (`idEstado`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id_estados`);

--
-- Indices de la tabla `estatus`
--
ALTER TABLE `estatus`
  ADD PRIMARY KEY (`id_estatus`);

--
-- Indices de la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
  ADD PRIMARY KEY (`id_histomedico`);

--
-- Indices de la tabla `historialpsicologico`
--
ALTER TABLE `historialpsicologico`
  ADD PRIMARY KEY (`id_historialP`);

--
-- Indices de la tabla `medicacmentos`
--
ALTER TABLE `medicacmentos`
  ADD PRIMARY KEY (`id_medicamentos`);

--
-- Indices de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  ADD PRIMARY KEY (`id_parroquia`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`id_permisos`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_preguntas`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `prescripcion`
--
ALTER TABLE `prescripcion`
  ADD PRIMARY KEY (`id_pre`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `idPersonal` (`idEmpleado`),
  ADD KEY `idRol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `atencionmedica`
--
ALTER TABLE `atencionmedica`
  MODIFY `id_atencion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `beneficios`
--
ALTER TABLE `beneficios`
  MODIFY `id_beneficio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `bitacorasistema`
--
ALTER TABLE `bitacorasistema`
  MODIFY `id_bitacora` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `datosempleados`
--
ALTER TABLE `datosempleados`
  MODIFY `id_empleados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `datosninos`
--
ALTER TABLE `datosninos`
  MODIFY `id_datosnino` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `datospersonales`
--
ALTER TABLE `datospersonales`
  MODIFY `id_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estatus`
--
ALTER TABLE `estatus`
  MODIFY `id_estatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `historialmedico`
--
ALTER TABLE `historialmedico`
  MODIFY `id_histomedico` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historialpsicologico`
--
ALTER TABLE `historialpsicologico`
  MODIFY `id_historialP` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medicacmentos`
--
ALTER TABLE `medicacmentos`
  MODIFY `id_medicamentos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `parroquia`
--
ALTER TABLE `parroquia`
  MODIFY `id_parroquia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `permiso`
--
ALTER TABLE `permiso`
  MODIFY `id_permisos` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_preguntas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `prescripcion`
--
ALTER TABLE `prescripcion`
  MODIFY `id_pre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datosempleados`
--
ALTER TABLE `datosempleados`
  ADD CONSTRAINT `cargo` FOREIGN KEY (`idCargo`) REFERENCES `cargo` (`id_cargo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `datosempleados_ibfk_1` FOREIGN KEY (`idPersonal`) REFERENCES `datospersonales` (`id_personal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `departamento` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dependencia` FOREIGN KEY (`idDependencia`) REFERENCES `dependencia` (`id_dependencia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estatus` FOREIGN KEY (`idEstatus`) REFERENCES `estatus` (`id_estatus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD CONSTRAINT `estados` FOREIGN KEY (`idEstado`) REFERENCES `estados` (`id_estados`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `rol` (`id_rol`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`idEmpleado`) REFERENCES `datosempleados` (`id_empleados`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
