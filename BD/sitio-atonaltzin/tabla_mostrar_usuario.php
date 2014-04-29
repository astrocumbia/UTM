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
	init_conexion( );
//	echo '<br><br>'.$_SESSION['usuario'].'<br>'; 
?>
	<!--TABLA PARA RESULTADOS-->
	<div class="col-md-1"></div>
	<div class="table-responsive col-md-10 col-lg-offset-1">
  		<table class="table table-hover" id="tabla_resultados">
	  		<!--FILA ENCABEZADO -->
	        <thead>  
	          <tr>  
	            <th bgcolor="#45A0FF"> Identificador </th>  
	            <th bgcolor="#45A0FF"> Nombre </th>  
	            <th bgcolor="#45A0FF"> Username </th>
	            <th bgcolor="#45A0FF"> Tipo </th>  
	            <th bgcolor="#45A0FF"> Base </th>  
	            <th > </th>
	            <th > </th>
	            <th > </th>
	            <th > </th>
	            <th>  </th>
	          </tr>  
	        </thead> 

	        <!--CUERPO DE TABLA-->
	        <tbody>
	        	<?php 
	        	if( $_POST['tipo']==2)
	        		$result = preg_replace("/[^0-9]/","", $_POST['valor']); 

	        		if( $_POST['tipo']==1 || $_POST['valor']=="" || ($_POST['campo']=="idUSUARIOS" && $result==false) )
	        			tabla_mostrar_usuarios( ); 
	        		else{
	        			$rows=tabla_mostrar_usuarios_busqueda( $_POST['campo'], $_POST['valor']);
	        			echo'
	        				<script type="text/javascript">
	        					$( "#div_alerta_usuarios" ).load("ocurrencias_usuarios.php?num='.$rows.'");
	        				</script>
	        			';
	        		}
	        	?>
	        </tbody>
    		
  		</table>

	</div>

