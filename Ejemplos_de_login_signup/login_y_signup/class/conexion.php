<DOCTYPE HTML>
<meta charset = "utf8" />
<?php  
	// crear conexion con oracle
	$nombre_base = "DB_SPOTIFY";
	$contrasena = "oracle";
	$host = "localhost/xe";

	//guarda en variable de conexion
	$conexion = oci_connect($nombre_base, $contrasena, $host); 
	
	//verifica si la conexion es establecida 
	if (!$conexion) {    
	  $m = oci_error();    
	  echo $m['message'], "n";    
	  exit; 
	} else {    
	  echo "Conexión con éxito a Oracle!". '<br>'; 
	  echo "Conexion hecha a la base de datos de SPOTIFY";
	} 

	$sentencia_dml = oci_parse($conexion, "Insert into TBL_USUARIOS (CODIGO_USUARIO,
				 							CODIGO_GENERO, 
				 							CODIGO_LUGAR_VIVE, 
				 							CODIGO_MARCA_TELEFONO_M, 
				 							CODIGO_PROVEEDOR_SERVICIO, 
				 							CODIGO_TIPO_USUARIO, 
				 							CODIGO_PLANES_CUENTA, 
				 							NOMBRE_COMPLETO, 
				 							FECHA_NACIMIENTO, 
				 							USUARIO_PLATAFORMA, 
				 							CORREO_ELECTRONICO, 
				 							CONTRASENA, 
				 							NUMERO_TELEFONO)

											values (10, 
													1, 
													9, 
													4, 
													2, 
													2, 
													1, 
													'Pedro masilla', 
													TO_DATE('12-12-85', 'DD-MM-YY'), 
													'leo98745', 
													'leogol@gmail.com', 
													'como123456', 
													96746932)");
	oci_execute($sentencia_dml);
	echo '<br>';
	echo "Datos ingresados con exito!!!";
 
?>

</DOCTYPE>