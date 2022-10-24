<?php
session_start();
if(isset($_COOKIE["panier"]) && isset($_SESSION["login"]) && isset($_POST["num"]) && isset($_POST["code"])){
    if(!empty($_POST["num"]) || !empty($_POST["code"])){
        $panier = json_decode($_COOKIE["panier"]);
        include("Parametres.php");
        include("Fonctions.inc.php");


        $mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
        mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");

        foreach($panier as $item){
            $stmt = $mysqli->prepare("REPLACE INTO commande (ID_PROD,ETAT,ID_CLIENT,DATE,CIVILITE,NOM,PRENOM,ADRESSE,CP,VILLE,TELEPHONE) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $etat = 0;
            $stmt->bind_param("iissssssiss", $item, $etat, $_SESSION["login"], date('d/m/Y'),0,$_SESSION["NOM"], $_SESSION["PRENOM"], $_SESSION["ADRESSE"], $_SESSION["CP"], $_SESSION["VILLE"], $_SESSION["TELEPHONE"]);
            $stmt->execute();
            $result = $stmt->get_result();

            //query($mysqli,"replace into commande (ID_PROD,ETAT,ID_CLIENT,DATE,CIVILITE,NOM,PRENOM,ADRESSE,CP,VILLE,TELEPHONE) values ('".$item."',0,'".$_SESSION["login"]."','".date('d/m/Y')."',0,'".$_SESSION["NOM"]."','".$_SESSION["PRENOM"]."','".$_SESSION["ADRESSE"]."','".$_SESSION["CP"]."','".$_SESSION["VILLE"]."','".$_SESSION["TELEPHONE"]."')");
        }
        setcookie("panier", "", time()-3600,"/");
        mysqli_close($mysqli);
        $_SESSION["paiement"] = "opération réussie";
        $_SESSION["color"] = "green";
    }else{
        $_SESSION["paiement"] = "donnees incorrectes <br/> Veuillez essayer de nouveau";
        $_SESSION["color"] = "red";
    }

}else{
    $_SESSION["paiement"] = "donnees incorrectes <br/> Veuillez essayer de nouveau";
    $_SESSION["color"] = "red";
}

header('location: panier.php');




?>
