<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-login.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-general.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>
		<?php
		
			//Check the session
			session_start();
			
			// Create connection
			$con=mysqli_connect("localhost","root","","defiantlyDB");
			
			// Check connection
			if (mysqli_connect_errno()){
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
		?>
		
		<div id="header">
			<div id="header-data">	
				<div id="image-logo">
					<a href="index.php"><img id="logo-darkblue" src="./images/logo-darkblue2.png" width="150" height="40"></a>
				</div>
				<div id="text-welcome" class="text">
					Bienvenido, desconocido!
				</div>
			</div>
		</div>
		 
		<div id="content">
			<div id="area-1"  style="height:550px;">
	    		<div id="area-1-section" class="text">
					
					<div id="text-login">
						<p class="text"><span style="font-weight: bold;">Bienvenido a Defiantly!</span> Si eres nuevo por aqu&iacute; tienes que saber que es 
						necesario registrarte para poder retar a tus compa&ntilde;eros. Si ya eres un viejo
						amigo, inicia sesi&oacute;n y suerte con los desafios!</p>
					</div>
					
	    			<div id="section-1" class="section">
					
						<div id="section-1-login">
							
								<form name="login-user" method="POST" action="operations.php">
										<input type="hidden" name="operation" value="login">
										
										<div id="form-login-1">
											Email:&nbsp;&nbsp; <input class="text" type="text" name="emailUser">
										</div>
										
										<div id="form-login-2">
											Contrase&ntilde;a:&nbsp;&nbsp; <input class="text" type="password" name="passUser">
										</div>
										
										<div id="form-login-3">
											<input type="submit" class="button" value="Adelante!">
										</div>			
								</form>
							
						</div>	
						
						<div id="section-1-registration">
							<form name="new-user" method="POST" action="operations.php" enctype="multipart/form-data">
									<input type="hidden" name="operation" value="registration">
									
									<div class="registration-left">
										Nombre:
									</div>
									<div class="registration-right">
										<input type="text" style="width:400px;" class="text" name="nameUser">
									</div>
									
									<div class="registration-left">
										Apellido:
									</div>
									<div class="registration-right">
										<input type="text" style="width:400px;"  class="text" name="lastNameUser">
									</div>
									
									<div class="registration-left">
										Email:
									</div>
									<div class="registration-right">
										<input type="text" style="width:400px;"  class="text" name="emailUser"><br>
									</div>
									
									<div class="registration-left">
										Contrase&ntilde;a: 
									</div>
									<div class="registration-right">
										<input type="password" style="width:400px;"  class="text" name="passUser">
									</div>
									
									<div class="registration-left">
										Repite Contrase&ntilde;a:
									</div>
									<div class="registration-right">
										<input type="password" style="width:400px;"  class="text" name="passUser">
									</div>
									
									<div class="registration-left">
										Imagen de perfil:
									</div>
									<div class="registration-right">
										<input type="file" class="text" name="imageUser">
									</div>
									
									<div id="button-registration">
										<input type="submit" class="button" value="Registrarme!">		
									</div>
									
							</form>
						</div>
					</div>
	    				
		    	</div>
		    	
			</div>	
		</div> 
			
				
			
			
		
		
		<div id="footer">
			<div style="width:100%;height:100%;background-color:rgba(0, 0, 0, 0.47);">Footer</div>
		</div>
		
		
		<?php
		
			//Close server
			mysqli_close($con);
	
		?>	
</html>