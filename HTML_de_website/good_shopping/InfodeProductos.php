<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informacion del Producto o Servicio</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/estilo2.css" rel="stylesheet">
	<link rel="icon" type="image/jpg" href="recursos/imagenes/Logo.png">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" 
		integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

	<link rel="stylesheet" href="css/mensaje_error.css">
  </head>
  <body>
  	<?php
        include_once("class/conexion_copy.php");
        session_start();
        $conexion = new Conexion();

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
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="#">Entretenimiento</a>
					<a class="dropdown-item" style="padding-left: 50px;" href="#">Películas & Música</a>
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
	                //echo "seccion cerrada";
			        echo'<div class="nav-item dropdown">';
						echo'<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>';
						echo'<div class="dropdown-menu" style="margin: 9px 0 0 -60px;">';
							echo'<a class="dropdown-item dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Iniciar Sesión</a>';
							
							//<!--formulario para iniciar sesión -->
							echo'<div class="dropdown-menu" style="margin: -82px 0 0 -80px;">';
								echo'<div class="px-4 py-3">';
									echo'<div class="form-group">';
										echo'<label for="txt-correo">Correo Electrónico</label>';
										echo'<input type="email" class="form-control" id="txt-correo" name="txt-correo" placeholder="email@example.com">';
									echo'</div>';
									echo'<div class="form-group">';
										echo'<label for="txt-contrasena">Contraseña</label>';
										echo'<input type="password" class="form-control" id="txt-contrasena" name="txt-contrasena" placeholder="Contraseña">';
									echo'</div>';
									echo'<div class="form-group">';
										echo'<div class="form-check">';
										echo'<input type="checkbox" class="form-check-input" id="dropdownCheck">';
										echo'<label class="form-check-label" for="dropdownCheck">
											Recordar
										</label>';
										echo'</div>';
									echo'</div>';
									echo'<button type="submit" id="btn_iniciar2" name="btn_iniciar2" class="btn btn-success">Iniciar Sesión</button>';
								echo'</div>';
									echo'<div id="mostrar_error_login" class="error_login">Ingrese el correo y la contrasena.</div>';
									//<!--<div id="mostrar_error_login2" class="error_login">Correo o Contraseña incorrectos</div>-->
									echo'<div class="dropdown-divider"></div>';
									echo'<a class="dropdown-item" href="#" data-toggle="modal" data-target="#exampleModal">Restablecer Contraseña</a>';
							echo'</div>';
							echo'<a class="dropdown-item" href="modulo_registro.html">Registrarse</a>';
						echo'</div>';
					echo'</div>';
				}
				else{
					$usuario = $_SESSION['codigo_usuario_sesion'];
				    //echo "seccion iniciada por: " . $usuario;
				    echo'<div class="nav-item dropdown">';
						echo'<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">';
								$conexion->establecerConexion();
								$resultado_usuario = $conexion->ejecutarInstruccion("	
									SELECT NOMBRE, CODIGO_TIPO_USUARIO
									FROM TBL_USUARIOS
									WHERE CODIGO_USUARIO = '$usuario'");
								oci_execute($resultado_usuario);
								while ($fila = $conexion->obtenerFila($resultado_usuario)) {
								 	echo $fila["NOMBRE"];
								 	$tipo_usuario = $fila["CODIGO_TIPO_USUARIO"];
								}
						echo'</a>';
						echo'<div class="dropdown-menu" style="margin: 9px 0 0 -40px;">';
							echo'<a class="dropdown-item" href="Perfil_usuario_empresarial.php">Ver Perfil</a>';
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
					$obtener_tipo_publicacion = $conexion->ejecutarInstruccion(" 	SELECT B.NOMBRE_TIPO_PUBLICACION
																					FROM TBL_PUBLICACION_PRODUCTOS A
																					INNER JOIN TBL_TIPO_PUBLICACION B
																					ON (A.CODIGO_TIPO_PUBLICACION = B.CODIGO_TIPO_PUBLICACION)
																					WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
					oci_execute($obtener_tipo_publicacion);
					while ($fila8 = $conexion->obtenerFila($obtener_tipo_publicacion)) {
						echo '<div><h5 class="col-lg-12" style="padding-top:30px;">Informacion del ';
							if ($fila8["NOMBRE_TIPO_PUBLICACION"] == "Producto") {
								echo 'Producto';	
							}
							else{
								echo 'Servicio';
							}
						echo '</h5></div>';
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
					  			echo '<br><br><h5><a href="Informacion_de_vendedor.php?codigo-usuario='.$fila["CODIGO_USUARIO_VENDEDOR"].'">'.$fila["NOMBRE"].' '.$fila["APELLIDO"].'</a></h5>';
					  			$codigo_usuario_vendedor = $fila["CODIGO_USUARIO_VENDEDOR"];
					  			$codigo_tipo_vendedor = $fila["CODIGO_TIPO_VENDEDOR"];
							}

							$obtener_vendedor_calificacion = $conexion->ejecutarInstruccion(" 	
								SELECT obtener_valoracion(CODIGO_USUARIO_VENDEDOR) PROMEDIO_ESTRELLAS
								FROM TBL_RANKING
								WHERE CODIGO_USUARIO_VENDEDOR = '$codigo_usuario_vendedor'");
							oci_execute($obtener_vendedor_calificacion);
							while ($fila2 = $conexion->obtenerFila($obtener_vendedor_calificacion)) {
								$promedio_estrellas = intval($fila2["PROMEDIO_ESTRELLAS"]);
							}

							echo '<br>Calificacion del Vendedor<br>';
							for ($i=1; $i <= 5 ; $i++) { 
								echo '<span class="fa fa-star ';
								  	if ($i<=$promedio_estrellas) {
								  		echo 'checked';
								  	}	
								echo'"></span>';
							}
							echo '<br>';
					  ?>  
					  	
					  <br>Compartir<br>
					  <button class="btn btn-primary"><a href="https://www.facebook.com/sharer/sharer.php?u="><img src="recursos/imagenes/Facebook.png" width="25"></a></button>
					  <button class="btn btn-warning"><a href="#"><img src="recursos/imagenes/Instagram.png" width="25"></a></button>
					  <button class="btn btn-primary"><a href="https://twitter.com/intent/tweet?text= Compra%20Vende%20facil%20y%20rapido%20desde%20tu%20hogar%20en%20cualquier%20momento&url=&hashtags=Goodshopping"><img src="recursos/imagenes/Twiter.png" width="30"></a></button><br><br>
					<?php
						if ($codigo_usuario_vendedor!=$usuario&&$tipo_usuario==2) {
							echo '<button type="submit" name="btn_denunciar" id="btn_denunciar" class="btn btn-dark">Denunciar </button>';
						}			
					?> 
					  </div>
				  </div>
				  
				  <!--Columna 2-->
				  <div class="col-sm-6 col-md-6 col-lg-4">
				  	<div> 

				  		<?php

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

							echo '<br><h6>Categoria:</h6>';
							$obtener_categoria = $conexion->ejecutarInstruccion(" 	
								SELECT A.NOMBRE_PRODUCTO, B.NOMBRE_CATEGORIA
								FROM TBL_PUBLICACION_PRODUCTOS A
								INNER JOIN TBL_CATEGORIAS B
								ON (A.CODIGO_CATEGORIA=B.CODIGO_CATEGORIA)
								WHERE A.CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
							oci_execute($obtener_categoria);
							while ($fila4 = $conexion->obtenerFila($obtener_categoria)) {
								echo $fila4["NOMBRE_CATEGORIA"];
							}

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
				  		?>
				  		
					  </div>
				  	</div>
				  </div>
					
				  <!--Columna 3-->
				  <div class="col-sm-6 col-md-6 col-lg-3 offset-lg-0"><!--Columna 3-->
	<!--scrollbar onlyread-->			  	
					<label for="cmb-categoria"><h6>Productos Destacados:<h6></label>
						<div>

							<?php

								$arreglo_codigo_publicacion =array();
								$contador = 0;

								$obtener_codigo_producto_destacado = $conexion->ejecutarInstruccion(" 	SELECT A.CODIGO_PUBLICACION_PRODUCTO, A.NOMBRE_PRODUCTO, D.NOMBRE, D.APELLIDO, C.CODIGO_USUARIO_VENDEDOR, A.PRECIO, COUNT(*) AS TOTAL
																										FROM TBL_PUBLICACION_PRODUCTOS A
																										INNER JOIN TBL_VEND_X_TBL_PUBLI B
																										ON (A.CODIGO_PUBLICACION_PRODUCTO=B.CODIGO_PUBLICACION_PRODUCTO)
																										INNER JOIN TBL_VENDEDORES C
																										ON (B.CODIGO_USUARIO_VENDEDOR=C.CODIGO_USUARIO_VENDEDOR)
																										INNER JOIN TBL_USUARIOS D
																										ON (C.CODIGO_USUARIO_VENDEDOR=D.CODIGO_USUARIO)
																										INNER JOIN TBL_PROD_X_TBL_IMG F
																										ON (A.CODIGO_PUBLICACION_PRODUCTO=F.CODIGO_PRODUCTO)
																										INNER JOIN TBL_IMAGENES G
																										ON (F.CODIGO_IMAGEN=G.CODIGO_IMAGEN)
																										WHERE A.CODIGO_TIPO_PUBLICACION = 1
																										GROUP BY (A.CODIGO_PUBLICACION_PRODUCTO, A.NOMBRE_PRODUCTO, D.NOMBRE, D.APELLIDO, C.CODIGO_USUARIO_VENDEDOR, A.PRECIO)");
								oci_execute($obtener_codigo_producto_destacado);
								while ($fila7 = $conexion->obtenerFila($obtener_codigo_producto_destacado)) {
									$arreglo_codigo_publicacion[$contador] = $fila7["CODIGO_PUBLICACION_PRODUCTO"];
									$contador++;
								}

								//$verificar = rand(0,2);
								$verificar = 1;
								//echo count($arreglo_codigo_publicacion);
								//echo $numero_aleatorio = rand(0,count($arreglo_codigo_publicacion));

								echo '<table class="table" style="width:100%">';
									echo '<thead class="thead-dark">';
									    echo '<tr>';
									      	echo '<th scope="col">Producto</th>';
									      	echo '<th scope="col">Vendedor</th>';
									      	echo '<th scope="col">Precio</th>';
									    echo '</tr>';
								 	echo '</thead>';
								$obtener_producto_destacado = $conexion->ejecutarInstruccion(" 	SELECT A.CODIGO_PUBLICACION_PRODUCTO, A.NOMBRE_PRODUCTO, D.NOMBRE, D.APELLIDO, A.PRECIO, G.RUTA_IMAGEN
																								FROM TBL_PUBLICACION_PRODUCTOS A
																								INNER JOIN TBL_VEND_X_TBL_PUBLI B
																								ON (A.CODIGO_PUBLICACION_PRODUCTO=B.CODIGO_PUBLICACION_PRODUCTO)
																								INNER JOIN TBL_VENDEDORES C
																								ON (B.CODIGO_USUARIO_VENDEDOR=C.CODIGO_USUARIO_VENDEDOR)
																								INNER JOIN TBL_USUARIOS D
																								ON (C.CODIGO_USUARIO_VENDEDOR=D.CODIGO_USUARIO)
																								INNER JOIN TBL_PROD_X_TBL_IMG F
																								ON (A.CODIGO_PUBLICACION_PRODUCTO=F.CODIGO_PRODUCTO)
																								INNER JOIN TBL_IMAGENES G
																								ON (F.CODIGO_IMAGEN=G.CODIGO_IMAGEN)
																								WHERE A.CODIGO_TIPO_PUBLICACION = 1");
								oci_execute($obtener_producto_destacado);
								while ($fila6 = $conexion->obtenerFila($obtener_producto_destacado)) {
									for ($i=0; $i <rand(0,count($arreglo_codigo_publicacion)); $i++) {
										if ($verificar <= 2) {
										 	if ($arreglo_codigo_publicacion[$i] == $fila6["CODIGO_PUBLICACION_PRODUCTO"]) {
												echo '<tbody>';
													echo '<tr>'; 
												      echo '<td><a href="#"><img src="'.$fila6["RUTA_IMAGEN"].'" style="width: 100px; height: 80px"></a></td>';
												      echo '<td><a href="#">'.$fila6["NOMBRE"].' '.$fila6["APELLIDO"].'</a></td>';
												      echo '<td>'.$fila6["PRECIO"].'</td>';
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
							echo '<div style="margin-left: 50px; margin-top: 50px">No has iniciado sesión, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' para enviar mensaje a este vendedor</div>';
						}
						else{
							if ($codigo_usuario_vendedor!=$usuario) {
								echo '<label for="txt-descripcion" style="padding-top:15px; "><h6>Mensaje:</h6></label>';
								echo'<textarea class="ex1" id="txt-mensaje" name="txt-mensaje" style="width: 100%; height: 180px;" placeholder="Escriba su mensaje aqui"></textarea>';
								echo'<input type="text" name="txt-codigo-p" id="txt-codigo-p" style="display: none;" value="'.$codigo_publicacion.'">';
								echo'<input type="text" name="txt-idVendedor" id="txt-idVendedor" style="display: none;" value="'.$codigo_usuario_vendedor.'">';
								echo'<span>';
									echo'<button type="submit" name="btn_enviar_mensaje" id="btn_enviar_mensaje" class="btn btn-success"> Enviar Mensaje</button>';
								echo'</span>';	
								echo'<div id="mensaje1" class="errores">Por favor, rellene los campos requeridos</div>';
							}
						}
					?>
				  </div>
				</div>
			</div>
		</div>
		<!-- /#page-content-wrapper -->
	</div>
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
					<button class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></button>
					<button class="btn btn-warning"><img src="recursos/imagenes/Instagram.png" width="25"></button>
					<button class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></button>
				</div>
			</div>
		</div>		
	</footer>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/controlador_enviar_mensaje.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>		
</body>
</html>

<?php
  	if(!isset($_SESSION['codigo_usuario_sesion'])){
                                                             
  	}
  	else{
  		$conexion->cerrarConexion();
  	}
?>