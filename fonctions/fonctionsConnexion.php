<?php
function connexion()
{
	if(isset($_SESSION['erreur'])) unset($_SESSION['erreur']);
	
	//si l'utilisateur a valid� le forumulaire de connexion
	if(isset($_POST['connexion']))
	{
		extract($_POST);
		$sel='';
		$mdp_base='';
		$requete = mysql_query('select sel, mdp from users where login="'.$login.'"');
		if (mysql_num_rows($requete)) //Si l'utilisateur existe
		{
			$donnees = mysql_fetch_row($requete);
			$sel = $donnees[0];
			$mdp_base = $donnees[1];
		}
		else $_SESSION['erreur'] = 'Nom d\'utilisateur incorrect';
		
		$mdp = SHA1($mdp);
		
		//On va comparer le mot de passe saisi une fois hash� et sal� au hash sal� de la base de donn�es cens� correspondre
		$mdp_hash_sel = SHA1($mdp.$sel);
		$vrai_mdp_sale = SHA1($mdp_base.$sel);
		
		//Si les deux hashs correspondent, on r�cup�re les infos du client		
		if ($mdp_hash_sel === $vrai_mdp_sale)
		{
			$result = mysql_query('select id, rang from utilisateur where login="'.$login.'" and mdp="'.$mdp.'"');
			
			//si les identifiants sont corrects
			if(mysql_num_rows($result))
			{
				$data = mysql_fetch_row($result);
				$_SESSION['id'] = $data[0];
				$_SESSION['login'] = $login;
				$_SESSION['rang'] = $data[1];
				
				if(isset($_GET['source']) == 'livraison') header('Location: panier.php');
				else if($_SESSION['rang']!=1) header('Location: index.php');
				else header('Location: administration.php');
			}
			else $_SESSION['erreur'] = 'Identifiants incorrects.';
		}
	}
}

function afficherFormulaire($data)
{
	if(isset($_SESSION['erreur'])) echo '<span class="erreur" style="padding:0px">'.$_SESSION['erreur'].'</span>';
	
	foreach($data as $elt)
	{
		echo '<br /><br />
			<label for="'.$elt['name'].'" class="formLabel">'.$elt['label'].'</label>
			<input class="'.$elt['class'].'" type="'.$elt['type'].'" id="'.$elt['name'].'" name="'.$elt['name'].'"/>';
			
	}
	echo '<br/><a href="mdp.php">mot de passe oubli�?</a>';
}

function afficherConnexion()
{	
	if(isset($_GET['source']) && $_GET['source']=='livraison')
	{
		echo '<form action="connexion.php?source="'.$_GET['source'].'" method="post"><div>';
	}
	else echo '<div>';
	
		$data[] = array('name'=>'login', 'type'=>'text', 'label'=>'Pseudo:', 'class'=>'inputMoyen');						
		$data[] = array('name'=>'password', 'type'=>'password', 'label'=>'Mot de passe:', 'class'=>'inputMoyen');			
		afficherFormulaire($data);
		unset($data);
		echo'<br /><br /><input id="submit" type="submit" value="Valider" style="margin:0px"/>			
		</div>
	</div>';
}
?>