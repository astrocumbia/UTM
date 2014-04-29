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
	    	imprime_seccion_reportes($_SESSION['puesto'], 1 );
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



	<!--TITULO PRINCIPAL-->
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<h1>
				Reportes
				<span class="glyphicon glyphicon-list-alt"></span>
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
				    <option value="one">Camioenta</option>
				    <option value="two">Dueño</option>
				    <option value="three">Total</option>	    
			</select>			
		</div>

        <div class="col-md-3 col-lg-offset-0">
            <input class="form-control" maxlength="50" size="16" type="text" example="locol" value="" >
        </div>

		
		<button type="button" class="btn btn-primary">Generar reportes</button>
	</div>
	<br><br>

	<div class="row">
	<!--TABLA PARA RESULTADOS-->
	<div class="col-md-1"></div>
	<div class="table-responsive col-md-10">
  		<table class="table table-hover" id="tabla_resultados">
  		<!--FILA ENCABEZADO -->
        <thead>  
          <tr>  
            <th bgcolor="#45A0FF"> Camioneta </th>  
            <th bgcolor="#45A0FF"> Dueño </th>  
            <th bgcolor="#45A0FF"> Inporte </th>              
            <th > </th>
            <th > </th>
            <th > </th>
            <th > </th>
          </tr>  
        </thead> 

        <!--CUERPO DE TABLA-->
        <tbody>
        	<tr class="info">
        		<td class="info" width="5%" >
        			456789
        		</td>
        		<td class="info" width="19%">
        			Arturo
        		</td>
        		<td class="info" width="13%">
        			55.9
        		</td>
        	       		
        		<td class="info" width="2%">
        			<button type="button" data-toggle="modal" data-target="#modal_ver">
  						<span class="glyphicon glyphicon-eye-open"></span>
					</button>
        		</td>
        		<td class="info" width="2%">
        			<button type="button">
        				<span class="glyphicon glyphicon-pencil"></span>
        			</button>
        		</td>
        		<td class="info" width="2%">
        			<button type="button">
        				<span class="glyphicon glyphicon-remove-sign"></span>
        			</button>
        		</td>        		
        	</tr>

        	<tr class="info">
        		<td class="info" width="5%" >
        			098765
        		</td>
        		<td class="info" width="19%">
        			Gil Hernandez
        		</td>
        		<td class="info" width="13%">
        			100.00
        		</td>
        	        	
        		<td class="info" width="2%">
        			<button type="button" data-toggle="modal" data-target="#modal_ver" >
  						<span class="glyphicon glyphicon-eye-open"></span>
					</button>
        		</td>
        		<td class="info" width="2%">
        			<button type="button">
        				<span class="glyphicon glyphicon-pencil"></span>
        			</button>
        		</td>
        		<td class="info" width="2%">
        			<button type="button">
        				<span class="glyphicon glyphicon-remove-sign"></span>
        			</button>
        		</td>        		
        	</tr>

        	<tr class="info">
        		<td class="info" width="5%" >
        			876543
        		</td>
        		<td class="info" width="19%">
        			Arnold Perez
        		</td>
        		<td class="info" width="13%">
        			505.66
        		</td>
        		
        		<td class="info" width="2%">
        			<button type="button" data-toggle="modal" data-target="#modal_ver" >
  						<span class="glyphicon glyphicon-eye-open"></span>
					</button>
        		</td>
        		<td class="info" width="2%">
        			<button type="button" data-toggle="modal" data-target="#modal_modificar">
        				<span class="glyphicon glyphicon-pencil"></span>
        			</button>
        		</td>
        		<td class="info" width="2%">
        			<button type="button">
        				<span class="glyphicon glyphicon-remove-sign"></span>
        			</button>
        		</td>        		
        	</tr>

        	       	       	        	        	

        </tbody>
    		
  		</table>

	</div>
	</div>






<!--  MODALES -->

	<!-- Modal -->
	<div class="modal fade" id="modal_ver" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <h3 class="modal-title" id="myModalLabel">Datos del Boleto</h3>
	      </div>
	      <div class="modal-body">

	      		<div class="row">
	      			<div class="col-md-4">
	      				<div class="col-lg-offset-4">
		      				<label class="control-label"> Código:  	</label><br>
		      				<label class="control-label"> Nombre:  	</label><br>
		      				<label class="control-label"> Origen:  	</label><br>
		      				<label class="control-label"> Destino: 	</label><br>
		      				<label class="control-label"> Fecha:   	</label><br>
		      				<label class="control-label"> Hora:    	</label><br>
		      				<label class="control-label"> Camioneta: </label><br>
		      				<label class="control-label"> Asiento:   </label><br>
		      				<label class="control-label"> Estado:    </label><br>
		      				<label class="control-label"> Precio:    </label>
		      			</div>
	      			</div>
					<div class="col-md-8">
						<label class="control-label"> Código del Boleto </label><br>
						<label class="control-label"> Nombre del Cliente que tiene Boleto </label>
						<label class="control-label"> Origen Del viaje </label><br>
						<label class="control-label"> Destino del Viaje </label><br>
						<label class="control-label"> Fecha el viaje </label><br>
						<label class="control-label"> Hora del viaje </label><br>
						<label class="control-label"> Número de Camioneta </label><br>
						<label class="control-label"> Número de Asiento </label><br>
						<label class="control-label"> Estado del boleto </label><br>
						<label class="control-label"> Precio del boleto </label>
					</div>
			     </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
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
	        <h3 class="modal-title" id="myModalLabel"> Modificar Reserva </h3>
	      </div>
	      <div class="modal-body">

	      		<div class="row">
	      			<div class="col-md-4">
	      				<div class="col-lg-offset-4">
		      				<label class="control-label"> Código:  	</label><br>
		      				<label class="control-label"> Nombre:  	</label><br>
		      				<label class="control-label"> Origen:  	</label><br>
		      				<label class="control-label"> Destino: 	</label><br>
		      				<label class="control-label"> Fecha:   	</label><br>
		      				<label class="control-label"> Hora:    	</label><br>
		      				<label class="control-label"> Camioneta: </label><br>
		      				<label class="control-label"> Asiento:   </label><br>
		      				<label class="control-label"> Estado:    </label><br>
		      				<label class="control-label"> Precio:    </label>
		      			</div>
	      			</div>
					<div class="col-md-8">
						<label class="control-label"> Código del Boleto </label><br>
						<label class="control-label"> Nombre del Cliente que tiene Boleto </label>
						<label class="control-label"> Origen Del viaje </label><br>
						<label class="control-label"> Destino del Viaje </label><br>
						<label class="control-label"> Fecha el viaje </label><br>
						<label class="control-label"> Hora del viaje </label><br>
						<label class="control-label"> Número de Camioneta </label><br>
						<label class="control-label"> Número de Asiento </label><br>
						<label class="control-label"> Estado del boleto </label><br>
						<label class="control-label"> Precio del boleto </label>
					</div>
			     </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>	

</body>
</html>
