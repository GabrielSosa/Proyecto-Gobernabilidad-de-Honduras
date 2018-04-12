<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();

$sql= "SELECT id_area_asistencia_tecnica, area_asistencia_tecnica FROM cat_areas_asistencia_tecnica";
$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_area_asistencia_tecnica']. '">' . $row['area_asistencia_tecnica'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>