<?php
session_start();
session_destroy();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Login</title>

    <link href="css/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<div class="container">
    <form class="form-signin" action="Backend/validar.php" method="post">
     <div class="module form-module"> 
        <div class="toggle"><i class="fa fa-times fa-pencil"></i>
             <div class="tooltip">Click Me</div>
        </div> 

        <div class="form-signin-heading text-center">
            <img src="images/logo.png" alt=""/>
        </div>

        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="Usuario" name="username" autofocus value="" required>
            <input type="password" class="form-control" placeholder="Password" name="pass" value="" required>

            <button class="btn btn-lg btn-login btn-block" type="submit">
                <i class="fa fa-check"></i>
            </button>
        </div>

        
     </div> 
    </form>

</div>
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/modernizr.min.js"></script>
<script src="librerias/alertifyjs/alertify.js"></script>

</body>
</html>
