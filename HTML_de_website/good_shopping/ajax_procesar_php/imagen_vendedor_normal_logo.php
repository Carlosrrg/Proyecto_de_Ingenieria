<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];

	$nombre_archivo = $_FILES['logo']['name'];
	$archivo = $_FILES['logo']["tmp_name"];
	$ruta_archivo = "img/FotosDePerfilVendedor/".$_FILES['logo']['name'];

	if (move_uploaded_file($archivo, "../".$ruta_archivo)) {
		$codigo_imagen = 0;

		$obtiene_imagen_anterior = $conexion->ejecutarInstruccion("	
			SELECT A.CODIGO_IMAGEN,B.RUTA_IMAGEN FROM TBL_VEND_X_TBL_IMG A
			INNER JOIN TBL_IMAGENES B
			ON A.CODIGO_IMAGEN = B.CODIGO_IMAGEN
			WHERE A.CODIGO_USUARIO_VENDEDOR = '$codigo_usuario' 
			AND B.CODIGO_TIPO_IMAGEN = 1");
		oci_execute($obtiene_imagen_anterior);

		while ($fila = $conexion->obtenerFila($obtiene_imagen_anterior)) {
			 $codigo_imagen = $fila["CODIGO_IMAGEN"];
			 $ruta_imagen = $fila["RUTA_IMAGEN"];
		} 

		if ($codigo_imagen != 0) {
			//unlink("../".$ruta_imagen);
			$elimina_imagen_anterior = $conexion->ejecutarInstruccion("	DELETE FROM TBL_VEND_X_TBL_IMG
																	WHERE CODIGO_IMAGEN = '$codigo_imagen'");
			oci_execute($elimina_imagen_anterior);
			$elimina_imagen = $conexion->ejecutarInstruccion("	DELETE FROM TBL_IMAGENES
																	WHERE CODIGO_IMAGEN = '$codigo_imagen'");
			oci_execute($elimina_imagen);
		}

		$anadir_imagen = $conexion->ejecutarInstruccion("	
			DECLARE
			    V_CODIGO_IMAGEN INTEGER;
			BEGIN
			    P_AGREGAR_IMAGEN (1,'$ruta_archivo',200,200,V_CODIGO_IMAGEN);
			END;");
		oci_execute($anadir_imagen);

		$anadir_imagen_vendedor = $conexion->ejecutarInstruccion("	
			INSERT INTO TBL_VEND_X_TBL_IMG (CODIGO_IMAGEN, CODIGO_USUARIO_VENDEDOR)
			SELECT CODIGO_IMAGEN,'$codigo_usuario' FROM TBL_IMAGENES WHERE ROWNUM=1 ORDER BY CODIGO_IMAGEN DESC");
		oci_execute($anadir_imagen_vendedor);

		echo "Imagen guardada";

	} else {
		echo 0;
	}

	$conexion->cerrarConexion();
?>