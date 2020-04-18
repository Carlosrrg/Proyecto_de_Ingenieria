<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();

	$mensaje_enviar = $_POST["txt-mensaje"];
	$codigo_usuario_vendedor = $_POST["txt-idVendedor"];
	$codigo_publicacion = $_POST["txt-codigo-p"];
	
	$codigo_usuario_comprador = $_SESSION['codigo_usuario_sesion'];
	//$codigo_usuario_comprador = 8;

	$nombre_publicacion = " ";
	$nombre_usuario_comprador = " ";
	$nombre_usuario_vendedor = " ";
	$mensaje = " ";
	$correo_usuario_comprador = " ";
	$correo_usuario_vendedor = " ";
	$telefono_usuario_comprador = " ";
	$telefono_usuario_vendedor = " ";

	$mensaje = " ";

	/*
		Buenas Usuario_vendedor te saludamos de Good Shopping para recordarte que tienes una notificacion pendiente
		
		De: Usuario_comprador
		Por la publicacion: nombre_publicacion
		Recibido: fecha_recibida
		Mensaje: contenido
		
		Gracias por usar el servicio de Good Shopping, te esperamos pronto.
		para mayor informacion contactate con nosotros atraves de nuestras redes sociales o atraves de correo electronico a: goodshopping_suport@gmail.com 
	*/

	//echo $mensaje_enviar." ".$codigo_usuario_vendedor." ".$codigo_publicacion."  ".$codigo_usuario_comprador;


	$resultado_publicacion = $conexion->ejecutarInstruccion("	SELECT NOMBRE_PRODUCTO
																FROM TBL_PUBLICACION_PRODUCTOS
																WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
	oci_execute($resultado_publicacion);
	while ($fila = $conexion->obtenerFila($resultado_publicacion)) {
		$nombre_publicacion = $fila["NOMBRE_PRODUCTO"];
	} 

	
	$resultado_usuario_comprador = $conexion->ejecutarInstruccion("	SELECT NOMBRE, APELLIDO, CORREO_ELECTRONICO, TELEFONO
																	FROM TBL_USUARIOS
																	WHERE CODIGO_USUARIO = '$codigo_usuario_comprador'");
	oci_execute($resultado_usuario_comprador);
	while ($fila2 = $conexion->obtenerFila($resultado_usuario_comprador)) {
		$nombre_usuario_comprador = $fila2["NOMBRE"].' '.$fila2["APELLIDO"];
		$correo_usuario_comprador = $fila2["CORREO_ELECTRONICO"];
		$telefono_usuario_comprador = "+504 ".$fila2["TELEFONO"];
	}

	
	$resultado_usuario_vendedor = $conexion->ejecutarInstruccion("	SELECT NOMBRE, APELLIDO, CORREO_ELECTRONICO, TELEFONO
																	FROM TBL_USUARIOS
																	WHERE CODIGO_USUARIO = '$codigo_usuario_vendedor'");
	oci_execute($resultado_usuario_vendedor);
	while ($fila3 = $conexion->obtenerFila($resultado_usuario_vendedor)) {
		$nombre_usuario_vendedor = $fila3["NOMBRE"].' '.$fila3["APELLIDO"];
		$correo_usuario_vendedor = $fila3["CORREO_ELECTRONICO"];
		$telefono_usuario_vendedor = "+504 ".$fila3["TELEFONO"];
	}  



	if (!empty($_POST)) {
				//Envio de copia de mensaje a vendedor
				$email_subject = "Saludos de Good Shopping!";
				$email_message = "Buenas ".$nombre_usuario_vendedor." te saludamos de Good Shopping para recordarte que tienes una notificacion pendiente\n\n";
				$email_message .= " - De: " . $nombre_usuario_comprador . "\n";
				$email_message .= " - Correo de contacto: " . $correo_usuario_comprador . "\n";
				$email_message .= " - Telefono de contacto: " . $telefono_usuario_comprador . "\n";
				$email_message .= " - Por la publicacion: " . $nombre_publicacion . "\n";
				$email_message .= " - Contenido del mensaje: " . $mensaje_enviar . "\n\n";
				$email_message .= "Gracias por usar el servicio de Good Shopping, te esperamos pronto.";
				$email_message .= " Para mayor informacion contactate con nosotros atraves de nuestras redes sociales o atraves de correo electronico a: goodshopping_suport@gmail.com";
				

				$header = "From: " . $correo_usuario_vendedor . "  \r\n";
				$header .= "X-Mailer: PHP/" . phpversion() . "  \r\n";
				$header .= "Mime-Version: 1.0 \r\n";
				$header .= "Content-Type:  text/plain";

				if (mail($correo_usuario_vendedor,$email_subject,$email_message,$header)) {
					//$mensaje .= "Se envío correo de registro a " . $correo . "\n";
					echo $mensaje = 0;
				}else{
					//$mensaje .= "Error al enviar correo\n";
					echo $mensaje = 1;
				}

				$ingresar_mensaje = $conexion->ejecutarInstruccion("	DECLARE
																		    V_CODIGO_MENSAJE INTEGER;
																		BEGIN
																		    P_AGREGAR_MENSAJES ($codigo_usuario_comprador,$codigo_usuario_vendedor,'$mensaje_enviar',SYSDATE,V_CODIGO_MENSAJE);
																		    DBMS_OUTPUT.PUT_LINE('CODIGO_MENSAJE: '||V_CODIGO_MENSAJE);
																		END;");
				oci_execute($ingresar_mensaje);

				//Envio de copia de mensaje a comprador
				$email_subject = "Saludos de Good Shopping!";
				$email_message = "Buenas ".$nombre_usuario_comprador." aqui tienes una copia del mensaje enviado a " .$nombre_usuario_vendedor. ".\n\n";
				$email_message .= " - Nombre del vendedor: " . $nombre_usuario_vendedor . "\n";
				$email_message .= " - Correo de contacto: " . $correo_usuario_vendedor . "\n";
				$email_message .= " - Telefono de contacto: " . $telefono_usuario_vendedor . "\n";
				$email_message .= " - Publicacion desde donde se envia el mensaje: " . $nombre_publicacion . "\n";
				$email_message .= " - Contenido del mensaje que enviastes: " . $mensaje_enviar . "\n\n";
				$email_message .= "Gracias por usar el servicio de Good Shopping, te esperamos pronto.";
				$email_message .= " Para mayor informacion contactate con nosotros atraves de nuestras redes sociales o atraves de correo electronico a: goodshopping_suport@gmail.com";
				

				$header = "From: " . $correo_usuario_comprador . "  \r\n";
				$header .= "X-Mailer: PHP/" . phpversion() . "  \r\n";
				$header .= "Mime-Version: 1.0 \r\n";
				$header .= "Content-Type:  text/plain";


				if (mail($correo_usuario_comprador,$email_subject,$email_message,$header)) {
					//$mensaje .= "Se envío correo de registro a " . $correo . "\n";
					echo $mensaje = 0;
				}else{
					//$mensaje .= "Error al enviar correo\n";
					echo $mensaje = 1;
				}
	}

	$conexion->cerrarConexion();
?>