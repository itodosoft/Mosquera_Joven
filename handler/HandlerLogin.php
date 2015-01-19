<?php
	include_once("../class/SQL.php");
	$conexion = new Query();
	$usuario = $conexion->getRowsQuery("persona",array("correo","numero_documento"), array("si@si.com", "0"));
	$conexion->cerrarConexion();
?>