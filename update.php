<?php
session_start();
	
include("Parametres.php");
include("Fonctions.inc.php");

$mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");
$stmt = $mysqli->prepare("SELECT * FROM users WHERE LOGIN = ?");
$stmt->bind_param("s", $_SESSION["login"]);
$stmt->execute();
$result = $stmt->get_result() or die("Impossible de faire une connection à base de données");

//$str = "SELECT * FROM users WHERE LOGIN = '".$_SESSION["login"]."'";
//$result = query($mysqli,$str) or die ("Impossible de faire une connection à base de donnèes<br>");

$row = mysqli_fetch_assoc($result);

if((isset($_POST["emailbdd"]) && empty($_POST["emailbdd"])) || !(isset($_POST["emailbdd"]))){
	$email = $row["EMAIL"];
}
else{
	if(strlen(trim(mysqli_real_escape_string($mysqli,$_POST["emailbdd"])))>100){
		$email = $row["EMAIL"];
	}else if(!filter_var(trim(mysqli_real_escape_string($mysqli,$_POST["emailbdd"])), FILTER_VALIDATE_EMAIL)){
		$email = $row["EMAIL"];
	}else{
		$email = trim(mysqli_real_escape_string($mysqli,$_POST["emailbdd"]));
	}
}

if((isset($_POST["nombdd"]) && empty($_POST["nombdd"])) || !(isset($_POST["nombdd"]))){
	$nom = $row["NOM"];
}
else{
	if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["nombdd"])){
		$nom = $row["NOM"];
	}
	else if(strlen(trim(mysqli_real_escape_string($mysqli,$_POST["nombdd"])))>50){
		$nom = $row["NOM"];
	}
	else{
		$nom = trim(mysqli_real_escape_string($mysqli,($_POST["nombdd"])));
	}
}

if((isset($_POST["prenombdd"]) && empty($_POST["prenombdd"])) || !(isset($_POST["prenombdd"]))){
	$prenom = $row["PRENOM"];
}
else{
	if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["prenombdd"])){
		$prenom = $row["PRENOM"];
	}
	else if(strlen(trim(mysqli_real_escape_string($mysqli,$_POST["prenombdd"])))>50){
		$prenom = $row["PRENOM"];
	}
	else{
		$prenom = trim(mysqli_real_escape_string($mysqli,$_POST["prenombdd"]));
	}
	
}

if((isset($_POST["adressebdd"]) && empty($_POST["adressebdd"])) || !(isset($_POST["adressebdd"]))){
	$adresse = $row["ADRESSE"];
}
else{
	if(!preg_match("/^[a-zA-Z0-9'\- ]+$/",$_POST["adressebdd"])){
		$adresse = $row["ADRESSE"];
	}
	else if(strlen(trim(mysqli_real_escape_string($mysqli,$_POST["adressebdd"])))>500){
		$adresse = $row["ADRESSE"];
	}
	else{
		$adresse = trim(mysqli_real_escape_string($mysqli,$_POST["adressebdd"]));
	} 
}

if((isset($_POST["villebdd"]) && empty($_POST["villebdd"])) || !(isset($_POST["villebdd"]))){
	$ville = $row["VILLE"];
}
else{
	if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["villebdd"])){
		$ville = $row["VILLE"];
	}
	else if(strlen(trim(mysqli_real_escape_string($mysqli,$_POST["villebdd"])))>50){
		$ville = $row["VILLE"];
	}
	else{
		$ville = trim(mysqli_real_escape_string($mysqli,$_POST["villebdd"])); 
	} 
}

if((isset($_POST["postalbdd"]) && empty($_POST["postalbdd"])) || !(isset($_POST["postalbdd"]))){
	$codepostal = $row["CODEP"];
}
else{
	if(!preg_match("/^[0-9\- ]+/",$_POST["postalbdd"])){
		$codepostal = $row["CODEP"];
	}
	else if(strlen(trim(mysqli_real_escape_string($mysqli,$_POST["postalbdd"])))>7){
		$codepostal = $row["CODEP"];
	}
	else{
		$codepostal = trim(mysqli_real_escape_string($mysqli,$_POST["postalbdd"])); 
	} 
}


if((isset($_POST["datebdd"]) && empty($_POST["datebdd"])) || !(isset($_POST["datebdd"]))){
	$date = $row["DATE"];
}
else{
	$len = strlen(trim(mysqli_real_escape_string($mysqli,$_POST["datebdd"])));
	if(!preg_match("/^[0-9\/\- ]*$/",$_POST["datebdd"])){
		$date = $row["DATE"];
	}
	else if($len>20){
		$date = $row["DATE"];
	}else{
		$date = trim(mysqli_real_escape_string($mysqli,$_POST["datebdd"])); 
	}
}

if((isset($_POST["telephonebdd"]) && empty($_POST["telephonebdd"])) || !(isset($_POST["telephonebdd"]))){
	$telephone = $row["TELEPHONE"];
}
else{
	if(!preg_match("/^[0-9\- ]{9,15}$/",$_POST["telephonebdd"])){
		$telephone = $row["TELEPHONE"];
	}
	else{
		$telephone = mysqli_real_escape_string($mysqli,$_POST["telephonebdd"]); 
	} 
}

$sexe = $_POST["optradio"];
//var_dump($nom);
$query = "UPDATE users SET EMAIL = ?, NOM = ?, PRENOM = ?, ADRESSE = ?, CODEP = ?, VILLE = ?, DATE = ?, SEXE = ?, TELEPHONE = ? WHERE LOGIN = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssssisssis", $email, $nom, $prenom, $adresse, $codepostal, $ville, $date, $sexe, $telephone, $_SESSION["login"]);
$stmt->execute();

//$str = "UPDATE users SET EMAIL = '".$email."', PASS = '".$pass."', NOM ='".$nom."', PRENOM = '".$prenom."', ADRESSE = '".$adresse."', CODEP = '".$codepostal."', VILLE = '".$ville."', DATE = '".$date."',SEXE = '".$sexe."', TELEPHONE = '".$telephone."' WHERE LOGIN = '".$_SESSION["login"]."'";
//query($mysqli,$str) or die ("Impossible de se connecter à base de donnèes<br>");
mysqli_close($mysqli);
header('location: profil.php');
?>