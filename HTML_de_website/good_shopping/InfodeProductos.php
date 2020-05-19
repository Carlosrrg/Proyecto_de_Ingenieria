<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Información del Producto o Servicio</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/estilo2.css" rel="stylesheet">
	<link rel="icon" type="image/jpg" href="recursos/imagenes/Logo.png">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" 
		integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

	<link rel="stylesheet" href="css/mensaje_error.css">
	<link rel="stylesheet" href="css/jquery.rateyo.min.css"/>
  </head>
  <body>
  	<?php
        include_once("class/conexion_copy.php");
        session_start();
        $conexion = new Conexion();
        //$codigo_publicacion = 21;
        $codigo_publicacion = $_GET["codigo-publicacion"];
       
		//echo '<br>Codigo publicación: '.$codigo_publicacion;
       
    ?>
	  <!--Barra de navegacion superior-->
	  <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #72a276;">
			<!-- Menú desplegable de categorias -->
			<div class="mr-auto nav-item dropdown" >
				<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<img src="recursos/imagenes/Menu.png" width=20>
				</a>
				<div class="dropdown-menu dropright scrollMenu" style="align-content: initial; margin: 6px 0 0 -17px; border-radius: 0px;">
					<h6 style="text-align: center;">Categorías</h6>
					<?php
						$conexion->establecerConexion();

						echo '<div class="dropdown-divider"></div>';

						$codigo_categoria_base = " ";
						$resultado_categorias = $conexion->ejecutarInstruccion("	SELECT CODIGO_CATEGORIA, NOMBRE_CATEGORIA
																					FROM TBL_CATEGORIAS");
						oci_execute($resultado_categorias);
						while ($fila2 = $conexion->obtenerFila($resultado_categorias)) {
							$codigo_categoria_base = $fila2["CODIGO_CATEGORIA"];

							echo '<a class="dropdown-item" href="BusquedaP.php?pagina=1&categoria='.$fila2["CODIGO_CATEGORIA"].'">'.$fila2["NOMBRE_CATEGORIA"].'</a>';	

							$resultado_sub_categorias = $conexion->ejecutarInstruccion("	SELECT A.CODIGO_CATEGORIA, A.NOMBRE_CATEGORIA, C.NOMBRE_SUB_CATEGORIA, C.CODIGO_SUB_CATEGORIA
																							FROM TBL_CATEGORIAS A
																							INNER JOIN TBL_CATEGO_X_TBL_SUBCATEGO B
																							ON (A.CODIGO_CATEGORIA = B.CODIGO_CATEGORIA)
																							INNER JOIN TBL_SUB_CATEGORIAS C
																							ON (B.CODIGO_SUB_CATEGORIA = C.CODIGO_SUB_CATEGORIA)
																							WHERE A.CODIGO_CATEGORIA = '$codigo_categoria_base'
																							ORDER BY (C.CODIGO_SUB_CATEGORIA) ASC");
							oci_execute($resultado_sub_categorias);
							while ($fila3 = $conexion->obtenerFila($resultado_sub_categorias)) {
								echo '<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria='.$codigo_categoria_base.'&subcategorias='.$fila3["CODIGO_SUB_CATEGORIA"].'">'.$fila3["NOMBRE_SUB_CATEGORIA"].'</a>';
							}
							echo '<div class="dropdown-divider"></div>';
							$codigo_categoria_base = " ";
						}		
					?>
				</div>
			</div>

			<!--logo de la pagina -->
			<a href="index.php" class="navbar-brand mr-auto" style="background-color: #72a276;"><img src="recursos/imagenes/Logo.png" width=50 height="40"></a>

			<!--gestion de sesión -->
			<?php
				if(!isset($_SESSION['codigo_usuario_sesion'])){
					$usuario = 1;
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
					$resultado_usuario = $conexion->ejecutarInstruccion("	
																			SELECT 	NOMBRE, APELLIDO, CODIGO_TIPO_USUARIO, CORREO_ELECTRONICO, TELEFONO,
																					NVL(CODIGO_TIPO_VENDEDOR,0) CODIGO_TIPO_VENDEDOR
																			FROM TBL_USUARIOS
																			LEFT JOIN TBL_VENDEDORES
																			ON (CODIGO_USUARIO = CODIGO_USUARIO_VENDEDOR)
																			WHERE CODIGO_USUARIO = '$usuario'");
					oci_execute($resultado_usuario);
					while ($fila = $conexion->obtenerFila($resultado_usuario)) {
						echo '<h6 style="padding-top:4px; margin-right:-10px;">'.$fila["NOMBRE"].'</h6>';
						$tipo_usuario = $fila["CODIGO_TIPO_USUARIO"];
						$codigo_vendedor = $fila["CODIGO_TIPO_VENDEDOR"];
					}
				    echo'<div class="nav-item dropdown">';
						echo'<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">';
								
						echo'</a>';
						echo'<div class="dropdown-menu" style="margin: 9px 0 0 -110px;">';
							if (isset($tipo_usuario) && isset($codigo_vendedor)) {
								if ($tipo_usuario==1) {
								echo'<a class="dropdown-item" href="Adm_gestion_publicaciones.php">Administrar</a>';
								}
								else {
									if ($codigo_vendedor == 1) {
										echo'<a class="dropdown-item" href="Perfil_usuario_comprador.php">Ver Perfil</a>';
									}
									else{
										echo'<a class="dropdown-item" href="Perfil_usuario_empresarial.php">Ver Perfil</a>';
									}
								}
							}
							else{
								session_destroy();
								echo '<script>window.location="InfodeProductos.php"+window.location.search</script>';
							}
							echo'<a class="dropdown-item" href="php/session_cerrar.php">Cerrar Sesión</a>';
						echo'</div>';
					echo'</div>';
				} 
			?>

		</nav>
	<div class="d-flex" id="wrapper">
		<!-- Page Content -->
		<div id="page-content-wrapper">
			<!--Contenido de la pagina-->
			<div class="container" style="text-align: center; border-bottom: medium">
				<?php
					$tipo_publicacion = " ";
					$obtener_tipo_publicacion = $conexion->ejecutarInstruccion(" 	SELECT B.NOMBRE_TIPO_PUBLICACION
																					FROM TBL_PUBLICACION_PRODUCTOS A
																					INNER JOIN TBL_TIPO_PUBLICACION B
																					ON (A.CODIGO_TIPO_PUBLICACION = B.CODIGO_TIPO_PUBLICACION)
																					WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
					oci_execute($obtener_tipo_publicacion);
					while ($fila8 = $conexion->obtenerFila($obtener_tipo_publicacion)) {
						echo '<div><h5 class="col-lg-12" style="padding-top:30px;">Información del ';
							if ($fila8["NOMBRE_TIPO_PUBLICACION"] == "Producto") {
								echo 'Producto';	
							}
							else{
								echo 'Servicio';
							}
						echo '</h5></div>';
						$tipo_publicacion = $fila8["NOMBRE_TIPO_PUBLICACION"];
					}
				?>
			</div>
			<br>
			
			<div class="container-fluid">
				<div class="row">
				  <div class="col-md-6 col-lg-7 col-sm-6"> </div>
				</div>
				
				<!--Fila 1-->
				<div class="row">
				  <!--Columna 1-->
				  <div class="col-md-6 col-lg-4 col-sm-6 offset-lg-0">

					<?php
					  	$obtener_imagenes = $conexion->ejecutarInstruccion("
							SELECT A.RUTA_IMAGEN FROM TBL_IMAGENES A
							INNER JOIN TBL_PROD_X_TBL_IMG B
							ON A.CODIGO_IMAGEN = B.CODIGO_IMAGEN
							WHERE B.CODIGO_PRODUCTO = '$codigo_publicacion'");
						oci_execute($obtener_imagenes);

						//<!-- CARROUSEL DE IMAGENES -->
						  echo '<div class="col-md-6 col-lg-5 col-sm-6 offset-lg-0">';
							  echo '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="width: 400px; height: 200px">';
								  echo '<div class="carousel-inner" id="carousel-inner">';

								$activo = 0;
								while ($fila = $conexion->obtenerFila($obtener_imagenes)) {
									if ($activo == 0) {
										echo '<div class="carousel-item active col-lg-1">';
									} else {
										echo '<div class="carousel-item col-lg-1">';
									}
									  echo '<img class="d-block w-0" src="'.$fila["RUTA_IMAGEN"].'" style="width: 400px; height: 200px">';
									echo '</div>';
									$activo++;
								}

								  echo '</div>';
								  echo '<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">';
									echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
									echo '<span class="sr-only">Previous</span>';
								  echo '</a>';
								  echo '<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">';
									echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
									echo '<span class="sr-only">Next</span>';
								  echo '</a>';
							  echo '</div>';	  
						  echo '</div>';
					?>

					  <style>
						.checked {
						  color: orange;
						}
					  </style>
					  <?php
					  		$codigo_usuario_vendedor = " ";
					  		$promedio_estrellas = " "; 

					  		$obtener_vendedor = $conexion->ejecutarInstruccion(" 	
					  			SELECT 	C.CODIGO_USUARIO_VENDEDOR, D.NOMBRE, D.APELLIDO, D.CIUDAD, 
					  					E.NOMBRE_LUGAR, C.CODIGO_TIPO_VENDEDOR
								FROM TBL_PUBLICACION_PRODUCTOS A
								INNER JOIN TBL_VEND_X_TBL_PUBLI B
								ON (A.CODIGO_PUBLICACION_PRODUCTO=B.CODIGO_PUBLICACION_PRODUCTO)
								INNER JOIN TBL_VENDEDORES C
								ON (B.CODIGO_USUARIO_VENDEDOR=C.CODIGO_USUARIO_VENDEDOR)
								INNER JOIN TBL_USUARIOS D
								ON (C.CODIGO_USUARIO_VENDEDOR=D.CODIGO_USUARIO)
								INNER JOIN TBL_LUGARES E
								ON (D.CODIGO_LUGAR=E.CODIGO_LUGAR)
								WHERE A.CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
							oci_execute($obtener_vendedor);
							while ($fila = $conexion->obtenerFila($obtener_vendedor)) {
								echo '<div style="text-align: center;">';
								$codigo_usuario_vendedor = $fila["CODIGO_USUARIO_VENDEDOR"];
					  			$codigo_tipo_vendedor = $fila["CODIGO_TIPO_VENDEDOR"];
								if ($codigo_tipo_vendedor == 2) {
									$obtener_nombre_vendedor = $conexion->ejecutarInstruccion(" 	SELECT A.NOMBRE_TIENDA
																									FROM TBL_TIENDAS A
																									INNER JOIN TBL_VENDEDORES B
																									ON (A.CODIGO_TIENDA = B.CODIGO_TIENDA)
																									WHERE CODIGO_USUARIO_VENDEDOR = '$codigo_usuario_vendedor'
																									AND CODIGO_TIPO_VENDEDOR = '$codigo_tipo_vendedor'");
									oci_execute($obtener_nombre_vendedor);
									while ($fila9 = $conexion->obtenerFila($obtener_nombre_vendedor)) {
										echo '<br><br><h5><a href="Informacion_de_vendedor.php?codigo-usuario='.$codigo_usuario_vendedor.'">'.$fila9["NOMBRE_TIENDA"].'</a></h5>';
									}
								}
								else{
									echo '<br><br><h5><a href="Informacion_de_vendedor.php?codigo-usuario='.$fila["CODIGO_USUARIO_VENDEDOR"].'">'.$fila["NOMBRE"].' '.$fila["APELLIDO"].'</a></h5>';
								}
							}

							$obtener_vendedor_calificacion = $conexion->ejecutarInstruccion(" 	
								SELECT obtener_valoracion(CODIGO_USUARIO_VENDEDOR) PROMEDIO_ESTRELLAS
								FROM TBL_RANKING
								WHERE CODIGO_USUARIO_VENDEDOR = '$codigo_usuario_vendedor'");
							oci_execute($obtener_vendedor_calificacion);
							
							//Estrellas de puntuacion de usuario vendedor
							while ($fila2 = $conexion->obtenerFila($obtener_vendedor_calificacion)) {
								$promedio_estrellas = $fila2["PROMEDIO_ESTRELLAS"];
							}
							for($i = 0;$i < strlen($promedio_estrellas); $i++){
								if($promedio_estrellas[$i] == ','){
									$promedio_estrellas[$i] = '.';
								}
							}
							echo '<br>Calificación del Vendedor<br>
								<div class="rateyo" id="puntuacion"
									data-rateyo-read-only="true"
									data-rateyo-rating="'.$promedio_estrellas.'"
									data-rateyo-num-stars= "5"
									data-rateyo-star-width= "30px"
									style="margin: 10px auto;">
								</div>';
					  ?> 
					  
					  	
					  <br>Compartir<br>
					  <a href="https://www.facebook.com/sharer/sharer.php?u=" class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></a>
					  <a href="https://pinterest.com/pin/create/button/?media=" class="btn btn-danger"><img src="recursos/imagenes/pinterest.png" width="25"></a>
					  <a href="https://twitter.com/intent/tweet?text= Compra,%20Vende%20facil%20y%20rapido%20desde%20tu%20hogar%20en%20cualquier%20momento%20en%20Good%20Shopping&url=http://localhost/good_shopping/InfodeProductos.php?codigo-publicacion=81" class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></a><br><br>
					<?php
						$tipo_usuario_seccion = " ";

						$obtener_tipo_usuario = $conexion->ejecutarInstruccion(" 	SELECT CODIGO_TIPO_VENDEDOR
																					FROM TBL_VENDEDORES
																					WHERE CODIGO_USUARIO_VENDEDOR = $usuario");
						oci_execute($obtener_tipo_usuario);
						while ($fila12 = $conexion->obtenerFila($obtener_tipo_usuario)) {
							$tipo_usuario_seccion = $fila12["CODIGO_TIPO_VENDEDOR"];
						}
						if (!isset($_SESSION['codigo_usuario_sesion'])) {			
							echo '<div style="margin-left: 50px; margin-top: 50px">No has iniciado sesión, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' para poder denunciar esta publicación<br></div>';
						}
						else{
							if ($codigo_usuario_vendedor != $usuario && $tipo_usuario==2 && $tipo_usuario_seccion == 1) {
							echo '<a class="btn btn-dark" href="Denunciar_publicacion.php?codigo-publicacion='.$codigo_publicacion.'&codigo-usuario-sesion='.$usuario.'&codigo-usuario-vendedor='.$codigo_usuario_vendedor.'">Denunciar</a>';
							}	
						}
								
					?> 
					  </div>
				  </div>
				  
				  <!--Columna 2-->
				  <div class="col-sm-6 col-md-6 col-lg-4">
				  	<div> 

				  		<?php

				  			if ($tipo_publicacion == "Producto") {
				  				$obtener_valores_producto = $conexion->ejecutarInstruccion(" 	SELECT A.NOMBRE_PRODUCTO, A.PRECIO, B.NOMBRE_ESTADO_PRODUCTO, A.DESCIPCION, C.NOMBRE_TIPO_MONEDA
																							FROM TBL_PUBLICACION_PRODUCTOS A
																							INNER JOIN TBL_ESTADO_PRODUCTO B
																							ON(A.CODIGO_ESTADO_PRODUCTO = B.CODIGO_ESTADO_PRODUCTO)
																							INNER JOIN TBL_MONEDA C
																							ON(A.CODIGO_TIPO_MONEDA = C.CODIGO_TIPO_MONEDA)
																							WHERE CODIGO_PUBLICACION_PRODUCTO='$codigo_publicacion'");
								oci_execute($obtener_valores_producto);
								while ($fila = $conexion->obtenerFila($obtener_valores_producto)) {
									echo '<h4>'.$fila["NOMBRE_PRODUCTO"].'</h4>';
								   	echo '<div style="text-align: left" 
								    style="text-align: left;">';
									echo '<br><h6>Precio:</h6> <span style="font-size: 20px;font-weight: bold;">';
										if ($fila["NOMBRE_TIPO_MONEDA"] == "Lempiras") {
											echo 'L. '.$fila["PRECIO"];
										}
										else{
											echo '$. '.$fila["PRECIO"];
										}
									echo '</span>';
									echo '<br><br><h6>Estado del Producto:</h6> '.$fila["NOMBRE_ESTADO_PRODUCTO"];
									echo '<br><br><h6>Descripcion:</h6>';
									echo $fila["DESCIPCION"].'.';
								}

				  			}
				  			else{
				  				$obtener_valores_producto = $conexion->ejecutarInstruccion(" 	SELECT A.NOMBRE_PRODUCTO, A.PRECIO, A.DESCIPCION, B.NOMBRE_TIPO_MONEDA
																								FROM TBL_PUBLICACION_PRODUCTOS A
																								INNER JOIN TBL_MONEDA B
																								ON(A.CODIGO_TIPO_MONEDA = B.CODIGO_TIPO_MONEDA)
																								WHERE CODIGO_PUBLICACION_PRODUCTO='$codigo_publicacion'");
								oci_execute($obtener_valores_producto);
								while ($fila10 = $conexion->obtenerFila($obtener_valores_producto)) {
									echo '<h4>'.$fila10["NOMBRE_PRODUCTO"].'</h4>';
								   	echo '<div style="text-align: left" 
								    style="text-align: left;">';
									echo '<br><h6>Precio:</h6> <span style="font-size: 20px;font-weight: bold;">';
										if ($fila10["NOMBRE_TIPO_MONEDA"] == "Lempiras") {
											echo 'L. '.$fila10["PRECIO"];
										}
										else{
											echo '$. '.$fila10["PRECIO"];
										}
									echo '</span>';
									echo '<br><br><h6>Descripcion:</h6>';
									echo $fila10["DESCIPCION"].'.';
								}

				  			}

				  			


							$obtener_vendedor = $conexion->ejecutarInstruccion(" 	
								SELECT 	C.CODIGO_USUARIO_VENDEDOR, D.NOMBRE, D.APELLIDO, 
										NVL(D.CIUDAD,0) CIUDAD, E.NOMBRE_LUGAR
								FROM TBL_PUBLICACION_PRODUCTOS A
								INNER JOIN TBL_VEND_X_TBL_PUBLI B
								ON (A.CODIGO_PUBLICACION_PRODUCTO=B.CODIGO_PUBLICACION_PRODUCTO)
								INNER JOIN TBL_VENDEDORES C
								ON (B.CODIGO_USUARIO_VENDEDOR=C.CODIGO_USUARIO_VENDEDOR)
								INNER JOIN TBL_USUARIOS D
								ON (C.CODIGO_USUARIO_VENDEDOR=D.CODIGO_USUARIO)
								INNER JOIN TBL_LUGARES E
								ON (D.CODIGO_LUGAR=E.CODIGO_LUGAR)
								WHERE A.CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
							oci_execute($obtener_vendedor);
							while ($fila3 = $conexion->obtenerFila($obtener_vendedor)) {
								echo '<h6><br><br><img src="https://image.flaticon.com/icons/svg/684/684809.svg" style="width: 5%"> Ubicación: ';
								if ($fila3["CIUDAD"]!='0') {
									echo $fila3["CIUDAD"].', ';
								}
								echo $fila3["NOMBRE_LUGAR"].'.</h6>';
							}

							$tipo_publicacion2 = " ";

							echo '<br><h6>Categoria:</h6>';
							$obtener_categoria = $conexion->ejecutarInstruccion(" 	
								SELECT A.NOMBRE_PRODUCTO, B.NOMBRE_CATEGORIA, A.CODIGO_TIPO_PUBLICACION
								FROM TBL_PUBLICACION_PRODUCTOS A
								INNER JOIN TBL_CATEGORIAS B
								ON (A.CODIGO_CATEGORIA=B.CODIGO_CATEGORIA)
								WHERE A.CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
							oci_execute($obtener_categoria);
							while ($fila4 = $conexion->obtenerFila($obtener_categoria)) {
								echo $fila4["NOMBRE_CATEGORIA"];
								$tipo_publicacion2 = $fila4["CODIGO_TIPO_PUBLICACION"];
							}

							if ($tipo_publicacion2 == 1) {
								$obtener_sub_categoria = $conexion->ejecutarInstruccion(" 	SELECT A.NOMBRE_PRODUCTO, C.NOMBRE_SUB_CATEGORIA
																						FROM TBL_PUBLICACION_PRODUCTOS A
																						INNER JOIN TBL_PRODU_X_TBL_CATEGO B
																						ON (A.CODIGO_PUBLICACION_PRODUCTO=B.CODIGO_PRODUCTO)
																						INNER JOIN TBL_SUB_CATEGORIAS C
																						ON (B.CODIGO_SUB_CATEGORIA=C.CODIGO_SUB_CATEGORIA)
																						WHERE A.CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
								oci_execute($obtener_sub_categoria);
								while ($fila5 = $conexion->obtenerFila($obtener_sub_categoria)) {
									echo '<ul>';
					  					echo '<li>'.$fila5["NOMBRE_SUB_CATEGORIA"].'</li>';
					  				echo '</ul>';
								}
							}
							else{
								$obtener_servicio = $conexion->ejecutarInstruccion(" 	SELECT A.NOMBRE_PRODUCTO, C.NOMBRE_SERVICIO
																							FROM TBL_PUBLICACION_PRODUCTOS A
																							INNER JOIN TBL_PUBLIC_X_TBL_SERV B
																							ON (A.CODIGO_PUBLICACION_PRODUCTO=B.CODIGO_PUBLICACION_PRODUCTO)
																							INNER JOIN TBL_SERVICIOS C
																							ON (B.CODIGO_SERVICIO=C.CODIGO_SERVICIO)
																							WHERE A.CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
								oci_execute($obtener_servicio);
								while ($fila13 = $conexion->obtenerFila($obtener_servicio)) {
									echo '<ul>';
					  					echo '<li>'.$fila13["NOMBRE_SERVICIO"].'</li>';
					  				echo '</ul>';
								}
							}
				  		?>
				  		
					  </div>
				  	</div>
				  </div>
					
				  <!--Columna 3-->
				  <div class="col-sm-6 col-md-6 col-lg-3 offset-lg-0"><!--Columna 3-->
	<!--scrollbar onlyread-->			  	
					<label for="cmb-categoria"><h6>Publicaciones Destacadas:<h6></label>
						<div>

							<?php

								$arreglo_codigo_publicacion =array();
								$contador = 0;

								$obtener_codigo_producto_destacado = $conexion->ejecutarInstruccion(" 	SELECT A.CODIGO_PUBLICACION_PRODUCTO, A.NOMBRE_PRODUCTO, A.PRECIO, C.CODIGO_USUARIO_VENDEDOR, D.NOMBRE, D.APELLIDO
																										FROM TBL_PUBLICACION_PRODUCTOS A
																										INNER JOIN TBL_VEND_X_TBL_PUBLI B
																										ON (A.CODIGO_PUBLICACION_PRODUCTO = B.CODIGO_PUBLICACION_PRODUCTO)
																										INNER JOIN TBL_VENDEDORES C
																										ON (B.CODIGO_USUARIO_VENDEDOR=C.CODIGO_USUARIO_VENDEDOR)
																										INNER JOIN TBL_USUARIOS D
																										ON (C.CODIGO_USUARIO_VENDEDOR=D.CODIGO_USUARIO)
																										WHERE A.CODIGO_ESTADO_PUBLICACION = 1");
								oci_execute($obtener_codigo_producto_destacado);
								while ($fila7 = $conexion->obtenerFila($obtener_codigo_producto_destacado)) {
									$arreglo_codigo_publicacion[$contador] = $fila7["CODIGO_PUBLICACION_PRODUCTO"];
									$contador++;
								}
								//echo count($arreglo_codigo_publicacion);

								//$verificar = rand(0,2);
								$verificar = 0;
								$codigo_publicacion_imagen = " ";
								$randon = " ";

								$codigo_usuario_vendedor2 = " ";
								$codigo_tipo_vendedor2 = " ";

								echo '<table class="table" style="width:100%">';
									echo '<thead class="thead-dark">';
									    echo '<tr>';
									      	echo '<th scope="col">Producto</th>';
									      	echo '<th scope="col">Vendedor</th>';
									      	echo '<th scope="col">Precio</th>';
									    echo '</tr>';
								 	echo '</thead>';
								$obtener_producto_destacado = $conexion->ejecutarInstruccion(" 	SELECT A.CODIGO_PUBLICACION_PRODUCTO, A.NOMBRE_PRODUCTO, A.PRECIO, C.CODIGO_USUARIO_VENDEDOR, C.CODIGO_TIPO_VENDEDOR, D.NOMBRE, D.APELLIDO, E.NOMBRE_TIPO_MONEDA
																								FROM TBL_PUBLICACION_PRODUCTOS A
																								INNER JOIN TBL_VEND_X_TBL_PUBLI B
																								ON (A.CODIGO_PUBLICACION_PRODUCTO = B.CODIGO_PUBLICACION_PRODUCTO)
																								INNER JOIN TBL_VENDEDORES C
																								ON (B.CODIGO_USUARIO_VENDEDOR=C.CODIGO_USUARIO_VENDEDOR)
																								INNER JOIN TBL_USUARIOS D
																								ON (C.CODIGO_USUARIO_VENDEDOR=D.CODIGO_USUARIO)
																								INNER JOIN TBL_MONEDA E
																								ON (A.CODIGO_TIPO_MONEDA=E.CODIGO_TIPO_MONEDA)
																								WHERE A.CODIGO_ESTADO_PUBLICACION = 1");
								oci_execute($obtener_producto_destacado);
								while ($fila6 = $conexion->obtenerFila($obtener_producto_destacado)) {
									$codigo_usuario_vendedor2 = $fila6["CODIGO_USUARIO_VENDEDOR"];
					  				$codigo_tipo_vendedor2 = $fila6["CODIGO_TIPO_VENDEDOR"];

									$randon = rand(0,count($arreglo_codigo_publicacion));
									for ($i=0; $i <$randon; $i++) {
										if ($verificar <= 2) {
										 	if ($arreglo_codigo_publicacion[$i] == $fila6["CODIGO_PUBLICACION_PRODUCTO"]) {
												echo '<tbody>';
													echo '<tr>'; 
												      echo '<td><a href="InfodeProductos.php?codigo-publicacion='.$fila6["CODIGO_PUBLICACION_PRODUCTO"].'"><img src="';
														    $codigo_publicacion_imagen = $fila6["CODIGO_PUBLICACION_PRODUCTO"];

														    $obtener_imagen_producto = $conexion->ejecutarInstruccion(" SELECT A.CODIGO_PUBLICACION_PRODUCTO, A.NOMBRE_PRODUCTO, C.RUTA_IMAGEN
																														FROM TBL_PUBLICACION_PRODUCTOS A
																														INNER JOIN TBL_PROD_X_TBL_IMG B
																														ON (A.CODIGO_PUBLICACION_PRODUCTO = B.CODIGO_PRODUCTO)
																														INNER JOIN TBL_IMAGENES C
																														ON (B.CODIGO_IMAGEN = C.CODIGO_IMAGEN)
																														WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion_imagen'");
															oci_execute($obtener_imagen_producto);
															while ($fila8 = $conexion->obtenerFila($obtener_imagen_producto)) {
																echo $fila8["RUTA_IMAGEN"];
																break;
															}
												      echo '" style="width: 100px; height: 80px"></a></td>';

												      	if ($codigo_tipo_vendedor2 == 2) {
															$obtener_nombre_vendedor2 = $conexion->ejecutarInstruccion(" 	SELECT A.NOMBRE_TIENDA
																															FROM TBL_TIENDAS A
																															INNER JOIN TBL_VENDEDORES B
																															ON (A.CODIGO_TIENDA = B.CODIGO_TIENDA)
																															WHERE CODIGO_USUARIO_VENDEDOR = '$codigo_usuario_vendedor2'
																															AND CODIGO_TIPO_VENDEDOR = '$codigo_tipo_vendedor2'");
															oci_execute($obtener_nombre_vendedor2);
															while ($fila11 = $conexion->obtenerFila($obtener_nombre_vendedor2)) {
																echo '<td><a href="Informacion_de_vendedor.php?codigo-usuario='.$codigo_usuario_vendedor2.'">'.$fila11["NOMBRE_TIENDA"].'</a></td>';
															}
														}
														else{
															echo '<td><a href="Informacion_de_vendedor.php?codigo-usuario='.$fila6["CODIGO_USUARIO_VENDEDOR"].'">'.$fila6["NOMBRE"].' '.$fila6["APELLIDO"].'</a></td>';
														}
														if($fila6["NOMBRE_TIPO_MONEDA"] == "Lempiras"){
															echo '<td>L. '.$fila6["PRECIO"].'</td>';
														}
														else{
															echo '<td>$. '.$fila6["PRECIO"].'</td>';
														}
												    echo '</tr>';
												echo '</tbody>';
												$verificar++;
											}
										} 
									}
								}
								echo '</table>';
								//echo $contador;
								/*echo $numero_aleatorio = rand(1,25);
								echo "<br>";
								$d=mt_rand(1,25);
  								echo $d ;*/
							?>

						</div>
						<style>
                        	div.ex1 {
							  background-color: lightblue;
							  height: 40px;
							  width: 200px;
							  overflow-y: scroll;
							}
                        </style>
    				<!--scrollbar mensaje de texto-->                    
					<?php 
						if (!isset($_SESSION['codigo_usuario_sesion'])) {			
							echo '<div style="margin-left: 50px; margin-top: 50px">No has iniciado sesión, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' para enviar mensaje a este vendedor sobre esta publicación</div>';
						}
						else{
							if ($codigo_usuario_vendedor!=$usuario && $tipo_usuario_seccion == 1) {
								echo '<label for="txt-descripcion" style="padding-top:15px; "><h6>Mensaje:</h6></label>';
								echo'<textarea class="ex1" id="txt-mensaje" name="txt-mensaje" style="width: 100%; height: 180px;" placeholder="Escriba su mensaje aqui"></textarea>';
								echo'<input type="text" name="txt-codigo-p" id="txt-codigo-p" style="display: none;" value="'.$codigo_publicacion.'">';
								echo'<input type="text" name="txt-idVendedor" id="txt-idVendedor" style="display: none;" value="'.$codigo_usuario_vendedor.'">';
								echo'<span>';
									echo'<button type="submit" name="btn_enviar_mensaje" id="btn_enviar_mensaje" class="btn btn-success"> Enviar Mensaje</button>';
								echo'</span>';	
								echo'<div id="mensaje1" class="errores">Por favor, rellene los campos requeridos con un máximo de 500 caracteres.</div>';
							}
						}
					?>
					<br><br>
					<center>
                        <div class="spinner-border text-success" role="status" id="r-cargando">
                            <span class="sr-only">Cargando...</span>
                        </div>
                    </center>

				  </div>
				</div>
			</div>
		</div>
		<!-- /#page-content-wrapper -->
	</div>
	<!-- /#wrapper -->
	  
	<!--Pie de página-->
	<footer id="footer" style="background: #fff; margin-top:14%; width:100%;">
		<div class="container">
			<div class="row">
				<div class="col-xs-6 col-mx-2" style="padding-left:50px; padding-right: 30px;">
					<br>
					<h6>Good Shopping</h6>
					<a href="Acerca_de_nosotros.html" style="color: black;">
						<span>
							Acerca de nosotros
						</span>
					</a>
					<br>
					<a href="contactanos.html" style="color: black;">
						<span>
							Contáctanos
						</span>
					</a>
				</div>
	
				<div class="col-xs-4 col-mx-2" style="padding-left:50px; padding-right: 30px;">
					<br>
					<h6>Destacados</h6>
					<a href="Destacados_Region.php" style="color: black;">
						<span>
							Región
						</span>
					</a>
					<br>
					<a href="vendedores.html" style="color: black;">
						<span>
							Vendedor
						</span>
					</a>
				</div>

				<div class="col-xs-3 col-mx-3" style="padding-left:40px; padding-right: 10px;">
					<br>
					<h6>Términos y condiciones</h6>
					<a href="Terminos_y_condiciones.html" style="color: black;">
						<span>
							Condiciones de servicio
						</span>
					</a>
					<br>
					<a href="Politica_de_privacidad.html" style="color: black;">
						<span>
							Políticas de privacidad
						</span>
					</a>
				</div>

				<div class="col-xs-9 col-mx-2" style="padding-left:50px; padding-right: 50px;">
					<br>
					<h6>Ayuda</h6>
					<a href="Preguntas_frecuentes.html" style="color: black;">
						<span>
							Preguntas frecuentes
						</span>
					</a>
				</div>

				<div class="col-xs-2  col-md-7 col-sm-5 col-lg-3" style="text-align:center; padding-left: 5%;">
					<br>
					<h6>Síguenos en</h6>
					<a href="https://www.facebook.com/Good-Shopping-106040207755389/?modal=admin_todo_tour" class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></a>
					<a href="https://www.pinterest.ca/GoodShoppingHn504/" class="btn btn-danger"><img src="recursos/imagenes/pinterest.png" width="25"></a>
					<a href="https://twitter.com/GoodShopping7" class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></a>
				</div>
			</div>
		</div>		
	</footer>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/controlador_enviar_mensaje.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery.rateyo.js"></script>
  <script>
		$(function () {
			$(".rateyo").rateYo().on();
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