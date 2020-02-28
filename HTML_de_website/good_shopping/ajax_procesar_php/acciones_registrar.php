<?php
	include_once("../class/conexion_copy.php");

	$conexion = new Conexion();
	$conexion->establecerConexion();
	
	$nombre = $_POST["txt-nombre"];
	$apellido = $_POST["txt-apellido"];
	$correo = $_POST["txt-correo"];
	$contrasena = $_POST["txt-contrasena"];
	$confirmar_contrasena = $_POST["txt-confirmar-contrasena"];
	$telefono = $_POST["txt-telefono"];
	$ubicacion = $_POST["slc-ubicacion"];
	$dia = $_POST["txt-dia"];
	$mes = $_POST["slc-mes"];
	$anio = $_POST["txt-anio"];
	
	$mensaje = " ";
	$ingresar_contrasena = "";



	
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
		    	else{
		    		$mensaje = 2;
		    	}
		    }
		    echo $mensaje;
		}
		else{
			echo $mensaje = 3;
		}

		if ($contrasena == $confirmar_contrasena) {
			$ingresar_contrasena = $contrasena;
			//echo "Las contrasenas coinciden";
		}
		else{
			$mensaje = 4;
		}

		//echo $mensaje;

	/*
	$mail = $_POST["txt-email"];	
	$mail2 = $_POST["txt-confirmar-email"];
	$contrasena = $_POST["txt-contrasena"];
	$nombre_completo = $_POST["txt-nombre"];
	$dia = $_POST["txt-dia"];
	$mes = $_POST["slc-mes"];
	$anio = $_POST["txt-anio"];
	$genero = $_POST["rtb-genero"];
	$verificar_correo = 0;
	$existe = 0;
	$datos_requeridos = 0;
	
	
	if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
		$correos_bd = array();
		$cont = 0;
		$resultado_recibidos = $conexion->ejecutarInstruccion("SELECT CORREO_ELECTRONICO
																FROM TBL_USUARIOS");
	    oci_execute($resultado_recibidos);
	    while ($fila = $conexion->obtenerFila($resultado_recibidos)) {
	    	$correos_bd[$cont] = $fila["CORREO_ELECTRONICO"];
	    	$cont++;
	    }
	    if ($mail == $mail2) {
	    	for ($i=0; $i < count($correos_bd); $i++) { 
	    		if ($mail == $correos_bd[$i]) {
	    			$verificar_correo = 1;
	    		}
	    	}
	    }
	    else{
	    	//echo "Los correos electronicos ingresados no coinciden, intentelo de nuevo.";
	    	echo $datos_requeridos = 2;
	    }
	}
	else{
		//echo "Ingrese los datos requeridos para registrarse..."; 
		echo 3;
	}
	//echo "<br>" . $verificar_correo;

	if ($verificar_correo == 1) {
		echo $existe = 1;
	}
	else{
		$resultado_canjear = $conexion->ejecutarInstruccion("	DECLARE
    																V_CODIGO_USUARIO INTEGER;
																BEGIN
    															P_AGREGAR_NUEVO_USUARIO ($genero, 7, 3, 1, 1, 1, '$nombre_completo', TO_DATE('$dia-$mes-$anio', 'DD-MM-YYYY'), '$nombre_completo', '$mail', '$contrasena', 11111111, V_CODIGO_USUARIO);
    															DBMS_OUTPUT.PUT_LINE('CODIGO_USUARIO_AGREGADO: '||V_CODIGO_USUARIO);
																END;");
		oci_execute($resultado_canjear);
		//header("Location: ../canjear.php?id=correcto");
		echo 4;
	}

	//echo "<br>";
	
	*/
	$conexion->cerrarConexion();
?>

