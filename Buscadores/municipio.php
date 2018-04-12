<?php

session_start();

if(!isset($_SESSION['usuario'])){
    header('location:index.php');
}
$usuario = rtrim($_SESSION['usuario']);

require_once "../Backend/conexion.php";
$conexion= new conexion();

$id_depto = $_POST['id_depto'];

$sql= "SELECT distinct(municipios.id_municipio), municipios.municipio, municipios.id_departamento, municipios.seleccionado
		FROM cat_usuario_municipio INNER JOIN municipios ON municipios.id_municipio = cat_usuario_municipio.id_municipio
	    	WHERE usuario = '$usuario' AND municipios.id_departamento = $id_depto AND municipios.seleccionado=true";

$result = pg_query($conexion->getConexion(),$sql);

echo '<option value="0">Seleccionar</option>';

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_municipio']. '">' . $row['municipio'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>
