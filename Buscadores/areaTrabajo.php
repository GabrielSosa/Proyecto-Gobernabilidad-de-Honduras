<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();

$sql= "SELECT id_area_trabajo, area_trabajo FROM cat_area_trabajo ORDER BY area_trabajo ASC";
$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_area_trabajo']. '">' . $row['area_trabajo'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>