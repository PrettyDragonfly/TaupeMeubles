<?php

function afficherFormulaire($data)
{
	foreach($data as $elt)
	{	
		echo '<tr><br />
			<td><label for="'.$elt['name'].'" class="formLabel2">'.$elt['label'].'</label></td><td>';
			//s'il y a une erreur concernant cet input alors on affiche l'erreur � c�t� de l'input
			if(isset($_SESSION['erreur'][$elt['name']])) echo '<input class="'.$elt['class'].'" type="'.$elt['type'].'" id="'.$elt['name'].'" name="'.$elt['name'].'"/><span class="erreur">'.$_SESSION['erreur'][$elt['name']].'</span>';
			else
			{	//s'il n'y a pas d'erreur alors on initialise l'input avec la valeur entr�e par l'utilisateur (pour le else il n'y a pas de valeur � afficher car l'utilisateur vient d'arriver sur la page)
				if(isset($_POST[$elt['name']])) echo '<input class="'.$elt['class'].'" type="'.$elt['type'].'" id="'.$elt['name'].'" name="'.$elt['name'].'" value="'.$_POST[$elt['name']].'"/>';
				else echo '<input class="'.$elt['class'].'" type="'.$elt['type'].'" id="'.$elt['name'].'" name="'.$elt['name'].'"/>';
			};
		echo '</td></tr>';
	}
}

function afficherPaiement()
{
	echo '
	<form action="confirmerCommande.php" method="post">
		<div>
		
			<div class="formCadre">
			<table>
				<h2>Paiement par carte bancaire</h2>';
				$data[] = array('name'=>'nom', 'type'=>'text', 'label'=>'Votre nom tel qu\'il appara�t sur la carte:', 'class'=>'inputMoyen');				
				$data[] = array('name'=>'num', 'type'=>'text', 'label'=>'Num�ro de la carte:', 'class'=>'inputMoyen');				
				$data[] = array('name'=>'code', 'type'=>'password', 'label'=>'Code (3 chiffres au dos de la carte):', 'class'=>'inputMoyen');			
				afficherFormulaire($data);
				unset($data);
				
				echo '<tr><td><label class="formLabel2" style="margin-right:28px">Date d\'expiration:</label></td>';
				
				echo '<td><select style="margin-right:5px">
						<option>01</option>
						<option>02</option>
						<option>03</option>
						<option>04</option>
						<option>05</option>
						<option>06</option>
						<option>07</option>
						<option>08</option>
						<option>09</option>
						<option>10</option>
						<option>11</option>
						<option>12</option>
					</select>';
					
				$date = getdate(time());
				echo '<select>';
					for($i=0; $i<11; $i++) echo '<option>'.($date['year']+$i).'</option>';
				echo '</select>';
			echo '</td></tr></table>';
		echo'</div><br />
			<input id="submit" name="paiement" type="submit" value="Valider" style="margin:0px"/>
	</form>';
}
?>