

	<?php
	
	// Create connection
	$con=mysqli_connect("localhost","root","","defiantlyDB");
	
	// Check connection
	if (mysqli_connect_errno()){
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}	
	
	session_start();
	
	if ((!empty($_GET['operation']) && strcmp($_GET['operation'],"checkChallenge") == 0)){
		
		
		
	}
		
	if ((!empty($_POST['operation']) && strcmp($_POST['operation'],"registration") == 0)){
		
    	//Check that user dont exist
    	$emailUser = $_POST['emailUser'];
		$query = "SELECT * FROM users WHERE email='$emailUser'";
		
		$result = mysqli_query($con, $query);
		$row = mysqli_fetch_array($result);
		
		if(empty($row)){
			
			$nameUser = $_POST['nameUser'];
			$lastNameUser = $_POST['lastNameUser'];
			$passUser = $_POST['passUser'];
			
			$image = addslashes(file_get_contents($_FILES['imageUser']['tmp_name'])); //SQL Injection defence!
												
			//The user dont exist, create the new one
			$queryInsert = "INSERT INTO users (name, lastname, image, email, pass)
				VALUES ('$nameUser', '$lastNameUser', '$image', '$emailUser', '$passUser')";
			
			mysqli_query($con, $queryInsert);
			
			$_POST['operation'] = "login";
			
		}	
		
	}	
	
	if (((!empty($_POST['operation'])) && strcmp($_POST['operation'],"login") == 0)) {
		
		if(strlen($_POST['emailUser'])>0){
						
			if(strlen($_POST['passUser'])>0 && strlen($_POST['passUser'])<9){
				
				//Check that the user exist
				$userExists = false; $emailUser = $_POST['emailUser'];
				
				$queryUser = "SELECT * FROM users WHERE email='$emailUser'";
				
				$result = mysqli_query($con,$queryUser);
				$row = mysqli_fetch_array($result);
					
				if(!empty($row)){
					
					//Check if the password matches
					if (strcmp($row['pass'],$_POST['passUser']) == 0){
						
						$_SESSION['name'] = $row['name'];
						$_SESSION['id'] = $row['id'];
						
						$query = "SELECT * FROM requirements WHERE challenge=1";
						$results = mysqli_query($con, $query);
						while($row = mysqli_fetch_array($results)){
							
							$date1 = new DateTime($row['dateReqC']);
							$date2 = new DateTime(date("Y-m-d H:i:s"));
							$differenceDates = round(($date2->format('U') - $date1->format('U')) / (60*60*24));
							
							if(($differenceDates > 0) && ($row['votes'] != $row['votesC'])){
								
								$nameReq; $descrip; $nameReqC; $descripC; $idUser; $user = 0; $userC = 0;
								
								if($row['votes'] < $row['votesC']){
									$idUser = $row['userC']; 
									
									$userN = $row['userC'];
									$userNC = $row['user'];
									$nameReq = $row['nameReqC']; 
									$descrip = $row['descripC']; 
									$nameReqC = $row['nameReq']; 
									$descripC = $row['descrip'];
									$votes = $row['votesC']; 
									$votesC = $row['votes'];
									
								}else{
									$idUser = $row['user'];
									
									$userN = $row['user'];
									$userNC = $row['userC'];
									$nameReq = $row['nameReq'];
									$descrip = $row['descrip'];
									$nameReqC = $row['nameReqC'];
									$descripC = $row['descripC'];
									$votes = $row['votes'];
									$votesC = $row['votesC'];
									
								}
								
								$queryWin = "SELECT * FROM users WHERE id=$idUser";
								$result = mysqli_query($con, $queryWin);
								$user = mysqli_fetch_array($result);
								$wins = $user['wins'];
								if($wins == null){
									$wins = 1;
								}else{
									$wins++;
								}
								$queryWin = "UPDATE users SET wins=$wins WHERE id=$idUser";
								mysqli_query($con, $queryWin);
							
								$idReq = $row['idReq'];
								$date = date("Y-m-d H:i:s");
								$queryUpdate = "UPDATE requirements SET challenge=2, user=$userN, userC=$userNC, dateReq='$date', nameReq='$nameReq', descrip='$descrip', nameReqC='$nameReqC', descripC='$descripC', votes=$votes, votesC=$votesC WHERE idReq='$idReq'";
								mysqli_query($con, $queryUpdate);
								
								$idReq = $row['id'];
								$queryFind = "INSERT INTO requirementswin (id, idUser) VALUES ($idReq, $idUser)";
								mysqli_query($con, $queryFind);
															
								$queryEmail = "SELECT * FROM users WHERE id=$idUser";
								$resultEmail = mysqli_query($con,$queryEmail);
								$userEmail = mysqli_fetch_array($resultEmail);
								
								$destiny = $userEmail['email']; 
								$title = "Has ganado un desafio!"; 
								$body = ' 
								<html> 
								<head> 
								   <title>Informacion</title> 
								</head> 
								<body> 
								<h3>Hola ' . $userEmail['name'] .'!</h3> 
								<p> 
								Te informamos que has ganado el desafío por el reto con ID: <b>' . $row['idReq'] . '!</b></p>
								<p>Tu propuesta ya ha sido procesada y validada. Puedes ver los resultados del desafío hasta que otro usuario te rete, ¡Date prisa!:
								</p>
								<a href="defiantly.netau.net/detail.php?idReq=' . $row['id'] . '">defiantly.netau.net/detail.php?idReq=' . $row['id'] . '</a> <br>
								<p>Recuerda que has conseguido una medalla por haber ganado la competición, consigue todas las que puedas. Nos vemos en Defiantly!</p>
								</body> 
								</html> 
								'; 
								
								//para el envío en formato HTML 
								$headers = "MIME-Version: 1.0\r\n"; 
								$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
								
								//dirección del remitente 
								$headers .= "From: Defiantly-Info\r\n"; 
								
								//dirección de respuesta, si queremos que sea distinta que la del remitente 
								$headers .= "Reply-To:  No-reply\r\n"; 
								
								//ruta del mensaje desde origen a destino 
								$headers .= "Return-path:  No-reply\r\n"; 
								
								mail($destiny,$title,$body,$headers);
														
								
								}
								
							}
							header("Location: index.php");
														
					}else{
						$_SESSION['err'] = "La contraseña no coincide";
						header("Location: login.php");
					}
				}else{
					$_SESSION['err'] = "El email introducido no existe";
					header("Location: login.php");
				}
			}else{
				$_SESSION['err'] = "No ha introducido la contraseña";
				header("Location: login.php");
			}
		}else{
			$_SESSION['err'] = "No ha introducido el nombre";
			header("Location: login.php");
		}
	}

	if ((!empty($_POST['operation']) && strcmp($_POST['operation'],"closeSession") == 0)){
		
    	session_destroy();
    	header("Location: login.php");
		
	}
	
	if ((!empty($_POST['operation']) && strcmp($_POST['operation'],"update") == 0)){
		
		$idUser = $_POST['idUser'];
				
		if(!(empty($_POST['nameUser']))){
		
			$nameUser = $_POST['nameUser'];
			
			$queryUpdate = "UPDATE users SET name='$nameUser' WHERE id=$idUser";
			
			$_SESSION['name'] = $nameUser;
			
			mysqli_query($con, $queryUpdate);
			
		}
		
		if(!(empty($_POST['passUser']))){
		
			$passUser = $_POST['passUser'];
			
			if(empty($_POST['validationPassUser'])){
			
				//Send error message: Lost the verification of pass
				header ("Location: index.php");
				
			}else{
				
				$validationPassUser = $_POST['validationPassUser'];
				if($validationPassUser == $passUser){
					
					$queryUpdate = "UPDATE users SET pass='$passUser' WHERE id=$idUser";
					mysqli_query($con, $queryUpdate);
					
				}else{
					
					//Send error message: Lost the verification of pass
					header ("Location: index.php");
					
				}
				
			}
			
		}
				
		if(!(empty($_POST['lastnameUser']))){
		
			$lastnameUser = $_POST['lastnameUser'];
			
			$queryUpdate = "UPDATE users SET lastname='$lastnameUser' WHERE id=$idUser";
			
			mysqli_query($con, $queryUpdate);
			
		}
		
		if(!(empty($_FILES['imageUser']))){
								
			$imageUser = addslashes(file_get_contents($_FILES['imageUser']['tmp_name'])); //SQL Injection defence!
			
			if($imageUser != null){
				$queryUpdate = "UPDATE users SET image='$imageUser' WHERE id=$idUser";
				mysqli_query($con, $queryUpdate);
			}
			
		}
		
		header ("Location: index.php");
		
	}

	if ((!empty($_POST['operation']) && strcmp($_POST['operation'],"newRequirement") == 0)){	
			
		$idReq = $_POST['idReq'];

		//Check if the requirement already exists
		$query = "SELECT * FROM requirements WHERE idReq='$idReq'";
		
		$result = mysqli_query($con,$query);
		
		if(empty($results)){
			
			//Don't exists the requirements, add the new one
			$nameReq = $_POST['nameReq'];
			$descrip = $_POST['descrip'];
			$date = date("Y-m-d H:i:s");
			$user = $_SESSION['id'];
			
			$queryAdd = "INSERT INTO requirements (idReq, nameReq, descrip, date, user)
				VALUES ('$idReq', '$nameReq', '$descrip', '$dateReq', $user)";
			
			mysqli_query($con, $queryAdd);
							
		}else{
			
			$_SESSION['err']="El ID ya existe";
			
		}
		
		header("Location: index.php");
				
	}	
	
	if ((!empty($_POST['operation']) && strcmp($_POST['operation'],"newChallenge") == 0)){
	
		$userC = $_POST['userC']; echo $userC;
		$nameReqC = $_POST['nameReqC']; echo $nameReqC;
		$descripC = $_POST['descripC']; echo $descripC;
		$idReq = $_POST['idReq']; echo $idReq;
		$dateReqC = date("Y-m-d H:i:s"); echo $dateReqC;
		
		$queryUpdate = "UPDATE requirements SET userC='$userC', nameReqC='$nameReqC', dateReqC='$dateReqC', descripC='$descripC', challenge=1, votes=0, votesC=0 WHERE id=$idReq";
		mysqli_query($con, $queryUpdate);	
		
		$queryDestroy = "DELETE FROM requirementswin WHERE id=$idReq";
		mysqli_query($con, $queryDestroy);	
		
		$query = "SELECT * FROM requirements WHERE id='$idReq'";
		$result = mysqli_query($con, $query);	
		$requirement = mysqli_fetch_array($result);
		$idUser = $requirement['user'];
		$idReq = $requirement['id'];
		$queryNotice = "INSERT INTO viewchallenges (idReq, idUser) VALUES ($idReq, $idUser)";
		mysqli_query($con, $queryNotice);	
		
		$queryDeteleVote = "DELETE FROM votes WHERE idReq=$idReq";
		mysqli_query($con, $queryDeteleVote);
		
		header("Location: index.php");
	
	}
	
	if ((!empty($_POST['operation']) && strcmp($_POST['operation'],"voteUp") == 0)){
	
		$idRequirement = $_POST['idRequirement'];
		$idUser = $_POST['idUser'];
		
		if($idUser == 1){
			$queryCheck = "SELECT * FROM requirements WHERE id=$idRequirement";
			$result = mysqli_query($con, $queryCheck);
			$row = mysqli_fetch_array($result);
			$countVotes = $row['votes'];
			$countVotesNew = $countVotes + 1;
			
			$queryUpdate = "UPDATE requirements SET votes=$countVotesNew WHERE id=$idRequirement";
			mysqli_query($con, $queryUpdate);
			
		}else{
			$queryCheck = "SELECT * FROM requirements WHERE id=$idRequirement";
			$result = mysqli_query($con, $queryCheck);
			$row = mysqli_fetch_array($result);
			$countVotes = $row['votesC'];
			$countVotesNew = $countVotes + 1;
			
			$queryUpdate = "UPDATE requirements SET votesC=$countVotesNew WHERE id=$idRequirement";
			mysqli_query($con, $queryUpdate);
			
		}
		$idUserCurrent = $_SESSION['id'];
		//Now save that the current user have already voted
		$query = "INSERT INTO votes (idReq, idUser) VALUES ($idRequirement,$idUserCurrent)";
		mysqli_query($con, $query);
		
			
		$rute = "detail.php?idReq=" . $idRequirement;
		header("Location: $rute");
	
	}
	
	?>
	

	