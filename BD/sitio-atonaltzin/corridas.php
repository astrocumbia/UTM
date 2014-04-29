<?php 
	@session_start();
	/* Verificar que el usuario inicio sesion */
	if(!isset($_SESSION['usuario'])) 
	{
		echo '<script> location.href = "login.php"; </script>';
		exit();
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Principal </title>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
	<link href="dist/date/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
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
	      
	    <!-- PESTAÑA INICIO -->  
	        <li >
	        	<a href="inicio.php">
		        	<span class="glyphicon glyphicon-home"></span>
		        	Inicio
		        </a>
		    </li>

		<!-- PESTAÑA Boletos --> 
	        <li class="dropdown " >
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
	          	<span class="glyphicon glyphicon-tag"></span>
	          	Boletos 
	          	<b class="caret"></b>
	          </a>
	          <ul class="dropdown-menu">
	            <li><a href="boletos_venta.php">Venta</a></li>
	            <li><a href="boletos_reserva.php">Reserva</a></li>
	            <li><a href="boletos_buscar.php">Buscar</a></li>
	          </ul>
	        </li>

	    <!-- PESTAÑA CORRIDAS --> 
	        <li class="active">
	        	<a href="corridas.php">
	        		<span class="glyphicon glyphicon-road"></span>
	        		Corridas
	        	</a>
	        </li>

	    <!-- PESTAÑA REPORTES --> 
	        <li>
	        	<a href="reportes.php">
	        		<span class="glyphicon glyphicon-list-alt"></span>
	        		Reportes
	        	</a>
	        </li>

	    <!-- PESTAÑA ADMINISTRACION --> 
	        <li class="dropdown">
	          <a href="reportes.php" class="dropdown-toggle" data-toggle="dropdown"> 
	          	<span class="glyphicon glyphicon-user"></span>
	          	Administración 
	          	<b class="caret"></b>
	          </a>
	          <ul class="dropdown-menu">
	            <li><a href="administracion_usuarios.php">Usuarios</a></li>
	            <li><a href="administracion_suburban.php">Suburban</a></li>
	            <li><a href="administracion_choferes.php">Choferes</a></li>
	          </ul>
	        </li>

    	    <!-- PESTAÑA Avisos --> 
	        <li>
	        	<a href="#">
	        		<span class="glyphicon glyphicon-exclamation-sign"></span>
	        		Aviso
	        		<span class="badge">0</span>
	        	</a>
	        </li>

	      
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

	<!--TITULO PRINCIPAL-->
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-4">
			<h1>
				Corridas
				<span class="glyphicon glyphicon-road"></span>
			</h1>
		</div>
		<div class="col-md-6"></div>
	</div>
	<br>




	<div class="row">
		<div class="col-md-2 col-lg-offset-1">
			<h4>
				<label clas="control-label ">Corridas del Día</label>
			</h4>
		</div>

		<div class="col-md-2">
							
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
			<!--TERMINA CALENDARIO -->
		</div>

		<div class="col-md-2">
			<button type="button" class="btn btn-primary" >Buscar</button>
		</div>

	</div>
	<br>
	
	<!--BOTONES CREAR LISTA CORRIDAS-->
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-3">
			<button type="button" class="btn btn-info ">Agregar Lista de Corridas</button>
			<button type="button" class="btn btn-primary ">Agregar Corrida</button>
		</div>
	</div>
	










</body>
</html>