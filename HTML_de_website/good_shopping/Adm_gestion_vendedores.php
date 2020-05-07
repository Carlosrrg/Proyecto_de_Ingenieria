<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestionar Vendedores</title>
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
							echo'<a class="dropdown-item" href="index.php">Inicio</a>';
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
					$resultado_usuario = $conexion->ejecutarInstruccion("	
			    		SELECT NOMBRE, APELLIDO, CORREO_ELECTRONICO, CODIGO_TIPO_USUARIO
						FROM TBL_USUARIOS
						WHERE CODIGO_USUARIO = '$usuario'");
					oci_execute($resultado_usuario);
					while ($fila = $conexion->obtenerFila($resultado_usuario)) {
						$tipo_usuario = $fila["CODIGO_TIPO_USUARIO"];
						if ($tipo_usuario==1) {
							echo '<div class="col-12 col-lg-12" style="text-align: center">';
						  		//<!--Imagen del perfil de usuario id:imagenUsuario-->
							    echo '<img src="recursos/imagenes/ImagenUsuario.png" class="rounded-circle img-fluid" 
								id="imagenUsuario" alt="Placeholder image" style="width: 100px; height: 100px; padding:10px; ">';
							  	echo '<br>Administrador<br>';
							  	//<!--Etiqueta para el nombre del perfil de usuario-->
							  	echo '<h5>';
							  		echo $fila["NOMBRE"]." ".$fila["APELLIDO"];
							  	echo'</h5>';
								//<!--ETiqueta para el correo electronico-->
								echo '<h7>';
									echo $fila["CORREO_ELECTRONICO"];
								echo '<h7>';
							echo '</div>';
				  			echo '<br>';

				  			echo '<div class="list-group list-group-flush">';
								echo '<a href="Adm_gestion_publicaciones.php" class="list-group-item list-group-item-action bg-light"><span><h6>Gestión de Publicaciones</h6></span></a>'; 
								echo '<a href="Adm_gestion_vendedores.php" class="list-group-item list-group-item-action bg-light"><span>
									<h6 style="color:green">Gestión de Vendedores</h6></span></a>';
								echo '<a href="Adm_denuncias.php" class="list-group-item list-group-item-action bg-light"><span>
									<h6>Denuncias</h6></span></a>';
								echo '<a href="Adm_estadisticas.php" class="list-group-item list-group-item-action bg-light"><span>
									<h6>Estadísticas de la Página</h6></span></a>';
						  	echo '</div>';
						  
						}
					}
			  	}
			?>
	    </div>
		<!-- /#sidebar-wrapper -->
		

		<?php
			if (!isset($_SESSION['codigo_usuario_sesion'])) {			
				echo '<div style="margin-top: 50px;margin-left: 50px">No es un administrador, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' con una cuenta de administrador.</div>';
			}
			else{
				if ($tipo_usuario==2) {
					echo '<div style="margin-top: 50px;margin-left:50px">No es un administrador, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' con una cuenta de administrador.</div>';
				} else {
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
						//Principio del contenido principal
						echo '<center><div><h5 class="col-lg-12">Gestión de Vendedores</h5></div></center><hr>';

						echo 	'<div class="col-lg-12">
								<h6>Gestión de subcategorias y servicios a vendedores:</h6>
								</div>
								<center>

									<div class="input-group mb-3" style="width:90%">
									  <div class="input-group-prepend">
									    <span class="input-group-text">Nombre de la subcategoría:</span>
									  </div>
									  <input type="text" class="form-control" value="" id="txt-subcategoria">
									  <div class="input-group-prepend">
									    <span class="input-group-text">Agregar a:</span>
									  </div>
									  <select class="custom-select" id="slc-categoria">';

									$resultado_categorias = $conexion->ejecutarInstruccion("	
							    		SELECT CODIGO_CATEGORIA, NOMBRE_CATEGORIA
										FROM TBL_CATEGORIAS");
									oci_execute($resultado_categorias);
									while ($fila = $conexion->obtenerFila($resultado_categorias)) {
										echo '<option value="'.$fila["CODIGO_CATEGORIA"].'">'.$fila["NOMBRE_CATEGORIA"].'</option>';
									}

								echo '</select>
									  <div class="input-group-append">
									  	<button type="button" id="btn-subcategoria" class="btn btn-success" disabled>Agregar</button>
									  </div>
									</div>

									<button style="margin-bottom:20px" type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalScrollable2">Eliminar subcategorías</button>

									<!-- Modal para eliminar subcategorias-->
									<div class="modal fade" id="exampleModalScrollable2" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-scrollable" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="exampleModalScrollableTitle">Seleccione las subcategorías a eliminar:</h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="text-align:left;margin-bottom:0px;border-radius:0">
											  <b>ADVERTENCIA: </b> Las subcategorías eliminadas no se podrán recuperar y se eliminaran de las publicaciones que las contengan.
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
										  </div>
									      <div class="modal-body" style="text-align:left;padding-left:40px">
									      Subcategorías disponibles:<br><br>';

									    $resultado_categorias = $conexion->ejecutarInstruccion("	
								    		SELECT CODIGO_CATEGORIA, NOMBRE_CATEGORIA
								    		FROM TBL_CATEGORIAS");
										oci_execute($resultado_categorias);

										while ($fila = $conexion->obtenerFila($resultado_categorias)) {
											echo '<label><li>'.$fila["NOMBRE_CATEGORIA"].'</li></label><br>';
											$resultado_subcategorias = $conexion->ejecutarInstruccion("	
										    	SELECT	A.CODIGO_SUB_CATEGORIA, A.NOMBRE_SUB_CATEGORIA,
										    			B.CODIGO_CATEGORIA
										    	FROM TBL_SUB_CATEGORIAS A
												INNER JOIN TBL_CATEGO_X_TBL_SUBCATEGO B
												ON A.CODIGO_SUB_CATEGORIA = B.CODIGO_SUB_CATEGORIA");
											oci_execute($resultado_subcategorias);
											while ($fila2 = $conexion->obtenerFila($resultado_subcategorias)) {
												if ($fila["CODIGO_CATEGORIA"]==$fila2["CODIGO_CATEGORIA"]) {
													echo '<label style="padding-left:40px"><input type="checkbox" id="chk-subcategorias[]" name="chk-subcategorias[]" class="thirdparty" value="'.$fila2["CODIGO_SUB_CATEGORIA"].'" ';
													if ($fila2["CODIGO_SUB_CATEGORIA"]==5||$fila2["CODIGO_SUB_CATEGORIA"]==6) {
														echo 'disabled';
													}
													echo '> '.$fila2["NOMBRE_SUB_CATEGORIA"].'</label><br>';
												}
											}
										}

									echo '</div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									        <button type="button" class="btn btn-danger"  id="btn-eliminar-subcategorias">Eliminar</button>
									      </div>
									    </div>
									  </div>
									</div>

									<div class="input-group mb-3" style="width:50%">
									  <div class="input-group-prepend">
									    <span class="input-group-text">Nombre del servicio:</span>
									  </div>
									  <input type="text" class="form-control" value="" id="txt-servicio">
									  <div class="input-group-append">
									  	<button type="button" id="btn-servicio" class="btn btn-success" disabled>Agregar</button>
									  </div>
									</div>

									<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModalScrollable">Eliminar servicios</button>

									<!-- Modal para eliminar servicios-->
									<div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
									  <div class="modal-dialog modal-dialog-scrollable" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="exampleModalScrollableTitle">Seleccione los servicios a eliminar:</h5>
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          <span aria-hidden="true">&times;</span>
									        </button>
									      </div>
									      <div class="alert alert-danger alert-dismissible fade show" role="alert" style="text-align:left;margin-bottom:0px;border-radius:0">
											  <b>ADVERTENCIA: </b> Los servicios eliminados no se podrán recuperar y serán retirados de los vendedores que ofrezcan dichos servicios.
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
										  </div>
									      <div class="modal-body" style="text-align:left;padding-left:40px">
									      Servicios disponibles:<br><br>';

									    $resultado_servicios = $conexion->ejecutarInstruccion("	
								    		SELECT CODIGO_SERVICIO, NOMBRE_SERVICIO
											FROM TBL_SERVICIOS");
										oci_execute($resultado_servicios);
										while ($fila = $conexion->obtenerFila($resultado_servicios)) {
											echo '<label><input type="checkbox" id="chk-servicios[]" name="chk-servicios[]" class="thirdparty" value="'.$fila["CODIGO_SERVICIO"].'"> '.$fila["NOMBRE_SERVICIO"].'</label><br>';
										}

									echo '</div>
									      <div class="modal-footer">
									        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
									        <button type="button" class="btn btn-danger" id="btn-eliminar-servicios">Eliminar</button>
									      </div>
									    </div>
									  </div>
									</div>

								</center><br>';

							$codigo_vendedor = array();
							$nombre = array();
							$n_articulos = array();
							$ranking = array();
							$filtro = 0;
							$filtrosql = "B.CODIGO_USUARIO DESC";
							if (isset($_GET["filtro"])) {
								$filtro = $_GET['filtro'];
								switch ($filtro) {
									case 0:
										$filtrosql = "B.CODIGO_USUARIO DESC";
										break;
									case 1:
										$filtrosql = "obtener_valoracion(B.CODIGO_USUARIO) DESC";
										break;
									case 2:
										$filtrosql = "obtener_valoracion(B.CODIGO_USUARIO) ASC";
										break;
									case 3:
										$filtrosql = "COUNT(C.CODIGO_PUBLICACION_PRODUCTO) DESC";
										break;
									default:
										$filtrosql = "B.CODIGO_USUARIO DESC";
										break;
								}
							}
							$cont = 1;
							$resultado_gestion = $conexion->ejecutarInstruccion("	
					    		SELECT * FROM (
								SELECT  B.CODIGO_USUARIO,
								        INITCAP(B.NOMBRE||' '||B.APELLIDO) AS NOMBRE_COMPLETO,
								        COUNT(C.CODIGO_PUBLICACION_PRODUCTO) AS N_ARTICULOS,
								        obtener_valoracion(B.CODIGO_USUARIO) AS RANKING
								FROM TBL_VENDEDORES A
								INNER JOIN TBL_USUARIOS B
								ON A.CODIGO_USUARIO_VENDEDOR = B.CODIGO_USUARIO
								LEFT JOIN TBL_VEND_X_TBL_PUBLI C
								ON A.CODIGO_USUARIO_VENDEDOR = C.CODIGO_USUARIO_VENDEDOR
                                LEFT JOIN TBL_PUBLICACION_PRODUCTOS E
                                ON E.CODIGO_PUBLICACION_PRODUCTO = C.CODIGO_PUBLICACION_PRODUCTO
                                WHERE E.CODIGO_ESTADO_PUBLICACION <> 3
								GROUP BY B.CODIGO_USUARIO, INITCAP(B.NOMBRE||' '||B.APELLIDO),
                                        obtener_valoracion(B.CODIGO_USUARIO)
								ORDER BY ".$filtrosql."
								)
								WHERE ROWNUM <= 10");
							oci_execute($resultado_gestion);
							while ($fila = $conexion->obtenerFila($resultado_gestion)) {
								$codigo_vendedor[$cont] = $fila["CODIGO_USUARIO"];
								$nombre[$cont] = $fila["NOMBRE_COMPLETO"];
								$n_articulos[$cont] = $fila["N_ARTICULOS"];
								$ranking[$cont] = $fila["RANKING"];
								$cont++;
							}

							echo '<div class="col-lg-12">
								<h6>Lista de vendedores:</h6>

								<center>
								<div class="input-group input-group-sm mb-3" style="width:28%">
								  <div class="input-group-prepend">
								    <span class="input-group-text" id="inputGroup-sizing-sm">Filtrar por:</span>
								  </div>
									<select id="slc-filtro" class="form-control form-control-sm" onchange="filtro()">';

									echo '<option value="0" ';if($filtro==0){echo'selected';}
									echo '>Últimos registrados</option>';
									echo '<option value="1" ';if($filtro==1){echo'selected';}
									echo '>Mejor Calificados</option>';
									echo '<option value="2" ';if($filtro==2){echo'selected';}
									echo '>Peor Calificados</option>';
									echo '<option value="3" ';if($filtro==3){echo'selected';}
									echo '>Más artículos publicados</option>';

							echo '</select>
								   </div>
								</div>
								</center>

								<center>
									<table class="table" style="width:60%">
									  <thead class="thead-dark">
									    <tr>
									      <th scope="col">#</th>
									      <th scope="col">Nombre</th>
									      <th scope="col">Nº de artículos</th>
									      <th scope="col">Ranking</th>
									    </tr>
									  </thead>
									  <tbody>';
									  for ($i=1; $i <= count($codigo_vendedor) ; $i++) { 
									  	echo '<tr>
											    <th scope="row">'.$i.'</th>
											    <td><a style="color:black" href="Informacion_de_vendedor.php?codigo-usuario='.$codigo_vendedor[$i].'">'.$nombre[$i].'</a></td>
											    <td>'.$n_articulos[$i].'</td>
											    <td>';
											    for ($j=1; $j <= 5 ; $j++) { 
													echo '<span class="fa fa-star" ';
								  					if ($j<=$ranking[$i]) {
								  						echo 'style="color:orange"';
								  					}	
													echo'></span>';
												}
											echo '</td>
											  </tr>';
									  }
								echo '</tbody>
									</table>
									<p><b>NOTA: </b>Solo aparecerán los 10 primeros registros encontrados de vendedores que tengan productos publicados actualmente.</p>
								</center><br>';
							echo '<div class="col-lg-12">
								<h6>Últimas publicaciones eliminadas:<h6>
								</div>';
							//Lista de publicaciones eliminadas
							echo '<div id="div-publicaciones-eliminadas" style="width:85%;margin:0 auto;">';
							echo '</div>';
						//Fin del contenido principal
						echo '</div>';

					echo '</div><br>';
				}
			}
		?>

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
	<script src="js/controlador_administrador.js"></script>
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
        function filtro(){
        	var filtro = $("#slc-filtro").val();
        	window.location="Adm_gestion_vendedores.php?filtro="+filtro;
        }
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
