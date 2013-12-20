<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Defiantly!</title>
		<link rel="stylesheet" type="text/css" href="./styles/style-fonts.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-detail.css">
		<link rel="stylesheet" type="text/css" href="./styles/style-general.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script src="./amcharts/amcharts.js" type="text/javascript"></script>
        <script src="./amcharts/pie.js" type="text/javascript"></script>
		
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
			
			$queryReq = "SELECT * FROM requirements WHERE id='$idReq'";
			$result = mysqli_query($con,$queryReq);
			$row = mysqli_fetch_array($result);
			$requirement = $row;
			
			$idUsuario = $requirement['user'];
			$idUsuarioC = $requirement['userC'];
			
			$votesUser = $requirement['votes'];
			$votesUserC = $requirement['votesC'];
			
			$queryUser = "SELECT * FROM users WHERE id=$idUsuario";
			$queryUserC = "SELECT * FROM users WHERE id=$idUsuarioC";
			
			$resultUser = mysqli_query($con,$queryUser);
			$resultUserC = mysqli_query($con,$queryUserC);
			
			$rowUser = mysqli_fetch_array($resultUser);
			
			$image = $rowUser['image'];
			$name = $rowUser['name'];
						
			$rowUserC = mysqli_fetch_array($resultUserC);
			$imageC = $rowUserC['image'];
			$nameC = $rowUserC['name'];
					
			$countWins = $rowUser['wins'];
			$countWinsC = $rowUserC['wins'];
						
			$show_up = TRUE;
			
			if (($_SESSION['id'] == $idUsuario) or ($_SESSION['id'] == $idUsuarioC)){
				$show_up = FALSE;
			}
			$idSearch = $requirement['id'];
			$queryShow = "SELECT * FROM requirements WHERE id=$idSearch";
			$result = mysqli_query($con,$queryShow);
			$requirement2 = mysqli_fetch_array($result);
			
			$win = 0;
			if($requirement2['challenge']==2){
				$show_up = FALSE;
				if($requirement2['votes']>$requirement2['votesC']){
					$win = 1;
				}else{
					$win = 2;
				}
			}
			
			$query = "SELECT * FROM users";
			$result = mysqli_query($con, $query);
			$countAllUsers = mysqli_num_rows($result);
			$noVotes = ($countAllUsers - ($votesUser + $votesUserC)) - 2;
			
			//check if the current user has already voted
			
			$query = "SELECT * FROM votes WHERE idUser=$currentUserID AND idReq=$idReq";
			$result = mysqli_query($con, $query);
			$countVotesCurrentUser = mysqli_num_rows($result);
			
			if($countVotesCurrentUser > 0){
				$show_up = FALSE;
			}
			
			if($requirement['challenge']==2){
				$show_up = FALSE;
			}
			
		?>
		
		 <script type="text/javascript">
            var chart;
            var legend;

            var chartData = [
                {
                    "Usuario": "Han votado por <?php echo $name;?>",
                    "Votos": <?php echo $votesUser; ?>
                },
                {
                   "Usuario": "Han votado por <?php echo $nameC;?>",
                    "Votos": <?php echo $votesUserC; ?>
                },
                {
                    "Usuario": "No han votado aun",
                    "Votos": <?php echo $noVotes; ?>
                },
                
            ];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "Usuario";
                chart.valueField = "Votos";

                // LEGEND
                legend = new AmCharts.AmLegend();
                legend.align = "center";
                legend.markerType = "circle";
                chart.balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
                chart.addLegend(legend);

                // WRITE
                chart.write("chartdiv");
            });

            // changes label position (labelRadius)
            function setLabelPosition() {
                if (document.getElementById("rb1").checked) {
                    chart.labelRadius = 30;
                    chart.labelText = "[[title]]: [[value]]";
                } else {
                    chart.labelRadius = -30;
                    chart.labelText = "[[percents]]%";
                }
                chart.validateNow();
            }


            // makes chart 2D/3D                   
            function set3D() {
                if (document.getElementById("rb3").checked) {
                    chart.depth3D = 10;
                    chart.angle = 10;
                } else {
                    chart.depth3D = 0;
                    chart.angle = 0;
                }
                chart.validateNow();
            }

            // changes switch of the legend (x or v)
            function setSwitch() {
                if (document.getElementById("rb5").checked) {
                    legend.switchType = "x";
                } else {
                    legend.switchType = "v";
                }
                legend.validateNow();
            }
            
		</script>
            
            
		
	</head>

	<body>
		
		<?php include ("header.php"); ?>
		  
		<div id="content">
			<div id="area-1"  style="height:550px;">
	    		<div id="section-1">
	    			
	    			<form name="voteUpUser" id="voteUpUserID" method="POST" action="operations.php">
						<input type="hidden" name="idUser" value="">
						<input type="hidden" name="idRequirement" value="">
						<input type="hidden" name="operation" value="voteUp">
					</form>
					
					<script>
						function voteUp(id, idReq){
							
							document.voteUpUser.idUser.value = id;
						    document.voteUpUser.idRequirement.value = idReq;
						  	document.voteUpUser.submit();
			            }
					</script>
				
					<div id="oponent1" class="shadow-box text">
						<div class="oponent-data">
							<?php echo $requirement['idReq'];?>
						</div>
						<div class="oponent-data" style="height: 50px;">
							<?php echo $requirement['nameReq'];?>
						</div>
						<div class="oponent-data" style="height: 200px;">
							<?php echo $requirement['descrip'];?>
						</div>
						<div id="image-user">
							<img style="width:100%; border-radius: 1000px;" src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>"> 
							
						</div>
						<div id="user-medals">
							<?php 
							for($i=0; $i<$countWins; $i++){ ?>
								
								<img style="width:20px; border-radius: 1000px;" src="./images/medal3.png">
							<?php } ?>
						</div>
						<div id="user-wins">
							<?php echo $name . " ha ganado " . $countWins . " desafios"?>
						</div>	
						
						<?php if($show_up == TRUE){ ?>
						<div id="buttom-up">
							<img class="shadow-box" style="width:60px; border-radius: 1000px;cursor:pointer; margin: 25px 0 0 30px;" onclick="voteUp(1,<?php echo $requirement['id'];?>)" src="./images/arrow-up.png" alt="1 Reto ganado">
						</div>
						<?php }else{ 
							if($win == 1){ ?>
								<div id="buttom-up">
									<img style="width:100px; border-radius: 1000px;" src="./images/medal3.png" >
								</div>
							
						<?php }else if($win == 2){ ?>
								<div id="buttom-up">
									<!-- <img style="width:100px; border-radius: 1000px;" src="./images/./images/medal3.png" > -->
								</div>
						<?php }
						} ?>
					</div>
					
					<div id="oponent2" class="shadow-box text">
						<div class="oponent-data">
							<?php echo $requirement['idReq'];?>
						</div>
						<div class="oponent-data" style="height: 50px;">
							<?php echo $requirement['nameReqC'];?>
						</div>
						<div class="oponent-data" style="height: 200px;">
							<?php echo $requirement['descripC'];?>
						</div>
						<div id="image-user">
							<img style="width:100%; border-radius: 1000px;" src="data:image/jpeg;base64,<?php echo base64_encode($imageC); ?>">

						</div>
						<div id="user-medals">
							<?php 
							for($i=0; $i<$countWinsC; $i++){ ?>
								<img style="width:20px; border-radius: 1000px;" src="./images/medal3.png" >
							<?php } ?>
						</div>
						<div id="user-wins">
							<?php echo $nameC . " ha ganado " . $countWinsC . " desafios"?>
						</div>	
						<?php if($show_up == TRUE){ ?>
						<div id="buttom-up">
							<img class="shadow-box" style="width:60px; border-radius: 1000px;cursor:pointer; margin: 25px 0 0 30px;" onclick="voteUp(2,<?php echo $requirement['id'];?>)" src="./images/arrow-up.png" alt="1 Reto ganado">
						</div>
						<?php }else{ 
							if($win == 2){ ?>
								<div id="buttom-up">
									<img style="width:100px; border-radius: 1000px;" src="./images/medal3.png" >
								</div>
							
						<?php }else if($win == 1){ ?>
								<div id="buttom-up">
									<!-- <img style="width:100px; border-radius: 1000px;" src="./images/settings-icon.png" > -->
								</div>
						<?php }
						} ?>
					</div>
					
					
					
				</div>
			
			
			<div id="graphics" class="text">
			
				<div id="chartdiv" class="text" style="color:white;"></div>
					<table align="center" cellspacing="20">
						<tr>
							<td>
								<input type="radio" checked="true" name="group" id="rb1" onclick="setLabelPosition()">Etiquetas fuera
								<input type="radio" name="group" id="rb2" onclick="setLabelPosition()">Etiquetas dentro</td>
							<td>
								<input type="radio" name="group2" id="rb3" onclick="set3D()">3D
								<input type="radio" checked="true" name="group2" id="rb4" onclick="set3D()">2D</td>
							<td>Cambio tipo de leyenda:
								<input type="radio" checked="true" name="group3" id="rb5"
								onclick="setSwitch()">x
								<input type="radio" name="group3" id="rb6" onclick="setSwitch()">v</td>
						</tr>
					</table>
			
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
		
	</body>	
</html>