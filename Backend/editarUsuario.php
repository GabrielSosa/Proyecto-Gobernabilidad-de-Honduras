<?php 

require_once 'conexion.php';
$conexion= new conexion();
//if form is submitted
session_start();

if($_POST and isset($_SESSION['usuario'])) {	

	$validator = array('success' => false, 'messages' => array());

	$nombreUsuario = $_POST['nombreUsuario'];
	$nombreCompleto = $_POST['nombreCompleto'];
	$contresenia = $_POST['contresenia'];
	$areaDepto = $_POST['areaDepto'];
	$areaMuni = $_POST['areaMuni'];
	
	if(isset($_POST['privilegios'])){
		$privilegios = $_POST['privilegios'];
			$FinalUsuario = rtrim($nombreUsuario);

	if($usuarios != $FinalUsuario){

		for ($j=0;$j<count($areaMuni);$j++)    
		{ 
			list($municipio, $Departamento) = explode('/', $areaMuni[$j]);
			$sqlCatMuni = "INSERT INTO cat_usuario_municipio(usuario, id_departamento, id_municipio)
					VALUES ('$nombreUsuario', $Departamento, $municipio)";

			$resultCatMUni =pg_query($conexion->getConexion(),$sqlCatMuni);	
		} 
		    

			$sql = "INSERT INTO tbl_usuarios(usuario, contrasenia, nombrecompleto, privilegios) VALUES ('$nombreUsuario', '$contresenia', '$nombreCompleto','$privilegios')";

			$result = pg_query($conexion->getConexion(),$sql);

			//$result = true;
	}else{
		     $result = false;
	}

		if($result == true) {			
		$validator['success'] = true;
		$validator['messages'] = "Usuario añadido satifactoriamente";		
	} else {		
		$validator['success'] = false;
		$validator['messages'] = "Error al añadir información";
	}

	// close the database connection

	echo json_encode($validator);


	}
	
}

?>