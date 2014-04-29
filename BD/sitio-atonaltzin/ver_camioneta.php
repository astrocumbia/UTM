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

	//print_r( $_POST );
?>

	<div class="row">
		<div class="col-md-4 col-lg-offset-2">
			
			<label class="control-label"> Número: </label>   <br>
			<label class="control-label"> Matricula: </label>   <br>
			<label class="control-label"> Número Asientos: </label>     <br>
			<label class="control-label"> Modelo: </label>     <br>
			<label class="control-label"> Dueño: </label>	 <br>					
			<label class="control-label"> Estado Actual: </label> <br>
			
		</div>
		<div class="col-md-4">
			<label class="control-label"><?php echo $_POST['ID'];            ?>  </label><br>
			<label class="control-label"><?php echo $_POST['matricula'];        ?>  </label><br>
			<label class="control-label"><?php echo $_POST['num_asientos'];       ?>  </label><br>
			<label class="control-label"><?php echo $_POST['modelo'];        ?>  </label><br>
			<label class="control-label"><?php echo $_POST['nombre_dueno'];  ?>  </label><br>
			<label class="control-label"><?php echo $_POST['descripcion']; ?>  </label><br>
		</div>
	</div>