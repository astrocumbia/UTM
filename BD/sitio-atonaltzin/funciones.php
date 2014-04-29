<?php

	/* VARIABLES GLOBALES */
/*
	$usuario       =  "extjs_equipo1";
	$password      =  "equipo1#";
	$basedatos     =  "extjs_equipo1";
	$servidor      =  "localhost";
*/
	$usuario       =  "irvin";
	$password      =  "irvin";
	$basedatos     =  "mydb";
	$servidor      =  "localhost";

	$CONEXION;

	/* Generar las corridas para un select */
	function select_horas( )
	{
		for( $i=3; $i < 22; $i++ ){
			for ($j=0; $j <2 ; $j++) { 
				if( $j == 0 )
					echo '<option value="'.$i.'_'.'0">'.$i.':00 </option>';
				else
					echo '<option value="'.$i.'_'.'3">'.$i.':30 </option>';
			}
		}
	}

	/* inicializar la conexion, llamar solo una vez */
	function init_conexion( ){

		$GLOBALS["CONEXION"] = mysql_connect( $GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["password"] ) or die(mysql_error() );
		mysql_select_db( $GLOBALS["basedatos"], $GLOBALS["CONEXION"] );	
	}

	/* Genera las suburban disponibles en la base */
	function select_suburban_disponibles( $base ){
		$myquery      =  "select * from CAMIONETA, ESTADO where CAMIONETA.ESTADO_id_estado=ESTADO.id_estado &&  ESTADO.descripcion='".$base."';";
		$resultados   =  mysql_query( $myquery, $GLOBALS["CONEXION"] ) or die ( mysql_error() );
		$rows         =  mysql_num_rows( $resultados );

		for ($i=0; $i < $rows ; $i++) { 
			$tupla = mysql_fetch_assoc( $resultados );
			$id_camioneta = $tupla['id_camioneta'];
			//print_r( $tupla );
			echo '<option value="'.$id_camioneta.'" > Camioneta '.$id_camioneta.' </option>' ;
		}
	}


	function select_cuotas(  ){
		$myquery      =  "select * from CUOTA where descripcion like 'oaxaca-%';";
		$resultados   =  mysql_query( $myquery, $GLOBALS["CONEXION"] ) or die ( mysql_error() );
		$rows         =  mysql_num_rows( $resultados );

		for ($i=0; $i < $rows ; $i++) { 
			$tupla = mysql_fetch_assoc( $resultados );
			$id_camioneta = $tupla['id_cuota'];
			//print_r( $tupla );
			echo '<option value="'.$id_camioneta.'" > Camioneta '.$id_camioneta.' </option>' ;
		}		
	}


	        	    

	function tabla_mostrar_usuarios( ){
		$myquery     = "select * from USUARIOS;";
		$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
		$rows        = mysql_num_rows( $resultados );
		$disable     = 0;
		if( $_SESSION['puesto']=="Admin"){
			$disable = 1;
		}
		for ($i=0; $i < $rows ; $i++) {
			$tupla   = mysql_fetch_assoc( $resultados );
			/*echo $tupla['idUSUARIOS'].'<br>';
			echo $tupla['nombre'].'<br>';
			echo $tupla['login'].'<br>';
			echo $tupla['tipo'].'<br>';
			echo  $tupla['base'].'<br>';*/
			echo '<tr class="info" >';
			echo '<td class="info" width="5%"> '.$tupla['idUSUARIOS'].' </td>';
			echo '<td class="info" width="19%"> '.$tupla['nombre'].'</td>';
			echo '<td class="info" width="10%"> '.$tupla['login'].'</td>';
			echo '<td class="info" width="13%"> '.$tupla['tipo'].'</td>';
			echo '<td class="info" width="13%"> '.$tupla['base'].'</td>'; 
			echo  '<td class="info" width="2%">
					<button type="button" data-toggle="modal" data-target="#modal_agregar" id="boton-agregar-modal-'.$tupla['idUSUARIOS'].'">
							<span class="glyphicon glyphicon-plus-sign"></span>
					</button>	        	    	
			    </td>

				<td class="info" width="2%">
					<button type="button" data-toggle="modal" data-target="#modal_ver" id="boton-ver-modal-'.$tupla['idUSUARIOS'].'">
							<span class="glyphicon glyphicon-eye-open"></span>
					</button>
				</td>
				<td class="info" width="2%">
					<button type="button" data-toggle="modal" data-target="#modal_modificar" id="boton-modificar-modal-'.$tupla['idUSUARIOS'].'" '; if($disable==1 && $tupla['tipo']!="Taquillero") echo'disabled="disabled"';

					echo'>
							<span class="glyphicon glyphicon-pencil"></span>
					</button>
				</td>
				<td class="info" width="2%">
					<button type="button" id="boton-eliminar-modal-'.$tupla['idUSUARIOS'].'"';if($disable==1 && $tupla['tipo']!="Taquillero") echo'disabled="disabled"';
					echo '>
						<span class="glyphicon glyphicon-remove-sign" ></span>
					</button>
				</td>   
			  </tr>';

			 echo '
			 	<script>
					$( "#boton-ver-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
					    $( "#div-modal-ver" ).load("mostrar_usuarios.php?ID='.$tupla['idUSUARIOS'].'");    
					  });
					
				   	$( "#boton-agregar-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
				    	$( "#div-modal-agregar" ).load("formulario_agregar_usuario.php"); 

				  	});
					
				   	$( "#boton-modificar-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
				    	$( "#div-modal-modificar" ).load("formulario_modificar_usuario.php?ID='.$tupla['idUSUARIOS'].'");    
				  	});


				   	$( "#boton-eliminar-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
				    
						if( confirm("¿ Desea Eliminar al Usuario '.$tupla['nombre'].' ?") ){
					        var dataString = "ID="+'.$tupla['idUSUARIOS'].';
					        $.ajax({
					            type: "POST",
					            url: "eliminar_usuario.php",
					            data: dataString,
					            success: function(data) {
					            	$("#div_alerta_usuarios").html(data);
					            }
					        });
							
							/* mostrar tabla de usuarios */
					        $.ajax({
					            type: "POST",
					            url: "tabla_mostrar_usuario.php",
					            data: "tipo=1",
					            success: function(data) {
					            	$("#div_mostrar_usuarios").html(data);
					            }
					        });						        	   		
					   	  
						}
						else{

						}
				    	
				    	
				  	});


				</script>
			 ';

		}
	}

	function tabla_mostrar_usuarios_busqueda( $campo, $valor ){
		if( $campo == "idUSUARIOS" ) $myquery     = "select * from USUARIOS where ".$campo."=".$valor.";";
		else $myquery     = "select * from USUARIOS where ".$campo." like '%".$valor."%';";
		$resultados  = mysql_query( $myquery, $GLOBALS["CONEXION"]) or die ( mysql_error() );
		$rows        = mysql_num_rows( $resultados );
		$disable     = 0;
		if( $_SESSION['puesto']=="Admin"){
			$disable = 1;
		}
		for ($i=0; $i < $rows ; $i++) {
			$tupla   = mysql_fetch_assoc( $resultados );
			/*echo $tupla['idUSUARIOS'].'<br>';
			echo $tupla['nombre'].'<br>';
			echo $tupla['login'].'<br>';
			echo $tupla['tipo'].'<br>';
			echo  $tupla['base'].'<br>';*/
			echo '<tr class="info" >';
			echo '<td class="info" width="5%"> '.$tupla['idUSUARIOS'].' </td>';
			echo '<td class="info" width="19%"> '.$tupla['nombre'].'</td>';
			echo '<td class="info" width="10%"> '.$tupla['login'].'</td>';
			echo '<td class="info" width="13%"> '.$tupla['tipo'].'</td>';
			echo '<td class="info" width="13%"> '.$tupla['base'].'</td>'; 
			echo  '<td class="info" width="2%">
					<button type="button" data-toggle="modal" data-target="#modal_agregar" id="boton-agregar-modal-'.$tupla['idUSUARIOS'].'">
							<span class="glyphicon glyphicon-plus-sign"></span>
					</button>	        	    	
			    </td>

				<td class="info" width="2%">
					<button type="button" data-toggle="modal" data-target="#modal_ver" id="boton-ver-modal-'.$tupla['idUSUARIOS'].'">
							<span class="glyphicon glyphicon-eye-open"></span>
					</button>
				</td>
				<td class="info" width="2%">
					<button type="button" data-toggle="modal" data-target="#modal_modificar" id="boton-modificar-modal-'.$tupla['idUSUARIOS'].'" '; if($disable==1 && $tupla['tipo']!="Taquillero") echo'disabled="disabled"';

					echo'>
							<span class="glyphicon glyphicon-pencil"></span>
					</button>
				</td>
				<td class="info" width="2%">
					<button type="button" id="boton-eliminar-modal-'.$tupla['idUSUARIOS'].'"';if($disable==1 && $tupla['tipo']!="Taquillero") echo'disabled="disabled"';
					echo '>
						<span class="glyphicon glyphicon-remove-sign" ></span>
					</button>
				</td>   
			  </tr>';

			 echo '
			 	<script>
					$( "#boton-ver-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
					    $( "#div-modal-ver" ).load("mostrar_usuarios.php?ID='.$tupla['idUSUARIOS'].'");    
					  });
					
				   	$( "#boton-agregar-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
				    	$( "#div-modal-agregar" ).load("formulario_agregar_usuario.php"); 

				  	});
					
				   	$( "#boton-modificar-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
				    	$( "#div-modal-modificar" ).load("formulario_modificar_usuario.php?ID='.$tupla['idUSUARIOS'].'");    
				  	});


				   	$( "#boton-eliminar-modal-'.$tupla['idUSUARIOS'].'" ).mousedown(function() {
				    
						if( confirm("¿ Desea Eliminar al Usuario '.$tupla['nombre'].' ?") ){
					        var dataString = "ID="+'.$tupla['idUSUARIOS'].';
					        $.ajax({
					            type: "POST",
					            url: "eliminar_usuario.php",
					            data: dataString,
					            success: function(data) {
					            	$("#div_alerta_usuarios").html(data);
					            }
					        });
							
							/* mostrar tabla de usuarios */
					        $.ajax({
					            type: "POST",
					            url: "tabla_mostrar_usuario.php",
					            data: "tipo=1",
					            success: function(data) {
					            	$("#div_mostrar_usuarios").html(data);
					            }
					        });						        	   		
					   	  
						}
						else{

						}
				    	
				    	
				  	});


				</script>
			 ';

		}
		return $rows;
	}


	/* imprime la seccion de inicio de la barra de navegacion */
	function imprime_seccion_inicio( $cargo, $estoy ){
		$active = "";
		if( $estoy == 1 )
			$active = "active";
		echo'
			    <!-- PESTAÑA INICIO -->  
			        <li  class="'.$active.'">
			        	<a href="inicio.php" >
				        	<span class="glyphicon glyphicon-home"></span>
				        	Inicio
				        </a>
				    </li>			
		';
	}


	/* imrpime la seccion boletos de la barra de navegacion */
	function imprime_seccion_boletos( $cargo, $estoy ){
		$active = "";
		if( $estoy == 1 )
			$active = "active";
		echo '
		<!-- PESTAÑA Boletos --> 
	        <li class="dropdown '.$active.'" >
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
	          	<span class="glyphicon glyphicon-tag"></span>
	          	Boletos 
	          	<b class="caret"></b>
	          </a>
	          <ul class="dropdown-menu">
	            <li><a href="boletos_venta.php">Venta</a></li>
	            <li><a href="boletos_reserva.php">Reserva</a></li>
	            <li><a href="boletos_buscar.php">Buscar</a></li>
	          </ul>
	        </li>
		';
	}

	function imprime_seccion_reportes( $cargo, $estoy ){
		/* rechaza al taquillero :( */
		if( $cargo == "Taquillero")
			return;

		$active = "";
		if( $estoy == 1 )
			$active = "active";

		echo '
		    <!-- PESTAÑA REPORTES --> 
		        <li class="'.$active.'">
		        	<a href="reportes.php">
		        		<span class="glyphicon glyphicon-list-alt"></span>
		        		Reportes
		        	</a>
		        </li>
		';
	}

	function imprime_secccion_administracion( $cargo, $estoy ){
		if( $cargo == "Taquillero" )
			return;
		$active = "";
		if( $estoy == 1 )
			$active =  "active";
		echo '

	    <!-- PESTAÑA ADMINISTRACION --> 
	        <li class="dropdown '.$active.'">
	          <a href="reportes.php" class="dropdown-toggle" data-toggle="dropdown"> 
	          	<span class="glyphicon glyphicon-user"></span>
	          	Administración 
	          	<b class="caret"></b>
	          </a>
	          <ul class="dropdown-menu">
	            <li><a href="administracion_suburban.php">Camionetas</a></li>	            
	            <li><a href="administracion_choferes.php">Choferes</a></li>
	            <li><a href="administracion_cuotas.php"  >Cuotas  </a></li>
	            <li><a href="administracion_duenos.php"  >Dueños  </a></li>					          	
	            <li><a href="administracion_usuarios.php">Usuarios</a></li>
	          </ul>
	        </li>

		';
	}
?>
