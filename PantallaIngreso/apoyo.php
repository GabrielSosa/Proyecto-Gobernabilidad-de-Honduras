<div class="row"> 
<div class="col-lg-12">
<div class="panel panel-default">
            <div class="panel-heading"> II. Apoyo a servicios locales, Áreas temáticas, Áreas Técnicas </div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
              <!-- Aqui encontramos la primera columna -->
              
                <!-- Aqui encontramos la primera columna -->
                <div class="form-group"> <label class="col-md-1 control-label">Áreas temáticas:</label>
                  <div class="col-md-3">
                  <select id="areaTematica" class="form-control">
                    <option value="0">Seleccionar</option>
                    <option value="1">Gestor/prestador de servicios públicos</option>
                    <option value="2">Asistencia técnica</option>
                    <option value="3">Inversión o proyectos de infraestructura</option>
                  </select>
                  </div> <label class="col-md-1 control-label">Apoyo servicios locales:</label>
                  <div class="col-md-3">
                      <select id="areaTrabajo" multiple class="form-control"></select>
                  </div>
                  <label class="col-md-1 control-label">Área asistencia técnica:</label>
                  <div class="col-md-3">
                    <select id="areaTecnica" multiple class="form-control">
                      <option value="">Seleccionar</option>
                    </select>
                  </div>
                </div>
               <!-- Aqui termina la primera columna -->
               
            </div>
            <!-- aqui termina el contenido del panel -->
          </div><!-- aqui termina el ultimo panel -->

</div>
</div>
<script type="text/javascript">
$(document).ready(function() {

areaTrabajo();
areaApoyo();
   //Aqui carga todos los Tipo de actores al inicio
function areaTrabajo() {

  $.post( 'Buscadores/areaTrabajo.php' ).done( function(respuesta)
  {
    $( '#areaTrabajo' ).html( respuesta );
  });
}

function areaApoyo() {

  $.post( 'Buscadores/areaApoyo.php' ).done( function(respuesta)
  {
    $( '#areaTecnica' ).html( respuesta );
  });
}


     
});
</script>
