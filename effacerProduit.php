<?php
session_start();
include("Parametres.php");
include("Fonctions.inc.php");



if(isset($_SESSION["login"]) && $_SESSION["login"] = 'admin' && isset($_POST["id"])){
    $mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
    mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");

    $stmt = $mysqli->prepare('DELETE FROM favs WHERE id_prod = ?');
    $stmt->bind_param('i', $_POST["id"]); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result() or die("Impossible de supprimer le produit pour l'instant<br>");

    //$str = "delete from favs where id_prod =".$_POST["id"];

    $stmt = $mysqli->prepare('DELETE FROM produits WHERE id_prod = ?');
    $stmt->bind_param('i', $_POST["id"]); // 's' specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result() or die("Impossible de supprimer le produit pour l'instant<br>");

    //$str2 = "delete from produits where id_prod =".$_POST["id"];
    //query($mysqli,$str);
    //query($mysqli,$str2);
    mysqli_close($mysqli);
    echo "produit effacé avec succès";
}


?>
