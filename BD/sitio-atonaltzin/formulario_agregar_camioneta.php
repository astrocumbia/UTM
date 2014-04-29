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

    $GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
    mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );                 


?>


<form class="form-horizontal" role="form" id="form_mod_cuota" method="post">

    
    <div class="form-group">
        <label for="input-matricula" class="col-lg-2 control-label">Matricula</label>
        <div class="col-lg-10">
            <input type="text"  class="form-control" id="input-matricula" maxlength="10" placeholder="Matricula"  required="required">
        </div>
    </div>


    <div class="form-group">
        <label for="input-modelo" class="col-lg-2 control-label">Modelo</label>
        <div class="col-lg-10">
            <input type="text"  class="form-control" id="input-modelo" maxlength="15" placeholder="Modelo de suburban"  required="required">
        </div>
    </div>

    <div class="form-group">
        <label for="input-asientos" class="col-lg-2 control-label">Asientos</label>
        <div class="col-lg-10">
            <input type="text"  class="form-control" id="input-asientos" maxlength="5" placeholder="Número de asientos"  required="required">
        </div>
    </div>    

    <div class="form-group">
        <label for="input_camioneta_dueno" class="col-lg-2 control-label">Dueño</label>
        <div class="col-lg-10">
            <select id="input_camioneta_dueno" class="form-control">
                <?php 
                    $resultados  = mysql_query( "select * from  DUENO;", $GLOBALS["CONEXION"]) or die ( mysql_error() );
                    $rows        = mysql_num_rows( $resultados );

                    for( $i = 0; $i < $rows; $i++ ){
                        $tupla     = mysql_fetch_assoc( $resultados );
                        $nombre    = $tupla['nombre'].' '.$tupla['apellido'];
                        $id_dueno  = $tupla['id_dueno'];

                        echo '<option value="'.$id_dueno.'">'.$nombre.'</option>';
                    }

                ?>
                    
                    
            </select>             
        </div>
    </div>    

    <div class="form-group">
        <label for="input_camioneta_estado" class="col-lg-2 control-label">Estado</label>
        <div class="col-lg-10">
            <select id="input_camioneta_estado" class="form-control">
                <?php 
                    $resultados  = mysql_query( "select * from  ESTADO;", $GLOBALS["CONEXION"]) or die ( mysql_error() );
                    $rows        = mysql_num_rows( $resultados );

                    for( $i = 0; $i < $rows; $i++ ){
                        $tupla          = mysql_fetch_assoc( $resultados );
                        $descripcion    = $tupla['descripcion'];
                        $id_estado      = $tupla['id_estado'];

                        echo '<option value="'.$id_estado.'">'.$descripcion.'</option>';
                    }

                ?>
            </select>             
        </div>
    </div>

</form>

