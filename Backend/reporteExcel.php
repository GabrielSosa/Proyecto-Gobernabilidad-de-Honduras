<?php	

session_start();
if($_POST and isset($_SESSION['usuario'])){
 	//Incluimos librería y archivo de conexión
	require '../librerias/PHPExcel.php';
	$cadena = "host='localhost' port='5432' dbname='actoreslocales' user='postgres' password='postgres'";
	$connect = pg_connect($cadena) or die("ERROR EN LA CONEXION :( ");
	pg_set_client_encoding($connect,'utf8');

    $depto=$_POST['depto'];
	//Consulta
	$sql = "SELECT departamentos.id_departamento, municipios.id_municipio, cat_tipo_actor.id_tipo_actor, sub_cat_tipo_actor.id_tipo_actores, 
actores_locales.id_actor_local, contactos.id_contacto, cat_area_trabajo.id_area_trabajo, actores_locales.nombre_institucion_organizacion, 
contactos.nombre_contacto, contactos.correo_electronico, contactos.telefono_celular, contactos.cargo, cat_area_trabajo.area_trabajo
FROM cat_area_trabajo INNER JOIN (((cat_tipo_actor INNER JOIN sub_cat_tipo_actor ON cat_tipo_actor.id_tipo_actor = sub_cat_tipo_actor.id_tipo_actor) 
                                   INNER JOIN ((departamentos INNER JOIN municipios on departamentos.id_departamento = municipios.id_departamento) 
                                               INNER JOIN(actores_locales INNER JOIN contactos ON actores_locales.id_actor_local = contactos.id_actor_local) 
                                               ON (municipios.id_municipio = actores_locales.id_municipio) AND (municipios.id_departamento = actores_locales.id_departamento)) 
                                   ON (sub_cat_tipo_actor.id_tipo_actor = actores_locales.id_tipo_actor) AND (sub_cat_tipo_actor.id_tipo_actores = actores_locales.id_tipo_actores)) 
                                  INNER JOIN areas_trabajo_actor on actores_locales.id_actor_local = areas_trabajo_actor.id_actor_local) 
                                  ON cat_area_trabajo.id_area_trabajo = areas_trabajo_actor.id_area_trabajo ";

    if(isset($_POST['depto'])  && $_POST['depto'] !=0){
    	$sql .= " WHERE departamentos.id_departamento  = '".$_POST["depto"]."' ";
    	if(isset($_POST['municipio']) && $_POST['municipio'] !=0){
			$sql .= " AND municipios.id_municipio = '".$_POST["municipio"]."' ";
		   	

		   	if(isset($_POST['actor'])){ 
			    $id_actor = json_decode($_POST['actor']);
			    $posicion = count($id_actor);
			    //echo $posicion;
			}
			else{
				$posicion = 0;
			}

			if(isset($_POST['actores'])){ 
			    $id_actores = json_decode($_POST['actores']);
		    	$posicionActores = count($id_actores);
			}
			else{
				$posicionActores = 0;
			}
		    
			if(isset($_POST['area'])){ 
			    $id_area = json_decode($_POST['area']);
		    	$posicionArea = count($id_area);
			}
			else{
				$posicionArea = 0;
			}

		    
		    
		   // echo var_dump($id_area);
		     //Evalua si hay actores
		     if ($posicion!=0) { 
		          $contador = 1;
		          $sql .= " AND ( ";
		          foreach ($id_actor as $valor) { 
		            $sql .= " cat_tipo_actor.id_tipo_actor = '".$valor."'  ";
		             if ($posicion!=$contador) {
		                $sql .= " OR ";
		              }else{
		                 $sql .= ") ";                
		              }

		             $contador++;
		          }      
		      }
		     if ($posicionActores!=0) { 
		          $contadorActores = 1;
		          $sql .= " AND ( ";
		          foreach ($id_actores as $valores) { 
		            $sql .= " sub_cat_tipo_actor.id_tipo_actores = '".$valores."'  ";
		             if ($posicionActores!=$contadorActores) {
		                $sql .= " OR ";
		              }else{
		                 $sql .= ")  ";                
		              }

		             $contadorActores++;
		          }
		     }

		     if ($posicionArea!=0) { 
		          $contadorArea = 1;
		          $sql .= " AND ( ";
		          foreach ($id_area as $valoresArea) { 
		            $sql .= " cat_area_trabajo.id_area_trabajo = '".$valoresArea."'  ";
		             if ($posicionArea!=$contadorArea) {
		                $sql .= " OR ";
		              }else{
		                 $sql .= ") ";                
		              }

		             $contadorArea++;
		          }
		     }
		}
    }
 
  //echo $sql;

	$resultado = pg_query($connect, $sql);
	$fila = $_POST['fila']; //Establecemos en que fila inciara a imprimir los datos

	
	//Objeto de PHPExcel
	$objPHPExcel  = new PHPExcel();
	
	//Propiedades de Documento
	$objPHPExcel->getProperties()->setCreator("USAID")->setDescription("Listado de actores locales");
	
	//Establecemos la pestaña activa y nombre a la pestaña
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setTitle("Actores Locales");
	
	
	$estiloTituloReporte = array(
    'font' => array(
	'name'      => 'Arial',
	'bold'      => true,
	'italic'    => false,
	'strike'    => false,
	'size' =>15
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_NONE
	)
    ),
    'alignment' => array(
	'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloTituloColumnas = array(
    'font' => array(
	'name'  => 'Arial',
	'bold'  => true,
	'size' =>10,
	'color' => array(
	'rgb' => 'FFFFFF'
	)
    ),
    'fill' => array(
	'type' => PHPExcel_Style_Fill::FILL_SOLID,
	'color' => array('rgb' => '538DD5')
    ),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
    'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	);
	
	$estiloInformacion = new PHPExcel_Style();
	$estiloInformacion->applyFromArray( array(
    'font' => array(
	'name'  => 'Arial',
	'color' => array(
	'rgb' => '000000'
	)
    ),
    'fill' => array(
	'type'  => PHPExcel_Style_Fill::FILL_SOLID
	),
    'borders' => array(
	'allborders' => array(
	'style' => PHPExcel_Style_Border::BORDER_THIN
	)
    ),
	'alignment' =>  array(
	'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
	'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
    )
	));
	
	$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->applyFromArray($estiloTituloReporte);
	$objPHPExcel->getActiveSheet()->getStyle('A6:F6')->applyFromArray($estiloTituloColumnas);
	
	$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Actores locales');
	$objPHPExcel->getActiveSheet()->mergeCells('B3:E3');
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'ID');
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
	$objPHPExcel->getActiveSheet()->setCellValue('B6', 'INSTITUCIÓN');
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(37);
	$objPHPExcel->getActiveSheet()->setCellValue('C6', 'CONTACTO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(12);
	$objPHPExcel->getActiveSheet()->setCellValue('D6', 'TELEFONO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(38);
	$objPHPExcel->getActiveSheet()->setCellValue('E6', 'CORREO ELECTRONICO');
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(27);
	$objPHPExcel->getActiveSheet()->setCellValue('F6', 'AREA TRABAJO');
	
	//Recorremos los resultados de la consulta y los imprimimos
	while($rows = pg_fetch_assoc($resultado)){
		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$fila, $rows['id_actor_local']);
		$objPHPExcel->getActiveSheet()->setCellValue('B'.$fila, $rows['nombre_institucion_organizacion']);
		$objPHPExcel->getActiveSheet()->setCellValue('C'.$fila, $rows['nombre_contacto']);
		$objPHPExcel->getActiveSheet()->setCellValue('D'.$fila, $rows['telefono_celular']);
		$objPHPExcel->getActiveSheet()->setCellValue('E'.$fila, $rows['correo_electronico']);
		$objPHPExcel->getActiveSheet()->setCellValue('F'.$fila, $rows['area_trabajo']);
		
		$fila++; //Sumamos 1 para pasar a la siguiente fila
	}
	
	
	
	$writer = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	
	
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header('Content-Disposition: attachment;filename="ActoresLocales.xlsx"');
	header('Cache-Control: max-age=0');
	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	ob_start();
	$objWriter->save("php://output");
	$xlsData = ob_get_contents();
	ob_end_clean();

	$response =  array(
	        'op' => 'ok',
	        'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
	    );

	die(json_encode($response));
	   
}else{
	header('location:../index.php');
}
	

?>