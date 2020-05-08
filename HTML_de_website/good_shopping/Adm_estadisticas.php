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

						//Tipo de estadistica
						echo '<center><div class="input-group mb-3" style="width:52%">
								  <div class="input-group-prepend">
								    <label class="input-group-text" for="slc-estadisticas">Mostrar estadísticas de: </label>
								  </div>
								  <select class="custom-select" id="slc-estadisticas">';

								$estadistica = 1;
	
								if (isset($_GET['estadistica'])) {
									$estadistica = $_GET['estadistica'];
								}

							echo '<option value="1" ';if($estadistica==1){echo'selected';};
							echo '>Cantidad de productos por categoria</option>';
							echo '<option value="2" ';if($estadistica==2){echo'selected';};
							echo '>Cantidad de vendedores registrados</option>';
							echo '<option value="3" ';if($estadistica==3){echo'selected';};
							echo '>Cantidad de productos por departamento</option>
								  </select>
								</div></center>';

						//Tiempo a mostrar
						echo '<center><div class="input-group mb-3" style="width:30%">
								  <div class="input-group-prepend">
								    <label class="input-group-text" for="slc-tiempo">En: </label>
								  </div>
								  <select class="custom-select" id="slc-tiempo">';

								$tiempo = 1;
	
								if (isset($_GET['tiempo'])) {
									$tiempo = $_GET['tiempo'];
								}

							echo '<option value="1" ';if($tiempo==1){echo'selected';};
							echo '>Año</option>';
							echo '<option value="2" ';if($tiempo==2){echo'selected';};
							echo '>Mes</option>';
							echo '<option value="3" ';if($tiempo==3){echo'selected';};
							echo '>Semana</option>
								  </select>';

						//Fecha a mostrar
						echo '<select class="custom-select" id="slc-fecha">';

								$fecha = 1;
								if (isset($_GET['fecha'])) {
									$fecha = $_GET['fecha'];
								}
								echo '<option value="1" ';if($fecha==1){echo'selected';}
								echo '>Actual</option>';
								echo '<option value="2" ';if($fecha==2){echo'selected';}
								echo '>Anterior</option>';

						echo '</select>
								</div></center>';
						
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

        $("#slc-estadisticas").change(function(){
        	window.location = "Adm_estadisticas.php?estadistica="+$("#slc-estadisticas").val();
        });

        $("#slc-tiempo").change(function(){
        	window.location = 	"Adm_estadisticas.php?estadistica="+$("#slc-estadisticas").val()+
        						"&tiempo="+$("#slc-tiempo").val();
        });

        $("#slc-fecha").change(function(){
        	window.location = 	"Adm_estadisticas.php?estadistica="+$("#slc-estadisticas").val()+
        						"&tiempo="+$("#slc-tiempo").val()+
        						"&fecha="+$("#slc-fecha").val();
        });
    </script>

	<!--Librerias para graficos-->
	<script src="js/highcharts.js"></script>
	<script src="js/exporting.js"></script>
	<script src="js/export-data.js"></script>
	<script src="js/accessibility.js"></script>

	<?php
		$sql = '';

		switch ($estadistica) {
			case 1:
				$estadistica = 'productos_x_cat';
				break;
			case 2:
				$estadistica = '2_tipos_usarios';
				break;
			case 3:
				$estadistica = 'productos_x_dep';
				break;
			default:
				$estadistica = 'productos_x_cat';
				break;
		}

		$año = date("Y");
		$año_anterior = strtotime("-1 year");
		$año_anterior = date("Y", $año_anterior);
		switch ($tiempo) {
			case 1:
				$sql_tiempo = 'YYYY';
				$sql_tiempo_dividido = 'MM';
				if ($fecha == 1) {
					$sql_fecha = $año;
				} else {
					$sql_fecha = $año_anterior;
				}
				break;
			case 2:
				$sql_tiempo = 'MM/YYYY';
				$sql_tiempo_dividido = 'DD';
				$mes = date("m");
				$mes_anterior = strtotime("-1 month");
				$mes_anterior = date("m", $mes_anterior);
				if ($fecha == 1) {
					$sql_fecha = $mes."/".$año;
				} else {
					$sql_fecha = $mes_anterior."/".$año;
				}
				break;
			case 3:
				$sql_tiempo = 'IW/YYYY';
				$sql_tiempo_dividido = 'D';
				$semana = date("W");
				$semana_anterior = strtotime("-1 week");
				$semana_anterior = date("W", $semana_anterior);
				if ($fecha == 1) {
					$sql_fecha = $semana."/".$año;
				} else {
					$sql_fecha = $semana_anterior."/".$año;
				}
				break;
			default:
				$sql_tiempo = 'YYYY';
				$sql_tiempo_dividido = 'MM';
				if ($fecha == 1) {
					$sql_fecha = $año;
				} else {
					$sql_fecha = $año_anterior;
				}
				break;
		}

		$ejeY = 0;
		$titulo = $tituloY = '';

		//GRAFICA POR CATEGORIA
		if($estadistica == 'productos_x_cat'){
			$titulo = 'Cantidad De Productos Publicados Por Categoría';				
			$tituloY = 'Cantidad de productos';

			$cantidad_productos = $conexion->ejecutarInstruccion("
				SELECT NVL(MAX(COUNT(*)),0) NUM_PRODUCTOS 
				FROM TBL_CATEGORIAS C
				INNER JOIN TBL_PUBLICACION_PRODUCTOS PB 
				ON PB.CODIGO_CATEGORIA = C.CODIGO_CATEGORIA
				WHERE TO_CHAR(TO_DATE(PB.FECHA_PUBLICACION), '".$sql_tiempo."') = '".$sql_fecha."' 
				GROUP BY C.CODIGO_CATEGORIA, 
				TO_CHAR(TO_DATE(PB.FECHA_PUBLICACION), '".$sql_tiempo_dividido."')");
			oci_execute($cantidad_productos);
			while($fila = $conexion->obtenerFila($cantidad_productos)){
				$ejeY = $fila["NUM_PRODUCTOS"];
			}

			$sql = $conexion->ejecutarInstruccion(" 
				SELECT  C.CODIGO_CATEGORIA CODIGO,
				        TO_CHAR(TO_DATE(PB.FECHA_PUBLICACION), '".$sql_tiempo_dividido."') TIEMPO,
				        COUNT(C.CODIGO_CATEGORIA) CANTIDAD
				FROM TBL_CATEGORIAS C
				INNER JOIN TBL_PUBLICACION_PRODUCTOS PB 
				ON PB.CODIGO_CATEGORIA = C.CODIGO_CATEGORIA
				WHERE TO_CHAR(TO_DATE(PB.FECHA_PUBLICACION), '".$sql_tiempo."') = '".$sql_fecha."' 
				GROUP BY C.CODIGO_CATEGORIA, 
				TO_CHAR(TO_DATE(PB.FECHA_PUBLICACION), '".$sql_tiempo_dividido."')
				ORDER BY C.CODIGO_CATEGORIA, TIEMPO");
			
		}

		//GRAFICA POR TIPO DE USUARIO
		else if($estadistica == '2_tipos_usarios'){
			$titulo = 'Cantidad De Vendedores Registrados';					
			$tituloY = 'Cantidad de vendedores';

			$cantidad_vendedores = $conexion->ejecutarInstruccion("
				SELECT NVL(MAX(COUNT(*)),0) NUM_VENDEDORES FROM TBL_VENDEDORES V
				INNER JOIN TBL_USUARIOS U
				ON V.CODIGO_USUARIO_VENDEDOR=U.CODIGO_USUARIO
				WHERE TO_CHAR(TO_DATE(U.FECHA_REGISTRO), '".$sql_tiempo."') = '".$sql_fecha."' 
				GROUP BY V.CODIGO_TIPO_VENDEDOR,
				TO_CHAR(TO_DATE(U.FECHA_REGISTRO), '".$sql_tiempo_dividido."')");
			oci_execute($cantidad_vendedores);
			while($fila = $conexion->obtenerFila($cantidad_vendedores)){
				$ejeY = $fila["NUM_VENDEDORES"];
			}

			$sql = $conexion->ejecutarInstruccion(" 
				SELECT 	V.CODIGO_TIPO_VENDEDOR CODIGO, 
				        TO_CHAR(TO_DATE(U.FECHA_REGISTRO), '".$sql_tiempo_dividido."') TIEMPO,
				        COUNT(V.CODIGO_TIPO_VENDEDOR) CANTIDAD
				FROM TBL_VENDEDORES V
				INNER JOIN TBL_USUARIOS U 
				ON U.CODIGO_USUARIO = V.CODIGO_USUARIO_VENDEDOR
				WHERE TO_CHAR(TO_DATE(U.FECHA_REGISTRO), '".$sql_tiempo."') = '".$sql_fecha."' 
				GROUP BY V.CODIGO_TIPO_VENDEDOR,
				TO_CHAR(TO_DATE(U.FECHA_REGISTRO), '".$sql_tiempo_dividido."')
				ORDER BY V.CODIGO_TIPO_VENDEDOR, TIEMPO");

		}

		//GRAFICA POR DEPARTAMENTO
		else if($estadistica == 'productos_x_dep'){
			$titulo = 'Cantidad De Productos Publicados Por Departamento';					
			$tituloY = 'Cantidad de productos';

			$cantidad_productos = $conexion->ejecutarInstruccion("
				SELECT NVL(MAX(COUNT(*)),0) NUM_PRODUCTOS 
				FROM TBL_USUARIOS U
				INNER JOIN TBL_LUGARES L 
				ON L.CODIGO_LUGAR = U.CODIGO_LUGAR
				INNER JOIN TBL_VEND_X_TBL_PUBLI VxP 
				ON VxP.CODIGO_USUARIO_VENDEDOR = U.CODIGO_USUARIO
				INNER JOIN TBL_PUBLICACION_PRODUCTOS P
				ON P.CODIGO_PUBLICACION_PRODUCTO = VxP.CODIGO_PUBLICACION_PRODUCTO
				WHERE TO_CHAR(TO_DATE(P.FECHA_PUBLICACION), '".$sql_tiempo."') = '".$sql_fecha."' 
				GROUP BY L.CODIGO_LUGAR,
				TO_CHAR(TO_DATE(P.FECHA_PUBLICACION), '".$sql_tiempo_dividido."')");
			oci_execute($cantidad_productos);
			while($fila = $conexion->obtenerFila($cantidad_productos)){
				$ejeY = $fila["NUM_PRODUCTOS"];
			}

			$sql = $conexion->ejecutarInstruccion(" 
				SELECT  L.CODIGO_LUGAR CODIGO,
				        TO_CHAR(TO_DATE(P.FECHA_PUBLICACION), '".$sql_tiempo_dividido."') TIEMPO,
				        COUNT(L.NOMBRE_LUGAR) CANTIDAD
				FROM TBL_USUARIOS U
				INNER JOIN TBL_LUGARES L 
				ON L.CODIGO_LUGAR = U.CODIGO_LUGAR
				INNER JOIN TBL_VEND_X_TBL_PUBLI VxP 
				ON VxP.CODIGO_USUARIO_VENDEDOR = U.CODIGO_USUARIO
				INNER JOIN TBL_PUBLICACION_PRODUCTOS P
				ON P.CODIGO_PUBLICACION_PRODUCTO = VxP.CODIGO_PUBLICACION_PRODUCTO
				WHERE TO_CHAR(TO_DATE(P.FECHA_PUBLICACION), '".$sql_tiempo."') = '".$sql_fecha."' 
				GROUP BY L.CODIGO_LUGAR,
				TO_CHAR(TO_DATE(P.FECHA_PUBLICACION), '".$sql_tiempo_dividido."')
				ORDER BY L.CODIGO_LUGAR, TIEMPO");
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
							if ($tiempo == 1) {
								echo"categories: [
								'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio',
								'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' 
								],";
							}
							if ($tiempo == 2) {
								echo"categories: [
								'1', '2', '3', '4', '5', '6', '7','8', '9', '10', '11', '12' 
								,'13','14','15','16','17','18','19','20','21','22','23','24','25','26',
								'27','28','29','30','31'
								],";
							}
							if ($tiempo == 3) {
								echo"categories: [
								'domingo','lunes', 'martes', 'miercoles', 'jueves', 'viernes','sabado'
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
			
			<?php
				if($estadistica == 'productos_x_dep' || $estadistica == 'productos_x_cat'){
					$entero = 0;
					$cantidad = 18;
					echo"colors: [";
					for($i=0 ; $i < $cantidad; $i++){
						echo"'#".substr(md5($entero), 0, 6)."',";
						$entero += 2;
					}
					echo'],';
				}
			?>

			plotOptions: {
				column: {
					pointPadding: 0.1,
					borderWidth: 0,
					<?php
						if($estadistica == 'productos_x_dep' || $estadistica == 'productos_x_cat'){
							echo 'colorByPoint: false';
						}
					?>
				}
			},
			
			series: [		
				<?php
					oci_execute($sql);

					//tiempo que se define
					if ($tiempo == 1) {
						$cantidad_tiempo = 12;
					}
					if ($tiempo == 2) {
						$cantidad_tiempo = 31;
					}
					if ($tiempo == 3) {
						$cantidad_tiempo = 7;
					}

					//Muestra Grafica de productos por categoria
					if($estadistica == 'productos_x_cat'){
						$categorias = $conexion->ejecutarInstruccion("
							SELECT  C.CODIGO_CATEGORIA,C.NOMBRE_CATEGORIA
							FROM TBL_CATEGORIAS C
							INNER JOIN TBL_PUBLICACION_PRODUCTOS PB 
							ON PB.CODIGO_CATEGORIA = C.CODIGO_CATEGORIA
							WHERE TO_CHAR(TO_DATE(PB.FECHA_PUBLICACION), '".$sql_tiempo."') = '".$sql_fecha."' 
							GROUP BY C.CODIGO_CATEGORIA,C.NOMBRE_CATEGORIA
							ORDER BY C.CODIGO_CATEGORIA");
						oci_execute($categorias);

						$categorizacion = array();
						//define las comparaciones
						while($fila = $conexion->obtenerFila($categorias)){
							$categorizacion[] = $fila["NOMBRE_CATEGORIA"];
						}
					}

					//Muestra Grafica por tipo de usuario
					if($estadistica == '2_tipos_usarios'){	
						$departamentos = $conexion->ejecutarInstruccion("
							SELECT 	V.CODIGO_TIPO_VENDEDOR,
							        TV.NOMBRE_TIPO_VENDEDOR
							FROM TBL_VENDEDORES V
							INNER JOIN TBL_USUARIOS U 
							ON U.CODIGO_USUARIO = V.CODIGO_USUARIO_VENDEDOR
							INNER JOIN TBL_TIPO_VENDEDORES TV
							ON TV.CODIGO_TIPO_VENDEDOR = V.CODIGO_TIPO_VENDEDOR
							WHERE TO_CHAR(TO_DATE(U.FECHA_REGISTRO), '".$sql_tiempo."') = '".$sql_fecha."' 
							GROUP BY V.CODIGO_TIPO_VENDEDOR,TV.NOMBRE_TIPO_VENDEDOR
							ORDER BY V.CODIGO_TIPO_VENDEDOR");
						oci_execute($departamentos);

						$categorizacion = array();
						//define las comparaciones
						while($fila = $conexion->obtenerFila($departamentos)){
							$categorizacion[] = $fila["NOMBRE_TIPO_VENDEDOR"];
						}
					}

					//Muestra Grafica de productos por departamento
					if($estadistica == 'productos_x_dep'){
						$departamentos = $conexion->ejecutarInstruccion("
							SELECT L.CODIGO_LUGAR, L.NOMBRE_LUGAR
							FROM TBL_USUARIOS U
							INNER JOIN TBL_LUGARES L 
							ON L.CODIGO_LUGAR = U.CODIGO_LUGAR
							INNER JOIN TBL_VEND_X_TBL_PUBLI VxP 
							ON VxP.CODIGO_USUARIO_VENDEDOR = U.CODIGO_USUARIO
							INNER JOIN TBL_PUBLICACION_PRODUCTOS P
							ON P.CODIGO_PUBLICACION_PRODUCTO = VxP.CODIGO_PUBLICACION_PRODUCTO
							WHERE TO_CHAR(TO_DATE(P.FECHA_PUBLICACION), '".$sql_tiempo."') = '".$sql_fecha."' 
							GROUP BY L.CODIGO_LUGAR, L.NOMBRE_LUGAR
							ORDER BY L.CODIGO_LUGAR");
						oci_execute($departamentos);

						$categorizacion = array();
						//define las comparaciones
						while($fila = $conexion->obtenerFila($departamentos)){
							$categorizacion[] = $fila["NOMBRE_LUGAR"];
						}
					}
						
					//llenado de arreglo para el tiempo establecido
					for ($i = 0; $i < count($categorizacion); $i++) {
						for ($j = 0; $j < $cantidad_tiempo; $j++) {
							$arreglo[$i][$j] = 0;
						}
					}

					//llena los campos que existen
					$cont = 0;
					$codigo_anterior = 0;
					while($fila = $conexion->obtenerFila($sql)){
						if ($fila["CODIGO"] != $codigo_anterior) {
							if ($codigo_anterior != 0) {
								$cont++;
							}
						} 
						for($i = 0; $i < $cantidad_tiempo; $i++){
							if($fila["TIEMPO"] == $i+1){
								$arreglo[$cont][$i] = $fila["CANTIDAD"];
							}
						}
						$codigo_anterior = $fila["CODIGO"];
					}

					//mete los datos a la grafica
					for($i = 0; $i< count($categorizacion); $i++) {
						echo"{name: '".$categorizacion[$i]."', data: [";
						for ($j = 0; $j< $cantidad_tiempo; $j++) {
							echo $arreglo[$i][$j];
							echo ',';
						}
						echo']},';	
					}

					//si no hay ningun dato
					if (count($categorizacion)==0) {
						echo"{name: 'No existen datos para este tiempo', data: [";
						for ($j = 0; $j< $cantidad_tiempo; $j++) {
							echo '0,';
						}
						echo']},';	
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
