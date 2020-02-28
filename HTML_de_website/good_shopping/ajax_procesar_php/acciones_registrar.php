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
		    }
		}
		else{
			$mensaje = 3;
		}

		if($mensaje==0){
			$ingresar_usuario = $conexion->ejecutarInstruccion("Insert into TBL_USUARIOS (CODIGO_USUARIO, CODIGO_TIPO_USUARIO, CODIGO_LUGAR, CODIGO_GENERO, NOMBRE, APELLIDO, CORREO_ELECTRONICO, CONTRASENA, TELEFONO, FECHA_NACIMIENTO)
																	values (USUARIOS_SEQ.NEXTVAL,2,$ubicacion,3,'$nombre','$apellido','$correo','$contrasena',$telefono,TO_DATE('$dia-$mes-$anio', 'DD-MM-YYYY'))");
			/*$ingresar_usuario = $conexion->ejecutarInstruccion("DECLARE
																    V_CODIGO_USUARIO INTEGER;
																BEGIN
																    P_AGREGAR_NUEVO_USUARIO (2, $ubicacion, 3, '$nombre', '$apellido', '$correo', '$contrasena', $telefono, TO_DATE('$dia-$mes-$anio', 'DD-MM-YYYY'), V_CODIGO_USUARIO);
																END;");*/
			oci_execute($ingresar_usuario);
			$mensaje = 2;
		}
		echo $mensaje;

	$conexion->cerrarConexion();
?>

