<?php
session_start();
include('conexion.php');
$conexion = new Conexion();
$username = $_POST['username'];
$pass = $_POST['pass'];

if(isset($username) && isset($pass)) {
	
		$sql= pg_query($conexion->getConexion(), "SELECT * FROM tbl_usuarios WHERE usuario='$username'" );
		
		$array= pg_fetch_array( $sql);

		if($array>=1){
			//echo $pass;
			$pw = rtrim($array['contrasenia']);
			if( password_verify($pass, $pw) ){

				$_SESSION['privilegios']=$array['privilegios'];
				$_SESSION['usuario']=$array['usuario'];
				//header("location:../index.php");
				echo "<script>location.href='../index.php' </script>"; // redirigir a la pagina deseada si cumple el login
			}
			else
			{	
				echo "<script>alert('Usuario o Contraseña incorrectos') </script>";
				//header("location:../login.php");
				echo "<script>location.href='../login.php' </script>"; // redirigir al login si es incorrecto
				session_destroy();
			}
			
		}
		else
			{	
				echo "<script>alert('Usuario o Contraseña incorrectos') </script>";
				//header("location:../login.php");
				echo "<script>location.href='../login.php' </script>"; // redirigir al login si es incorrecto
				session_destroy();
			}

		
	$conexion->cerrarConexion();
			
	}
	else
	{
		header("location:../index.php");
	}

   //pg_close($conexion->cerrarConexion());

?>