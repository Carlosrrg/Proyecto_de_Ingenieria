<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Notificaciones</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/estilo2.css" rel="stylesheet">
	<link rel="icon" type="image/jpg" href="recursos/imagenes/Logo.png">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" 
		integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
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

			  			echo '<div class="list-group list-group-flush">';
			  				
			  				echo '<a href="Productos_y_servicios.php" class="list-group-item list-group-item-action bg-light"><span><h6><i class="fas fa-shopping-bag"></i> Mis Productos</h6></span></a>'; 
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
				echo '<div style="margin-left: 50px; margin-top: 50px">No has iniciado sesión, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' para ver tus Productos y Servicios.</div>';
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

					

					echo '<div class="container" style="padding: 30px">';
						echo '<center><div><h5 class="col-lg-12">Mis Notificaciones</h5></div>';
						echo '<br>';
						//TABLA DE PRODUCTOS
						echo '<table class="table" style="width:95%">
								<thead class="thead-dark">
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Usuario</th>
							      <th scope="col">Contactos</th>
							      <th scope="col">Fecha recibido</th>
							      <th scope="col">Mensaje</th>
							      <th scope="col">Publicacion</th>
							      <th scope="col">Acción</th>
							    </tr>
							  </thead>
							  <tbody>';

							  	$conteo = 1;

							  	$resultado_mensajes = $conexion->ejecutarInstruccion("	SELECT A.CODIGO_MENSAJE, C.CODIGO_USUARIO, C.NOMBRE, C.APELLIDO, C.CORREO_ELECTRONICO, C.TELEFONO, A.FECHA_ENVIO, A.MENSAJE, A.CODIGO_PUBLICACION, A.NOMBRE_PUBLICACION
																						FROM TBL_MENSAJES A
																						INNER JOIN TBL_COMPRADORES B
																						ON (A.CODIGO_USUARIO_COMPRADOR = B.CODIGO_USUARIO_COMPRADOR)
																						INNER JOIN TBL_USUARIOS C
																						ON (C.CODIGO_USUARIO = B.CODIGO_USUARIO_COMPRADOR)
																						WHERE CODIGO_USUARIO_VENDEDOR = '$usuario'
																						ORDER BY (A.CODIGO_MENSAJE)");
								oci_execute($resultado_mensajes);
								while ($fila2 = $conexion->obtenerFila($resultado_mensajes)) {
									echo '<tr>
									      <th scope="row">'.$conteo.'</th>
									      <td>'.$fila2["NOMBRE"].' '.$fila2["APELLIDO"].'</td>
									      <td>'.$fila2["CORREO_ELECTRONICO"].'<br>+504 '.$fila2["TELEFONO"].'</td>
									      <td>'.$fila2["FECHA_ENVIO"].'</td>
									      <td style="padding-left:2px;padding-right: 2px">';
									echo '<p>'.$fila2["MENSAJE"].'</p>';
									      		
									echo  '
										  </td>
										  <td><a href="infodeProductos.php?codigo-publicacion='.$fila2["CODIGO_PUBLICACION"].'">'.$fila2["NOMBRE_PUBLICACION"].'</a></td>
									      <td style="padding-left:2px;padding-right: 2px">
									      	<a class="btn btn-success" href="Responder_mensaje.php?codigo-usuario-comprador='.$fila2["CODIGO_USUARIO"].'&codigo-publicacion='.$fila2["CODIGO_PUBLICACION"].'" style="margin:0" >Responder</a>
									      </td>
								    </tr>';
								    $conteo++;
								}
						
						echo '</tbody>
							</table>';
						echo '</center>';
						echo '</tbody>
							</table>';

					echo '</div>';

				echo '</div><br>';
			}
		?>
			<!-- /#Modal de Vendido -->
			<button type="button" id="btn-vendido" style="display: none" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-sm"></button>

			<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content">
			      <div class="modal-body">
			        <center><p>¿Seguro que ya vendió éste producto/servicio?</p></center>
			        <center>
			        	<button class="btn btn-success" id="btn-vendido-si">Sí</button>
			        	<button class="btn btn-danger" id="btn-vendido-no">No</button>
			        </center>
			        <button type="button" id="btn-cerrar-vendido" class="close" data-dismiss="modal" aria-label="Close" style="display: none">
			      </div>
			    </div>
			  </div>
			</div>

			<!-- /#Link a enviar para eliminar producto -->
			<div id="div-eliminar"></div>
			<!-- /#Link a enviar para editar producto -->
			<div id="div-editar"></div>

		</div>

	  
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
					<a href="https://www.facebook.com/Good-Shopping-106040207755389/?modal=admin_todo_tour" class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></a>
					<a href="https://www.pinterest.ca/GoodShoppingHn504/" class="btn btn-danger"><img src="recursos/imagenes/pinterest.png" width="25"></a>
					<a href="https://twitter.com/GoodShopping7" class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></a>
				</div>
			</div>
		</div>		
	</footer>


	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/"></script>
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
