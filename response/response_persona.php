<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
	include_once("../handler/HandlerPersona.php");
	$handler_persona = new HandlerPersona();
	function getAllPerson(){
		global $handler_persona;
		$return = "";
		$dato = $handler_persona->getRangePerson(1,10);
		$return .= "<table class='table'>
			<tr>
				<th>numero_documento</th>
				<th>Nombre</th>
				<th>Dirección</th>
				<th>Barrio</th>
				<th>Telefono</th>
				<th>Correo Electronico</th>
				<th>Opciones</th>
			</tr>";
		for ($i=0; $i < sizeof($dato); $i++) { 
			$return .= "<tr>
				<td><input type='number' class='form-control' id='numero_documento_".$dato[$i]['numero_documento']."' name='numero_documento' value='".$dato[$i]['numero_documento']."' disabled='disabled' /></td>
				<td><input type='text' class='form-control' id='nombre_".$dato[$i]['numero_documento']."' name='nombre' value='".$dato[$i]['nombre']."' disabled='disabled' /></td>
				<td><input type='text' class='form-control' id='direccion_".$dato[$i]['numero_documento']."' name='direccion' value='".$dato[$i]['direccion']."' disabled='disabled' /></td>
				<td><input type='text' class='form-control' id='barrio_".$dato[$i]['numero_documento']."' name='barrio' value='".$dato[$i]['barrio']."' disabled='disabled' /></td>
				<td><input type='text' class='form-control' id='telefono_".$dato[$i]['numero_documento']."' name='telefono' value='".$dato[$i]['telefono']."' disabled='disabled' /></td>
				<td><input type='email' class='form-control' id='correo_electronico_".$dato[$i]['numero_documento']."' name='correo_electronico' value='".$dato[$i]['correo_electronico']."' disabled='disabled' /></td>
				<td>
					<button data-persona-edit='".$dato[$i]['numero_documento']."' class='btn-success'>
						<span class='glyphicon glyphicon-pencil'></span>
					</button>
					<button data-persona-activar='".$dato[$i]['numero_documento']."' class='btn-warning'>
						<span class='glyphicon glyphicon-remove'></span>''
					</button>
				</td>
			</tr>";
		}
		$return .= "</table>";
		$return .= "<button type='button' id='mostrar_crear_persona' class='btn-primary'>
				<span class='glyphicon glyphicon-user'></span>
					Crear Emplado
				<span class='glyphicon glyphicon-arrow-down' id='span_opcion_crear_persona'></span>
			</button>
			<div id='new_persona_campos' data-estado='no_visible'>
				<input type='number' name='numero_documento' id='numero_documento' placeholder='Numero Documento'/>
				<input type='text' name='nombre' id='nombre' placeholder='nombre'/>
				<input type='text' name='direccion' id='direccion' placeholder='direccion'/>
				<input type='date' name='barrio' id='barrio' placeholder='barrio'/>
				<input type='tel' name='telefono' id='telefono' placeholder='telefono'/>
				<input type='email' name='correo_electronico' id='correo_electronico' placeholder='Correo Electronico'/>
				<button id='save_new_persona'>Guardar</button>
			</div>";
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