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
	$servicio1 = $_POST["txt-servicio1"];
	$servicio2 = $_POST["txt-servicio2"];
	$servicio3 = $_POST["txt-servicio3"];
	$servicio4 = $_POST["txt-servicio4"];
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


			/*
				1234
				1230
				1200
				1000
				0000
				0234
				0034
				0004
				0230
				1004
				1034    
				1204
			*/
			/*
				tareas para terminar 
					1. verificar los campos que van nulos en la consulta (ya)
					2. si el correo o telefono es nulo no ingresa los servicios (ya)
					3. como anadir fotos de logo y banner
					4. terminar el de publicar producto
					5. arreglar cuando el update lleva valores nulos como el correo, numero de telefono y no guarda nada (ya)
					6.verificar correos ya repetidos
			*/	




			if ($servicio1 == 1 && $servicio2 == 2 && $servicio3 == 3 && $servicio4 == 4) {
				for ($i=1; $i < 5 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 1 && $servicio2 == 2 && $servicio3 == 3 && $servicio4 == 0) {
				for ($i=1; $i < 4 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 1 && $servicio2 == 2 && $servicio3 == 0 && $servicio4 == 0) {
				for ($i=1; $i < 3 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 1 && $servicio2 == 0 && $servicio3 == 0 && $servicio4 == 0) {
				for ($i=1; $i < 2 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 0 && $servicio2 == 0 && $servicio3 == 0 && $servicio4 == 0) {
				
			}
			else if ($servicio1 == 0 && $servicio2 == 2 && $servicio3 == 3 && $servicio4 == 4) {
				for ($i=2; $i < 5 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 0 && $servicio2 == 0 && $servicio3 == 3 && $servicio4 == 4) {
				for ($i=3; $i < 5 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 0 && $servicio2 == 0 && $servicio3 == 0 && $servicio4 == 4) {
				for ($i=4; $i < 5 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 0 && $servicio2 == 2 && $servicio3 == 3 && $servicio4 == 0) {
				for ($i=2; $i < 4 ; $i++) { 
					$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','$i')");
					oci_execute($anadir_servicio);
				}
			}
			else if ($servicio1 == 1 && $servicio2 == 0 && $servicio3 == 0 && $servicio4 == 4) {
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','1')");
				oci_execute($anadir_servicio);
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','4')");
				oci_execute($anadir_servicio);
			}
			else if ($servicio1 == 1 && $servicio2 == 0 && $servicio3 == 3 && $servicio4 == 4) {
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','1')");
				oci_execute($anadir_servicio);
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','3')");
				oci_execute($anadir_servicio);
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','4')");
				oci_execute($anadir_servicio);
			}
			else if ($servicio1 == 1 && $servicio2 == 2 && $servicio3 == 0 && $servicio4 == 4) {
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','1')");
				oci_execute($anadir_servicio);
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','2')");
				oci_execute($anadir_servicio);
				$anadir_servicio = $conexion->ejecutarInstruccion("	INSERT INTO TBL_VEND_X_TBL_SERV (CODIGO_USUARIO_VENDEDOR, CODIGO_SERVICIO)
																					VALUES ('$codigo_usuario','4')");
				oci_execute($anadir_servicio);
			}

			
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

