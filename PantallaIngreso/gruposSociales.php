<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
            <div class="panel-heading"> V. Grupos Sociales</div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
              <!-- Aqui encontramos la primera columna -->
              
                <!-- Aqui encontramos la primera columna -->
                <div class="form-group"> <label class="col-md-1 control-label">Grupos Sociales:</label>
                  <div class="col-md-3">
                  <select id="grupoSocial" multiple class="form-control">
                  </select> 
                  </div> <label class="col-md-3 control-label">¿Trabaja en los temas de transparencia, auditoria social o veeduría social?</label>
                  <div class="col-md-1">
                    <div class="radio">
                      <label>
                        <input type="radio" name="optionsRadios" id="opcionsi" value="SI" >SI</label>
                    </div>
                    <div class="radio">
                       <label>
                         <input type="radio" name="optionsRadios" id="opcionno" value="NO">NO
                       </label>
                    </div>
                  </div>
                  <label class="col-md-2 control-label">Áreas que apoya:</label>
                  <div class="col-md-2">
                    <input type="text" class="form-control" id="areaApoyo" value="" required>
                  </div>
               <!-- Aqui termina la primera columna -->
              </div>
            </div>
            <!-- aqui termina el contenido del panel -->
          </div><!-- aqui termina el ultimo panel -->  
</div>
</div>

<script type="text/javascript">
$(document).ready(function() {

    grupoSocial();
      
    function grupoSocial() {

      $.post( 'Buscadores/grupoSocial.php' ).done( function(respuesta)
      {
        $( '#grupoSocial' ).html( respuesta );
      });
    }
     
});
</script>