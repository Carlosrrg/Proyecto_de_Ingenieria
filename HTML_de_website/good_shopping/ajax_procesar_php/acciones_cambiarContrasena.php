<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$contrasena_actual = $_POST["txt-contrasena-actual"];
	$contrasena_nueva = $_POST["txt-contrasena-nueva"];
	
	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];
	$mensaje = 0;

	//echo $contrasena_actual.$contrasena_nueva."  ".$codigo_usuario;

	$resultado_usuarios_contrasena = $conexion->ejecutarInstruccion("	SELECT 	CONTRASENA
																		FROM TBL_USUARIOS
																		WHERE CODIGO_USUARIO = '$codigo_usuario'");
	oci_execute($resultado_usuarios_contrasena);
	while ($fila = $conexion->obtenerFila($resultado_usuarios_contrasena)) {
		if ($contrasena_actual == $fila["CONTRASENA"]) {
		 	$mensaje = 1;
		}
	} 

	if ($mensaje == 1) {
		$resultado_usuarios_vendedor = $conexion->ejecutarInstruccion("	UPDATE TBL_USUARIOS
																		SET CONTRASENA = '$contrasena_nueva'
																		WHERE CODIGO_USUARIO = '$codigo_usuario'");
		oci_execute($resultado_usuarios_vendedor);
		$cantidad = $conexion->cantidadRegistros($resultado_usuarios_vendedor);
		if ($cantidad == " ") {
			echo $mensaje = 2;
		}
		else{
			$resultado_usuarios_vendedor = $conexion->ejecutarInstruccion("COMMIT");
			oci_execute($resultado_usuarios_vendedor);
			echo $mensaje;
		}
	}
	else{
		echo $mensaje;
	}

	
	$conexion->cerrarConexion();
?>