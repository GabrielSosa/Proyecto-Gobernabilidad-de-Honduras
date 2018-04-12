-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2017 a las 00:35:18
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usaid`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_comparacion_valor_anual` (IN `p_id_proyecto` INT, `p_costo_inicial_1` FLOAT, `p_costo_inicial_2` FLOAT, `p_interes_2` FLOAT, `p_interes_1` FLOAT, `p_valor_salvamiento_1` FLOAT, `p_valor_salvamiento_2` FLOAT, `p_periodo_1` FLOAT, `p_periodo_2` FLOAT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
	DECLARE v_cantidad_tasas float DEFAULT 0;
    DECLARE v_valor_anual_1 float DEFAULT 0;
    DECLARE v_valor_anual_2 float DEFAULT 0;
    DECLARE v_interes_1 float DEFAULT 0;
    DECLARE v_interes_2 float DEFAULT 0;
   SELECT count(*) INTO v_cantidad_tasas FROM `tbl_comparacion_valor_anual` WHERE  id_proyecto= p_id_proyecto ;
   	
    IF (v_cantidad_tasas<=0) THEN
    	set v_interes_1=p_interes_1/100;
        set v_interes_2=p_interes_2/100;
    	set v_valor_anual_1=((-1*p_costo_inicial_1)*((v_interes_1*POW((1+v_interes_1),p_periodo_1))/ (pow((1+ v_interes_1),p_periodo_1)-1))) +
p_valor_salvamiento_1*((v_interes_1/POW(1+v_interes_1,p_periodo_1) - 1));
		set v_valor_anual_2=((-1*p_costo_inicial_2)*((v_interes_2*POW((1+v_interes_2),p_periodo_2))/ (pow((1+ v_interes_2),p_periodo_2)-1))) +
p_valor_salvamiento_2*((v_interes_2/POW(1+v_interes_2,p_periodo_2) - 1));
     INSERT INTO `tbl_comparacion_valor_anual`( `id_proyecto`, `costo_inicial_1`, `interes_1`, `valor_salvamiento_1`, `periodo_1`, `valor_anual_1`, `costo_inicial_2`, `interes_2`, `valor_salvamiento_2`, `periodo_2`, `valor_anual_2`) VALUES(p_id_proyecto, p_costo_inicial_1, v_interes_1, p_valor_salvamiento_1, p_periodo_1, v_valor_anual_1,  p_costo_inicial_2, v_interes_2,p_valor_salvamiento_2, p_periodo_2, v_valor_anual_2) ; 
    	
    SELECT 'COMPARACION VALOR ANUAL CALCULADO CON EXITO' INTO P_MENSAJE FROM DUAL;
	ELSE
       		SELECT 'ERROR:YA SE HA COMPARADO EL VALOR ANUAL ' INTO P_MENSAJE FROM DUAL;
       END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_costo_capitalizado` (IN `p_id_proyecto` INT, IN `COSTO_INICIAL_1` FLOAT, IN `P_VALOR_ANUAL_1` FLOAT, IN `COSTO_INICIAL_2` FLOAT, IN `INTERES_2` FLOAT, IN `P_VALOR_ANUAL_2` FLOAT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
	
    DECLARE v_cantidad_valor_anual int DEFAULT 0;
    DECLARE v_interes float DEFAULT 0;
    DECLARE v_costo_capitalizado_1 float DEFAULT 0;
    DECLARE v_costo_capitalizado_2 float DEFAULT 0;
    SELECT count(*) INTO v_cantidad_valor_anual FROM `tbl_resultados` WHERE  id_proyecto= p_id_proyecto and valor_anual_1 IS null;
    IF (v_cantidad_valor_anual>=0) THEN
    SELECT `interes` INTO v_interes FROM `tbl_proyectos` WHERE id_proyecto= p_id_proyecto;
    set v_costo_capitalizado_1= COSTO_INICIAL_1+(P_VALOR_ANUAL_1/(v_interes/100));
    set v_costo_capitalizado_2= COSTO_INICIAL_2+(P_VALOR_ANUAL_2/(INTERES_2/100));
    UPDATE `tbl_resultados` SET `costo_inicial_1`=COSTO_INICIAL_1,`valor_anual_1`=P_VALOR_ANUAL_1,`tasa_interes_2`=INTERES_2,`costo_inicial_2`=COSTO_INICIAL_2,`valor_anual_2`=P_VALOR_ANUAL_2,`costo_capitalizado_1`=v_costo_capitalizado_1,`costo_capitalizado_2`=v_costo_capitalizado_2  WHERE  id_proyecto=p_id_proyecto;
    SELECT 'COSTO CAPITALIZADO CALCULADO CON EXITO' INTO P_MENSAJE FROM DUAL;
	ELSE
       		SELECT 'ERROR:YA SE LE HA CALCULADO EL COSTO CAPITALIZADO O  NO EXITE PARA ESTE PROYECTO' INTO P_MENSAJE FROM DUAL;
       END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CREAR_PROYECTO` (IN `P_ID_USUARIO` INT(11), IN `P_NOMBRE_PROYECTO` VARCHAR(100), IN `P_DESCRIPCION` VARCHAR(100), IN `P_PERIODO` INT(5), IN `P_INTERES` FLOAT, IN `P_TIEMPO` INT(11), IN `P_MONTO_PRESTAMO` FLOAT, IN `P_FECHA_INICIO` DATE, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
    	DECLARE V_CANTIDAD_NOMBRES INT;
        DECLARE V_ID_PROYECTO INT;
        SELECT  COUNT(*) INTO V_CANTIDAD_NOMBRES  FROM tbl_proyectos where nombre_proyecto=P_NOMBRE_PROYECTO AND id_usuario=P_ID_USUARIO;
        IF (V_CANTIDAD_NOMBRES<=0) THEN
            INSERT INTO `tbl_proyectos`(`id_usuario`, `nombre_proyecto`, `descripcion`, `periodo`, `interes`, `tiempo`, `monto_prestamo`, `fecha_inicio`,`estado_proyecto`) VALUES (P_ID_USUARIO,P_NOMBRE_PROYECTO,P_DESCRIPCION,P_PERIODO,P_INTERES,P_TIEMPO,P_MONTO_PRESTAMO,P_FECHA_INICIO,1);
            SELECT  MAX(id_proyecto) INTO V_ID_PROYECTO  FROM tbl_proyectos;
            INSERT INTO `tbl_resultados`(`id_proyecto`) VALUES (V_ID_PROYECTO);
            
            SELECT 'INSERTADO CON EXITO' INTO P_MENSAJE FROM DUAL;
       ELSE
       		SELECT 'ERROR:EL NOMBRE DE PROYECTO YA EXISTE' INTO P_MENSAJE FROM DUAL;
       END IF;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_flujo_efectivo_incremental` (IN `p_id_proyecto` INT, `p_flujo_efectivo_propuesta_1` FLOAT, `p_flujo_efectivo_propuesta_2` FLOAT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
	DECLARE v_cantidad_efectivo_incremental int DEFAULT 0;
    DECLARE v_total float DEFAULT 0;
    SELECT count(*) INTO v_cantidad_efectivo_incremental FROM `tbl_flujo_efectivo_incremental` WHERE  id_proyecto= p_id_proyecto;
    set v_total=p_flujo_efectivo_propuesta_1-p_flujo_efectivo_propuesta_2;
    IF (v_cantidad_efectivo_incremental<3) THEN
    	INSERT INTO `tbl_flujo_efectivo_incremental`( `id_proyecto`, `flujo_propuesta_1`, `flujo_propuesta_2`,`total`) VALUES (p_id_proyecto,p_flujo_efectivo_propuesta_1,p_flujo_efectivo_propuesta_2,v_total);
    	
    	 SELECT 'FLUJO INCREMENTAL INGRESADO CON EXITO ' INTO P_MENSAJE FROM DUAL;
	ELSE
       		SELECT 'ERROR:YA SE HAN INGRESADO 3 FLUJOS INCREMENTAL ' INTO P_MENSAJE FROM DUAL;
       END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_interes_compuesto` (IN `p_id_proyecto` INT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
	
    DECLARE c int DEFAULT 0;
    DECLARE v_periodo int DEFAULT 0;
    DECLARE v_monto_pres float DEFAULT 0;
    DECLARE v_monto_pagado float DEFAULT 0;
    DECLARE v_pago_interes float DEFAULT 0;
    DECLARE v_pago_capital float DEFAULT 0;
    DECLARE v_cuota float DEFAULT 0;
    DECLARE v_saldo_actual float DEFAULT 0;
    DECLARE v_interes float DEFAULT 0;
    DECLARE v_cantidad_interes_compuesto int DEFAULT 0;
    
    SELECT COUNT(*) INTO v_cantidad_interes_compuesto FROM `tbl_interes_compuesto` WHERE id_proyecto= p_id_proyecto;
    IF (v_cantidad_interes_compuesto<=0) THEN
    SELECT `periodo`, `interes`, `monto_prestamo` INTO v_periodo, v_interes, v_monto_pres FROM `tbl_proyectos` WHERE id_proyecto= p_id_proyecto;
    
    set v_saldo_actual=v_monto_pres;
    set v_cuota=v_monto_pres/v_periodo;
    set v_pago_capital=v_cuota;
    
    set v_monto_pagado=0.00;
    WHILE( c < v_periodo ) DO
    	 set v_pago_interes=v_saldo_actual*(v_interes/100);
		 set v_saldo_actual= v_saldo_actual-v_cuota;
         set v_monto_pagado= v_monto_pagado+v_cuota;
         set c = c+1;
         

         INSERT INTO `tbl_interes_compuesto`( `id_proyecto`, `periodo`, `interes`, `pago_capital`, `cuota`, `saldo_actual`, `monto_pagado`) VALUES (p_id_proyecto,c,v_pago_interes,v_pago_capital, v_cuota,v_saldo_actual,v_monto_pagado);
    end WHILE;
    SELECT 'INTERES COMPUESTO CALCULADO CON EXITO' INTO P_MENSAJE FROM DUAL;
	ELSE
       		SELECT 'ERROR:YA SE LE HA CALCULADO EL INTERES COMPUESTO O  NO EXITE PARA ESTE PROYECTO' INTO P_MENSAJE FROM DUAL;
       END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_interes_simple` (IN `p_id_proyecto` INT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
	
    DECLARE c int DEFAULT 0;
    DECLARE v_periodo int DEFAULT 0;
    DECLARE v_monto_pres float DEFAULT 0;
    DECLARE v_monto_pagar float DEFAULT 0;
    DECLARE v_monto_pagado float DEFAULT 0;
    DECLARE v_pago_interes float DEFAULT 0;
    DECLARE v_pago_capital float DEFAULT 0;
    DECLARE v_cuota float DEFAULT 0;
    DECLARE v_saldo_actual float DEFAULT 0;
    DECLARE v_interes float DEFAULT 0;
    DECLARE v_cantidad_interes_simple int DEFAULT 0;
    
    SELECT COUNT(*) INTO v_cantidad_interes_simple FROM `tbl_interes_simple` WHERE id_proyecto= p_id_proyecto;
    IF (v_cantidad_interes_simple<=0) THEN
    SELECT `periodo`, `interes`, `monto_prestamo` INTO v_periodo, v_interes, v_monto_pres FROM `tbl_proyectos` WHERE id_proyecto= p_id_proyecto;
    set v_monto_pagar= v_monto_pres*(v_interes*v_periodo/100)+v_monto_pres;
    set v_saldo_actual=v_monto_pagar;
    set v_cuota=v_monto_pagar/v_periodo;
    set v_pago_capital=v_cuota-(v_monto_pres/v_periodo);
    set v_pago_interes=v_cuota-(v_pago_capital);
    set v_monto_pagado=0.00;
    WHILE( c < v_periodo ) DO
		 set v_saldo_actual= v_saldo_actual-v_cuota;
         set v_monto_pagado= v_monto_pagado+v_cuota;
         set c = c+1;
         

         INSERT INTO `tbl_interes_simple`( `id_proyecto`, `periodo`, `interes`, `pago_capital`, `cuota`, `saldo_actual`, `monto_pagado`) VALUES (p_id_proyecto,c,v_pago_interes,v_pago_capital, v_cuota,v_saldo_actual,v_monto_pagado);
    end WHILE;
    SELECT 'INTERES SIMPLE CALCULADO CON EXITO' INTO P_MENSAJE FROM DUAL;
	ELSE
       		SELECT 'ERROR:YA SE LE HA CALCULADO EL INTERES SIMPLE O  NO EXITE PARA ESTE PROYECTO' INTO P_MENSAJE FROM DUAL;
       END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_inversion_permanente` (IN `p_id_proyecto` INT, `p_cantidad_depositada` FLOAT, `p_cantidad_retirar_indefinidamente` FLOAT, `p_cantidad_acumular` FLOAT, `p_tiempo_requerido` FLOAT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
	DECLARE v_cantidad_inversion_permanente float DEFAULT 0;
    
    SELECT count(*) INTO v_cantidad_inversion_permanente FROM `tbl_resultados` WHERE  id_proyecto= p_id_proyecto  and 	cantidad_depositada_hoy IS null and cantidad_retirar_indefinida IS null  and cantidad_acumular IS null  and tiempo_requerido IS null;
    IF (v_cantidad_inversion_permanente>0) THEN
    	 UPDATE `tbl_resultados` SET `cantidad_depositada_hoy`=p_cantidad_depositada, `cantidad_retirar_indefinida`=p_cantidad_retirar_indefinidamente,`cantidad_acumular`=p_cantidad_acumular,`tiempo_requerido`=p_tiempo_requerido WHERE  id_proyecto=p_id_proyecto;
    	 SELECT 'INVERSION PERMANTE INGRESADO CON EXITO ' INTO P_MENSAJE FROM DUAL;
	ELSE
       		SELECT 'ERROR:YA AN INGRESADO INVERSION PERMANTENTE O NO EXISTE ESTE PROYECTO ' INTO P_MENSAJE FROM DUAL;
       END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR` (IN `P_NOMBRE_COMPLETO` VARCHAR(100), IN `P_PAIS` VARCHAR(11), IN `P_USUARIO` VARCHAR(50), IN `P_CORREO_ELECTRONICO` VARCHAR(150), IN `P_PASSWORD` VARCHAR(100), OUT `P_MENSAJE` VARCHAR(200))  BEGIN
    	DECLARE V_ID_PERSONA INT;
    	DECLARE V_CANTIDAD_USUARIO INT;
        SELECT  COUNT(*) INTO V_CANTIDAD_USUARIO  FROM tbl_usuarios where usuario=P_USUARIO;
        IF (V_CANTIDAD_USUARIO<=0) THEN
            INSERT INTO `tbl_personas`( `nombre_completo`, `pais`, `correo_electronico`) VALUES (P_NOMBRE_COMPLETO,P_PAIS,P_CORREO_ELECTRONICO);
            SELECT  MAX(id_persona) INTO V_ID_PERSONA  FROM tbl_personas;
           INSERT INTO `tbl_usuarios`( `usuario`, `password`, `id_persona`, `id_estado`,`fecha_ingreso`) VALUES (P_USUARIO,P_PASSWORD,V_ID_PERSONA,1,now());
            SELECT 'INSERTADO CON EXITO' INTO P_MENSAJE FROM DUAL;
       ELSE
       		SELECT 'ERROR:EL NOMBRE DE USUARIO YA EXISTE' INTO P_MENSAJE FROM DUAL;
       END IF;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tasa_retorno` (IN `p_id_proyecto` INT, `p_interes` FLOAT, `p_periodo` INT, `p_saldo_inicial_no_recuperado` FLOAT, `p_flujo_efectivo` FLOAT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
	DECLARE v_cantidad_tasas float DEFAULT 0;
    DECLARE v_interes_sobre_saldo_no_rec float DEFAULT 0;
    DECLARE v_cantidad_recuperado float DEFAULT 0;
    DECLARE v_saldo_final_no_recuperado float DEFAULT 0;
    SELECT count(*) INTO v_cantidad_tasas FROM `tbl_tasa_retorno` WHERE  id_proyecto= p_id_proyecto;
    IF (v_cantidad_tasas<3) THEN
    	set v_interes_sobre_saldo_no_rec=(p_interes/100)*p_saldo_inicial_no_recuperado;
        set v_cantidad_recuperado=p_flujo_efectivo-v_interes_sobre_saldo_no_rec;
        set v_saldo_final_no_recuperado=p_saldo_inicial_no_recuperado+v_cantidad_recuperado;
    	INSERT INTO `tbl_tasa_retorno`( `id_proyecto`, `anio`, `interes`,`interes_sobre_saldo_no_recuperado`, `saldo_inicial_no_recuperado`, `flujo_efectivo`, `cantidad_recuperada`, `saldo_final_no_recuperado`) VALUES (p_id_proyecto,p_periodo,p_interes,v_interes_sobre_saldo_no_rec,p_saldo_inicial_no_recuperado,p_flujo_efectivo,v_cantidad_recuperado,v_saldo_final_no_recuperado);
    SELECT 'TASA DE RETORNO CALCULADO CON EXITO' INTO P_MENSAJE FROM DUAL;
	ELSE
       		SELECT 'ERROR:YA SE  HAN CALCULADO 3 TASAS DE RETORNO ' INTO P_MENSAJE FROM DUAL;
       END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_valor_futuro` (IN `p_id_proyecto` INT, IN `p_valor_futuro` FLOAT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
    DECLARE v_cantidad_valor_futuro int DEFAULT 0;
    
    SELECT count(*) INTO v_cantidad_valor_futuro FROM `tbl_resultados` WHERE id_proyecto= p_id_proyecto and valor_futuro IS null;
    IF (v_cantidad_valor_futuro >0) THEN
        UPDATE `tbl_resultados` SET `valor_futuro`=p_valor_futuro WHERE  id_proyecto=p_id_proyecto;
        SELECT 'VALOR FUTURO INSERTADO CON EXITO' INTO P_MENSAJE FROM DUAL;
	ELSE
       	SELECT 'ERROR:YA SE HA INSERTADO VALOR FUTURO' INTO P_MENSAJE FROM DUAL;
     END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_valor_presente` (IN `p_id_proyecto` INT, IN `p_valor_presente` FLOAT, OUT `P_MENSAJE` VARCHAR(200))  BEGIN
    DECLARE v_cantidad_valor_presente int DEFAULT 0;
    SELECT count(*) INTO v_cantidad_valor_presente FROM `tbl_resultados` WHERE id_proyecto= p_id_proyecto and valor_presente IS null;
    IF (v_cantidad_valor_presente >0) THEN
        UPDATE `tbl_resultados` SET `valor_presente`=p_valor_presente WHERE  id_proyecto=p_id_proyecto;
        SELECT 'VALOR PRESENTE INSERTADO CON EXITO' INTO P_MENSAJE FROM DUAL;
	ELSE
       	SELECT 'ERROR:YA SE HA INSERTADO VALOR PRESENTE' INTO P_MENSAJE FROM DUAL;
     END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_departamentos`
--

CREATE TABLE `tbl_departamentos` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_departamentos`
--

INSERT INTO `tbl_departamentos` (`id_departamento`, `departamento`) VALUES
(1, 'francisco morazan'),
(2, 'cortes'),
(3, 'santa barbara'),
(4, 'copan'),
(5, 'lempira');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_estados`
--

CREATE TABLE `tbl_estados` (
  `id_estado` int(1) NOT NULL,
  `nombre_estado` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_estados`
--

INSERT INTO `tbl_estados` (`id_estado`, `nombre_estado`) VALUES
(1, 'ACTIVO'),
(2, 'INACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_municipios`
--

CREATE TABLE `tbl_municipios` (
  `id_municipio` int(11) NOT NULL,
  `municipio` varchar(50) NOT NULL,
  `id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_municipios`
--

INSERT INTO `tbl_municipios` (`id_municipio`, `municipio`, `id_departamento`) VALUES
(1, 'tela', 1),
(2, 'tegucigalpa', 3),
(3, 'santa lucia', 1),
(4, 'santa rosa', 3),
(5, 'la campa', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_personas`
--

CREATE TABLE `tbl_personas` (
  `id_persona` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `pais` varchar(100) NOT NULL,
  `correo_electronico` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_personas`
--

INSERT INTO `tbl_personas` (`id_persona`, `nombre_completo`, `pais`, `correo_electronico`) VALUES
(9, 'NOMBRE1 APELLIDO1', 'HONDURAS', 'NOMBRE1@MAIL.COM'),
(10, 'N', 'A2', 'C'),
(13, 'N', 'A3', 'C3'),
(15, 'N', 'A5', 'C5'),
(16, 'NOMBRE1 APELLIDO1', 'tegucigapa', 'ersona');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_proyectos`
--

CREATE TABLE `tbl_proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `nombre_proyecto` varchar(100) NOT NULL,
  `descripcion` varchar(100) DEFAULT NULL,
  `periodo` int(5) DEFAULT NULL,
  `id_departamento` int(11) NOT NULL,
  `id_municipio` int(11) NOT NULL,
  `correo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_proyectos`
--

INSERT INTO `tbl_proyectos` (`id_proyecto`, `id_usuario`, `nombre_proyecto`, `descripcion`, `periodo`, `id_departamento`, `id_municipio`, `correo`) VALUES
(1, 1, 'asdf', 'asdf', 2, 1, 1, 'sadas@gmail.com'),
(2, 1, 'asd', 'asd', 1, 1, 3, 'qwerert@hotmail.com'),
(3, 1, 'A', 'AN', 1, 1, 3, 'hola@err.com'),
(4, 1, 'hhh', 'asd', 3, 3, 4, 'rtyuiop@mmm.com'),
(5, 1, 'A2', 'AN2', 1, 5, 5, 'wqedasd@tabla.com'),
(6, 1, 'A3', 'AN3', 10, 5, 5, 'gabo@hotmail.com'),
(7, 1, 'dsds', 'asds', 1, 3, 2, 'rosa@trabo.com'),
(8, 1, 'Aa', 'ANa', 1, 3, 4, 'sdsad@dai.com'),
(9, 1, 'A5', 'AN5', 1, 4, 1, 'hola@gmail.com'),
(10, 1, 'A25', 'AN25', 1, 3, 2, 'qwe@gmail.com'),
(11, 1, 'asdDSA', 'asddsa', 12, 1, 3, 'adsasd@google.com'),
(12, 1, 'aasd', 'dsa', 12, 3, 2, 'asda@dai.com'),
(13, 1, 'prestamo simple', 'asdsd', 12, 5, 5, 'asdasdfer@google.com'),
(14, 1, 'hhhweqa', 'dsad', 12, 5, 5, 'qwert@google.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_pruebas`
--

CREATE TABLE `tbl_pruebas` (
  `depto` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_pruebas`
--

INSERT INTO `tbl_pruebas` (`depto`) VALUES
('Arraylength'),
('2'),
('1'),
('1'),
('2'),
('0'),
('5'),
('5'),
('1'),
('1'),
(''),
('4'),
('');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE `tbl_usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_estado` int(1) NOT NULL,
  `fecha_ingreso` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`id_usuario`, `usuario`, `password`, `id_persona`, `id_estado`, `fecha_ingreso`) VALUES
(1, 'NA', 'ASDF1234', 9, 1, '2017-03-16 19:19:22'),
(2, 'AN5', 'PW', 15, 1, '2017-03-18 21:58:27'),
(3, '1', 'sasd', 16, 1, '2017-04-09 21:01:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_departamentos`
--
ALTER TABLE `tbl_departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `tbl_estados`
--
ALTER TABLE `tbl_estados`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `tbl_municipios`
--
ALTER TABLE `tbl_municipios`
  ADD PRIMARY KEY (`id_municipio`);

--
-- Indices de la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  ADD PRIMARY KEY (`id_persona`),
  ADD UNIQUE KEY `uk_email` (`correo_electronico`);

--
-- Indices de la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uk_user` (`usuario`),
  ADD KEY `fk_persona` (`id_persona`),
  ADD KEY `fk_estado_persona` (`id_estado`),
  ADD KEY `id_persona` (`id_persona`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_estados`
--
ALTER TABLE `tbl_estados`
  MODIFY `id_estado` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `tbl_personas`
--
ALTER TABLE `tbl_personas`
  MODIFY `id_persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT de la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbl_proyectos`
--
ALTER TABLE `tbl_proyectos`
  ADD CONSTRAINT `tbl_proyectos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `tbl_usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD CONSTRAINT `tbl_usuarios_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `tbl_personas` (`id_persona`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_usuarios_ibfk_2` FOREIGN KEY (`id_estado`) REFERENCES `tbl_estados` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
