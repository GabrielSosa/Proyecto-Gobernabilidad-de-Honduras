<?php
require_once "../Backend/conexion.php";
$conexion= new conexion();

$id_actor = $_POST['id_actor'];

$sql= "SELECT * FROM sub_cat_tipo_actor WHERE id_tipo_actor = ".$id_actor." ";

$result = pg_query($conexion->getConexion(),$sql); 

while ( $row = pg_fetch_assoc($result))
{
  if(isset($_POST['id']))
   {
	  	if($_POST['id']==$row['id_tipo_actores'])
	  	 {
		  	echo $_POST['id'];
		  	echo '<option value="' . $row['id_tipo_actores']. '"selected>' . $row['tipo_actores'] . '</option>' ;
		 }
		else
		 {
		  	echo '<option value="' . $row['id_tipo_actores']. '">' . $row['tipo_actores'] . '</option>' ;
		 }	  	
	}
   else
    {
	  echo '<option value="' . $row['id_tipo_actores']. '">' . $row['tipo_actores'] . '</option>' ;
    }
  
}

pg_close($conexion->cerrarConexion());

?>
