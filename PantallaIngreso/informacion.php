  <div class="row">
        <div class="col-lg-12">
        <form id="loginForm" method="post" class="form-horizontal" action="Backend/registrarProyecto.php">
          <div class="panel panel-default">
            <div class="panel-heading"> I. Información de la organización</div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
              <!-- Aqui encontramos la primera columna -->
              
                <!-- Aqui encontramos la primera columna -->
                <div class="form-group"> 
                  <label class="col-md-2 control-label">Departamento:</label>
                    <div class="col-md-4">
                      <select id="depto" class="form-control">
                        <option value="0">Seleccionar</option>
                      </select>
                    </div> 

                  <label class="col-md-2 control-label">Municipio:</label>
                  <div class="col-md-4">
                    <select id="municipio" class="form-control">
                      <option value="0">Seleccionar</option>
                    </select>
                  </div>
                </div>
                <!-- Aqui termina la primera columna -->

                <!-- Aqui encontramos la segunda columna -->
                <div class="form-group"> 
                
                <label class="col-md-2 control-label">Nombre:</label>
                  <div class="col-md-4">
                    <input type="text" placeholder="nombre de la organización" class="form-control" id="nombreOrg" data-toggle="tooltip" data-placement="right" 
                      required=""> </div>

                 <label class="col-md-2 control-label">Nivel territorial</label>
                  <div class="col-md-4">
                    <select id="nivelTerri" class="form-control">
                        <option value="1">Nacional</option>
                        <option value="2">Local</option>
                        <option value="3">Intermunicipal</option>
                        <option value="4">Departamental</option>
                    </select>
                  </div>

                </div>
                <!-- Aqui encontramos la segunda columna -->

                <!-- Aqui encontramos la columna de posiciones-->
                <div class="form-group"> 

                <label class="col-md-2 control-label">X:</label>
                  <div class="col-md-4">
                    <input type="text" placeholder="aqui detalla el Y" class="form-control" id="X" data-toggle="tooltip" data-placement="right" 
                      required=""> </div>

                <label class="col-md-2 control-label">Y:</label>
                  <div class="col-md-4">
                    <input type="text" placeholder="aqui detalla el X" class="form-control" id="Y" data-toggle="tooltip" data-placement="right" required=""> </div> 

                </div>
                <!-- Aqui encontramos la segunda columna -->

                <!-- Aqui encontramos la tercera columna -->
                <div class="form-group"> 
                <label class="col-md-2 control-label">Tipo de organización:</label>
                  <div class="col-md-4">
                    <select id="tipoOrg" class="form-control">
                        <option value="0">Seleccionar</option>
                    </select>
                  </div> 

                 
                <label class="col-md-2 control-label">Tipo de Actores:</label>
                  <div class="col-md-4">
                    <select id="tipoActoresLocales" class="form-control">
                        <option value="0">Seleccionar</option>
                    </select>
                  </div>

                </div>
                <!-- Aqui encontramos la tercera columna -->

                <!-- Aqui encontramos la cuarta columna -->
                <div class="form-group"> 
                <label class="col-md-2 control-label">¿Tiene personería jurídica?</label>
                  <div class="col-md-4">
                    <select id="personeria" class="form-control">
                        <option value="1">Si</option>
                        <option value="2">No</option>
                        <option value="3">En proceso</option>
                    </select>     
                  </div> 

                <label class="col-md-2 control-label">Objetivo organizacional:</label>
                  <div class="col-md-4">
                    <textarea class="form-control" id="objetivo" placeholder="Detalle el objetivo"></textarea>   
                  </div>
                </div>
               <!-- Aqui termina la cuarta columna -->
               
              
            </div>
            <!-- aqui termina el contenido del panel -->
          </div><!-- aqui termina el ultimo panel -->

<script type="text/javascript">
$(document).ready(function() {

    tipoActor();
    //tipoActoresLocales();
  
    $.post( 'Buscadores/departamento.php' ).done( function(respuesta)
    {
      $( '#depto' ).html( respuesta );
    });

    $( "#depto" ).change(function()
    {

      var id_depto = $("#depto option:selected").val();
      
      // Lista de municipios
      $.post( 'Buscadores/municipio.php', { id_depto: id_depto} ).done( function( respuesta )
      {
        $( '#municipio' ).html( respuesta );
      });
    });


function tipoActor() {

  $.post( 'Buscadores/tipoActor.php' ).done( function(respuesta)
  {
    $( '#tipoOrg' ).html( respuesta );
  });
}

$( "#tipoOrg" ).change(function()
  {
    //alert('Hola');
    var id_actor = $("#tipoOrg option:selected").val();

    $.post( 'Buscadores/tipoActoresModal.php', { id_actor: id_actor} ).done( function( respuesta )
    {
      $( '#tipoActoresLocales' ).html( respuesta );
    });

  });
         
});
</script>