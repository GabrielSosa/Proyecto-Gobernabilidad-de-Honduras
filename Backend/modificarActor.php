<?php

session_start();
if($_POST and isset($_SESSION['usuario'])){
    
    require_once "../Backend/conexion.php";
    $conexion= new conexion();

        $id_actor_local = $_POST['id_actor_local'];
        $tipoActor = $_POST['tipoActor']; 
        $tipoActores = $_POST['tipoActores'];
        $nombre = $_POST['nombre'];
        $contacto = $_POST['contacto'];
        $x = $_POST['x'];
        $y = $_POST['y'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];


    $sql = "UPDATE actores_locales  
            SET  id_tipo_actor = ".$tipoActor." ,id_tipo_actores = ".$tipoActores.", nombre_institucion_organizacion = '".$nombre."' , 
                ide_geografica_coor_latitude = ".$x." , ide_geografica_coor_longitude = ".$y."
            WHERE  id_actor_local = ".$id_actor_local." ";

    $sql2 = " UPDATE contactos 
              SET  nombre_contacto =  '".$contacto."', telefono_celular = '".$telefono."', correo_electronico = '".$correo."'
              WHERE  id_actor_local = ".$id_actor_local." ";



     pg_query($conexion->getConexion(),$sql); 
     pg_query($conexion->getConexion(),$sql2); 

     pg_close($conexion->cerrarConexion());

}else{
    header('location:../index.php');
}

?>