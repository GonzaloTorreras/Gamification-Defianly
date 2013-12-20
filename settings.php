<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-settings.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-general.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		
	</head>

	<body>
		<?php
		
			//Check the session
			session_start();
			
			if(empty($_SESSION['name'])){
				header ("Location: login.php");
			}
						
			// Create connection
			$con=mysqli_connect("localhost","root","","defiantlyDB");
			
			// Check connection
			if (mysqli_connect_errno()){
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			
			$currentUserID = $_SESSION['id'];
			
			$querySearch = "SELECT * FROM users WHERE id='$currentUserID'";
			$result = mysqli_query($con,$querySearch);
			$user = mysqli_fetch_array($result);
			
			$currentUserName = $user['name'];
			$currentUserImage = $user['image'];
			
			$querySearch = "SELECT * FROM viewchallenges WHERE idUser='$currentUserID'";
			$result = mysqli_query ($con,$querySearch);
			
			$countNoView = mysqli_num_rows($result);		
			
		?>
		
		<?php include ("header.php"); ?>
				  
		<div id="content">
			<div id="area-3">
			
	    		<div id="area-3-section">
					
	    			<div id="area-3-section-1" class="section">
	    				<div id="area-3-section-1-header" class="section-header shadow-box">
							<p class="section-header-text text"><span style="font-weight:bold;">Configurar cuenta</span></p>
						</div>
						
						<div id="area-3-section-1-data" class="section-data text shadow-box">
							
							<form id="configuration-user" method="post" action="operations.php" enctype="multipart/form-data">
								
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">Nombre: </div>
									<div class="area-3-section-1-data-elements2"><input  style="height: 20px; width: 950px;" type="text" class="text" name="nameUser"></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">Apellido: </div>
									<div class="area-3-section-1-data-elements2"><input  style="height: 20px; width: 950px;" type="text" class="text" name="lastnameUser"></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">Contrase&ntilde;a: </div>
									<div class="area-3-section-1-data-elements2"><input  style="height: 20px; width: 950px;" type="text" class="text" name="passUser"></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">Confirmar contrase&ntilde;a: </div>
									<div class="area-3-section-1-data-elements2"><input  style="height: 20px; width: 950px;" type="password" class="text" name="validationPassUser"></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">Imagen de perfil: </div>
									<div class="area-3-section-1-data-elements2"><input type="file" class="text" name="imageUser"></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<input type="submit" value="Modificar perfil">
								</div>
								<input type="hidden" name="idUser" value="<?php echo $_SESSION['id'];?>">
								<input type="hidden" class="text" name="operation" value="update">
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