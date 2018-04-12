<div class="row">
  <div class="col-xs-12">
  <div class="table-responsive">
    <table id="tablaAdopcion" class="table table-hover table-condensed table-bordered">
    <caption>
      <button class="btn btn-primary" data-toggle="modal" data-target="#modalAdopcion">
        Agregar nuevo 
        <span class="fa fa-plus""></span>
      </button>
      <button class="btn btn-primary" id="eliminarAdopcion">
        Eliminar
        <span class="fa fa-trash"></span>
      </button>
    </caption>
    <thead> 
      <tr>
        <th>Politica / ordenanza</th>
        <th>Fecha de presentación política</th>
        <th>Estatus</th>
        <th>Servicio a mejorar</th>
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


<div class="modal fade" id="modalAdopcion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega nueva Política Ordenanza</h4>
      </div>
      <div class="modal-body">
          <label>Politica / ordenanza:</label>
          <input type="text" id="politica" class="form-control input-sm">
          <label>Fecha de presentación política:</label>
          <input type="text"  id="fechaPolitica" class="form-control input-sm">
          <label>Estatus:</label>
          <select id="estatus" class="form-control">
              <option value="0">Seleccionar</option>
          </select>
          <label>Servicio a mejorar:</label>
          <input type="text" id="servicioAuditoria" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarAdopcion">
        Agregar
        </button>
       
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      $.datepicker.setDefaults($.datepicker.regional["es"]);
      $("#fechaPolitica").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        firstDay: 1
      });
        estatus();

        $("#guardarAdopcion").click(function(){

          datosAdopcion = 
          {
            politica: $('#politica').val(),
            fechaPolitica: $('#fechaPolitica').val(),
            estatus: $('#estatus').val(),
            servicioAuditoria: $('#servicioAuditoria').val()  
          }
          if(verificarAdopcion(datosAdopcion)=='Politica Ordenaza Agregada con exito ')
          {
              const adopcionFilas = agregarAdopcion(datosAdopcion);
              $("#tablaAdopcion tbody:last").append(adopcionFilas);
              limpiarAdopcion();
              alertify.success(verificarAdopcion(datosAdopcion));
         }
          else
          {
             alertify.error(verificarAdopcion(datosAdopcion));
          }

    });

    $( "#ver").click(function()
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
        console.log(array);

    });

    $('#eliminarAdopcion').click(function(){
      $('#tablaAdopcion tbody tr').each(function(){
          $('#tablaAdopcion tbody tr').remove();
        });
    });

    function estatus(){
      $.post( 'Buscadores/estatus.php' ).done( function(respuesta)
            {
              $('#estatus').html( respuesta );
            });
    }

    function verificarAdopcion(datosAdopcion) {
      nombreMejorar = /^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/; 
     // fecha =  \(?([0-9]{4})\)?([-]?)([0-9]{4})\2([0-9]{4})/;

    if( !nombreMejorar.exec(datosAdopcion.politica) ||datosAdopcion.politica=='')
      {
        return 'Falta la politica o ingreso caracteres especiales ';
      }
    else if (!fecha.exec(datosAdopcion.fechaPolitica) ||datosAdopcion.fechaPolitica=='')
      {
        return 'Fecha politica tiene un error '; 
      }
    else
      {
        return 'Politica Ordenaza Agregada con exito ';
      }

    }

    });
</script>