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

//	print_r( $_POST );
?>

<!--TABLA PARA RESULTADOS-->
	<div class="col-lg-offset-1 table-responsive col-md-10">
  		<table class="table table-hover" id="tabla_resultados_duenos">
	  		<!--FILA ENCABEZADO -->
	        <thead>  
	          <tr>  
	            <th bgcolor="#45A0FF"> Identificador </th>  
	            <th bgcolor="#45A0FF"> Nombre </th>  
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
	        			$myquery = "select * from DUENO;";
	        			break;
	        		case 1:{
	        			$campo = $_POST['campo'];
	        			$valor = $_POST['valor'];
	        			if( $valor == "" ){
		        			$myquery = "select * from DUENO;";
		        			break;	
	        			}
	        			if( $campo == 1 ){
	        				$id_dueno = intval($valor);
	        				if( $id_dueno == "" ){
		               			$myquery = "select * from DUENO;";
			        			break;	
	        				}
	        				$myquery = "select * from DUENO where id_dueno=$valor;";
	        			}
	        			if( $campo == 2 ){
	        				$myquery = "select * from DUENO where nombre like '%$valor%' OR apellido like '%$valor%';";
	        			}
	        			if( $campo == 3 ){
	        				$id_dueno = intval($valor);
	        				if( $id_dueno == "" ){
		               			$myquery = "select * from DUENO;";
			        			break;	
	        				}
	        				$myquery = "select * from DUENO, CAMIONETA where id_dueno=DUENO_id_dueno AND id_camioneta=$id_dueno;";
	        			}
	        			if( $campo == 4 ){
	        				$myquery = "select * from DUENO, CAMIONETA where matricula like '$valor' and id_dueno=DUENO_id_dueno;";
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
					$tupla    = mysql_fetch_assoc( $resultados );

					$ID       = $tupla['id_dueno'];
					$nombre   = $tupla['nombre'];
					$apellido = $tupla['apellido'];

					$resultados_     =  mysql_query("select * from DUENO, CAMIONETA where id_dueno=DUENO_id_dueno AND id_dueno=$ID;", $GLOBALS["CONEXION"]) or die ( mysql_error() );
					$num_camionetas  =  mysql_num_rows( $resultados_ );
					//echo $num_camionetas;					
					$disabled_mod = "";
					$disabled_del = "";
 					if( $_SESSION['puesto']=="Admin" ){
						$disabled_mod = ' disabled="disabled" ';
						$disabled_del = ' disabled="disabled" ';
 					}
 					if( $num_camionetas > 0 ){
 						$disabled_del = ' disabled="disabled" ';
 					}
					echo '

			        	<tr class="info">
			        		<td class="info" width="20%" >
			        		'.$ID.'
			        		</td>
			        		<td class="info" width="30%">
			        			'.$nombre.' '.$apellido.'
			        		</td>

			        		<td class="info" width="2%">
			        			<button type="button" data-toggle="modal" data-target="#modal_agregar_dueno" id="boton_agregar_dueno_'.$ID.'">
			  						<span class=" glyphicon glyphicon-plus-sign"></span>
								</button>
			        		</td>
			     
			        		<td class="info" width="2%">
			        			<button type="button" data-toggle="modal" data-target="#modal_ver_dueno" id="boton_ver_dueno_'.$ID.'">
			  						<span class="glyphicon glyphicon-eye-open"></span>
								</button>
			        		</td>
			        		<td class="info" width="2%">
			        			<button type="button" data-toggle="modal" data-target="#modal_modificar_dueno" id="boton_modificar_dueno_'.$ID.'" '.$disabled_mod.'>
			        				<span class="glyphicon glyphicon-pencil"></span>
			        			</button>
			        		</td>
			        		<td class="info" width="2%">
			        			<button type="button" id="boton_eliminar_dueno_'.$ID.'" '.$disabled_del.'>
			        				<span class="glyphicon glyphicon-remove-sign"></span>
			        			</button>
			        		</td>        		
			        	</tr>

			        	<script>
				        	/* mostrar modal ver dueno */
							$( "#boton_ver_dueno_'.$ID.'" ).mousedown(function() {
							       // $("#div_modal_ver_dueno").load("ver_dueno.php?ID='.$ID.'&num='.$num_camionetas.'");		

						        $.ajax({
						            type: "POST",
						            url: "ver_dueno.php",
						            data: "ID='.$ID.'&num='.$num_camionetas.'&nombre='.$nombre.'&apellido='.$apellido.'",
						            success: function(data) {
						            	$("#div_modal_ver_dueno").html(data);
						            }
						        });	 						       				       
							});	


							$( "#boton_modificar_dueno_'.$ID.'" ).mousedown(function() {
							      
						        $.ajax({
						            type: "POST",
						            url: "formulario_modificar_dueno.php",
						            data: "ID='.$ID.'&num='.$num_camionetas.'&nombre='.$nombre.'&apellido='.$apellido.'",
						            success: function(data) {
						            	$("#div_modificar_dueno_modal").html(data);
						            }
						        });	 						       				       
							});							

							$( "#boton_agregar_dueno_'.$ID.'" ).mousedown(function() {
							    $("#div_modal_agregar_dueno").load("formulario_agregar_dueno.php");
							});		


							$( "#boton_eliminar_dueno_'.$ID.'" ).mousedown(function() {
						    
								if( confirm("¿ Desea Eliminar el dueño '.$nombre.' '.$apellido.' ?") ){
							        var dataString = "ID=+'.$ID.'&nombre='.$nombre.'&apellido='.$apellido.'";
							        $.ajax({
							            type: "POST",
							            url: "eliminar_dueno.php",
							            data: dataString,
							            success: function(data) {
							            	$("#alertas_duenos").html(data);
							            }
							        });
									
							        $.ajax({
							            type: "POST",
							            url: "mostrar_tabla_duenos.php",
							            data: "tipo=0",
							            success: function(data) {
							            	$("#div_mostrar_tabla_dueno").html(data);
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
