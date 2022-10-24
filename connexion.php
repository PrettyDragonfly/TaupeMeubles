<?php
	session_start();
	if(isset($_SESSION["login"])){
		header('location: profil.php');
	}
	include 'fonctions/fonctionsLayout.php';
	include 'fonctions/fonctionsConnexion.php';
	
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
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
		<script>
			$().ready(function() {
				$('#submit').click(function (){
				$.ajax({
					type: 'POST',
					url: 'fonctions/fonctionsLogin.php',
					data: {login : $('#login').val(), password : $('#password').val(), captcha : $('#g-recaptcha-response').val()},
					success: function(data){
								alert(data);
								location.reload();						
					},
				});
			});
			});
		</script>
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
						<div id="content" class="8u skel-cell-important">
							<section>
								<header class="major">
									<h2>Connexion</h2>
								</header>
								<div id="reponse"></div>
								<?php //afficherConnexion(); 
								afficherCaptcha();?>
							</section>
						</div>					
					</div>
				</div>
			</div>
	</body>
	
</html>