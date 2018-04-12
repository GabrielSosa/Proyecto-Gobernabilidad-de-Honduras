$(document).ready(function(){
	
  $('#informacion').load('PantallaIngreso/informacion.php');
	$('#apoyo').load('PantallaIngreso/apoyo.php');
	$('#tablaProyectos').load('Backend/tablaProyectos.php');
	$('#areasInfluencia').load('PantallaIngreso/areasInfluencia.php');
	$('#gruposSociales').load('PantallaIngreso/gruposSociales.php');
	$('#panelAuditoria').hide();
	$('#panelAdopcion').hide();
	$('#auditoriasSociales').load('PantallaIngreso/auditoriasSociales.php');
	$('#adopcion').load('PantallaIngreso/adopcion.php');

}); 

$( "#guardarTodo").click(function()
	{
		
    
		agregarTodo({
		 depto: $("#depto option:selected").val(),
		 municipio: $("#municipio option:selected").val(),
		 nombreOrg: $("#nombreOrg").val(),
		 X: $("#X").val(),
		 Y: $("#Y").val(),
		 tipoOrg: $("#tipoOrg").val(),
     tipoActoresLocales: $("#tipoActoresLocales option:selected").val(),
		 nivelTerri: $("#nivelTerri").val(),
		 personeria: $("#personeria").val(),
		 objetivo: $("#objetivo").val(),
		 areas:verAreas(), //areas de influencia
     proyectos: verProyectos(), // proyectos
     areaTematica : $("#areaTematica option:selected").val(),
     apoyoLocal : $("#areaTrabajo option:selected").val(), //Esto es lo mismo que id_area_trabajo
     areaTecnica : $("#areaTecnica option:selected").val(),
     gruposSocial: $("#grupoSocial option:selected").text(),
     areaApoyo : $("#areaApoyo").val(), //Esta opcion es de grupos sociales
     adopcion : verAdopcion(), 
     auditoriaSocial : verAuditoria()
		});

	});


$( "#gruposSociales").click(function()
	{
			
			if($( "#opcionsi" ).is(':checked')){
				$('#panelAuditoria').show();
				$('#panelAdopcion').hide();
			}
			if($( "#opcionno" ).is(':checked')){
				$('#panelAuditoria').hide();
				$('#panelAdopcion').show();
			}
	});


 function agregarTodo(datos){
  
  if(verificacion(datos)=='Creado con exito')
  {
    $.ajax({
      type:"POST",
      url:"Backend/crearNuevo.php",
      data:datos,
      success:function(r)
      {
        if(r!='')
        {
          //location.href="nuevo.php";
          LimpiarTodo();
          alertify.success('Creado con exito');
        }
        else
        { 
          alertify.error("Fallo el servidor :(");
         
        }
      }

    });
  }
  else
  {
    alertify.error(verificacion(datos));
  }
 	
 }

/*++++++++++++++++++++++++++++++++++++++++

		Tabla de proyectos

+++++++++++++++++++++++++++++++++++++++++++*/

function agregardatos(data){
	return (
    `<tr>` +
      `<td>${data.nombre}</td>` +
      `<td>${data.monto}</td>` +
      `<td>${data.bene}</td>` +
       `<td>${data.rol}</td>` +
    `</tr>`
  );
}

function limpiarTabla(){
		      $('#nombreProyecto').val("");
          $('#monto').val("");
          $('#beneficiarios').val("");
          $('#rol').val("");
}

function verProyectos()
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
        return (array);

    }
/*++++++++++++++++++++++++++++++++++++++++

		Areas de influencia

+++++++++++++++++++++++++++++++++++++++++++*/

function areadatos(areaIn){
	return (
    `<tr>` +
      `<td>${areaIn.areaDepto}</td>` +
      `<td>${areaIn.areaMuni}</td>` +
       `<td>${areaIn.areaComu}</td>` +
    `</tr>`
  );
}

function limpiarAreas(){
		      $('#areaDepto').val("");
          $('#areaMuni').val("");
          $('#areaComu').val("");
}

function verAreas()
    {
      var array = [];
        /* Obtenemos todos los tr del Body*/
        var rowsBody= $("#tablaA").find('tbody > tr');
        /* Obtenemos todos los th del Thead */
        var rowsHead= $("#tablaA").find('thead > tr > th');
        
        /* Iteramos sobre as filas del tbody*/
        for (var i = 0; i < rowsBody.length; i++) {
            var obj={};/* auxiliar*/
            for (var j = 0;j < rowsHead.length;j++) /*  Iteramos sobre los th de THead*/
                /*Asignamos como clave el text del th del thead*/
                 /*Asignamos como Valor el text del tr del tbody*/
                obj[rowsHead[j].innerText] =  rowsBody[i].getElementsByTagName('td')[j].innerText;
            array.push(obj);/* Añadimos al Array Principal*/

        }
        return (array);

    }

/*++++++++++++++++++++++++++++++++++++++++

		Areas de auditorias Sociales

+++++++++++++++++++++++++++++++++++++++++++*/

function agregarAuditoria(auditoria){
	return (
    `<tr>` +
      `<td>${auditoria.anio}</td>` +
      `<td>${auditoria.mes}</td>` +
      `<td>${auditoria.tema}</td>` +
      `<td>${auditoria.organizacion}</td>` +
       `<td>${auditoria.servicio}</td>` +
       `<td>${auditoria.detalle}</td>` +
       `<td>${auditoria.Nrecomendadionces}</td>` +
       `<td>${auditoria.fechaInicio}</td>` +
    `</tr>`

  );
}

function limpiarAuditorias(){
		      $('#anio').val("");
          $('#mes').val("");
          $('#tema').val("");
          $('#organizacion').val("");
          $('#servicio').val("");
          $('#detalle').val("");
          $('#Nrecomendadionces').val("");
          $('#fechaInicio').val("");
}

function verAuditoria()
    {
      var array = [];
        /* Obtenemos todos los tr del Body*/
        var rowsBody= $("#tablaAuditoria").find('tbody > tr');
        /* Obtenemos todos los th del Thead */
        var rowsHead= $("#tablaAuditoria").find('thead > tr > th');
        
        /* Iteramos sobre as filas del tbody*/
        for (var i = 0; i < rowsBody.length; i++) {
            var obj={};/* auxiliar*/
            for (var j = 0;j < rowsHead.length;j++) /*  Iteramos sobre los th de THead*/
                /*Asignamos como clave el text del th del thead*/
                 /*Asignamos como Valor el text del tr del tbody*/
                obj[rowsHead[j].innerText] =  rowsBody[i].getElementsByTagName('td')[j].innerText;
            array.push(obj);/* Añadimos al Array Principal*/

        }
        return (array);

    }


/*++++++++++++++++++++++++++++++++++++++++

		Adopcion, implementacion etc

+++++++++++++++++++++++++++++++++++++++++++*/

function agregarAdopcion(adopcion){
	return (
    `<tr>` +
      `<td>${adopcion.politica}</td>` +
      `<td>${adopcion.fechaPolitica}</td>` +
       `<td>${adopcion.estatus}</td>` +
       `<td>${adopcion.servicioAuditoria}</td>` +
    `</tr>`

  );
}

function limpiarAdopcion(){
		      $('#politica').val("");
          $('#fechaPolitica').val("");
          $('#estatus').val("");
          $('#servicioAuditoria').val("");
}

function verAdopcion()
    {
      var array = [];
        /* Obtenemos todos los tr del Body*/
        var rowsBody= $("#tablaAdopcion").find('tbody > tr');
        /* Obtenemos todos los th del Thead */
        var rowsHead= $("#tablaAdopcion").find('thead > tr > th');
        
        /* Iteramos sobre as filas del tbody*/
        for (var i = 0; i < rowsBody.length; i++) {
            var obj={};/* auxiliar*/
            for (var j = 0;j < rowsHead.length;j++) /*  Iteramos sobre los th de THead*/
                /*Asignamos como clave el text del th del thead*/
                 /*Asignamos como Valor el text del tr del tbody*/
                obj[rowsHead[j].innerText] =  rowsBody[i].getElementsByTagName('td')[j].innerText;
            array.push(obj);/* Añadimos al Array Principal*/

        }
        return (array);

    }

function verificacion(datos) {

  var decimal=   /^(-{1}?(?:([0-9]{0,10}))|([0-9]{1})?(?:([0-9]{0,9})))?(?:\.([0-9]{0,20}))?$/; 
  var nombre = /^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;

  if(datos.depto==0)
    {
      return 'Falta departamentos';
    }
  else if(datos.municipio==0)
    {
      return 'Falta municipios';
    }
  else if( !nombre.exec(datos.nombreOrg) ||datos.nombreOrg=='')
    {
      return 'Falta el nombre la organizacion o esta mal escrito ';
    }
  else if( !decimal.exec(datos.X) || (datos.X=='') )
    {
      return 'Hay un error con la X';
    }
  else if( !decimal.exec(datos.Y) || (datos.Y=='') )
    {
      return 'Hay un error con la Y';
    }  
  else if( datos.tipoOrg==0 )
    {
      return 'Falta tipo de Organizacion';
    }  
  else if(datos.tipoActoresLocales==0)
  {
     return 'Falta actores locales ';
  }
  else if( !nombre.exec(datos.objetivo) ||datos.objetivo=='')
    {
      return 'Falta el objetivo de la organizacion o esta mal escrito ';
    }
  else if(datos.areaTematica==0)
    {
      return 'Falta area Tematica';
    } 
  else if(datos.areaTecnica==null)
    {
      return 'Falta area Tecnica';
    } 
  else if(datos.apoyoLocal==null)
    {
      return 'Falta apoyo local';
    } 
  else if(datos.proyectos=='')
    {
      return 'Falta proyectos en los que participa';
    } 
  else if(datos.areas=='')
    {
      return 'Falta areas de influencia';
    } 
  else if(datos.gruposSocial=='')
    {
      return 'Falta los grupos Sociales ';
    } 
  else if( !nombre.exec(datos.areaApoyo) ||datos.areaApoyo=='')
    {
      return 'Falta el area de apoyo o esta mal escrito';
    }  
  else
    {
      return 'Creado con exito';
    }

}

function LimpiarTodo(){
  $('#informacion').load('PantallaIngreso/informacion.php');
  $('#apoyo').load('PantallaIngreso/apoyo.php');
  $('#tablaProyectos').load('Backend/tablaProyectos.php');
  $('#areasInfluencia').load('PantallaIngreso/areasInfluencia.php');
  $('#gruposSociales').load('PantallaIngreso/gruposSociales.php');
  $('#panelAuditoria').hide();
  $('#panelAdopcion').hide();
  $('#auditoriasSociales').load('PantallaIngreso/auditoriasSociales.php');
  $('#adopcion').load('PantallaIngreso/adopcion.php');
}