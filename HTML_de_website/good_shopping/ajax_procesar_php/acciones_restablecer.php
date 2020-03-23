<?php
	include_once("../class/conexion_copy.php");

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$boton = $_POST["boton"];
	$correo = $_POST["txt-correo"];

	$codigo_usuario = "";
	$mensaje = "";

	if (filter_var($correo, FILTER_VALIDATE_EMAIL)) {
		$resultado_usuarios = $conexion->ejecutarInstruccion("	SELECT CODIGO_USUARIO, NOMBRE, CODIGO_CODIGO
																FROM TBL_USUARIOS
																WHERE CORREO_ELECTRONICO = '$correo'");
		oci_execute($resultado_usuarios);
		while ($fila = $conexion->obtenerFila($resultado_usuarios)) {
		 	$codigo_usuario = $fila["CODIGO_USUARIO"];
		 	$codigo_codigo = $fila["CODIGO_CODIGO"];
		 	$nombre = $fila["NOMBRE"];
		}
	}

	//valida session
	if ($codigo_usuario=="") {
		echo $mensaje = 0;//correo no existe
	}else{
		$obtener_codigo = $conexion->ejecutarInstruccion("	SELECT CODIGO
															FROM TBL_CODIGOS
															WHERE CODIGO_CODIGO = $codigo_codigo");
		oci_execute($obtener_codigo);
		while ($fila = $conexion->obtenerFila($obtener_codigo)) {
		 	$codigo_obtenido = $fila["CODIGO"];
		}

		if ($boton==1) {
			//FUNCION PARA ENVIAR CORREO DE CAMBIO DE CONTRASEÑA
			if (!empty($_POST)) {
				$email_subject = "Clave para restablecer contraseña Good Shopping";
				$email_message = "Hola, " . $nombre . ":\n\n";
				$email_message .= "El código para restablecer tú contraseña es: " . $codigo_obtenido . "\n";
				$email_message .= "Introduce el código en Good Shopping para que puedas cambiar tú contraseña.\n\n";
				$email_message .= "Si no has sido tú cambia tu contraseña de Good Shopping y considera también cambiar la\n"; 
				$email_message .= "contraseña de tu dirección de correo electrónico para proteger tu cuenta.\n\n";
				$email_message .= "Gracias, Good Shopping.";
				$header = "From: " . $correo . "  \r\n";
				$header .= "X-Mailer: PHP/" . phpversion() . "  \r\n";
				$header .= "Mime-Version: 1.0 \r\n";
				$header .= "Content-Type:  text/plain";

				if (mail($correo,$email_subject,$email_message,$header)) {
					echo $mensaje = "Se envío correo a " . $correo . "\n";
				}else{
					echo $mensaje = "Error al enviar correo\n";
				}
			}
			//FIN DE FUNCION PARA ENVIAR CORREO
		}else{
			$codigo_ingresado = $_POST["txt-codigo"];
			$contrasena = $_POST["txt-contrasena"];

			if ($codigo_ingresado == $codigo_obtenido) {
				$actualizar_contrasena = $conexion->ejecutarInstruccion("UPDATE TBL_USUARIOS
																		SET CONTRASENA = '$contrasena'
																		WHERE CODIGO_USUARIO = $codigo_usuario");
				oci_execute($actualizar_contrasena);
				echo $mensaje = 2;//cambio de contraseña exitoso
			}else{
				echo $mensaje = 1;//codigo invalido
			}

		}

	}

	$conexion->cerrarConexion();
?>