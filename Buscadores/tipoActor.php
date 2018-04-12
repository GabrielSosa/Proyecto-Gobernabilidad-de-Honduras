<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();
$sql= "SELECT id_tipo_actor, tipo_actor FROM cat_tipo_actor ORDER BY tipo_actor ASC";
$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_tipo_actor']. '">' . $row['tipo_actor'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>
