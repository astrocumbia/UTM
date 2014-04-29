<?php 
	@session_start();
	/* Verificar que el usuario inicio sesion */
	if(!isset($_SESSION['usuario'])) 
	{
		echo '<script> location.href = "login.php"; </script>';
		exit();
	}
	include("funciones.php");
	init_conexion( );


	$myquery     = 'select * from USUARIOS WHERE idUSUARIOS='.$_GET['ID'].';';
	$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
//	$rows         = mysql_num_rows( $resultados );		
//	for ($i=0; $i < $rows ; $i++) {
	$tupla   = mysql_fetch_assoc( $resultados );

?>

	<div class="row">
		<div class="col-md-4 col-lg-offset-2">
			
			<label class="control-label"> Número: </label>   <br>
			<label class="control-label"> Nombre: </label>   <br>
			<label class="control-label"> Base: </label>     <br>
			<label class="control-label"> Cargo: </label>	 <br>					
			<label class="control-label"> Username: </label> <br>
			
		</div>
		<div class="col-md-4">
			<label class="control-label"><?php echo $tupla['idUSUARIOS']; ?>  </label><br>
			<label class="control-label"><?php echo $tupla['nombre'];     ?>  </label><br>
			<label class="control-label"><?php echo $tupla['base'];       ?>  </label><br>
			<label class="control-label"><?php echo $tupla['tipo'];       ?>  </label><br>
			<label class="control-label"><?php echo $tupla['login'];      ?>  </label><br>
		</div>
	</div>
