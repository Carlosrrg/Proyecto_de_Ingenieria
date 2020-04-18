<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	//$codigo_usuario_comprador = $_SESSION['codigo_usuario_sesion'];
	$codigo_usuario_comprador = 8;

	$codigo_publicacion = $_POST["codigo-publicacion"];
	$codigo_usuario_vendedor = $_POST["codigo-usuario-vendedor"];
	$motivo_denuncia = $_POST["codigo-motivo"];
	$comentario = $_POST["comentario"];

	//echo $codigo_publicacion.$codigo_usuario_vendedor.$motivo_denuncia.$comentario." ".$codigo_usuario_comprador;

	
	$agregar_denuncia = $conexion->ejecutarInstruccion("	DECLARE
															    V_CODIGO_REPORTE INTEGER;
															BEGIN
															    P_AGREGAR_REPORTE_DENUNCIAS ($codigo_usuario_comprador, 2, $codigo_publicacion, $codigo_usuario_vendedor, $motivo_denuncia, SYSDATE, '$comentario', V_CODIGO_REPORTE);
															    DBMS_OUTPUT.PUT_LINE('CODIGO_REPORTE: '||V_CODIGO_REPORTE);
															END;");
	oci_execute($agregar_denuncia);

	echo $respuesta = 0;

	$conexion->cerrarConexion();
?>
