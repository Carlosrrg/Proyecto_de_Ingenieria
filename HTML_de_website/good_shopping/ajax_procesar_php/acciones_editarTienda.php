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
	
	//echo $nombre_tienda.$correo_tienda.$telefono_tienda.$direccion_tienda.$servicio1.$servicio2.$servicio3.$servicio4.$descripcion.$codigo_usuario;
	
	/*if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		$resultado_usuarios = $conexion->ejecutarInstruccion("		UPDATE TBL_USUARIOS
																	SET CORREO_ELECTRONICO = '$correo',
																		CODIGO_GENERO = '$genero',
																	    FECHA_NACIMIENTO = TO_DATE('$fecha_dia/$fecha_mes/$fecha_anio', 'DD/MM/YYYY'),
																	    NUMERO_TELEFONO = $numero_telefono,
																	    CODIGO_MARCA_TELEFONO_M = $telefono_movil,
																	    CODIGO_PROVEEDOR_SERVICIO = $proveedor
																	WHERE CODIGO_USUARIO = '$codigo_usuario'");
		oci_execute($resultado_usuarios);
		$cantidad = $conexion->cantidadRegistros($resultado_usuarios);
		if ($cantidad == " ") {
		}
		else{
			$resultado_usuarios = $conexion->ejecutarInstruccion("COMMIT");
			oci_execute($resultado_usuarios);
		}
	}
	else{
		
	}*/


	$conexion->cerrarConexion();
?>

