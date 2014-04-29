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

	    	imprime_seccion_inicio(  $_SESSION['puesto'],  0 ); 
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
                Camionetas
                <span class="glyphicon glyphicon-road"></span>
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
                    <option value="one">Numero de camineta</option>
                    <option value="two">Chofer</option>
                    <option value="three">Matricula</option>
                    <option value="four">Estado</option>
            </select>           
        </div>

        <div class="col-md-3 col-lg-offset-0">
            <input class="form-control" maxlength="50" size="16" type="text" example="locol" value="" >
        </div>

        
        <button type="button" class="btn btn-primary">Buscar</button>
    </div>
    <br><br>


    <div class="row">
        <div id="div_alertas_camionetas">

        </div>
    </div>


    <div class="row">
        <div id="div_tabla_camionetas">

        </div>
    </div>





<!--  MODALES -->

    <!-- Modal -->
    <div class="modal fade" id="modal_ver_camioneta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel">Datos de Camioneta</h3>
          </div>
          <div class="modal-body" id="div_moda_ver_camioneta">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_agregar_camioneta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel">Agregar Camioneta</h3>
          </div>
          <div class="modal-body" id="div_modal_agregar_camioneta">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton_guardar_agregar_camioneta">Guardar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_modificar_camioneta" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3 class="modal-title" id="myModalLabel"> Modificar Camioneta </h3>
          </div>
          <div class="modal-body" id="div_modal_modificar_camioneta">

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal" id="boton_guardar_modificar_camioneta">Guardar</button>
          </div>
        </div>
      </div>
    </div>  

</div>

<script type="text/javascript">

    $.ajax({
        type: "POST",
        url: "mostrar_tabla_camionetas.php",
        data: "tipo=0",
        success: function(data) {
            $("#div_tabla_camionetas").html(data);
        }
    });   


    /* BOTON ACEPTAR modificar MODAL */
    $( "#boton_guardar_modificar_camioneta" ).mousedown( function(){
        var dataString = "matricula="+$('input#mod-input-matricula').val()+"&modelo="+$('input#mod-input-modelo').val()+"&asientos="+$('input#mod-input-asientos').val()+"&id_dueno="+$('select#mod_input_camioneta_dueno').val()+"&id_estado="+$('select#mod_input_camioneta_estado').val()+"&ID="+$('input#camioneta_ID').val();

        $.ajax({
            type: "POST",
            url: "modificar_camioneta.php",
            data: dataString,
            success: function(data) {
                $("#div_alertas_camionetas").html(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "mostrar_tabla_camionetas.php",
            data: "tipo=0",
            success: function(data) {
                $("#div_tabla_camionetas").html(data);
            }
        });         
    });          
    

    /* BOTON ACEPTAR agregar MODAL */
    $( "#boton_guardar_agregar_camioneta" ).mousedown( function(){
        var dataString = "matricula="+$('input#input-matricula').val()+"&modelo="+$('input#input-modelo').val()+"&asientos="+$('input#input-asientos').val()+"&id_dueno="+$('select#input_camioneta_dueno').val()+"&id_estado="+$('select#input_camioneta_estado').val();

        $.ajax({
            type: "POST",
            url: "agregar_camioneta.php",
            data: dataString,
            success: function(data) {
                $("#div_alertas_camionetas").html(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "mostrar_tabla_camionetas.php",
            data: "tipo=0",
            success: function(data) {
                $("#div_tabla_camionetas").html(data);
            }
        });         
    });          




</script>


</body>
</html>