<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Producto</title>
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
					echo '<div class="nav-item dropdown">';
						echo '<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>';
						echo '<div class="dropdown-menu" style="margin: 9px 0 0 -40px;">';
							echo '<a class="dropdown-item" href="index.php">Iniciar Sesión</a>';
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
	<div class="d-flex" id="wrapper">
	  <!-- Sidebar -->

	    <div class="bg-light border-right" id="sidebar-wrapper">

	    	<?php
			  	if(!isset($_SESSION['codigo_usuario_sesion'])){
			  		echo '<div class="col-12 col-lg-12" style="text-align: center">';
				  		//<!--Imagen del perfil de usuario id:imagenUsuario-->
					    echo '<img src="recursos/imagenes/ImagenUsuario.png" class="rounded-circle img-fluid" 
						id="imagenUsuario" alt="Placeholder image" style="width: 100px; height: 100px; padding:10px; ">';
					  
					  	//<!--Etiqueta para el nombre del perfil de usuario-->
					  	echo '<h5>Usuario</h5>';
						//<!--ETiqueta para el correo electronico-->
						echo '<h7>correo@servidor.dominio<h7>';
						//<!--Etiqueta para el numero de telefono-->
						echo '<br>';
						echo '<h7>+504 99999999</h7>';
						echo '<br>';
						echo '<div><h6>Seleccione el perfil</h6></div>';
						echo '<form action="">';
							//<!--Combobox para seleccion de tipo de usuario  id: cmbUsuario-->
							echo '<select name="usuario" id="cmbUsuario" disabled style="width:120px;">';
								echo '<option value="1" selected="selected">Vendedor</option>';
								echo '<option value="2">Comprador</option>';
							echo '</select>';
						echo '</form>';
					echo '</div>';
		  			echo '<br>';

		  			echo '<div class="list-group list-group-flush">';
						echo '<a href="#" class="list-group-item list-group-item-action bg-light"><span><h6><i class="fas fa-shopping-bag"></i> Mis Productos</h6></span></a>'; 
						echo '<a href="#" class="list-group-item list-group-item-action bg-light"><span>
							<h6><i class="fas fa-money-bill-alt"></i> Notificaciones</h6></span></a>';
				  	echo '</div>';
				  
				    echo '<div class="sidebar-heading"><span><h6><i class="fas fa-home"> </i> Mi Tienda</h6></span></div>';
				    echo '<div class="list-group list-group-flush">';
					    echo '<div class="ml-4 col-md-10 col-11 col-lg-10">';
						    echo '<a href="Perfil_usuario_empresarial.php" class=" list-group-item-action bg-light">Editar Perfil</a>';
						    echo '<br>';
						    echo '<a href="EditarTienda.php" class=" list-group-item-action bg-light">Editar Tienda</a>';
						    echo '<br>';
						    echo '<a href="publicarProducto.php" class=" list-group-item-action bg-light">Publicar Producto</a>';
					    echo '</div>';
				    echo '</div>';
			  	}
			  	else{
			  		$imagen = " ";
			  		$resultado_usuario_imagen = $conexion->ejecutarInstruccion("	SELECT A.NOMBRE, A.APELLIDO, A.CORREO_ELECTRONICO, A.TELEFONO ,B.CODIGO_TIPO_VENDEDOR, D.CODIGO_TIPO_IMAGEN, D.RUTA_IMAGEN
																			FROM TBL_USUARIOS A
																			INNER JOIN TBL_VENDEDORES B
																			ON (A.CODIGO_USUARIO = B.CODIGO_USUARIO_VENDEDOR)
																			INNER JOIN TBL_VEND_X_TBL_IMG C
																			ON (B.CODIGO_USUARIO_VENDEDOR = C.CODIGO_USUARIO_VENDEDOR)
																			INNER JOIN TBL_IMAGENES D
																			ON (C.CODIGO_IMAGEN = D.CODIGO_IMAGEN)
																			WHERE A.CODIGO_USUARIO = '$usuario'
																			AND D.CODIGO_TIPO_IMAGEN = 1");
					oci_execute($resultado_usuario_imagen);
					while ($fila5 = $conexion->obtenerFila($resultado_usuario_imagen)) {
						$imagen = $fila5["RUTA_IMAGEN"];
					}



			  		$tipo_vendedor = "";
					$resultado_usuario = $conexion->ejecutarInstruccion("	SELECT NOMBRE, APELLIDO, CORREO_ELECTRONICO,
													 						TELEFONO ,CODIGO_TIPO_VENDEDOR
																			FROM TBL_USUARIOS
																			INNER JOIN TBL_VENDEDORES
																			ON (CODIGO_USUARIO = CODIGO_USUARIO_VENDEDOR)
																			WHERE CODIGO_USUARIO = '$usuario'");
					oci_execute($resultado_usuario);
					while ($fila = $conexion->obtenerFila($resultado_usuario)) {
						echo '<div class="col-12 col-lg-12" style="text-align: center">';
					  		//<!--Imagen del perfil de usuario id:imagenUsuario-->
						    echo '<img src="';
						    	if ($imagen == " ") {
						    		echo 'recursos/imagenes/ImagenUsuario.png';
						    	}
						    	else{
						    		echo $imagen;
						    	}
						    echo '" class="rounded-circle img-fluid" 
							id="imagenUsuario" alt="Placeholder image" style="width: 100px; height: 100px; padding:10px; ">';
						  
						  	//<!--Etiqueta para el nombre del perfil de usuario-->
						  	echo '<h5>';
						  		echo $fila["NOMBRE"]." ".$fila["APELLIDO"];
						  	echo'</h5>';
							//<!--ETiqueta para el correo electronico-->
							echo '<h7>';
								echo $fila["CORREO_ELECTRONICO"];
							echo '<h7>';
							//<!--Etiqueta para el numero de telefono-->
							echo '<br>';
							echo '<h7>+504 ';
								echo $fila["TELEFONO"];
							echo '</h7>';
							echo '<br>';
							
							$tipo_vendedor = $fila["CODIGO_TIPO_VENDEDOR"];
							
							if ($tipo_vendedor == 1) {
								echo '<div><h6>Seleccione su perfil</h6></div>';
								echo '<div class="list-group list-group-flush">';
									echo '<div class="ml-4 col-md-10 col-11 col-lg-10">';
										echo '<a href="Perfil_usuario_comprador.php" class=" list-group-item-action bg-light" style="margin-left:-39px;">comprador</a><br>';
										echo '<a href="Productos_y_servicios.php" class=" list-group-item-action bg-light" style="font-weight:bold; margin-left:-39px;">vendedor</a>';
									echo '</div>';
								echo '</div><br>';
							}
							else{
								echo '<div><h6>Vendedor empresarial</h6></div>';
							}

						echo '</div>';
			  			echo '<br>';

			  			echo '<div class="list-group list-group-flush" style="width:99.5%;">';
							echo '<a href="Productos_y_servicios.php" class="list-group-item list-group-item-action bg-light"><span><h6><i class="fas fa-shopping-bag"></i> Mis Publicaciones</h6></span></a>'; 
							echo '<a href="Notificaciones.php" class="list-group-item list-group-item-action bg-light"><span>
								<h6><i class="fas fa-money-bill-alt"></i> Notificaciones</h6></span></a>';
					  	echo '</div>';
					  	
					    echo '<div class="sidebar-heading"><span><h6><i class="fas fa-home"> </i> Mi Tienda</h6></span></div>';
					    echo '<div class="list-group list-group-flush">';
						    echo '<div class="ml-4 col-md-10 col-11 col-lg-10">';
							    
							    if ($tipo_vendedor == 1) {
							    	
							    }
							    else{
							    	echo '<a href="Perfil_usuario_empresarial.php" class=" list-group-item-action bg-light">Editar Perfil</a>';
							    	echo '<br>';
							    	echo '<a href="EditarTienda.php" class=" list-group-item-action bg-light">Editar Tienda</a>';
							    	echo '<br>';
							    }  
							    echo '<a href="publicarProducto.php" class=" list-group-item-action bg-light">Publicar Producto</a>';
						    echo '</div>';
					    echo '</div>';
					}
			  	}
			?>
	    </div>
		<!-- /#sidebar-wrapper -->
		

		<?php
			if (!isset($_SESSION['codigo_usuario_sesion'])) {			
				echo '<div style="margin-left: 50px; margin-top: 50px">No has iniciado sesión, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' para publicar tus productos</div>';
			}
			else{
				//<!-- Page Content -->
				echo '<div id="page-content-wrapper">';
					//<!--Boton para desplegar la barra lateral-->
					echo '<button type="button" id="menu-toggle" class="sidebar-btn">';
						echo '<span></span>';
						echo '<span>';
							echo '<img src="recursos/imagenes/ImagenUsuario.png" style="width: 35px; height: 35px; margin-top:-28px; margin-left: -10px;">';
						echo '</span>';
						echo '<span></span>';
					echo '</button>';

					//<!--Contenido de la pagina-->
					$codigo_publicacion = $_GET["codigo-publicacion"];

					$obtener_producto = $conexion->ejecutarInstruccion("
						SELECT CODIGO_TIPO_PUBLICACION,CODIGO_TIPO_MONEDA,CODIGO_ESTADO_PRODUCTO,
						CODIGO_CATEGORIA,NOMBRE_PRODUCTO,PRECIO,DESCIPCION FROM TBL_PUBLICACION_PRODUCTOS
						WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
					oci_execute($obtener_producto);

					while ($fila = $conexion->obtenerFila($obtener_producto)) {
						$tipo_publicacion = $fila["CODIGO_TIPO_PUBLICACION"];
						$tipo_moneda = $fila["CODIGO_TIPO_MONEDA"];
						$categoria = $fila["CODIGO_CATEGORIA"];
						$nombre = $fila["NOMBRE_PRODUCTO"];
						$precio = $fila["PRECIO"];
						$descripcion = $fila["DESCIPCION"];
						if ($tipo_publicacion == 1) {
							$estado = $fila["CODIGO_ESTADO_PRODUCTO"];
						}
					}

					echo '<div class="container" style="text-align: center; border-bottom: medium">';
						echo '<div><h5 class="col-lg-12" style="padding-top:30px;">';

					if ($tipo_publicacion == 1) {
						echo 'Editar Producto';
					} else {
						echo 'Editar Servicio';
					}

					echo '</h5></div></div>';


					echo '<br>';
					echo '<div class="container-fluid">';
						echo '<div class="row">';
						  	echo '<div class="col-lg-5 col-md-6 col-sm-6">';
								  echo '<div class="form-group " style="width: 100%; padding: 10px;">';
									  //<!--Combobox para seleccion de tipo de producto  id: cmbProducto-->
									echo '<select name="slc-tipo-publicacion" id="slc-tipo-publicacion" style="width:100%; height: 40px;" disabled>';
									if ($tipo_publicacion == 1) {
										echo '<option value="1">Producto</option>';
									} else {
										echo '<option value="2">Servicio</option>';
									}
									echo '</select>';
								  echo '</div>';
							echo '</div>';

							//<!--Textbox nombre del producto id: txt-nombreProducto-->
						  	echo '<div class="col-md-6 col-lg-7 col-sm-6">';
							  echo '<div class="form-group" style="width: 100%; padding: 10px;">';
							  	echo '<input id="codigo-publicacion" style="display:none" type="text" value="'.$codigo_publicacion.'">';
								echo '<input id="txt-nombreProducto" name="txt-nombreProducto" type="text" class="form-control" placeholder="Nombre del Producto o Servicio" value="'.$nombre.'">';
								echo '<div id="mensaje1" class="errores">*Nombre obligatorio</div>';
							  echo '</div>';
							echo '</div>';
						echo '</div>';

						echo '<div class="row">';

						$obtener_imagenes = $conexion->ejecutarInstruccion("
							SELECT A.RUTA_IMAGEN FROM TBL_IMAGENES A
							INNER JOIN TBL_PROD_X_TBL_IMG B
							ON A.CODIGO_IMAGEN = B.CODIGO_IMAGEN
							WHERE B.CODIGO_PRODUCTO = '$codigo_publicacion'");
						oci_execute($obtener_imagenes);

						//<!-- CARROUSEL DE IMAGENES -->
						  echo '<div class="col-md-6 col-lg-5 col-sm-6 offset-lg-0">';
							  echo '<div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="width:100%; height: 200px">';
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
							  echo '<div>';
							  	echo '<input type="file" id="btn_subir_foto" name="btn_subir_foto" class="btn file-loading" accept="image/*" disabled>';
							  	echo '<div style="margin-left: 10px"><b id="agregadas">Imágenes agregadas: '.$activo.'/5</b></div>';
							  	echo '<div id="mensaje3" class="errores" style="margin:0">*Debe subir al menos 1 imagen</div>';
							  	echo '<button type="submit" id="btn_cambiar_imagenes" class="btn btn-danger" style="margin-left:10px">Cambiar imágenes</button>';
							  echo '</div>';	  
						  echo '</div>';

						  echo '<div class="col-sm-6 col-md-6 col-lg-7">';
							echo '<div class="form-group" style="width: 100%; padding: 10px;">';
								echo '<label style="margin-right: 57px"><h6>Tipo de moneda:</h6></label>';

								if ($tipo_moneda==1) {
									echo '<label style="margin-right: 20px"><input type="radio" name="moneda" id="rbt-moneda" value="1" checked> Lempiras</label>';
									echo '<label><input type="radio" name="moneda" id="rbt-moneda" value="2"> Dolares</label>';
								} else {
									echo '<label style="margin-right: 20px"><input type="radio" name="moneda" id="rbt-moneda" value="1"> Lempiras</label>';
									echo '<label><input type="radio" name="moneda" id="rbt-moneda" value="2" checked> Dolares</label>';
								}

								echo '<input id="txt-precioProducto" name="txt-precioProducto" type="number" class="form-control" value="'.$precio.'" placeholder="Precio: ej. 3500">';
								echo '<div id="mensaje2" class="errores">*Precio obligatorio</div><br>';
								
								if ($tipo_publicacion == 1) {

									//PRODUCTOS
									echo '<div id="div-productos" style="display:block">';
									echo '<label style="margin-right: 30px"><h6>Estado del producto:</h6></label>';
									if ($estado == 1) {
										echo '<label style="margin-right: 37px"><input type="radio" name="estadoProducto" id="rbt-estado" value="1" checked> Nuevo</label>';
										echo '<label><input type="radio" name="estadoProducto" id="rbt-estado" value="2"> Usado</label>';
									} else {
										echo '<label style="margin-right: 37px"><input type="radio" name="estadoProducto" id="rbt-estado" value="1"> Nuevo</label>';
										echo '<label><input type="radio" name="estadoProducto" id="rbt-estado" value="2" checked> Usado</label>';
									}
									
									//<!--Combobox para seleccion de categoria de producto  id: cmb-categoria-->
									echo '<br>';
									echo '<label for="cmb-categoria"><h6>Seleccione una Categoría:</h6></label>';
									echo '<select name="slc-categoria" id="slc-categoria" style="width:100%; height: 40px;">';

									$codigo_categoria = array();
									$nombre_categoria = array();
									$cont = 1;
									$obtener_categorias = $conexion->ejecutarInstruccion("	
										SELECT CODIGO_CATEGORIA,NOMBRE_CATEGORIA
										FROM TBL_CATEGORIAS");
									oci_execute($obtener_categorias);
									while ($filacategorias = $conexion->obtenerFila($obtener_categorias)) {
										$codigo_categoria[$cont] = $filacategorias["CODIGO_CATEGORIA"];
										$nombre_categoria[$cont] = $filacategorias["NOMBRE_CATEGORIA"];
										$cont++;
									}

									for ($i=1; $i <= count($codigo_categoria) ; $i++) { 
										echo '<option value="'.$codigo_categoria[$i].'" ';
										if ($categoria == $codigo_categoria[$i]) {
											echo 'selected';
										}
										echo '>'.$nombre_categoria[$i].'</option>';
									}
									echo '</select><br><br>';

									//<!--Subcategorias-->
									$codigo_subcategoria = array();
									$nombre_subcategoria = array();
									$cont = 1;
									$obtener_subcategorias = $conexion->ejecutarInstruccion("	
										SELECT A.CODIGO_SUB_CATEGORIA,A.NOMBRE_SUB_CATEGORIA 
										FROM TBL_SUB_CATEGORIAS A
										INNER JOIN TBL_CATEGO_X_tBL_SUBCATEGO B
										ON A.CODIGO_SUB_CATEGORIA = B.CODIGO_SUB_CATEGORIA
										WHERE B.CODIGO_CATEGORIA = '$categoria'");
									oci_execute($obtener_subcategorias);
									while ($fila = $conexion->obtenerFila($obtener_subcategorias)) {
										$codigo_subcategoria[$cont] = $fila["CODIGO_SUB_CATEGORIA"];
										$nombre_subcategoria[$cont] = $fila["NOMBRE_SUB_CATEGORIA"];
										$cont++;
									}

									$codigo_subcategoria_producto = array();
									$cont = 1;
									$obtener_subcategorias_producto = $conexion->ejecutarInstruccion("	
										SELECT CODIGO_SUB_CATEGORIA FROM TBL_PRODU_X_TBL_CATEGO
										WHERE CODIGO_PRODUCTO = '$codigo_publicacion'");
									oci_execute($obtener_subcategorias_producto);
									while ($fila = $conexion->obtenerFila($obtener_subcategorias_producto)) {
										$codigo_subcategoria_producto[$cont] = $fila["CODIGO_SUB_CATEGORIA"];
										$cont++;
									}

									echo '<label for="cmb-categoria"><h6>Seleccione Subcategorías:</h6></label><br>';
									echo '<div id="div-subcategorias">';
									for ($i=1; $i <= count($codigo_subcategoria) ; $i++) { 
										echo '<label><input type="checkbox" id="chk-subcategorias[]" name="chk-subcategorias[]" class="thirdparty" value="'.$codigo_subcategoria[$i].'" ';
										for ($j=1; $j <= count($codigo_subcategoria_producto) ; $j++) { 
											if ($codigo_subcategoria_producto[$j]==$codigo_subcategoria[$i]) {
											echo 'checked';
											}
										}
										echo '> '.$nombre_subcategoria[$i].'</label><br>';
									}

									echo '</div>';
									echo '</div>';//fin del div de productos

								} else {

									//SERVICIOS
									echo '<div id="div-servicios" style="display:block">';
									echo '<label><h6>Servicios al que pertenece:</h6></label>';
									echo '<div id="mensaje5" class="errores">*Seleccione al menos un servicio</div><br>';
									$codigos_servicios = array();
								    $nombres_servicios = array();
								    $cont = 1;

									$obtener_servicios = $conexion->ejecutarInstruccion("	
										SELECT CODIGO_SERVICIO,NOMBRE_SERVICIO
										FROM TBL_SERVICIOS");
									oci_execute($obtener_servicios);
									while ($fila = $conexion->obtenerFila($obtener_servicios)) {
										$codigos_servicios[$cont] = $fila["CODIGO_SERVICIO"];
										$nombres_servicios[$cont] = $fila["NOMBRE_SERVICIO"];
										$cont++;
									}

									$codigos_servicios_producto = array();
								    $cont = 1;

									$obtener_servicios_producto = $conexion->ejecutarInstruccion("	
										SELECT CODIGO_SERVICIO FROM TBL_PUBLIC_X_TBL_SERV
										WHERE CODIGO_PUBLICACION_PRODUCTO = '$codigo_publicacion'");
									oci_execute($obtener_servicios_producto);
									while ($fila = $conexion->obtenerFila($obtener_servicios_producto)) {
										$codigos_servicios_producto[$cont] = $fila["CODIGO_SERVICIO"];
										$cont++;
									}

									for ($i=1; $i <= count($codigos_servicios) ; $i++) { 
										echo '<label><input type="checkbox" id="chk-servicios[]" name="chk-servicios[]" class="thirdparty" value="'.$codigos_servicios[$i].'" ';
										for ($j=1; $j <= count($codigos_servicios_producto) ; $j++) { 
											if ($codigos_servicios_producto[$j]==$codigos_servicios[$i]) {
												echo 'checked';
											}
										}		
										echo '> '.$nombres_servicios[$i].'</label><br>';						
									}	
									echo '</div>';//Fin del div de servicios

								}

								echo '<label for="txt-descripcion" style="padding-top:15px; "><h6>Descripción del Producto o Servicio:</h6></label>';
								echo '<textarea id="txt-descripcion" name="txt-descripcion" class="form-control" style="width: 100%; height: 180px;" placeholder="Ingrese la descripción detallada de su producto o servicio.">'.$descripcion.'</textarea>
									  <div id="mensaje4" class="errores">*Se requiere de una descripción (menor a 500 caracteres).</div>';

								echo '<div class="container-fluid" style="padding-top: 20px">';
									echo '<span>';

										echo '<button type="submit" id="btn_editar" name="btn_editar" class="btn btn-success" style="margin-left: -15px;">';
										if ($tipo_publicacion == 1) {
											echo 'Editar producto</button>';
										} else {
											echo 'Editar servicio</button>';
										}
										echo '<button type="submit" id="btn_cancelar" name="btn_cancelar" class="btn btn-danger" style="margin-left:10px">Cancelar</button>';
									echo '</span>';
								echo '</div>';
							  echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			}
		?>
		<!-- /#page-content-wrapper -->
		
	</div>
	<!-- /#wrapper -->
	  
	<!--Pie de página-->
	<footer id="footer" style="background: #fff; margin-top:0px; width:100%;">
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
	<script src="js/controlador_productos_servicios.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="js/bootstrap.min.js"></script>
		
  <!--Boton para desplegar la barra lateral-->		
  <script type="text/javascript">
        $(document).ready(function () {
            $("#menu-toggle").on('click', function () {
                $("#wrapper").toggleClass("toggled");
                $(this).toggleClass('active');
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
