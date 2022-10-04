<?php
session_start();
include("../Parametres.php");
include("../Fonctions.inc.php");

	$secret = "6LeNW1QiAAAAAO-DZq4od_3ZGaRD8_EkAU1IXnkx";
	//$response = htmlspecialchars($_POST['g-recaptcha-response']);
	$response = $_POST["btn"];
	$remoteip = $_SERVER['REMOTE_ADDR'];

	$request = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$response."&remoteip=".$remoteip;
	
	$get = file_get_contents($request);
	$decode = json_decode($get, true);
	
	echo '<script>alert('.$decode.')</script>';

	if($decode['success']){
		$mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
		mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");
			
		$return["msg"] = "L'utilisateur n'a été pas trouvé";

		if(isset($_POST["login"]) && isset($_POST["password"])){
			$login = trim(mysqli_real_escape_string($mysqli,$_POST["login"]));
			$pass = $_POST["password"];
			$str = "SELECT * FROM users WHERE LOGIN = '".$login."'";
			$result = query($mysqli,$str) or die ("Impossible de se connection à la base de données<br>");
			if(mysqli_num_rows($result)>0){
				$row = mysqli_fetch_assoc($result);
				if(password_verify($pass, $row["PASS"])){
					$_SESSION["login"] = $row["LOGIN"];
					$_SESSION["NOM"] = $row["NOM"];
					$_SESSION["PRENOM"] = $row["PRENOM"];
					$_SESSION["ADRESSE"] = $row["ADRESSE"];
					$_SESSION["CP"] = $row["CODEP"];
					$_SESSION["VILLE"] = $row["VILLE"];
					$_SESSION["TELEPHONE"] = $row["TELEPHONE"];
					unset($return);
					$return["msg"] = "Connexion réussie";
					mysqli_close($mysqli);
					echo $return["msg"];
					exit();
				}	
			}
		}
		mysqli_close($mysqli);
		echo $return["msg"];		
	}
	else 
		echo "Le captcha svp";
?>