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

	if (filter_var($correo_tienda, FILTER_VALIDATE_EMAIL)) {
		$correos_bd = array();
		$cont = 0;
		$resultado_recibidos = $conexion->ejecutarInstruccion("	SELECT CORREO_TIENDA
																FROM TBL_TIENDAS
																WHERE CODIGO_TIENDA != '$codigo_tienda'");
		oci_execute($resultado_recibidos);
		while ($fila = $conexion->obtenerFila($resultado_recibidos)) {
		    $correos_bd[$cont] = $fila["CORREO_TIENDA"];
		    $cont++;
		}

		$correo_existe = 0;
		for ($i=0; $i < count($correos_bd); $i++) { 
		    if ($correo_tienda == $correos_bd[$i]) {
		    	$correo_existe = 1;
		    }
		}

		if ($correo_existe == 1) {
			echo $verificar = 2;
		} else {
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
				
				$resultado_tiendas = $conexion->ejecutarInstruccion("COMMIT");
				oci_execute($resultado_tiendas);
				
				echo $verificar = 1;
			}
		}	
	}
	else{
		echo $verificar;
	}

	$conexion->cerrarConexion();
?>

