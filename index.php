<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('location:login.php');
}

?> 

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Menu</title>

  <link rel="stylesheet" href="css/estilo.css" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">

<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.1.2/js/buttons.print.min.js"></script>


</head>
<body>
<nav class="navbar navbar-default sidebar" role="navigation">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <div class="logo">
          <a href="index.php">
            <img src="images/logo.png" class="img-responsive" alt=""> </a>
        </div>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php"><span class="fa fa-home"></span> Proyecto</a></li>
          <li><a href="nuevo.php"><span  class="fa fa-file"></span> Nuevo</a></li>
          <?php
          
          $privilegios = rtrim($_SESSION['privilegios']);
          if(strcmp($privilegios, 'admin') == 0)
            {
               echo '<li><a href="usuarios.php"><span  class="fa fa-address-book"></span> Usuarios</a></li>';

            }

          ?>
          <li><a href="salir.php"><span  class="fa fa-sign-out"></span> Cerrar Sesión</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="main">  
  <div id="page-wrapper">
      <div class="row">
        <div class="col-xs-12">
          <h1 class="page-header">Ficha de actores locales</h1>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- Este es el marco para el formulario a llenar -->
      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading"> Ficha de actores </div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
              <!-- Aqui encontramos la primera columna -->
              <form id="loginForm" class="form-horizontal" >
                
               <!-- Aqui encontramos la segunda columna -->
                <div class="form-group"> 
                  <label class="col-sm-3 control-label">Departamento:</label>

                  <div class="col-sm-3">
                   <select id="departamento" class="form-control">
                      <option value="0">SELECCIONAR</option>
                   </select>
                  </div> 

                  <label class="col-sm-2 control-label">Municipio:</label>
                    <div class="col-sm-3">
                       <select id="municipio" class="form-control">
                       <option value="0">SELECCIONAR</option>
                      </select>
                    </div>
                </div>
                <!-- Aqui termina la segunda columna -->
                
                <!-- Aqui encontramos la primer columna -->
                <div class="form-group"> 
                  <label class="col-sm-1 control-label">Tipo de Actor:</label>
                    <div class="col-sm-3">
                      <select id="tipoActor" multiple class="form-control"></select>
                    </div> 

                  <label class="col-sm-1 control-label">Tipo de Actores:</label>
                    <div class="col-sm-3">
                      <select id="tipoActores" multiple class="form-control"></select>
                    </div> 

                   <label class="col-sm-1 control-label">Áreas de Trabajo:</label>
                    <div class="col-sm-3">
                      <select id="areaTrabajo" multiple class="form-control"></select>
                    </div> 
                </div>

                <div class="form-group"> 
                  <div class="col-sm-3">
                     <caption>
                        <button type="button" id="excelBoton" class="btn btn-success" >
                          EXCEL
                          <span class="fa fa-file-excel-o"></span>
                        </button>
                    </caption>
                  </div>
                </div>
                 
            <div id="contenido_php"></div>
              
              </form>
                <div class="table-responsive">
                <table id="tabla" class="table table-bordered table-striped">
                 <thead>
                  <tr>
                   <th>Id Actor Local</th>
                   <th>Nombre de la Institución</th>
                   <th>Contacto</th>
                   <th>Teléfono</th>
                   <th>Correo Electrónico</th>
                   <th>Áreas de Trabajo</th>
                   <th  class="detalle" >Detalle</th>
                  </tr>
                 </thead>
                </table>
               </div>
            </div>
            
          </div>
        </div>
      </div>

    </div> 
  </div>

<!-- Modal para edicion de datos INICIO-->

<div class="modal fade" id="modalEdicion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md" role="document"> 
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Actualizar datos</h4>
      </div>
      <div class="modal-body">
          <form id="loginForm" method="post" class="form-horizontal">
            <div class="form-group">
                <label class="col-xs-4 control-label">Tipo de Actor:</label>
                <div class="col-xs-7">
                    <select id="tipoActorModal" class="form-control"></select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Tipo de Actores:</label>
                <div class="col-xs-7">
                    <select id="tipoActoresModal" class="form-control"></select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Nombre de la Institución:</label>
                <div class="col-xs-7">
                    <input type="text" pattern = "[(a-z)|(A-Z)|(\s)|(á)|(é)|(i)|(ó)|(ú)]*" class="form-control" id="n" data-toggle="tooltip" data-placement="right"   required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Contactos:</label>
                <div class="col-xs-7">
                    <input type="text" pattern = "[(a-z)|(A-Z)|(\s)|(á)|(é)|(i)|(ó)|(ú)]*" class="form-control" id="c" data-toggle="tooltip" data-placement="right"    required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Teléfono:</label>
                <div class="col-xs-7">
                    <input type="text" pattern = "[0-9]+" class="form-control" id="telefono" data-toggle="tooltip" placeholder="Ingresa el teléfono"  data-placement="right"    required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Correo Eléctronico:</label>
                <div class="col-xs-7">
                    <input type="text" pattern = "[(a-z)|(A-Z)|(\s)|(á)|(é)|(i)|(ó)|(ú)]*" placeholder="Ingresa el correo eléctronico" class="form-control" id="correo" data-toggle="tooltip" data-placement="right"    required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Ubicación X:</label>
                <div class="col-xs-7">
                    <input type="text" pattern = "[0-9]+" class="form-control" id="x"  data-toggle="tooltip" data-placement="right" required/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Ubicación Y:</label>
                <div class="col-xs-7">
                    <input type="text"  pattern = "[0-9]+" class="form-control" id="y" data-toggle="tooltip" data-placement="right" required/>
                </div>
            </div>

            <div class="form-group">
              <div class="col-xs-12">
                <div id="map" style="width: 100%; height: 200px; text-align: center" ></div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-warning" id="actualizadatos" data-dismiss="modal">Actualizar</button>
          </div>
        </form>
      
    </div>
  </div>
</div>
<!-- Modal para edicion de datos FIN -->

</body>
</html>
<script src="librerias/alertifyjs/alertify.js"></script>
<script src="fronted/index.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJroPq_aUq_ffImg5VYXiF_YAVCxIICZc&callback=initMap" async defer></script>
<script src="fronted/mapa.js"></script>

