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

	$nombre   = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	
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

	$myquery      = "select * from DUENO where nombre like '$nombre' AND apellido like '$apellido';";
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
	if( mysql_num_rows( $resultados ) > 0 ){
	  	echo '
			<div class="alert alert-danger col-lg-offset-1 col-md-7">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error,  el dueño '.$nombre.' '.$apellido.' ya existe.  
			</div>
		';
    	return;		
	}	

	$myquery      =  "insert into DUENO( nombre,apellido ) values(  '$nombre' , '$apellido' );";
	$resultados   =  mysql_query( $myquery, $GLOBALS["CONEXION"] ) or die ( mysql_error() );
	if( !$resultados ){
	  	echo '
			<div class="alert alert-danger col-lg-offset-1 col-md-8">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error desconocido, el dueño no puedo ser agregado, contacte con servicio técnico.  
			</div>
		';
    	return;	
	}
	else{
    	echo '
    		<div class="alert alert-success col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-ok-circle"></span>
    			El dueño '.$nombre.' '.$apellido.' se ha agregado correctamente.  
    		</div>
    	';
	}
?>