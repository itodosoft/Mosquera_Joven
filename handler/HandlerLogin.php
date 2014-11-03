<?php
	include_once("../class/SQL.php");
	$conexion = new Query();
	$usuario = $conexion->getRowsQuery("usuario",array("usuario","clave"))
	$conexion->cerrarConexion();
?>