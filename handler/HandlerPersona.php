<?php
	include_once("../class/SQL.php");
	include_once("../class/HandlerPersona.php");
	if(isset($_POST['opcion'])){
		$handler_persona = new HandlerPersona();
		$datos = null;
		switch ($_POST['opcion']) {
			case 'new_persona':
				$datos = array(1,$_POST['numero_documento'],$_POST['nombre'],$_POST['direccion'],$_POST['barrio'],$_POST['telefono'],$_POST['correo_electronico']);
				break;
			case 'edit_persona':
				$datos = array(2,$_POST['numero_documento'],$_POST['nombre'],$_POST['direccion'],$_POST['barrio'],$_POST['telefono'],$_POST['correo_electronico']);
				break;
			default:
				echo "Otra opcion: ".$_POST['opcion'];
				break;
		}

		$a =  $handler_persona->alterPersona($datos);
		$HandlerPersona->cerrarConexion();
		var_dump($a);
	}
?>