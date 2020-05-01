<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Good Shopping</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="icon" type="image/jpg" href="img/logo2.png">
    <link rel="stylesheet" href="css/mensaje_error.css">
</head>
<body style ="margin:0; padding:0; display: flex; min-height: 100vh; flex-wrap: wrap; background-color: #F5F5F5;">
	<?php
        include_once("class/conexion_copy.php");
        session_start();
        $conexion = new Conexion();
    ?>
	<!--Barra-->
	<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #72a276; width: 100%; height:5%;">
		<!-- centrar horizontalmente mx-auto -->
		<!-- ml-auto: meter margen por la izquierda -->
		<!-- mr-auto: meter margen por la derecha -->
		<!-- Menú desplegable de categorias -->
		<div class="mr-auto nav-item dropdown" >
			<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				<img src="recursos/imagenes/Menu.png" width=20>
			</a>
			<div class="dropdown-menu dropright" style="overflow-y: auto; height: 590px; margin: 6px 0 0 -17px; border-radius: 0px;">
				<h6 style="text-align: center;">Categorías</h6>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="BusquedaP.php?pagina=1&categoria=1">Entretenimiento</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=1&subcategorias=1">Películas & Música</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=1&subcategorias=2">Computadoras & Accesorios</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=1&subcategorias=3">Consolas & Videojuegos</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=1&subcategorias=4">Celulares & Accesorios</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="BusquedaP.php?pagina=1&categoria=2">Vehículos</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=2&subcategorias=5">Comprar</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=2&subcategorias=6">Rentar</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="BusquedaP.php?pagina=1&categoria=3">Inmuebles</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=3&subcategorias=5">Comprar</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=3&subcategorias=6">Rentar</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="BusquedaP.php?pagina=1&categoria=4">Hogar</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=4&subcategorias=7">Muebles</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=4&subcategorias=8">Electrodomésticos</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=4&subcategorias=9">Jardín & Herramientas</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="BusquedaP.php?pagina=1&categoria=5">Empleos, Negocios & Servicios</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=5&subcategorias=10">Ofertas de empleo</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=5&subcategorias=11">Servicios a negocios</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=5&subcategorias=12">Servicios al público</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=5">Otros servicios</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="BusquedaP.php?pagina=1&categoria=6">Otros</a>
				<a class="dropdown-item" style="padding-left: 50px;" href="BusquedaP.php?pagina=1&categoria=6&subcategorias=13">Otros productos</a>
			</div>
		</div>

		<!--logo de la pagina -->
		<a href="#" class="navbar-brand mr-auto" style="background-color: #72a276;"><img src="img/logo.png" width=50 height="40"></a>

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
								echo'<button type="submit" id="btn_iniciar" name="btn_iniciar" class="btn btn-success">Iniciar Sesión</button>';
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
					echo '<h6 style="padding-top:4px; margin-right:-10px;">Saludos, &nbsp'.$fila["NOMBRE"].'</h6>';
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

	<!-- Modal de restablecer contraseña-->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalCenterTitle">Restablece tú contraseña</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="form-group">
				<label for="txt-correo-restablecer">Ingrese su correo electrónico</label>
				<input type="email" class="form-control" id="txt-correo-restablecer" name="txt-correo-restablecer" placeholder="email@example.com">
				<div id="mensaje15" class="errores">Campo obligatorio</div>
				<div id="mensaje16" class="errores">El correo ingresado no existe</div>
			</div>
			<center>
				<button type="submit" id="btn_codigo" name="btn_codigo" class="btn btn-success">Enviar código</button><br><br>
				<div class="spinner-border text-success" role="status" id="cargando">
				  <span class="sr-only">Loading...</span>
				</div>
			</center>
			<div id="correo-enviado">
				<div class="form-group">
					<label for="txt-codigo">Ingrese el código que le enviamos a su correo</label>
					<input type="text" class="form-control" id="txt-codigo" name="txt-codigo" placeholder="Código">
					<div id="mensaje17" class="errores">Campo obligatorio</div>
					<div id="mensaje18" class="errores">El código que ingreso es incorrecto</div>
				</div>
				<div class="form-group">
					<label for="txt-contrasena-nueva">Ingrese su nueva contraseña</label>
					<input type="password" class="form-control" id="txt-contrasena-nueva" name="txt-contrasena-nueva" placeholder="Nueva contraseña">
					<div id="mensaje19" class="errores">Ingrese una contraseña</div>
				</div>
				<div class="form-group">
					<label for="txt-contrasena-nueva-c">Confirmar contraseña</label>
					<input type="password" class="form-control" id="txt-contrasena-nueva-c" name="txt-contrasena-nueva-c" placeholder="Nueva contraseña a confirmar">
					<div id="mensaje20" class="errores">Las contraseñas no coinciden</div>
				</div>
			</div>
			<div id="mensaje21" style="color: green;">Se restablecio la contraseña con éxito. Vuelva a iniciar sesión.</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	        <button type="button" id="btn_cambio_contrasena" class="btn btn-success" disabled>Cambiar contraseña</button>
	      </div>
	    </div>
	  </div>
	</div>
	
	<!--Barra de busqueda-->
	<br>
	<div class="container barra" style="padding-top:30px;">
		<div class="input-group mb-3">
			<input id="txt-barraBusqueda" name="txt-barraBusqueda" type="text" class="form-control" placeholder="¿Qué estas buscando?">
			<div class="input-group-append">
			  <button class="btn btn-outline-secondary" type="button" id="btn-busqueda" style="background: #fff;">
				<img src="recursos/imagenes/Lupa.png" width="20">
			</button>
			</div>
		  </div>
	</div>

	<!--Grupo de botones de departamentos Small boxes (Stat box) -->
	<br>
	<div class="box box-success" style = "padding-top:0%; padding-left:7%; padding-right:7%; padding-bottom: 5%;">
		<div class="row" style="background: #E3E3E3; border-top-left-radius:10px; border-top-right-radius:10px;">
			<div class="col-lg-12">
					<br>
					<center>
					<section class="content-header">
						<span>
							<h3>Departamentos</h3>					
						</span>
					</section>
					<br>
				</center>
			</div>
		</div>
		<div class="row" style="background: #E3E3E3;">
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=1" class="button radius">
							<span>
								Francisco Morazán
							</span>
						</a>	
					</div>
				</div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=7" class="button radius">
							<span>
								Cortes
							</span>
						</a>	
					</div>
				</div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">		
						<a href="busquedaP.php?pagina=1&lugar=5" class="button radius">
							<span>
								Comayagua
							</span>
						</a>
					</div>		
				</div>
				</div><!-- ./col -->
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=3" class="button radius">
							<span>
							Choluteca 
							</span>
						</a>
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">		
						<a href="busquedaP.php?pagina=1&lugar=15" class="button radius">
							<span>
								Olancho
							</span>
						</a>
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=2" class="button radius">
							<span>
								Atlántida 
							</span>
						</a> 
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">	
						<a href="busquedaP.php?pagina=1&lugar=8" class="button radius">
							<span>
								El Paraíso
							</span>
						</a>    
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=11" class="button radius">
							<span>
								Islas de la Bahía 
							</span>
						</a>  
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=6" class="button radius">
							<span>
								Copán
							</span>
						</a> 
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
					<div class="inner" style="text-align:center">	
						<a href="busquedaP.php?pagina=1&lugar=17" class="button radius">
							<span>
								Valle
							</span>
						</a>  
					</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">	
						<a href="busquedaP.php?pagina=1&lugar=12" class="button radius">
							<span>
								La Paz 
							</span>
						</a>
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">	
						<a href="busquedaP.php?pagina=1&lugar=16" class="button radius">
							<span>
								Santa Bárbara
							</span>
						</a>
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=10" class="button radius">
							<span>
								Intibucá
							</span>
						</a>
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=13" class="button radius">
							<span>
								Lempira
							</span>
						</a>
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=18" class="button radius">
							<span>
								Yoro
							</span>
						</a>
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=14" class="button radius">
							<span>
								Ocotepeque
							</span>
						</a> 
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">

				</div>
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center; border-radius: 50px">
						<a href="busquedaP.php?pagina=1&lugar=4" class="button radius">
							<span>
								Colón
							</span>
						</a>
					</div>
					<div class="icon">
					</div>
				</div>
				</div>
				<div class="col-lg-3 col-xs-9" >
					<div class="inner" style="text-align:center;">
						<a href="busquedaP.php?pagina=1&lugar=9" class="button radius">
							<span>
								Gracias a Dios
							</span>
						</a>
					</div>    
				</div>
			</div>
			<!--Linea inferior-->
			<div class="row" style="padding-top:3%; background: #E3E3E3; border-bottom-left-radius:10px; border-bottom-right-radius:10px;">
			</div>
	</div>

	<!--Pie de página-->
	<footer style="background: #fff; margin-top:0px; width:100%; padding-bottom: 20px">
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

				<div class="col-xs-2 col-sm-3 " style="text-align:center; padding-left: 5%;">
					<br>
					<h6>Siguenos en</h6>
					<a href="https://www.facebook.com/Good-Shopping-106040207755389/?modal=admin_todo_tour" class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></a>
					<a href="https://www.pinterest.ca/GoodShoppingHn504/" class="btn btn-danger"><img src="recursos/imagenes/pinterest.png" width="25"></a>
					<a href="https://twitter.com/GoodShopping7" class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></a>
		</div>		
	</footer>
	
	<!--Agregando bootstrap al archivo html-->
	<script src="js/jquery.js"></script><!--Lanzar archivo jquery-->
	<script src="js/controlador_login.js"></script>
	<script src="js/bootstrap.min.js"></script><!--Lanzar archivo Bootstrap.js-->    
</body>
</html>
<?php
  	if(!isset($_SESSION['codigo_usuario_sesion'])){
                                                             
  	}
  	else{
  		$conexion->cerrarConexion();
  	}
?>