<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Informacion del vendedor</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo2.css">
	<link rel="stylesheet" href="css/estilo.css">
	<link rel="icon" type="image/jpg" href="recursos/imagenes/logo.png">
	<link rel="stylesheet" href="css/jquery.rateyo.min.css"/>
</head>
<body>
	<?php
		include_once("class/conexion_copy.php");
		session_start();
		$conexion = new Conexion();
	?>
	<!--Barra de navegacion superior-->
	<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #72a276; width: 100%; height:5%;">
		<!-- Menú desplegable de categorias -->
		<div class="mr-auto nav-item dropdown" >
			<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				<img src="recursos/imagenes/Menu.png" width=20>
			</a>
			<div class="dropdown-menu dropright" style="overflow-y: auto; height: 590px; margin: 6px 0 0 -17px; border-radius: 0px;">
				<h6 style="text-align: center;">Categorías</h6>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Entretenimiento</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#"><label>Películas & Música</label></a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Computadoras & Accesorios</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Consolas & Videojuegos</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Celulares & Accesorios</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Vehículos</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Comprar</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Rentar</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Inmuebles</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Comprar</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Rentar</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Hogar</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Muebles</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Electrodomésticos</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Jardín & Herramientas</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Empleos, Negocios & Servicios</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Ofertas de empleo</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Servicios a negocios</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Servicios al público</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Otros servicios</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="#">Otros</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="#">Otros productos</a>
			</div>
		</div>

		<!--logo de la pagina -->
		<a href="index.php" class="navbar-brand mr-auto" style="background-color: #72a276;"><img src="recursos/imagenes/Logo.png" width=50 height="40"></a>

		<!--gestion de sesión -->
		<?php
			if(!isset($_SESSION['codigo_usuario_sesion'])){
					$conexion->establecerConexion();
	                //echo "seccion cerrada";
			        echo '<div class="nav-item dropdown">';
						echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>';
						echo '<div class="dropdown-menu" style="margin: 9px 0 0 -40px;">';
							echo '<a class="dropdown-item" href="index.php">Iniciar Sesión</a>';
							echo'<a class="dropdown-item" href="modulo_registro.html">Registrarse</a>';
						echo '</div>';
					echo '</div>';
			}
			else{
				$usuario = $_SESSION['codigo_usuario_sesion'];
				//echo "seccion iniciada por: " . $usuario;
				$conexion->establecerConexion();
				$resultado_usuario = $conexion->ejecutarInstruccion("	SELECT NOMBRE,CODIGO_TIPO_USUARIO
																		FROM TBL_USUARIOS
																		WHERE CODIGO_USUARIO = '$usuario'");
				oci_execute($resultado_usuario);
				while ($fila = $conexion->obtenerFila($resultado_usuario)) {
					echo '<h6 style="padding-top:4px; margin-right:-10px;">'.$fila["NOMBRE"].'</h6>';
					$tipo_usuario = $fila["CODIGO_TIPO_USUARIO"];
				}
			    echo'<div class="nav-item dropdown">';
					echo'<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">';
							
					echo'</a>';
					echo'<div class="dropdown-menu" style="margin: 9px 0 0 -110px;">';
						if ($tipo_usuario==1) {
							echo'<a class="dropdown-item" href="Adm_gestion_publicaciones.php">Administrar</a>';
						}
						else {
							echo'<a class="dropdown-item" href="Perfil_usuario_empresarial.php">Ver Perfil</a>';
						}
						echo'<a class="dropdown-item" href="php/session_cerrar.php">Cerrar Sesión</a>';
					echo'</div>';
				echo'</div>';
			}
		?>
	</nav>

	<!--Contenido de la pagina-->
	<div class="container" style="text-align: center; margin-bottom: 10px;">
		<div>
		  <h5 class="col-lg-12" style="padding-top:30px;">Informacion del vendedor </h5><hr>
		</div>
	</div>
	<br>
	<div class="container-fluid" style="text-align: center;">
		<br>
	  	<?php
			//<!--Fila 1-->
			echo'<div class="row">';
		
			//consulta para obtener los datos del usuario en una variable de conexion: resultado_usuario
			$codigo_usuario_vendedor = $_GET["codigo-usuario"];
			echo'<input type="text" id="codigoVendedor" value="'.$codigo_usuario_vendedor.'" style="display: none;">';
			$resultado_usuario = $conexion->ejecutarInstruccion(
				"SELECT NOMBRE, APELLIDO, CORREO_ELECTRONICO, TELEFONO, L.NOMBRE_LUGAR, NVL(CIUDAD,0) CIUDAD,
					obtener_valoracion(U.CODIGO_USUARIO) NUMERO_ESTRELLAS, V.CODIGO_TIPO_VENDEDOR,
					T.NOMBRE_TIENDA, T.DESCRIPCION_TIENDA||(
						SELECT 'Descripcion no disponible' FROM TBL_TIENDAS 
						WHERE DESCRIPCION_TIENDA IS NULL AND 
						CODIGO_TIENDA = V.CODIGO_TIENDA) DESCRIPCION_TIENDA, 
						T.TELEFONO_TIENDA||(
							SELECT 'Telefono no disponible' FROM TBL_TIENDAS 
						WHERE TELEFONO_TIENDA IS NULL AND 
						CODIGO_TIENDA = V.CODIGO_TIENDA) TELEFONO_TIENDA, 
						T.CORREO_TIENDA||(
							SELECT 'Correo no disponible' FROM TBL_TIENDAS 
						WHERE CORREO_TIENDA IS NULL AND 
						CODIGO_TIENDA = V.CODIGO_TIENDA) CORREO_TIENDA,
						T.DIRECCION_FISICA_TIENDA||(
							SELECT 'Direccion de la tienda no disponible' FROM TBL_TIENDAS 
						WHERE DIRECCION_FISICA_TIENDA IS NULL AND 
						CODIGO_TIENDA = V.CODIGO_TIENDA) DIRECCION_FISICA_TIENDA
				FROM TBL_USUARIOS U
				INNER JOIN TBL_VENDEDORES V ON U.CODIGO_USUARIO = V.CODIGO_USUARIO_VENDEDOR
				INNER JOIN TBL_LUGARES L ON L.CODIGO_LUGAR = U.CODIGO_LUGAR
				LEFT JOIN TBL_TIENDAS T ON T.CODIGO_TIENDA = V.CODIGO_TIENDA
				WHERE U.CODIGO_USUARIO = '$codigo_usuario_vendedor'
			");
			oci_execute($resultado_usuario);
			//Imagenes de perfil y banner
			$imagenesDelPrefil = $conexion->ejecutarInstruccion(
				"SELECT IMG.CODIGO_TIPO_IMAGEN, IMG.RUTA_IMAGEN FROM TBL_VENDEDORES V
					INNER JOIN TBL_VEND_X_TBL_IMG IMGT 
						ON IMGT.CODIGO_USUARIO_VENDEDOR = V.CODIGO_USUARIO_VENDEDOR 
					INNER JOIN TBL_IMAGENES IMG ON IMG.CODIGO_IMAGEN = IMGT.CODIGO_IMAGEN
					WHERE V.CODIGO_USUARIO_VENDEDOR = '$codigo_usuario_vendedor'
				"
			);
			oci_execute($imagenesDelPrefil);
			$imagenPerfil = "recursos/imagenes/ImagenUsuario.png";  
			$imagenBanner = "img/banner.jpg";
			$imagenLogo = "img/cuadrada.png";
			while ($imagen = $conexion->obtenerFila($imagenesDelPrefil)){
				if($imagen["CODIGO_TIPO_IMAGEN"] == 2){
					$imagenBanner = $imagen["RUTA_IMAGEN"];
				}else if($imagen["CODIGO_TIPO_IMAGEN"] == 1){
					$imagenPerfil = $imagen["RUTA_IMAGEN"];
					$imagenLogo = $imagen["RUTA_IMAGEN"];
				}
			}
			while ($fila = $conexion->obtenerFila($resultado_usuario)) {
				$tipoVendedor = $fila["CODIGO_TIPO_VENDEDOR"];
				//<!--Banner para empresarial-->
				if ($tipoVendedor == 2) {
					echo'<div class="container" style="text-align: center; border-bottom: medium; margin-top:-50px;
						height:20vh; margin-bottom: 40px;">
						<center><div id="previewbanner"><img src="'.$imagenBanner.'" style="padding-bottom: 1%;padding-right: 1%;" class="img-fluid"></div></center>
					</div>';
				}
				//<!--Columna 1-->
				if($tipoVendedor == 1){
					echo'<div class="col-md-6 col-sm-6 offset-lg-0 col-lg-6">';
					//<!--Imagen del perfil de usuario id:imagenUsuario-->
					echo'<img src="'.$imagenPerfil.'" class="rounded-circle img-fluid" id="imagenUsuario" alt="Placeholder image" 
					style="width: 50%; max-width:200px; max-height:200px; padding:10px;">';
					echo'<h5>';
						echo $fila["NOMBRE"]." ".$fila["APELLIDO"];//nombre del vendedor obtenido en la base de datos
					echo'</h5>';

					echo'<h6>Calificación del vendedor</h6>';//etiqueta calificacion del vendedor
					echo'<h3 style="color: orange;">';
					echo $fila["NUMERO_ESTRELLAS"];
					echo'&#9733;</h3>';
				}else{
					echo'<div class="col-md-6 col-sm-6 offset-lg-0 col-lg-7">';
					echo'<div class="container" style="text-align:left;">';
						
						echo'<div class="row">';
						echo'<div class="col-md-6 col-sm-6 offset-lg-0 col-lg-4">';
						//<!--Imagen del perfil de usuario id:imagenUsuario-->
							echo'<img src="'.$imagenLogo.'" class="rounded-circle img-fluid" id="imagenUsuario" alt="Placeholder image" 
							style="width: 100%; max-width:200px; max-height:200px; padding:10px;">';
						echo'</div>';
						echo'<div class="col-md-6 col-sm-6 offset-lg-0 col-lg-8">';
							echo'<h3>';
								echo $fila["NOMBRE_TIENDA"];//nombre de la tienda
							echo'</h3>';
							echo'<h5>Descripción:</h5>';
							echo'<h6 style="-ms-word-break: break-all; word-break: break-all; word-break: break-word; 
									-webkit-hyphens: auto; -moz-hyphens: auto;-ms-hyphens: auto; hyphens: auto;">';
									echo $fila["DESCRIPCION_TIENDA"];		
							echo'</h6>';

							echo'<h5>Calificación de la tienda</h5>';
							echo'<h3 style="color: orange;">';
							echo $fila["NUMERO_ESTRELLAS"];
							echo'&#9733;</h3>';
							echo'</div>';
						echo'</div>';
					echo'</div>';
				}

				if(!isset($_SESSION['codigo_usuario_sesion'])){
					echo '<div style="margin-left: 50px; margin-top: 10px">No has iniciado sesión, '." ".
					' <a href="index.php">Inicia Sesión</a> '." ".
					' para poder calificar o agregar a favoritos este vendedor</div>';
				}else if($codigo_usuario_vendedor != $_SESSION['codigo_usuario_sesion']){
					$usuario = $_SESSION['codigo_usuario_sesion'];
					$esTienda = $conexion->ejecutarInstruccion(
					"SELECT V.CODIGO_TIPO_VENDEDOR FROM TBL_USUARIOS U
						INNER JOIN TBL_VENDEDORES V 
							ON V. CODIGO_USUARIO_VENDEDOR = U.CODIGO_USUARIO
						WHERE U.CODIGO_USUARIO = $usuario
					");
					oci_execute($esTienda);
					
					while($obtenerTienda = $conexion->obtenerFila($esTienda)){	
						if($obtenerTienda["CODIGO_TIPO_VENDEDOR"] != 2){
							$resultadoMiValoracion = $esTienda = $conexion->ejecutarInstruccion(
								"SELECT NUMERO_ESTRELLAS FROM TBL_RANKING
								 WHERE CODIGO_USUARIO_VENDEDOR = $codigo_usuario_vendedor AND
								 CODIGO_USUARIO_COMPRADOR = $usuario
								"
							);
							oci_execute($resultadoMiValoracion);
		
							 $miValoracion = 0;
							while($filaEstrella = $conexion->obtenerFila($resultadoMiValoracion)){
								$miValoracion = $filaEstrella["NUMERO_ESTRELLAS"];
							}
							//Botón agregar a favoritos 
							echo'<button type="button" id="btn_favoritos" 
							name="btn_favoritos" class="btn btn-dark">Añadir a favoritos</button><br><br>';
							//etiqueta para indicar la seccion de calificar vendedor
							echo'<h6 style="color: #000;">Calificar este vendedor</h6>';
							//Hacer funcionar valoracion por estrellas
							echo'<form style="margin-bottom:10px;">';
								echo'<div class="rateyo" id= "rating"';
									echo'data-rateyo-rating="'.$miValoracion.'"';
									echo'data-rateyo-num-stars="5"';
									echo'data-rateyo-full-star= true style="margin: 10px auto"></div>';
									echo'<h6 class = "result">Tu calificación: 0</h6>';
								echo'<input type="radio" name="rating" id="rb_rating value="6" checked style="display: none;">';
							echo'</form>';
							echo'<button type="button" id="btn_enviar" 
								name="enviar" class="btn btn-dark">Enviar Valoración</button><br><br>';
						}
								
					}
				}

				echo'</div>';

				//<!--Columna 2-->
				echo'<div class="col-sm-6 col-md-6 col-lg-5" style="text-align: left;">';
					if($tipoVendedor == 1){
						echo'<h6>Correo: '; 
							echo$fila["CORREO_ELECTRONICO"];
						echo'</h6>';
		
						echo'<h6>Telefono: +';
							echo $fila["TELEFONO"];
						echo'</h6>';

						echo'<h6><img src="img/pin.png" width=30 height=30> Ubicación: ';
							echo $fila['NOMBRE_LUGAR'];
						if ($fila['CIUDAD']!='0') {
							echo', '.$fila['CIUDAD'];
						}
						echo'</h6>';
					}else{
						echo'<br><h6>Correo: '; 
							echo$fila["CORREO_TIENDA"];
						echo'</h6>';
		
						echo'<h6>Telefono: +';
							echo $fila["TELEFONO_TIENDA"];
						echo'</h6>';

						echo'<h6><img src="img/pin.png" width=30 height=30> Ubicación: ';
							echo $fila['NOMBRE_LUGAR'].", ".$fila['DIRECCION_FISICA_TIENDA'];
						echo'</h6>';
					}

					echo'<h6>Servicios ofrecidos</h6>';

					$resultado_servicios = $conexion->ejecutarInstruccion(
						" SELECT S.NOMBRE_SERVICIO FROM TBL_VENDEDORES V
						INNER JOIN TBL_VEND_X_TBL_SERV VXS ON VXS.CODIGO_USUARIO_VENDEDOR = V.CODIGO_USUARIO_VENDEDOR
						INNER JOIN TBL_SERVICIOS S ON S.CODIGO_SERVICIO = VXS.CODIGO_SERVICIO
						WHERE V.CODIGO_USUARIO_VENDEDOR = '$codigo_usuario_vendedor'
					");
					oci_execute($resultado_servicios);
					echo'<div class="container">';
						while ($fila = $conexion->obtenerFila($resultado_servicios)) {
								echo'<h7>';
									echo "&#x2600;".$fila["NOMBRE_SERVICIO"]."<br>";
								echo'</h7>';	
						}
						if ($conexion->cantidadRegistros($resultado_servicios) == 0) {
								echo'<h7>';
									echo "No ofrece ningun servicio<br>";
								echo'</h7>';
						}
					echo'</div><br>';
					
					$resultado_productos = $conexion->ejecutarInstruccion(
						" SELECT PB.NOMBRE_PRODUCTO, TBL_MONEDA.CODIGO_TIPO_MONEDA, PRECIO, 
							NVL(EPROD.NOMBRE_ESTADO_PRODUCTO,'Disponible') NOMBRE_ESTADO_PRODUCTO, 
							IMG.RUTA_IMAGEN, PB.CODIGO_PUBLICACION_PRODUCTO
						FROM TBL_VENDEDORES V
						INNER JOIN TBL_VEND_X_TBL_PUBLI VPB 
							ON VPB.CODIGO_USUARIO_VENDEDOR = V.CODIGO_USUARIO_VENDEDOR
						INNER JOIN TBL_PUBLICACION_PRODUCTOS PB
							ON PB.CODIGO_PUBLICACION_PRODUCTO = VPB.CODIGO_PUBLICACION_PRODUCTO
						LEFT JOIN TBL_ESTADO_PRODUCTO EPROD 
							ON EPROD.CODIGO_ESTADO_PRODUCTO = PB.CODIGO_ESTADO_PRODUCTO
						INNER JOIN TBL_MONEDA 
							ON TBL_MONEDA.CODIGO_TIPO_MONEDA = PB.CODIGO_TIPO_MONEDA
						INNER JOIN TBL_ESTADO_PUBLICACION EPB 
							ON EPB.CODIGO_ESTADO_PUBLICACION = PB.CODIGO_ESTADO_PUBLICACION
						INNER JOIN TBL_PROD_X_TBL_IMG PXIMG
							ON PXIMG.CODIGO_PRODUCTO = PB.CODIGO_PUBLICACION_PRODUCTO
						INNER JOIN TBL_IMAGENES IMG 
							ON IMG.CODIGO_IMAGEN = PXIMG.CODIGO_IMAGEN
						WHERE V.CODIGO_USUARIO_VENDEDOR = '$codigo_usuario_vendedor' AND 
							UPPER(EPB.NOMBRE_ESTADO_PUBLICACION) = UPPER('disponible')
						ORDER BY PB.CODIGO_PUBLICACION_PRODUCTO
					");
					oci_execute($resultado_productos);
					echo'<h6>Productos</h6>';
					echo'<div class="card card-scroll col-lg-12 col-md-12" 
						style="max-height: 240px; overflow:scroll; -webkit-overflow-scrolling:touch; margin-bottom:10px;">';
						echo'<ul class="list-group list-group-flush">';
						$repetido = 0;
							while($fila = $conexion->obtenerFila($resultado_productos)){
								if ($repetido != $fila["CODIGO_PUBLICACION_PRODUCTO"]) {
									echo'<li class="list-group-item"><img src="'.$fila["RUTA_IMAGEN"].'" width=50 height=50>';
										echo "\t<a style='color:black' href='infodeProductos.php?codigo-publicacion=".$fila['CODIGO_PUBLICACION_PRODUCTO']."'>".$fila["NOMBRE_PRODUCTO"]."\t";
										if($fila["CODIGO_TIPO_MONEDA"] == 1){
											echo"\t L. ";
										}else{
											echo"\t $. ";
										}
										echo $fila["PRECIO"]."\tEstado: ".$fila["NOMBRE_ESTADO_PRODUCTO"];
									echo'</a></li>';
									$repetido = $fila["CODIGO_PUBLICACION_PRODUCTO"];
								}
							}
						if ($conexion->cantidadRegistros($resultado_productos) == 0) {
								echo'<h7>';
									echo "No cuenta con productos publicados<br>";
								echo'</h7>';
						}
						echo'</ul>';
					echo'</div>';
				echo'</div>';
			}
				
			echo'</div>';
		?>
	</div>
		<!-- /#page-content-wrapper -->
	<!-- /#wrapper -->
	  
	<!--Pie de página-->
	<footer id="footer" style="background: #fff; margin-top:0px; width:100%;">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-mx-2" style="padding-left:50px; padding-right: 30px;">
					<br>
					<h6>Goodshopping</h6>
					<a href="#" style="color: black;">
						<span>
							Acerca de nosotros
						</span>
					</a>
					<br>
					<a href="#" style="color: black;">
						<span>
							Contáctanos
						</span>
					</a>
				</div>
	
				<div class="col-xs-4 col-mx-2" style="padding-left:50px; padding-right: 30px;">
					<br>
					<h6>Destacados</h6>
					<a href="#" style="color: black;">
						<span>
							Región
						</span>
					</a>
					<br>
					<a href="#" style="color: black;">
						<span>
							Categoría
						</span>
					</a>
					<br>
					<a href="#" style="color: black;">
						<span>
							Vendedor
						</span>
					</a>
				</div>

				<div class="col-xs-3 col-mx-3" style="padding-left:40px; padding-right: 10px;">
					<br>
					<h6>Terminos y condiciones</h6>
					<a href="#" style="color: black;">
						<span>
							Condiciones de servicio
						</span>
					</a>
					<br>
					<a href="#" style="color: black;">
						<span>
							Políticas de privacidad
						</span>
					</a>
				</div>

				<div class="col-xs-9 col-mx-2" style="padding-left:50px; padding-right: 50px;">
					<br>
					<h6>Ayuda</h6>
					<a href="#" style="color: black;">
						<span>
							Soporte técnico
						</span>
					</a>
				</div>

				<div class="col-xs-2  col-md-7 col-sm-5 col-lg-3" style="text-align:center; padding-left: 5%;">
					<br>
					<h6>Siguenos en</h6>
					<a href="https://www.facebook.com" class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></a>
					<a href="https://pinterest.com" class="btn btn-danger"><img src="recursos/imagenes/pinterest.png" width="25"></a>
					<a href="https://twitter.com" class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></a>
				</div>
			</div>
		</div>		
	</footer>


	<!--Agregando bootstrap al archivo html-->
	<script src="js/jquery.js"></script><!--Lanzar archivo jquery-->
	<script src="js/controlador_informacionVendedor.js"></script>
	<script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.rateyo.js"></script>
	<script src="js/bootstrap.min.js"></script><!--Lanzar archivo Bootstrap.js-->  
	
	<!--script para la valoracion por estrellas-->
	<script>	
		/* Javascript */
		$(function () {
			$(".rateyo").rateYo().on("rateyo.change", function (e, data) {
				var rating = data.rating;
				$(this).parent().find('.result').text('Tu calificación: '+ rating);
				if(rating >=1 && rating <=5){
					$(this).parent().find('input[name=rating]').val(rating);
				}else{
					$(this).parent().find('input[name=rating]').val(6);
				}	
			});
    	});	
	</script>
</body>
</html>

<?php
  	if(!isset($_SESSION['codigo_usuario_sesion'])){
                                                             
  	}
  	else{
  		$conexion->cerrarConexion();
  	}
?>