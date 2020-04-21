<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis Productos</title>
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
						    echo '<img src="recursos/imagenes/ImagenUsuario.png" class="rounded-circle img-fluid" 
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
							echo '<div><h6>Seleccione el perfil</h6></div>';
							echo '<form action="">';
								//<!--Combobox para seleccion de tipo de usuario  id: cmbUsuario-->
								echo '<select name="usuario" id="cmbUsuario" style="width:120px;">';
									echo '<option value="1" selected="selected">Vendedor</option>';
									echo '<option value="2">Comprador</option>';
								echo '</select>';
							echo '</form>';
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
							    echo '<a href="Perfil_usuario_empresarial.php" class=" list-group-item-action bg-light">Editar Perfil</a>';
							    echo '<br>';
							    $tipo_vendedor = $fila["CODIGO_TIPO_VENDEDOR"];
							    if ($tipo_vendedor == 1) {
							    	
							    }
							    else{
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

					//<!--Contenido de la pagina-->
					$codigo_publicacion = array();
					$codigo_tipo_publicacion = array();
					$nombre_estado = array();
					$nombre_producto = array();
					$fecha_publicacion = array();
					$cont = 1;
					$obtener_productos = $conexion->ejecutarInstruccion("
						SELECT A.CODIGO_PUBLICACION_PRODUCTO,A.CODIGO_TIPO_PUBLICACION,B.NOMBRE_ESTADO_PUBLICACION,
						A.NOMBRE_PRODUCTO,LOWER(TO_CHAR(A.FECHA_PUBLICACION,'DD/MONTH/YYYY')) AS FECHA
						FROM TBL_PUBLICACION_PRODUCTOS A
						INNER JOIN TBL_ESTADO_PUBLICACION B
						ON A.CODIGO_ESTADO_PUBLICACION = B.CODIGO_ESTADO_PUBLICACION
						INNER JOIN TBL_VEND_X_TBL_PUBLI C
						ON A.CODIGO_PUBLICACION_PRODUCTO = C.CODIGO_PUBLICACION_PRODUCTO
						WHERE C.CODIGO_USUARIO_VENDEDOR = '$usuario'
						ORDER BY A.CODIGO_PUBLICACION_PRODUCTO ASC");
					oci_execute($obtener_productos);

					while ($fila = $conexion->obtenerFila($obtener_productos)) {
						$codigo_publicacion[$cont] = $fila["CODIGO_PUBLICACION_PRODUCTO"];
						$codigo_tipo_publicacion[$cont] = $fila["CODIGO_TIPO_PUBLICACION"];
						$nombre_estado[$cont] = $fila["NOMBRE_ESTADO_PUBLICACION"];
						$nombre_producto[$cont] = $fila["NOMBRE_PRODUCTO"];
						$fecha_publicacion[$cont] = $fila["FECHA"];
						$cont++;
					}

					echo '<div class="container" style="padding: 30px">';
						echo '<center><div><h5 class="col-lg-12">Mis Productos</h5></div>';

						//TABLA DE PRODUCTOS
						echo '<table class="table" style="width:95%">
								<thead class="thead-dark">
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Nombre del producto</th>
							      <th scope="col">Fecha de publicación</th>
							      <th scope="col">Estado</th>
							      <th scope="col">Solicitud</th>
							      <th scope="col">Acción</th>
							    </tr>
							  </thead>
							  <tbody>';

						$cantidad = 1;
						for ($i=1; $i <= count($codigo_publicacion) ; $i++) { 					
							if ($codigo_tipo_publicacion[$i]==1 && $nombre_estado[$i]!="Eliminado") {
								echo '<tr>
								      <th scope="row">'.$cantidad.'</th>
								      <td><a href="infodeProductos.php?codigo-publicacion='.$codigo_publicacion[$i].'" style="color:black">'.$nombre_producto[$i].'</a></td>
								      <td>'.$fecha_publicacion[$i].'</td>
								      <td>'.$nombre_estado[$i].'</td>
								      <td style="padding-left:2px;padding-right: 2px">
								      	<select id="slc-solicitud-'.$codigo_publicacion[$i].'">
								      		<option value="0" selected="selected">--Seleccione--</option>';

								      		if ($nombre_estado[$i]=="Vendido") {
								      			echo '<option value="3">Eliminar</option>';
								      		} else {
								      			echo '<option value="1">Vendido</option>
													<option value="2">Modificar</option>
													<option value="3">Eliminar</option>';
								      		}
								echo	'</select>
									  </td>
								      <td style="padding-left:2px;padding-right: 2px">
								      	<button type="button" onclick="enviar('.$codigo_publicacion[$i].')" name="slc-solicitud-'.$codigo_publicacion[$i].'" class="btn btn-success" style="margin:0" disabled>Enviar</button>
								      </td>
								    </tr>';
								$cantidad++;
							}
						}

						echo '</tbody>
							</table>';

						if ($cantidad == 1) {
							echo 'No tiene servicios publicados actualmente... Empiece a <a href="publicarProducto.php">Publicar Producto</a><br><br>';
						}
						echo '</center>';

						echo '<center><div><h5 class="col-lg-12">Mis Servicios</h5></div>';

						//TABLA DE SERVICIOS
						echo '<table class="table" style="width:95%">
								<thead class="thead-dark">
							    <tr>
							      <th scope="col">#</th>
							      <th scope="col">Nombre del servicio</th>
							      <th scope="col">Fecha de publicación</th>
							      <th scope="col">Estado</th>
							      <th scope="col">Solicitud</th>
							      <th scope="col">Acción</th>
							    </tr>
							  </thead>
							  <tbody>';

						$cantidad = 1;
						for ($i=1; $i <= count($codigo_publicacion) ; $i++) { 					
							if ($codigo_tipo_publicacion[$i]==2 && $nombre_estado[$i]!="Eliminado") {
								echo '<tr>
								      <th scope="row">'.$cantidad.'</th>
								      <td><a href="infodeProductos.php?codigo-publicacion='.$codigo_publicacion[$i].'" style="color:black">'.$nombre_producto[$i].'</a></td>
								      <td>'.$fecha_publicacion[$i].'</td>
								      <td>'.$nombre_estado[$i].'</td>
								      <td style="padding-left:2px;padding-right: 2px">
								      	<select id="slc-solicitud-'.$codigo_publicacion[$i].'">
								      		<option value="0" selected="selected">--Seleccione--</option>';

								      		if ($nombre_estado[$i]=="Vendido") {
								      			echo '<option value="3">Eliminar</option>';
								      		} else {
								      			echo '<option value="1">Vendido</option>
													<option value="2">Modificar</option>
													<option value="3">Eliminar</option>';
								      		}
								echo	'</select>
									  </td>
								      <td style="padding-left:2px;padding-right: 2px">
								      	<button type="button" onclick="enviar('.$codigo_publicacion[$i].')" name="slc-solicitud-'.$codigo_publicacion[$i].'" class="btn btn-success" style="margin:0" disabled>Enviar</button>
								      </td>
								    </tr>';
								$cantidad++;
							}
						}

						echo '</tbody>
							</table>';

						if ($cantidad == 1) {
							echo 'No tiene servicios publicados actualmente... Empiece a <a href="publicarProducto.php">Publicar Servicio</a><br><br>';
						}
						echo '</center>';

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
					<a href="https://www.facebook.com" class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></a>
					<a href="https://pinterest.com" class="btn btn-danger"><img src="recursos/imagenes/pinterest.png" width="25"></a>
					<a href="https://twitter.com" class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></a>
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
