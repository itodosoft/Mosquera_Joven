<?php
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

		public function cerrarConexion(){
			$this->conexion->cerrarConexion();
		}

	}
?>