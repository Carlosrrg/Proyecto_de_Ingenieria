<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$correo = $_POST["txt-correo"];
	$contrasena = $_POST["txt-contrasena"];
	$codigo_usuario = "";
	$mensaje = "";

	if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		$resultado_usuarios = $conexion->ejecutarInstruccion("	SELECT CODIGO_USUARIO
																FROM TBL_USUARIOS
																WHERE CORREO_ELECTRONICO = '$correo'
																AND CONTRASENA = '$contrasena'");
		oci_execute($resultado_usuarios);
		while ($fila = $conexion->obtenerFila($resultado_usuarios)) {
		 	$codigo_usuario = $fila["CODIGO_USUARIO"];
		}
	}

	//valida session
	if (!isset($codigo_usuario)) {
		echo $mensaje = 0;
	}
	else{
		echo $_SESSION['codigo_usuario_sesion'] = $codigo_usuario;
	}
	

	$conexion->cerrarConexion();
?>