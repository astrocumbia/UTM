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
	    	imprime_secccion_administracion( $_SESSION['puesto'], 1 );
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



	<!--  MODALES -->

		<!-- Modal ver-->
		<div class="modal fade" id="modal_ver_cuota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h3 class="modal-title" id="myModalLabel">Datos de la Cuota</h3>
		      </div>
		      <div class="modal-body" id="div_modal_ver_cuota">

		      	
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal agregar-->
		<div class="modal fade" id="modal_agregar_cuota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h3 class="modal-title" id="myModalLabel">Agregar  Cuota</h3>
		      </div>
		      <div class="modal-body" id="div_modal_agregar_cuota">

		      	
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		        <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton_aceptar_agregar_cuota">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="modal_modificar_cuota" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h3 class="modal-title" id="myModalLabel"> Modificar Cuota </h3>
		      </div>
		      <div class="modal-body" id="div_modal_modificar_cuota">


		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
		         <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton_guardar_modificar_cuota">Guardar</button>
		      </div>
		    </div>
		  </div>
		</div>	

		


		<!--TITULO PRINCIPAL-->
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-4 col-lg-offset-0">
				<h1>
					Cuotas
					<span class="glyphicon glyphicon-usd"></span>
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
				<select id="select_tipo_busqueda" class="form-control">
					    <option value="id_cuota">Identificador</option>
					    <option value="origen">Origen</option>
					    <option value="destino">Destino</option>
					    <option value="descripcion">Origen-Destino</option>
					    <option value="precio">Precio</option>	    
				</select>			
			</div>

	        <div class="col-md-3 col-lg-offset-0">
	            <input class="form-control" maxlength="25" size="16" type="text" id="input_busqueda" value="" >
	        </div>

			
			<button type="button" class="btn btn-primary" id="boton_buscar_cuotas">Buscar</button>
		</div>
		<br><br>

		<div class="row" id="alertas_cuotas">
			<br>
		</div>

		<div class="row" id="div_tabla_cuotas">
			<!-- AQUI VA LA TABLA DE CUOTAS SE LLENA CON UNA FUNCION DE JQUERY -->


		</div>
</div>


<!-- SCRIPTS PARA RECARGAR TABLAS Y ESA COSAS -->
<script type="text/javascript">

    $.ajax({
        type: "POST",
        url: "mostrar_tabla_cuotas.php",
        data: "tipo=0",
        success: function(data) {
        	$("#div_tabla_cuotas").html(data);
        }
    });	  

	/* accion al presionar boton buscar */
   $( "#boton_buscar_cuotas" ).mousedown(function() {

        $.ajax({
            type: "POST",
            url: "mostrar_tabla_cuotas.php",
            data: "tipo=2&campo="+$("select#select_tipo_busqueda").val()+"&valor="+$("input#input_busqueda").val(),
            success: function(data) {
            	$("#div_tabla_cuotas").html(data);
            }
        });	   		
    	
  	}); 

    /* BOTON ACEPTAR AGREGAR MODAL */
	$( "#boton_aceptar_agregar_cuota" ).mousedown( function(){
   		var dataString = "origen="+$('input#input-origen').val()+"&destino="+$('input#input-destino').val()+"&precio="+$('input#input-precio').val();

        $.ajax({
            type: "POST",
            url: "agregar_cuota.php",
            data: dataString,
            success: function(data) {
            	$("#alertas_cuotas").html(data);
            }
        });

        $.ajax({
		        type: "POST",
		        url: "mostrar_tabla_cuotas.php",
		        data: "tipo=0",
		        success: function(data) {
		        	$("#div_tabla_cuotas").html(data);
        	}
   		 });		   	
	});

    /* BOTON ACEPTAR MODIFICAR MODAL */
	$( "#boton_guardar_modificar_cuota" ).mousedown( function(){
   		var dataString = "ID="+$('input#ID').val()+"&origen="+$('input#mod-input-origen').val()+"&destino="+$('input#mod-input-destino').val()+"&precio="+$('input#mod-input-precio').val();

        $.ajax({
            type: "POST",
            url: "modificar_cuota.php",
            data: dataString,
            success: function(data) {
            	$("#alertas_cuotas").html(data);
            }
        });

        $.ajax({
		        type: "POST",
		        url: "mostrar_tabla_cuotas.php",
		        data: "tipo=0",
		        success: function(data) {
		        	$("#div_tabla_cuotas").html(data);
        	}
   		 });		   	
	});	 	     

</script>



</body>
</html>
