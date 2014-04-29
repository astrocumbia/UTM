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
    	<label for="input-origen" class="col-lg-2 control-label">Origen</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="input-origen" maxlength="12" placeholder="Origen"  required="required">
    	</div>
	</div>

	<div class="form-group">
    	<label for="input-destino" class="col-lg-2 control-label">Destino</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="input-destino" maxlength="12" placeholder="Destino"  required="required">
    	</div>
	</div>

	<div class="form-group">
    	<label for="input-precio" class="col-lg-2 control-label">precio</label>
    	<div class="col-lg-10">
      		<input type="int"  class="form-control" id="input-precio" maxlength="9" placeholder="precio"  required="required">
    	</div>
	</div>	
</form>

