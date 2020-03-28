<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$codigo_usuario = $_SESSION['codigo_usuario_sesion'];

	$nombre_tienda = $_POST["txt-nombre-tienda"];
	$correo_tienda = $_POST["txt-correo-tienda"];
	$telefono_tienda = $_POST["txt-telefono-tienda"];
	$direccion_tienda = $_POST["txt-direccion-tienda"];
	$servicios = $_POST["slc-servicios"];
	$descripcion = $_POST["txt-descripcion"];
	$verificar = 0;
	$codigo_tienda = "";

	$resultado_codigo_tienda = $conexion->ejecutarInstruccion("	SELECT B.CODIGO_TIENDA 
															FROM TBL_USUARIOS A
															INNER JOIN TBL_VENDEDORES B
															ON(A.CODIGO_USUARIO = B.CODIGO_USUARIO_VENDEDOR)
															WHERE CODIGO_USUARIO = '$codigo_usuario'");
	oci_execute($resultado_codigo_tienda);
	while ($fila = $conexion->obtenerFila($resultado_codigo_tienda)) {
		 	$codigo_tienda = $fila["CODIGO_TIENDA"];
	} 

	//echo $nombre_tienda.$correo_tienda.$telefono_tienda.$direccion_tienda.$servicio1.$servicio2.$servicio3.$servicio4.$descripcion.$codigo_usuario.$codigo_tienda;

	if (filter_var($correo_tienda, FILTER_VALIDATE_EMAIL)) {
		$resultado_tiendas = $conexion->ejecutarInstruccion("	UPDATE TBL_TIENDAS
																SET NOMBRE_TIENDA = '$nombre_tienda',
																	TELEFONO_TIENDA = $telefono_tienda,
																    CORREO_TIENDA = '$correo_tienda',
																    DIRECCION_FISICA_TIENDA = '$direccion_tienda',
																    DESCRIPCION_TIENDA = '$descripcion'
																WHERE CODIGO_TIENDA = '$codigo_tienda'");
		oci_execute($resultado_tiendas);
		$cantidad = $conexion->cantidadRegistros($resultado_tiendas);

		if ($cantidad == " ") {
		}
		else{

			$eliminar_servicio = $conexion->ejecutarInstruccion("	DELETE FROM TBL_VEND_X_TBL_SERV
																	WHERE CODIGO_USUARIO_VENDEDOR = '$codigo_usuario'");
			oci_execute($eliminar_servicio);

			if ($servicios!="") {
				$servicios_ind = explode(",", $servicios);
				for ($i=0; $i < count($servicios_ind) ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	
						INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
						VALUES ('$codigo_usuario','$servicios_ind[$i]')");
					oci_execute($anadir_servicio);
				}
			}

			/*
				tareas para terminar 
					1. verificar los campos que van nulos en la consulta (ya)
					2. si el correo o telefono es nulo no ingresa los servicios (ya)
					3. como anadir fotos de logo y banner (ya)
					4. terminar el de publicar producto
					5. arreglar cuando el update lleva valores nulos como el correo, numero de telefono y no guarda nada (ya)
					6.verificar correos ya repetidos
			*/	

			
			$resultado_tiendas = $conexion->ejecutarInstruccion("COMMIT");
			oci_execute($resultado_tiendas);
			
			echo $verificar = 1;
		}	
	}
	else{
		echo $verificar;
	}

	$conexion->cerrarConexion();
?>

