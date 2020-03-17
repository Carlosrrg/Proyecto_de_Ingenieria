<?php
	include_once("../class/conexion_copy.php");

	$conexion = new Conexion();
	$conexion->establecerConexion();

	
	$nombre = $_POST["txt-nombre"];
	$apellido = $_POST["txt-apellido"];
	$correo = $_POST["txt-correo"];
	$contrasena = $_POST["txt-contrasena-enviar"];
	$telefono = $_POST["txt-telefono"];
	$ubicacion = $_POST["slc-ubicacion"];
	$dia = $_POST["txt-dia"];
	$mes = $_POST["slc-mes"];
	$anio = $_POST["txt-anio"];

	//$valores = $nombre.$apellido.$correo.$contrasena.$telefono.$ubicacion.$dia.$mes.$anio;
	//echo $valores;
	
	$mensaje = 0;


		if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
			$correos_bd = array();
			$cont = 0;
			$resultado_recibidos = $conexion->ejecutarInstruccion("SELECT CORREO_ELECTRONICO
																	FROM TBL_USUARIOS");
		    oci_execute($resultado_recibidos);
		    while ($fila = $conexion->obtenerFila($resultado_recibidos)) {
		    	$correos_bd[$cont] = $fila["CORREO_ELECTRONICO"];
		    	$cont++;
		    }
		    for ($i=0; $i < count($correos_bd); $i++) { 
		    	if ($correo == $correos_bd[$i]) {
		    		$mensaje = 1;
		    		break;
		    	}
		    	/*else{
		    		$mensaje = 2;
		    	}*/
		    }
		}
		else{
			$mensaje = 3;
		}

		if($mensaje==0){
			$codigo_recuperacion = rand(1,3);
			//echo "codigo_recuperacion: ".$codigo_recuperacion;
			$ingresar_usuario = $conexion->ejecutarInstruccion("DECLARE
																    V_CODIGO_USUARIO INTEGER;
																BEGIN
																P_AGREGAR_NUEVO_USUARIO (2, $ubicacion, 3, $codigo_recuperacion, '$nombre', '$apellido', '$correo', '$contrasena', $telefono, TO_DATE('$dia-$mes-$anio', 'DD-MM-YYYY'), SYSDATE, NULL, V_CODIGO_USUARIO);
																END;");
			oci_execute($ingresar_usuario);
			$mensaje = 2;
		}
		echo $mensaje;

	$conexion->cerrarConexion();
?>

