<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-general.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-challenge.css">
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
			
			if(empty($_GET['idReq'])){
				header ("Location: index.php");
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
			
			$idReq = $_GET['idReq'];
			
			$query = "SELECT * FROM requirements WHERE id=$idReq";
			
			$result = mysqli_query($con,$query);
			
			$requirement = mysqli_fetch_array($result);
				
			$idUserC = $_SESSION['id'];
			$idUser = $requirement['user'];
			
			$query2 = "SELECT * FROM users WHERE id=$idUser";
			
			$result = mysqli_query($con,$query2);
			
			$user2 = mysqli_fetch_array($result);
			
			$imagen = $user2['image'];
						
			if($currentUserID == $idUser){
				$_SESSION['err'] = "No puedes retarte a ti mismo.";
				header ("Location: allrequirements.php");
			}
			
		?>
		
		<?php include ("header.php"); ?>
		
		<div id="content">
			
			<div id="area-1">
			
	    		<div id="area-1-section">
					
	    			<div id="section-1" >
	    										
						<div id="info" class="text">
							<div class="info-section" style="margin: 0 0 0 0;">
								<img src="./images/info1.png" class="shadow-box" style="border-radius: 1000px; width:150px; ">
								<h3>Creatividad</h3>
								<p>Recuerda dejar fluir tu creatividad cuando escribas nuevos requisitos, la diferencia entre la victoria y la derrota puede estar en la originalidad de tu propuesta.</p>
							</div>
							<div class="info-section">
								<img src="./images/info2.png" class="shadow-box" style="border-radius: 1000px; width:150px; ">
								<h3>Formato correcto</h3>
								<p>Los requisitos deben estar escritos de forma clara y concisa. No utilices la forma negativa y evitas las ambiegüedades. Escribe como Dios manda.</p>
							</div>
							<div class="info-section">
								<img src="./images/info3.png" class="shadow-box" style="border-radius: 1000px; width:150px; ">
								<h3>Persistenc&iacute;a</h3>
								<p>No te olvides que una vez lances el reto no habr&aacute; vuelta atr&aacute;s. No podr&aacute;s borrar lo escrito hasta el fin del desaf&iacute;o. No te tomes los retos a la ligera.</p>
							</div>
							<div class="info-section">
								<img src="./images/info4.png" class="shadow-box" style="border-radius: 1000px; width:150px;">
								<h3>Competici&oacute;n</h3>
								<p>Ante todo esto es una competición. Intenta ser buen rival y compa&ntilde;ero. Recuerda que siempre podr&aacute;s ver el desarrollo del desaf&iacute;o. ¡A por todas!</p>
							</div>
							
							
						</div>
						
						
						
						
						<div id="oponent1" class="shadow-box text">
							<div class="oponent-data">
								<?php echo $requirement['idReq'];?>
							</div>
	    					<div class="oponent-data" style="height: 50px;">
								<?php echo $requirement['nameReq'];?>
							</div>
							<div class="oponent-data" style="height: 250px;">
								<?php echo $requirement['descrip'];?>
							</div>
							<div id="image-user">
								<img style="width:100%; border-radius: 1000px;" src="data:image/jpeg;base64,<?php echo base64_encode($imagen); ?>">
							</div>
							<div id="user-medals">
								
								<?php for($i=0; $i<$user2['wins']; $i++){ ?>
									<img style="width:30px; border-radius: 1000px;" src="./images/medal.png" title="Reto ganado">
								<?php } ?>
 								
							</div>
							<div id="user-wins">
								<?php echo $user2['name']. " ha ganado " . $user2['wins'] .  " desafios"?>
							</div>	
						</div>
						
						<div id="oponent2" class="shadow-box text">
							<script>
								function challenge(){
									document.getElementById("new-challenge-id").submit();
								}
							</script>
						
							<form name="new-challenge" id="new-challenge-id" action="operations.php" method="post">
								<input type="hidden" name="operation" value="newChallenge">
								<input type="hidden" name="idReq" value="<?php echo $idReq;?>">
								<input type="hidden" name="userC" value="<?php echo $idUserC;?>">
								<div class="oponent-data">
									<?php echo $requirement['idReq'];?>
								</div>
								<textarea class="oponent-data2 text" style="height:50px; font-size: 15px;" type="text" name="nameReqC">Escriba aqu&iacute; el nuevo nombre del requisito</textarea>
								<textarea class="oponent-data2 text" style="height: 250px; font-size: 15px;" name="descripC">Escriba aqu&iacute; el nuevo nombre del requisito</textarea>
								<div id="info-challenge">
									¡Recuerda que una vez realices el reto, no podr&aacute;s volver atr&aacute;s! Suerte y que gane el mejor! (Pulsa el bot&oacute;n para avanzar)
								</div>
								<div id="send-challenge">
									<img title="¡Desafiar!" style="cursor:pointer; width:70px; margin:10px; border-radius: 1000px;" onclick="challenge()" src="./images/icon-challenge.png" alt="info">
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