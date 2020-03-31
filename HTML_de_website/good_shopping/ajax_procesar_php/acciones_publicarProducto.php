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

	} else {	//SE DIO CLICK A PUBLICAR PRODUCTO, GUARDAR EN LA BASE DE DATOS
		$nombre = $_POST["txt-nombre-producto"];
		$moneda = $_POST["rbt-moneda"];
		$precio = $_POST["txt-precio-producto"];
		$descripcion = $_POST["txt-descripcion"];
		$tipo_publicacion = $_POST["slc-tipo-publicacion"];
		$codigo_usuario = $_SESSION['codigo_usuario_sesion'];

		if ($tipo_publicacion == 1) {	//De producto
			$estado = $_POST["estadoProducto"];
			$categoria = $_POST["slc-categoria"];
			$subcategorias = $_POST["chk-subcategorias"];

			$guardar_producto = $conexion->ejecutarInstruccion("
				DECLARE
				    V_CODIGO_PUBLICACION_PRODUCTO INTEGER;
				BEGIN
				    P_AGREGAR_PRODUCTO_SERVICIO ('$tipo_publicacion', '$moneda', '$estado', '$categoria', 1, '$nombre', '$precio', '$descripcion', SYSDATE, 1, V_CODIGO_PUBLICACION_PRODUCTO);
				END;");
			oci_execute($guardar_producto);

			$producto_vendedor = $conexion->ejecutarInstruccion("
				INSERT INTO TBL_VEND_X_TBL_PUBLI (CODIGO_USUARIO_VENDEDOR,CODIGO_PUBLICACION_PRODUCTO)
				SELECT '$codigo_usuario',CODIGO_PUBLICACION_PRODUCTO FROM TBL_PUBLICACION_PRODUCTOS WHERE ROWNUM=1 ORDER BY CODIGO_PUBLICACION_PRODUCTO DESC");
			oci_execute($producto_vendedor);

			$obtiene_vendedor = $conexion->ejecutarInstruccion("
				SELECT CODIGO_TIPO_VENDEDOR,CODIGO_TIENDA FROM TBL_VENDEDORES
				WHERE CODIGO_USUARIO_VENDEDOR = '$codigo_usuario'");
			oci_execute($obtiene_vendedor);

			while ($fila = $conexion->obtenerFila($obtiene_vendedor)) {
				$codigo_tipo_vendedor = $fila["CODIGO_TIPO_VENDEDOR"];
				$codigo_tienda = $fila["CODIGO_TIENDA"];
			}

			if ($codigo_tipo_vendedor == 2) { 	//vendedor empresarial
				$producto_tienda = $conexion->ejecutarInstruccion("
					INSERT INTO TBL_TIENDA_X_TBL_PUBLICACION (CODIGO_TIENDA,CODIGO_PUBLICACION_PRODUCTO)
					SELECT '$codigo_tienda',CODIGO_PUBLICACION_PRODUCTO 
					FROM TBL_PUBLICACION_PRODUCTOS WHERE ROWNUM=1 ORDER BY CODIGO_PUBLICACION_PRODUCTO DESC");
				oci_execute($producto_tienda);
			}

			echo 'Producto publicado con éxito!';

		} else {	//De servicio ***************No se agregaran los servicios de momento******************

			//***************CODIGO PARA GUARDAR SERVICIO***************************
			echo 'De momento no se guardan los servicios!';
		}

	}

	$conexion->cerrarConexion();
?>
