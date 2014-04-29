<?php 
	@session_start();
	/* Verificar que el usuario inicio sesion */
	if(!isset($_SESSION['usuario'])) 
	{
		echo '<script> location.href = "login.php"; </script>';
		exit();
	}
	include("funciones.php");
		

	$ID       = $_POST['ID'];
	$nombre   = $_POST['nombre'];
	$apellido = $_POST['apellido'];


	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	




	$myquery = "DELETE FROM DUENO  WHERE id_dueno=".$ID;
	$resultados = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );

	if( mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() ) ){
    	echo '
    		<div class="alert alert-warning col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-warning-sign"></span>
    			 Se ha eliminado el dueño '.$nombre.' '.$apellido.'  
    		</div>
    	';
    }
    else{
    	echo '
    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-remove-circle"></span>
    			 Ocurrio un error desconocido, contactar a servicio técnico.  
    		</div>
    	';
    }

	//echo $myquery.'<br>';
	//print_r( $myquery );
?>