<?php @session_start();
if(!isset($_SESSION['usuario'])) 
{
	echo '<script> location.href = "login.php"; </script>';
	exit();
}
	echo '<script> location.href = "inicio.php"; </script>';
?>