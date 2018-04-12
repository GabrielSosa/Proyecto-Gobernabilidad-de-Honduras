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
  <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
  <script src="js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
  <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
          <li class="active"><a href="nuevo.php"><span  class="fa fa-file"></span> Nuevo</a></li>
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
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Ficha de Actores Locales</h1>
        </div>
        <!-- /.col-lg-12 -->
      </div>
      <!-- Este es el marco para el formulario a llenar -->
     
      <div id="informacion"></div><!-- Aqui va la informacion general  -->
      <div id="apoyo"></div><!-- Aqui va la informacion de Apoyo a servicios locales, Areas tematicas, Areas Tecnicas  -->
          
      <div class="row">
        <div class="col-lg-12">
          <div class="panel panel-default">
            <div class="panel-heading"> III. Proyectos en los que Participa </div>
            <div class="panel-body">
        
              <!-- Este es contenido del panel -->
              <!-- Aqui encontramos la primera columna -->
              
                <!-- Aqui encontramos la primera columna -->
                
                  <div class="row">
                    <div class="col-sm-10" style="text-align: center; width:100%">
                      <div id="tablaProyectos"></div>
                    </div>
                  </div>        
               <!-- Aqui termina la primera columna -->     
            </div>
            <!-- aqui termina el contenido del panel -->
          </div><!-- aqui termina el ultimo panel -->
        </div>
      </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading"> IV. Áreas de Influencia </div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
                  <div class="row">
                    <div class="col-sm-10" style="text-align: center; width:100%">
                      <div id="areasInfluencia"></div>
                    </div>
                  </div>          
            </div>
            <!-- aqui termina el contenido del panel -->
          </div><!-- aqui termina el ultimo panel -->
        </div>
      </div>
          
       <div id="gruposSociales"></div>

    <div class="row">
      <div class="col-lg-12">
       <div id="panelAuditoria" class="panel panel-default">
            <div class="panel-heading"> VI. Auditorias Sociales que  ha Realizado </div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
                  <div class="row">
                    <div class="col-sm-10" style="text-align: center; width:100%">
                      <div id="auditoriasSociales"></div>
                    </div>
                  </div>          
            </div>
          </div>
        </div>
            <!-- aqui termina el contenido del panel -->
        </div><!-- aqui termina el ultimo panel -->

    <div class="row">
      <div class="col-lg-12">
      <div id="panelAdopcion" class="panel panel-default">
            <div class="panel-heading"> VII. Ha Promovido la Adopción, Implementación, Derogación de Políticas </div>
            <div class="panel-body">
              <!-- Este es contenido del panel -->
                  <div class="row">
                    <div class="col-sm-10" style="text-align: center; width:100%">
                      <div id="adopcion"></div>
                    </div>
                  </div>          
            </div>
        </div>
      </div>
            <!-- aqui termina el contenido del panel -->
        </div><!-- aqui termina el ultimo panel -->

    
       <div class="row">
        <div class="col-lg-12 text-right">
          <h1 class="page-header">
            <caption>
              <button class="btn btn-primary" onClick="window.location = 'index.php';" > Atras <span class="fa fa-arrow-left"></span></button>
              <button class="btn btn-primary" id="guardarTodo" >Guardar <span class="fa fa-floppy-o"></span></button>   
            </caption>
          </h1>
        </div>
        <!-- /.col-lg-12 -->
      </div>
  </div>  
    
<script src="fronted/nuevo.js"></script>
<script src="librerias/alertifyjs/alertify.js"></script>

</body>
</html>

