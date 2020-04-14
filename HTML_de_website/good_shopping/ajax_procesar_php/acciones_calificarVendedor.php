<?php
	include_once("../class/conexion_copy.php");

	session_start();

	$conexion = new Conexion();
	$conexion->establecerConexion();
	
	$accion = $_POST["accion"];
	$codigo_usuario_comprador = $_SESSION['codigo_usuario_sesion'];
	$codigoVendedor = $_POST["codigoVendedor"];
	
	if($accion == 'calificar'){
			$rating = $_POST["rb_rating"];
			if($rating >= 1 && $rating <= 5){
				$realizar_valoracion = $conexion->ejecutarInstruccion("
					BEGIN 
						SP_CalificarVendedor(".$codigoVendedor.", ".$codigo_usuario_comprador.", ".$rating."); 
					END;
				");
				
				oci_execute($realizar_valoracion);
				if($rating == 1){
					echo 'Vendedor calificado con '.$rating.' estrella';
				}else{
					echo 'Vendedor calificado con '.$rating.' estrellas';
				}
			}else{
				echo'Tiene que seleccionar almenos una estrella';
			}
	}else if($accion == 'favoritos'){
		$sql = "SELECT COUNT(*) CANTIDAD FROM TBL_FAVORITOS
				WHERE CODIGO_USUARIO_COMPRADOR = ".$codigo_usuario_comprador." AND CODIGO_USUARIO_VENDEDOR = ".$codigoVendedor."";
		$datos_favoritos = $conexion->ejecutarInstruccion($sql);
		oci_execute($datos_favoritos);
		
		while ($fila = $conexion->obtenerFila($datos_favoritos)){
			$yaAgregado = $fila["CANTIDAD"];
			if($yaAgregado > 0){
				echo 'Ya tiene agregado este vendedor';
			}else{
				$insertar_favorito = $conexion->ejecutarInstruccion("
					INSERT INTO TBL_FAVORITOS(CODIGO_USUARIO_COMPRADOR, CODIGO_USUARIO_VENDEDOR, FECHA_AGREGO)
					VALUES('$codigo_usuario_comprador', '$codigoVendedor', SYSDATE)
				");
				oci_execute($insertar_favorito);
				echo'Vendedor agregado a favoritos exitosamente';
			}
		}
	}
	$conexion->cerrarConexion();
?>