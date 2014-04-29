<?php
	@session_start();
	/* Verificar que el usuario inicio sesion */
	if(!isset($_SESSION['usuario'])) 
	{
		echo '<script> location.href = "login.php"; </script>';
		exit();
	}
	/* rechazar si el taquillero intenta entrar localhost/sitio/reportes.php */
	if( $_SESSION['puesto']=="Taquillero" ){
		echo '<script> location.href = "inicio.php"; </script>';
		exit();	
	}
	include("funciones.php");

	$num = $_GET['num'];
	if( $num == 0 ){
  		echo '
	    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 No se encontraron coincidencias.  
	    		</div>
	    	';
	}
	else if( $num == 1 ){
    	echo '
    		<div class="alert alert-success col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-ok-circle"></span>
    			 Se ha encontrado una coincidencia. 
    		</div>
    	';
	}
	else {
    	echo '
    		<div class="alert alert-success col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-ok-circle"></span>
    			 Se han encontrado '.$num.' coincidencias. 
    		</div>
    	';
	}

?>

