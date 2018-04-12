<?php 
session_start();
if($_POST and isset($_SESSION['usuario'])){
	
	include("conexion.php");
	$conexion= new conexion();

	$depto = $_POST['depto'];
	$municipio = $_POST['municipio'];
	$nombreOrg= $_POST['nombreOrg'];
	$X= $_POST['X'];
	$Y= $_POST['Y'];
	$tipoOrg= $_POST['tipoOrg'];
	$tipoActoresLocales = $_POST['tipoActoresLocales'];
	$nivelTerri= $_POST['nivelTerri'];
	$personeria= $_POST['personeria'];
	$objetivo= $_POST['objetivo'];
	$areaTematica = $_POST['areaTematica'];
	$apoyoLocal= $_POST['apoyoLocal']; //Es lo mismo que id_area_trabajo
	$areaTecnica= $_POST['areaTecnica'];
	$gruposSocial= $_POST['gruposSocial'];
	$areaApoyo = $_POST['areaApoyo'];  

	//Aqui miramos el último registro por el id de actor local
	$id_local = "SELECT MAX(id_actor_local) FROM actores_locales";
	$ultimoActor = pg_query($conexion->getConexion(),$id_local);
	$numeroActor = pg_fetch_row($ultimoActor);
	$numero= $numeroActor[0]+1; //devuelve el ultimo valor

	$sqlActores = "INSERT INTO public.actores_locales(
		id_actor_local, id_departamento, id_municipio, id_tipo_actores, id_tipo_actor, id_personeria_juridica, id_nivel_territorial, id_area_tematica, id_area_asistencia_tecnica, ide_geografica_coor_latitude, ide_geografica_coor_longitude, nombre_institucion_organizacion, objetivo_organizacion, areas_apoya_grupos_sociales)
		VALUES ($numero, $depto, $municipio, $tipoActoresLocales, $tipoOrg, $personeria, $nivelTerri, $areaTematica, $areaTecnica, $Y, $X, '$nombreOrg', '$objetivo', '$areaApoyo')";
	pg_query($conexion->getConexion(),$sqlActores);

	if(isset($_POST['proyectos'])){

		$proyectos= $_POST['proyectos']; // Proyectos y esto es un arreglo porque viene de una tabla
		$id_proyecto = "SELECT MAX(id_proyectos) FROM proyectos";
		$ultimoProyecto = pg_query($conexion->getConexion(),$id_proyecto);
		$numeroproyecto = pg_fetch_row($ultimoProyecto);
		$numeroP= $numeroproyecto[0]+1; //devuelve el ultimo valor
		if ($numeroP==null) {
			$numeroP=0;
		}

		foreach ($proyectos as $proyecto) {
			$nombreProyecto= $proyecto['Nombre del Proyecto'];
			$monto= $proyecto['Monto (L.)'];
			$beneficiarios = $proyecto['Beneficiarios'];
			$rol = $proyecto['Rol'];
			$sqlProyectos = "INSERT INTO proyectos(
				id_proyectos, id_actor_local, proyecto, monto, beneficiarios, rol)
				VALUES ($numeroP, $numero, '$nombreProyecto', $monto, '$beneficiarios', '$rol')";
			$numeroP = $numeroP + 1;	
			pg_query($conexion->getConexion(),$sqlProyectos);
		}
		//print_r($proyecto);
	}

	if(isset($_POST['areas'])){
		$areas= $_POST['areas']; //areas de influencia y esto es una arreglo porque viene de una tabla
	    $id_area = "SELECT MAX(id_area_infuencia) FROM area_influencia";
		$ultimoArea = pg_query($conexion->getConexion(),$id_area);
		$numeroArea = pg_fetch_row($ultimoArea);
		$numeroA= $numeroArea[0]+1; //devuelve el ultimo valor
		
		if ($numeroA==null) {
			$numeroA=0;
		}

		foreach ($areas as $area) {

			$Departamento= $area['Departamento'];
			$Municipio= $area['Municipio'];
			$Comunidad = $area['Comunidad'];
			$sqlAreas = "INSERT INTO area_influencia(
							id_area_infuencia, id_actor_local, id_departamento, id_municipio, comunidad)
							VALUES ($numeroA, $numero, $Departamento, $Municipio, '$Comunidad')";
			$numeroA = $numeroA + 1;	
			pg_query($conexion->getConexion(),$sqlAreas);
		}
	}

	if(isset($_POST['adopcion'])){
		$adopcion = $_POST['adopcion']; //Es adopcion y esto es un json porque esta dentro de una tabla Es de la tabla politica ordenanza
		$sqlPolitica = "SELECT MAX(id_politica_ordenanza) FROM politica_ordenanza";
		$ultimoPolitica = pg_query($conexion->getConexion(),$sqlPolitica);
		$numeroPolitica = pg_fetch_row($ultimoPolitica);
		$numeroPo= $numeroPolitica[0]+1; //devuelve el ultimo valor
		
		if ($numeroPo==null) {
			$numeroPo=0;
		}

		foreach ($adopcion as $adopciones) {
			$idEstatus =  $adopciones['Estatus'];
			$PoliticaOrdenanza= $adopciones['Politica / ordenanza'];
			$FechaPolitica= $adopciones['Fecha de presentación política'];
			$ServicioMejorar = $adopciones['Servicio a mejorar'];
			$sqlAdopcion = "INSERT INTO politica_ordenanza(
						id_politica_ordenanza, id_actor_local, id_estatus, politica_odenanza, fecha_presentacion, servicio_meta_mejorar)
						VALUES ($numeroPo, $numero, $idEstatus, $PoliticaOrdenanza, $FechaPolitica, $ServicioMejorar)";
			$numeroPo = $numeroPo + 1;	
			pg_query($conexion->getConexion(),$sqlAdopcion);
		}

	}

	if(isset($_POST['auditoriaSocial'])){
		$auditoriaSocial = $_POST['auditoriaSocial']; //Es adopcion y esto es un json porque esta dentro de una tabla
		$sqlAuditoria = "SELECT MAX(id_auditoria_social) FROM auditorias_sociales";
		$ultimoAuditoria = pg_query($conexion->getConexion(),$sqlAuditoria);
		$numeroAuditoria = pg_fetch_row($ultimoAuditoria);
		$numeroAudi= $numeroAuditoria[0]+1; //devuelve el ultimo valor
		
		if ($numeroAudi==null) {
			$numeroAudi=0;
		}

		foreach ($auditoriaSocial as $auditoria) {

			$Anio= $auditoria['Año'];
			$Mes= $auditoria['Mes'];
			$tema= $auditoria['Tema de la Auditoria'];
			$Organizacion = $auditoria['Organización'];
			$Servicio = $auditoria['Servicio a mejorar'];
			$DetalleMejorar = $auditoria['Detalle de las recomendaciones']; 
			$NRecomendaciones = $auditoria['% de recomendacion'];	
			$fechaInicio = $auditoria['fecha Inicio']; 	
			$sqlAuditoria = "INSERT INTO auditorias_sociales(
						id_auditoria_social, id_actor_local, mes, anio, tema_auditoria, organizacion_auditada, servicio_meta_mejorar, 
					    detalle_recomendaciones, porcentaje_recomendaciones_implementadas, fecha_inicio_implementacion)
						VALUES ($numeroAudi, $numero, $Mes, $Anio, '$tema', '$Organizacion', '$Servicio', '$DetalleMejorar', $NRecomendaciones, '$fechaInicio')";
			$numeroAudi = $numeroAudi + 1;	
			pg_query($conexion->getConexion(),$sqlAuditoria);

		}
	}

	if(isset($_POST['gruposSocial'])){
	$sqlGrupoSocial = "SELECT MAX(id_grupos_sociales) FROM grupo_social";
	$ultimoGrupo= pg_query($conexion->getConexion(),$sqlGrupoSocial);
	$numeroGrupo = pg_fetch_row($ultimoGrupo);
	$numeroG= $numeroGrupo[0]+1; //devuelve el ultimo valor

	if ($numeroG==null) {
		$numeroG=0;
	}

	$sqlGrupo = "INSERT INTO grupo_social(
				id_grupos_sociales, id_actor_local, id_grupo_social)
				VALUES ($numeroG, $numero, $gruposSocial)";

	}

	//echo $sqlActores;

	//$j=sizeof($n); // Saber el tamaño de un arreglo

	//$sql="INSERT into tbl_pruebas (depto) values ('$j')";

	pg_close($conexion->cerrarConexion());
	    

}else{
	header('location:../index.php');
}

?>
