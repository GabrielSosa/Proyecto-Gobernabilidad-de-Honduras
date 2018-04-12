<?php 

session_start();
if($_POST and isset($_SESSION['usuario'])){
	require_once 'conexion.php';
	$conexion= new conexion();

	$output = array('success' => false, 'messages' => array());

	$memberId = $_POST['member_id'];

	$sql = "DELETE FROM tbl_usuarios WHERE usuario = '$memberId' ";
	$query =pg_query($conexion->getConexion(),$sql);

	$usuario = rtrim($memberId);
	$sqlCatMuni = " DELETE FROM cat_usuario_municipio WHERE usuario = '$usuario' ";
	$queryCatMuni =pg_query($conexion->getConexion(),$sqlCatMuni);



	if($query == TRUE and $queryCatMuni == TRUE) {
		$output['success'] = true;
		$output['messages'] = 'Removido correctamente';
	} else {
		$output['success'] = false;
		$output['messages'] = 'Error al Eliminar información';
	}

	// close database connection

	echo json_encode($output);
    
}else{
	header('location:../index.php');
}



