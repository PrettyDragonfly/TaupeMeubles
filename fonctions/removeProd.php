<?php
	session_start();
	if(isset($_POST["item"])){
		include("../Parametres.php");
		include("../Fonctions.inc.php");
		
			$mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
			mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");

            $stmt = $mysqli->prepare("DELETE FROM produits WHERE id_prod = ? limit 1");
            $stmt->bind_param("i", $_POST["item"]);
            $stmt->execute();
            $result2 = $stmt->get_result();

			//query($mysqli,'delete from produits where id_prod = '.$_POST["item"]);
			mysqli_close($mysqli);
	}
	else{
		echo "Erreur";
	}
?>