<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Good Shopping</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="icon" type="image/jpg" href="recursos/imagenes/logo.png">
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
						echo'<a class="dropdown-item" href="php/session_cerrar.php">Cerrar Sesión</a>';
					echo'</div>';
				echo'</div>';
			}
		?>
	</nav>
	
	<?php
		//Control del numero de paginas que se mostraran
		$conexion->establecerConexion();
		//Gestion de parametros para buscar
		$parametros = "";
		$busca = "";
		if (isset($_GET['busca'])) {
			$busca = $_GET['busca'];
			$parametros .= "&busca=".$busca;
		}
		$lugar = 0;
		$sql_lugar = "";
		if (isset($_GET['lugar'])) {
			$lugar = $_GET['lugar'];
			if ($lugar!=0) {
				$sql_lugar = "AND F.CODIGO_LUGAR = ".$lugar." ";
			}
			$parametros .= "&lugar=".$lugar;
		}
		$categoria = 0;
		$sql_categoria = "";
		if (isset($_GET['categoria'])) {
			$categoria = $_GET['categoria'];
			if ($categoria!=0) {
				$sql_categoria = "AND A.CODIGO_CATEGORIA = ".$categoria." ";
			}
			$parametros .= "&categoria=".$categoria;
		}
		$tipo_moneda = 0;
		$sql_moneda = "";
		if (isset($_GET['tipo_moneda'])) {
			$tipo_moneda = $_GET['tipo_moneda'];
			if ($tipo_moneda==1||$tipo_moneda==2) {
				$sql_moneda = "AND A.CODIGO_TIPO_MONEDA = ".$tipo_moneda." ";
			}
			$parametros .= "&tipo_moneda=".$tipo_moneda;
		}
		$precio_max = 50000;
		$sql_precio = "";
		if (isset($_GET['precio_max'])) {
			$precio_max = $_GET['precio_max'];
			if ($precio_max!=50000) {
				$sql_precio = "AND A.PRECIO <= ".$precio_max." ";
			}
			$parametros .= "&precio_max=".$precio_max;
		}
		$subcategorias = "";
		$sql_subcatego1 = "";
		$sql_subcatego2 = "";
		if($categoria != 0){
			if (isset($_GET['subcategorias'])) {
				$subcategorias = $_GET['subcategorias'];
				if ($subcategorias!="") {
					$sql_subcatego1 = "INNER JOIN TBL_PRODU_X_TBL_CATEGO G ON A.CODIGO_PUBLICACION_PRODUCTO=G.CODIGO_PRODUCTO ";
					$sql_subcatego2 = "AND G.CODIGO_SUB_CATEGORIA IN(".$subcategorias.") ";
				}
				$parametros .= "&subcategorias=".$subcategorias;
			}
		}
		$orden = 1;
		$sql_orden = "ORDER BY A.CODIGO_PUBLICACION_PRODUCTO DESC ";
		if (isset($_GET['orden'])) {
			$orden = $_GET['orden'];
			if ($orden==2) {
				$sql_orden = "ORDER BY A.CODIGO_PUBLICACION_PRODUCTO ASC ";
			}
			if ($orden==3) {
				$sql_orden = "ORDER BY A.PRECIO ASC, A.CODIGO_PUBLICACION_PRODUCTO DESC ";
			}
			if ($orden==4) {
				$sql_orden = "ORDER BY A.PRECIO DESC, A.CODIGO_PUBLICACION_PRODUCTO DESC ";
			}
			if ($orden==5) {
				$sql_orden = "ORDER BY obtener_valoracion(C.CODIGO_USUARIO) DESC, A.CODIGO_PUBLICACION_PRODUCTO DESC ";
			}
			if ($orden==6) {
				$sql_orden = "ORDER BY G.CODIGO_TIPO_VENDEDOR ASC, A.CODIGO_PUBLICACION_PRODUCTO DESC ";
			}
			if ($orden==7) {
				$sql_orden = "ORDER BY G.CODIGO_TIPO_VENDEDOR DESC, A.CODIGO_PUBLICACION_PRODUCTO DESC ";
			}
			$parametros .= "&orden=".$orden;
		}

		$resultado_cantP = $conexion->ejecutarInstruccion(
			"SELECT  COUNT(*) NUM_PRODUCTOS
			FROM TBL_PUBLICACION_PRODUCTOS A
			INNER JOIN TBL_VEND_X_TBL_PUBLI C ON A.CODIGO_PUBLICACION_PRODUCTO=C.CODIGO_PUBLICACION_PRODUCTO
			INNER JOIN TBL_USUARIOS F ON C.CODIGO_USUARIO_VENDEDOR=F.CODIGO_USUARIO 
			".$sql_subcatego1."  
			WHERE A.CODIGO_ESTADO_PUBLICACION = 1
			AND UPPER(A.NOMBRE_PRODUCTO) LIKE UPPER('%$busca%')
			".$sql_lugar."
			".$sql_categoria." 
			".$sql_moneda." 
			".$sql_precio." 
			".$sql_subcatego2." 
			");
		oci_execute($resultado_cantP);
		while ($cantidad = $conexion->obtenerFila($resultado_cantP)) {
			$total_productos = $cantidad["NUM_PRODUCTOS"];//todos los productos en venta de la base de datos
		}
		
		$productosAMostrar = 5;// son el numero de productos que se mostraran en una pagina
		$paginas = ceil($total_productos / $productosAMostrar);//son el total de paginas que abarcaran todos los productos
		
		//Control de seguridad por si hay numeros que no corresponden a las paginas
		if($paginas == 0){
			$paginas = 1;
		}
		if(!$_GET){
			header('Location:BusquedaP.php?pagina=1');
		}
		if($_GET['pagina'] > $paginas){
			header('Location:BusquedaP.php?pagina='.$paginas.'');
		}
		if($_GET['pagina'] < 1){
			header('Location:BusquedaP.php?pagina=1');
		}
		//#Control de seguridad por si hay numeros que no corresponden a las paginas
	?>
	
	<div class="d-flex" id="wrapper">
		
  	  <!-- Barra lateral -->
	    <div class="bg-light border-right" id="sidebar-wrapper">
			<div class="col-12 col-lg-12" style="text-align: center">
				
			<div class="form-group">
				<!--Titulo de la seccion-->
				<label for="txt_buscar" style="margin-bottom: -10px; margin-top: 30px;"><h5>Filtrar búsqueda</h5></label>

				<!--id: txt_buscar -> campo que contiene el nombre del producto que esta buscando, 
					id:btn_buscar-> boton que realizara la busqueda filtrada -->
				<div class="input-group mb-3" style=" margin-top: 30px; width: 95%;">
				<?php
					if (!isset($_GET["busca"])) {
						echo'<input type="text" class="form-control" id="txt_buscar" placeholder="¿Qué estas buscando?" aria-label="Buscar" aria-describedby="btn_buscar">';
					} else {
						echo'<input type="text" class="form-control" id="txt_buscar" placeholder="¿Qué estas buscando?" aria-label="Buscar" value="'.$busca.'" aria-describedby="btn_buscar">';
					}
				?>
				<div class="input-group-append">
					<button class="btn btn-outline-secondary" type="button" id="btn_buscar"><img src="recursos/imagenes/Lupa.png" style="width: 20px;"></button>
				</div>
				</div>
		
			</div>

			<!--id: cmb_ubicacion -> combobox que contendra todas las ubicaciones de los productos-->
		    <label for="cmb_ubicacion" style="margin-bottom: -10px; margin-top: 30px;"><h6>Ubicación</h6></label>
			<select id="cmb_ubicacion" class="form-control" style="width: 95%;" onchange="refrescar()">
			<?php
				echo '<option value="0" ';
				if (!isset($_GET["lugar"])) {
					echo 'selected';
				} else {
					if ($lugar==0) {
						echo 'selected';
					}
				}
				echo '>No seleccionado</option>';
				$resultado_lugares = $conexion->ejecutarInstruccion(
					"SELECT CODIGO_LUGAR,NOMBRE_LUGAR FROM TBL_LUGARES");
				oci_execute($resultado_lugares);
				while ($fila = $conexion->obtenerFila($resultado_lugares)) {
					echo '<option value="'.$fila["CODIGO_LUGAR"].'" ';
					if ($lugar == $fila["CODIGO_LUGAR"]) {
						echo 'selected';
					}
					echo '>'.$fila["NOMBRE_LUGAR"].'</option>';
				}
			?>
			</select>

			<!--id: cmb_categoria -> combobox que contendra todas las categorias de la base de datos-->
			<label for="cmb_categoria" style="margin-bottom: -10px; margin-top: 30px;"><h6>Categoría</h6></label>
			<select id="cmb_categoria" class="form-control" style="width: 95%;" onchange="refrescarCategoria()">
			<?php
				echo '<option value="0" ';
				if (!isset($_GET["categoria"])) {
					echo 'selected';
				} else {
					if ($categoria==0) {
						echo 'selected';
					}
				}
				echo '>No seleccionado</option>';
				$resultado_categorias = $conexion->ejecutarInstruccion(
					"SELECT CODIGO_CATEGORIA,NOMBRE_CATEGORIA FROM TBL_CATEGORIAS");
				oci_execute($resultado_categorias);
				while ($fila = $conexion->obtenerFila($resultado_categorias)) {
					echo '<option value="'.$fila["CODIGO_CATEGORIA"].'" ';
					if ($categoria == $fila["CODIGO_CATEGORIA"]) {
						echo 'selected';
					}
					echo '>'.$fila["NOMBRE_CATEGORIA"].'</option>';
				}
			?>
			</select>

			<!--Grupos de casillaspara seleccion multiple de subcategorias-->
		    <p id="div-subcategorias" style="margin-bottom: -10px; margin-top: 30px; text-align: justify;">
		    <?php 
		    	if ($categoria!=0) {
		    		$resultado_subcatego = $conexion->ejecutarInstruccion("
						SELECT A.CODIGO_SUB_CATEGORIA, A.NOMBRE_SUB_CATEGORIA FROM TBL_SUB_CATEGORIAS A
						INNER JOIN TBL_CATEGO_X_TBL_SUBCATEGO B
						ON A.CODIGO_SUB_CATEGORIA = B.CODIGO_SUB_CATEGORIA
						WHERE B.CODIGO_CATEGORIA = '$categoria'");
					oci_execute($resultado_subcatego);

					$subcategorias_ind = array();
					if ($subcategorias!="") {
						$subcategorias_ind = explode(",", $subcategorias);
					}

					while ($fila = $conexion->obtenerFila($resultado_subcatego)) {
						echo '<label>
							  <input type="checkbox" name="cbox_subcategorias" value="'.$fila["CODIGO_SUB_CATEGORIA"].'" id="cbox_subcategorias" onclick="refrescar()" ';
						for ($i=0; $i < count($subcategorias_ind) ; $i++) { 
							if ($subcategorias_ind[$i]==$fila["CODIGO_SUB_CATEGORIA"]) {
								echo ' checked';
							}
						}
						echo '> '.$fila["NOMBRE_SUB_CATEGORIA"].
					  		  '</label> <br>';
					}
		    	}
		    ?>
		    </p>

			<!--id: cmb_ordenar -> combobox que contiene los formatos de orden de la lista de productos-->
		    <label for="cmb_ordenar" style="margin-bottom: -10px; margin-top: 30px;"><h6>Ordenar por</h6></label>
			  <select id="cmb_ordenar" class="form-control" style="width: 95%;" onchange="refrescar()">
				<option value="1" <?php if($orden==1){echo'selected';}?> >Más Reciente</option>
				<option value="2" <?php if($orden==2){echo'selected';}?> >Más Antiguo</option>
				<option value="3" <?php if($orden==3){echo'selected';}?> >Más Barato</option>
				<option value="4" <?php if($orden==4){echo'selected';}?> >Más Caro</option>
				<option value="5" <?php if($orden==5){echo'selected';}?> >Mejores Vendedores</option>
				<option value="6" <?php if($orden==6){echo'selected';}?> >Primero Vendedores Individuales</option>
				<option value="7" <?php if($orden==7){echo'selected';}?> >Primero Vendedores Empresariales</option>
			  </select>


			<!--name: opcion_moneda -> botones de radio para seleccionar el tipo de moneda de los productos
				radio lempiras->id: rb_lempiras
				radio dolares->id: rb_dolares
			-->
		    <center style="margin-bottom: 5px; margin-top: 30px;">
				  <div class="btn-group btn-group-toggle" data-toggle="buttons">
					  <label style="text-transform: none;" class="btn btn-secondary btn-sm col-lg-6">
						<input type="radio" name="opcion_moneda" id="rb_lempiras" value="1"
						 <?php if($tipo_moneda==1){echo ' checked';} ?> >Lempiras
					  </label>
					  <label style="text-transform: none;" class="btn btn-secondary btn-sm col-lg-6">
						<input type="radio" name="opcion_moneda" id="rb_dolares" value="2"
						<?php if($tipo_moneda==2){echo ' checked';} ?>>Dolares
					  </label>
				 </div>
		    </center><br>

			<!--Slider para controlar la cantidad de dinero maxima del precio de los productos
			id:slb_precio
			el valor minimo "min" debe contener el menor precio del producto mas barato de la base de datos
			el valor maximo "max" debe contener el mayor precio del producto mas caro de la base de datos
			el valor "value" del slider debe ser el valor maximo-->
			<div class="slidecontainer">
				Rango máximo de precio:
			  <span class="font-weight-bold text ml-2 valorPrecio" style="color:#15B714;"></span>
			  <input type="range" min="0" max="50000" value="<?php echo $precio_max; ?>" class="slider" id="slb_precio">
			</div>  
			  
		  </div>	  
	    </div>
		<!-- /#Barra lateral -->
		
		<!-- Contenido de la pagina -->
		<div id="page-content-wrapper">
			<!--Boton para desplegar la barra lateral-->
		    <button type="button" id="menu-toggle" class="sidebar-btn">
				<span></span>
				<span>
					<img src="recursos/imagenes/Lupa.png" style="width: 25px; height: 25px; margin-top:-28px; margin-left: -10px;">
				</span>
				<span></span>
			</button>
			
			<div class="container" style="padding-left: 15px; margin-top:10px;">
				<?php 
					//primera pagina de la lista
					$limiteInferior = ($_GET['pagina']-1)*$productosAMostrar;
					
					//ultima pagina de la lista
					$limiteSuperior = $limiteInferior + $productosAMostrar;

					//productos acotados entre los limites
					$busquedaProductos = $conexion->ejecutarInstruccion(
						"SELECT * FROM (
							SELECT  A.CODIGO_PUBLICACION_PRODUCTO,
							        A.CODIGO_TIPO_MONEDA,
							        A.NOMBRE_PRODUCTO,
							        A.PRECIO,
							        A.DESCIPCION,
							        (to_date(SYSDATE, 'dd/mm/yyyy') - to_date(A.FECHA_PUBLICACION, 'dd/mm/yyyy')) FECHA_PUBLICACION,
							        E.RUTA_IMAGEN,
							        F.NOMBRE_LUGAR,
							        ROW_NUMBER() OVER(".$sql_orden.") RN
							FROM TBL_PUBLICACION_PRODUCTOS A
							INNER JOIN TBL_VEND_X_TBL_PUBLI B ON A.CODIGO_PUBLICACION_PRODUCTO=B.CODIGO_PUBLICACION_PRODUCTO
							INNER JOIN TBL_USUARIOS C ON B.CODIGO_USUARIO_VENDEDOR=C.CODIGO_USUARIO
							INNER JOIN (
							        SELECT MIN(CODIGO_IMAGEN) CODIGO_IMAGEN, CODIGO_PRODUCTO FROM TBL_PROD_X_TBL_IMG
							        GROUP BY CODIGO_PRODUCTO
							        ) D ON A.CODIGO_PUBLICACION_PRODUCTO=D.CODIGO_PRODUCTO
							INNER JOIN TBL_IMAGENES E ON D.CODIGO_IMAGEN=E.CODIGO_IMAGEN
							INNER JOIN TBL_LUGARES F ON F.CODIGO_LUGAR=C.CODIGO_LUGAR 
							INNER JOIN TBL_VENDEDORES G ON G.CODIGO_USUARIO_VENDEDOR = B.CODIGO_USUARIO_VENDEDOR
							".$sql_subcatego1." 
							WHERE A.CODIGO_ESTADO_PUBLICACION = 1
							AND UPPER(A.NOMBRE_PRODUCTO) LIKE UPPER('%$busca%')
							".$sql_lugar."
							".$sql_categoria." 
							".$sql_moneda." 
							".$sql_precio." 
							".$sql_subcatego2." 
							".$sql_orden.")
						WHERE RN BETWEEN $limiteInferior+1 AND $limiteSuperior"
					);
					oci_execute($busquedaProductos);
					
					//Se imprimiran todos los productos seleccionados
					$cantidad = 0;
					$codigo_anterior = 0;
					while ($fila = $conexion->obtenerFila($busquedaProductos)) {
						$tiempo_publicado = "hace " . $fila["FECHA_PUBLICACION"] . " días.";
						if ($fila["FECHA_PUBLICACION"]==0) {
							$tiempo_publicado = "hoy.";
						}
						if ($codigo_anterior!=$fila["CODIGO_PUBLICACION_PRODUCTO"]) {
							echo'<a href="InfodeProductos.php?codigo-publicacion='.$fila["CODIGO_PUBLICACION_PRODUCTO"].'" id="link-productos"><div class="card mini" style="margin-bottom:10px">
							  <div class="card-body">	
								 <div class="row">
									<div class="col-lg-3">';
										echo'<img src="'.$fila["RUTA_IMAGEN"].'" style="width:90%;">'; 
									echo'</div>
									
									<div class="col-lg-9">';
										echo'<h5 class="card-title">'.$fila["NOMBRE_PRODUCTO"].'</h5>';
										echo'<img src="img/pin.png" width=15 height=15>'.$fila["NOMBRE_LUGAR"];
										echo'<p class="card-text">'.$fila["DESCIPCION"].'</p>';
										echo'<h6 style="color:#15B714;">';
										if ($fila["CODIGO_TIPO_MONEDA"] == 1) {
											echo 'L. ';
										} else {
											echo '$ ';
										}
										echo $fila["PRECIO"].'</h6>';
										echo'<img src="img/calendar.png" width=15 height=15> Publicado ' . $tiempo_publicado;
									echo'</div>
									
								</div>
							  </div>
							</div></a>';
							$codigo_anterior = $fila["CODIGO_PUBLICACION_PRODUCTO"];
						}
						$cantidad++;
					}
					if ($cantidad==0) {
						echo'<h5>No se encontraron resultados</h5>';
					}
					if ($cantidad!=0) {
				?>
				
				<!--Control de paginacion para cambiar de una pagina a otra-->
				<nav aria-label="Paginacion" class="Paginacion">
				  <ul class="pagination justify-content-center">
					
					<!--boton que lleva a una pagina anterior, no es nesesario modificar este componente-->
				    <li class="page-item
						<?php echo $_GET['pagina']-1 == 0 ? ' disabled' : '' ?>
					"> 
					<a class="page-link" 
						href="BusquedaP.php?pagina=<?php echo ($_GET['pagina']-1) . $parametros ?>"
					> Anterior</a>
					</li>
					
					<!--Imprime cada una de las paginas especificadas en la cantidad de paginas 
					si se especifican 13 paginas habran 13 botones numerados, si se especifican n 
					botones habran n botones numerados, todabia no esta controlado el limite de botones de botones
					asi que si se usan muchos es posible que se salga de la pantalla-->
					<?php for($i=0; $i < $paginas; $i++):?>
				    <li class="page-item 
					<?php 
						echo $_GET['pagina']==$i+1 ? 'active' : '' 
					?>"><a class="page-link" <?php if(($_GET['pagina']-1)==$i){echo'style="background-color:#72A276;color:white;border-color:white"';} ?> href="BusquedaP.php?pagina=<?php echo ($i+1).$parametros;?>">
					<?php echo $i+1;?>
					</a></li>
					<?php endfor ?>


					<!--boton que lleva a la siguiente pagina, no es nesesario modificar este componente-->
				    <li class="page-item
						<?php echo $_GET['pagina'] >= $paginas ? ' disabled' : '' ?>
					"> 
					<a class="page-link" 
					href="BusquedaP.php?pagina=<?php echo ($_GET['pagina']+1) . $parametros ?>"
					> Siguiente</a>
					</li>
			      </ul>
			  </nav>
			  <?php } ?>
            </div>
	  </div>
	  <!-- /#Contenido de la pagina -->
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

	<!--Agregando bootstrap al archivo html-->
<script src="js/jquery.js"></script><!--Lanzar archivo jquery-->
<script src="js/controlador_busquedas.js"></script><!--Controlador de la pagina-->
<script src="js/bootstrap.min.js"></script><!--Lanzar archivo Bootstrap.js-->
<script>//JavaScript
		$(document).ready(function() {
			
		  const $valueSpan = $('.valorPrecio');
		  const $value = $('#slb_precio');
		  $valueSpan.html($value.val());
		  if ($value.val()==50000) {
		  	$valueSpan.html("Ilimitado");
		  }
		  $value.on('input change', () => {
		  	if ($value.val()==50000) {
		  		$valueSpan.html("Ilimitado");
		  	} else {
		  		$valueSpan.html($value.val());
		  	}
		  });
		});

		//Boton para desplegar la barra lateral
		$(document).ready(function () {
            $("#menu-toggle").on('click', function () {
                $("#wrapper").toggleClass("toggled");
                $(this).toggleClass('active');
            });
        });

		//buscar por filtro de precio
		$("#slb_precio").click(function(){
			$("#btn_buscar").click();
		});

		//buscar for filtro de moneda
		$("#rb_lempiras").click(function(){
			$("#btn_buscar").click();
		});
		$("#rb_dolares").click(function(){
			$("#btn_buscar").click();
		});

		//función para refrescar la busqueda al cativar los combobox
		function refrescar(){
			$("#btn_buscar").click();
		}
		
		//buscar cuando cambia de categoria
		function refrescarCategoria(){
			$('input[name="cbox_subcategorias"]:checked').each(function(){
	            $(this).prop("checked", false);
	        });
			$("#btn_buscar").click();
		}

</script>	
	
</body>
</html>