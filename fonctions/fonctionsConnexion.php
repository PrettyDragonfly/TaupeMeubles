<?php
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
	echo '<br /><br /><div class="g-recaptcha" data-sitekey="6LeNW1QiAAAAAKGaY29GZ3X6rOFLw_JTHYG29uCd"></div>';
	echo'<br /><br /><input id="submit" type="submit" value="Valider" style="margin:0px"/>			
		</div>
	</div>';
	
}
?>

<?php
function afficherCaptcha(){ ?>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php
	if(isset($_GET['source']) && $_GET['source']=='livraison')
	{
		echo '<form action="connexion.php?source="'.$_GET['source'].'" method="post"><div>';
	}
	else echo '<div>'; 
		$data[] = array('name'=>'login', 'type'=>'text', 'label'=>'Pseudo:', 'class'=>'inputMoyen');						
		$data[] = array('name'=>'password', 'type'=>'password', 'label'=>'Mot de passe:', 'class'=>'inputMoyen');	
		afficherFormulaire($data);
		unset($data);
		echo '<div class="g-recaptcha" data-sitekey="6LeNW1QiAAAAAKGaY29GZ3X6rOFLw_JTHYG29uCd"></div><br><br>';
		echo'<br /><br /><input id="submit" type="submit" name="submit" value="Valider" style="margin:0px"/>			
		</div>
	</div>';
}
?>