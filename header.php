
<div id="header">
	<div id="header-data">	
		<div id="image-logo">
			<a href="index.php"><img id="logo-darkblue" src="./images/logo-darkblue2.png" width="120" height="40"></a>
		</div>
		<div id="text-welcome" class="text">
			<?php
			$rute = "./images/m" . $countNoView . ".png";
			?>
			Bienvenido, <?php echo $currentUserName;?> ¡Tienes <a href="allchallenges.php?idUser=<?php echo $currentUserID;?>"><img style="margin:0 0 -4px 0;border-radius:1000px; width:20px;" src="<?php echo $rute;?>"></a> nuevo/s reto/s!
		</div>
		<div id="buttons-header">
			<form name="closeSessionForm" method="post" action="operations.php">
				<input type="hidden" name="operation" value="closeSession">
				
				<img style="margin-left:-10px; 10px;border-radius: 1000px; height:50px; width:50px;" src="data:image/jpeg;base64,<?php echo base64_encode($currentUserImage); ?>" />
				
				<input id="button-close" type="submit" value="Cerrar Sesi&oacute;n">
				
			</form>
		</div>
		<div id="icons-header">
				
			<a href="index.php" ><img title="Inicio" class="shadow-box" style="margin-bottom:10px;border-radius: 1000px; height:50px; width:50px;" src="./images/home-icon.png" /></a>
			<a href="allrequirements.php" ><img title="Ver todos los requisitos" class="shadow-box" style="margin-bottom:10px;border-radius: 1000px; height:50px; width:50px;" src="./images/requirements-icon.png" /></a>
			<a href="allchallenges.php" ><img title="Ver todos los retos" class="shadow-box" style="margin-bottom:10px;border-radius: 1000px; height:50px; width:50px;" src="./images/challenge-icon.png" /></a>
			<a href="settings.php"><img title="Configuración" class="shadow-box" style="margin-bottom:10px;border-radius: 1000px; height:50px; width:50px;" src="./images/settings-icon.png" /></a>	
			<img style="margin:10px 0 20px 0;width:50px;" src="./images/icon-all2.png" />
			
			<?php
			
				$query = "SELECT * FROM users WHERE id=$currentUserID";
				$result = mysqli_query($con, $query);
				$user = mysqli_fetch_array($result);
				$wins = $user['wins'];
				
				for($i=0; $i<$wins; $i++){ ?>
							
					<img title="Reto ganado" class="shadow-box" style="margin: 0 0 10px 10px; border-radius: 1000px; height:30px; width:30px;" src="./images/medal3.png" />
					
				<?php }
				
			?>
			
			
					
		</div>
	</div>
</div>