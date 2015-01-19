<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	include_once("../handler/HandlerPersona.php");
	$handler_persona = new HandlerPersona();
	function getAllPerson(){
		global $handler_persona;
		$return = "";
		$return .= "<center><a href='#' class='registro'><h3>Registrar Estudiante</h3></a></center>";
		$dato = $handler_persona->getRangePerson(1,10);
		$return .= "<table class='table-bordered' colspan = '0' cellspacing = '0'>
			<tr>
				<th><center><h3>Cedula</h3></center></th>
				<th><center><h3>Nombre</h3></center></th>
				<th><center><h3>Opciones</h3></center></th>
			</tr>";
		for ($i=0; $i < sizeof($dato); $i++) { 
			$return .= "<tr>
				<td><b>".$dato[$i]['numero_documento']."</b></td>
				<td>".$dato[$i]['nombre']."</td>
				<td>
					<button data-persona-edit='".$dato[$i]['numero_documento']."' class='btn-success'>
						<span class='glyphicon glyphicon-pencil'></span>
					</button>
					<button data-persona-activar='".$dato[$i]['numero_documento']."' class='btn-danger'>
						<span class='glyphicon glyphicon-remove'></span>
					</button>
				</td>
			</tr>";
		}
		$return .= "</table>";
		return $return;
	}

	if (isset($_REQUEST['opcion'])){
		switch ($_REQUEST['opcion']) {
			case 'getAllPerson':
				echo getAllPerson();
				break;
			default:
				echo "Bienvenido a la seccion de administrar persona";
				break;
		}
	}
?>