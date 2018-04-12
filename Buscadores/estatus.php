<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();

$sql= "SELECT id_estatus, estatus FROM cat_estatus";
$result = pg_query($conexion->getConexion(),$sql); 

echo '<option value="0">SELECCIONAR</option>';

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_estatus']. '">' . $row['estatus'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>
