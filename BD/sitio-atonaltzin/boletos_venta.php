<?php 	
	@session_start();
	/* Verificar que el usuario inicio sesion */
	if(!isset($_SESSION['usuario'])) 
	{
		echo '<script> location.href = "login.php"; </script>';
		exit();
	}
	include("funciones.php"); 
	init_conexion( );
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
	    	imprime_seccion_boletos( $_SESSION['puesto'], 1 );
	    	imprime_seccion_reportes($_SESSION['puesto'], 0 );
	    	imprime_secccion_administracion( $_SESSION['puesto'], 0);
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
		<!--Pariticion de titulo-->
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-1"></div>
		<div class="col-md-4">
			<h1> 
				Venta de Boletos 
				<span class="glyphicon glyphicon-tag"></span>
			</h1>
		</div>
	</div><br><br>

	<!--PARITICION PRINCIPAL -->
	<div class="row">
		<form id="formulario_venta_boleto" action="">

			<!--PARTICION PARA FORMULARIO-->
			<div class="col-md-4">


				<!--PARTICION ORIGEN Y DESTINO-->	
				<div class="row">

					<!--ORIGEN -->
					<div class="col-md-6">
						<div class="col-lg-offset-1">
							<label clas="control-label ">Origen</label>
						</div>
						<select id="select_origen" class="form-control">
						    <option value="one">Oaxaca</option>
						    <option value="two">Huajuapan</option>
						    <option value="three">Tamazulapan</option>
						    <option value="four">Nochixtlan</option>
						</select>
					</div>

					<!--DESTINO-->
					<div class="col-md-6">
						<div class="col-lg-offset-1">
							<label clas="control-label ">Destino</label>
						</div>
						<select id="select_destino" class="form-control">
						    <option value="one">Huajuapan</option>
						    <option value="two">Oaxaca</option>
						    <option value="three">Tamazulapan</option>
						    <option value="four">Nochixtlan</option>
						</select>
					</div>
				</div>
				<br><br>
				<!--PARTICION FECHA Y HORA-->	
				<div class="row">

					<!--FECHA -->
					<div class="col-md-6">
						<div class="col-lg-offset-1">
							<label clas="control-label ">Fecha de Salida</label>
						</div>
						
						<!--CALENDARIO-->
			            <div class="input-group date form_date" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
			                <input class="form-control" size="16" type="text" value="" readonly>
			                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
			                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
			            </div>
			            <input type="hidden" id="dtp_input2" value="" />
			            <!--SCRIPT DEL CALENDARIO NO TOCAR!! -->
			            <script type="text/javascript" src="dist/date/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
						<script type="text/javascript" src="dist/date/js/locales/bootstrap-datetimepicker.es.js" charset="UTF-8"></script>
			            <script type="text/javascript">
						    $('.form_datetime').datetimepicker({
						        language:  'es',
						        weekStart: 1,
						        todayBtn:  1,
						        autoclose: 1,
						        todayHighlight: 1,
						        startView: 2,
						        forceParse: 0,
						        showMeridian: 1
						    });

						    $('.form_date').datetimepicker({
						        language:  'es',
						        weekStart: 1,
						        todayBtn:  1,
						        autoclose: 1,
						        todayHighlight: 1,
						        startView: 2,
						        minView: 2,
						        forceParse: 0
						    });

						    $('.form_time').datetimepicker({
						        language:  'es',
						        weekStart: 1,
						        todayBtn:  1,
						        autoclose: 1,
						        todayHighlight: 1,
						        startView: 1,
						        minView: 0,
						        maxView: 1,
						        forceParse: 0
						    });
						</script>

					</div>

					<!--Hora-->
					<div class="col-md-6">
						<div class="col-lg-offset-1">
							<label clas="control-label ">Hora de salida</label>
						</div>
						<select id="select_hora_salida" class="form-control">
						    <?php select_horas( ); ?>
						</select>
					</div>
				</div>	

				<br><br>

				<!--NOMBRE PASAJERO-->
				<div clas="row">
					<div class="col-lg-offset-4">
						<label class="control-label ">Nombre del Pasajero</label>
					</div>
				</div>

				<!--INPUT NOMBRE PASAJERO-->	
				<div class="row col-lg-offset-1">
					<input class="form-control" maxlength="45" size="16" type="text" value="" >
				</div>		

				<br><br>

				<!--PARTICION Numero asiento y precio del boleto-->	
				<div class="row">

					<!--NUMERO ASIENTO -->
					<div class="col-md-6">
						<div class="col-lg-offset-1 ">
							<label class="control-label col-lg-offset-1">Número de Asiento</label>
						</div>		
						<div class="col-lg-offset-2 col-md-6">
							<input id="numero_asiento" class="form-control" maxlength="3" size="16" type="int" value="10" >
						</div>
					</div>

					<!--PRECIO DEL BOLETO-->
					<div class="col-md-6">
						<div class="col-lg-offset-1 ">
							<label class="control-label col-lg-offset-1">
								Precio de Boleto <span class="glyphicon glyphicon-usd"></span>
							</label>
						</div>	
						<div class="col-lg-offset-1 col-lg-7">
							<input id="precio_boleto" class="form-control" maxlength="7" size="16" type="value" value="100.0" >
						</div>
					</div>
				</div>	

				<br><br>
				<!--PARTICION BOTONES-->	
				<div class="row">

					<!--BOTON CANCELAR -->
					<div class="col-md-6">
						<div class="col-lg-offset-2">
							<button type="reset" class="btn btn-danger ">Cancelar Venta</button>
						</div>
					</div>

					<!--BOTON VENDER-->
					<div class="col-md-6">
						<div clas="col-lg-offset-2">
							<button type="submit" class="btn btn-info">Vender Boleto</button>
						</div>
					</div>
				</div>					
			
			</div>

			<!--PARTICION PARA IMAGEN -->
			<div class="col-md-6">
				<div class="row">
						<form action="boletos_venta_submit" method="get" accept-charset="utf-8" role="form">
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 form-group-horizontal form-group" >
								<label for="select_camioneta">Número de Camioneta</label>
								<select id="select_camioneta" class="form-control">
									<?php
										select_suburban_disponibles( "Oaxaca" );
									?>
								</select>


							</div>
						</form>
				</div>
				<div class="row">
					<img src="images/suburban-reserva.png" class="img-responsive col-lg-offset-1" alt="Responsive image">
				</div>

				<br><br>
				<div class="col-lg-offset-4">
					<button type="button" class="btn btn-primary btn-lg	">Despachar</button>
				</div>

			</div>

		</form>
	</div>
</div>	

</body>
</html>