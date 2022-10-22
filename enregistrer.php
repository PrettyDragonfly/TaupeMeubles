<?php
session_start();
include("Parametres.php");
include("Fonctions.inc.php");

$mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");


$ok = true;
$result["msg"] = "invalide";


if((isset($_POST["loginbdd"])) && (isset($_POST["passwordbdd"]))){			  
	if(empty($_POST["loginbdd"]) || empty($_POST["passwordbdd"])){
		$return["pass"] = "Le mot de passe est trop court";
		$return["loginVal"] = "Le login n'est pas valide";
		$ok = false;
	}
	else{
		$pass = mysqli_real_escape_string($mysqli,$_POST["passwordbdd"]);
		$login = mysqli_real_escape_string($mysqli,$_POST["loginbdd"]);
		$matches[] = NULL;
		if(!preg_match("/^[a-zA-Z'\-\_0-9 ]+$/",$_POST["loginbdd"])){
			$return["loginVal"] = "Le login n'est pas valide";
			$login = NULL;
				
		}
		
		if(count((array)$login)>100){
			$return["loginLong"] = "Le login est trop long";
			$ok = false;
		}
		
		if(count((array)$pass)>100){
			$return["passLong"] = "Le mot de passe est trop long";
			$ok = false;
		}
		
	}
	
}
else{
	$return["loginVal"] = "Le login n'est pas valide";
	$return["passVal"] = "Le mot de passe n'est valide";
	$ok = false;
}

if(isset($_POST["emailbdd"])){
	if(!filter_var($_POST["emailbdd"], FILTER_VALIDATE_EMAIL)){
			$return["emailVal"] = "L'email n'est pas valide";
			$email = NULL;
	}
	else{
		$email = $_POST["emailbdd"];
	}
}else{
	$email = NULL;
}

if(isset($_POST["nombdd"])){
	if(empty($_POST["nombdd"])){
		$return["Nom"] = "Le nom n'est pas valide";
		$nom = NULL;
	}
	else{
		$nom = mysqli_real_escape_string($mysqli,$_POST["nombdd"]);
		if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["nombdd"])){
			$return["Nom"] = "Le nom n'est pas valide";
			$nom = NULL;
		}else if(count((array)$nom)>50){
			$return["Nom"] = "Le nom est trop long";
			$ok = false;
		}
	} 
}else{
	$nom = NULL;
}

if(isset($_POST["prenombdd"])){
	if(empty($_POST["prenombdd"])){
		$prenom = NULL;
	}
	else{
		$prenom = mysqli_real_escape_string($mysqli,$_POST["prenombdd"]);
		if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["prenombdd"])){
			$return["Prenom"] = "Le prénom n'est pas valide";
			$prenom = NULL;
		}else if(count((array)$prenom)>50){
			$return["Prenom"] = "Le prénom est trop long";
			$ok = false;
		}
	} 
}
else{
	$prenom = NULL;
}

if(isset($_POST["adressebdd"])){
	if(empty($_POST["adressebdd"])){
	$adresse = NULL;
}else{
	$adresse = mysqli_real_escape_string($mysqli,$_POST["adressebdd"]);
	if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["adressebdd"])){
		$return["Adresse"] = "L'adresse n'est pas valide";
		$adresse = NULL;
	}
	else if(count((array)$adresse)>500){
			$return["Adresse"] = "L'adresse n'est pas valide";
			$ok = false;
		}
	}
}else{
	$adresse = NULL;
}


if(isset($_POST["villebdd"])){
	if(empty($_POST["villebdd"])){
		$ville = NULL;
	}else{
		$ville = mysqli_real_escape_string($mysqli,$_POST["villebdd"]);
		if(!preg_match("/^[a-zA-Z'\- ]+$/",$_POST["villebdd"])){
			$return["Ville"] = "La ville n'est pas valide";
			$ville = NULL;
		}
		else if(count((array)$ville)>50){
		$return["ville"] = "La ville n'est pas valide";
		$ok = false;
		}
	}
}
else{
	$ville = NULL;
}

if(isset($_POST["codepostalbdd"])){
	if(empty($_POST["codepostalbdd"])){
	$codepostal = NULL;
}else{
	$codepostal = mysqli_real_escape_string($mysqli,$_POST["codepostalbdd"]);
	if(!preg_match("/^[0-9]{5}$/",$_POST["codepostalbdd"])){
		$return["codepostal"] = "Le code postal n'est pas valide";
		$codepostal = NULL;
	}
	else if(count((array)$codepostal)>50){
	$return["codepostal"] = "Le code postal n'est pas valide";
	$ok = false;
	}
}
}else{
	$codepostal = NULL;
}

if(isset($_POST["datebdd"])){
	if(empty($_POST["datebdd"])){
	$date = NULL;
}else{
	$date = mysqli_real_escape_string($mysqli,$_POST["datebdd"]);
	if(count((array)$date)>50){
	$return["date"] = "La date n'est pas valide";
	$ok = false;
	}
}
}
else{
	$date = NULL;
}

if(isset($_POST["telephonebdd"])){
	if(!preg_match("/^[0-9]{9,15}$/",$_POST["telephonebdd"])){
			$return["telephoneVal"] = "le téléphone n'est pas valide";
			$telephone = NULL;
			$ok = false;
}
else{
	$telephone = mysqli_real_escape_string($mysqli,$_POST["telephonebdd"]);
	}
}else{
	$telephone = NULL;
}
	


if(isset($_POST["optradio"])){
	$sexe = $_POST["optradio"];
}else{
	$sexe = NULL;
}

if(isset($login)){
	$str = "SELECT EMAIL FROM users WHERE login = '".$login."'";
	$result = query($mysqli,$str) or die("Impossible de créer un compte pour l'instant<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaEmail"] = "L'email saisi est déjà enregistré";
	}
	
	
	$str = "SELECT LOGIN FROM users WHERE LOGIN = '".$login."'";
	$result = query($mysqli,$str) or die("Impossible de créer un compte pour l'instant<br>");
	if(mysqli_num_rows($result)>0){
		$ok = false;
		$return["dejaLogin"] = "Le login saisi est déjà enregistré";
	}
}else{
	$ok = false;
}

if($ok === true){
	$str = "INSERT INTO users VALUES ('".$login."','".$email."','".password_hash($pass, PASSWORD_DEFAULT)."','".$nom."','".$prenom."','".$date."','".$sexe."','".$adresse."','".$codepostal."','".$ville."','".$telephone."');";
	query($mysqli,$str) or die("Impossible de créer un compte pour l'instant<br>");
	$_SESSION["login"] = $login;
	$_SESSION["NOM"] = $nom;
	$_SESSION["PRENOM"] = $prenom;
	$_SESSION["ADRESSE"] = $adresse;
	$_SESSION["CP"] = $codepostal;
	$_SESSION["VILLE"] = $ville;
	$_SESSION["TELEPHONE"] = $telephone;
	unset($return);
	mysqli_close($mysqli);	
	header('location: index.php');
}else{
	mysqli_close($mysqli);
	$_SESSION["inscription"] = $return;
	header('location: inscription.php');
}

?>