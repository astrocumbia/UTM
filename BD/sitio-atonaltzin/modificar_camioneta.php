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
//	print_r( $_POST );
	$matricula   = $_POST['matricula'];
	$asientos    = intval($_POST['asientos']);
	$modelo      = $_POST['modelo'];
	$id_dueno    = $_POST['id_dueno'];
	$id_estado   = $_POST['id_estado'];	
	$ID          = $_POST['ID'];

	//print_r( $_POST );

	if( $matricula=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar camioneta,  el campo matricula estaba vacio.  
	    		</div>
	    	';
    	return;			
	}
	if( $modelo=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar camioneta,  el campo modelo estaba vacio.  
	    		</div>
	    	';
    	return;			
	}
	if( $asientos == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar camioneta,  el campo asientos contiene caracteres extraños.  
	    		</div>
	    	';
    	return;		
	}
	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	


	/* valida que tengan diferente username */
	$myquery = "select * from CAMIONETA where matricula like '$matricula' AND id_camioneta=$ID;";
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
	if( mysql_num_rows( $resultados ) != 1 ){
		$myquery = "select * from CAMIONETA where matricula like '$matricula';";
		$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
		if( mysql_num_rows( $resultados ) > 0 ){
			  	echo '
					<div class="alert alert-danger col-lg-offset-1 col-md-7">
						<span class="glyphicon glyphicon-remove-circle"></span>
						 Ocurrio un error,  la camioneta con matricula '.$matricula.' esta en uso.  
					</div>
				';
		    	return;		
		 }
	}	



	$myquery = "UPDATE CAMIONETA SET matricula='$matricula', n_asientos=$asientos, modelo='$modelo', DUENO_id_dueno=$id_dueno, ESTADO_id_estado=$id_estado WHERE id_camioneta=$ID;";
	$resultados = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );

	

	if( mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() ) ){
    	echo '
    		<div class="alert alert-warning col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-warning-sign"></span>
    			 Se ha modificado la camioneta '.$matricula.'.  
    		</div>
    	';
    }
    else{
    	echo '
    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-remove-circle"></span>
    			 Ocurrio un error al modificar la camioneta  '.$matricula.'.  
    		</div>
    	';
    }


?>