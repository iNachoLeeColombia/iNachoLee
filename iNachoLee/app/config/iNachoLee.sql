-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 21-05-2014 a las 20:08:12
-- Versión del servidor: 5.5.34-0ubuntu0.13.04.1
-- Versión de PHP: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sanofre`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad_desempeno`
--

CREATE TABLE IF NOT EXISTS `actividad_desempeno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desempeno_id` int(11) DEFAULT NULL,
  `actividad_id` int(11) DEFAULT NULL,
  `porcentaje` int(11) NOT NULL,
  `descipcion_desempeno` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_35E07058597098E1` (`desempeno_id`),
  KEY `IDX_35E070586014FACA` (`actividad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) DEFAULT NULL,
  `grupo_promovido_id` int(11) DEFAULT NULL,
  `grado_id` int(11) DEFAULT NULL,
  `departamento_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `depto_nacimiento_id` int(11) DEFAULT NULL,
  `municipio_nacimiento_id` int(11) DEFAULT NULL,
  `depto_ubicacion_id` int(11) DEFAULT NULL,
  `municipio_ubicacion_id` int(11) DEFAULT NULL,
  `ultimo_depto_expulsor_id` int(11) DEFAULT NULL,
  `acudiente_id` int(11) DEFAULT NULL,
  `padre_id` int(11) DEFAULT NULL,
  `madre_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `sede_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `movil` varchar(14) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cedula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo_documento` int(11) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` int(11) DEFAULT NULL,
  `tipo_sangre` int(11) DEFAULT NULL,
  `direccion_residencia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zona` int(11) DEFAULT NULL,
  `localidad_vereda` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `barrio` int(11) DEFAULT NULL,
  `estrato_socioeconomico` int(11) DEFAULT NULL,
  `sisben` int(11) DEFAULT NULL,
  `eps` int(11) DEFAULT NULL,
  `ars` int(11) DEFAULT NULL,
  `poblacion_vitima_conflito` int(11) DEFAULT NULL,
  `tipo_municipio_expulsor` int(11) DEFAULT NULL,
  `es_sector_privado` tinyint(1) DEFAULT NULL,
  `es_otro_municipio` tinyint(1) DEFAULT NULL,
  `tipo_discapacidad` int(11) DEFAULT NULL,
  `capacidad_excepcionales` int(11) DEFAULT NULL,
  `etnia` int(11) DEFAULT NULL,
  `resguardo` int(11) DEFAULT NULL,
  `parentesco` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `empresa` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono_empresa` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ocupacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `colegio_estudio_ultimo_ano` int(11) DEFAULT NULL,
  `direccion_colegio_proveniente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `grado_proveniente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ano` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `motivo_retiro` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `es_resposable` tinyint(1) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `jornada` int(11) DEFAULT NULL,
  `subsidiado` int(11) DEFAULT NULL,
  `alumno_madre_cabeza_familia` int(11) DEFAULT NULL,
  `beneficiario_madre_cabeza_familia` int(11) DEFAULT NULL,
  `beneficiario_veterano_militar` int(11) DEFAULT NULL,
  `beneficiario_heroes_nacion` int(11) DEFAULT NULL,
  `situacion_academica_ano_anterior` int(11) DEFAULT NULL,
  `condicion_finalizar_ano_anterior` int(11) DEFAULT NULL,
  `repitente` int(11) DEFAULT NULL,
  `es_nuevo` int(11) DEFAULT NULL,
  `es_habilitacion` int(11) DEFAULT NULL,
  `posicion_academica` int(11) DEFAULT NULL,
  `es_recuperacion` int(11) DEFAULT NULL,
  `tiene_novedad` int(11) DEFAULT NULL,
  `es_adicion` int(11) DEFAULT NULL,
  `nombre_completo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1435D52DDB38439E` (`usuario_id`),
  KEY `IDX_1435D52D9C833003` (`grupo_id`),
  KEY `IDX_1435D52DB61D4E53` (`grupo_promovido_id`),
  KEY `IDX_1435D52D91A441CC` (`grado_id`),
  KEY `IDX_1435D52D5A91C08D` (`departamento_id`),
  KEY `IDX_1435D52D58BC1BE0` (`municipio_id`),
  KEY `IDX_1435D52D8FDE7B87` (`depto_nacimiento_id`),
  KEY `IDX_1435D52DC5947016` (`municipio_nacimiento_id`),
  KEY `IDX_1435D52D87F42153` (`depto_ubicacion_id`),
  KEY `IDX_1435D52D125AF137` (`municipio_ubicacion_id`),
  KEY `IDX_1435D52DD52427B5` (`ultimo_depto_expulsor_id`),
  KEY `IDX_1435D52DAD8563A1` (`acudiente_id`),
  KEY `IDX_1435D52D613CEC58` (`padre_id`),
  KEY `IDX_1435D52D8682C8A2` (`madre_id`),
  KEY `IDX_1435D52DE19F41BF` (`sede_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_desempeno`
--

CREATE TABLE IF NOT EXISTS `alumno_desempeno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) DEFAULT NULL,
  `dimension_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `desempeno_id` int(11) DEFAULT NULL,
  `index_desempeno` double NOT NULL,
  `tiene_descriptor_adicional` int(11) NOT NULL,
  `es_imprimir_boletin` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6FD5D602FC28E5EE` (`alumno_id`),
  KEY `IDX_6FD5D602277428AD` (`dimension_id`),
  KEY `IDX_6FD5D602C5C70C5B` (`asignatura_id`),
  KEY `IDX_6FD5D602597098E1` (`desempeno_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_dimension`
--

CREATE TABLE IF NOT EXISTS `alumno_dimension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) DEFAULT NULL,
  `dimension_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `nota` double NOT NULL,
  `nota_buffered` double DEFAULT NULL,
  `numero_cambios` int(11) DEFAULT NULL,
  `fecha_ultimo_cambio` datetime DEFAULT NULL,
  `fecha_ultimo_ingreso` datetime DEFAULT NULL,
  `es_modificada` tinyint(1) DEFAULT NULL,
  `es_ingresadad` tinyint(1) DEFAULT NULL,
  `es_error` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3D880953FC28E5EE` (`alumno_id`),
  KEY `IDX_3D880953277428AD` (`dimension_id`),
  KEY `IDX_3D880953C5C70C5B` (`asignatura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_examen_redsaber`
--

CREATE TABLE IF NOT EXISTS `alumno_examen_redsaber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) DEFAULT NULL,
  `examen_id` int(11) DEFAULT NULL,
  `nota_id` int(11) DEFAULT NULL,
  `referencia` int(11) NOT NULL,
  `promedio` double NOT NULL,
  `estado_lectura` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E6DA0BA6FC28E5EE` (`alumno_id`),
  KEY `IDX_E6DA0BA65C8659A` (`examen_id`),
  KEY `IDX_E6DA0BA6A98F9F02` (`nota_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno_redsaber`
--

CREATE TABLE IF NOT EXISTS `alumno_redsaber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `examen_id` int(11) DEFAULT NULL,
  `nombre_completo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_60196FDB5C8659A` (`examen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AnoGrado`
--

CREATE TABLE IF NOT EXISTS `AnoGrado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ano_escolar_grado`
--

CREATE TABLE IF NOT EXISTS `ano_escolar_grado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) DEFAULT NULL,
  `anoescolar_id` int(11) DEFAULT NULL,
  `grado_id` int(11) DEFAULT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B50063C6FC28E5EE` (`alumno_id`),
  KEY `IDX_B50063C68076D628` (`anoescolar_id`),
  KEY `IDX_B50063C691A441CC` (`grado_id`),
  KEY `IDX_B50063C69C833003` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignatura`
--

CREATE TABLE IF NOT EXISTS `asignatura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_id` int(11) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duracion_minutos` int(11) DEFAULT NULL,
  `frucuencia_semana` int(11) DEFAULT NULL,
  `es_area` tinyint(1) DEFAULT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9243D6CE91A441CC` (`grado_id`),
  KEY `IDX_9243D6CEBD0F409C` (`area_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspecto_evaluar`
--

CREATE TABLE IF NOT EXISTS `aspecto_evaluar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `aspecto_evaluar`
--

INSERT INTO `aspecto_evaluar` (`id`, `nombre`) VALUES
(1, 'Cognitivo'),
(2, 'Procedimental'),
(3, 'Actitudinal'),
(4, 'Autoevaluación');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `auditoria`
--

CREATE TABLE IF NOT EXISTS `auditoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sede_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AF4BB49DE19F41BF` (`sede_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `buble`
--

CREATE TABLE IF NOT EXISTS `buble` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pregunta_id` int(11) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C6F22DAC31A5801E` (`pregunta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carga_academica`
--

CREATE TABLE IF NOT EXISTS `carga_academica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor_id` int(11) DEFAULT NULL,
  `profesor_dueno_id` int(11) DEFAULT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `ano_escolar_id` int(11) DEFAULT NULL,
  `es_carga_academica` tinyint(1) DEFAULT NULL,
  `estado_asignacion` int(11) DEFAULT NULL,
  `tiene_profesor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CA40EC13E52BD977` (`profesor_id`),
  KEY `IDX_CA40EC1325C8959F` (`profesor_dueno_id`),
  KEY `IDX_CA40EC139C833003` (`grupo_id`),
  KEY `IDX_CA40EC13C5C70C5B` (`asignatura_id`),
  KEY `IDX_CA40EC13DBD45574` (`ano_escolar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colegio`
--

CREATE TABLE IF NOT EXISTS `colegio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rector_id` int(11) DEFAULT NULL,
  `sector_id` int(11) DEFAULT NULL,
  `calendario_id` int(11) DEFAULT NULL,
  `propiedad_juridica_id` int(11) DEFAULT NULL,
  `nucleo_id` int(11) DEFAULT NULL,
  `genero_id` int(11) DEFAULT NULL,
  `discapacidades_id` int(11) DEFAULT NULL,
  `capacidades_excepcionales_id` int(11) DEFAULT NULL,
  `etnias_id` int(11) DEFAULT NULL,
  `resguardo_id` int(11) DEFAULT NULL,
  `novedad_inst_id` int(11) DEFAULT NULL,
  `metodologia_id` int(11) DEFAULT NULL,
  `zona_id` int(11) DEFAULT NULL,
  `depto_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `regimen_costos_id` int(11) DEFAULT NULL,
  `rango_promedio_id` int(11) DEFAULT NULL,
  `idioma_id` int(11) DEFAULT NULL,
  `nucleo_privado_id` int(11) DEFAULT NULL,
  `ano_siguiente_id` int(11) DEFAULT NULL,
  `ano_anterior_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codigo_dane` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `numero_sedes` int(11) DEFAULT NULL,
  `es_subsidio` tinyint(1) DEFAULT NULL,
  `barrio` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `web` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `es_principal` tinyint(1) DEFAULT NULL,
  `numero_linc_func` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resolucion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nota_minima` double DEFAULT NULL,
  `tipo_valoracion` int(11) DEFAULT NULL,
  `valor_minimo_deficiente` double DEFAULT NULL,
  `valor_maximo_deficiente` double DEFAULT NULL,
  `valor_minimo_insuficiente` double DEFAULT NULL,
  `valor_maximo_insuficiente` double DEFAULT NULL,
  `valor_minimo_aceptable` double DEFAULT NULL,
  `valor_maximo_aceptable` double DEFAULT NULL,
  `valor_minimo_sobresaliente` double DEFAULT NULL,
  `valor_maximo_sobresaliente` double DEFAULT NULL,
  `valor_minimo_excelente` double DEFAULT NULL,
  `valor_maximo_excelente` double DEFAULT NULL,
  `himno_colegio` longtext COLLATE utf8_unicode_ci,
  `numero_certificados` int(11) DEFAULT NULL,
  `numero_areas_minimo` int(11) DEFAULT NULL,
  `maximo_areas_habilitar` int(11) DEFAULT NULL,
  `numero_cifrasignificativa` int(11) DEFAULT NULL,
  `valor_defecto` int(11) DEFAULT NULL,
  `plantilla_boletin_preescolar` int(11) DEFAULT NULL,
  `plantilla_boletin_basica_primaria` int(11) DEFAULT NULL,
  `plantilla_boletin_basica_secundaria` int(11) DEFAULT NULL,
  `plantilla_boletin_media` int(11) DEFAULT NULL,
  `nro_clases_dia` int(11) DEFAULT NULL,
  `es_aulafija` tinyint(1) DEFAULT NULL,
  `nro_diasentremismaclase` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AA00D876C9EEDC24` (`rector_id`),
  KEY `IDX_AA00D876DE95C867` (`sector_id`),
  KEY `IDX_AA00D876A7F6EA19` (`calendario_id`),
  KEY `IDX_AA00D876A220D576` (`propiedad_juridica_id`),
  KEY `IDX_AA00D876F8E74B7F` (`nucleo_id`),
  KEY `IDX_AA00D876BCE7B795` (`genero_id`),
  KEY `IDX_AA00D8763D9D1468` (`discapacidades_id`),
  KEY `IDX_AA00D8768FACAD38` (`capacidades_excepcionales_id`),
  KEY `IDX_AA00D876684D6BA8` (`etnias_id`),
  KEY `IDX_AA00D876AE376F1D` (`resguardo_id`),
  KEY `IDX_AA00D876B469B033` (`novedad_inst_id`),
  KEY `IDX_AA00D8762705F290` (`metodologia_id`),
  KEY `IDX_AA00D876104EA8FC` (`zona_id`),
  KEY `IDX_AA00D8761538A2D3` (`depto_id`),
  KEY `IDX_AA00D87658BC1BE0` (`municipio_id`),
  KEY `IDX_AA00D876A8A67D10` (`regimen_costos_id`),
  KEY `IDX_AA00D8762F593D7A` (`rango_promedio_id`),
  KEY `IDX_AA00D876DEDC0611` (`idioma_id`),
  KEY `IDX_AA00D8763479742D` (`nucleo_privado_id`),
  KEY `IDX_AA00D8766C505A80` (`ano_siguiente_id`),
  KEY `IDX_AA00D8767054C757` (`ano_anterior_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_asignatura`
--

CREATE TABLE IF NOT EXISTS `condicion_asignatura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asignatura_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) DEFAULT NULL,
  `hora_fila` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BEFD7B3DC5C70C5B` (`asignatura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_ca_colegio`
--

CREATE TABLE IF NOT EXISTS `condicion_ca_colegio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `colegio_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) DEFAULT NULL,
  `hora_fila` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_59609737FDC9E6F` (`colegio_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_contrato`
--

CREATE TABLE IF NOT EXISTS `condicion_contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carga_academica_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) DEFAULT NULL,
  `hora_fila` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_885B17B8FC3625A3` (`carga_academica_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_grado`
--

CREATE TABLE IF NOT EXISTS `condicion_grado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) DEFAULT NULL,
  `hora_fila` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_302639B091A441CC` (`grado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_grupo`
--

CREATE TABLE IF NOT EXISTS `condicion_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) DEFAULT NULL,
  `hora_fila` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A7E5499C833003` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion_profesor`
--

CREATE TABLE IF NOT EXISTS `condicion_profesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) DEFAULT NULL,
  `hora_fila` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B5467442E52BD977` (`profesor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenido_redsaber`
--

CREATE TABLE IF NOT EXISTS `contenido_redsaber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuerpo` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE IF NOT EXISTS `contrato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor_contrato_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `horas_contratadas` double NOT NULL,
  `horas_buffer` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_66696523816F678` (`profesor_contrato_id`),
  KEY `IDX_66696523C5C70C5B` (`asignatura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `criterio_promocion`
--

CREATE TABLE IF NOT EXISTS `criterio_promocion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_asignatura_id` int(11) DEFAULT NULL,
  `grado_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `valor` double DEFAULT NULL,
  `es_area_asg` int(11) DEFAULT NULL,
  `simbolo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B4007F2DDCFB1460` (`area_asignatura_id`),
  KEY `IDX_B4007F2D91A441CC` (`grado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descriptores_adicional`
--

CREATE TABLE IF NOT EXISTS `descriptores_adicional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_desempeno_id` int(11) DEFAULT NULL,
  `es_visible_boletin` int(11) DEFAULT NULL,
  `observacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E0BF7ACC441E55F3` (`alumno_desempeno_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desempeno`
--

CREATE TABLE IF NOT EXISTS `desempeno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aspecto_evaluar_id` int(11) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `asignatura_id` int(11) DEFAULT NULL,
  `periodo_id` int(11) DEFAULT NULL,
  `descripcion_inf` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion_perdida` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `observacion_sobresaliente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion_deficiente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion_insuficiente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion_aceptable` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion_sobresaliente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descripcion_excelente` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_98C61ECD8EA94F64` (`aspecto_evaluar_id`),
  KEY `IDX_98C61ECDE52BD977` (`profesor_id`),
  KEY `IDX_98C61ECDC5C70C5B` (`asignatura_id`),
  KEY `IDX_98C61ECD9C3921AB` (`periodo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desempeno_dimension`
--

CREATE TABLE IF NOT EXISTS `desempeno_dimension` (
  `desempeno_id` int(11) NOT NULL,
  `dimension_id` int(11) NOT NULL,
  PRIMARY KEY (`desempeno_id`,`dimension_id`),
  KEY `IDX_EAA0A98597098E1` (`desempeno_id`),
  KEY `IDX_EAA0A98277428AD` (`dimension_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desempeno_grupo`
--

CREATE TABLE IF NOT EXISTS `desempeno_grupo` (
  `desempeno_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  PRIMARY KEY (`desempeno_id`,`grupo_id`),
  KEY `IDX_D4B60B54597098E1` (`desempeno_id`),
  KEY `IDX_D4B60B549C833003` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimension`
--

CREATE TABLE IF NOT EXISTS `dimension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asignatura_id` int(11) DEFAULT NULL,
  `padre_id` int(11) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `periodoacademico_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `es_item_principal` tinyint(1) DEFAULT NULL,
  `es_ano_escolar` tinyint(1) DEFAULT NULL,
  `limte_inferior_nota` double DEFAULT NULL,
  `limte_superior_nota` double DEFAULT NULL,
  `es_carita_feliz` tinyint(1) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `porcentaje` int(11) DEFAULT NULL,
  `es_ano_activo` tinyint(1) DEFAULT NULL,
  `ponderado` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CA9BC19CC5C70C5B` (`asignatura_id`),
  KEY `IDX_CA9BC19C613CEC58` (`padre_id`),
  KEY `IDX_CA9BC19CE52BD977` (`profesor_id`),
  KEY `IDX_CA9BC19C632CD11E` (`periodoacademico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dimension_grupo`
--

CREATE TABLE IF NOT EXISTS `dimension_grupo` (
  `dimension_id` int(11) NOT NULL,
  `grupo_id` int(11) NOT NULL,
  PRIMARY KEY (`dimension_id`,`grupo_id`),
  KEY `IDX_4E9E152F277428AD` (`dimension_id`),
  KEY `IDX_4E9E152F9C833003` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `examen_icfes`
--

CREATE TABLE IF NOT EXISTS `examen_icfes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grados_id` int(11) DEFAULT NULL,
  `reponsable_id` int(11) DEFAULT NULL,
  `creador_examen_id` int(11) DEFAULT NULL,
  `preguntas_id` int(11) DEFAULT NULL,
  `nro_preguntas` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `hora` int(11) NOT NULL,
  `minuto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_82FB011E753297FF` (`grados_id`),
  KEY `IDX_82FB011EAC5A3D41` (`reponsable_id`),
  KEY `IDX_82FB011E4821FA08` (`creador_examen_id`),
  KEY `IDX_82FB011E1D4F25C6` (`preguntas_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Foto`
--

CREATE TABLE IF NOT EXISTS `Foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4AEE94DBDB38439E` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado`
--

CREATE TABLE IF NOT EXISTS `grado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_siguiente_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `niveles_educativo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B98F472A36923F0E` (`grado_siguiente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grado_promovido`
--

CREATE TABLE IF NOT EXISTS `grado_promovido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_actual_id` int(11) DEFAULT NULL,
  `grado_siguiente_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6F019DC86CF985F0` (`grado_actual_id`),
  KEY `IDX_6F019DC836923F0E` (`grado_siguiente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo`
--

CREATE TABLE IF NOT EXISTS `grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grado_id` int(11) DEFAULT NULL,
  `director_grupo_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `aula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8C0E9BD391A441CC` (`grado_id`),
  KEY `IDX_8C0E9BD37A33D2D1` (`director_grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_promovido`
--

CREATE TABLE IF NOT EXISTS `grupo_promovido` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_actual_id` int(11) DEFAULT NULL,
  `grupo_siguiente_id` int(11) DEFAULT NULL,
  `grado_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14A1870717599F3F` (`grupo_actual_id`),
  KEY `IDX_14A18707CA9AB73B` (`grupo_siguiente_id`),
  KEY `IDX_14A1870791A441CC` (`grado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_clase`
--

CREATE TABLE IF NOT EXISTS `horario_clase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carga_academica_id` int(11) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) NOT NULL,
  `hora_fila` int(11) NOT NULL,
  `posicion` int(11) DEFAULT NULL,
  `posicion_columna` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D743B58AFC3625A3` (`carga_academica_id`),
  KEY `IDX_D743B58AE52BD977` (`profesor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario_grupo`
--

CREATE TABLE IF NOT EXISTS `horario_grupo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carga_academica_id` int(11) DEFAULT NULL,
  `grupo_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `dia_columna` int(11) NOT NULL,
  `hora_fila` int(11) NOT NULL,
  `posicion` int(11) DEFAULT NULL,
  `posicion_columna` int(11) DEFAULT NULL,
  `valor` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_42D28297FC3625A3` (`carga_academica_id`),
  KEY `IDX_42D282979C833003` (`grupo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula_alumno`
--

CREATE TABLE IF NOT EXISTS `matricula_alumno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ano_id` int(11) DEFAULT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `es_matricula` tinyint(1) DEFAULT NULL,
  `es_ultima_matricula` tinyint(1) DEFAULT NULL,
  `es_pago_matricula` tinyint(1) DEFAULT NULL,
  `es_papeles` tinyint(1) DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B4CF3828AE2D4F07` (`ano_id`),
  KEY `IDX_B4CF3828FC28E5EE` (`alumno_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE IF NOT EXISTS `mensaje` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuerpo_html` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  `destino` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_doc_adjunto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `es_documento_adjunto` tinyint(1) DEFAULT NULL,
  `asunto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje_usuario`
--

CREATE TABLE IF NOT EXISTS `mensaje_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `destinatario_id` int(11) DEFAULT NULL,
  `remitente_id` int(11) DEFAULT NULL,
  `mensaje_id` int(11) DEFAULT NULL,
  `fecha_envio` datetime DEFAULT NULL,
  `fecha_lectura` datetime DEFAULT NULL,
  `es_leido` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B438C745B564FBC1` (`destinatario_id`),
  KEY `IDX_B438C7451C3E945F` (`remitente_id`),
  KEY `IDX_B438C7454C54F362` (`mensaje_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_academico`
--

CREATE TABLE IF NOT EXISTS `nivel_academico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alumno_id` int(11) DEFAULT NULL,
  `periodo_actual_id` int(11) DEFAULT NULL,
  `puesto` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `nota` double DEFAULT NULL,
  `fecha_actualizacion` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5B91420FC28E5EE` (`alumno_id`),
  KEY `IDX_5B91420F1E0C3BD` (`periodo_actual_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nota_recuperacion`
--

CREATE TABLE IF NOT EXISTS `nota_recuperacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nota_id` int(11) DEFAULT NULL,
  `ano_escolar_id` int(11) DEFAULT NULL,
  `nota_recuperacion` double DEFAULT NULL,
  `observacion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_27070824A98F9F02` (`nota_id`),
  KEY `IDX_27070824DBD45574` (`ano_escolar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` int(11) NOT NULL,
  `contenido` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticias_usuarios`
--

CREATE TABLE IF NOT EXISTS `noticias_usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuarios_id` int(11) DEFAULT NULL,
  `noticias_id` int(11) DEFAULT NULL,
  `es_leida` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AEF73A68F01D3B25` (`usuarios_id`),
  KEY `IDX_AEF73A68FA5F3F21` (`noticias_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `observacion`
--

CREATE TABLE IF NOT EXISTS `observacion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dueno_id` int(11) DEFAULT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `periodo_id` int(11) DEFAULT NULL,
  `contenido` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8B8B4C6BAD2216` (`dueno_id`),
  KEY `IDX_8B8B4C6FC28E5EE` (`alumno_id`),
  KEY `IDX_8B8B4C69C3921AB` (`periodo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos_academico`
--

CREATE TABLE IF NOT EXISTS `periodos_academico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plantilla_bc3`
--

CREATE TABLE IF NOT EXISTS `plantilla_bc3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenido` longtext COLLATE utf8_unicode_ci NOT NULL,
  `referecnia` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `contenido_estatico` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `plantilla_bc3`
--

INSERT INTO `plantilla_bc3` (`id`, `contenido`, `referecnia`, `tipo`, `contenido_estatico`) VALUES
(1, '<div id=''conten-bc3-{{alumno.id}}''><table> <tr>    <td style="width: 20%;">      <img src=''{{src_img_escudo}}'' style=''width:110px;height:110px;'' />    </td>    <td><span style="font-size: 25px;font-weight: 900;text-align: center;margin-bottom: 0px;padding-bottom: 0px;" class="label_bc3" id="label_1_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">{{alumno.sede}}</span><div style="color: gray;font-size: 10px;text-align: center;margin-top: 0px;padding-top: 0px;"> <span  class="label_bc3 label_bc3_texto" id="label_24_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>aprobada por Resolución Nacional N°</span>  <span label_bc3" id="label_25_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">{{colegio.getNumeroLincFunc()}}</span></div>    </td> </tr></table><table style="width:100%;"><tr>    <td style="width:20%;"><span label_bc3  label_bc3_texto"" id="label_30_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"> ----</span>    </td>    <td style="width:60%"><span label_bc3  label_bc3_texto"" id="label_31_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"> -----</span>    </td>    <td style="width:20%;"><span label_bc3  label_bc3_texto"" id="label_32_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"> ----</span>    </td></tr></table><div style="margin-top:15px;"><table  class=''table table-bordered table-boletin''>  <tr>    <td  colspan="2" style="width:50%;">        <span class="label_bc3 label_bc3_texto" id="label_2_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>NOMBRES Y APELLIDOS:</span>         <span class="label_bc3" id="label_3_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.apellido}}</span>        <span class="label_bc3" id="label_4_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.apellido1}}</span>        <span class="label_bc3" id="label_5_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.nombre}}</span>        <span class="label_bc3" id="label_6_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.nombre1}}</span>    </td>  </tr>  <tr><td><span class="label_bc3 label_bc3_texto" id="label_7_{{alumno.id}}" data-alumno-id="{{alumno.id}}"   onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >GRADO:</span>         <span  class="label_bc3" id="label_8_{{alumno.id}}" data-alumno-id="{{alumno.id}}"   onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{alumno.grado}}</span>       </td>      <td><span class="label_bc3 label_bc3_texto" id="label_9_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >PUESTO EN GRUPO:</span>          <span class="label_bc3" id="label_10_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{puesto}}</span>/          <span class="label_bc3" id="label_23_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{nro_alumnos_grupo}}</span>      </td>  </tr>  <tr>      <td><span class="label_bc3 label_bc3_texto" id="label_11_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >PROMEDIO ALUMNO:</span>          <span class="label_bc3" id="label_12_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{promedio_estudiante|number_format(2)}}</span></td>      <td><span class="label_bc3 label_bc3_texto" id="label_13_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >AÑO ESCOLAR/PERIODO: </span>          <span class="label_bc3" id="label_14_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{ano_escolar_activo}}</span>/<span class="label_bc3 label_bc3_texto" id="label_20_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >          <span class="label_bc3" id="label_22_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{periodo_escolar_activo}}</span></td>  </tr></table></div><div id=''body_estatico{{alumno.id}}''><table  class="table table-bordered table-boletin" style="margin-top: 15px;">    <tr style="height: 40px;font-weight: 900;" class="encabezado">        <td><span class="label_bc3 label_bc3_texto" id="label_15_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Areas/Asignaturas</span></td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td><span class="label_bc3 label_bc3_texto" id="label_16_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Def</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_17_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Desemp </span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_18_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Descriptores|Logros</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_19_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >F</span></td>     </tr>    {%for areas in datos%}    <tr {%if areas.desempeno==''BAJO''%}          style="color: red;font-weight: 600;"        {%elseif areas.desempeno==''SUPERIOR''%}          style="color: green;font-weight: 600;"        {%endif%}>        <td>{{areas.nombre|upper}}</td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td>{{areas.nota_promedio_acumalativa}}</td>        <td>             {{areas.desempeno}}        </td>        {%if areas.inasistencia!=0%}            <td> </td>        {%else%}            <td>  </td>        {%endif%}      </tr>      {% for asignaturas_area in areas.asignaturas%}         <tr>             <td>{{asignaturas_area.asignatura.nombre|lower}}</td>                      {%for periodos_asignatura in asignaturas_area.asignatura.periodos %}                <td>{{periodos_asignatura.periodo.nota}}</td>             {%endfor%}                <td>{{asignaturas_area.asignatura.nota}}</td>             <td>-</td>             <td style="text-align: justify;">               {%for desempenos_asg in asignaturas_area.asignatura.desempenos%}                  {%for desempeno_asg in desempenos_asg%}                      {{desempeno_asg}}                  {%endfor%}               {%endfor%}                 </td>             <td>             {%if asignaturas_area.asignatura.inasistencias!=0%}                   {{asignaturas_area.asignatura.inasistencias}}             {%endif%}             </td>        </tr>      {%endfor%}{%endfor%}</table></div><table style="width: 100%;">    <tr><td style="text-align:center;width:180px;height:40px;"><img  style="text-align:center;width:150px;height:30px;" src="{{src_img_firma_rector}}" /></td></tr>    <tr><td><span class="label_bc3 label_bc3_texto" id="label_20_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >------------------------------------------------------------------------</span></td></tr>    <tr><td><span class="label_bc3 label_bc3_texto" id="label_21_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Firma rector(a).</span></td></tr></table><div class="footer-div"></div></div>', 0, 1, '<table  class="table table-bordered table-boletin" style="margin-top: 15px;">    <tr style="height: 40px;font-weight: 900;" class="encabezado">        <td><span class="label_bc3 label_bc3_texto" id="label_15_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Areas/Asignaturas</span></td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td><span class="label_bc3 label_bc3_texto" id="label_16_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Def</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_17_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Desemp </span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_18_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Descriptores|Logros</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_19_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >F</span></td>     </tr>    {%for areas in datos%}    <tr {%if areas.desempeno==''BAJO''%}          style="color: red;font-weight: 600;"        {%elseif areas.desempeno==''SUPERIOR''%}          style="color: green;font-weight: 600;"        {%endif%}>        <td>{{areas.nombre|upper}}</td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td>{{areas.nota_promedio_acumalativa}}</td>        <td>             {{areas.desempeno}}        </td>        {%if areas.inasistencia!=0%}            <td> </td>        {%else%}            <td>  </td>        {%endif%}      </tr>      {% for asignaturas_area in areas.asignaturas%}         <tr>             <td>{{asignaturas_area.asignatura.nombre|lower}}</td>                      {%for periodos_asignatura in asignaturas_area.asignatura.periodos %}                <td>{{periodos_asignatura.periodo.nota}}</td>             {%endfor%}                <td>{{asignaturas_area.asignatura.nota}}</td>             <td>-</td>             <td style="text-align: justify;">               {%for desempenos_asg in asignaturas_area.asignatura.desempenos%}                  {%for desempeno_asg in desempenos_asg%}                      {{desempeno_asg}}                  {%endfor%}               {%endfor%}                 </td>             <td>             {%if asignaturas_area.asignatura.inasistencias!=0%}                   {{asignaturas_area.asignatura.inasistencias}}             {%endif%}             </td>        </tr>      {%endfor%}{%endfor%}</table>'),
(2, '<div id=''conten-bc3-{{alumno.id}}''><div>{%for areas in datos%}        <div style=''                {%if loop.index%2==0 %}float=left;{%else%}float:right;{%endif%}                {%if areas.nota_promedio_acumalativa<=colegio.getNotaMinima %}background-color:red;                {%else%}                    background-color:green;                {%endif%}                border: black solid thin;                width:30%;''>            {% for asignaturas_area in areas.asignaturas%}                {{asignaturas_area.asignatura.nombre|lower}}            {%endfor%}        </div>{%endfor%}</div></div>', 0, 6, '<table  class="table table-bordered table-boletin" style="margin-top: 15px;">    <tr style="height: 40px;font-weight: 900;" class="encabezado">        <td><span class="label_bc3 label_bc3_texto" id="label_15_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Areas/Asignaturas</span></td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td><span class="label_bc3 label_bc3_texto" id="label_16_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Def</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_17_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Desemp </span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_18_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Descriptores|Logros</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_19_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >F</span></td>     </tr>    {%for areas in datos%}    <tr {%if areas.desempeno==''BAJO''%}          style="color: red;font-weight: 600;"        {%elseif areas.desempeno==''SUPERIOR''%}          style="color: green;font-weight: 600;"        {%endif%}>        <td>{{areas.nombre|upper}}</td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td>{{areas.nota_promedio_acumalativa}}</td>        <td>             {{areas.desempeno}}        </td>        {%if areas.inasistencia!=0%}            <td> </td>        {%else%}            <td>  </td>        {%endif%}      </tr>      {% for asignaturas_area in areas.asignaturas%}         <tr>             <td>{{asignaturas_area.asignatura.nombre|lower}}</td>                      {%for periodos_asignatura in asignaturas_area.asignatura.periodos %}                <td>{{periodos_asignatura.periodo.nota}}</td>             {%endfor%}                <td>{{asignaturas_area.asignatura.nota}}</td>             <td>-</td>             <td style="text-align: justify;">               {%for desempenos_asg in asignaturas_area.asignatura.desempenos%}                  {%for desempeno_asg in desempenos_asg%}                      {{desempeno_asg}}                  {%endfor%}               {%endfor%}                 </td>             <td>             {%if asignaturas_area.asignatura.inasistencias!=0%}                   {{asignaturas_area.asignatura.inasistencias}}             {%endif%}             </td>        </tr>      {%endfor%}{%endfor%}</table>'),
(3, '<div id=''conten-bc3-{{alumno.id}}''><table> <tr>    <td style="width: 20%;">      <img src=''{{src_img_escudo}}'' style=''width:110px;height:110px;'' />    </td>    <td>    <span style="font-size: 25px;font-weight: 900;text-align: center;margin-bottom: 0px;padding-bottom: 0px;" class="label_bc3" id="label_1_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.sede}}</span><div style="color: gray;font-size: 10px;text-align: center;margin-top: 0px;padding-top: 0px;"> <span  class="label_bc3 label_bc3_texto" id="label_24_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>aprobada por Resolución Nacional N°</span>  <span  class="label_bc3" id="label_25_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">{{colegio.getNumeroLincFunc()}}</span> <span  class="label_bc3 label_bc3_texto" id="label_26_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">Nit: </span><span   class="label_bc3" id="label_27_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">{{colegio.fax}}</span><span class="label_bc3 label_bc3_texto" id="label_28_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">REGISTRO DANE</span><span class="label_bc3" id="label_29_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"> {{colegio.getCodigoDane()}}</span></div>    </td> </tr></table><table style="width:100%;"><tr>    <td style="width:20%;"><span class="label_bc3  label_bc3_texto" id="label_30_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"> ----</span>    </td>    <td style="width:60%"><span class="label_bc3  label_bc3_texto" id="label_31_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"> -----</span>    </td>    <td style="width:20%;"><span class="label_bc3  label_bc3_texto" id="label_32_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"> ----</span>    </td></tr></table><div style="margin-top:15px;"><table  class=''table table-bordered table-boletin''>  <tr>    <td  colspan="2" style="width:50%;">        <span class="label_bc3 label_bc3_texto" id="label_2_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>NOMBRES Y APELLIDOS:</span>         <span class="label_bc3" id="label_3_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.apellido}}</span>        <span class="label_bc3" id="label_4_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.apellido1}}</span>        <span class="label_bc3" id="label_5_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.nombre}}</span>        <span class="label_bc3" id="label_6_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);";>{{alumno.nombre1}}</span>    </td>  </tr>  <tr><td><span class="label_bc3 label_bc3_texto" id="label_7_{{alumno.id}}" data-alumno-id="{{alumno.id}}"   onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >GRADO:</span>         <span  class="label_bc3" id="label_8_{{alumno.id}}" data-alumno-id="{{alumno.id}}"   onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{alumno.grado}}</span>       </td>      <td><span class="label_bc3 label_bc3_texto" id="label_9_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >PUESTO EN GRUPO:</span>          <span class="label_bc3" id="label_10_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{puesto}}</span>/          <span class="label_bc3" id="label_23_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{nro_alumnos_grupo}}</span>      </td>  </tr>  <tr>      <td><span class="label_bc3 label_bc3_texto" id="label_11_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >PROMEDIO ALUMNO:</span>          <span class="label_bc3" id="label_12_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{promedio_estudiante|number_format(2)}}</span></td>      <td><span class="label_bc3 label_bc3_texto" id="label_13_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >AÑO ESCOLAR/PERIODO: </span>          <span class="label_bc3" id="label_14_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{ano_escolar_activo}}</span>/          <span class="label_bc3" id="label_22_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{periodo_escolar_activo}}</span></td>  </tr></table></div><table  class="table table-bordered table-boletin" style="margin-top: 15px;">    <tr style="height: 40px;font-weight: 900;" class="encabezado">        <td><span class="label_bc3 label_bc3_texto" id="label_15_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Areas/Asignaturas</span></td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td><span class="label_bc3 label_bc3_texto" id="label_16_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Def</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_17_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Desemp </span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_18_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Descriptores|Logros</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_19_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >F</span></td>     </tr>    {%for areas in datos%}    <tr {%if areas.desempeno==''BAJO''%}          style="color: red;font-weight: 600;"        {%elseif areas.desempeno==''SUPERIOR''%}          style="color: green;font-weight: 600;"        {%endif%}>        <td><span>{{areas.nombre|upper}}</span></td>        {%for periodo_academico in periodos_escolares%}            <td><span>--<span></td>        {%endfor%}        <td><span>{{areas.nota_promedio_acumalativa}}</span></td>        <td>             <span>{{areas.desempeno}}</span>        </td>                    <td> </td>                    <td> {%if areas.inasistencia!=0%}{{areas.inasistencia}}{%endif%} </td>             </tr>      {% for asignaturas_area in areas.asignaturas%}         <tr>             <td>{{asignaturas_area.asignatura.nombre|lower}}</td>                      {%for periodos_asignatura in asignaturas_area.asignatura.periodos %}                <td>{{periodos_asignatura.periodo.nota}}</td>             {%endfor%}                <td>{{asignaturas_area.asignatura.nota}}</td>             <td> </td>             <td style="text-align: justify;">               {%if asignaturas_area.asignatura.habilito==1%}                 <strong>Nota:</strong> {{asignaturas_area.asignatura.nota_recuperacion}}                  <strong>Actividades:</strong> {{asignaturas_area.asignatura.actividades_recuperacion}}                  {%endif%}              </td>             <td>             {%if asignaturas_area.asignatura.inasistencias!=0%}                   {{asignaturas_area.asignatura.inasistencias}}             {%endif%}             </td>        </tr>      {%endfor%}{%endfor%}</table><table style="width: 100%;">    <tr><td><span class="label_bc3 label_bc3_texto" id="label_20_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >------------------------------------------------------------------------</span></td></tr>    <tr><td><span class="label_bc3 label_bc3_texto" id="label_21_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Firma rector(a).</span></td></tr></table><div class="footer-div"></div></div>', 0, 8, '<table  class="table table-bordered table-boletin" style="margin-top: 15px;">    <tr style="height: 40px;font-weight: 900;" class="encabezado">        <td><span class="label_bc3 label_bc3_texto" id="label_15_{{alumno.id}}" data-alumno-id="{{alumno.id}}"  onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Areas/Asignaturas</span></td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td><span class="label_bc3 label_bc3_texto" id="label_16_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Def</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_17_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Desemp </span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_18_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Descriptores|Logros</span></td>        <td><span class="label_bc3 label_bc3_texto" id="label_19_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >F</span></td>     </tr>    {%for areas in datos%}    <tr {%if areas.desempeno==''BAJO''%}          style="color: red;font-weight: 600;"        {%elseif areas.desempeno==''SUPERIOR''%}          style="color: green;font-weight: 600;"        {%endif%}>        <td>{{areas.nombre|upper}}</td>        {%for periodo_academico in periodos_escolares%}            <td>P{{loop.index}}</td>        {%endfor%}        <td>{{areas.nota_promedio_acumalativa}}</td>        <td>             {{areas.desempeno}}        </td>        {%if areas.inasistencia!=0%}            <td> </td>        {%else%}            <td>  </td>        {%endif%}      </tr>      {% for asignaturas_area in areas.asignaturas%}         <tr>             <td>{{asignaturas_area.asignatura.nombre|lower}}</td>                      {%for periodos_asignatura in asignaturas_area.asignatura.periodos %}                <td>{{periodos_asignatura.periodo.nota}}</td>             {%endfor%}                <td>{{asignaturas_area.asignatura.nota}}</td>             <td>-</td>             <td style="text-align: justify;">               {%for desempenos_asg in asignaturas_area.asignatura.desempenos%}                  {%for desempeno_asg in desempenos_asg%}                      {{desempeno_asg}}                  {%endfor%}               {%endfor%}                 </td>             <td>             {%if asignaturas_area.asignatura.inasistencias!=0%}                   {{asignaturas_area.asignatura.inasistencias}}             {%endif%}             </td>        </tr>      {%endfor%}{%endfor%}</table>');
INSERT INTO `plantilla_bc3` (`id`, `contenido`, `referecnia`, `tipo`, `contenido_estatico`) VALUES
(4, '{%set alumno=datos_alumno.alumno%}<div id=''conten-bc3-{{alumno.id}}''>    <table>        <tr>           <td style="width: 10%;">                <img style="width:110px;height: 110px"                      src="{{src_img_escudo}}" />            </td>            <td style="width: 90%;">                <p style="font-size: 10px;text-align: center;"><span class="label_bc3 label_bc3_texto" id="label_1_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" > Republica de colombia</span><br/>  <span class="label_bc3 label_bc3_texto" id="label_2_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" > DEPARTAMENTO DE CHOCO</span><br/>  <span class="label_bc3 label_bc3_texto" id="label_3_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >MUNICIPIO DE CARMEN DEL DARIEN</span><br/><span class="label_bc3 label_bc3_texto" id="label_4_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio}}</span><span class="label_bc3 label_bc3_texto" id="label_5_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Aprobado de grado 0º hasta grado 11º</span><span class="label_bc3 label_bc3_texto" id="label_6_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Mediante Resolución 1557 de julio 15 de 2003.</span><span class="label_bc3 label_bc3_texto" id="label_7_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Actualiza vigencia bajo resolución 3786 del 20 de Septiembre de 2013</span><span class="label_bc3 label_bc3_texto" id="label_8_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >registro DANE</span><span class="label_bc3 label_bc3_texto" id="label_9_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio.fax}}</span><span class="label_bc3 label_bc3_texto" id="label_10_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >dirección de de correo</span><span class="label_bc3 label_bc3_texto" id="label_11_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio.email}}</span>    </p>           </td>       </tr></table><p style="margin-top:20px;font-size:12px;text-align:justify;"><span class="label_bc3 label_bc3_texto" id="label_12_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Los Suscrito Rector  y  Secretaria de la</span><span class="label_bc3" id="label_13_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio}}</span>,<span class="label_bc3 label_bc3_texto" id="label_14_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >del Municipio CARMEN DEL DARIEN,</span><span class="label_bc3 label_bc3_texto" id="label_15_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >ubicado en la Cabecera Municipal (CURBARADÓ),</span><span class="label_bc3 label_bc3_texto" id="label_16_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >con jornada diurna y sabatina,</span><span class="label_bc3 label_bc3_texto" id="label_17_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >establecimiento oficial Departamental aprobados los GRADOS DE SEXTO A UNDECIMO (6° a 11°) de bachillerato</span><span class="label_bc3" id="label_18_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >mediante Resolución {{colegio.getNumeroLincFunc()}},</span><span class="label_bc3 label_bc3_texto" id="label_19_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >previo archivo del plantel</span></p><p style="font-size:18px;text-weight:900;text-align:center;"><span class="label_bc3 label_bc3_texto" id="label_20_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >CERTIFICAN</span></p><p  style="margin-top:20px;font-size:12px;text-align:justify;"><span class="label_bc3 label_bc3_texto" id="label_21_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Que el alumno (a)</span><span class="label_bc3" id="label_22_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{alumno }},</span><span class="label_bc3 label_bc3_texto" id="label_23_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >con </span><span class="label_bc3 label_bc3_texto" id="label_24_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >        {%if datos_alumno.alumno.getTipoDocumento()==1 %}                Cedula Ciudadania              {%elseif datos_alumno.alumno.getTipoDocumento()==2%}                   Tarjeta de Identidad             {%elseif datos_alumno.alumno.getTipoDocumento()==3%}                   Cédula de Extranjería ó Identificación de Extranjería             {%elseif datos_alumno.alumno.getTipoDocumento()==4%}                   Registro Civil de Nacimiento             {%elseif datos_alumno.alumno.getTipoDocumento()==5%}                   Número de Identificación Personal (NIP)             {%elseif datos_alumno.alumno.getTipoDocumento()==6%}                   Número de Identificación establecido por la Secretaría de  Educación             {%elseif datos_alumno.alumno.getTipoDocumento()==7%}                   Certificado Cabildo             {%endif%}</span> <span class="label_bc3 label_bc3_texto" id="label_25_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >N°</span><span class="label_bc3" id="label_26_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{ alumno.cedula }}</span>  <span class="label_bc3 label_bc3_texto" id="label_27_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Se matriculo en el </span><span class="label_bc3 label_bc3_texto" id="label_28_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >grado {{alumno.grado }}</span><span class="label_bc3 label_bc3_texto" id="label_29_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >de este plantel en la</span><span class="label_bc3 label_bc3_texto" id="label_30_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >sede </span><span class="label_bc3 label_bc3_texto" id="label_31_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{alumno.sede}}</span><span class="label_bc3 label_bc3_texto" id="label_32_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >y obtuvo las siguientes calificaciones  año lectivo</span><span class="label_bc3 label_bc3_texto" id="label_33_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >2014</span><span class="label_bc3 label_bc3_texto" id="label_34_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Grado {{alumno.grado }},</span><span class="label_bc3 label_bc3_texto" id="label_35_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >con folio  de matricula</span><span class="label_bc3 label_bc3_texto" id="label_36_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >­­­­ 036</span></p>  <table class="table table-bordered table-boletin" style="margin-top: 15px;">   <tr>    <td style="background-color: gray;color: white;width: 2%;"><span class="label_bc3 label_bc3_texto" id="label_37_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >N°</span></td>    <td style="background-color: gray;color: white;width: 80%;"><span class="label_bc3 label_bc3_texto" id="label_38_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >AREAS</span></td>    <td  style="background-color: gray;color: white;width: 4%;"><span class="label_bc3 label_bc3_texto" id="label_39_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >I:H.</span></td>    <td style="background-color: gray;color: white;width: 12%;"><span class="label_bc3 label_bc3_texto" id="label_40_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Calificación</span></td>    <td style="background-color: gray;color: white;width: 2%;"><span class="label_bc3 label_bc3_texto" id="label_41_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >N. Desempeño</span></td>    </tr>       {%for area in datos_alumno.areas%}      <tr>            <td> {{loop.index}}</td>         <td> {{area.nombre|upper}}</td>                <td> {{area.ih}}</td>                     <td> {{area.nota}}</td>         <td> {{area.desempeno|raw}}</td>     </tr>              {%endfor%}  </table><p  style="margin-top:20px;font-size:12px;text-align:justify;"><span class="label_bc3 label_bc3_texto" id="label_42_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Plan de estudios según LEY 115 DE 1994, los decretos reglamentario1860 de 1994, el 1850 de 1994y el decreto 1290 de 2009.</span><br/><span class="label_bc3 label_bc3_texto" id="label_43_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" > Para constacia, se firma en el municipio de</span><span class=''label_bc3 label_bc3_texto'' id=''label_44_{{alumno.id}}'' data-alumno-id=''{{alumno.id}}'' onclick=''procesarClickLabelBc3(this);''  ondblclick=''procesarDbClicLabelBc3(this);'' onmouseout=''procesarOutLabelBc3(this);'' onmouseover=''procesarSobreLabelBc3(this);'' > CARMEN DEL DARIEN(CHOCO)</span><span class=''label_bc3 label_bc3_texto'' id=''label_45_{{alumno.id}}'' data-alumno-id=''{{alumno.id}}'' onclick=''procesarClickLabelBc3(this);''  ondblclick=''procesarDbClicLabelBc3(this);'' onmouseout=''procesarOutLabelBc3(this);'' onmouseover=''procesarSobreLabelBc3(this);'' > {{''now''|date(''Y m d h:i'')}}</span></p><table  style="margin-top:20px;font-size:12px;text-align:justify;">      <tr><td style="width:30%;"> <td>         <td style="width:40%;">     <p  style="text-align: center;"><span class="label_bc3 label_bc3_texto" id="label_46_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >___________________________</span>  <br/><span class="label_bc3 label_bc3_texto" id="label_47_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio.rector}}</span><br/><span class="label_bc3 label_bc3_texto" id="label_48_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"  style="font-size: 10px;">Rector.</span> <br/><span class="label_bc3 label_bc3_texto" id="label_49_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);"  style="font-size: 10px;">{{colegio.rector.cedula}}.</span>           </p></td><td style="width:30%;"> </td></tr></table></div>', 20, 1, '..'),
(5, '<div id=''conten-bc3-{{alumno.id}}''><table>        <tr>           <td style="width: 10%;">                <img style="width:110px;height: 110px"                      src="{{src_img_escudo}}" />            </td><td style="width: 90%;"><p style="font-size: 10px;text-align: center;"><span class="label_bc3 label_bc3_texto" id="label_1_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" > Republica de colombia</span><br/>  <span class="label_bc3 label_bc3_texto" id="label_2_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" > DEPARTAMENTO DE CHOCO</span><br/>  <span class="label_bc3 label_bc3_texto" id="label_3_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >MUNICIPIO DE CARMEN DEL DARIEN</span><br/><span class="label_bc3 label_bc3_texto" id="label_4_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio}}</span><span class="label_bc3 label_bc3_texto" id="label_5_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Aprobado de grado 0º hasta grado 11º</span><span class="label_bc3 label_bc3_texto" id="label_6_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Mediante Resolución 1557 de julio 15 de 2003.</span><span class="label_bc3 label_bc3_texto" id="label_7_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Actualiza vigencia bajo resolución 3786 del 20 de Septiembre de 2013</span><span class="label_bc3 label_bc3_texto" id="label_8_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >registro DANE</span><span class="label_bc3 label_bc3_texto" id="label_9_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio.fax}}</span><span class="label_bc3 label_bc3_texto" id="label_10_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >dirección de de correo</span><span class="label_bc3 label_bc3_texto" id="label_11_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio.email}}</span>    </p>           </td>       </tr></table><span  class="label_bc3 label_bc3_texto" id="label_12_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">El suscrito coordinador de la </span><span  class="label_bc3 label_bc3_texto"  id="label_13_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">{{colegio.sede}},</span> <span  class="label_bc3 label_bc3_texto"  id="label_14_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">de Curbaradó – Carmen del Darién,</span><span  class="label_bc3 label_bc3_texto"  id="label_15_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);">CERTIFICA</span><span  class="label_bc3 label_bc3_texto" id="label_16_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Que la (el) alumna (o):</span><span  class="label_bc3 label_bc3_texto" id="label_17_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{alumno}}--,</span><span  class="label_bc3 label_bc3_texto" id="label_18_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >identificado con documento Nº</span><span  class="label_bc3 label_bc3_texto" id="label_19_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >_______________________,</span><span  class="label_bc3 label_bc3_texto" id="label_20_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >se encuentra matriculado en esta Institución Educativa Grado:</span><span  class="label_bc3 label_bc3_texto" id="label_21_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{alumno.grado}}</span><span  class="label_bc3 label_bc3_texto" id="label_22_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >sede:</span><span  class="label_bc3 label_bc3_texto" id="label_23_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{alumno.sede}},</span><span  class="label_bc3 label_bc3_texto" id="label_24_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >jornada de la mañana,</span><span  class="label_bc3 label_bc3_texto" id="label_25_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Horario de </span><span  class="label_bc3 label_bc3_texto" id="label_26_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{"now"|date("Y m d h:i")}},</span><span  class="label_bc3 label_bc3_texto" id="label_27_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >correspondiente al año 2013.</span><span  class="label_bc3 label_bc3_texto" id="label_28_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Fecha de matricula:</span><span  class="label_bc3 label_bc3_texto" id="label_29_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{"now"|date("Y/m/d")}}</span><span  class="label_bc3 label_bc3_texto" id="label_30_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Institución de carácter: Publica</span><span  class="label_bc3 label_bc3_texto" id="label_31_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Institución estrato: uno</span><span  class="label_bc3 label_bc3_texto" id="label_32_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Asistió el 80% a clases durante los meses de Junio y Julio</span><span  class="label_bc3 label_bc3_texto" id="label_33_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Para mayor constancia se firma en Curbaradó a los</span><span  class="label_bc3 label_bc3_texto" id="label_34_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >_____ </span><span  class="label_bc3 label_bc3_texto" id="label_35_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >días del mes de</span><span  class="label_bc3 label_bc3_texto" id="label_36_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >_________________ </span><span  class="label_bc3 label_bc3_texto" id="label_37_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >de 2013.</span><span  class="label_bc3 label_bc3_texto" id="label_38_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >___________________________________</span><span  class="label_bc3 label_bc3_texto" id="label_39_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >{{colegio.rector}}</span><span  class="label_bc3 label_bc3_texto" id="label_40_{{alumno.id}}" data-alumno-id="{{alumno.id}}" onclick="procesarClickLabelBc3(this);"  ondblclick="procesarDbClicLabelBc3(this);" onmouseout="procesarOutLabelBc3(this);" onmouseover="procesarSobreLabelBc3(this);" >Coordinador</span>', 30, 1, '..');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE IF NOT EXISTS `pregunta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `examen_id` int(11) DEFAULT NULL,
  `contenido_id` int(11) DEFAULT NULL,
  `indice` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `alumno_referencia` int(11) NOT NULL,
  `bloque` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AEE0E1F75C8659A` (`examen_id`),
  KEY `IDX_AEE0E1F77FDA517C` (`contenido_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor`
--

CREATE TABLE IF NOT EXISTS `profesor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `departamento_id` int(11) DEFAULT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `sede_id` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombre1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `apellido1` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_documento` int(11) DEFAULT NULL,
  `cedula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url_foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `horas_trabajo_semanales` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  `estado_civil` int(11) DEFAULT NULL,
  `numero_hijos` int(11) DEFAULT NULL,
  `fecha_retiro` date DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_vinculacion` date DEFAULT NULL,
  `libreta_militar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `distrito` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clase` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resolucion_nombramiento` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `es_activo` tinyint(1) DEFAULT NULL,
  `genero` int(11) DEFAULT NULL,
  `nivel_educativo_aprobado` int(11) DEFAULT NULL,
  `ubicacion` int(11) DEFAULT NULL,
  `cargo` int(11) DEFAULT NULL,
  `zona` int(11) DEFAULT NULL,
  `fuente_recursos` int(11) DEFAULT NULL,
  `tipo_vinculacion` int(11) DEFAULT NULL,
  `nombre_cargo` int(11) DEFAULT NULL,
  `doc_dir_comision` int(11) DEFAULT NULL,
  `amenazados` int(11) DEFAULT NULL,
  `fecha_status_amenazado` date DEFAULT NULL,
  `grado_escalafon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sobresueldo_recibido` int(11) DEFAULT NULL,
  `nivel_ensenanza` int(11) DEFAULT NULL,
  `etnoeducador` int(11) DEFAULT NULL,
  `area_ensenanza_nombrado` int(11) DEFAULT NULL,
  `area_ensenanza_tecnica` int(11) DEFAULT NULL,
  `descripcion_otra_area` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nombre_completo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5B7406D9DB38439E` (`usuario_id`),
  KEY `IDX_5B7406D95A91C08D` (`departamento_id`),
  KEY `IDX_5B7406D958BC1BE0` (`municipio_id`),
  KEY `IDX_5B7406D9E19F41BF` (`sede_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `profesor`
--

INSERT INTO `profesor` (`id`, `departamento_id`, `municipio_id`, `usuario_id`, `sede_id`, `nombre`, `nombre1`, `apellido`, `apellido1`, `tipo_documento`, `cedula`, `url_foto`, `horas_trabajo_semanales`, `tipo`, `estado_civil`, `numero_hijos`, `fecha_retiro`, `fecha_nacimiento`, `fecha_vinculacion`, `libreta_militar`, `distrito`, `clase`, `resolucion_nombramiento`, `es_activo`, `genero`, `nivel_educativo_aprobado`, `ubicacion`, `cargo`, `zona`, `fuente_recursos`, `tipo_vinculacion`, `nombre_cargo`, `doc_dir_comision`, `amenazados`, `fecha_status_amenazado`, `grado_escalafon`, `sobresueldo_recibido`, `nivel_ensenanza`, `etnoeducador`, `area_ensenanza_nombrado`, `area_ensenanza_tecnica`, `descripcion_otra_area`, `nombre_completo`) VALUES
(1, NULL, NULL, 1, NULL, 'iNachoLee', NULL, NULL, NULL, 2, '118123975', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'inacholee');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_peridoentrega`
--

CREATE TABLE IF NOT EXISTS `profesor_peridoentrega` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periodo_id` int(11) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_final` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_87C0A51B9C3921AB` (`periodo_id`),
  KEY `IDX_87C0A51BE52BD977` (`profesor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesor_solicitud`
--

CREATE TABLE IF NOT EXISTS `profesor_solicitud` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_id` int(11) DEFAULT NULL,
  `profesor_id` int(11) DEFAULT NULL,
  `alumno_id` int(11) DEFAULT NULL,
  `auditoria_id` int(11) DEFAULT NULL,
  `fecha_solicitud` datetime DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `es_realizada` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_29822F39C833003` (`grupo_id`),
  KEY `IDX_29822F3E52BD977` (`profesor_id`),
  KEY `IDX_29822F3FC28E5EE` (`alumno_id`),
  KEY `IDX_29822F3F22D1D98` (`auditoria_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicidad_periodos_profesores`
--

CREATE TABLE IF NOT EXISTS `publicidad_periodos_profesores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profesor_id` int(11) DEFAULT NULL,
  `periodo_academico_id` int(11) DEFAULT NULL,
  `tipo` int(11) NOT NULL,
  `fecha_ultimo_publicacion` datetime DEFAULT NULL,
  `fecha_ultimo_ingreso` datetime DEFAULT NULL,
  `fecha_ultimo_calificaion` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4FF8B18DE52BD977` (`profesor_id`),
  KEY `IDX_4FF8B18DFC89ACB7` (`periodo_academico_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rest`
--

CREATE TABLE IF NOT EXISTS `rest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `udate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'ROLE_ESTUDIANTE'),
(2, 'ROLE_PROFESORES'),
(3, 'ROLE_RECTOR'),
(4, 'ROLE_AUXILIAR'),
(5, 'ROLE_ACUDIENTE');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag_plantilla_bc3`
--

CREATE TABLE IF NOT EXISTS `tag_plantilla_bc3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `referencia` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=124 ;

--
-- Volcado de datos para la tabla `tag_plantilla_bc3`
--

INSERT INTO `tag_plantilla_bc3` (`id`, `tag`, `label`, `referencia`) VALUES
(1, '{{alumno.sede}}', 'label_1', 0),
(2, 'alumno_nombre', 'label_2', 0),
(3, '{{alumno.apellido}}', 'label_3', 0),
(4, '{{alumno.apellido1}}', 'label_4', 0),
(5, '{{alumno.nombre}}', 'label_5', 0),
(6, '{{alumno.nombre1}}', 'label_6', 0),
(7, 'grado', 'label_7', 0),
(8, '{{alumno.grado}}', 'label_8', 0),
(9, 'Puesto alumno', 'label_9', 0),
(10, '{{puesto}}', 'label_10', 0),
(11, 'label_promedio_alumno', 'label_11', 0),
(12, '{{promedio_estudiante|number_format(2)}}', 'label_12', 0),
(13, 'label_ano_activo', 'label_13', 0),
(14, '{{ano_escolar_activo}}', 'label_14', 0),
(15, 'label_asg', 'label_15', 0),
(16, 'label_def', 'label_16', 0),
(17, 'label_desempeno', 'label_17', 0),
(18, 'label_descrip', 'label_18', 0),
(19, 'label_fallas', 'label_19', 0),
(20, '-----', 'label_20', 0),
(21, 'label_rector', 'label_21', 0),
(22, '{{periodo_escolar_activo}}', 'label_22', 0),
(23, '{{nro_alumnos_grupo}}', 'label_23', 0),
(24, 'resolucion', 'label_24', 0),
(25, '{{colegio.getNumeroLincFunc()}}', 'label_25', 0),
(26, 'nit', 'label_26', 0),
(27, '{{colegio.fax}}', 'label_27', 0),
(28, 'regustro_dane', 'label_28', 0),
(29, '{{colegio.getCodigoDane()}}', 'label_29', 0),
(30, 'label', 'label_30', 0),
(31, 'label', 'label_31', 0),
(32, 'label', 'label_32', 0),
(33, 'Republica de colombia', 'label_1', 20),
(34, 'DEPARTAMENTO DE CHOCO', 'label_2', 20),
(35, 'MUNICIPIO DE CARMEN DEL DARIEN', 'label_3', 20),
(36, '{{colegio}}', 'label_20', 20),
(37, 'Aprobado de grado 0º hasta grado 11º', 'label_5', 20),
(38, 'Mediante Resolución 1557 de julio 15 de 2003.', 'label_6', 20),
(39, 'Actualiza vigencia bajo resolución 3786 del 20 de Septiembre de 2013', 'label_7', 20),
(40, 'registro DANE', 'label_8', 20),
(41, '{{colegio.fax}}', 'label_9', 20),
(42, 'dirección de de correo', 'label_10', 20),
(43, '{{colegio.email}}', 'label_11', 20),
(44, 'Los Suscrito Rector  y  Secretaria de la', 'label_12', 20),
(45, '{{colegio}}', 'label_13', 20),
(46, 'del Municipio CARMEN DEL DARIEN,', 'label_120', 20),
(47, 'ubicado en la Cabecera Municipal (CURBARADÓ),', 'label_15', 20),
(48, 'con jornada diurna y sabatina,', 'label_16', 20),
(49, 'establecimiento oficial Departamental aprobados los GRADOS DE SEXTO A UNDECIMO (6° a 11°) de bachillerato', 'label_17', 20),
(50, 'mediante Resolución {{colegio.getNumeroLincFunc()}}', 'label_18', 20),
(51, 'previo archivo del plantel', 'label_19', 20),
(52, 'CERTIFICAN', 'label_20', 20),
(53, 'Que el alumno (a)', 'label_21', 20),
(54, '{{alumno}}', 'label_22', 20),
(55, 'con', 'label_23', 20),
(56, 'Tarjeta de Identidad', 'label_220', 20),
(57, 'N°', 'label_25', 20),
(58, '{{ alumno.cedula }}', 'label_26', 20),
(59, 'Se matriculo en el ', 'label_27', 20),
(60, 'grado {{alumno.grado }}', 'label_28', 20),
(61, 'de este plantel en la', 'label_29', 20),
(62, 'sede', 'label_30', 20),
(63, '{{alumno.sede}}', 'label_31', 20),
(64, 'y obtuvo las siguientes calificaciones  año lectivo', 'label_32', 20),
(65, '20120', 'label_33', 20),
(66, 'Grado {{alumno.grado }},', 'label_34', 20),
(67, 'con folio  de matricula', 'label_35', 20),
(68, 'con folio  de matricula', 'label_36', 20),
(69, '­­­­ 036', 'label_37', 20),
(70, 'N°', 'label_38', 20),
(71, 'AREAS', 'label_39', 20),
(72, 'I:H.', 'label_40', 20),
(73, '{{alumno.grado}}', 'label_41', 20),
(74, 'Calificación', 'label_42', 20),
(75, 'N. Desempeño', 'label_43', 20),
(76, 'Plan de estudios según LEY 115 DE 1994, los decretos reglamentario1860 de 1994, el 1850 de 1994', 'label_44', 20),
(77, 'Para constacia, se firma en el municipio de', 'label_45', 20),
(78, 'CARMEN DEL DARIEN(CHOCO)', 'label_46', 20),
(79, '{{''now''|date(''Y m d h:i'')}}', 'label_47', 20),
(80, '___________________________', 'label_48', 20),
(81, '{{colegio.rector}}', 'label_49', 20),
(82, 'Rector.', 'label_50', 20),
(83, '{{colegio.rector.cedula}}', 'label_51', 20),
(84, 'Republica de colombia', 'label_1', 30),
(85, 'DEPARTAMENTO DE CHOCO', 'label_2', 30),
(86, 'MUNICIPIO DE CARMEN DEL DARIEN', 'label_3', 30),
(87, '{{colegio}}', 'label_20', 30),
(88, 'Aprobado de grado 0º hasta grado 11º', 'label_5', 30),
(89, 'Mediante Resolución 1557 de julio 15 de 2003.', 'label_6', 30),
(90, 'Actualiza vigencia bajo resolución 3786 del 20 de Septiembre de 2013', 'label_7', 30),
(91, 'registro DANE', 'label_8', 30),
(92, '{{colegio.fax}}', 'label_9', 30),
(93, 'dirección de de correo', 'label_10', 30),
(94, '{{colegio.email}}', 'label_11', 30),
(95, 'Los Suscrito Rector  y  Secretaria de la', 'label_12', 30),
(96, '{{colegio}}', 'label_13', 30),
(97, 'del Municipio CARMEN DEL DARIEN,', 'label_120', 30),
(98, 'ubicado en la Cabecera Municipal (CURBARADÓ),', 'label_15', 30),
(99, 'con jornada diurna y sabatina,', 'label_16', 30),
(100, 'establecimiento oficial Departamental aprobados los GRADOS DE SEXTO A UNDECIMO (6° a 11°) de bachillerato', 'label_17', 30),
(101, 'mediante Resolución {{colegio.getNumeroLincFunc()}}', 'label_18', 30),
(102, 'previo archivo del plantel', 'label_19', 30),
(103, 'CERTIFICAN', 'label_20', 30),
(104, 'Que el alumno (a)', 'label_21', 30),
(105, '{{alumno}}', 'label_22', 30),
(106, 'con', 'label_23', 30),
(107, 'Tarjeta de Identidad', 'label_220', 30),
(108, 'N°', 'label_25', 30),
(109, '{{ alumno.cedula }}', 'label_26', 30),
(110, 'Se matriculo en el ', 'label_27', 30),
(111, 'grado {{alumno.grado }}', 'label_28', 30),
(112, 'de este plantel en la', 'label_29', 30),
(113, 'sede', 'label_30', 30),
(114, '{{alumno.sede}}', 'label_31', 30),
(115, 'y obtuvo las siguientes calificaciones  año lectivo', 'label_32', 30),
(116, '20120', 'label_33', 30),
(117, 'Grado {{alumno.grado }},', 'label_34', 30),
(118, 'con folio  de matricula', 'label_35', 30),
(119, 'con folio  de matricula', 'label_36', 30),
(120, '­­­­ 036', 'label_37', 30),
(121, 'N°', 'label_38', 30),
(122, 'AREAS', 'label_39', 30),
(123, 'I:H.', 'label_40', 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tema_asignatura`
--

CREATE TABLE IF NOT EXISTS `tema_asignatura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asignatura_id` int(11) DEFAULT NULL,
  `tema` longtext COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_332A5071C5C70C5B` (`asignatura_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `es_alumno` tinyint(1) DEFAULT NULL,
  `es_cambio_contrasena` tinyint(1) DEFAULT NULL,
  `es_cambio_fotoperfil` tinyint(1) DEFAULT NULL,
  `es_fotoperfil` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `salt`, `es_alumno`, `es_cambio_contrasena`, `es_cambio_fotoperfil`, `es_fotoperfil`) VALUES
(1, 'rector', 'Kld+p9GeUSwPziAJcLb/HWoBYGelSKYC/PWZ2+8PqsUtlJ/TxJprSb4PvrlmE6j5wNle1s7jRyFHFuP7CesUcQ==', '224751a3450676044ca5467f0095a503', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_rol`
--

CREATE TABLE IF NOT EXISTS `usuario_rol` (
  `usuario_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL,
  PRIMARY KEY (`usuario_id`,`rol_id`),
  KEY `IDX_72EDD1A4DB38439E` (`usuario_id`),
  KEY `IDX_72EDD1A44BAB96C` (`rol_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario_rol`
--

INSERT INTO `usuario_rol` (`usuario_id`, `rol_id`) VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valor_variable`
--

CREATE TABLE IF NOT EXISTS `valor_variable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `variable_id` int(11) DEFAULT NULL,
  `valor` int(11) NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_83F427EF3037E8E` (`variable_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=45 ;

--
-- Volcado de datos para la tabla `valor_variable`
--

INSERT INTO `valor_variable` (`id`, `variable_id`, `valor`, `descripcion`) VALUES
(1, 1, 1, 'Oficial'),
(2, 1, 2, 'No Oficial'),
(3, 2, 1, 'M'),
(4, 2, 2, 'F'),
(5, 3, 1, 'Completa'),
(6, 3, 2, 'Mañana'),
(7, 3, 3, 'Tarde'),
(8, 3, 4, 'Nocturna'),
(9, 4, 1, 'Propiedad Juridica 1'),
(10, 4, 2, 'Propiedad Juridica2'),
(11, 5, 1, 'Nucleo 1'),
(12, 5, 2, 'Nucleo 2'),
(13, 6, 1, 'Discapacidades I'),
(14, 6, 2, 'Discapacidades II'),
(15, 7, 1, 'Capacidad Excepcional I'),
(16, 7, 2, 'Capacidad Excepcional II'),
(17, 8, 1, 'Etnias I'),
(18, 8, 2, 'Etnias II'),
(19, 9, 1, 'Resguardo I'),
(20, 9, 2, 'Resguardo II'),
(21, 10, 1, 'N I I'),
(22, 10, 2, 'NV II'),
(23, 11, 1, 'Metodologia I'),
(24, 11, 2, 'Metodologia II'),
(25, 12, 1, 'Zona I'),
(26, 12, 2, ' Zona II'),
(27, 13, 1, 'Depto I'),
(28, 13, 2, 'Depto II'),
(29, 14, 1, 'Municipio I'),
(30, 14, 2, 'Municipio II'),
(31, 15, 1, 'Municipio I'),
(32, 15, 2, 'Municipio II'),
(33, 16, 1, 'Regimen I'),
(34, 16, 2, 'Regimen II'),
(35, 17, 1, 'Rango Promedio I'),
(36, 17, 2, 'Rango Promedio II'),
(37, 18, 1, 'Ingles'),
(38, 18, 2, 'Español'),
(39, 19, 1, 'Nucleo Privado I'),
(40, 19, 2, 'Nucleo Privado II'),
(41, 20, 1, 'Prescolar'),
(42, 20, 2, 'Básica Primaria'),
(43, 20, 3, 'Básica Secundaria'),
(44, 20, 4, 'Media');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `variable`
--

CREATE TABLE IF NOT EXISTS `variable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Volcado de datos para la tabla `variable`
--

INSERT INTO `variable` (`id`, `nombre`) VALUES
(1, 'Sector'),
(2, 'Sexo'),
(3, 'Jornada'),
(4, 'Propiedad Juridica'),
(5, 'Nucleo'),
(6, 'Discapacidades'),
(7, 'Capacidades Excepcionales'),
(8, 'Etnias'),
(9, 'Resguardo'),
(10, 'Novedad Institucional'),
(11, 'Metodologia'),
(12, 'Zona'),
(13, 'Departamento'),
(14, 'Municipio'),
(15, 'Municipio'),
(16, 'Regimem'),
(17, 'Rango Promedio'),
(18, 'Idioma'),
(19, 'Nucleo Privado'),
(20, 'Niveles Educativo');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividad_desempeno`
--
ALTER TABLE `actividad_desempeno`
  ADD CONSTRAINT `FK_35E070586014FACA` FOREIGN KEY (`actividad_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_35E07058597098E1` FOREIGN KEY (`desempeno_id`) REFERENCES `desempeno` (`id`);

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `FK_1435D52DE19F41BF` FOREIGN KEY (`sede_id`) REFERENCES `colegio` (`id`),
  ADD CONSTRAINT `FK_1435D52D125AF137` FOREIGN KEY (`municipio_ubicacion_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_1435D52D58BC1BE0` FOREIGN KEY (`municipio_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_1435D52D5A91C08D` FOREIGN KEY (`departamento_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_1435D52D613CEC58` FOREIGN KEY (`padre_id`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `FK_1435D52D8682C8A2` FOREIGN KEY (`madre_id`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `FK_1435D52D87F42153` FOREIGN KEY (`depto_ubicacion_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_1435D52D8FDE7B87` FOREIGN KEY (`depto_nacimiento_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_1435D52D91A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `FK_1435D52D9C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `FK_1435D52DAD8563A1` FOREIGN KEY (`acudiente_id`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `FK_1435D52DB61D4E53` FOREIGN KEY (`grupo_promovido_id`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `FK_1435D52DC5947016` FOREIGN KEY (`municipio_nacimiento_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_1435D52DD52427B5` FOREIGN KEY (`ultimo_depto_expulsor_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_1435D52DDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `alumno_desempeno`
--
ALTER TABLE `alumno_desempeno`
  ADD CONSTRAINT `FK_6FD5D602597098E1` FOREIGN KEY (`desempeno_id`) REFERENCES `desempeno` (`id`),
  ADD CONSTRAINT `FK_6FD5D602277428AD` FOREIGN KEY (`dimension_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_6FD5D602C5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_6FD5D602FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `alumno_dimension`
--
ALTER TABLE `alumno_dimension`
  ADD CONSTRAINT `FK_3D880953C5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_3D880953277428AD` FOREIGN KEY (`dimension_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_3D880953FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `alumno_examen_redsaber`
--
ALTER TABLE `alumno_examen_redsaber`
  ADD CONSTRAINT `FK_E6DA0BA6A98F9F02` FOREIGN KEY (`nota_id`) REFERENCES `alumno_dimension` (`id`),
  ADD CONSTRAINT `FK_E6DA0BA65C8659A` FOREIGN KEY (`examen_id`) REFERENCES `examen_icfes` (`id`),
  ADD CONSTRAINT `FK_E6DA0BA6FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `alumno_redsaber`
--
ALTER TABLE `alumno_redsaber`
  ADD CONSTRAINT `FK_60196FDB5C8659A` FOREIGN KEY (`examen_id`) REFERENCES `examen_icfes` (`id`);

--
-- Filtros para la tabla `ano_escolar_grado`
--
ALTER TABLE `ano_escolar_grado`
  ADD CONSTRAINT `FK_B50063C69C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `FK_B50063C68076D628` FOREIGN KEY (`anoescolar_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_B50063C691A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `FK_B50063C6FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `asignatura`
--
ALTER TABLE `asignatura`
  ADD CONSTRAINT `FK_9243D6CEBD0F409C` FOREIGN KEY (`area_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_9243D6CE91A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `auditoria`
--
ALTER TABLE `auditoria`
  ADD CONSTRAINT `FK_AF4BB49DE19F41BF` FOREIGN KEY (`sede_id`) REFERENCES `colegio` (`id`);

--
-- Filtros para la tabla `buble`
--
ALTER TABLE `buble`
  ADD CONSTRAINT `FK_C6F22DAC31A5801E` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `carga_academica`
--
ALTER TABLE `carga_academica`
  ADD CONSTRAINT `FK_CA40EC13DBD45574` FOREIGN KEY (`ano_escolar_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_CA40EC1325C8959F` FOREIGN KEY (`profesor_dueno_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_CA40EC139C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `FK_CA40EC13C5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_CA40EC13E52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`);

--
-- Filtros para la tabla `colegio`
--
ALTER TABLE `colegio`
  ADD CONSTRAINT `FK_AA00D8767054C757` FOREIGN KEY (`ano_anterior_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_AA00D876104EA8FC` FOREIGN KEY (`zona_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D8761538A2D3` FOREIGN KEY (`depto_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D8762705F290` FOREIGN KEY (`metodologia_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D8762F593D7A` FOREIGN KEY (`rango_promedio_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D8763479742D` FOREIGN KEY (`nucleo_privado_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D8763D9D1468` FOREIGN KEY (`discapacidades_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D87658BC1BE0` FOREIGN KEY (`municipio_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876684D6BA8` FOREIGN KEY (`etnias_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D8766C505A80` FOREIGN KEY (`ano_siguiente_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_AA00D8768FACAD38` FOREIGN KEY (`capacidades_excepcionales_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876A220D576` FOREIGN KEY (`propiedad_juridica_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876A7F6EA19` FOREIGN KEY (`calendario_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876A8A67D10` FOREIGN KEY (`regimen_costos_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876AE376F1D` FOREIGN KEY (`resguardo_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876B469B033` FOREIGN KEY (`novedad_inst_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876BCE7B795` FOREIGN KEY (`genero_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876C9EEDC24` FOREIGN KEY (`rector_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_AA00D876DE95C867` FOREIGN KEY (`sector_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876DEDC0611` FOREIGN KEY (`idioma_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_AA00D876F8E74B7F` FOREIGN KEY (`nucleo_id`) REFERENCES `valor_variable` (`id`);

--
-- Filtros para la tabla `condicion_asignatura`
--
ALTER TABLE `condicion_asignatura`
  ADD CONSTRAINT `FK_BEFD7B3DC5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`);

--
-- Filtros para la tabla `condicion_ca_colegio`
--
ALTER TABLE `condicion_ca_colegio`
  ADD CONSTRAINT `FK_59609737FDC9E6F` FOREIGN KEY (`colegio_id`) REFERENCES `colegio` (`id`);

--
-- Filtros para la tabla `condicion_contrato`
--
ALTER TABLE `condicion_contrato`
  ADD CONSTRAINT `FK_885B17B8FC3625A3` FOREIGN KEY (`carga_academica_id`) REFERENCES `carga_academica` (`id`);

--
-- Filtros para la tabla `condicion_grado`
--
ALTER TABLE `condicion_grado`
  ADD CONSTRAINT `FK_302639B091A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `condicion_grupo`
--
ALTER TABLE `condicion_grupo`
  ADD CONSTRAINT `FK_5A7E5499C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `condicion_profesor`
--
ALTER TABLE `condicion_profesor`
  ADD CONSTRAINT `FK_B5467442E52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`);

--
-- Filtros para la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD CONSTRAINT `FK_66696523C5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_66696523816F678` FOREIGN KEY (`profesor_contrato_id`) REFERENCES `profesor` (`id`);

--
-- Filtros para la tabla `criterio_promocion`
--
ALTER TABLE `criterio_promocion`
  ADD CONSTRAINT `FK_B4007F2D91A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `FK_B4007F2DDCFB1460` FOREIGN KEY (`area_asignatura_id`) REFERENCES `asignatura` (`id`);

--
-- Filtros para la tabla `descriptores_adicional`
--
ALTER TABLE `descriptores_adicional`
  ADD CONSTRAINT `FK_E0BF7ACC441E55F3` FOREIGN KEY (`alumno_desempeno_id`) REFERENCES `alumno_desempeno` (`id`);

--
-- Filtros para la tabla `desempeno`
--
ALTER TABLE `desempeno`
  ADD CONSTRAINT `FK_98C61ECD9C3921AB` FOREIGN KEY (`periodo_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_98C61ECD8EA94F64` FOREIGN KEY (`aspecto_evaluar_id`) REFERENCES `aspecto_evaluar` (`id`),
  ADD CONSTRAINT `FK_98C61ECDC5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `carga_academica` (`id`),
  ADD CONSTRAINT `FK_98C61ECDE52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`);

--
-- Filtros para la tabla `desempeno_dimension`
--
ALTER TABLE `desempeno_dimension`
  ADD CONSTRAINT `FK_EAA0A98277428AD` FOREIGN KEY (`dimension_id`) REFERENCES `dimension` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EAA0A98597098E1` FOREIGN KEY (`desempeno_id`) REFERENCES `desempeno` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `desempeno_grupo`
--
ALTER TABLE `desempeno_grupo`
  ADD CONSTRAINT `FK_D4B60B549C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D4B60B54597098E1` FOREIGN KEY (`desempeno_id`) REFERENCES `desempeno` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `dimension`
--
ALTER TABLE `dimension`
  ADD CONSTRAINT `FK_CA9BC19C632CD11E` FOREIGN KEY (`periodoacademico_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_CA9BC19C613CEC58` FOREIGN KEY (`padre_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_CA9BC19CC5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`),
  ADD CONSTRAINT `FK_CA9BC19CE52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`);

--
-- Filtros para la tabla `dimension_grupo`
--
ALTER TABLE `dimension_grupo`
  ADD CONSTRAINT `FK_4E9E152F9C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4E9E152F277428AD` FOREIGN KEY (`dimension_id`) REFERENCES `dimension` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `examen_icfes`
--
ALTER TABLE `examen_icfes`
  ADD CONSTRAINT `FK_82FB011E1D4F25C6` FOREIGN KEY (`preguntas_id`) REFERENCES `pregunta` (`id`),
  ADD CONSTRAINT `FK_82FB011E4821FA08` FOREIGN KEY (`creador_examen_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_82FB011E753297FF` FOREIGN KEY (`grados_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `FK_82FB011EAC5A3D41` FOREIGN KEY (`reponsable_id`) REFERENCES `profesor` (`id`);

--
-- Filtros para la tabla `Foto`
--
ALTER TABLE `Foto`
  ADD CONSTRAINT `FK_4AEE94DBDB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `grado`
--
ALTER TABLE `grado`
  ADD CONSTRAINT `FK_B98F472A36923F0E` FOREIGN KEY (`grado_siguiente_id`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `grado_promovido`
--
ALTER TABLE `grado_promovido`
  ADD CONSTRAINT `FK_6F019DC836923F0E` FOREIGN KEY (`grado_siguiente_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `FK_6F019DC86CF985F0` FOREIGN KEY (`grado_actual_id`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `FK_8C0E9BD37A33D2D1` FOREIGN KEY (`director_grupo_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_8C0E9BD391A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`);

--
-- Filtros para la tabla `grupo_promovido`
--
ALTER TABLE `grupo_promovido`
  ADD CONSTRAINT `FK_14A1870791A441CC` FOREIGN KEY (`grado_id`) REFERENCES `grado` (`id`),
  ADD CONSTRAINT `FK_14A1870717599F3F` FOREIGN KEY (`grupo_actual_id`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `FK_14A18707CA9AB73B` FOREIGN KEY (`grupo_siguiente_id`) REFERENCES `grupo` (`id`);

--
-- Filtros para la tabla `horario_clase`
--
ALTER TABLE `horario_clase`
  ADD CONSTRAINT `FK_D743B58AE52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_D743B58AFC3625A3` FOREIGN KEY (`carga_academica_id`) REFERENCES `carga_academica` (`id`);

--
-- Filtros para la tabla `horario_grupo`
--
ALTER TABLE `horario_grupo`
  ADD CONSTRAINT `FK_42D282979C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `FK_42D28297FC3625A3` FOREIGN KEY (`carga_academica_id`) REFERENCES `carga_academica` (`id`);

--
-- Filtros para la tabla `matricula_alumno`
--
ALTER TABLE `matricula_alumno`
  ADD CONSTRAINT `FK_B4CF3828FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`),
  ADD CONSTRAINT `FK_B4CF3828AE2D4F07` FOREIGN KEY (`ano_id`) REFERENCES `dimension` (`id`);

--
-- Filtros para la tabla `mensaje_usuario`
--
ALTER TABLE `mensaje_usuario`
  ADD CONSTRAINT `FK_B438C7454C54F362` FOREIGN KEY (`mensaje_id`) REFERENCES `mensaje` (`id`),
  ADD CONSTRAINT `FK_B438C7451C3E945F` FOREIGN KEY (`remitente_id`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `FK_B438C745B564FBC1` FOREIGN KEY (`destinatario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `nivel_academico`
--
ALTER TABLE `nivel_academico`
  ADD CONSTRAINT `FK_5B91420F1E0C3BD` FOREIGN KEY (`periodo_actual_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_5B91420FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `nota_recuperacion`
--
ALTER TABLE `nota_recuperacion`
  ADD CONSTRAINT `FK_27070824DBD45574` FOREIGN KEY (`ano_escolar_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_27070824A98F9F02` FOREIGN KEY (`nota_id`) REFERENCES `alumno_dimension` (`id`);

--
-- Filtros para la tabla `noticias_usuarios`
--
ALTER TABLE `noticias_usuarios`
  ADD CONSTRAINT `FK_AEF73A68FA5F3F21` FOREIGN KEY (`noticias_id`) REFERENCES `noticia` (`id`),
  ADD CONSTRAINT `FK_AEF73A68F01D3B25` FOREIGN KEY (`usuarios_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `observacion`
--
ALTER TABLE `observacion`
  ADD CONSTRAINT `FK_8B8B4C69C3921AB` FOREIGN KEY (`periodo_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_8B8B4C6BAD2216` FOREIGN KEY (`dueno_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_8B8B4C6FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `FK_AEE0E1F77FDA517C` FOREIGN KEY (`contenido_id`) REFERENCES `contenido_redsaber` (`id`),
  ADD CONSTRAINT `FK_AEE0E1F75C8659A` FOREIGN KEY (`examen_id`) REFERENCES `examen_icfes` (`id`);

--
-- Filtros para la tabla `profesor`
--
ALTER TABLE `profesor`
  ADD CONSTRAINT `FK_5B7406D9E19F41BF` FOREIGN KEY (`sede_id`) REFERENCES `colegio` (`id`),
  ADD CONSTRAINT `FK_5B7406D958BC1BE0` FOREIGN KEY (`municipio_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_5B7406D95A91C08D` FOREIGN KEY (`departamento_id`) REFERENCES `valor_variable` (`id`),
  ADD CONSTRAINT `FK_5B7406D9DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `profesor_peridoentrega`
--
ALTER TABLE `profesor_peridoentrega`
  ADD CONSTRAINT `FK_87C0A51BE52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_87C0A51B9C3921AB` FOREIGN KEY (`periodo_id`) REFERENCES `dimension` (`id`);

--
-- Filtros para la tabla `profesor_solicitud`
--
ALTER TABLE `profesor_solicitud`
  ADD CONSTRAINT `FK_29822F3F22D1D98` FOREIGN KEY (`auditoria_id`) REFERENCES `auditoria` (`id`),
  ADD CONSTRAINT `FK_29822F39C833003` FOREIGN KEY (`grupo_id`) REFERENCES `grupo` (`id`),
  ADD CONSTRAINT `FK_29822F3E52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`),
  ADD CONSTRAINT `FK_29822F3FC28E5EE` FOREIGN KEY (`alumno_id`) REFERENCES `alumno` (`id`);

--
-- Filtros para la tabla `publicidad_periodos_profesores`
--
ALTER TABLE `publicidad_periodos_profesores`
  ADD CONSTRAINT `FK_4FF8B18DFC89ACB7` FOREIGN KEY (`periodo_academico_id`) REFERENCES `dimension` (`id`),
  ADD CONSTRAINT `FK_4FF8B18DE52BD977` FOREIGN KEY (`profesor_id`) REFERENCES `profesor` (`id`);

--
-- Filtros para la tabla `tema_asignatura`
--
ALTER TABLE `tema_asignatura`
  ADD CONSTRAINT `FK_332A5071C5C70C5B` FOREIGN KEY (`asignatura_id`) REFERENCES `asignatura` (`id`);

--
-- Filtros para la tabla `usuario_rol`
--
ALTER TABLE `usuario_rol`
  ADD CONSTRAINT `FK_72EDD1A44BAB96C` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `FK_72EDD1A4DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `valor_variable`
--
ALTER TABLE `valor_variable`
  ADD CONSTRAINT `FK_83F427EF3037E8E` FOREIGN KEY (`variable_id`) REFERENCES `variable` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
