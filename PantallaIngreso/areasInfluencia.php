<div class="row">
  <div class="col-sm-12">
  <div class="table-responsive">
    <table id="tablaA" class="table table-hover table-condensed table-bordered">
    <caption>
      <button class="btn btn-primary" data-toggle="modal" data-target="#modalAreas">
        Agregar nuevo 
        <span class="fa fa-plus""></span>
      </button>
      <button class="btn btn-primary" id="eliminarAreas">
        Eliminar
        <span class="fa fa-trash"></span>
      </button>
    </caption>
    <thead> 
      <tr>
        <th>Departamento</th>
        <th>Municipio</th>
        <th>Comunidad</th>
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


<div class="modal fade" id="modalAreas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega áreas de influencia</h4>
      </div>
      <div class="modal-body">
          <label>Departamento:</label>
            <select id="areaDepto" class="form-control">
              <option value="0">Seleccionar</option>
            </select>
          <label>Municipio:</label>
            <select id="areaMuni" class="form-control">
              <option value="0">Seleccionar</option>
            </select>
          <label>Comunidad:</label>
          <input type="text"  id="areaComu" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarArea">
        Agregar
        </button>
       
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){ 

      areaDepto();
        

        $("#guardarArea").click(function(){

          datos = 
          {
            areaDepto: $('#areaDepto').val(),
            areaMuni: $('#areaMuni').val(),
            areaComu: $('#areaComu').val()
          }

          if(verificarAreas(datos)=='Area agregada con exito')
          {
            const areaFilas = areadatos(datos);
            $("#tablaA tbody:last").append(areaFilas);
            limpiarAreas();
            alertify.success(verificarAreas(datos));  
          }
          else
          {
            alertify.error(verificarAreas(datos));
          }
          

      });

   

    $('#eliminarAreas').click(function(){
      $('#tablaA tbody tr').each(function(){
          $('#tablaA tbody tr').remove();
        });
    });

    function areaDepto() {
       $.post( 'Buscadores/departamento.php' ).done( function(respuesta)
            {
              $( '#areaDepto' ).html( respuesta );
            });

    }
         

      $( "#areaDepto" ).change(function()
      {

        var id_depto = $("#areaDepto option:selected").val();
        // Lista de municipios
        $.post( 'Buscadores/municipio.php', { id_depto: id_depto} ).done( function( respuesta )
        {
          $( '#areaMuni' ).html( respuesta );
        });
      });

      function verificarAreas(datos) {
        var Comunidad = /^[0-9a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ_\s]+$/;

        if(datos.areaDepto==0)
        {
          return 'Falta departamentos de las areas de influencia';
        }
        else if(datos.areaMuni==0)
        {
          return 'Falta municipios de las areas de influencia';
        }
        else if(!Comunidad.exec(datos.areaComu) ||datos.areaComu=='')
        {
          return 'Falta el area de la comunidad o esta mal escrito ';
        }
        else
        {
          return 'Area agregada con exito';
        }
      }


});
</script>