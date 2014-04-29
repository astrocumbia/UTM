<?php 
	@session_start();
	/* Verificar que el usuario inicio sesion */
	if(!isset($_SESSION['usuario'])) 
	{
		echo '<script> location.href = "login.php"; </script>';
		exit();
	}
	include("funciones.php");
		
	//echo 'HOLAA';
	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	

	$myquery        = "select nombre from USUARIOS where idUSUARIOS=".$_POST['ID'];
	$resultados     = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
	$tupla          = mysql_fetch_assoc( $resultados );


	$myquery = "DELETE FROM USUARIOS  WHERE idUSUARIOS=".$_POST['ID'];
	$resultados = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );

	if( mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() ) ){
    	echo '
    		<div class="alert alert-warning col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-warning-sign"></span>
    			 Se ha eliminado el usuario <h8> '.$tupla['nombre'].' </h8>  
    		</div>
    	';
    }
    else{
    	echo '
    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-remove-circle"></span>
    			 Ocurrio un error al eliminar al usuario <h8> '.$_POST['input_nombre'].' </h8>  
    		</div>
    	';
    }

	//echo $myquery.'<br>';
	//print_r( $myquery );
?>