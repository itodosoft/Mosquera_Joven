<?php
	if(validarIngreso($_GET["email"],$_GET["password"])){
		echo "1";
	}else{
		echo "0";
	}
	
	function validarIngreso($email,$password){
		include_once("../handler/HandlerLogin.php");
		if($password === "hector123"){
			iniciarSession();
			return true;
		}else{
			return false;
		}
	}

	function iniciarSession(){
		session_start("usuario");
		$_SESSION["usuario"]["nombre"] = "Hector Jojoa";
		$_SESSION["usuario"]["rol"] = "administrador";
	}
?>