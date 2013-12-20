<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-allchallenges.css">
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
			
			if(!empty($_GET['idUser'])){
				$deteleNotice = "DELETE FROM viewchallenges WHERE idUser='$currentUserID'";
				mysqli_query($con,$deteleNotice);
			}			
		?>
		
		<?php include ("header.php"); ?>
		 
		<div id="content">
			<div id="area-1">
	    		<div id="section-1">
	    				    			
	    			<?php
	    				$all = true;
	    				if(!empty($_GET['idUser'])){
							$all = false;
							?>
							<div id="area-3-section-1-header" class="section-header">
								<a href="allchallenges.php"><p class="section-header-text text"><span style="font-weight:bold;">Click para ver todos los desaf&iacute;os</span></p></a>
							</div>
							<?php
						}else{ ?>
							<div id="area-3-section-1-header" class="section-header">
								<a href="allchallenges.php?idUser=<?php echo $_SESSION['id'];?>"><p class="section-header-text text"><span style="font-weight:bold;">Click para ir a mis desaf&iacute;os</span></p></a>
							</div>	
							<?php
						}
	    			?>
					
				
					<?php
					$query = "SELECT * FROM requirements WHERE (challenge=1 OR challenge=2) ORDER BY dateReqC DESC";
					if($all == false){
						$userC = $_GET['idUser'];
						$query = "SELECT * FROM requirements WHERE (challenge=1 OR challenge=2) AND (userC='$userC' OR user='$userC') ORDER BY dateReqC DESC";
					}
					
					$result = mysqli_query($con,$query);
					
					while($row = mysqli_fetch_array($result)){
							
						$idUsuario = $row['user'];
						$idUsuarioC = $row['userC'];
						$consulta2 = "SELECT * FROM users WHERE id='$idUsuario'";
						$consulta2C = "SELECT * FROM users WHERE id='$idUsuarioC'";
	    				$result2 = mysqli_query($con,$consulta2);
						$result2C = mysqli_query($con,$consulta2C);
						$image; $imageC;
						while($row2 = mysqli_fetch_array($result2)){
			  				$image = $row2['image'];
						}
						while($row2C = mysqli_fetch_array($result2C)){
			  				$imageC = $row2C['image'];
						}
						
						$userWin = 0;
						if($row['votes'] > $row['votesC']){
							$userWin = 1;
						}
						if($row['votes'] < $row['votesC']){
							$userWin = 2;
						}
							
					
					?>
					
				
					<div id="area-2-section-1-element" class="shadow-box">
				 		<div id="area-2-section-1-element-data">
				 			<div id="area-2-section-1-element-data-id" style="width:50%;float:left;"><?php echo $row['idReq'];?></div>
							<div id="area-2-section-1-element-data-bottom" style="float:right; margin-right:20px;"><a href="detail.php?idReq=<?php echo $row['id'] ;?>"><img style="width:20px; margin-right: -10px; cursor:pointer;" src="./images/icon-all.png"></a></div>
				 			<div id="area-2-section-1-element-data-date" style="float:right; margin-right:50px;"><?php echo $row['dateReqC'];?></div>
						</div>	
				  		<div class="area-2-section-1-element-user" style="border-bottom: 1px solid rgb(218, 218, 218);">
				  			<div style="float:left; margin-top: 15px;"><img style="border-radius:10px; width:128px;" src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" /></div>
				  			<div style="float:left;margin:15px 0 0 20px;width:820px;">
				  				
				  				<?php if($userWin == 0){ ?>
				  					<div class="area-2-section-1-element-votes" style="background-color: rgba(252, 252, 0, 0.1);"><div style="margin: 45px 0 0 0; text-align: center; font-size:30px;"><?php echo $row['votes'];?></div></div>
									<div class="area-2-section-1-element-data" style="background-color: rgba(252, 252, 0, 0.1);"><?php echo $row['nameReq'];?></div>
				  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(252, 252, 0, 0.1);"><?php echo $row['descrip'];?></div>
								<?php } if($userWin == 1) { ?>
									<div class="area-2-section-1-element-votes" style="background-color: rgba(0, 252, 30, 0.1);"><div style="margin: 45px 0 0 0; text-align: center; font-size:30px;"><?php echo $row['votes'];?></div></div>
									<div class="area-2-section-1-element-data" style="background-color: rgba(0, 252, 30, 0.1)";><?php echo $row['nameReq'];?></div>
				  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(0, 252, 30, 0.1)";"><?php echo $row['descrip'];?></div>
								<?php } if($userWin == 2){ ?>
									<div class="area-2-section-1-element-votes" style="background-color: rgba(252, 0, 0, 0.1);"><div style=" margin: 45px 0 0 0; text-align: center; font-size:30px;"><?php echo $row['votes'];?></div></div>
									<div class="area-2-section-1-element-data" style="background-color: rgba(252, 0, 0, 0.1);"><?php echo $row['nameReq'];?></div>
				  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(252, 0, 0, 0.1);"><?php echo $row['descrip'];?></div>
								<?php } ?>
				  				
				  				
				  			</div>
				  			
				  		</div>
				  		<div class="area-2-section-1-element-user" style="margin-top:17px; height:140px;">
				  			
				  			<div style="float:left;width:820px;margin:0 20px 0 0;">
				  				
				  				
				  				<?php if($userWin == 0){ ?>
				  					<div class="area-2-section-1-element-data" style="background-color: rgba(252, 252, 0, 0.1);"><?php echo $row['nameReqC'];?></div>
				  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(252, 252, 0, 0.1);"><?php echo $row['descrip'];?></div>
									<div class="area-2-section-1-element-votes" style="margin: -40px 0 0 20px; background-color: rgba(252, 252, 0, 0.1);">
										<div style="margin: 45px 0 0 0; text-align:center; font-size:30px;">
											<?php echo $row['votesC']; ?>
										</div>
									</div>
								<?php } if($userWin == 2) { ?>
									<div class="area-2-section-1-element-data" style="background-color: rgba(0, 252, 30, 0.1);"><?php echo $row['nameReqC'];?></div>
				  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(0, 252, 30, 0.1);"><?php echo $row['descrip'];?></div>
									<div class="area-2-section-1-element-votes" style="margin: -40px 0 0 20px; background-color: rgba(0, 252, 30, 0.1);">
										<div style="margin: 45px 0 0 0; text-align: center; font-size:30px;">
											<?php echo $row['votesC'];?>
										</div>
									</div>
								<?php } if($userWin == 1){ ?>
									<div class="area-2-section-1-element-data" style="background-color: rgba(252, 0, 0, 0.1);"><?php echo $row['nameReqC'];?></div>
				  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(252, 0, 0, 0.1);"><?php echo $row['descrip'];?></div>
									<div class="area-2-section-1-element-votes" style="margin: -40px 0 0 20px; background-color: rgba(252, 0, 0, 0.1);">
										<div style="margin: 45px 0 0 0; text-align:center; font-size:30px;">
											<?php echo $row['votesC'];?>
										</div>
									</div>
								<?php } ?>
				  			
				  			</div>
						  	<div style="float:left;"><img style="border-radius:10px; width:128px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageC); ?>" /></div>
				  		</div>
				 		
				  	</div>
					
					<?php } ?>
					
				</div>
			</div>
		</div>
		
		<!-- Include the footer -->
		<?php include ("footer.php"); ?>
		
		
		<?php
		
			//Close server
			mysqli_close($con);
	
		?>	
</html>