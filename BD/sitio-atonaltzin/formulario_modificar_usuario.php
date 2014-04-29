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


	$myquery      =  "select * from USUARIOS where idUSUARIOS=".$ID.";";
	$resultados   =  mysql_query( $myquery, $GLOBALS["CONEXION"] ) or die ( mysql_error() );
	$tupla = mysql_fetch_assoc( $resultados );
//	print_r( $tupla );

?>


<form class="form-horizontal" role="form" id="form_add_user" method="post">
	<?php echo '<input type="hidden" value="'.$ID.'" id="ID">' ?>
  	<div class="form-group">
    	<label for="mod-input-nombre" class="col-lg-2 control-label">Nombre</label>
    	<div class="col-lg-10">
      		<input type="text"  class="form-control" id="mod-input-nombre" maxlength="30" placeholder="Nombre"  required="required">
    	</div>
	</div>

  	<div class="form-group">
    	<label for="input-cargo" class="col-lg-2 control-label">Cargo</label>
    	<div class="col-lg-10">
    		<select class="form-control" id="mod-input-cargo">
    			<option value="Taquillero">Taquillero</option>
    			<?php
    				if( $_SESSION['puesto']=="Comisario" ){
    					echo '
			    			<option value="Admin">Administrador</option>
			    			<option value="Comisario">Comisario</option>
       					';
    				}
    			?>
    		</select>
    	</div>
	</div>	

  	<div class="form-group">
    	<label for="input-base" class="col-lg-2 control-label">Base</label>
    	<div class="col-lg-10">
    		<select class="form-control" id="mod-input-base">
    			<option value="Oaxaca">Oaxaca</option>
    			<option value="Huajuapan">Huajuapan</option>
    			<option value="Nochixtlan">Nochixtlan</option>
    			<option value="Tamazulapa">Tamazulapan</option>
    		</select>    		
    	</div>
	</div>	

  	<div class="form-group">
    	<label for="input-usuario" class="col-lg-2 control-label">Usuario</label>
    	<div class="col-lg-10">
      		<input type="text" class="form-control" id="mod-input-usuario" placeholder="Username" maxlength="15" required="required">
    	</div>
	</div>

  	<div class="form-group">
    	<label for="input-pass1" class="col-lg-2 control-label">Contraseña</label>
    	<div class="col-lg-10">
      		<input type="password" class="form-control" id="mod-input-pass1" placeholder="Password"  maxlength="15" required="required">
    	</div>
	</div>	

  	<div class="form-group">
    	<label for="input-pass2" class="col-lg-2 control-label">Confirmar Contraseña</label>
    	<div class="col-lg-10">
      		<input type="password" class="form-control" id="mod-input-pass2" placeholder="Confirmar" maxlength="15"  required="required">
    	</div>
	</div>						
</form>

<?php 
	echo '
		<script type="text/javascript">
			$("#mod-input-nombre").val("'.$tupla['nombre'].'");
			$("#mod-input-usuario").val("'.$tupla['login'].'");
			$("#mod-input-pass1").val("'.$tupla['pass'].'");
			$("#mod-input-pass2").val("'.$tupla['pass'].'");

			if("'.$tupla['tipo'].'"=="Taquillero")
				document.getElementById("mod-input-cargo").selectedIndex = 0;
			if("'.$tupla['tipo'].'"=="Admin")
				document.getElementById("mod-input-cargo").selectedIndex = 1;
			if("'.$tupla['tipo'].'"=="Comisario")
				document.getElementById("mod-input-cargo").selectedIndex = 2;

			if("'.$tupla['base'].'"=="Oaxaca")
				document.getElementById("mod-input-base").selectedIndex = 0;
			if("'.$tupla['base'].'"=="Huajuapan")
				document.getElementById("mod-input-base").selectedIndex = 1;			
			if("'.$tupla['base'].'"=="Nochixtlan")
				document.getElementById("mod-input-base").selectedIndex = 2;
			if("'.$tupla['base'].'"=="Tamazulapa")
				document.getElementById("mod-input-base").selectedIndex = 3;


		</script>
	';
?>