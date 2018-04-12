<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();

$id_depto = json_decode($_POST['data']);
$posicion = count($id_depto);
$contador = 1; 


$sql = "SELECT id_municipio, municipio, id_departamento, seleccionado FROM municipios WHERE ";

foreach ($id_depto as $depto) {
	
	$sql .= " id_departamento = '".$depto."' AND seleccionado = true ";
	
	if ($posicion!=$contador) {
		$sql .= " OR ";
	}

	$contador++;

}

$sql .= " ORDER BY municipio ASC ";

$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  echo '<option value="' . $row['id_municipio']."/".$row['id_departamento'].'">' . $row['municipio'] . '</option>' ;
}

pg_close($conexion->cerrarConexion());

?>
