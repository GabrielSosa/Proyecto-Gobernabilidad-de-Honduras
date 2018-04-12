<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header('location:login.php');
}

$privilegios = rtrim($_SESSION['privilegios']);

if(strcmp($privilegios, 'admin') != 0){
    header('location:index.php');
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
  <title>Usuarios</title>

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

  <!--validación de JQUEY Validate-->
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js"></script>

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
          <li><a href="index.php"><span class="fa fa-home"></span> Proyecto</a></li>
          <li><a href="nuevo.php"><span  class="fa fa-file"></span> Nuevo</a></li>
          <li class="active"><a href="usuarios.php"><span  class="fa fa-address-book"></span> Usuarios</a></li>
          <li><a href="salir.php"><span  class="fa fa-sign-out"></span> Cerrar Sesión</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="main">  
  <div id="page-wrapper">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="page-header">Usuarios</h1>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- Este es el marco para el formulario a llenar -->
    <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-heading"> Usuarios </div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
              <!-- Aqui encontramos la primera columna -->
             <div class="removeMessages"></div>
                
             <div class="col-sm-12">
                <button class="btn btn-default pull pull-right" data-toggle="modal" data-target="#addMiembro" id="addMemberModalBtn">
                    <span class="fa fa-plus-circle"></span> Añadir Usuarios
                </button>
              </div>  
              <br><br><br>
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="manageMemberTable">          
                  <thead>
                    <tr>
                      <th>Usuario</th>                         
                      <th>Nombre Completo</th>
                      <th>Privilegios</th>
                      <th>Opción</th>  
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


<!-- add modal -->
  <div class="modal fade" tabindex="-1" role="dialog" id="addMiembro">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="fa fa-plus-circle"></span> Añadir Usuario</h4>
        </div>
        
        <form class="form-horizontal" action="Backend/crearUsuario.php" method="POST" id="createMemberForm">

        <div class="modal-body">
          <div class="messages">
          </div>

        <div class="form-group"> <!--/here teh addclass has-error will appear -->
          <label for="name" class="col-xs-4 control-label">Nombre del Usuario:</label>
          <div class="col-xs-7"> 
            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="Ingrese el nombre de usuario" required="Ingrese el nombre de usuario">
          </div>
        </div>
        <div class="form-group">
          <label for="address" class="col-xs-4 control-label">Nombre Completo:</label>
          <div class="col-xs-7">
            <input type="text" class="form-control" id="nombreCompleto" name="nombreCompleto" placeholder="Ingrese el nombre de usuario" required>
          </div>
        </div>

        <div class="form-group">
          <label for="contact" class="col-xs-4 control-label">Contraseña</label>
          <div class="col-xs-7">
            <input type="password" class="form-control" id="contresenia" name="contresenia" placeholder="Ingrese su contraseña" required>
          </div>
        </div> 

        <div class="form-group">
          <label class="col-xs-4 control-label" >Repetir Contraseña:</label>
          <div class="col-xs-7">
            <input type="password" class="form-control" id="repeatContrasenia" name="repeatContrasenia" placeholder="Repita su contraseña" required>
          </div>
        </div>       
          <div class="form-group">
            <label class="col-xs-4 control-label" >Departamento:</label>
            <div class="col-xs-7">
              <select name="areaDepto[]"  multiple class="form-control" required>
              </select>
            </div> 
          </div>

         <div class="form-group">
            <label class="col-xs-4 control-label" >Municipio:</label>
            <div class="col-xs-7">
              <select name="areaMuni[]" multiple class="form-control" required>
              </select>
            </div> 
          </div>
            
          <div class="form-group">
              <div class="radio">
                 <label class="radio-inline col-xs-6 control-label">
                 <input type="radio" name="privilegios" id="admin" value="admin" >Admin</label>
                 <label class="radio-inline control-label"><input type="radio" name="privilegios" id="normal" value="normal">Normal</label> 
            </div>              
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
        </form> 
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- /add modal -->

  <!-- remove modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
      <div class="modal-dialog" role="document"> 
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><span class="fa fa-trash"></span> Remover Usuario</h4>
          </div>
          <div class="modal-body">
            <p>¿Desea Remover el Usuario?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="removeBtn">Remover Usuario</button> 
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /remove modal -->

    <!-- edit modal -->
    <div class="modal fade" tabindex="-1" role="dialog" id="editMemberModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><span class="fa fa-pencil-square-o"></span> Editar Usuario</h4>
        </div>

      <form class="form-horizontal" action="Backend/editarUsuario.php" method="POST" id="updateMemberForm">       
  
        <div class="modal-body">
            <div class="messages">
              
            </div>

          <div class="form-group"> <!--/here teh addclass has-error will appear -->
            <label for="name" class="col-xs-4 control-label">Nombre del Usuario:</label>
            <div class="col-xs-7"> 
              <input type="text" class="form-control" id="editName" name="editName" placeholder="Ingrese el nombre de usuario" required="Ingrese el nombre de usuario">
            </div>
          </div>
          <div class="form-group">
            <label for="address" class="col-xs-4 control-label">Nombre Completo:</label>
            <div class="col-xs-7">
              <input type="text" class="form-control" id="editnombreCompleto" name="editnombreCompleto" placeholder="Ingrese el nombre de usuario" required>
            </div>
          </div>

          <div class="form-group">
            <label for="contact" class="col-xs-4 control-label">Contraseña</label>
            <div class="col-xs-7">
              <input type="password" class="form-control" id="editcontresenia" name="editcontresenia" placeholder="Ingrese su contraseña" required>
            </div>
          </div> 

          <div class="form-group">
            <label class="col-xs-4 control-label" >Repetir Contraseña:</label>
            <div class="col-xs-7">
              <input type="password" class="form-control" id="editrepeatContrasenia" name="editrepeatContrasenia" placeholder="Repita su contraseña" required>
            </div>
          </div>       
            <div class="form-group">
              <label class="col-xs-4 control-label" >Departamento:</label>
              <div class="col-xs-7">
                <select name="areaDepto[]"  multiple class="form-control" required>
                </select>
              </div> 
            </div>

           <div class="form-group">
              <label class="col-xs-4 control-label" >Municipio:</label>
              <div class="col-xs-7">
                <select name="areaMuni[]" multiple class="form-control" required>
                </select>
              </div> 
            </div>
              
            <div class="form-group">
              <div class="radio">
                <label class="col-xs-6 control-label">
                  <input type="radio" name="editprivilegios" id="admin" value="admin" >Admin</label>
                  <label class="col-xs-2 control-label">
                   <input type="radio" name="editprivilegios" id="normal" value="normal">Normal
                 </label>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
          </form> 
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /edit modal -->
</body>
</html>
<script src="librerias/alertifyjs/alertify.js"></script>
<script type="text/javascript" src="fronted/usuarios.js"></script>

