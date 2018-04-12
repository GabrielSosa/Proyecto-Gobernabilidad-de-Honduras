 $(document).ready(function() {
            Departamentos(); 
            cargarDatos();
            tipoActorModal();
           // $('#n').val("Hola");
          //modificaForm(18113);
         // modificarActor(18113);
    var id_actor_local = 0;     




 ///AQUI SE CARGARAN TODOS LOS DATOS DE LAS TABLAS
function cargarDatos(id_depto, muni, actor,actores,area) {

  var dataTable = $('#tabla').DataTable({
     "processing":true,
     "serverSide":true,
     "order":[],
    // "pageLength": 13885,
     // dom: 'Bfrtip',
     "ajax":{
      url:"Backend/fetch.php",
      type:"POST",
      data:{id_depto:id_depto, muni:muni, actor:actor,actores:actores,area:area}
     },
     "columnDefs":[
      {
       "targets":[2],
       "orderable":false,
       "targets" : "detalle",
       "defaultContent": "<button id='btnDetalle' class = 'btn btn-warning editar' data-toggle='modal' data-target='#modalEdicion'>Editar</button>"

      }
     ],
    });

}

$('#tabla tbody').on( 'click', '[id*=btnDetalle]', function () {
        // var id_actor = '';
         var currentRow=$(this).closest("tr"); 
         id_actor_local=currentRow.find("td:eq(0)").text();
        //  alert(id_actor);
          modificaForm(id_actor_local);
         // modificarActor(id_actor_local);    

    } );

//Evaluar si estan todos los combobox activos
function cargarTabla(){
  
  
  var depto = $('#departamento option:selected').val();
  var municipio = $('#municipio option:selected').val();

  //Seleccionamos el tipo de actor
    var tipoActor = [];
    $('#tipoActor :selected').each(function(i, selected){
      tipoActor[i] = $(selected).val();

    });
     // Lista de actores
     var actor = JSON.stringify(tipoActor); 
    
    var tipoActores = [];
    $('#tipoActores :selected').each(function(i, selected){
      tipoActores[i] = $(selected).val();
    });
    var actores = JSON.stringify(tipoActores);

    //Area de Trabajo
    var areaTrabajo = [];
    $('#areaTrabajo :selected').each(function(i, selected){
      areaTrabajo[i] = $(selected).val();

    });
    var area = JSON.stringify(areaTrabajo);

  $('#tabla').DataTable().destroy();
  if(depto != 0) {
      if (municipio != 0) {
            cargarDatos(depto,municipio,actor,actores,area);   
      }else {
          cargarDatos(depto);
        }
   }else {
       cargarDatos();
   } 
    
}

//Aqui carga todos los Tipo de actores al inicio
function areaTrabajo() {

  $.post( 'Buscadores/areaTrabajo.php' ).done( function(respuesta)
  {
    $( '#areaTrabajo' ).html( respuesta );
  });
}



//Aqui carga todos los Tipo de actor al inicio
function tipoActor() {

  $.post( 'Buscadores/tipoActor.php' ).done( function(respuesta)
  {
    $( '#tipoActor' ).html( respuesta );
  });
}

//Aqui carga todos los Tipo de actor en el Modal
function tipoActorModal() {

  $.post( 'Buscadores/tipoActor.php' ).done( function(respuesta)
  {
    $( '#tipoActorModal' ).html( respuesta );
  });
}
//Aqui carga todos los departamentos al inicio
function Departamentos() {

  $.post( 'Buscadores/departamento.php' ).done( function(respuesta)
  {
    $( '#departamento' ).html( respuesta );
  });
}

$( "#departamento" ).change(function()
  {
    var id_depto = $("#departamento option:selected").val();
    
    // Lista de municipios
    $.post( 'Buscadores/municipio.php', { id_depto: id_depto} ).done( function( respuesta )
    {
      $( '#municipio' ).html( respuesta );
    });
    
    cargarTabla();
  });


$( "#municipio" ).change(function()
  {
    cargarTabla();
    tipoActor();

  });


$( "#tipoActor" ).change(function()
  {
    var tipoActor = [];
    $('#tipoActor :selected').each(function(i, selected){
      tipoActor[i] = $(selected).val();

    });
     // Lista de actores
     var data = JSON.stringify(tipoActor);
    $.post( 'Buscadores/tipoActores.php', { data: data} ).done( function( respuesta )
    {
      $( '#tipoActores' ).html( respuesta );
    });
    cargarTabla();
  });

$( "#tipoActorModal" ).change(function()
  {

    var id_actor = $("#tipoActorModal option:selected").val();
     // Lista de actores
    cargarActoresModal(id_actor);

  });

$( "#tipoActores" ).change(function()
  {

     areaTrabajo();
     cargarTabla();
  });

$( "#areaTrabajo" ).change(function()
  {
  cargarTabla();     
  });

function cargarActoresModal(actor,id){
   
    var id_actor = actor;
     // Lista de actores
    $.post( 'Buscadores/tipoActoresModal.php', { id_actor: id_actor, id:id} ).done( function( respuesta )
    {
      $( '#tipoActoresModal' ).html( respuesta );
    });

  //  $('#tipoActoresModal > option[value="'+id+'"]').attr('selected', 'selected');
}


  
 $('#actualizadatos').click(function() {

    var tipoActor = $("#tipoActorModal").val();
    var tipoActores = $( '#tipoActoresModal' ).val();
    var nombre = $('#n').val();
    var contacto = $('#c').val();
    var x = $('#x').val();
    var y = $('#y').val();
    var correo = $('#correo').val();
    var telefono = $('#telefono').val();
    datos={ nombre: nombre, contacto: contacto, X: x, Y: y,correo: correo,telefono: telefono }
    
    cadena= "id_actor_local=" + id_actor_local +
      "&tipoActor=" + tipoActor +
      "&tipoActores=" + tipoActores + 
      "&nombre=" + nombre +
      "&contacto=" + contacto +
      "&x=" + x +
      "&y=" + y +
      "&correo=" + correo +
      "&telefono=" + telefono ;
    
    if(validar(datos)=='Actualizado con exito'){
      $.ajax({
        type:"POST",
        url:"Backend/modificarActor.php",
        data:cadena,
        success:function(r){
          
          if(r!=''){
            cargarTabla();
            id_actor = "";
            alertify.success("Actualizado con exito");
          }else{
            alertify.error("Fallo el servidor "); 
          }
        }
      });
    }else{
       alertify.error(validar(datos));
    }

    

});

function validar(datos) {
  
  var regCorreo= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  var decimal=   /^(-{1}?(?:([0-9]{0,10}))|([0-9]{1})?(?:([0-9]{0,9})))?(?:\.([0-9]{0,20}))?$/; 
  var telefono = /^[\d]{4}[-]*([\d]{2}[-]*){2}$/;
 // var telofonoGuion = 
 if( !regCorreo.exec(datos.correo)  )
    {
      return 'Correo esta mal escrito';
    }
  else if( datos.nombre=='' )
  {
    return 'El nombre de la Institución no puede ir vacio';
  }
  else if( datos.contacto=='' )
  {
    return 'El nombre del contacto no puede ir vacio';
  }
  else if( !telefono.exec(datos.telefono))
  {
    return 'El nombre del telefono no puede exceder de 8 números y no puede ir vacio';
  }
  else if( !decimal.exec(datos.X)  )
    {
      return 'Hay un error con la X';
    }
  else if( !decimal.exec(datos.Y) )
    {
      return 'Hay un error con la Y';
    }
  else
  {
    return 'Actualizado con exito';
  }

}

function modificaForm(id){
 
  cadena={"id":id};
  $.ajax({
    type:"POST",
    url:"Backend/actualizarActor.php",
    data:cadena
    }).done(function(respuesta){
      if (respuesta.estado === "ok") {

        $('#tipoActorModal > option[value="'+respuesta.data[0][5]+'"]').attr('selected', 'selected');
        cargarActoresModal(respuesta.data[0][5], respuesta.data[0][6]);
       // $('#tipoActoresModal > option[value="'+respuesta.id+'"]').attr('selected', 'selected');
        $('#n').val(respuesta.data[0][1]);
        $('#c').val(respuesta.data[0][2]);
        $('#telefono').val(respuesta.data[0][7]);
        $('#correo').val(respuesta.data[0][8]);
        $('#x').val(respuesta.data[0][3]);
        $('#y').val(respuesta.data[0][4]);
        //console.log(respuesta.data[0][1]);
      }
    });
} 

//Este Boton exporta en excel 
$( '#excelBoton' ).on( 'click', function() {
    
        jsShowWindowLoad('Se esta descargando el archivo');
        depto = $('#departamento option:selected').val();
        municipio = $('#municipio option:selected').val();
        fila =7;

        //Seleccionamos el tipo de actor
          var tipoActor = [];
          $('#tipoActor :selected').each(function(i, selected){
            tipoActor[i] = $(selected).val();

          });
          
           // Lista de actores
           var actor = JSON.stringify(tipoActor); 
           

          var tipoActores = [];
          $('#tipoActores :selected').each(function(i, selected){
            tipoActores[i] = $(selected).val();
          });
          var actores = JSON.stringify(tipoActores);

          //Area de Trabajo
          var areaTrabajo = [];
          $('#areaTrabajo :selected').each(function(i, selected){
            areaTrabajo[i] = $(selected).val();

          });
          var area = JSON.stringify(areaTrabajo);

        console.log(actor);
        cadena = {depto: depto, fila:fila, municipio: municipio, actor: actor, actores: actores, area: area}
        $.ajax({
            type:'POST',
            url:"Backend/reporteExcel.php",
            data: cadena,
            dataType:'json'
        }).done(function(data)
        {
          var $a = $("<a>");
          $a.attr("href",data.file);
          $("body").append($a);
          $a.attr("download","ActoresLocales.xls");
          $a[0].click();
          $a.remove();
          jsRemoveWindowLoad();
        });
        

    });


});

//Animacion para de cargar

function jsRemoveWindowLoad() {
    // eliminamos el div que bloquea pantalla
    $("#WindowLoad").remove();
 
}
 
function jsShowWindowLoad(mensaje) {
    //eliminamos si existe un div ya bloqueando
    jsRemoveWindowLoad();
 
    //si no enviamos mensaje se pondra este por defecto
    if (mensaje === undefined) mensaje = "Procesando la información<br>Espere por favor";
 
    //centrar imagen gif
    height = 20;//El div del titulo, para que se vea mas arriba (H)
    var ancho = 0;
    var alto = 0;
 
    //obtenemos el ancho y alto de la ventana de nuestro navegador, compatible con todos los navegadores
    if (window.innerWidth == undefined) ancho = window.screen.width;
    else ancho = window.innerWidth;
    if (window.innerHeight == undefined) alto = window.screen.height;
    else alto = window.innerHeight;
 
    //operación necesaria para centrar el div que muestra el mensaje
    var heightdivsito = alto/2 - parseInt(height)/2;//Se utiliza en el margen superior, para centrar
 
   //imagen que aparece mientras nuestro div es mostrado y da apariencia de cargando
    imgCentro = "<div style='text-align:center;height:" + alto + "px;'><div  style='color:white;margin-top:" + heightdivsito + "px; font-size:20px;font-weight:bold'>" + mensaje + "</div><img  src='images/load.gif'></div>";
 
        //creamos el div que bloquea grande------------------------------------------
        div = document.createElement("div");
        div.id = "WindowLoad"
        div.style.width = ancho + "px";
        div.style.height = alto + "px";
        $("body").append(div);
 
        //creamos un input text para que el foco se plasme en este y el usuario no pueda escribir en nada de atras
        input = document.createElement("input");
        input.id = "focusInput";
        input.type = "text"
 
        //asignamos el div que bloquea
        $("#WindowLoad").append(input);
 
        //asignamos el foco y ocultamos el input text
        $("#focusInput").focus();
        $("#focusInput").hide();
 
        //centramos el div del texto
        $("#WindowLoad").html(imgCentro);
 
}