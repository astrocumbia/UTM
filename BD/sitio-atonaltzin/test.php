<?php 	
	include("funciones.php"); 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>


		<?php 
			init_conexion( );
			$_POST['input-nombre'] = "irvin Castellanos Juarez";
			$_POST['input-usuario'] = "irvin";
			$_POST['input-pass1']   = "irvin";
			$_POST['input-cargo']   = "Admin";
			$_POST['input-base']    = "Oaxaca";
			db_agregar_usuario( $_POST );

		?>		



</body>
</html>