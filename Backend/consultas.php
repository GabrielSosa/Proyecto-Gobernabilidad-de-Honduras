<?php
include('conexion.php');

class consultas extends conexion{
 
	//Busca todas las carreras que coincidan con ese ID
    public function buscarPorDepartamento( $depto )
    {
    	$resultado = array();
        $conexion = new Conexion();
        $sql = "SELECT A.id_proyecto, A.nombre_proyecto, A.descripcion, A.correo FROM tbl_proyectos A INNER JOIN tbl_departamentos B on A.id_departamento= B.id_departamento WHERE departamento = '".$depto."'";

    	$rSQL = mysqli_query($conexion->getConexion(),$sql);
    
    	if($rSQL->num_rows > 0) {
            while ($fila = mysqli_fetch_assoc($rSQL)) {
                $resultado[]= $fila;
            }   

        }
        
    		
    	$conexion->cerrarConexion();
    
    	return $resultado;
    }

    public function Buscar($municipio, $dpto){
        $resultado = array();
        $conexion = new Conexion();
        $sql = "SELECT actores_locales.id_Actor_Local, actores_locales.nombre_institucion_organizacion, contactos.nombre_contacto, 
                contactos.correo_electronico, contactos.telefono_celular 
                FROM actores_locales  INNER JOIN contactos  ON actores_locales.id_actor_local = contactos.id_actor_local 
                INNER JOIN municipios  ON actores_locales.id_municipio = municipios.id_municipio 
                INNER JOIN departamentos ON actores_locales.id_departamento = departamentos.id_departamento WHERE 1=1 ";

        if (strcasecmp($dpto, "seleccionar")!=0){

            $sql = $sql." AND departamentos.departamento LIKE '%$dpto%' ";
        }
                    
        if (strcasecmp($municipio, "seleccionar")!=0){
            $sql = $sql." AND municipios.municipio LIKE '%$municipio%' ";
        }
    
        $rSQL = pg_query($conexion->getConexion(),$sql);
    
        if(pg_num_rows($rSQL) > 0) {
            while ($fila = pg_fetch_assoc($rSQL)) {
                $resultado[]= $fila;
            }   

        }
        
    
        return $resultado;

        $conexion->cerrarConexion();
        
    }

}

?>