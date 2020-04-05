<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];

	$nombre_archivo = $_FILES['foto']['name'];
	$archivo = $_FILES['foto']["tmp_name"];
	$ruta_archivo = "img/Productos/".$_FILES['foto']['name'];
	$codigo_publicacion = $_POST['codigo'];

	if (move_uploaded_file($archivo, "../".$ruta_archivo)) {

		$anadir_imagen = $conexion->ejecutarInstruccion("	
			DECLARE
			    V_CODIGO_IMAGEN INTEGER;
			BEGIN
			    P_AGREGAR_IMAGEN (3,'$ruta_archivo',200,400,V_CODIGO_IMAGEN);
			END;");
		oci_execute($anadir_imagen);

		$imagen_a_producto = $conexion->ejecutarInstruccion("	
			INSERT INTO TBL_PROD_X_TBL_IMG (CODIGO_PRODUCTO,CODIGO_IMAGEN)
			SELECT '$codigo_publicacion',CODIGO_IMAGEN FROM TBL_IMAGENES 
			WHERE ROWNUM=1 ORDER BY CODIGO_IMAGEN DESC");
		oci_execute($imagen_a_producto);

		echo "Imagen guardada";

	} else {
		echo 0;
	}

	$conexion->cerrarConexion();
?>