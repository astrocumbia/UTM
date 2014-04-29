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
	
	$ID = $_GET['ID'];

	$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
	mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	


	$myquery      =  "select * from CUOTA where id_cuota=".$ID.";";
	$resultados   =  mysql_query( $myquery, $GLOBALS["CONEXION"] ) or die ( mysql_error() );
	$tupla = mysql_fetch_assoc( $resultados );

	$Origen   = strtok($tupla['descripcion'], '-');
	$Destino  = strtok('-');
	$Precio   = $tupla['precio'];
?>


<form class="form-horizontal" role="form" id="form_mod_cuota" method="post">

	<?php echo '<input type="hidden" value="'.$ID.'" id="ID">' ?>

  	<div class="form-group">
    	<label for="mod-input-origen" class="col-lg-2 control-label">Origen</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="mod-input-origen" maxlength="12" placeholder="Origen"  required="required">
    	</div>
	</div>

	<div class="form-group">
    	<label for="mod-input-destino" class="col-lg-2 control-label">Destino</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="mod-input-destino" maxlength="12" placeholder="Destino"  required="required">
    	</div>
	</div>

	<div class="form-group">
    	<label for="mod-input-precio" class="col-lg-2 control-label">precio</label>
    	<div class="col-lg-10">
      		<input type="int"  class="form-control" id="mod-input-precio" maxlength="9" placeholder="precio"  required="required">
    	</div>
	</div>	
</form>

<?php 
	echo '
		<script type="text/javascript">
			$("#mod-input-origen").val("'.$Origen.'");
			$("#mod-input-destino").val("'.$Destino.'");
			$("#mod-input-precio").val("'.$Precio.'");
		</script>
	';
?>