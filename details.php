<?php
	session_start();
	include 'fonctions/fonctionsLayout.php';
?>
<!DOCTYPE HTML>
<!--
	Solarize by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Taupe Meubles</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.dropotron.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>
	<?php include("./navbar.php");?>	
	
		<!-- Main -->
			<div id="main" class="wrapper style4">

				<div class="container">
					<div class="row">
						<!-- Content -->
							<section>
								<header class="major">
									<h2>Détails</h2>
								</header>
								<?php 
		include("Parametres.php");
		include("Fonctions.inc.php");
		$mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error());
		mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");
		$result = query($mysqli,'select * from rubrique');						
								
		if(isset($_GET["prod"])){
            $stmt = $mysqli->prepare("SELECT * FROM produits WHERE id_prod = ?");
            $stmt->bind_param("i", $_GET["prod"]);
            $stmt->execute();
            $result = $stmt->get_result();

			//$result = query($mysqli,'select * from produits where id_prod = \''.$_GET["prod"].'\'');
			
			if((mysqli_num_rows($result)>0)){
					while($row = mysqli_fetch_assoc($result)){
						
					echo '<article class="one_third">
						  <figure><img src="'.$row["PHOTO"].'"alt="">
							<figcaption>
							  <h2><a href="#" onclick="addPanier('.$row["ID_PROD"].')">BBB</a> '.$row["LIBELLE"].'</h2>
							  <p>'.$row["DESCRIPTIF"].'</p>
							</figcaption>
						  </figure>
						</article>';
					}
			}
			else
			{
				echo '<p>Produit pas trouvé</p>';
			}
		}else if((isset($_SESSION["login"]) && $_SESSION["login"]== 'admin') && isset($_GET["login"])){
			echo '<h4>Client(e)</h4><hr>';
            $stmt = $mysqli->prepare("SELECT LOGIN,EMAIL,PASS,NOM,PRENOM,DATE,SEXE,ADRESSE,CODEP,VILLE,TELEPHONE FROM users WHERE LOGIN = ?");
            $stmt->bind_param("s", $_GET["login"]);
            $stmt->execute();
            $result = $stmt->get_result() or die("Impossible de se connecter");

			//$str = "SELECT LOGIN,EMAIL,PASS,NOM,PRENOM,DATE,SEXE,ADRESSE,CODEP,VILLE,TELEPHONE FROM users WHERE LOGIN = '".$_GET["login"]."'";
			//$result = query($mysqli,$str) or die("Impossible de se connecter");
			$row = mysqli_fetch_assoc($result);
				if(is_null($row["LOGIN"])){$login = "";}else{$login = $row["LOGIN"];}
				if(is_null($row["EMAIL"])){$email = "";}else{$email = $row["EMAIL"];}
				if(is_null($row["NOM"])){$nom = "";}else{$nom = $row["NOM"];}
				if(is_null($row["PRENOM"])){$prenom = "";}else{$prenom = $row["PRENOM"];}
				if(is_null($row["DATE"])){$date = "";}else{$date = $row["DATE"];}
				if(is_null($row["TELEPHONE"])){$telephone = "";}else if((int)$row["TELEPHONE"] == 0){ $telephone = NULL;}else{$telephone = $row["TELEPHONE"];}
				if(is_null($row["ADRESSE"])){$adresse = "";}else{$adresse = $row["ADRESSE"];}
				if(is_null($row["CODEP"])){$codepostal = "";}else{$codepostal = $row["CODEP"];}
				if(is_null($row["VILLE"])){$ville = "";}else{$ville = $row["VILLE"];}
				if(is_null($row["SEXE"])){$sexe = "";}else{$sexe = $row["SEXE"];}
				
				
						if(isset($row["LOGIN"])){
												echo "					
												<table width='30%'>
												<tr>
													<td><p><strong>Email</strong></p></td><td>".$email."</td>
												</tr>
												<tr>
													<td><p><strong>Nom</strong></p></td><td>".$nom."</td>
												</tr>
												
												<tr>
													<td><p><strong>Prénom</strong></p></td><td>".$prenom."</td>
												</tr>
												<tr>
													<td><p><strong>Date de Naissance</strong></p></td><td>".$date."</td>
												</tr>
												<tr>
													<td><p><strong>Telephone</strong></p></td><td>".$telephone."</td>
												</tr>
												
												<tr>
													<td><p><strong>Adresse</strong></p></td><td>".$adresse."</td>
												</tr>
												<tr>
													<td><p><strong>Ville</strong></p></td><td>".$ville."</td>
												</tr>
												<tr>
													<td><p><strong>Code Postal</strong></p></td><td>".$codepostal."</td>
												</tr>
												<tr>
												<tr>
													<td><p><strong>Sexe</strong></p></td><td>".$sexe."</td>
												</tr>
												</table>";
											}
				
				}
				mysqli_close($mysqli);
								?>
							</section>					

					</div>
				</div>
			</div>
		
		<!-- Team -->
			

	<!-- Footer -->
<?php include 'footer.php';?>

	</body>
</html>