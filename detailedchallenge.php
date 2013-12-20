<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Página principal</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-requirements.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	</head>

	<body>
		
		<?php
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
					<img id="logo-darkblue" src="./images/logo-darkblue.png" width="150" height="40"> 
				</div>
				<div id="text-welcome">
					<h3>Bienvenido, <a href="challenge.php">Daniel</a></h3>
				</div>
				<div id="buttoms-header">
					<h3><a href="closeSession.php">Cerrar sesi&oacute;n</a>
					<a href="configuration.php">Configuraci&oacute;n</a></h3>
				</div>
			</div>
		</div>
		
		<div id="content">
			
			<div id="area-1">
			
	    		<div id="area-1-section">
					
					<div id="menu">
						<div class="options-menu"><a href="challenge.php">RETOS</a>
							<a href="index.php">INICIO</a>
							<a href="requirements.php">REQUISITOS</a>
						</div>
					</div>
					
	    			<div id="section-1" class="section">
	    				
							<?php
								$idReq = $_GET['idReq'];
								
			    				$consulta = "SELECT * FROM requirements WHERE id='$idReq'";
			    				$result = mysqli_query($con,$consulta);
								
								while($row = mysqli_fetch_array($result)){
									$idUsuario = $row['user'];
									$consulta2 = "SELECT * FROM users WHERE id='$idUsuario'";
				    				$result2 = mysqli_query($con,$consulta2);
									
									while($row2 = mysqli_fetch_array($result2)){
						  				$imagen = $row2['image'];
									}
				    			
								  ?>
								  <div id="section-1-element">
								  
								  	<p>Nombre: <?php echo utf8_decode($row['nameReq']); ?></p>
								  	<p>ID req: <?php echo $row['idReq']; ?></p>
								  	<p>Descripción: <?php echo utf8_decode($row['descrip']) ;?></p>
								  	<p>Fecha: <?php echo $row['date'] ;?></p>
								  	<p>ID: <?php echo $row['id'] ;?></p>
								  	<p>User: <?php echo $row['user'];?></p>
								  	
								  	<!-- <img src="data:image/jpeg;base64,<?php echo base64_encode($imagen); ?>" /> -->
								  					  	
								  	<img id="<?php echo $row['id'];?>" src="./images/button.jpg" onclick="sendChallenge(this)" width"20px" height="20px">
								  	
								  	</div>
								<?php } ?>	

					</div>
	    			
		    			
		    	</div>
		    	
	    	
	    	</div>
	    	
	    </div>
		
		
		<div id="footer">
		
		</div>
		
		
		<?php
		
			//Close server
			mysqli_close($con);
	
		?>	
	</body>
</html>