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
	}
	if ($accion == 3) {
		$tiempo = $_POST["tiempo"];

		if ($tiempo == "Tiempo") {
			$sql_cuentas = "FECHA_REGISTRO <= SYSDATE";
			$sql_publicaciones = "FECHA_PUBLICACION <= SYSDATE";
		}
		if ($tiempo == "Año") {
			$sql_cuentas = "EXTRACT(YEAR FROM FECHA_REGISTRO) = EXTRACT(YEAR FROM SYSDATE)";
			$sql_publicaciones = "EXTRACT(YEAR FROM FECHA_PUBLICACION) = EXTRACT(YEAR FROM SYSDATE)";
		}
		if ($tiempo == "Mes") {
			$sql_cuentas = "EXTRACT(YEAR FROM FECHA_REGISTRO) = EXTRACT(YEAR FROM SYSDATE)
							AND EXTRACT(MONTH FROM FECHA_REGISTRO) = EXTRACT(MONTH FROM SYSDATE)";
			$sql_publicaciones = "EXTRACT(YEAR FROM FECHA_PUBLICACION) = EXTRACT(YEAR FROM SYSDATE)
							AND EXTRACT(MONTH FROM FECHA_PUBLICACION) = EXTRACT(MONTH FROM SYSDATE)";
		}
		if ($tiempo == "Día") {
			$sql_cuentas = "FECHA_REGISTRO = SYSDATE";
			$sql_publicaciones = "FECHA_PUBLICACION = SYSDATE";
		}

		$sql = 	"SELECT * FROM
				(SELECT COUNT(*) AS CUENTAS_TOTALES FROM TBL_USUARIOS
				WHERE ".$sql_cuentas."),
				(SELECT COUNT(*) AS CUENTAS_INDIVIDUALES FROM TBL_VENDEDORES
				INNER JOIN TBL_USUARIOS ON CODIGO_USUARIO=CODIGO_USUARIO_VENDEDOR
				WHERE CODIGO_TIPO_VENDEDOR = 1 AND ".$sql_cuentas."),
				(SELECT COUNT(*) AS CUENTAS_EMPRESARIALES FROM TBL_VENDEDORES
				INNER JOIN TBL_USUARIOS ON CODIGO_USUARIO=CODIGO_USUARIO_VENDEDOR
				WHERE CODIGO_TIPO_VENDEDOR = 2 AND ".$sql_cuentas."),
				(SELECT COUNT(*) AS PUBLICACIONES_TOTALES FROM TBL_PUBLICACION_PRODUCTOS
				WHERE ".$sql_publicaciones.")";

		$cuentas_totales = $conexion->ejecutarInstruccion($sql);
		oci_execute($cuentas_totales);

	    while($fila = $conexion->obtenerFila($cuentas_totales)){
	        $resultado = $fila;
	    }

	    echo json_encode($resultado);
	}
	if ($accion == 4) {
		$busqueda = $_POST['busqueda']."%";
		$muestra_denuncias = $conexion->ejecutarInstruccion("	
			SELECT  A.CODIGO_REPORTE,
			        A.CODIGO_TIPO_REPORTE,
			        B.NOMBRE_TIPO_REPORTE,
			        NVL(A.CODIGO_PUBLICACION_PRODUCTO,0) CODIGO_PUBLICACION_PRODUCTO,
			        NVL(C.NOMBRE_PRODUCTO,0) NOMBRE_PRODUCTO,
			        NVL(A.CODIGO_USUARIO_VENDEDOR,0) CODIGO_USUARIO_VENDEDOR,
			        NVL(D.NOMBRE||' '||D.APELLIDO,0) NOMBRE_COMPLETO,
			        E.NOMBRE_MOTIVO_REPORTE,
			        TO_CHAR(A.FECHA_EMITIO,'DD/MM/YYYY') AS FECHA_EMITIO,
			        NVL(A.COMENTARIO_REPORTE,'*El usuario no hizo comentarios*') COMENTARIO_REPORTE
			FROM TBL_REPORTES A
			INNER JOIN TBL_TIPO_REPORTE B
			ON A.CODIGO_TIPO_REPORTE = B.CODIGO_TIPO_REPORTE
			LEFT JOIN TBL_PUBLICACION_PRODUCTOS C
			ON A.CODIGO_PUBLICACION_PRODUCTO = C.CODIGO_PUBLICACION_PRODUCTO
			LEFT JOIN TBL_USUARIOS D 
			ON D.CODIGO_USUARIO = A.CODIGO_USUARIO_VENDEDOR
			INNER JOIN TBL_MOTIVO_REPORTE E
			ON E.CODIGO_MOTIVO_REPORTE = A.CODIGO_MOTIVO_REPORTE
			WHERE UPPER(D.NOMBRE) LIKE UPPER('$busqueda') OR UPPER(C.NOMBRE_PRODUCTO) LIKE UPPER('$busqueda')
			ORDER BY A.CODIGO_REPORTE DESC");

		oci_execute($muestra_denuncias);

		$resultado = array();

	    while($fila = $conexion->obtenerFila($muestra_denuncias)){
	        $resultado[] = $fila;
	    }

	    echo json_encode($resultado);
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

	$conexion->cerrarConexion();
?>
