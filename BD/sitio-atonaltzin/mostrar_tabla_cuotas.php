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

<!--TABLA PARA RESULTADOS-->
	<div class="col-lg-offset-1 table-responsive col-md-10">
  		<table class="table table-hover" id="tabla_resultados">
	  		<!--FILA ENCABEZADO -->
	        <thead>  
	          <tr>  
	            <th bgcolor="#45A0FF"> Identificador</th>  
	            <th bgcolor="#45A0FF"> Origen </th>
	            <th bgcolor="#45A0FF"> Destino </th>  
	            <th bgcolor="#45A0FF"> Precio </th>              
	            <th > </th>
	            <th > </th>
	            <th > </th>
	            <th > </th>
	          </tr>  
	        </thead> 

	        <!--CUERPO DE TABLA-->
	        <tbody>

	        <?php
	        	/* HACEMOS CONSULTA PARA RELLENAR TABLA */
	        	switch ($_POST['tipo']) {
	        		case 0:
	        			$myquery = "select * from CUOTA;";
	        			break;
	        		case 2:{
	        			if($_POST['campo']=='precio'){
	        				$precio  = floatval( $_POST['valor'] );
	        				if( $precio == "" ) $myquery = "select * from CUOTA;";
	        				else  $myquery = "select * from CUOTA where precio=$precio;";
	        			}
	        			if( $_POST['campo'] == 'id_cuota' ){
	        				$identificador = intval( $_POST['valor'] );
	        				if( $identificador == "" ) $myquery = "select * from CUOTA;";
	        				else $myquery = "select * from CUOTA where id_cuota=$identificador;";
	        			}
	        			if( $_POST['campo'] == 'origen' ){
	        				$origen = $_POST['valor'];
	        				$myquery = "select * from CUOTA where descripcion like 'origen%'";
	        			}
	        			if ( $_POST['campo'] == 'destino' ) {
	        				$destino = $_POST['valor'];
	        				$myquery = "select * from CUOTA where descripcion like '%-%$destino%'";	
	        			}
	        			if ( $_POST['campo'] == 'descripcion') {
	        				$descripcion = $_POST['valor'];
	        				$myquery = "select * from CUOTA where descripcion like '%$descripcion%'";	
	        			}
	        			break;
	        		}
	        		default: break;
	        	}
				$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
				mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );		        	
				$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
				$rows        = mysql_num_rows( $resultados );



				for( $i = 0; $i < $rows; $i++ ){
					$tupla   = mysql_fetch_assoc( $resultados );

					$mystring = $tupla['descripcion'];
					$ID       = $tupla['id_cuota'];
					$Origen   = strtok($mystring, '-');
					$Destino  = strtok('-');

					$res = mysql_query( "SELECT count(*) as boletos_asociados from CUOTA, ASIENTOS where id_cuota=".$ID." AND id_cuota=CUOTA_id_cuota", $GLOBALS["CONEXION"]) or die ( mysql_error() );

					$data  = mysql_fetch_assoc($res);
					$boletos_asociados = $data['boletos_asociados'];

					$res = mysql_query( "SELECT count(*) as reservas_asociados from CUOTA, RESERVAS where id_cuota=".$ID." AND id_cuota=CUOTA_id_cuota", $GLOBALS["CONEXION"]) or die ( mysql_error() );
					$data  = mysql_fetch_assoc($res);
					$reservas_asociados = $data['reservas_asociados'];

					echo '
						<tr class="info">
			        		<td class="info" width="5%" >
			        			'.$tupla['id_cuota'].'
			        		</td>
			        		<td class="info" width="19%">
			        			'.$Origen.'
			        		</td>
			        		<td class="info" width="19%">
			        			'.$Destino.'
			        		</td>
			        		<td class="info" width="13%">
			        			$'.money_format('%(#2n', $tupla['precio'] ).'
			        		</td>

			        		<td class="info" width="2%">
			        			<button type="button" data-toggle="modal" data-target="#modal_agregar_cuota" id="boton_agregar_cuota_'.$ID.'" >
			  						<span class="glyphicon glyphicon-plus-sign"></span>
								</button>
			        		</td>
			        	        	
			        		<td class="info" width="2%">
			        			<button type="button" data-toggle="modal" data-target="#modal_ver_cuota" id="boton_ver_cuota_'.$ID.'" >
			  						<span class="glyphicon glyphicon-eye-open"></span>
								</button>
			        		</td>
			        		<td class="info" width="2%">
			        			<button type="button" data-toggle="modal" data-target="#modal_modificar_cuota" id="boton_modificar_cuota_'.$ID.'">
			        				<span class="glyphicon glyphicon-pencil"></span>
			        			</button>
			        		</td>
			        		<td class="info" width="2%">
			        			<button type="button" id="boton_eliminar_cuota_'.$ID.'" ';
			        			if( $boletos_asociados+$reservas_asociados > 0 ) echo' disabled="disabled"';
			        		echo	'>
			        				<span class="glyphicon glyphicon-remove-sign" id="boton_eliminar_cuota"></span>
			        			</button>
			        		</td>        		
			        	</tr>


			        <script>

			        	/* mostrar modal ver cuota */
						$( "#boton_ver_cuota_'.$ID.'" ).mousedown(function() {
						    $( "#div_modal_ver_cuota" ).load("ver_cuota.php?ID='.$ID.'&reservas='.$reservas_asociados.'&boletos='.$boletos_asociados.'&ID='.$ID.'&origen='.$Origen.'&destino='.$Destino.'&precio='.$tupla['precio'].'");    
						});

			        	/* mostrar modal agregar cuota */
						$( "#boton_agregar_cuota_'.$ID.'" ).mousedown(function() {
						    $( "#div_modal_agregar_cuota" ).load("formulario_agregar_cuotas.php");    
						});		
						
						/* mostrar modal modificar cuota */
						$( "#boton_modificar_cuota_'.$ID.'" ).mousedown(function() {
						    $( "#div_modal_modificar_cuota" ).load("formulario_modificar_cuota.php?ID='.$ID.'");    
						});

						$( "#boton_eliminar_cuota_'.$ID.'" ).mousedown(function() {
					    
							if( confirm("¿ Desea Eliminar la cuota '.$Origen.'-'.$Destino.' ?") ){
						        var dataString = "ID="+'.$ID.';
						        $.ajax({
						            type: "POST",
						            url: "eliminar_cuota.php",
						            data: dataString,
						            success: function(data) {
						            	$("#alertas_cuotas").html(data);
						            }
						        });
								
							    $.ajax({
							        type: "POST",
							        url: "mostrar_tabla_cuotas.php",
							        data: "tipo=0",
							        success: function(data) {
							        	$("#div_tabla_cuotas").html(data);
							        }
							    });	  					        	   		
						   	  
							}
							else{

							}
					    	
					    	
					  	});													
					</script>
					';					
				}			

	        ?>	
	        	


	        </tbody>
    		
  		</table>
  	</div>
