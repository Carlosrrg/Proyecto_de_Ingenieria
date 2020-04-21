<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$accion = $_POST["accion"];
	if ($accion == "subcategorias") {	//SE MANDAN A LLAMAR LAS SUBCATEGORIAS
		$categoria = $_POST["slc-categoria"];
		$resultado = $conexion->ejecutarInstruccion("
			SELECT A.CODIGO_SUB_CATEGORIA, A.NOMBRE_SUB_CATEGORIA FROM TBL_SUB_CATEGORIAS A
			INNER JOIN TBL_CATEGO_X_TBL_SUBCATEGO B
			ON A.CODIGO_SUB_CATEGORIA = B.CODIGO_SUB_CATEGORIA
			WHERE B.CODIGO_CATEGORIA = '$categoria'");
		oci_execute($resultado);

	    $resultadoSubcategorias = array();

	    while($fila = $conexion->obtenerFila($resultado)){
	        $resultadoSubcategorias[] = $fila;
	    }
	    echo json_encode($resultadoSubcategorias);

	} 

	$conexion->cerrarConexion();
?>
