<div class="row">
  <div class="col-sm-12">
  <div class="table-responsive">
    <table id="tablaAuditoria" class="table table-hover table-condensed table-bordered">
    <caption>
      <button class="btn btn-primary" data-toggle="modal" data-target="#modalAuditoria">
        Agregar nuevo 
        <span class="fa fa-plus""></span>
      </button>
      <button class="btn btn-primary" id="eliminarAuditoria">
        Eliminar
        <span class="fa fa-trash"></span>
      </button>
    </caption>
    <thead> 
      <tr>
        <th>Año</th>
        <th>Mes</th>
        <th>Tema de la Auditoria</th>
        <th>Organización</th>
        <th>Servicio a mejorar</th>
        <th>Detalle de las recomendaciones</th>
        <th>% de recomendación</th>
        <th>fecha Inicio</th>
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


<div class="modal fade" id="modalAuditoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Agrega nueva Auditorías Sociales</h4>
      </div>
      <div class="modal-body">
          <label>Año:</label>
          <input type="text" id="anio" class="form-control input-sm">
          <label>Mes:</label>
          <input type="text" id="mes" class="form-control input-sm">
          <label>Tema de la Auditoria:</label>
          <input type="text" id="tema" class="form-control input-sm">
          <label>Organización:</label>
          <input type="text" id="organizacion" class="form-control input-sm">
          <label>Servicio a mejorar:</label>
          <input type="text" id="servicio" class="form-control input-sm">
          <label>Detalle de las recomendaciones:</label>
          <input type="text" id="detalle" class="form-control input-sm">
          <label>% de recomendación:</label>
          <input type="text" id="Nrecomendadionces" class="form-control input-sm">
          <label>Fecha de inicio:</label>
          <input type="text" id="fechaInicio" class="form-control input-sm">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="guardarAuditoria">
        Agregar
        </button>
       
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
   
    $(document).ready(function(){

        $("#guardarAuditoria").click(function(){
          datos = 
          {
            anio: $('#anio').val(),
            mes: $('#mes').val(),
            tema: $('#tema').val(),
            organizacion: $('#organizacion').val(),
            servicio: $('#servicio').val(),
            detalle: $('#detalle').val(),
            Nrecomendadionces: $('#Nrecomendadionces').val(),
            fechaInicio: $('#fechaInicio').val() 
          }

          const auditoriaFila = agregarAuditoria(datos);
          $("#tablaAuditoria tbody:last").append(auditoriaFila);
          limpiarTabla();
    });

    $( "#ver").click(function()
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
        console.log(array);

    });

    $('#eliminarAuditoria').click(function(){
      $('#tablaAuditoria tbody tr').each(function(){
          $('#tablaAuditoria tbody tr').remove();
        });
    });

  /*  function verficarAreas(datos) {
        anio = /^[0-9]+$/;
        mes = /(^[1-9]{1}$|^[1-4]{1}[0-9]{1}$|^12$)/gm;
        tema: $('#tema').val(),
        organizacion: $('#organizacion').val(),
        servicio: $('#servicio').val(),
        detalle: $('#detalle').val(),
        Nrecomendadionces: $('#Nrecomendadionces').val(),
        fechaInicio: $('#fechaInicio').val() 
    }
*/

    });
</script>