<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-general.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-index.css">
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
			
			<div id="area-1">
			
	    		<div id="area-1-section">
					
	    			<div id="section-1" class="section">
	    				<div class="section-header">
							<p class="section-header-text text"><span style="font-weight:bold;">&Uacute;ltimos requisitos</span></p>
						</div>
						
						<div id="section-1-data" class="section-data">
							
							<script>
		    					function sendChallenge(idReq2){
		    						document.newChallengeIndex.idReq.value = idReq2.id;
		    						document.newChallengeIndex.submit();
		    					}
		    				</script>
		    				
		    				<form name="newChallengeIndex" id="newChallengeIndex-id" action="challenge.php" method="GET">
		    					<input type="hidden" name="idReq" value="">
		    				</form>
			    			
			    			<?php
			    			
			    				$queryReq = "SELECT * FROM requirements WHERE (challenge IS NULL OR challenge=2) ORDER BY dateReq DESC";
			    				$result = mysqli_query($con,$queryReq);
								
								//Only show the last 4 requirements
								for($i=0; $i<4; $i++){
									
									$row = mysqli_fetch_array($result);
									$idUserReq = $row['user'];
									
									//Search the image of the user
									$queryImageUser = "SELECT * FROM users WHERE id='$idUserReq'";
				    				$result2 = mysqli_query($con,$queryImageUser);
									$imageUser;
									while($row2 = mysqli_fetch_array($result2)){
						  				$imageUser = $row2['image'];
									}
				    			
								  ?>
								  <div id="section-1-element" class="text shadow-box">
								  
								  	<div id = "element-header">
								  		
								  		<div id = "element-header-image">
								  			<img style="height:60px; width:60px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageUser); ?>" /> 							  		
											
										</div>
								  		<div id = "element-header-name">
										  	<p><?php echo $row['idReq']; ?></p> 
										  	<p><?php echo $row['nameReq'];?></p>
										  	
								  		</div>
								  		 <div id="element-header-buttons">
								  		 	<?php if($row['challenge'] == 2){ ?>
										  		<a href="detail.php?idReq=<?php echo $row['id'];?>"><img title="Ver detalles" style="float:left; border-radius:1000px; width:30px; margin: -18px 0 0 90px;" src="./images/icon-all.png"></a>
										  	<?php } ?>
									  			<img title="¡Desafiar!" style="cursor: pointer; float:right; width:30px; margin: -18px -12px 0 0;" id="<?php echo $row['id'];?>" src="./images/icon-challenge.png" onclick="sendChallenge(this)">
										 </div>
								  	
									</div>
									  	
									<div id="element-descrip">
									  		<div id="descrip-data">
												<p><?php echo $row['descrip'];?></p>
									  		</div>				  		
									</div>
									  
								  </div>
								<?php } ?>	
			    			</div>
					</div>
	    				    			
		    		<div id="section-2" class="section">
		    			
		    			<div class="section-header">
							<p class="section-header-text text"><span style="font-weight:bold;">&Uacute;ltimos desaf&iacute;os</span></p>
						</div>
						
						<script>
	    					function openChallenge(idReq2){
	    						document.openChallengeIndex.idReq.value = idReq2.id;
	    						document.openChallengeIndex.submit();
	    					}
	    				</script>
	    				
	    				<form name="openChallengeIndex" id="openChallengeIndex-id" action="detail.php" method="GET">
	    					<input type="hidden" name="idReq" value="">
	    				</form>
						
						<div id="section-2-data" class="section-data">
							
		    				<?php
		    				
			    				$queryChallenge = "SELECT * FROM requirements WHERE challenge=1 ORDER BY dateReqC DESC";
			    				$result = mysqli_query($con,$queryChallenge);
								
								for($j = 0; $j<4 ; $j++)
					  			{
								  $row = mysqli_fetch_array($result);
								  
								  if(!empty($row)){
														
										$idUser1 = $row['user'];
									  	$idUser2 = $row['userC'];
															
										$queryUser1 = "SELECT * FROM users WHERE id='$idUser1'";
										$queryUser2	= "SELECT * FROM users WHERE id='$idUser2'";				
														
										$result1 = mysqli_query($con,$queryUser1);				
										$result2 = mysqli_query($con,$queryUser2);			
													
										$user1 = mysqli_fetch_array($result1);		
										$user2 = mysqli_fetch_array($result2);		
											
										$imageUser1 = $user1['image'];
										$imageUser2 = $user2['image'];	
										
										$votesUser1 = $row['votes'];
										$votesUser2 = $row['votesC'];
									
								  	 ?>
								  		<div class="section-2-element text shadow-box">
									  
									  		<div id="element-2-name">
									  			<div style="float:left;">
									  				<?php echo $row['idReq']; ?>
									  			</div>
									  			<div style="float:right;">
									  				<a href="detail.php?idReq=<?php echo $row['id'];?>"><img title="Ver detalles" style="border-radius:1000px; width:30px; margin: -5px -5px 0 0;" src="./images/icon-all.png"></a>
									  			</div>
									  		</div>
									  		<div class="element-2-user">
									  			<div class="element-2-userimage">
									  				<img style="border-radius:100px;height:70px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageUser1); ?>" />								  		
									  			</div>
									  			<div class="element-2-uservotes">
									  				<?php echo $votesUser1;?>
									  			</div>
									  		</div>
									  		<div id="icon-challenge">
									  			<!-- <img style="cursor: pointer; height:20px;" id="<?php echo $row['id'];?>" src="./images/icon-challenge.png" onclick="openChallenge(this)"> -->
									  		</div>
									  		<div class="element-2-user">
									  			<div class="element-2-userimage">
									  				<img style="border-radius:100px;height:70px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageUser2); ?>" />	
									  			</div>
									  			<div class="element-2-uservotes">
									  				<?php echo $votesUser2;?>
									  			</div>
									  		</div>
									  
								 	 	</div>
								  	<?php
									
								  }
								 
								}
			    			?>
		    			
						</div>
		    			
		    			</div>
		    			
		    	</div>
	    	
	    	</div>
	    	
	    	<div id="area-2">
			
	    		<div id="area-2-section">
					
	    			<div id="area-2-section-1" class="section">
	    				<div class="section-header">
							<p class="section-header-text text"><span style="font-weight:bold;">Mi &uacute;ltimo desafio</span></p>
						</div>
						
						<div id="area-2-section-1-data" class="section-data text">
							
			    			<?php
			    			
		    					$idUser = $_SESSION['id'];
		    					
			    				$consulta = "SELECT * FROM requirements WHERE challenge IS NOT NULL AND (user='$idUser' OR userC='$idUser') ORDER BY dateReqC DESC";
			    				$result = mysqli_query($con,$consulta);
								
								$row = mysqli_fetch_array($result);
								
								if(!empty($row)){
									
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
											<div id="area-2-section-1-element-data-bottom" style="float:right; margin-right:20px;"><img style="width:30px; float:left; margin: -5px -25px 0 0; cursor:pointer;" id="<?php echo $row['id'];?>" onclick="openChallenge(this)" src="./images/icon-all.png"></div>
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
													<div class="area-2-section-1-element-votes" style="margin: -40px 0 0 20px; background-color: rgba(252, 252, 0, 0.1);"><div style="margin: 45px 0 0 0; text-align: center; font-size:30px;"><?php echo $row['votesC'];?></div></div>
												<?php } if($userWin == 2) { ?>
													<div class="area-2-section-1-element-data" style="background-color: rgba(0, 252, 30, 0.1);"><?php echo $row['nameReqC'];?></div>
								  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(0, 252, 30, 0.1);"><?php echo $row['descrip'];?></div>
													<div class="area-2-section-1-element-votes" style="margin: -40px 0 0 20px; background-color: rgba(0, 252, 30, 0.1);"><div style="margin: 45px 0 0 0; text-align: center; font-size:30px;"><?php echo $row['votesC'];?></div></div>
												<?php } if($userWin == 1){ ?>
													<div class="area-2-section-1-element-data" style="background-color: rgba(252, 0, 0, 0.1);"><?php echo $row['nameReqC'];?></div>
								  					<div class="area-2-section-1-element-data" style="height:80px;background-color: rgba(252, 0, 0, 0.1);"><?php echo $row['descrip'];?></div>
													<div class="area-2-section-1-element-votes" style="margin: -40px 0 0 20px; background-color: rgba(252, 0, 0, 0.1);"><div style="margin: 45px 0 0 0;  text-align: center; font-size:30px;"><?php echo $row['votesC'];?></div></div>
												<?php } ?>
								  			
								  			</div>
										  	<div style="float:left;"><img style="border-radius:10px; width:128px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageC); ?>" /></div>
								  		</div>
								 		
								  	</div>
								  								
							<?php 

								}else{
									echo "No tienes retos aun!";
								}

							?>	
			    			</div>
					</div>
	    				
		    	</div>
	    	
	    	</div>
	    	
	    </div>
		
		
		<!-- Include the footer -->
		<?php include ("footer.php"); ?>
		
		<?php
				if(!empty($_SESSION['err'])){
				?>
					<script>
						alert("<?php echo $_SESSION['err'];?>");
					</script>
				<?php
				
				$_SESSION['err'] = null;
			}
				
				
			//Close server
			mysqli_close($con);
	
		?>	
	</body>
</html>