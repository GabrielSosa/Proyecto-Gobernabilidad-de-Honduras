<?php

session_start();

if(isset($_SESSION['usuario'])){
 	
 	require_once "../Backend/conexion.php";
	$conexion= new conexion();

	$usuario = rtrim($_SESSION['usuario']);

	$sql= "SELECT departamentos.id_departamento, departamentos.departamento, departamentos.seleccionado 
			FROM departamentos INNER JOIN cat_usuario_municipio ON departamentos.id_departamento = cat_usuario_municipio.id_departamento
	    	WHERE usuario = '$usuario' group by departamentos.id_departamento order by departamentos.id_departamento asc";

	$result = pg_query($conexion->getConexion(),$sql); 

	echo '<option value="0">SELECCIONAR</option>';

	while ( $row = pg_fetch_assoc($result))
	{
	  echo '<option value="' . $row['id_departamento']. '">' . $row['departamento'] . '</option>' ;
	}

	pg_close($conexion->cerrarConexion());

}
else{

	header('location:../index.php');
}



?>
