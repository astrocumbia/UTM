<?php

  include("funciones.php");
  init_conexion( ); 


  $usuario = $_POST["admin"];   
  $password = $_POST["password_usuario"];
 

  $result = mysql_query("SELECT * FROM USUARIOS WHERE login = '$usuario'");
 
  if($row = mysql_fetch_array($result))
  {     
    if($row["pass"] == $password)
    {
    
      @session_start();  
      $_SESSION['usuario'] = $usuario;
      $_SESSION['nombre']  = $row['nombre'];
      $_SESSION['puesto']  = $row['tipo'];
      $_SESSION['base']    = $row['base'];
      echo '<script> location.href = "inicio.php"; </script>';  
    }
  else
  {
    echo '
       <script languaje="javascript">
        alert("Contraseña Incorrecta!");
        location.href = "login.php";
       </script>
    ';
             
 }
}
else
{
  echo '
   <script languaje="javascript">
    alert("El nombre de usuario es incorrecto!");
    location.href = "login.php";
   </script>';

         
}
 
//Mysql_free_result() se usa para liberar la memoria empleada al realizar una consulta
mysql_free_result($result);
 
/*Mysql_close() se usa para cerrar la conexión a la Base de datos y es 
**necesario hacerlo para no sobrecargar al servidor, bueno en el caso de
**programar una aplicación que tendrá muchas visitas ;) .*/
mysql_close();

?>