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


<form class="form-horizontal" role="form" id="form_add_cuota" method="post">

  	<div class="form-group">
    	<label for="input-nombre-dueno" class="col-lg-2 control-label">Nombre</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="input-nombre-dueno" maxlength="20" placeholder="Nombre"  required="required">
    	</div>
	</div>

	<div class="form-group">
    	<label for="input-apellido-dueno" class="col-lg-2 control-label">Apellido</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="input-apellido-dueno" maxlength="20" placeholder="Apellido"  required="required">
    	</div>
	</div>

</form>

