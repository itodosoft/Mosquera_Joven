<?php session_start();
	error_reporting(E_ERROR);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Mosquera Joven</title>
	<script src="js/jquery-2.1.0.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/estiloBanner.css">
	<script type="text/javascript" src="js/index.js"></script>
	

	<!-- SCRIPTS PARA EL FUNCIONAMIENTO DE LOS INCLUDE -->
		<?php
			if($_SESSION["usuario"]["rol"] == "administrador"){
				echo '<script type="text/javascript" src="js/administrador.js"></script>';
			}else if($_SESSION["usuario"]["rol"] == "estudiante"){
				echo '<script type="text/javascript" src="js/estudiante.js"></script>';
			}
		?>
	<!--  FIN  -->

</head>
<body background="images/img_plataforma/fondo_index.jpg">
	<header  class="header">
		<div id="banner" class="col-xs-12">
			<img  src="images/img_plataforma/logo_alcaldia.png"  id="img_banner">
		</div>
		<br/>

		<div align = "center">
			
			<br />
			<?php
				if(isset($_SESSION["usuario"])){
					echo "
						<label><h1>Bienvenido : Hector Jojoa</h1>".$_SESSION["usuario"]["nombre"]." </label>
						<button id='cerrar_session' class='btn btn-lg btn-warning btn-block'>Cerrar Session</button>
					";
				}
			?>
		</div>
	</header>
	<div class="row" id="container_principal">
		<div class="col-xs-3">
			
				<img src="images/img_plataforma/log.png" id="img_banner">
			
		</div>
		<aside id="menu" class="col-xs-2">
			<?php
				if($_SESSION["usuario"]["rol"] == "administrador"){
					include_once("view/menu_administrador.php");
				}else if($_SESSION["usuario"]["rol"] == "estudiante"){
					include_once("view/menu_estudiante.php");	
				}
			?>
		</aside>
		
		<section class="col-xs-7 .col-md-5">
			<article>
				<div id="container">
					<?php
						if(!isset($_SESSION["usuario"])){
							include_once("view/login.php");
						}
					?>
				</div>
			</article>
		</section>
	</div>
	<br/>
	<footer id="pie" align="center">
	
		<h4><b>Universidad de Cundinamarca Hector Jojoa cabrera</b></h4>
	</footer>
</body>
</html>