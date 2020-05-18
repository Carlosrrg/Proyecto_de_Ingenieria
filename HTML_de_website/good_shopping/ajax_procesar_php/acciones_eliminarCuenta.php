<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$contrasena = $_POST["contrasena"];
	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];

	$confirma_eliminar = false;
	$resultado_usuario = $conexion->ejecutarInstruccion("	
		SELECT CODIGO_USUARIO FROM TBL_USUARIOS
		WHERE CODIGO_USUARIO = '$codigo_usuario'
		AND CONTRASENA = '$contrasena'");
	oci_execute($resultado_usuario);
	while ($fila = $conexion->obtenerFila($resultado_usuario)) {
		$confirma_eliminar = true;
	}

	if ($confirma_eliminar) {

		$elimina_productos = $conexion->ejecutarInstruccion("	
			SELECT CODIGO_PUBLICACION_PRODUCTO
			FROM TBL_VEND_X_TBL_PUBLI
			WHERE CODIGO_USUARIO_VENDEDOR = '$codigo_usuario'");
		oci_execute($elimina_productos);
		while ($fila = $conexion->obtenerFila($elimina_productos)) {
			$codigo_publicacion = $fila["CODIGO_PUBLICACION_PRODUCTO"];
			$elimina = $conexion->ejecutarInstruccion("	
				UPDATE TBL_PUBLICACION_PRODUCTOS
				SET CODIGO_ESTADO_PUBLICACION = 3
				WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
			oci_execute($elimina);
		}

		$elimina_usuario = $conexion->ejecutarInstruccion("	
			UPDATE TBL_USUARIOS
			SET CORREO_ELECTRONICO = 'correo_deshabilitado'
			WHERE CODIGO_USUARIO = '$codigo_usuario'");
		oci_execute($elimina_usuario);

		$resultado = $conexion->ejecutarInstruccion("COMMIT");
		oci_execute($resultado);

		echo 0;

	} else {
		//contraseña incorrecta
		echo 1;
	}
	
	$conexion->cerrarConexion();
?>