<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();

$sql= "SELECT * FROM departamentos WHERE seleccionado = true";
$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_departamento']. '">' . $row['departamento'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>
