<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
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
			
		?>
		
		<?php include ("header.php"); ?>
		
		<div id="content">
			
			<div id="area-1">
			
	    		<div id="area-1-section">
					
	    			<div id="section-1" class="section">
	    				<div class="section-header">
							<p class="section-header-text text"><span style="font-weight:bold;">...</span></p>
						</div>
						
						<div id="section-1-data" class="section-data">
						 ...
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