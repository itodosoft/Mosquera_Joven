<?php
/*class Query
	autor: Jonathan Castro Castiblanco.
	version: 1.3;
	utlima modificación: 31/05/13.
*/
class Query implements StoredProceduresAction{
	private $conexion;
	private $stored_procedure;
	private $database;
	private $server;
	private $user;
	private $pass;
	
	/*
	public function Query($server, $user, $pass){
		$this->conexion = mysql_connect($server, $user, $pass);
		$this->user = $user;
		$this->pass = $pass;
		$this->server = $server;
		$this->stored_procedure = 0;
		if(!$this->conexion){
			die("error conectando a la base de datos:".mysql_error());
		}
	}
	*/
	
	public function __construct(){
		
		$this->user = "root";
		$this->pass = "";
		$this->server = "localhost";
		$this->stored_procedure = 0;
		$this->conexion = mysql_connect($this->server, $this->user,$this->pass);
		$this->setDatabase("dbmosquerajoven");
		if(!$this->conexion){
			die("error conectando a la base de datos:".mysql_error());
		}
	}

	public function runStoredProcedure($_nombre, $_tipo, array $_valores){
		$mysqli = mysqli_connect($this->server, $this->user, $this->pass, $this->database);

		$_query = 'CALL '.$_nombre.' ('; 
		for($i = 0; $i<count($_valores); $i++){
			$_query.= "'".$_valores[$i]."',";
		}

		$_query = substr($_query, 0, (strlen($_query)-1)).')';

		switch($_tipo){
			case Query::SELECT:
				$array_results = array();
				if($peticion = mysqli_query($mysqli,$_query)){
					while ($registro = mysqli_fetch_array($peticion)){
						array_push($array_results, $registro);
					}
					mysqli_free_result ($peticion);
					return $array_results;
				}else{
					echo("error".mysqli_error()."<br><br>".$_query."<br><br>");
					mysqli_free_result ($peticion);
					return $array_results;
				}
			break;
			
			case Query::INSERT:
			case Query::UPDATE:
			case Query::DELETE:
				if($peticion = mysqli_query($mysqli,$_query)){
					mysqli_free_result($peticion);
					return true;
				}else{
					echo("error".mysqli_error()."<br>".$_query);
					return false;
				}
			break;
			
			default:
				return false;
		}
	}
	
	/**
	DESCRPCION:
		función:runQuery
		$sql:consulta a ejecutar
	NOTAS:
		no se recomienda su uso.
	**/
	public function runQuery($sql){
		$array_results = array();
		if($peticion = mysql_query($sql,$this->conexion)){
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result ($peticion);
			return $array_results;
		}else{
			echo("error".mysql_error()."<br><br>".$sql."<br><br>");
			mysql_free_result ($peticion);
			return $array_results;
		}
	}
	
	/**
	DESCRPCION:
		función:getNextIdTable
		$table:tabla
		$campo:campo id
	NOTAS:
		Obtiene el siguiente id en la tabla.
	**/
	public function getNextIdTable($table, $campo){
		$query = 'SELECT MAX('.$campo.') + 1 as max_id FROM '.$table;
		if($peticion = mysql_query($query, $this->conexion)){
			$array_results = array();
			while($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results[0]['max_id'];
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:getCountRowsTable
		$table:tabla
	NOTAS:
		Obtiene el total de registros.
	**/
	public function getCountRowsTable($table){
		$query = 'SELECT COUNT(*) as total FROM '.$table;
		if($peticion = mysql_query($query, $this->conexion)){
			$array_results = array();
			while($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results[0]['total'];
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:getCountRowsTableStrict
		$table:tabla
	NOTAS:
		Variacion de getCountRowsTable, obtiene total registros con validaciones AND.
	**/
	public function getCountRowsTableStrict($table, $campos, $datos){
		$string_busqueda = '';
		$invalid = array("--", "/*",);
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($campos); $i++){
				$string_busqueda.= $campos[$i].' = "'.str_replace($invalid, "", $datos[$i]).'" AND ';
			}
		}
		$string_busqueda = substr($string_busqueda,0,(strlen($string_busqueda)-4));
		$query = 'SELECT COUNT(*) as total FROM '.$table." WHERE ".$string_busqueda;
		if($peticion = mysql_query($query, $this->conexion)){
			$array_results = array();
			while($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results[0]['total'];
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:getRowsQuery
		$table:tabla
		$campos:arreglo de campos
		$datos:arreglo valores campos
	NOTAS:
		elimina caracteres para evitar SQL injection
	**/
	public function getRowsQuery($table, $campos, $datos){
		$string_busqueda = '';
		$invalid = array("--", "/*",);
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($campos); $i++){
				$string_busqueda.= $campos[$i].' = "'.str_replace($invalid, "", $datos[$i]).'" AND ';
			}
		}
		$string_busqueda = substr($string_busqueda,0,(strlen($string_busqueda)-4));
		$query = "SELECT * FROM ".$table." WHERE ".$string_busqueda;
		if($peticion = mysql_query($query,$this->conexion)){
			$array_results = array();
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result ($peticion);
			return $array_results;
		}else{
			echo(mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:getSimpleRangeRowsQuery
		$table:tabla
		$start_row:row inicio
		$end_row:row fin
		$campos_orden:campos orden
		$tipo_orden:ase o desc
	NOTAS:
		obtiene rango de registros sin condiciones
	**/
	public function getSimpleRangeRowsQuery($table, $start_row, $end_row, $campos_orden, $tipo_orden){
		$string_orden = '';		
		for($i = 0; $i<count($campos_orden); $i++){
			$string_orden.= $campos_orden[$i].',';
		}
		$string_orden = substr($string_orden,0,(strlen($string_orden)-1));
		$string_orden.= ($tipo_orden == 1 ? " DESC" : " ASC");
		
		$query = "SELECT * FROM ".$table." ORDER BY ".$string_orden." LIMIT ".$start_row.",".$end_row;
		if($peticion = mysql_query($query,$this->conexion)){
			$array_results = array();
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result ($peticion);
			return $array_results;
		}else{
			echo(mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:getRangeRowsQuery
		$table:tabla
		$campos:arreglo de campos
		$datos:arreglo valores campos
		$start_row:row inicio
		$end_row:row fin
		$campos_orden:campos orden
		$tipo_orden:ase o desc
	NOTAS:
		elimina caracteres para evitar SQL injection, selecciona un rango de registros
	**/
	public function getRangeRowsQuery($table, $campos, $datos, $start_row, $end_row, $campos_orden, $tipo_orden){
		$string_busqueda = '';
		$string_orden = '';
		$invalid = array("--", "/*",);
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($campos); $i++){
				$string_busqueda.= $campos[$i].' = "'.str_replace($invalid, "", $datos[$i]).'" AND ';
			}
			for($i = 0; $i<count($campos_orden); $i++){
				$string_orden.= $campos_orden[$i].',';
			}
		}
		
		$string_busqueda = substr($string_busqueda,0,(strlen($string_busqueda)-4));
		$string_orden = substr($string_orden,0,(strlen($string_orden)-1));
		$string_orden.= ($tipo_orden == 1 ? " DESC" : " ASC");
		
		$query = "SELECT * FROM ".$table." WHERE ".$string_busqueda." ORDER BY ".$string_orden." LIMIT ".$start_row.",".$end_row;
		if($peticion = mysql_query($query,$this->conexion)){
			$array_results = array();
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result ($peticion);
			return $array_results;
		}else{
			echo(mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:getTable
		$table:tabla
		$campo_orden:campo para ordenar
		$tipo_orden: 1 DESC : 0 ASC
	NOTAS:
		
	**/
	public function getTable($table, $campo_orden, $tipo_orden){
		$query = "SELECT * FROM ".$table." ORDER BY ".$campo_orden.($tipo_orden == 1 ? " DESC" : " ASC");
		if($peticion = mysql_query($query,$this->conexion)){
			$array_results = array();
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results;
		}else{
			echo(mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:insertRowTable
		$table:tabla
		$campos:campos tabla
		$datos:datos a insertar
	NOTAS:
		
	**/
	public function insertRowTable($table, $campos, $datos){
		$query = "INSERT INTO ".$table." (";
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($campos); $i++){
				$query.= $campos[$i]."," ;
			}
		}
		$query = substr($query,0,(strlen($query)-1));
		$query.=") VALUES (";
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($datos); $i++){
				$query.= "'".$datos[$i]."'," ;
			}
		}
		$query = substr($query,0,(strlen($query)-1));
		$query.=")";
		if($peticion = mysql_query($query,$this->conexion)){
			return true;
		}else{
			echo(mysql_error()."<br>".$query);
		}
	}
	
	/**
	DESCRPCION:
		función:updateRowsTable
		$table:tabla
		$campos:campos a actualizar
		$datos:datos para actualizar
		$_campos:campos condiciones
		$_valores:valores para condiciones
	NOTAS:
		Actualiza campos bajo condiciones AND
	**/
	public function updateRowsTable($table, $campos, $datos, $_campos, $_valores){
		$string_edicion = '';
		$string_validacion = '';
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($campos); $i++){
				$string_edicion.= $campos[$i].' = "'.$datos[$i].'", ';
			}
		}
		if(count($_campos) == count($_valores)){
			for($i = 0; $i<count($_campos); $i++){
				$string_validacion.= $_campos[$i].' = "'.$_valores[$i].'"AND ';
			}
		}
		$string_edicion = substr($string_edicion,0,(strlen($string_edicion)-2));
		$string_validacion = substr($string_validacion,0,(strlen($string_validacion)-4));
		$query = 'UPDATE '.$table.' SET '.$string_edicion.' WHERE '.$string_validacion;
		if($peticion = mysql_query($query, $this->conexion)){
			mysql_free_result($peticion);
			return true;
		}else{
			echo("error".mysql_error()."<br>".$query);
			return false;
		}
	}
	
	/**
	DESCRPCION:
		función:deleteRowsTable
		$table:tabla
		$campo:campo condicion
		$dato:valor para condicion
	NOTAS:
		Borra registro segun condicion
	**/
	public function deleteRowsTable($table,$campo,$dato){
		$query = 'DELETE FROM '.$table.' WHERE '.$campo.' = "'.$dato.'"';
		if($peticion = mysql_query($query,$this->conexion)){
			mysql_free_result($peticion);
			return true;
		}else{
			echo("error".mysql_error()."<br>".$query);
			return false;
		}
	}
	
	
	public function getRowsQueryOrder($table, $campo, $dato, $order){
		$query = "SELECT * FROM ".$table." WHERE ".$campo." = ".$dato." ORDER BY ".$order." DESC";
		if($peticion = mysql_query($query,$this->conexion)){
			$array_results = array();
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result ($peticion);
			return $array_results;
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}
	
	public function getTableFirstRows($table,$orden,$rows){
		$query = 'SELECT * FROM '.$table.' ORDER BY '.$orden.' DESC LIMIT '.$rows.'';
		if($peticion = mysql_query($query,$this->conexion)){
			$array_results = array();
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results;
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}
	
	public function getTableNextRows($table,$orden,$rows,$campo_start,$valor_start){
		$query = 'SELECT * FROM '.$table.' WHERE '.$campo_start.' < '.$valor_start.' ORDER BY '.$orden.' LIMIT '.$rows;
		if($peticion = mysql_query($query,$this->conexion)){
			$array_results = array();
			while ($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results;
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}
	
	/*
	DESCRPCION:
		función:getCountQueryStrict
		$table:tabla
		$campo:campo condicion
		$dato:valor para condicion
	NOTAS:
		DEPRECATED: usar getCountRowsTableStrict 
	*/
	public function getCountQueryStrict($table, $campos, $datos){
		$string_busqueda = '';
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($campos); $i++){
				$string_busqueda.= $campos[$i].' = "'.$datos[$i].'" AND ';
			}
		}
		$string_busqueda = substr($string_busqueda,0,(strlen($string_busqueda)-4));
		$query = 'SELECT COUNT(*) as total FROM '.$table.' WHERE '.$string_busqueda;
		if($peticion = mysql_query($query, $this->conexion)){
			$array_results = array();
			while($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results;
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}

	public function getLastIdTable($table, $id_campo, $campos, $datos){
		$string_busqueda = '';
		if(count($campos) == count($datos)){
			for($i = 0; $i<count($campos); $i++){
				$string_busqueda.= $campos[$i].' = "'.$datos[$i].'" AND ';
			}
		}
		$string_busqueda = substr($string_busqueda,0,(strlen($string_busqueda)-4));
		$query = 'SELECT MAX('.$id_campo.') as max_id FROM '.$table.' WHERE '.$string_busqueda;
		if($peticion = mysql_query($query, $this->conexion)){
			$array_results = array();
			while($registro = mysql_fetch_array($peticion)){
				array_push($array_results, $registro);
			}
			mysql_free_result($peticion);
			return $array_results;
		}else{
			echo("error".mysql_error()."<br>".$query);
		}
	}
	
	public function setDatabase($database){
		$this->database = $database;
		mysql_select_db($database, $this->conexion);
	}
	
	public function getDatabase(){
		return $this->database;
	}
	
	public function cerrarConexion(){
		mysql_close($this->conexion);
	}
}

interface StoredProceduresAction{
	const SELECT = 1;
	const INSERT = 2;
	const UPDATE = 3;
	const DELETE = 4;
}
?>