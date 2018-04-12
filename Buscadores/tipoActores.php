<?php
require_once "../Backend/conexion.php";
$conexion= new conexion(); 

$id_actor = json_decode($_POST['data']);
//$id_actor = $_POST['id_actor'];
//echo var_dump($id_actor);
$posicion = count($id_actor);
$contador = 1;

$sql = "SELECT * FROM sub_cat_tipo_actor WHERE ";

foreach ($id_actor as $actor) {
	
	$sql .= " id_tipo_actor = '".$actor."' ";
	
	if ($posicion!=$contador) {
		$sql .= " OR ";
	}

	$contador++;

}

$sql .= " ORDER BY tipo_actores ASC ";

//$sql= 'SELECT * FROM sub_cat_tipo_actor WHERE id_tipo_actor = 3 ORDER BY tipo_actores ASC ';
$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_tipo_actores']. '">' . $row['tipo_actores'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());


?>