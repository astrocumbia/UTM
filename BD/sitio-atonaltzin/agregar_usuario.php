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

	//int_conexion( );
	//print_r( $_POST );
	//echo 'AQIOOOOOO<br>';
	
	if( $_POST['input_nombre']=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar,  el campo nombre estaba vacio.  
	    		</div>
	    	';
    	return;
	}
	if( $_POST['input_usuario']=="" ){
	  	echo '
	    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
	    			<span class="glyphicon glyphicon-remove-circle"></span>
	    			 Ocurrio un error al agregar,  el campo usuario estaba vacio.  
	    		</div>
	    	';
    	return;
	}
	if( $_POST['input_pass1']==""){
	  	echo '
			<div class="alert alert-danger col-lg-offset-2 col-md-6">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error al agregar,  el campo password estaba vacio.  
			</div>
		';
    	return;
	}
	if( $_POST['input_pass1']!=$_POST['input_pass2']){
	  	echo '
			<div class="alert alert-danger col-lg-offset-2 col-md-6">
				<span class="glyphicon glyphicon-remove-circle"></span>
				 Ocurrio un error al agregar,  las contraseñas no coinciden.  
			</div>
		';
    	return;
	}			
	
	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	
	
	/* valida que tengan diferente username */
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
	
	$myquery = "insert into USUARIOS(nombre, login, pass, tipo, base ) values('".$_POST['input_nombre']."', '".$_POST['input_usuario']."', '".$_POST['input_pass1']."', '".$_POST['input_cargo']."', '".$_POST['input_base']."' );";
    
    if( mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() ) ){
    	echo '
    		<div class="alert alert-success col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-ok-circle"></span>
    			 Se ha agregado el usuario <h8> '.$_POST['input_nombre'].' </h8>  
    		</div>
    	';
    }
    else{
    	echo '
    		<div class="alert alert-danger col-lg-offset-2 col-md-6">
    			<span class="glyphicon glyphicon-remove-circle"></span>
    			 Ocurrio un error al agregar al usuario <h8> '.$_POST['input_nombre'].' </h8>  
    		</div>
    	';
    }

	//print_r( $_POST ); 

?>