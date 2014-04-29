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


	$origen  = $_POST['origen'];
	$destino = $_POST['destino'];
	$precio  = floatval( $_POST['precio'] );

	if( $origen == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar,  el campo origen estaba vacio.  
	    		</div>
	    	';
    	return;		
	}
	if( $destino == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar,  el campo destino estaba vacio.  
	    		</div>
	    	';
    	return;		
	}
	if( $precio == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-10">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar,  el campo precio estaba vacio o contiene caracteres extraños.  
	    		</div>
	    	';
    	return;		
	}
	if( $origen == $destino ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar, destino es igual a origen.  
	    		</div>
	    	';
    	return;			
	}

	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	

	$myquery      = "select * from CUOTA where descripcion='$origen-$descripcion';";
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
	if( mysql_num_rows( $resultados ) > 0 ){
	  	echo '
			<div class="alert alert-danger col-lg-offset-1 col-md-7">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error,  la cuota '.$origen.'-'.$destino.' ya existe.  
			</div>
		';
    	return;		
	}


	$myquery      =  "insert into CUOTA( precio,descripcion ) values(  $precio, '$origen-$destino' );";
	$resultados   =  mysql_query( $myquery, $GLOBALS["CONEXION"] ) or die ( mysql_error() );
	if( !$resultados ){
	  	echo '
			<div class="alert alert-danger col-lg-offset-1 col-md-7">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error desconocido,  la cuota no pudo ser agregada.  
			</div>
		';
    	return;	
	}
	else{
    	echo '
    		<div class="alert alert-success col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-ok-circle"></span>
    			La cuota '.$origen.'-'.$destino.' se ha agregado correctamente.  
    		</div>
    	';
	}

?>