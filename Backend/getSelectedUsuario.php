<?php 

session_start();
	
	if($_POST and isset($_SESSION['usuario'])){

	require_once 'conexion.php';
	$conexion= new conexion();

	$memberId = rtrim($_POST['member_id']);

	$sql = "SELECT usuario, nombrecompleto, privilegios, contrasenia FROM tbl_usuarios WHERE usuario = '$memberId'";
	$query =pg_query($conexion->getConexion(),$sql);
	$result = pg_fetch_assoc($query);
	//echo $sql;
	echo json_encode($result);

}else{
	header('location:../index.php');
}



