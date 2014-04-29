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



<div class="container">


	<!--TITULO PRINCIPAL-->
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<h1>
				Dueños
			</h1>
		</div>
		<div class="col-md-6"></div>
	</div>
	<br>

	<!--CUERPO FORMULARIO-->
	<div class="row">
		
		
		<!--SELECT DE BUSQUEDA-->
		<div class="col-md-1"></div>
		<div class="col-md-2">
			<select id="select_tipo_busqueda_dueno" class="form-control">
				    <option value="1">Identificador</option>
				    <option value="2">Nombre</option>
				    <option value="3">ID Camioneta</option>	    
				    <option value="4">Matricula Camioneta</option>
			</select>			
		</div>

        <div class="col-md-3 col-lg-offset-0">
            <input class="form-control" maxlength="50" size="16" type="text" id="campo_buscar_dueno" value="" >
        </div>

		
		<button type="button" class="btn btn-primary" id="boton_buscar_dueno">Buscar</button>
	</div>
	<br><br>



	<div class="row">
		<div id="alertas_duenos">
			<br><br>
		</div>
	</div>

	<div class="row">
		<div id="div_mostrar_tabla_dueno">

		</div>
    </div>








<!--  MODALES -->

	<!-- Modal -->
	<div class="modal fade" id="modal_agregar_dueno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel"> Agregar Dueño </h3>
	      </div>
	      <div class="modal-body" id="div_modal_agregar_dueno">

	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton_guardar_agregar_dueno">Guardar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modal_ver_dueno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel"> Ver Dueño </h3>
	      </div>
	      <div class="modal-body" id="div_modal_ver_dueno">

	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modal_modificar_dueno" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel"> Modificar Dueño </h3>
	      </div>
	      <div class="modal-body" id="div_modificar_dueno_modal">

	      </div>
	      <div class="modal-footer">
	      	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	        <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton_guardar_mod_dueno">Guardar</button>
	      </div>
	    </div>
	  </div>
	</div>	

	<script type="text/javascript">
        
        $.ajax({
            type: "POST",
            url: "mostrar_tabla_duenos.php",
            data: "tipo=0",
            success: function(data) {
            	$("#div_mostrar_tabla_dueno").html(data);
            }
        });	

		$( "#boton_buscar_dueno" ).mousedown( function(){
	   		var dataString = "tipo=1&campo="+$("select#select_tipo_busqueda_dueno").val()+"&valor="+$("input#campo_buscar_dueno").val()	;

            $.ajax({
		            type: "POST",
		            url: "mostrar_tabla_duenos.php",
		            data: dataString,
		            success: function(data) {
		            	$("#div_mostrar_tabla_dueno").html(data);
            	}
        	});	  

	   	
		});	             	

	
		$( "#boton_guardar_mod_dueno" ).mousedown( function(){
	   		var dataString = "nombre="+$("input#mod-input-nombre-dueno").val()+"&apellido="+$("input#mod-input-apellido-dueno").val()+"&ID="+$("input#mod_input_ID_dueno").val();

	        $.ajax({
	            type: "POST",
	            url: "modificar_dueno.php",
	            data: dataString,
	            success: function(data) {
	            	$("#alertas_duenos").html(data);
	            }
	        });

            $.ajax({
		            type: "POST",
		            url: "mostrar_tabla_duenos.php",
		            data: "tipo=0",
		            success: function(data) {
		            	$("#div_mostrar_tabla_dueno").html(data);
            	}
        	});	  

	   	
		});	   	

		$( "#boton_guardar_agregar_dueno" ).mousedown( function(){
	   		var dataString = "nombre="+$("input#input-nombre-dueno").val()+"&apellido="+$("input#input-apellido-dueno").val();

	        $.ajax({
	            type: "POST",
	            url: "agregar_dueno.php",
	            data: dataString,
	            success: function(data) {
	            	$("#alertas_duenos").html(data);
	            }
	        });

            $.ajax({
		            type: "POST",
		            url: "mostrar_tabla_duenos.php",
		            data: "tipo=0",
		            success: function(data) {
		            	$("#div_mostrar_tabla_dueno").html(data);
            	}
        	});	  

	   	
		});	         

	</script>		

</div>

</body>
</html>
