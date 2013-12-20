<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-allrequirements.css">
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
			<div id="area-1">
	    		<div id="section-1">
				
					<div id="area-3-section-1" class="section text">
	    				<div id="area-3-section-1-header" class="section-header">
							<p class="section-header-text text"><span style="font-weight:bold;">A&ntilde;ade un nuevo requisito</span></p>
						</div>
						
						<div id="area-3-section-1-data" class="section-data text shadow-box">
							<form id="new-requirement" method="post" action="operations.php">
								<input type="hidden" name="operation" value="newRequirement";>
								
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">ID: </div>
									<div class="area-3-section-1-data-elements2"><input  style="height: 20px; width: 950px;" type="text" class="text" name="idReq"></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">Nombre: </div>
									<div class="area-3-section-1-data-elements2"><input style="height: 20px; width: 950px;" class="text" type="text" name="nameReq"></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<div class="area-3-section-1-data-elements2">Descripcion:</div>
									<div class="area-3-section-1-data-elements2"><textarea class="text" name="descrip" style="width: 950px; height: 75px;"></textarea></div>
								</div>
								<div class="area-3-section-1-data-elements">
									<input type="submit" value="Crear requisito">
								</div>
								
							</form>				
			    		</div>
					</div>
				
					<?php
					
					$query = "SELECT * FROM requirements ORDER BY dateReq DESC";
					$result = mysqli_query($con, $query);
					$counter = 2;
					while($requirement = mysqli_fetch_array($result)){
									
						$idUser = $requirement['user'];		
						$queryUser = "SELECT * FROM users WHERE id='$idUser'";				
										
						$result2 = mysqli_query($con,$queryUser);			
									
						$user = mysqli_fetch_array($result2);		
							
						$imageUser = $user['image'];
						
						$challenge = $requirement['challenge'];
							
						 if( ($counter % 2) == 0){	?>
						<div id="requirement-content" style="margin-right:20px;" class="shadow-box text">
							
							<div id="image-user"><img style="width:40px; border-radius: 1000px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageUser); ?>"></div>
							
							<?php 
							
							if($challenge==1){
								?>
								<div class="requirement" style="height: 30px; width: 355px; margin-left: 10px;">
									<?php echo $requirement['idReq'];?>
								</div>
								<div id="image-user"><a href="detail.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px; border-radius: 1000px; cursor:pointer;" src="./images/icon-all.png"></a></div> <?php
								
							}if($challenge==0){
								?>
								<div class="requirement" style="height: 30px; width: 355px; margin-left: 10px;">
									<?php echo $requirement['idReq'];?>
								</div>
								<div id="image-user"><a href="challenge.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px; border-radius: 1000px; cursor:pointer;" src="./images/icon-challenge.png"></a></div> <?php
							
							
							}if($challenge==2){
								?>
								<div class="requirement" style="height: 30px; width: 305px; margin-left: 10px;">
									<?php echo $requirement['idReq'];?>
								</div>
								<div id="image-user" style="margin-right:10px;"><a href="detail.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px;border-radius: 1000px; cursor:pointer;" src="./images/icon-all.png"></a></div> <?php
								?><div id="image-user"><a href="challenge.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px; border-radius: 1000px; cursor:pointer;" src="./images/icon-challenge.png"></a></div> <?php
							}
							
							?>
							
							<div class="requirement" style="height: 50px;">
								<?php echo $requirement['nameReq'];?>
							</div>
							<div class="requirement" style="height: 200px;">
								<?php echo $requirement['descrip'];?>
							</div>
					
						</div>
					<?php }else{ ?>
							<div id="requirement-content" class="shadow-box text">
								
								<div id="image-user"><img style="width:40px; border-radius: 1000px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageUser); ?>"></div>
								
								<?php 
							
							if($challenge==1){
								?>
								<div class="requirement" style="height: 30px; width: 355px; margin-left: 10px;">
									<?php echo $requirement['idReq'];?>
								</div>
								<div id="image-user"><a href="detail.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px; border-radius: 1000px; cursor:pointer;" src="./images/icon-all.png"></a></div> <?php
								
							}if($challenge==0){
								?>
								<div class="requirement" style="height: 30px; width: 355px; margin-left: 10px;">
									<?php echo $requirement['idReq'];?>
								</div>
								<div id="image-user"><a href="challenge.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px; border-radius: 1000px; cursor:pointer;" src="./images/icon-challenge.png"></a></div> <?php
							
							
							}if($challenge==2){
								?>
								<div class="requirement" style="height: 30px; width: 305px; margin-left: 10px;">
									<?php echo $requirement['idReq'];?>
								</div>
								<div id="image-user" style="margin-right:10px;"><a href="detail.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px;border-radius: 1000px; cursor:pointer;" src="./images/icon-all.png"></a></div> <?php
								?><div id="image-user"><a href="challenge.php?idReq=<?php echo $requirement['id'];?>"><img style="width:40px; border-radius: 1000px; cursor:pointer;" src="./images/icon-challenge.png"></a></div> <?php
							}
							
							?>
								<div class="requirement" style="height: 50px;">
									<?php echo $requirement['nameReq'];?>
								</div>
								<div class="requirement" style="height: 200px;">
									<?php echo $requirement['descrip'];?>
								</div>
							
							</div>
					<?php }
					
						$counter++;
					
					 } ?>
				
					
				</div>
			</div>
		</div>
		
		<div id="footer">
			<div style="width:100%;height:100%;background-color:rgba(0, 0, 0, 0.47);">Footer</div>
		</div>
		
		
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
</html>