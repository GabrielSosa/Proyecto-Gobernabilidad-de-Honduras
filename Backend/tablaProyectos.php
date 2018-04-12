<?php 
	session_start();
	include("conexion.php");
	$conexion= new conexion();

 ?>
<div class="row">
	<div class="col-sm-12">
	<div class="table-responsive">
		<table id="tablaP" class="table table-hover table-condensed table-bordered">
		<caption>
			<button class="btn btn-primary" data-toggle="modal" data-target="#modalNuevo">
				Agregar nuevo 
				<span class="fa fa-plus""></span>
			</button>
			<button class="btn btn-primary" id="eliminar">
				Eliminar
				<span class="fa fa-trash"></span>
			</button>
		</caption>
		<thead>	
			<tr>
				<th>Nombre del Proyecto</th>
				<th>Monto (L.)</th>
				<th>Beneficiarios</th>
				<th>Rol</th>
			</tr>
		</thead>
			<!-- Cuerpo de la tabla con los campos -->
			<tbody>
				
			</tbody>
		</table>
	</div>
	</div>
</div>

	<!-- Modal para registros nuevos -->


<div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega nuevo Proyecto</h4>
      </div>
      <div class="modal-body">
        	<label>Nombre del Proyecto: </label>
        	<input type="text" name="" id="nombreProyecto" class="form-control input-sm">
        	<label>Monto: </label>
        	<input type="text" name="" id="monto" class="form-control input-sm">
        	<label>beneficiarios: </label>
        	<input type="text" name="" id="beneficiarios" class="form-control input-sm">
        	<label>Rol: </label>
        	<input type="text" name="" id="rol" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarProyecto">
        Agregar
        </button>
       
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){

        $("#guardarProyecto").click(function(){
	        
	        datos = 
	        {
	        	nombre: $('#nombreProyecto').val(),
		        monto: $('#monto').val(),
		        bene: $('#beneficiarios').val(),
		        rol: $('#rol').val()
	        }
	         if(verficarProyectos(datos)=='Proyecto Agregado')
	  			{
		 	        const row = agregardatos(datos);
					$("#tablaP tbody:last").append(row);
					limpiarTabla(); 
					alertify.success(verficarProyectos(datos));				
	  			}
	  		 else
	  		   {
	  		   	   alertify.error(verficarProyectos(datos));
	  		   }


		});

		$( "#ver").click(function()
		{
			var array = [];
		    /* Obtenemos todos los tr del Body*/
		    var rowsBody= $("#tablaP").find('tbody > tr');
		    /* Obtenemos todos los th del Thead */
		    var rowsHead= $("#tablaP").find('thead > tr > th');
		    
		    /* Iteramos sobre as filas del tbody*/
		    for (var i = 0; i < rowsBody.length; i++) {
		        var obj={};/* auxiliar*/
		        for (var j = 0;j < rowsHead.length;j++) /*  Iteramos sobre los th de THead*/
		            /*Asignamos como clave el text del th del thead*/
		             /*Asignamos como Valor el text del tr del tbody*/
		            obj[rowsHead[j].innerText] =  rowsBody[i].getElementsByTagName('td')[j].innerText;
		        array.push(obj);/* Añadimos al Array Principal*/

		    }
		    console.log(array);

		});

		$('#eliminar').click(function(){
			$('#tablaP tbody tr').each(function(){
         	$('#tablaP tbody tr').remove();
     	 	});
		});

		function verficarProyectos(datos) {
			var nombreProyecto = /^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;
			var monto = /[-+]?([0-9]*\.[0-9]+|[0-9]+)/;

			if (!nombreProyecto.exec(datos.nombre) ||datos.nombre=='') 
			{
				return 'Falta el nombre del proyecto o esta mal escrito ';
			}
			else if(!monto.exec(datos.monto) ||datos.monto=='')
			{
			   return 'El monto debe ir solo numeros o falta escribir monto ';
			}
			else if(!nombreProyecto.exec(datos.bene) ||datos.bene=='')
			{
			   return 'Falta escribir Beneficios o esta mal escrito ';
			}
			else if(!nombreProyecto.exec(datos.rol) ||datos.bene=='')
			{
			   return 'Falta escribir Rol o esta mal escrito ';
			}
			else
		    {
		      return 'Proyecto Agregado';
		    }
		}

    });
</script>