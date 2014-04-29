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
 	$ID        = $_POST['ID'];
	$nombre    = $_POST['nombre'];
	$apellido  = $_POST['apellido'];
?>


<form class="form-horizontal" role="form" id="form_add_cuota" method="post">

	<?php echo '<input type="hidden" value="'.$ID.'" id="mod_input_ID_dueno">' ?>

  	<div class="form-group">
    	<label for="mod-input-nombre-dueno" class="col-lg-2 control-label">Nombre</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="mod-input-nombre-dueno" maxlength="20" placeholder="Nombre"  required="required">
    	</div>
	</div>

	<div class="form-group">
    	<label for="mod-input-apellido-dueno" class="col-lg-2 control-label">Apellido</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="mod-input-apellido-dueno" maxlength="20" placeholder="Apellido"  required="required">
    	</div>
	</div>

</form>

<?php 
	echo '
		<script type="text/javascript">
			$("input#mod-input-nombre-dueno").val("'.$nombre.'");
			$("input#mod-input-apellido-dueno").val("'.$apellido.'");
		</script>
	';
?>