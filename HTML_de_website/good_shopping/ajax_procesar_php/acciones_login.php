<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();
	$email = $_POST["inputEmail"];
	$password = $_POST["inputPassword"];
	$verificacion = 0;


	if ($email == "" ||  $password == "") {
		//echo "Ingrese los datos solicitados para iniciar seccion";
		echo $verificacion;
	}
	else{
		$resultado_usuarios = $conexion->ejecutarInstruccion("	SELECT 	CODIGO_USUARIO,
											 							USUARIO_PLATAFORMA,
											 							NOMBRE_COMPLETO, 
											 							CORREO_ELECTRONICO, 
											 							CONTRASENA
																FROM TBL_USUARIOS
																WHERE CORREO_ELECTRONICO = '$email'
																AND CONTRASENA = '$password'");
		oci_execute($resultado_usuarios);
		while ($fila = $conexion->obtenerFila($resultado_usuarios)) {
		 	if ($fila["CORREO_ELECTRONICO"] == $_POST["inputEmail"] && $fila["CONTRASENA"] == $_POST["inputPassword"]) {
		 		//echo $fila["CODIGO_USUARIO"] . ", nombre= ". $fila["NOMBRE_COMPLETO"] . ",    correo = " . $fila["CORREO_ELECTRONICO"] . "   " . "contrasena = " . $fila["CONTRASENA"] . "<br>";
		 		$codigo_usuario = $fila["CODIGO_USUARIO"];
		 	}
		} 
	}

	//valida session
	if (!isset($codigo_usuario)) {
		echo $verificacion;
	}
	else{
		echo $_SESSION['codigo_usuario'] = $codigo_usuario;
		//echo "<br>variable codigo_usuario con un valor= " . $_SESSION['codigo_usuario'];
	}
	
	//echo "<br>";
	$conexion->cerrarConexion();
?>