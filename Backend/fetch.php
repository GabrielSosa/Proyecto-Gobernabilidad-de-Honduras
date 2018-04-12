<?php
session_start();

if($_POST and isset($_SESSION['usuario']) ){
  
$usuario = rtrim($_SESSION['usuario']);
//fetch.php
$cadena = "host='localhost' port='5432' dbname='actoreslocales' user='postgres' password='postgres'";
$connect = pg_connect($cadena) or die("ERROR EN LA CONEXION :( ");
pg_set_client_encoding($connect,'utf8');

$column = array("actores_locales.id_actor_local", " actores_locales.nombre_institucion_organizacion", "contactos.nombre_contacto", "product.price", "contactos.correo_electronico", "contactos.telefono_celular", "cat_area_trabajo.area_trabajo"); 
$query = "
SELECT departamentos.id_departamento, municipios.id_municipio, cat_tipo_actor.id_tipo_actor, sub_cat_tipo_actor.id_tipo_actores, 
actores_locales.id_actor_local, contactos.id_contacto, cat_area_trabajo.id_area_trabajo, actores_locales.nombre_institucion_organizacion, 
contactos.nombre_contacto, contactos.correo_electronico, contactos.telefono_celular, contactos.cargo, cat_area_trabajo.area_trabajo
FROM cat_area_trabajo INNER JOIN (((cat_tipo_actor INNER JOIN sub_cat_tipo_actor ON cat_tipo_actor.id_tipo_actor = sub_cat_tipo_actor.id_tipo_actor) 
                                   INNER JOIN ((departamentos INNER JOIN municipios on departamentos.id_departamento = municipios.id_departamento) 
                                               INNER JOIN(actores_locales INNER JOIN contactos ON actores_locales.id_actor_local = contactos.id_actor_local) 
                                               ON (municipios.id_municipio = actores_locales.id_municipio) AND (municipios.id_departamento = actores_locales.id_departamento)) 
                                   ON (sub_cat_tipo_actor.id_tipo_actor = actores_locales.id_tipo_actor) AND (sub_cat_tipo_actor.id_tipo_actores = actores_locales.id_tipo_actores)) 
                                  INNER JOIN areas_trabajo_actor on actores_locales.id_actor_local = areas_trabajo_actor.id_actor_local) 
                                  ON cat_area_trabajo.id_area_trabajo = areas_trabajo_actor.id_area_trabajo
";
$query .= " WHERE actores_locales.id_departamento in (SELECT id_departamento FROM cat_usuario_municipio WHERE usuario ='$usuario') 
                                    AND actores_locales.id_municipio in (SELECT id_municipio FROM cat_usuario_municipio WHERE usuario ='$usuario') AND  ";

if(isset($_POST["id_depto"]))
{
 $query .= " departamentos.id_departamento  = '".$_POST["id_depto"]."' AND ";
 if(isset($_POST["muni"]) && $_POST["muni"]!=0)
  {
   $query .= " municipios.id_municipio = '".$_POST["muni"]."' AND ";
    $id_actor = json_decode($_POST['actor']);
    $posicion = count($id_actor);

    $id_actores = json_decode($_POST['actores']);
    $posicionActores = count($id_actores);

    $id_area = json_decode($_POST['area']);
    $posicionArea = count($id_area);
    
   // echo var_dump($id_area);
     //Evalua si hay actores
     if ($posicion!=0) { 
          $contador = 1;
          $query .= " ( ";
          foreach ($id_actor as $valor) { 
            $query .= " cat_tipo_actor.id_tipo_actor = '".$valor."'  ";
             if ($posicion!=$contador) {
                $query .= " OR ";
              }else{
                 $query .= ") AND ";                
              }

             $contador++;
          }      
      }
     if ($posicionActores!=0) { 
          $contadorActores = 1;
          $query .= " ( ";
          foreach ($id_actores as $valores) { 
            $query .= " sub_cat_tipo_actor.id_tipo_actores = '".$valores."'  ";
             if ($posicionActores!=$contadorActores) {
                $query .= " OR ";
              }else{
                 $query .= ") AND ";                
              }

             $contadorActores++;
          }
     }

     if ($posicionArea!=0) { 
          $contadorArea = 1;
          $query .= " ( ";
          foreach ($id_area as $valoresArea) { 
            $query .= " cat_area_trabajo.id_area_trabajo = '".$valoresArea."'  ";
             if ($posicionArea!=$contadorArea) {
                $query .= " OR ";
              }else{
                 $query .= ") AND ";                
              }

             $contadorArea++;
          }
     }
}
}
if(isset($_POST["search"]["value"]))
{
 $query .= "(actores_locales.nombre_institucion_organizacion LIKE '%".$_POST["search"]["value"]."%' ";
 $query .= "OR contactos.nombre_contacto LIKE '%".$_POST["search"]["value"]."%' ";
 $query .= "OR contactos.correo_electronico LIKE '%".$_POST["search"]["value"]."%' ";
 $query .= "OR contactos.telefono_celular LIKE '%".$_POST["search"]["value"]."%') ";
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';

}
else
{
 $query .= 'ORDER BY actores_locales.id_actor_local DESC ';
}

//echo $query;

$query1 = '';

if($_POST["length"] != 1)
{
  $query1 .= 'LIMIT ' . $_POST['length'] . 'OFFSET ' . $_POST['start'];
}

$number_filter_row = pg_num_rows(pg_query($connect, $query));

$result = pg_query($connect, $query . $query1);

$data = array();

while($row = pg_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = $row["id_actor_local"];
 $sub_array[] = $row["nombre_institucion_organizacion"];
 $sub_array[] = $row["nombre_contacto"];
 $sub_array[] = $row["telefono_celular"];
 $sub_array[] = $row["correo_electronico"];
 $sub_array[] = $row["area_trabajo"];
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM actores_locales";
 $result = pg_query($connect, $query);
 return pg_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output, JSON_UNESCAPED_UNICODE);
//echo $query;

pg_close($connect);

}else{
  header('location:../index.php');
}

?>