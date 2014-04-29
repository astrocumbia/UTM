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

	//print_r( $_GET );
?>

	<div class="row">
		<div class="col-md-4 col-lg-offset-2">
			
			<label class="control-label"> Número: </label>   <br>
			<label class="control-label"> Origen: </label>   <br>
			<label class="control-label"> Destino: </label>     <br>
			<label class="control-label"> Precio: </label>     <br>
			<label class="control-label"> Boletos Asociados: </label>	 <br>					
			<label class="control-label"> Reservas Asociadas: </label> <br>
			
		</div>
		<div class="col-md-4">
			<label class="control-label"><?php echo $_GET['ID'];            ?>  </label><br>
			<label class="control-label"><?php echo $_GET['origen'];        ?>  </label><br>
			<label class="control-label"><?php echo $_GET['destino'];       ?>  </label><br>
			<label class="control-label"><?php echo $_GET['precio'];        ?>  </label><br>
			<label class="control-label"><?php echo $_GET['boletos'];  ?>  </label><br>
			<label class="control-label"><?php echo $_GET['reservas']; ?>  </label><br>
		</div>
	</div>