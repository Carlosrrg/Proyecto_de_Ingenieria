<?php
	//AJAX PARA ACTUALIZACION DE PUBLICACIONES Y ELIMINACION DE PUBLICACIONES
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];

	$solicitud = $_POST["solicitud"];
	$codigo_publicacion = $_POST["codigo-publicacion"];

	if ($solicitud == 1) {		//Selecciono Vendido
		
		$cambiar_estado = $conexion->ejecutarInstruccion("
			UPDATE TBL_PUBLICACION_PRODUCTOS
			SET CODIGO_ESTADO_PUBLICACION = 2
			WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
		oci_execute($cambiar_estado);

		$resultado = $conexion->ejecutarInstruccion("COMMIT");
		oci_execute($resultado);

		echo 0;
	}

	if ($solicitud == 4) { 		//Edita la publicacion
		$elimina_imagenes = $_POST["elimina-imagenes"];
		if ($elimina_imagenes == 1) {
			$imagenes_anteriores = array();
			$cont = 0;
			$obtiene_imagenes_anteriores = $conexion->ejecutarInstruccion("	
				SELECT A.CODIGO_IMAGEN FROM TBL_IMAGENES A
				INNER JOIN TBL_PROD_X_TBL_IMG B
				ON A.CODIGO_IMAGEN = B.CODIGO_IMAGEN
				WHERE B.CODIGO_PRODUCTO = '$codigo_publicacion'");
			oci_execute($obtiene_imagenes_anteriores);

			while ($fila = $conexion->obtenerFila($obtiene_imagenes_anteriores)) {
				$imagenes_anteriores[$cont] = $fila["CODIGO_IMAGEN"];
				$cont++;
			} 

			$elimina_img_publicacion = $conexion->ejecutarInstruccion("
				DELETE FROM TBL_PROD_X_TBL_IMG
				WHERE CODIGO_PRODUCTO = '$codigo_publicacion'");
			oci_execute($elimina_img_publicacion);

			for ($i=0; $i < count($imagenes_anteriores); $i++) { 
				$elimina_imagenes_principales = $conexion->ejecutarInstruccion("
					DELETE FROM TBL_IMAGENES
					WHERE CODIGO_IMAGEN = '$imagenes_anteriores[$i]'");
				oci_execute($elimina_imagenes_principales);
			}

		}

		$nombre = $_POST["txt-nombre-producto"];
		$moneda = $_POST["rbt-moneda"];
		$precio = $_POST["txt-precio-producto"];
		$descripcion = $_POST["txt-descripcion"];
		$tipo_publicacion = $_POST["slc-tipo-publicacion"];
		//$codigo_usuario = $_SESSION['codigo_usuario_sesion'];

		if ($tipo_publicacion == 1) {	//De producto
			$estado = $_POST["estadoProducto"];
			$categoria = $_POST["slc-categoria"];
			$subcategorias = $_POST["chk-subcategorias"];

			$actualiza_producto = $conexion->ejecutarInstruccion("
				UPDATE TBL_PUBLICACION_PRODUCTOS
				SET CODIGO_TIPO_MONEDA = '$moneda',
				    CODIGO_ESTADO_PRODUCTO = '$estado',
				    CODIGO_CATEGORIA = '$categoria',
				    NOMBRE_PRODUCTO = '$nombre',
				    PRECIO = '$precio',
				    DESCIPCION = '$descripcion'
				WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
			oci_execute($actualiza_producto);

			$elimina_subcategorias = $conexion->ejecutarInstruccion("
				DELETE FROM TBL_PRODU_X_TBL_CATEGO
				WHERE CODIGO_PRODUCTO = '$codigo_publicacion'");
			oci_execute($elimina_subcategorias);

			if ($subcategorias!="") {
				$subcategorias_ind = explode(",", $subcategorias);
				for ($i=0; $i < count($subcategorias_ind) ; $i++) { 
					$producto_subcategoria = $conexion->ejecutarInstruccion("	
						INSERT INTO TBL_PRODU_X_TBL_CATEGO (CODIGO_PRODUCTO,CODIGO_SUB_CATEGORIA)
						VALUES ('$codigo_publicacion','$subcategorias_ind[$i]')");
					oci_execute($producto_subcategoria);
				}
			}

		} else {	//De servicio
			$servicios = $_POST["chk-servicios"];

			$actualiza_producto = $conexion->ejecutarInstruccion("
				UPDATE TBL_PUBLICACION_PRODUCTOS
				SET CODIGO_TIPO_MONEDA = '$moneda',
				    NOMBRE_PRODUCTO = '$nombre',
				    PRECIO = '$precio',
				    DESCIPCION = '$descripcion'
				WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
			oci_execute($actualiza_producto);

			$elimina_servicios = $conexion->ejecutarInstruccion("
				DELETE FROM TBL_PUBLIC_X_TBL_SERV
				WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
			oci_execute($elimina_servicios);

			if ($servicios!="") {
				$servicios_ind = explode(",", $servicios);
				for ($i=0; $i < count($servicios_ind) ; $i++) { 
					$producto_servicio = $conexion->ejecutarInstruccion("	
						INSERT INTO TBL_PUBLIC_X_TBL_SERV (CODIGO_PUBLICACION_PRODUCTO,CODIGO_SERVICIO)
						VALUES ('$codigo_publicacion','$servicios_ind[$i]')");
					oci_execute($producto_servicio);
				}
			}

		}

		$resultado = $conexion->ejecutarInstruccion("COMMIT");
		oci_execute($resultado);

		echo 0;

	}

	$conexion->cerrarConexion();
?>
