<?php 

session_start();
if(isset($_SESSION['usuario'])){

	require_once 'conexion.php';
	$conexion= new conexion();

	$output = array('data' => array());

	$sql = "SELECT * FROM tbl_usuarios";
	$result =pg_query($conexion->getConexion(),$sql);



	while ($row = pg_fetch_assoc($result)) {


		$actionButton = '
		<div class="btn-group">
		  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    Acciones <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
		    <li><a type="button" data-toggle="modal" data-target="#editMemberModal" onclick="editMember(\''.$row['usuario'].'\')"> <span class="fa fa-pencil"></span> Editar</a></li>
		    <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeMember(\''.$row['usuario'].'\')"> <span class="fa fa-trash"></span> Remover</a></li>	    
		  </ul>
		</div>
			'; 

		$output['data'][] = array(
			$row['usuario'],
			$row['nombrecompleto'],
			$row['privilegios'],
			$actionButton
		);

	}

	// database connection close
	//pg_close($conexion);

	echo json_encode($output);

}else{
	header('location:../index.php');
}

