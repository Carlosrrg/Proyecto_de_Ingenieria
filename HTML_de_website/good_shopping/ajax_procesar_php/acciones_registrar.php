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
	$vendedor = $_POST["rb-vendedor"];


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

			if ($vendedor==2) {
				$nombre_tienda = $_POST["txt-nombre-tienda"];
				$rtn = $_POST["txt-rtn"];

				$ingresar_tienda = $conexion->ejecutarInstruccion(
						"DECLARE
							V_CODIGO_TIENDA INTEGER;
						BEGIN
							P_AGREGAR_NUEVA_TIENDA ('$nombre_tienda', '$rtn', V_CODIGO_TIENDA);
						END;");
				oci_execute($ingresar_tienda);

				$ingresar_vendedor = $conexion->ejecutarInstruccion(
						"INSERT INTO TBL_VENDEDORES (CODIGO_USUARIO_VENDEDOR, CODIGO_TIPO_VENDEDOR, CODIGO_TIENDA)
						SELECT * FROM 
						(SELECT CODIGO_USUARIO,$vendedor FROM TBL_USUARIOS WHERE ROWNUM=1 ORDER BY CODIGO_USUARIO DESC),
						(SELECT CODIGO_TIENDA FROM TBL_TIENDAS WHERE ROWNUM=1 ORDER BY CODIGO_TIENDA DESC)");
				oci_execute($ingresar_vendedor);

			}else{
				$ingresar_vendedor = $conexion->ejecutarInstruccion(
						"INSERT INTO TBL_VENDEDORES (CODIGO_USUARIO_VENDEDOR, CODIGO_TIPO_VENDEDOR, CODIGO_TIENDA)
						SELECT CODIGO_USUARIO,$vendedor,NULL FROM TBL_USUARIOS WHERE ROWNUM=1 ORDER BY CODIGO_USUARIO DESC");
				oci_execute($ingresar_vendedor);

				$ingresar_comprador = $conexion->ejecutarInstruccion(
							"INSERT INTO TBL_COMPRADORES (CODIGO_USUARIO_COMPRADOR)
							SELECT CODIGO_USUARIO FROM TBL_USUARIOS WHERE ROWNUM=1 ORDER BY CODIGO_USUARIO DESC"
				);
				oci_execute($ingresar_comprador);
			}

			$mensaje = "Datos ingresados con éxito!\n";

			//FUNCION PARA ENVIAR CORREO DE CONFIRMACION DE REGISTRO
			if (!empty($_POST)) {
				$email_subject = "Registro éxitoso a Good Shopping!";
				$email_message = "Detalles del registro:\n\n";
				$email_message .= " - Nombre: " . $nombre . "\n";
				$email_message .= " - Apellido: " . $apellido . "\n";
				$email_message .= " - Correo: " . $correo . "\n";
				$email_message .= " - Teléfono: " . $telefono . "\n";
				$email_message .= " - Fecha de nacimiento: " . $dia . "/" . $mes . "/" . $anio . "\n\n";
				if ($vendedor == 2) {
					$email_message .= "Se registro como: Vendedor Empresarial\n";
					$email_message .= " - Nombre de la tienda: " . $nombre_tienda . "\n";
					$email_message .= " - RTN: " . $rtn . "\n\n";
				}else{
					$email_message .= "Se registro como: Vendedor Individual\n\n";
				}
				$email_message .= "¡Se ha registrado con éxito a Good Shopping!";

				$header = "From: " . $correo . "  \r\n";
				$header .= "X-Mailer: PHP/" . phpversion() . "  \r\n";
				$header .= "Mime-Version: 1.0 \r\n";
				$header .= "Content-Type:  text/plain";

				if (mail($correo,$email_subject,$email_message,$header)) {
					$mensaje .= "Se envío correo de registro a " . $correo . "\n";
				}else{
					$mensaje .= "Error al enviar correo\n";
				}
			}
			//FIN DE FUNCION PARA ENVIAR CORREO

		}
		echo $mensaje;

	$conexion->cerrarConexion();
?>

