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

<form class="form-horizontal" role="form" id="form_add_user" name="form_add_user" method="post">
  	<div class="form-group">
    	<label for="input-nombre" class="col-lg-2 control-label">Nombre</label>
    	<div class="col-lg-10">
      		<input type="text" class="form-control" id="input-nombre" maxlength="30" placeholder="Nombre"  required="required">
    	</div>
	</div>

  	<div class="form-group">
    	<label for="input-cargo" class="col-lg-2 control-label">Cargo</label>
    	<div class="col-lg-10">
    		<select class="form-control" id="input-cargo">
    			<option value="Taquillero">Taquillero</option>
                <?php 
                    /* Un administrador no puede dar de alta a otro admin,
                        solo los comisarios pueden dar de alta comisarios y admins */
                    if($_SESSION['puesto']=="Comisario"){
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
    		<select class="form-control" id="input-base">
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
      		<input type="text" class="form-control" id="input-usuario" placeholder="Username" maxlength="15" required="required">
    	</div>
	</div>

  	<div class="form-group">
    	<label for="input-pass1" class="col-lg-2 control-label">Contraseña</label>
    	<div class="col-lg-10">
      		<input type="password" class="form-control" id="input-pass1" placeholder="Password"  maxlength="15" required="required">
    	</div>
	</div>	

  	<div class="form-group">
    	<label for="input-pass2" class="col-lg-2 control-label">Confirmar Contraseña</label>
    	<div class="col-lg-10">
      		<input type="password" class="form-control" id="input-pass2" placeholder="Confirmar" maxlength="15"  required="required">
    	</div>
	</div>						
</form>


