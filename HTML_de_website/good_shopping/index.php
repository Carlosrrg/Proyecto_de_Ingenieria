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
<body>
	<?php
        include_once("class/conexion_copy.php");
        session_start();
        $conexion = new Conexion();
    ?>
	<!--Barra-->
	<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #72a276;">
		<!-- centrar horizontalmente mx-auto -->
		<!-- ml-auto: meter margen por la izquierda -->
		<!-- mr-auto: meter margen por la derecha -->
		<!-- Menú desplegable de categorias -->
		<div class="mr-auto nav-item dropdown" >
			<a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
				<img src="recursos/imagenes/Menu.png" width=20>
			</a>
			<div class="dropdown-menu dropright" style="align-content: initial; margin: 6px 0 0 -17px; border-radius: 0px;">
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
		<a href="#" class="navbar-brand mr-auto" style="background-color: #72a276;"><img src="img/logo.png" width=50 height="40"></a>

		<!--gestion de sesión -->
		<div class="nav-item dropdown">
			<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Usuario</a>
			<div class="dropdown-menu" style="margin: 9px 0 0 -40px;">
				<a class="dropdown-item dropdown" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Iniciar Sesión</a>
				
				<!--formulario para iniciar sesión -->
				<div class="dropdown-menu" style="margin: -82px 0 0 -80px;">
					<div class="px-4 py-3">
						<div class="form-group">
							<label for="txt-correo">Correo Electrónico</label>
							<input type="email" class="form-control" id="txt-correo" name="txt-correo" placeholder="email@example.com">
						</div>
						<div class="form-group">
							<label for="txt-contrasena">Contraseña</label>
							<input type="password" class="form-control" id="txt-contrasena" name="txt-contrasena" placeholder="Contraseña">
						</div>
						<div class="form-group">
							<div class="form-check">
							<input type="checkbox" class="form-check-input" id="dropdownCheck">
							<label class="form-check-label" for="dropdownCheck">
								Recordar
							</label>
							</div>
						</div>
						<button type="submit" id="btn_iniciar" name="btn_iniciar" class="btn btn-primary">Iniciar Sesión</button>
					</div>
						<div id="mostrar_error_login" class="error_login">Ingrese el correo y la contrasena.</div>
						<!--<div id="mostrar_error_login2" class="error_login">Correo o Contraseña incorrectos</div>-->
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Restablecer Contraseña</a>
				</div>
				<a class="dropdown-item" href="modulo_registro.html">Registrarse</a>
			</div>
		</div>
	</nav>
	
	<!--Barra de busqueda-->
	<br>
	<div class="container">
		<div class="input-group mb-3">
			<input id="txt-barraBusqueda" name="txt-barraBusqueda" type="text" class="form-control" placeholder="¿Qué estas buscando?">
			<div class="input-group-append">
			  <button class="btn btn-outline-secondary" type="button" style="background: #fff;">
				<img src="recursos/imagenes/Lupa.png" width="20">
			</button>
			</div>
		  </div>
	</div>

	<!--Grupo de botones de departamentos Small boxes (Stat box) -->
	<br>
	<div class="box box-success" style = "padding-top:0%; padding-left:7%; padding-right:7%; padding-bottom: 5%;">
		<div class="row" style="background: #d3d0cb; border-top-left-radius:10px; border-top-right-radius:10px;">
			<div class="col-lg-12">
					<br>
					<center>
					<section class="content-header">
						<span>
							<h3>Departamento</h3>					
						</span>
					</section>
					<br>
				</center>
			</div>
		</div>
		<div class="row" style="background: #d3d0cb;">
				<div class="col-lg-3 col-xs-9">
				<!-- small box -->
				<div class="small-box">
					<div class="inner" style="text-align:center;">
					
				
						<a href="#" class="button radius">
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

						<a href="#" class="button radius">
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
						
						<a href="#" class="button radius">
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
						
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
							<span>
								Copán
							</span>
						</a> 

					</div>
				
				</div>
				</div>
				<div class="col-lg-3 col-xs-9">
					<div class="inner" style="text-align:center">
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
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
					
						<a href="#" class="button radius">
							<span>
								Gracias a Dios
							</span>
						</a>
			
					</div>    
				</div>
			</div>
			<!--Linea inferior-->
			<div class="row" style="padding-top:3%; background: #d3d0cb; border-bottom-left-radius:10px; border-bottom-right-radius:10px;">
			</div>
	</div>

	<!--Pie de página-->
	<div class="clearfix">
		<footer class="footer" style="background: #fff; margin-top:1px;">
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
						<button class="btn btn-primary"><img src="recursos/imagenes/Facebook.png" width="25"></button>
						<button class="btn btn-warning"><img src="recursos/imagenes/Instagram.png" width="25"></button>
						<button class="btn btn-primary"><img src="recursos/imagenes/Twiter.png" width="30"></button>
					</div>
				</div>
			</div>		
		</footer>
	</div>
	
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