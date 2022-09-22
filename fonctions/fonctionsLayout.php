<?php

function afficherMenuGauche()
{
	echo '<ul class="menuh">';
	
	$result = mysql_query('SELECT id_rub, Libelle_rub FROM rubrique WHERE id_rub NOT IN (SELECT id_enfant FROM hierarchie)');
	while($rub = mysql_fetch_row($result)) echo '<li><a href="index.php?id_rub='.$rub[0].'&amp;source=menu" title="">'.$rub[1].'</a></li> ';
	
	echo '</ul>';
}

function afficherBarreRecherche()
{
	echo '<span style="color:#1db6f6; font-weight:bold; float:left; padding-left:13px">Recherche</span>';
	echo '<form action="index.php" method="post">';
	echo '<div style="width:168px"><input type="text" id="recherche" name="recherche"/></div>';
	echo '</form>';
}
function afficherCadrePanier()
{	
	echo '<a href="panier.php';
	
	if(isset($_GET['id_rub'])) echo '?id_rub='.$_GET['id_rub'];
	
	echo '"><img src = "images/caddy.png" alt=""/><br />';
	
	if(!isset($_SESSION['panier']) || (count($_SESSION['panier'])) == 0) echo 'Le panier est vide.';
	else
	{
		$nbArticle = 0;
		$total = 0;
		
		foreach($_SESSION['panier'] as $article)
		{
			$nbArticle += $article['Quantite'];
			$total += $article['Prix'] * $article['Quantite'];
		}
		
		if($nbArticle ==1) echo '1 article ';
		else echo $nbArticle.' articles ';
		
		echo $total.' �';
	}
	
	echo '</a>';
}

function afficherCadreCompte()
{
	echo '<ul>';
	
	if(!isset($_SESSION["login"])) echo '<li><a class="btn btn-default" href="connexion.php">Connexion</a></li><li><a class="btn btn-default" href="inscription.php">Ouvrir un compte</a></li>';
	else 
	{
		//seul l'admin peut accéder à la page administration
		if($_SESSION["login"]=="admin"){ 
			echo '<li><a class="btn btn-default" href="administration.php">Administration</a></li>';
		}
		echo '<li><a class="btn btn-default" href="profil.php">Mon compte</a></li><li><a href="histoire.php">Histoire</a></li><li><a href="deconnexion.php">Deconnexion</a></li>';
		//echo '<a class="btn btn-default" href="deconnexion.php">D�connexion</a>';
	}
	
	echo '</ul>';
}
?>