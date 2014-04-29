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
	$matricula   = $_POST['matricula'];
	$asientos    = intval($_POST['asientos']);
	$modelo      = $_POST['modelo'];
	$id_dueno    = $_POST['id_dueno'];
	$id_estado   = $_POST['id_estado'];	

	//print_r( $_POST );

	if( $matricula=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar camioneta,  el campo matricula estaba vacio.  
	    		</div>
	    	';
    	return;			
	}
	if( $modelo=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar camioneta,  el campo modelo estaba vacio.  
	    		</div>
	    	';
    	return;			
	}
	if( $asientos == "" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-1 col-md-7">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar camioneta,  el campo asientos contiene caracteres extraños.  
	    		</div>
	    	';
    	return;		
	}
	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	

	$myquery      = "select * from CAMIONETA where matricula like '$matricula';";
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );

	if( mysql_num_rows( $resultados ) > 0 ){
	  	echo '
			<div class="alert alert-danger col-lg-offset-1 col-md-7">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error,  la camioneta con matricula '.$matricula.' ya existe.  
			</div>
		';
    	return;		
	}	

	$myquery      =  "insert into CAMIONETA( matricula, n_asientos , modelo, DUENO_id_dueno, ESTADO_id_estado ) values( '$matricula', $asientos, '$modelo', $id_dueno, $id_estado  );";

	$resultados   =  mysql_query( $myquery, $GLOBALS["CONEXION"] ) or die ( mysql_error() );
	if( !$resultados ){
	  	echo '
			<div class="alert alert-danger col-lg-offset-1 col-md-7">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error desconocido,  la camioneta no pudo ser agregada.  
			</div>
		';
    	return;	
	}
	else{
    	echo '
    		<div class="alert alert-success col-lg-offset-1 col-md-7">
    			<span class="glyphicon glyphicon-ok-circle"></span>
    			La camioneta con matricula '.$matricula.' se ha agregado correctamente.  
    		</div>
    	';
	}	
?>