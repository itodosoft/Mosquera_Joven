<?php session_start();
	error_reporting(E_ERROR);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mosquera Joven</title>
	<script src="js/jquery-2.1.0.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="js/index.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

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
<body>
	<header class="header">
		<div align = "center">
			<img src="images/img_plataforma/logo_alcaldia.png" id="img_banner">
			<br />
			<?php
				if(isset($_SESSION["usuario"])){
					echo "
						<label><b>Bienvenido : </b>".$_SESSION["usuario"]["nombre"]." </label>
						<button id='cerrar_session' class='btn btn-lg btn-warning btn-block'>Cerrar Session</button>
					";
				}
			?>
		</div>
	</header>
	<div class="row" id="container_principal">
		<div class="col-xs-6 col-md-3">
			<a href="#" class="thumbnail">
				<img src="images/img_plataforma/logo.png" alt="Logotipo Mosquera Joven">
			</a>
		</div>
		<aside id="menu" class="col-xs-1">
			<?php
				if($_SESSION["usuario"]["rol"] == "administrador"){
					include_once("view/menu_administrador.php");
				}else if($_SESSION["usuario"]["rol"] == "estudiante"){
					include_once("view/menu_estudiante.php");
				}
			?>
		</aside>
		<section class="col-xs-4 col-md-7">
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
	<footer id="pie" align="center">
		<hr />
		<h4><b>Copiright ITodosoft 2014</b></h4>
	</footer>
</body>
</html>