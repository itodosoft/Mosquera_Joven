<?php
	include_once("../class/SQL.php");
	class HandlerPersona{

		private $conexion;

		public function __construct(){
			$this->conexion = new Query();
		}

		public function getRangePerson($start_row,$end_row){
			return $this->conexion->getSimpleRangeRowsQuery('persona', $start_row, $end_row, array('nombre'), 2);
		}

		public function alterPersona($datos){
			return $this->conexion->runStoredProcedure("SP_AlterPersona",1,$datos);
		}

	}

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
		var_dump($a);
	}
?>