<?php
class Conexion{
	private $conect;

	public function getConexion(){
			$cadena="host='localhost' port='5432' dbname='actoreslocales' user='postgres' password='postgres'";//permisos.MP
			$conect= pg_connect($cadena) or die("ERROR EN LA CONEXION :( ");

			if(!$conect){ 
				echo 'fallo la conexion';
				exit;
			}
			else{
				//echo 'conexion exitosa';
			}

			return $conect;
		}
	
	/* cerrar conexión */
	public function cerrarConexion(){
		return $this->conect;
	}
	
}
?>