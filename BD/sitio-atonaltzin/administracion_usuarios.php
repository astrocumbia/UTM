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
	init_conexion( );
//	echo '<br><br>'.$_SESSION['usuario'].'<br>'; 
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Principal </title>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
	<link href="images/logo_min.png" type="image/x-icon" rel="shortcut icon" />
	<link href="dist/date/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
	<script language="Javascript" type="text/javascript" src="https://code.jquery.com/jquery.js"></script>
	<script language="Javascript" type="text/javascript" src="dist/js/bootstrap.js"></script>
	<script language="Javascript" type="text/javascript" src="tools/script.js"></script>
	<script language="Javascript" type="text/javascript" src="dist/js/jquery.js"></script>

</head>
<body>

<!--BARRA SUPERIOR-->
	<nav class="navbar navbar-inverse" role="navigation">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="inicio.php">Atonaltzin</a>
	    </div>

	    <!-- Collect the nav links, forms, and other content for toggling -->
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">
	      
	    <?php 

	    	imprime_seccion_inicio(  $_SESSION['puesto'], 0 ); 
	    	imprime_seccion_boletos( $_SESSION['puesto'], 0 );
	    	imprime_seccion_reportes($_SESSION['puesto'], 0 );
	    	imprime_secccion_administracion( $_SESSION['puesto'], 1);
	    ?>
	    
	    </ul>

		<!--SALIR-->
	      <ul class="nav navbar-nav navbar-right">
	      	<li>
	        	<a href="#">
	        		<?php echo $_SESSION['usuario']; ?> 
	        		<span class="glyphicon glyphicon-user"></span>
	        	</a>
	      	</li>
	        <li>
	        	<a href="logout.php">
	        		Salir
	        		<span class="glyphicon glyphicon-share-alt"></span>
	        	</a>
	        </li>
	      </ul>	    
	    
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

<!-- TERMINA BARRA SUPERIOR -->




	<!--TITULO PRINCIPAL-->
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<h1>
				Usuarios
				<span class="glyphicon glyphicon-user"></span>
			</h1>
		</div>
		<div class="col-md-6"></div>
	</div>
	<br>

	<!--CUERPO FORMULARIO-->
	<div class="row">
		
		
		<!--SELECT DE BUSQUEDA-->
		<div class="col-md-2"></div>
		<div class="col-md-2">
			<select id="select_tipo_busqueda" class="form-control">
				    <option value="idUSUARIOS">Identificador</option>
				    <option value="nombre">Nombre</option>
				    <option value="login">username</option>
				    <option value="tipo">Tipo</option>
				    <option value="base">Base</option>
				    
			</select>			
		</div>

        <div class="col-md-3 col-lg-offset-0">
            <input class="form-control" maxlength="50" size="16" type="text" id="input-busqueda" value="" >
        </div>

		
		<button type="button" class="btn btn-primary" id="boton_buscar_usuario">Buscar</button>
	</div>

	<br><br>



<!--  MODALES -->

	<!-- Modal -->
	<div class="modal fade" id="modal_ver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel">Datos del Usuario</h3>
	      </div>
	      <div class="modal-body" id="div-modal-ver">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modal_modificar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel">Modificar Usuario </h3>
	      </div>
	      <div class="modal-body" id="div-modal-modificar">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton-aceptar-modificar" >Guardar</button>
	      </div>
	    </div>
	  </div>
	</div>	


	<!-- Modal -->
	<div class="modal fade" id="modal_agregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel">Agregar Usuario </h3>
	      </div>
	      <div class="modal-body" id="div-modal-agregar">

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton-aceptar-agregar" >Guardar</button>
	      </div>
	    </div>
	  </div>
	</div>	


	<div class="row">	
		<div id="div_alerta_usuarios">
			<br><br><br>
		</div>
	</div>

	<div id="div_mostrar_usuarios">

	</div>



	<!--Script actualiza los datos de mostrar_usuarios.php en div -->
	<script type="text/javascript">
        
        $.ajax({
            type: "POST",
            url: "tabla_mostrar_usuario.php",
            data: "tipo=1",
            success: function(data) {
            	$("#div_mostrar_usuarios").html(data);
            }
        });	
  		
  		/* accion al presionar boton buscar */
	   $( "#boton_buscar_usuario" ).mousedown(function() {

	        $.ajax({
	            type: "POST",
	            url: "tabla_mostrar_usuario.php",
	            data: "tipo=2&campo="+$("select#select_tipo_busqueda").val()+"&valor="+$("input#input-busqueda").val(),
	            success: function(data) {
	            	$("#div_mostrar_usuarios").html(data);
	            }
	        });	   		
	    	
	  	}); 


  		/* accion al presionar boton aceptar en modal agregar */
	   $( "#boton-aceptar-agregar" ).mousedown(function() {


	   		
	   		var dataString = "input_nombre="+$('input#input-nombre').val( )+"&input_usuario="+$('input#input-usuario').val( )+"&input_pass1="+$('input#input-pass1').val()+"&input_pass2="+$('input#input-pass2').val()+"&input_cargo="+$('select#input-cargo').val()+"&input_base="+$('select#input-base').val();

	        $.ajax({
	            type: "POST",
	            url: "agregar_usuario.php",
	            data: dataString,
	            success: function(data) {
	            	$("#div_alerta_usuarios").html(data);
	            }
	        });	   		

	        /* mostrar tabla de usuarios */
	        $.ajax({
	            type: "POST",
	            url: "tabla_mostrar_usuario.php",
	            data: "tipo=1",
	            success: function(data) {
	            	$("#div_mostrar_usuarios").html(data);
	            }
	        });	    
	   	   //$( "#div_mostrar_usuarios" ).load("tabla_mostrar_usuario.php");

	   	   $('#modal_agregar').modal('hide');
	    	
	  	}); 



	   /* accion al presionar boton aceptar en modal modificar */
		$( "#boton-aceptar-modificar" ).mousedown( function(){
	   		var dataString = "ID="+$('input#ID').val()+"&input_nombre="+$('input#mod-input-nombre').val( )+"&input_usuario="+$('input#mod-input-usuario').val( )+"&input_pass1="+$('input#mod-input-pass1').val()+"&input_pass2="+$('input#mod-input-pass2').val()+"&input_cargo="+$('select#mod-input-cargo').val()+"&input_base="+$('select#mod-input-base').val();

	        $.ajax({
	            type: "POST",
	            url: "modificar_usuario.php",
	            data: dataString,
	            success: function(data) {
	            	$("#div_alerta_usuarios").html(data);
	            }
	        });	   	

	        /* mostrar tabla usuario */
	        $.ajax({
	            type: "POST",
	            url: "tabla_mostrar_usuario.php",
	            data: "tipo=1",
	            success: function(data) {
	            	$("#div_mostrar_usuarios").html(data);
	            }
	        });	
	       // $( "#div_mostrar_usuarios" ).load("tabla_mostrar_usuario.php");	

		});	   


		
	</script>





	

</body>
</html>