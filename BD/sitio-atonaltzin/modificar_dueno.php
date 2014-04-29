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
	//print_r( $_POST );

	$nombre  = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$ID      = $_POST['ID'];

	if( $nombre == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar, el nombre estaba vacio.  
	    		</div>
	    	';
    	return;		

	}
	if( $apellido == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar, el usuario estaba vacio.  
	    		</div>
	    	';
    	return;		
	}



	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	


	/* valida que tengan diferente username */
	$myquery = "select * from DUENO where nombre like '$nombre' AND  apellido like '$apellido' AND id_dueno=$ID;";
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
	if( mysql_num_rows( $resultados ) != 1 ){
		$myquery = "select * from DUENO where nombre like '$nombre' AND apellido like '$apellido';";
		$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
		if( mysql_num_rows( $resultados ) > 0 ){
			  	echo '
					<div class="alert alert-danger col-lg-offset-1 col-md-7">
						<span class="glyphicon glyphicon-remove-circle"></span>
						 Ocurrio un error,  el dueño '.$nombre.' '.$apellido.' esta en uso.  
					</div>
				';
		    	return;		
		 }
	}


	$myquery = "UPDATE DUENO SET nombre='$nombre', apellido='$apellido' WHERE id_dueno=$ID;";
	$resultados = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );

	

	if( mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() ) ){
    	echo '
    		<div class="alert alert-warning col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-warning-sign"></span>
    			 Se ha modificado el dueño '.$nombre.' '.$apellido.'.  
    		</div>
    	';
    }
    else{
    	echo '
    		<div class="alert alert-danger col-lg-offset-1 col-md-8">
    			<span class="glyphicon glyphicon-remove-circle"></span>
    			 Ocurrio un error al modificar el dueño  '.$nombre.' '.$apellido.', Contacte con servicio técnico.  
    		</div>
    	';
    }

?>
