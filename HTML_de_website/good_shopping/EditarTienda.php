<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Tienda</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/estilo2.css" rel="stylesheet">
	
	<link rel="icon" type="image/jpg" href="recursos/imagenes/Logo.png">
	<link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />

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

		  			echo '<div class="list-group list-group-flush" style="width:99.5%;">';
						echo '<a href="Productos_y_servicios.php" class="list-group-item list-group-item-action bg-light"><span><h6><i class="fas fa-shopping-bag"></i> Mis Publicaciones</h6></span></a>'; 
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
										echo '<a href="Perfil_usuario_comprador.php" class=" list-group-item-action bg-light">comprador</a><br>';
										echo '<a href="Productos_y_servicios.php" class=" list-group-item-action bg-light">vendedor</a>';
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
				echo '<div style="margin-left: 50px; margin-top: 50px">No has iniciado sesión, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' para editar tu Tienda</div>';
			}
			else{

				$resultado_usuario = $conexion->ejecutarInstruccion("	SELECT B.CODIGO_TIENDA, C.NOMBRE_TIENDA, C.TELEFONO_TIENDA, 
																		C.CORREO_TIENDA, C.DIRECCION_FISICA_TIENDA, C.DESCRIPCION_TIENDA
																		FROM TBL_USUARIOS A
																		INNER JOIN TBL_VENDEDORES B
																		ON (A.CODIGO_USUARIO = B.CODIGO_USUARIO_VENDEDOR)
																		INNER JOIN TBL_TIENDAS C
																		ON (B.CODIGO_TIENDA = C.CODIGO_TIENDA)
																		WHERE A.CODIGO_USUARIO = '$usuario'");
				oci_execute($resultado_usuario);
				while ($fila = $conexion->obtenerFila($resultado_usuario)) {
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
					    //<!-- Baner de la empresa-->	
						echo '<div class="container" style="text-align: center; border-bottom: medium;padding-top: 2%">';

						$ruta_imagen_banner = "img/banner.jpg";

			     		$obtiene_banner = $conexion->ejecutarInstruccion("	
							SELECT B.RUTA_IMAGEN FROM TBL_VEND_X_TBL_IMG A
							INNER JOIN TBL_IMAGENES B
							ON A.CODIGO_IMAGEN = B.CODIGO_IMAGEN
							WHERE A.CODIGO_USUARIO_VENDEDOR = '$usuario'
							AND B.CODIGO_TIPO_IMAGEN = 2");
						oci_execute($obtiene_banner);

						while ($filabanner = $conexion->obtenerFila($obtiene_banner)) {
							$ruta_imagen_banner = $filabanner["RUTA_IMAGEN"];
						} 

							echo '<center><div id="previewbanner"><img src="'.$ruta_imagen_banner.'" style="padding-bottom: 1%;padding-right: 1%;" class="img-fluid"></div></center>';
							echo '<a id="btn-banner" href="" type="file" class="list-group-item-action bg-light" style="margin-left:650px">Cambiar banner</a>';
							echo 	'<form id="file-submit" enctype="multipart/form-data" style="display:none">
									    <input id="banner" name="banner" type="file" accept="image/*"/>
									</form>';

							echo '<div><h5 style="padding-right: 14%; " class="col-lg-12">Editar Tienda</h5></div>';
						echo '</div>';
						//<!-- logo de la empresa -->
						echo '<div class="container-fluid">';
							echo '<div class="row">';
							  echo '<div class="col-lg-5 col-md-6 col-sm-6">';
									 
								echo '<div class="col-md-6 col-lg-5 col-sm-6">';
								  
			     					echo '<br>Logo de la empresa';

			     					$ruta_imagen = "img/cuadrada.png";

			     					$obtiene_logo = $conexion->ejecutarInstruccion("	
										SELECT B.RUTA_IMAGEN FROM TBL_VEND_X_TBL_IMG A
										INNER JOIN TBL_IMAGENES B
										ON A.CODIGO_IMAGEN = B.CODIGO_IMAGEN
										WHERE A.CODIGO_USUARIO_VENDEDOR = '$usuario'
										AND B.CODIGO_TIPO_IMAGEN = 1");
									oci_execute($obtiene_logo);

									while ($filalogo = $conexion->obtenerFila($obtiene_logo)) {
										 $ruta_imagen = $filalogo["RUTA_IMAGEN"];
									} 

									echo '<div id="preview"><img src="'.$ruta_imagen.'" class="img-fluid img-thumbnail"></div>';   				
									   echo '</div>';
								           echo '<input type="file" id="btn-logo" name="btn-logo" class="btn file-loading" accept="image/*">';
								       echo '</div>';
									   
								//<!--Textbox datos de la tienda-->
								echo '<div class= "row">';
									
								echo '</div>';
							  echo '<div class="col-md-6 col-lg-7 col-sm-6">';
								  echo '<div style= "text-align:left" ></style>';
			     					
			     					echo '<br><br>';
			     					echo '<input style="width: 50%;" type="text" class="form-control" id="txt-nombre-tienda" name="signup_form[displayname]" required="required" maxlength="100" value="'.$fila["NOMBRE_TIENDA"].'">';
			     						echo '<div id="mensaje22" class="errores">Ingrese el nombre de la tienda</div>';
			     					echo '<br>';
			     					echo '<input style="width: 50%;" type="text" class="form-control" id="txt-correo-tienda" name="signup_form[displayname]" required="required" maxlength="100"';
			     						if (!isset($fila["CORREO_TIENDA"])) {
			     							echo 'placeholder="Correo electronico de la tienda"';
			     							//echo 'value="'.NULL.'"';
			     						}
			     						else{
			     							echo 'value="'.$fila["CORREO_TIENDA"].'"';
			     						}
			     					echo '>';
			     					echo '<div id="mensaje25" class="errores">Ingrese un correo electronico valido</div>';
			     					echo '<div id="mensaje26" class="errores">El correo ya existe.</div>';
			     					echo '<br>';
			     					echo '<input style="width: 50%;" type="number" class="form-control" id="txt-telefono-tienda" name="signup_form[displayname]" required="required" maxlength="100"';
			     					 	if (!isset($fila["TELEFONO_TIENDA"])) {
			     							echo 'placeholder="Telefono de la tienda"';
			     							//echo 'value="'.NULL.'"';
			     						}
			     						else{
			     							echo 'value="'.$fila["TELEFONO_TIENDA"].'"';
			     						}
			     					echo '>';
			     					echo '<div id="mensaje23" class="errores">Ingrese un numero de telefono</div>';
			     					echo '<br>';
			     					echo '<input style="width: 50%;" type="text" class="form-control" id="txt-direccion-tienda" name="signup_form[displayname]" required="required" maxlength="100"';
			     						if (!isset($fila["DIRECCION_FISICA_TIENDA"])) {
			     							echo 'placeholder="Direccion fisica de la tienda"';
			     							//echo 'value="'.NULL.'"';
			     						}
			     						else{
			     							echo 'value="'.$fila["DIRECCION_FISICA_TIENDA"].'"';
			     						}
			     					echo '>';
			     					echo '<div id="mensaje24" class="errores">Ingrese una direccion</div>';
			     					echo '<br>';
			     					echo '<div style= "text-align:left" ></style>';
			     						//<!--checkbox de servicios ofrecidos-->
			    } 	
			    					


			    $codigos_servicios = array();
			    $nombres_servicios = array();
			    $servicios_usuario = array();
			    $contcodigos = 1;
			    $contnombres = 1;
			    $contusuario = 1;

			    echo 'Servicios Ofrecidos:<br>';

				$obtener_servicios = $conexion->ejecutarInstruccion("	
															SELECT CODIGO_SERVICIO,NOMBRE_SERVICIO
															FROM TBL_SERVICIOS");
				oci_execute($obtener_servicios);
				while ($fila = $conexion->obtenerFila($obtener_servicios)) {
					$codigos_servicios[$contcodigos++] = $fila["CODIGO_SERVICIO"];
					$nombres_servicios[$contnombres++] = $fila["NOMBRE_SERVICIO"];
				}


				$usuario_x_servicios = $conexion->ejecutarInstruccion("	
										     							SELECT A.CODIGO_USUARIO, D.CODIGO_SERVICIO
																		FROM TBL_USUARIOS A
																		INNER JOIN TBL_VENDEDORES B
																		ON (A.CODIGO_USUARIO = B.CODIGO_USUARIO_VENDEDOR)
																		INNER JOIN TBL_VEND_X_TBL_SERV C
																		ON (B.CODIGO_USUARIO_VENDEDOR = C.CODIGO_USUARIO_VENDEDOR)
																		INNER JOIN TBL_SERVICIOS D
																		ON (C.CODIGO_SERVICIO = D.CODIGO_SERVICIO)
																		WHERE CODIGO_USUARIO = '$usuario'");
				oci_execute($usuario_x_servicios);
				while ($fila = $conexion->obtenerFila($usuario_x_servicios)) {
					$servicios_usuario[$contusuario++] = $fila["CODIGO_SERVICIO"];
				}

				for ($i=1; $i <= count($codigos_servicios) ; $i++) { 
												
					echo '<input type="checkbox" id="chk-servicios[]" name="chk-servicios[]" class="thirdparty" value="'.$codigos_servicios[$i].'"';

					for ($j=1; $j <= count($servicios_usuario) ; $j++) { 
						if ($codigos_servicios[$i] == $servicios_usuario[$j]) {
							echo " checked";
						}	
					}

					echo '> '.$nombres_servicios[$i].' <br>';
															
					if ($i == count($codigos_servicios)) {
						echo '<br>';
					}							
				}	
										


				$resultado_usuario = $conexion->ejecutarInstruccion("	SELECT B.CODIGO_TIENDA, C.NOMBRE_TIENDA, C.TELEFONO_TIENDA, 
																		C.CORREO_TIENDA, C.DIRECCION_FISICA_TIENDA, C.DESCRIPCION_TIENDA
																		FROM TBL_USUARIOS A
																		INNER JOIN TBL_VENDEDORES B
																		ON (A.CODIGO_USUARIO = B.CODIGO_USUARIO_VENDEDOR)
																		INNER JOIN TBL_TIENDAS C
																		ON (B.CODIGO_TIENDA = C.CODIGO_TIENDA)
																		WHERE A.CODIGO_USUARIO = '$usuario'");
				oci_execute($resultado_usuario);
				while ($fila = $conexion->obtenerFila($resultado_usuario)) {							
									echo 'Descripcion<br>';
									echo '</div>';
									echo '<div class="row">';
											echo '</select>';
											//<!-- descripcion-->
											echo '<label for="txt-descripcion" style="padding-top:15px; "><h6></h6></label>';
											echo '<textarea id="txt-descripcion" class="form-control" name="txt-descripcion" style="width: 100%; height: 180px;"';
												if (!isset($fila["DESCRIPCION_TIENDA"])) {
					     							echo 'placeholder="Ingrese una descripcion."';
					     							echo '>';
					     						}
					     						else{
					     							echo '>';
					     							echo $fila["DESCRIPCION_TIENDA"];
					     						}
											echo'</textarea>';
											echo '<div id="errorDescripcion" class="errores">La descripción no debe ser mayor a 500 caracteres.</div>';

											echo '<div class="container-fluid" style="padding: 20px">';
												echo '<span>';
													echo '<button type="submit" id="editar_tienda" name="editar_tienda" class="btn btn-success" disabled>Guardar Cambios</button>';
												echo '</span>';
											echo '</div>';
									echo '</div>';
								
								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			}
		?>
		


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
					<a href="#" style="color: black;">
						<span>
							Soporte técnico
						</span>
					</a>
				</div>

				<div class="col-xs-2  col-md-7 col-sm-5 col-lg-3" style="text-align:center; padding-left: 5%;">
					<br>
					<h6>Siguenos en</h6>
					<a href="https://www.facebook.com/Good-Shopping-106040207755389/?modal=admin_todo_tour" class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></a>
					<a href="https://www.pinterest.ca/GoodShoppingHn504/" class="btn btn-danger"><img src="recursos/imagenes/pinterest.png" width="25"></a>
					<a href="https://twitter.com/GoodShopping7" class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></a>
				</div>
			</div>
		</div>		
	</footer>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/controlador_editarTienda.js"></script>
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