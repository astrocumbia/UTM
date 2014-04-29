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
	
	/* VALIDACIONES */
	if( $_POST['input_nombre']=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar,  el campo nombre estaba vacio.  
	    		</div>
	    	';
    	return;
	}
	if( $_POST['input_usuario']=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al modificar,  el campo usuario estaba vacio.  
	    		</div>
	    	';
    	return;
	}
	if( $_POST['input_pass1']==""){
	  	echo '
			<div class="alert alert-danger col-lg-offset-2 col-md-6">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error al modificar,  el campo password estaba vacio.  
			</div>
		';
    	return;
	}
	if( $_POST['input_pass1']!=$_POST['input_pass2']){
	  	echo '
			<div class="alert alert-danger col-lg-offset-2 col-md-6">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error al modificar,  las contraseñas no coinciden.  
			</div>
		';
    	return;
	}				
	


	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	


	/* valida que tengan diferente username */
	$myquery = "select * from USUARIOS where login='".$_POST['input_usuario']."' AND idUSUARIOS=".$_POST['ID'].";";
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
	if( mysql_num_rows( $resultados ) != 1 ){
		$myquery = "select * from USUARIOS where login='".$_POST['input_usuario']."';";
		$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
		if( mysql_num_rows( $resultados ) > 0 ){
			  	echo '
					<div class="alert alert-danger col-lg-offset-2 col-md-6">
						<span class="glyphicon glyphicon-remove-circle"></span>
						 Ocurrio un error,  el usuario '.$_POST['input_usuario'].' ya esta registrado.  
					</div>
				';
		    	return;		
		 }
	}




	$myquery = "UPDATE USUARIOS SET nombre='".$_POST['input_nombre']."' , login='".$_POST['input_usuario']."' , pass='".$_POST['input_pass1']."' , tipo='".$_POST['input_cargo']."', base='".$_POST['input_base']."' WHERE idUSUARIOS=".$_POST['ID'];
	$resultados = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );

	

	if( mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() ) ){
    	echo '
    		<div class="alert alert-warning col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-warning-sign"></span>
    			 Se ha modificado el usuario <h8> '.$_POST['input_nombre'].' </h8>  
    		</div>
    	';
    }
    else{
    	echo '
    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-remove-circle"></span>
    			 Ocurrio un error al modificar al usuario <h8> '.$_POST['input_nombre'].' </h8>  
    		</div>
    	';
    }


	//echo $myquery.'<br>';
	//print_r( $_POST );
?>