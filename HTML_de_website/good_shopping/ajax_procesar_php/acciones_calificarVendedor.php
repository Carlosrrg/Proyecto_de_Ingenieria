<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();
	
	$accion = $_POST["accion"];
	$codigo_usuario_comprador = $_SESSION['codigo_usuario_sesion'];
	$codigoVendedor = $_POST["codigoVendedor"];
	
	if($accion == 'calificar'){
			//numero de estrellas seleccionadas por el comprador
			$rating = $_POST["rb_rating"];
			if($rating >= 1 && $rating <= 5){
				$realizar_valoracion = $conexion->ejecutarInstruccion("
					BEGIN 
						SP_CalificarVendedor(".$codigoVendedor.", ".$codigo_usuario_comprador.", ".$rating."); 
					END;
				");
				oci_execute($realizar_valoracion);
				//distincion para singular y plural del numero de estrellas
				if($rating == 1){
					echo 'Vendedor calificado con '.$rating.' estrella';
				}else{
					echo 'Vendedor calificado con '.$rating.' estrellas';
				}
			}else{
				echo'Tiene que seleccionar almenos una estrella';
			}
	}else if($accion == 'favoritos'){
		//consulta que trae si ya se ha agregado a favoritos anteriormente el vendedor
		$sql = "SELECT COUNT(*) CANTIDAD FROM TBL_FAVORITOS
				WHERE CODIGO_USUARIO_COMPRADOR = ".$codigo_usuario_comprador." AND CODIGO_USUARIO_VENDEDOR = ".$codigoVendedor."";
		$datos_favoritos = $conexion->ejecutarInstruccion($sql);
		oci_execute($datos_favoritos);
		
		while ($fila = $conexion->obtenerFila($datos_favoritos)){
			$yaAgregado = $fila["CANTIDAD"];
			if($yaAgregado > 0){
				$quitar_favorito = $conexion->ejecutarInstruccion(
					"DELETE FROM TBL_FAVORITOS
					 WHERE CODIGO_USUARIO_COMPRADOR = $codigo_usuario_comprador AND
					 	   CODIGO_USUARIO_VENDEDOR = $codigoVendedor
				");
				oci_execute($quitar_favorito);
				echo'Vendedor quitado de favoritos';
			}else{
				$insertar_favorito = $conexion->ejecutarInstruccion("
					INSERT INTO TBL_FAVORITOS(CODIGO_USUARIO_COMPRADOR, CODIGO_USUARIO_VENDEDOR, FECHA_AGREGO)
					VALUES('$codigo_usuario_comprador', '$codigoVendedor', SYSDATE)
				");
				oci_execute($insertar_favorito);
				echo'Vendedor agregado a favoritos exitosamente';
			}
		}
	}else if($accion == 'comentar'){
		if (empty($_POST["txt_comentario"])){
			echo'vacio';
		}else{
			$comentario = $_POST["txt_comentario"];			
			$insertar_comentario = $conexion->ejecutarInstruccion(
				"UPDATE TBL_RANKING SET COMENTARIOS = '".$comentario."'
				 WHERE CODIGO_USUARIO_COMPRADOR = $codigo_usuario_comprador AND 
				 CODIGO_USUARIO_VENDEDOR = $codigoVendedor
				"
			);
			oci_execute($insertar_comentario);
			echo'Comentario enviado exitosamente';
		}
	}
	$conexion->cerrarConexion();
?>