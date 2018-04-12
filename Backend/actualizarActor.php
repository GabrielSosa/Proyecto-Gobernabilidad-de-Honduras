<?php
session_start();
if($_POST and isset($_SESSION['usuario'])){
	require_once "../Backend/conexion.php";
	$conexion= new conexion();



	//Obtenemos los datos de los input
	$id = $_POST["id"];

	$sql= 'SELECT actores_locales.id_actor_local, actores_locales.id_tipo_actores, actores_locales.id_tipo_actor, actores_locales.ide_geografica_coor_latitude, 
			actores_locales.ide_geografica_coor_longitude, actores_locales.nombre_institucion_organizacion, contactos.id_contacto, 
	        contactos.nombre_contacto, contactos.telefono_celular, contactos.correo_electronico
		FROM contactos INNER JOIN actores_locales ON actores_locales.id_actor_local = contactos.id_actor_local WHERE actores_locales.id_actor_local = '.$id.' ';
		
	$result = pg_query($conexion->getConexion(),$sql);
	//Hacemos las comprobaciones que sean necesarias... (sanitizar los textos para evitar XSS e inyecciones de código, comprobar que la edad sea un número, etc.)
	//Omitido para la brevededad del código
	//PERO NO OLVIDES QUE ES ALGO IMPORTANTE.

	//Seteamos el header de "content-type" como "JSON" para que jQuery lo reconozca como tal
	header('Content-Type: application/json');
	//Guardamos los datos en un array

	//$conexion->cerrarConexion();

	  while($row = pg_fetch_array($result))
		{
			$sub_array = array();
			$sub_array[] = $row["id_actor_local"];
			$sub_array[] = $row["nombre_institucion_organizacion"];
			$sub_array[] = $row["nombre_contacto"];
			$sub_array[] = $row["ide_geografica_coor_latitude"];
			$sub_array[] = $row["ide_geografica_coor_longitude"];
			$sub_array[] = $row["id_tipo_actor"];
			$sub_array[] = $row["id_tipo_actores"];
			$sub_array[] = $row["telefono_celular"];
			$sub_array[] = $row["correo_electronico"];
			$data[] = $sub_array;
		 
		}

	$datos = array(
			'estado' => 'ok',
			'data' => $data
	);
		
	//Devolvemos el array pasado a JSON como objeto
	echo json_encode($datos, JSON_FORCE_OBJECT);
    
}else{
	header('location:../index.php');
}


?>