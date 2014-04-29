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

	$origen  = $_POST['origen'];
	$destino = $_POST['destino'];
	$precio  = floatval( $_POST['precio'] );
	$ID      = $_POST['ID'];

	if( $origen == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar,  el campo origen estaba vacio.  
	    		</div>
	    	';
    	return;		
	}
	if( $destino == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar,  el campo destino estaba vacio.  
	    		</div>
	    	';
    	return;		
	}
	if( $precio == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-10">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar,  el campo precio estaba vacio o contiene caracteres extraños.  
	    		</div>
	    	';
    	return;		
	}
	if( $origen == $destino ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar, destino es igual a origen.  
	    		</div>
	    	';
    	return;			
	}


	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	


	/* valida que tengan diferente username */
	$myquery = "select * from CUOTA where descripcion like '$origen-$destino' AND id_cuota=$ID;";
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
	if( mysql_num_rows( $resultados ) != 1 ){
		$myquery = "select * from CUOTA where descripcion like '$origen-$destino';";
		$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
		if( mysql_num_rows( $resultados ) > 0 ){
			  	echo '
					<div class="alert alert-danger col-lg-offset-1 col-md-7">
						<span class="glyphicon glyphicon-remove-circle"></span>
						 Ocurrio un error,  la cuota '.$origen.'-'.$destino.' esta en uso.  
					</div>
				';
		    	return;		
		 }
	}


	$myquery = "UPDATE CUOTA SET precio=$precio, descripcion='$origen-$destino' WHERE id_cuota=$ID;";
	$resultados = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );

	

	if( mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() ) ){
    	echo '
    		<div class="alert alert-warning col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-warning-sign"></span>
    			 Se ha modificado la cuota '.$origen.'-'.$destino.'.  
    		</div>
    	';
    }
    else{
    	echo '
    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-remove-circle"></span>
    			 Ocurrio un error al modificar la cuota  '.$origen.'-'.$destino.'.  
    		</div>
    	';
    }


?>
