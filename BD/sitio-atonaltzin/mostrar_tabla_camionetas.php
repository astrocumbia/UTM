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

 <!--TABLA PARA RESULTADOS-->
   
    <div class="table-responsive col-md-12 col-lg-offset-1">
        <table class="table table-hover" id="tabla_resultados">
        <!--FILA ENCABEZADO -->
        <thead>  
          <tr>  
            <th bgcolor="#45A0FF"> Código </th>  
            <th bgcolor="#45A0FF"> Matricula </th>  
            <th bgcolor="#45A0FF"> Número de asientos </th>  
            <th bgcolor="#45A0FF"> Modelo </th>  
            <th bgcolor="#45A0FF"> Dueño </th>
            <th bgcolor="#45A0FF"> Estado Actual </th>
            <th > </th>
            <th > </th>
            <th > </th>
            <th > </th>
          </tr>  
        </thead> 

        <!--CUERPO DE TABLA-->
        <tbody>

        <?php 
            switch ($_POST['tipo']) {
                case 0:
                    $myquery = "select * from CAMIONETA;";
                    break;
                
                default:
                    break;
            }
            $GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
            mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );     

            $resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
            $rows        = mysql_num_rows( $resultados );

            for ($i=0; $i < $rows ; $i++) { 
                $tupla          = mysql_fetch_assoc( $resultados );
                $ID             = $tupla['id_camioneta'];
                $matricula      = $tupla['matricula'];
                $num_asientos   = $tupla['n_asientos'];
                $modelo         = $tupla['modelo'];
                $id_dueno       = $tupla['DUENO_id_dueno'];
                $id_estado      = $tupla['ESTADO_id_estado'];

                $res_dueno      = mysql_query("select * from DUENO where id_dueno=$id_dueno", $GLOBALS["CONEXION"]) or die ( mysql_error() );
                $tupla_dueno   = mysql_fetch_assoc( $res_dueno );
                $nombre_dueno  = $tupla_dueno['nombre'].' '.$tupla_dueno['apellido'];

                $res_estado    = mysql_query( "select * from ESTADO where id_estado=$id_estado",  $GLOBALS["CONEXION"]) or die ( mysql_error() );

                $tupla_estado  = mysql_fetch_assoc( $res_estado );
                $descripcion_estado = $tupla_estado['descripcion'];

                echo '
                    <tr class="info">
                        <td class="info" width="5%" >
                        '.$ID.'
                        </td>
                        <td class="info" width="10%">
                         '.$matricula.'
                        </td>
                        <td class="info" width="13%">
                        '.$num_asientos.'
                        </td>
                        <td class="info" width="15%">
                         '.$modelo.'
                        </td>
                        <td class="info" width="22%">
                         '.$nombre_dueno.'
                        </td>
                        <td class="info" width="15%">
                         '.$descripcion_estado.'
                        </td>
                        
                        <td class="info" width="2%">
                            <button type="button" data-toggle="modal" data-target="#modal_agregar_camioneta" id="boton_agregar_camioneta_'.$ID.'" >
                                <span class="glyphicon glyphicon-plus-sign"></span>
                            </button>
                        </td>
                        
                        <td class="info" width="2%">
                            <button type="button" data-toggle="modal" data-target="#modal_ver_camioneta" id="boton_ver_camioneta_'.$ID.'">
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </button>
                        </td>
                        <td class="info" width="2%">
                            <button type="button" data-toggle="modal" data-target="#modal_modificar_camioneta" id="boton_modificar_camioneta_'.$ID.'">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                        </td>         
                    </tr>     


            <script>
            
            $( "#boton_ver_camioneta_'.$ID.'" ).mousedown(function() {
                $.ajax({
                    type: "POST",
                    url: "ver_camioneta.php",
                    data: "ID='.$ID.'&matricula='.$matricula.'&num_asientos='.$num_asientos.'&modelo='.$modelo.'&nombre_dueno='.$nombre_dueno.'&descripcion='.$descripcion_estado.'",
                    success: function(data) {
                        $("#div_moda_ver_camioneta").html(data);
                    }
                });
            });

            $( "#boton_modificar_camioneta_'.$ID.'" ).mousedown(function() {
                $.ajax({
                    type: "POST",
                    url: "formulario_modificar_camioneta.php",
                    data: "ID='.$ID.'&matricula='.$matricula.'&num_asientos='.$num_asientos.'&modelo='.$modelo.'&id_dueno='.$id_dueno.'&id_estado='.$id_estado.'",
                    success: function(data) {
                        $("#div_modal_modificar_camioneta").html(data);
                    }
                });
            });


            $( "#boton_agregar_camioneta_'.$ID.'" ).mousedown(function() {
                $.ajax({
                    type: "POST",
                    url: "formulario_agregar_camioneta.php",
                    data: "",
                    success: function(data) {
                        $("#div_modal_agregar_camioneta").html(data);
                    }
                });
            });

            </script>

                ';
            }

        ?>

                                            

        </tbody>
            
        </table>

    </div>