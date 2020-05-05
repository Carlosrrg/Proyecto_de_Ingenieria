<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estadísticas de la Página</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/estilo2.css" rel="stylesheet">
	<link rel="icon" type="image/jpg" href="recursos/imagenes/Logo.png">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" 
		integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
	<link href="css/graficos.css" rel="stylesheet">
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
									<h6>Gestión de Vendedores</h6></span></a>';
								echo '<a href="Adm_denuncias.php" class="list-group-item list-group-item-action bg-light"><span>
									<h6>Denuncias</h6></span></a>';
								echo '<a href="Adm_estadisticas.php" class="list-group-item list-group-item-action bg-light"><span>
									<h6 style="color:green">Estadísticas de la Página</h6></span></a>';
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
						echo '<center><div><h5 class="col-lg-12">Estadísticas de la Página</h5></div></center><hr>';

						echo '<center><div class="input-group mb-3" style="width:35%">
								  <div class="input-group-prepend">
								    <label class="input-group-text" for="slc-estadisticas">Mostrar estadísticas de: </label>
								  </div>
								  <select class="custom-select" id="slc-estadisticas">
								    <option value="0" selected>-- Seleccione --</option>
								    <option value="1">Productos por categoria</option>
								    <option value="2">Ultimos usuarios registrados</option>
								    <option value="3">Cantidad de productos por departamento</option>
								  </select>
								</div></center>';
						echo '<div id="div-estadisticas"></div>';
						
						echo'<figure class="highcharts-figure">
							<div id="grafico"></div>
							<p class="highcharts-description">
								<!--Grafico para la tienda goodshopping.-->
							</p>
						</figure>';

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
    </script>

	<!--Librerias para graficos-->
	<script src="js/highcharts.js"></script>
	<script src="js/exporting.js"></script>
	<script src="js/export-data.js"></script>
	<script src="js/accessibility.js"></script>

	<?php
		$sql = '';
		$estadistica = '';
		if(1 == 1){
			$estadistica = 'productos_x_cat';
		}else if(2 == 2){
			$estadistica = '2_tipos_usarios';
		}else{
			$estadistica = 'productos_x_dep';
		}

		$ejeY = 0;
		if($estadistica == 'productos_x_dep' || $estadistica == 'productos_x_cat'){
			$cantidad_productos = $conexion->ejecutarInstruccion("SELECT COUNT(*) NUM_PRODUCTOS FROM TBL_PUBLICACION_PRODUCTOS");
			oci_execute($cantidad_productos);
			while($fila = $conexion->obtenerFila($cantidad_productos)){
				$ejeY = $fila["NUM_PRODUCTOS"];
			}
		}

		$titulo = $tituloY = '';
		if($estadistica == 'productos_x_cat'){
			$titulo = 'Cantidad de productos publicados por categoría';					
			$tituloY = 'Cantidad de productos';
			$sql = $conexion->ejecutarInstruccion(" SELECT COUNT(C.NOMBRE_CATEGORIA) CANTIDAD_PRODUCTOS, 
														C.NOMBRE_CATEGORIA 
													FROM TBL_CATEGORIAS C
													INNER JOIN TBL_PUBLICACION_PRODUCTOS PB 
														ON PB.CODIGO_CATEGORIA = C.CODIGO_CATEGORIA
													GROUP BY C.NOMBRE_CATEGORIA
													ORDER BY C.NOMBRE_CATEGORIA"
													);
			
		}else if($estadistica == '2_tipos_usarios'){
			$titulo = 'Cantidad de usuarios registrados los ultimos 5 meses';					
			$tituloY = 'Cantidad de usuarios';
			$cantidad_vendedores = $conexion->ejecutarInstruccion("SELECT COUNT(*) NUM_VENDEDORES FROM TBL_VENDEDORES");
			oci_execute($cantidad_vendedores);
			while($fila = $conexion->obtenerFila($cantidad_vendedores)){
				$ejeY = $fila["NUM_VENDEDORES"];
			}

			$sql = $conexion->ejecutarInstruccion(" SELECT COUNT(V.CODIGO_TIPO_VENDEDOR) VENDEDORES, V.CODIGO_TIPO_VENDEDOR, 
														TO_CHAR(U.FECHA_REGISTRO, 'MM') MES
													FROM TBL_VENDEDORES V
													INNER JOIN TBL_USUARIOS U 
														ON U.CODIGO_USUARIO = V.CODIGO_USUARIO_VENDEDOR
													WHERE (to_char(sysdate, 'YYYY') = to_char(U.FECHA_REGISTRO, 'YYYY')) AND
														(to_char(sysdate, 'MM')-to_char(U.FECHA_REGISTRO, 'MM') >= 0) AND
														(to_char(sysdate, 'MM')-to_char(U.FECHA_REGISTRO, 'MM') <= 5)
													GROUP BY V.CODIGO_TIPO_VENDEDOR,
													TO_CHAR(U.FECHA_REGISTRO, 'MM')
													ORDER BY MES"
													);
		}else if($estadistica == 'productos_x_dep'){
			$titulo = 'productos recientemente publicados por departamento';					
			$tituloY = 'Cantidad de productos';
			$sql = $conexion->ejecutarInstruccion(" SELECT COUNT(L.NOMBRE_LUGAR) CANTIDAD, L.NOMBRE_LUGAR FROM TBL_USUARIOS U
													INNER JOIN TBL_LUGARES L ON L.CODIGO_LUGAR = U.CODIGO_LUGAR
													INNER JOIN TBL_VENDEDORES V 
														ON V.CODIGO_USUARIO_VENDEDOR = U.CODIGO_USUARIO
													INNER JOIN TBL_VEND_X_TBL_PUBLI VxP 
														ON VxP.CODIGO_USUARIO_VENDEDOR = V.CODIGO_USUARIO_VENDEDOR
													INNER JOIN TBL_PUBLICACION_PRODUCTOS P
														ON P.CODIGO_PUBLICACION_PRODUCTO = VxP.CODIGO_PUBLICACION_PRODUCTO
													WHERE (to_char(sysdate, 'YYYY') = to_char(P.FECHA_PUBLICACION, 'YYYY')) AND
														(to_char(sysdate, 'MM') = to_char(P.FECHA_PUBLICACION, 'MM')) AND
														(to_char(sysdate, 'DD')-to_char(P.FECHA_PUBLICACION, 'DD') <= 14)
													GROUP BY L.NOMBRE_LUGAR
													ORDER BY L.NOMBRE_LUGAR"
													);
		}
	?>

	<script type="text/javascript">
		Highcharts.chart('grafico', {
			chart: {
				type: 'column'
			},
			title: {
				text: '<?php echo $titulo?>'
			},
			xAxis: {
					<?php
						if($estadistica == 'productos_x_cat'){
							oci_execute($sql);
							echo'categories: [';	 
							while($fila = $conexion->obtenerFila($sql)){
									echo "'".$fila["NOMBRE_CATEGORIA"]."', ";
							}
							echo'],';
						}else if($estadistica == 'productos_x_dep'){
							oci_execute($sql);
							echo'categories: [';	 
							while($fila = $conexion->obtenerFila($sql)){
									echo "'".$fila["NOMBRE_LUGAR"]."', ";			
							}
							echo'],';
						}
					?>

					<?php
						if($estadistica == '2_tipos_usarios'){
							echo"categories: [
								'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
								'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' 
							],";
						}
					?>
				
				crosshair: true
			},
			yAxis: {
				min: 0, max: '<?php echo $ejeY?>',
				title: {
					text: '<?php echo $tituloY;?>'
				}
			},
			tooltip: {
				headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
				pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y: 1f} </b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			plotOptions: {
				column: {
					pointPadding: 0.1,
					borderWidth: 0
				}
			},
			
			series: [		
				<?php
					if($estadistica == 'productos_x_dep' || $estadistica == 'productos_x_cat'){
						echo"{name: 'productos', data: [";
						oci_execute($sql);
						while($fila = $conexion->obtenerFila($sql)){
							if($estadistica == 'productos_x_dep'){	
								echo $fila["CANTIDAD"].",";
							}else if($estadistica == 'productos_x_cat'){
								echo $fila["CANTIDAD_PRODUCTOS"].",";
							}
						}
						echo']},';
					}
				?>	

				<?php
					if($estadistica == '2_tipos_usarios'){	
						oci_execute($sql);
						$meses = [0,0,0,0,0,0,0,0,0,0,0,0];
						$meses2 = [0,0,0,0,0,0,0,0,0,0,0,0];
						$vendedorNormal = 0;
						$vendedorEmpresarial = 0;
						while($fila = $conexion->obtenerFila($sql)){
							if($fila["CODIGO_TIPO_VENDEDOR"] == 1){
								for($i = 0; $i < 12; $i++){
									if($fila["MES"] == $i+1){
										$meses[$i] = $fila["VENDEDORES"];
										$vendedorNormal++;
										break;
									}
								}	
							}else if($fila["CODIGO_TIPO_VENDEDOR"] == 2){
								for($i = 0; $i < 12; $i++){
									if($fila["MES"] == $i+1){
										$meses2[$i] = $fila["VENDEDORES"];
										$vendedorEmpresarial++;
										break;
									}
								}
							}
						}
						if($vendedorNormal > 0){
							echo"{name: 'Vendedores normales', data: [";
							for($i = 0; $i<12; $i++){
								echo $meses[$i];
								echo ',';
							}
							echo']},';		
						}

						if($vendedorEmpresarial > 0){
							echo"{name: 'Vendedores empresariales', data: [";
							for($i = 0; $i<12; $i++){
								echo $meses2[$i];
								echo ',';
							}
							echo']},';		
						}
					}
					
				?>	
				
			]
			
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
