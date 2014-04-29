<?php 
	@session_start();
	/* Verificar que el usuario inicio sesion */
	if(!isset($_SESSION['usuario'])) 
	{
		echo '<script> location.href = "login.php"; </script>';
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

	    	imprime_seccion_inicio(  $_SESSION['puesto'], 1 ); 
	    	imprime_seccion_boletos( $_SESSION['puesto'], 0 );
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

<?php
	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	


	$resultados  = mysql_query( "select * from CAMIONETA", $GLOBALS["CONEXION"]) or die ( mysql_error() );
	$num_camionetas        = mysql_num_rows( $resultados );

	$resultados   = mysql_query( "select * from CHOFER", $GLOBALS["CONEXION"]) or die ( mysql_error() );
	$num_choferes = mysql_num_rows( $resultados );


	$resultados   = mysql_query( "select * from CUOTA", $GLOBALS["CONEXION"]) or die ( mysql_error() );
	$num_cuotas = mysql_num_rows( $resultados );

	$resultados   = mysql_query( "select * from USUARIOS", $GLOBALS["CONEXION"]) or die ( mysql_error() );
	$num_usuarios = mysql_num_rows( $resultados );
	
?>	


	<div class="col-md-8 col-lg-offset-2">
		<div class="panel panel-primary">
			  <div class="panel-heading">¡Bienvenido <?php echo $_SESSION['nombre']; ?>!</div>
			  <div class="panel-body">
			    <h4> Tu nombre de usuario es: <?php echo $_SESSION['usuario']; ?> </h4>
			    <h4> Tenemos <?php echo $num_camionetas; ?> camionetas registradas  </h4>
			    <h4> Tenemos <?php echo $num_choferes; ?> choferes registrados  </h4>
			    <h4> Tenemos <?php echo $num_cuotas; ?> cuotas registradas  </h4>
			    <h4> Tenemos <?php echo $num_usuarios; ?> usuarios registrados  </h4>
			  </div>
		</div>
	</div>
</body>
</html>