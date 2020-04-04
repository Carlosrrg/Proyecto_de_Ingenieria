<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$nombre = $_POST["txt-nombre"];
	$apellido = $_POST["txt-apellido"];
	$telefono = $_POST["txt-telefono"];
	$ubicacion = $_POST["slc-ubicacion"];
	$ciudad = $_POST["txt-ciudad"];
	$fecha_dia = $_POST["slc-dia"];
	$fecha_mes = $_POST["slc-mes"];
	$fecha_anio = $_POST["slc-anio"];

	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];
	$mensaje = 0;

	//echo $nombre.$apellido.$telefono.$ubicacion.$ciudad.$fecha_dia.$fecha_mes.$fecha_anio."  ".$codigo_usuario;

	$resultado_usuarios_vendedor = $conexion->ejecutarInstruccion("	UPDATE TBL_USUARIOS
																	SET NOMBRE = '$nombre',
																	    APELLIDO = '$apellido',
																	    TELEFONO = '$telefono',
																	    CODIGO_LUGAR = $ubicacion,
																	    CIUDAD = '$ciudad',
																	    FECHA_NACIMIENTO = TO_DATE('$fecha_dia/$fecha_mes/$fecha_anio', 'DD/MM/YYYY')
																	WHERE CODIGO_USUARIO = '$codigo_usuario'");
	oci_execute($resultado_usuarios_vendedor);
	$cantidad = $conexion->cantidadRegistros($resultado_usuarios_vendedor);
	if ($cantidad == " ") {
		echo $mensaje;
	}
	else{
		$resultado_usuarios_vendedor = $conexion->ejecutarInstruccion("COMMIT");
		oci_execute($resultado_usuarios_vendedor);
		echo $mensaje = 1;
	}

	
	$conexion->cerrarConexion();
?>