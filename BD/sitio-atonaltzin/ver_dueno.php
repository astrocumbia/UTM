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
	///echo 'HOLA_GUAPO';
	//print_r( $_POST );
?>

	<div class="row">
		<div class="col-md-4 col-lg-offset-2">
			
			<label class="control-label"> Número: </label>   <br>
			<label class="control-label"> Nombre: </label>   <br>
			<label class="control-label"> Apellido: </label>     <br>
			<label class="control-label"> Camionetras Registradas: </label>     <br>
			
		</div>
		<div class="col-md-4">
			<label class="control-label"><?php echo $_POST['ID'];            ?>  </label><br>
			<label class="control-label"><?php echo $_POST['nombre'];        ?>  </label><br>
			<label class="control-label"><?php echo $_POST['apellido'];       ?>  </label><br>
			<label class="control-label"><?php echo $_POST['num'];  ?>  </label><br>
			
		</div>
	</div>