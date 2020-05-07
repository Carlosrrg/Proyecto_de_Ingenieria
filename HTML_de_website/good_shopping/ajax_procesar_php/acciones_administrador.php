<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	/*
	DESCRIPCION DE LA VARIABLE ACCION
	accion = 1 -> cambia los dias para publicaciones de vendedores 
	accion = 2 -> agrega un nuevo servicio
	accion = 3 -> muestra estadisticas por tiempo
	accion = 4 -> muestra las denuncias
	accion = 5 -> Da de baja o elimina producto
	accion = 6 -> Muestra las publicaciones eliminadas
	accion = 7 -> agrega una nueva subcategoria
	accion = 8 -> elimina servicios
	accion = 9 -> elimina subcategorias
	accion = 10 -> filtra vendedores
	*/

	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];
	$accion = $_POST['accion'];

	if ($accion == 1) {
		$dias = $_POST['dias'];
		$tipo_vendedor = $_POST['tipo-vendedor'];
		$cambia_dias = $conexion->ejecutarInstruccion("	
			UPDATE TBL_G_PUBLICACIONES
			SET CODIGO_USUARIO = '$codigo_usuario',
				DIAS_VIGENTES = '$dias'
			WHERE CODIGO_TIPO_VENDEDOR = '$tipo_vendedor'");
		oci_execute($cambia_dias);

		$resultado = $conexion->ejecutarInstruccion("COMMIT");
		oci_execute($resultado);

		echo 0;
	}
	if ($accion == 2) {
		$servicio = $_POST['servicio'];

		$obtiene_servicios = $conexion->ejecutarInstruccion("	
			SELECT NOMBRE_SERVICIO FROM TBL_SERVICIOS
			WHERE UPPER(NOMBRE_SERVICIO) LIKE UPPER('%".$servicio."%')");
		oci_execute($obtiene_servicios);

		$cantidad = 0;
		while ($fila = $conexion->obtenerFila($obtiene_servicios)) {
			$cantidad++;
		}

		if ($cantidad == 0) {
			$agrega_servicio = $conexion->ejecutarInstruccion("	
				DECLARE
				    V_CODIGO_SERVICIO INTEGER;
				BEGIN
				    P_AGREGAR_SERVICIOS ('$servicio',V_CODIGO_SERVICIO);
				END;");
			oci_execute($agrega_servicio);

			$resultado = $conexion->ejecutarInstruccion("COMMIT");
			oci_execute($resultado);

			echo 0;
		} else {
			echo 'ExisteServicio';
		}

	}
	if ($accion == 4) {
		$busqueda = "%".$_POST['busqueda']."%";
		$subaccion = $_POST['subaccion'];

		if($subaccion==1){
			$muestra_denuncias = $conexion->ejecutarInstruccion("	
				SELECT  A.CODIGO_REPORTE,
				        A.CODIGO_TIPO_REPORTE,
				        B.NOMBRE_TIPO_REPORTE,
				        NVL(A.CODIGO_PUBLICACION_PRODUCTO,0) CODIGO_PUBLICACION_PRODUCTO,
				        NVL(C.NOMBRE_PRODUCTO,0) NOMBRE_PRODUCTO,
				        E.NOMBRE_MOTIVO_REPORTE,
				        TO_CHAR(A.FECHA_EMITIO,'DD/MM/YYYY') AS FECHA_EMITIO,
				        NVL(A.COMENTARIO_REPORTE,'*El usuario no hizo comentarios*') COMENTARIO_REPORTE,
				        NVL(F.CANTIDAD_REPORTES,0) CANTIDAD_REPORTES
				FROM TBL_REPORTES A
				INNER JOIN TBL_TIPO_REPORTE B
				ON A.CODIGO_TIPO_REPORTE = B.CODIGO_TIPO_REPORTE
				LEFT JOIN TBL_PUBLICACION_PRODUCTOS C
				ON A.CODIGO_PUBLICACION_PRODUCTO = C.CODIGO_PUBLICACION_PRODUCTO
				INNER JOIN TBL_MOTIVO_REPORTE E
				ON E.CODIGO_MOTIVO_REPORTE = A.CODIGO_MOTIVO_REPORTE
				LEFT JOIN (
	                SELECT  NVL(CODIGO_PUBLICACION_PRODUCTO,0) CODIGO_PUBLICACION_PRODUCTO, 
	                        COUNT(*) CANTIDAD_REPORTES FROM TBL_REPORTES
	                GROUP BY CODIGO_PUBLICACION_PRODUCTO ) F
	            ON F.CODIGO_PUBLICACION_PRODUCTO = A.CODIGO_PUBLICACION_PRODUCTO
				WHERE UPPER(C.NOMBRE_PRODUCTO) LIKE UPPER('$busqueda')
				ORDER BY A.CODIGO_REPORTE DESC");

			oci_execute($muestra_denuncias);

			$resultado = array();

		    while($fila = $conexion->obtenerFila($muestra_denuncias)){
		        $resultado[] = $fila;
		    }

		    echo json_encode($resultado);
		} else {
			$muestra_denuncias_vendedores = $conexion->ejecutarInstruccion("	
			SELECT  NVL(A.CODIGO_USUARIO_VENDEDOR,0) CODIGO_USUARIO_VENDEDOR, 
					B.NOMBRE||' '||B.APELLIDO NOMBRE_COMPLETO_VENDEDOR,
					B.CORREO_ELECTRONICO,B.TELEFONO,
                    COUNT(*) CANTIDAD_REPORTES_VENDEDORES
            FROM TBL_REPORTES A
            INNER JOIN TBL_USUARIOS B
            ON A.CODIGO_USUARIO_VENDEDOR = B.CODIGO_USUARIO
            WHERE UPPER(B.NOMBRE||' '||B.APELLIDO) LIKE UPPER('$busqueda')
            GROUP BY A.CODIGO_USUARIO_VENDEDOR,B.NOMBRE||' '||B.APELLIDO,
            B.CORREO_ELECTRONICO,B.TELEFONO
            HAVING COUNT(*) > 4
            ORDER BY COUNT(*) DESC");

			oci_execute($muestra_denuncias_vendedores);

			$resultadoDenunciasVendedores = array();

		    while($fila = $conexion->obtenerFila($muestra_denuncias_vendedores)){
		        $resultadoDenunciasVendedores[] = $fila;
		    }

		    echo json_encode($resultadoDenunciasVendedores);
		}
	}

	if ($accion == 5) {
		$tipo_reporte = $_POST['tipo-reporte'];
		$codigo = $_POST['codigo'];
		$codigo_reporte = $_POST['codigo-reporte'];
		if ($tipo_reporte == 1) { // reporte de vendedor

			$edita_usuario = $conexion->ejecutarInstruccion("	
				UPDATE TBL_USUARIOS
				SET CORREO_ELECTRONICO = 'correo_deshabilitado'
				WHERE CODIGO_USUARIO = '$codigo'");
			oci_execute($edita_usuario);

			$edita_reporte = $conexion->ejecutarInstruccion("
				UPDATE TBL_REPORTES
				SET COMENTARIO_REPORTE = '****RESUELTO****'
				WHERE CODIGO_USUARIO_VENDEDOR = '$codigo'");
			oci_execute($edita_reporte);

		}
		if ($tipo_reporte == 2) { // reporte de producto

			$edita_producto = $conexion->ejecutarInstruccion("
				UPDATE TBL_PUBLICACION_PRODUCTOS
				SET CODIGO_ESTADO_PUBLICACION = 3
				WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo'");
			oci_execute($edita_producto);

			$edita_reporte = $conexion->ejecutarInstruccion("
				UPDATE TBL_REPORTES
				SET COMENTARIO_REPORTE = '****RESUELTO****'
				WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo'");
			oci_execute($edita_reporte);

		}

		$resultado = $conexion->ejecutarInstruccion("COMMIT");
		oci_execute($resultado);

		echo 0;
	}

	if ($accion == 6) {
		$muestra_eliminaciones = $conexion->ejecutarInstruccion("	
			SELECT  B.NOMBRE||' '||B.APELLIDO AS NOMBRE_COMPLETO,
			        C.NOMBRE_PRODUCTO,
			        D.NOMBRE_MOTIVO_ELIMINACION,
			        NVL(A.COMENTARIOS,'*No realizo comentarios*') COMENTARIOS,
			        TO_CHAR(A.FECHA_EMITIO,'DD/MM/YYYY') AS FECHA_EMITIO
			FROM TBL_ADM_ELIMINACIONES A
			INNER JOIN TBL_USUARIOS B
			ON A.CODIGO_USUARIO_VENDEDOR=B.CODIGO_USUARIO
			INNER JOIN TBL_PUBLICACION_PRODUCTOS C
			ON A.CODIGO_PUBLICACION_PRODUCTO=C.CODIGO_PUBLICACION_PRODUCTO
			INNER JOIN TBL_MOTIVO_ELIMINACION D
			ON A.CODIGO_MOTIVO_ELIMINACION=D.CODIGO_MOTIVO_ELIMINACION
			ORDER BY A.CODIGO_ELIMINACION DESC");

		oci_execute($muestra_eliminaciones);

		$resultadoEliminaciones = array();

	    while($filaE = $conexion->obtenerFila($muestra_eliminaciones)){
	        $resultadoEliminaciones[] = $filaE;
	    }

	    echo json_encode($resultadoEliminaciones);
	}

	if ($accion == 7) {
		$subcategoria = $_POST['subcategoria'];
		$categoria = $_POST['categoria'];

		$obtiene_subcategorias = $conexion->ejecutarInstruccion("	
			SELECT NOMBRE_SUB_CATEGORIA FROM TBL_SUB_CATEGORIAS
			WHERE UPPER(NOMBRE_SUB_CATEGORIA) LIKE UPPER('%".$subcategoria."%')");
		oci_execute($obtiene_subcategorias);

		$cantidad = 0;
		while ($fila = $conexion->obtenerFila($obtiene_subcategorias)) {
			$cantidad++;
		}

		if ($cantidad == 0) {
			$agrega_servicio = $conexion->ejecutarInstruccion("	
				DECLARE
				    V_CODIGO_SUBCATEGORIA INTEGER;
				BEGIN
				    P_AGREGAR_SUBCATEGORIAS ('$subcategoria', '$categoria', V_CODIGO_SUBCATEGORIA);
				END;");
			oci_execute($agrega_servicio);

			$resultado = $conexion->ejecutarInstruccion("COMMIT");
			oci_execute($resultado);

			echo 0;
		} else {
			echo 'ExisteSubcategoria';
		}
	}

	if ($accion == 8) {
		$servicios = $_POST['servicios'];

		if ($servicios!="") {
			$servicios_ind = explode(",", $servicios);
			for ($i=0; $i < count($servicios_ind)-1 ; $i++) { 
				$elimina_servicio1 = $conexion->ejecutarInstruccion("	
					DELETE FROM TBL_VEND_X_TBL_SERV
					WHERE CODIGO_SERVICIO = '$servicios_ind[$i]'");
				oci_execute($elimina_servicio1);
				$elimina_servicio2 = $conexion->ejecutarInstruccion("	
					DELETE FROM TBL_PUBLIC_X_TBL_SERV
					WHERE CODIGO_SERVICIO = '$servicios_ind[$i]'");
				oci_execute($elimina_servicio2);
				$elimina_servicio3 = $conexion->ejecutarInstruccion("
					DELETE FROM TBL_SERVICIOS
					WHERE CODIGO_SERVICIO = '$servicios_ind[$i]'");
				oci_execute($elimina_servicio3);
			}
			$resultado = $conexion->ejecutarInstruccion("COMMIT");
			oci_execute($resultado);
		}
		echo 0;
	}

	if ($accion == 9) {
		$subcategorias = $_POST['subcategorias'];

		if ($subcategorias!="") {
			$subcategorias_ind = explode(",", $subcategorias);
			for ($i=0; $i < count($subcategorias_ind)-1 ; $i++) { 
				$elimina_categoria1 = $conexion->ejecutarInstruccion("	
					DELETE FROM TBL_CATEGO_X_TBL_SUBCATEGO
					WHERE CODIGO_SUB_CATEGORIA = '$subcategorias_ind[$i]'");
				oci_execute($elimina_categoria1);
				$elimina_categoria2 = $conexion->ejecutarInstruccion("	
					DELETE FROM TBL_PRODU_X_TBL_CATEGO
					WHERE CODIGO_SUB_CATEGORIA = '$subcategorias_ind[$i]'");
				oci_execute($elimina_categoria2);
				$elimina_categoria3 = $conexion->ejecutarInstruccion("
					DELETE FROM TBL_SUB_CATEGORIAS
					WHERE CODIGO_SUB_CATEGORIA = '$subcategorias_ind[$i]'");
				oci_execute($elimina_categoria3);
			}
			$resultado = $conexion->ejecutarInstruccion("COMMIT");
			oci_execute($resultado);
		}
		echo 0;
	}

	$conexion->cerrarConexion();
?>
