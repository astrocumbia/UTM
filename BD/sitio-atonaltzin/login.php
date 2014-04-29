<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Principal </title>
	<link rel="stylesheet" type="text/css" href="dist/css/bootstrap.css">
	<link href="images/logo_min.png" type="image/x-icon" rel="shortcut icon" />
	<script language="Javascript" type="text/javascript" src="https://code.jquery.com/jquery.js"></script>
	<script language="Javascript" type="text/javascript" src="dist/js/bootstrap.js"></script>
	<script language="Javascript" type="text/javascript" src="tools/script.js"></script>
	
</head>
<body>

<!--BARRA SUPERIOR-->

	<div class="row">
		<div class="col-md-4 col-lg-offset-4">
			<img src="images/atonaltzin-logo.jpg" class="img-responsive" alt="">
		</div>
	</div>
	<br><br><br>
	<!--particion del titulo -->
	<div class="row">
		<div class="col-md-5"></div>
		<div class="col-md-2">
			<h1>
				<span class="glyphicon glyphicon-user"></span>
				Login:
				
			</h1>
		</div>
		<div class="col-md-6"></div>
	</div>
	<br>

	<!--particion principal-->

	<div class="row">

        <form action="validar_usuario.php" method="post">
      
     
            <!--USUARIO -->
            <div class="row">
                <div class="col-md-1 col-lg-offset-4">            
                      <h4>
                      		<label class="control-label ">Usuario :</label>
              		  </h4>
                    </div>
              
            <!-- INPUT USUARIO -->
           
                           
                <div class="col-md-2" >
			   	 <input class="form-control" maxlength="50" size="16" type="text" name="admin" required="required" value="" >
                </div>
            </div>
            <br><br>
            <!--CONRASEÑA-->

            <div class="row">
               <div class="col-md-1 col-lg-offset-4"> 
               		<h4>
                    	<label class="control-label ">Contraseña:</label>
                	</h4>
                </div>
            
            <!-- INPUT CONTRASEÑA-->
           
                
                <div class="col-md-2">
                    <input class="form-control" maxlength="50" type="password" name="password_usuario" required="required" value="" >
                </div>
            </div>
          <br><br>
            <!--PARTICION DE BOTONES-->
            <div class="row">
                <br>
                <div class="col-md-5 "></div>
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </div>
        </form>
       
	</div>


