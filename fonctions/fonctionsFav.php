<?php
	session_start();
	if(isset($_POST["item"]) && isset($_SESSION["login"])){
		include("../Parametres.php");
		include("../Fonctions.inc.php");
		
			$mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
			mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");

            $stmt = $mysqli->prepare("SELECT * FROM favs WHERE ID_PROD = ?");
            $stmt->bind_param("i", $_POST["item"]);
            $stmt->execute();
            $result = $stmt->get_result()or die("Impossible d'ajouter produit<br>");

			//$str0 = 'select * from favs where id_prod = '.$_POST["item"];
			//$str = "INSERT INTO favs VALUES('".$_SESSION["login"]."','".$_POST["item"]."')";
			//$result = query($mysqli,$str0) or die("Impossible d'ajouter produit<br>");
			
			if(mysqli_num_rows($result)>0 && isset($_POST["x"])){
                        $stmt = $mysqli->prepare("DELETE FROM favs WHERE ID_PROD = ? and LOGIN = ?");
                        $stmt->bind_param("is", $_POST["item"], $_SESSION["login"]);
                        $stmt->execute();
                        $result = $stmt->get_result()or die("Impossible d'ajouter produit<br>");

						//query($mysqli,'delete from favs where id_prod = '.$_POST["item"].' and LOGIN = \''.$_SESSION["login"].'\'');
						echo 'Produit supprimé des favoris';
			}else{
                        $stmt = $mysqli->prepare("INSERT INTO favs (LOGIN, ID_PROD) VALUES (?,?)");
                        $stmt->bind_param("si", $_SESSION["login"], $_POST["item"]);
                        $stmt->execute();
                        $result = $stmt->get_result()or die("Impossible d'ajouter produit<br>");
						//query($mysqli,$str);
						echo 'Produit ajouté aux favoris';
			}
			
			mysqli_close($mysqli);
	}
	else {
	    echo "Merci de vous connecter pour ajouter des produits à vos favoris";
    }
?>