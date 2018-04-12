<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();

$sql= "SELECT id_grupo_social, grupo_social FROM cat_grupo_social";
$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_grupo_social']. '">' . $row['grupo_social'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>