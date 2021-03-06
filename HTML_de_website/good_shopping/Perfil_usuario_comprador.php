<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Perfil</title>
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
						echo '<a href="Productos_y_servicios.php" class="list-group-item list-group-item-action bg-light"><span><h6><i class="fas fa-shopping-bag"></i> Mis Productos</h6></span></a>'; 
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
										echo '<a href="Perfil_usuario_comprador.php" class=" list-group-item-action bg-light" style="font-weight:bold; margin-left:-39px;">comprador</a><br>';
										echo '<a href="Productos_y_servicios.php" class=" list-group-item-action bg-light" style="margin-left:-39px;">vendedor</a>';
									echo '</div>';
								echo '</div><br>';
							}
							

						echo '</div>';
			  			echo '<br>';

			  			echo '<div class="list-group list-group-flush" style="width:99.5%;">'; 
							echo '<a href="Notificaciones.php" class="list-group-item list-group-item-action bg-light"><span>
								<h6><i class="fas fa-money-bill-alt"></i> Notificaciones</h6></span></a>';
					  	echo '</div>';
					  	
					    echo '<div class="sidebar-heading"><span><h6><i class="fas fa-home"> </i> Mi Cuenta</h6></span></div>';
					    echo '<div class="list-group list-group-flush">';
						    echo '<div class="ml-4 col-md-10 col-11 col-lg-10">';
							    echo '<a href="Perfil_usuario_comprador.php" class=" list-group-item-action bg-light">Editar Perfil</a>';
							    echo '<br>';  
							    echo '<a href="favoritos.php" class=" list-group-item-action bg-light">Favoritos</a>';
						    echo '</div>';
					    echo '</div>';
					}
			  	}

			  	
			?>
	    </div>
		<!-- /#sidebar-wrapper -->
		
		<?php
			if (!isset($_SESSION['codigo_usuario_sesion'])) {			
				echo '<div style="margin-left: 50px; margin-top: 50px">No has iniciado sesión, '." ".' <a href="index.php">Inicia Sesión</a> '." ".' para editar tu Perfil de Vendedor</div>';
			}
			else{
				$resultado_usuario = $conexion->ejecutarInstruccion("	SELECT A.NOMBRE, A.APELLIDO, A.TELEFONO, A.CIUDAD, B.NOMBRE_LUGAR, 
																		C.CODIGO_TIPO_VENDEDOR,
																		TO_CHAR(A.FECHA_NACIMIENTO,'DD') AS FECHA_DIA,
																		TO_CHAR(A.FECHA_NACIMIENTO,'MM') AS FECHA_MES,
																		TO_CHAR(A.FECHA_NACIMIENTO,'YYYY') AS FECHA_ANIO
																		FROM TBL_USUARIOS A
																		INNER JOIN TBL_LUGARES B
																		ON(A.CODIGO_LUGAR = B.CODIGO_LUGAR)
																		INNER JOIN TBL_VENDEDORES C
																		ON(A.CODIGO_USUARIO= C.CODIGO_USUARIO_VENDEDOR)
																		WHERE CODIGO_USUARIO = '$usuario'");
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
						echo '<div class="container-fluid">';
							echo '<div class="row">';

							  echo '<div class="col-lg-1 col-md-2 col-sm-2">';		 
								echo '<div class="col-md-2 col-lg-1 col-sm-2">';
  				
								echo '</div>';           
							echo '</div>';
							


							echo '<div class="col-md-7 col-lg-8 col-sm-7">';
								echo '<div style= "text-align:left" >';

								  	echo '<div style="margin-top: 25px;"><h5 style="padding-left: -20%" class="col-lg-12">Editar mi Perfil</h5></div>';
			     					
								  	if ($fila["CODIGO_TIPO_VENDEDOR"] == 1) {
								  		echo '<hr>';
								  		echo '<h5>Logo de vendedor</h5>';
								  		$ruta_imagen = "recursos/imagenes/ImagenUsuario.png";

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
									    echo '<input type="file" id="btn-logo" name="btn-logo" class="btn file-loading" accept="image/*">';
									    echo '<br>';
								  	}
								  	

			     					echo '<br>';
			     					echo '<input style="width: 80%;" type="text" class="form-control" id="txt-nombre" name="signup_form[displayname]" required="required" maxlength="100"';
			     						if (!isset($fila["NOMBRE"])) {
			     							echo 'placeholder="Nombre"';
			     						}
			     						else{
			     							echo 'value="'.$fila["NOMBRE"].'"';
			     						}
			     					echo '>';
			     						echo '<div id="mensaje1" class="errores">Ingrese un nombre</div>';
			     					echo '<br>';
			     					echo '<input style="width: 80%;" type="text" class="form-control" id="txt-apellido" name="signup_form[displayname]" required="required" maxlength="100"';
			     						if (!isset($fila["APELLIDO"])) {
			     							echo 'placeholder="Apellido"';
			     						}
			     						else{
			     							echo 'value="'.$fila["APELLIDO"].'"';
			     						}
			     					echo '>';
			     					echo '<div id="mensaje2" class="errores">Ingrese un apellido</div>';
			     					echo '<br>';
			     					echo '<input style="width: 80%;" type="text" class="form-control" id="txt-telefono" name="signup_form[displayname]" required="required" maxlength="100"';
			     					 	if (!isset($fila["TELEFONO"])) {
			     							echo 'placeholder="Telefono"';	
			     						}
			     						else{
			     							echo 'value="'.$fila["TELEFONO"].'"';
			     						}
			     					echo '>';
			     					echo '<div id="mensaje3" class="errores">Ingrese un numero de telefono valido</div>';
			     					echo '<br>';

			     					echo'<select style="width: 80%;" id="slc-ubicacion" name="slc-ubicacion" id="slc-ubicacion" required="" class="form-control">';
				     					$arreglo_ubicacion = array();
				     					$arreglo_ubicacion_codigo = array();
				     					$cont = 1;
				     					$resultado_lugares = $conexion->ejecutarInstruccion("	SELECT CODIGO_LUGAR, NOMBRE_LUGAR
																								FROM TBL_LUGARES");
										oci_execute($resultado_lugares);
										while ($fila2 = $conexion->obtenerFila($resultado_lugares)) {
											$arreglo_ubicacion_codigo[$cont] = $fila2["CODIGO_LUGAR"];
											$arreglo_ubicacion[$cont] = $fila2["NOMBRE_LUGAR"];
											$cont++;
										}

										for ($i=1; $i <= count($arreglo_ubicacion); $i++) { 
	                                        echo '<option value="'.$arreglo_ubicacion_codigo[$i].'"';
	                                        	if (isset($fila["NOMBRE_LUGAR"])){
                                                    if ($fila["NOMBRE_LUGAR"] == $arreglo_ubicacion[$i]) {
                                                        echo "selected = selected";
                                                    }
                                                }
	                                        echo '>'.$arreglo_ubicacion[$i].'</option>';
	                                    }
									echo'</select>';

									echo '<br>';
			     					echo '<input style="width: 80%;" type="text" class="form-control" id="txt-ciudad" name="signup_form[displayname]" required="required" maxlength="100"';
			     					 	if (!isset($fila["CIUDAD"])) {
			     							echo 'placeholder="Ciudad de residencia"';	
			     						}
			     						else{
			     							echo 'value="'.$fila["CIUDAD"].'"';
			     						}
			     					echo '>';
			     					echo '<div id="mensaje4" class="errores">Ingrese una ciudad</div>';
			     					echo '<br>';

		
			     					$arreglo_mes = array();
			     					$arreglo_mes[0] = "cero";
			     					$arreglo_mes[1] = "Enero";
			     					$arreglo_mes[2] = "Febrero";
			     					$arreglo_mes[3] = "Marzo";
			     					$arreglo_mes[4] = "Abril";
			     					$arreglo_mes[5] = "Mayo";
			     					$arreglo_mes[6] = "Junio";
			     					$arreglo_mes[7] = "Juilo";
			     					$arreglo_mes[8] = "Agosto";
			     					$arreglo_mes[9] = "Septiembre";
			     					$arreglo_mes[10] = "Octubre";
			     					$arreglo_mes[11] = "Noviembre";
			     					$arreglo_mes[12] = "Diciembre";

									echo'<div class="form-group" style="width: 80%;">';
                                        echo'<label class="control-label">Fecha de nacimiento</label>';
                                            echo'<div id="profile_birthdate" class="bootstrap-date row">';
                                                echo'<div class="col-md-4">';
                                                    echo'<select name="slc-dia" id="slc-dia" class="form-control">';
                                                        for ($i=1; $i < 32; $i++) { 
                                                            echo '<option value="'.$i.'"';
                                                                if (isset($fila["FECHA_DIA"])){
                                                                    if ($fila["FECHA_DIA"] == $i) {
                                                                        echo "selected = selected";
                                                                    }
                                                                }
                                                            echo '>'.$i.'</option>';
                                                        }
                                                    echo'</select>';
                                                echo'</div>';
                                                echo'<div class="col-md-4">';
                                                    echo'<select name="slc-mes" id="slc-mes" class="form-control">';
                                                        for ($i=0; $i < 13; $i++) {
                                                        	if ($arreglo_mes[$i] == "cero") {
                                                        	 	
                                                        	 }
                                                        	else{
	                                                        	echo '<option value="'.$i.'"';
	                                                            	if (isset($fila["FECHA_MES"])){
	                                                                    if ($fila["FECHA_MES"] == $i) {
	                                                                        echo "selected = selected";
	                                                                    }
	                                                                }
	                                                            echo '>'.$arreglo_mes[$i].'</option>';
                                                        	}   
                                                        }
                                                    echo'</select>';
                                                echo'</div>';
                                                    echo'<div class="col-md-4">';
                                                        echo'<select name="slc-anio" id="slc-anio" class="form-control">';
                                                            for ($i=1920; $i < 2021; $i++) { 
                                                                echo '<option value="'.$i.'"';
                                                                    if (isset($fila["FECHA_ANIO"])){
                                                                        if ($fila["FECHA_ANIO"] == $i) {
                                                                            echo "selected = selected";
                                                                        }
                                                                    }
                                                                echo '>'.$i.'</option>';
                                                            }
                                                        echo'</select>';
                                                    echo'</div>';
                                                echo'</div>';
                                       		echo'</div>';
									echo '</div>';
									echo '<div id="mensaje5" class="errores">Año invalido</div>';


									if ($fila["CODIGO_TIPO_VENDEDOR"] == 1) {
								  		$codigos_servicios = array();
									    $nombres_servicios = array();
									    $servicios_usuario = array();
									    $contcodigos = 1;
									    $contnombres = 1;
									    $contusuario = 1;

									    echo '<br>Servicios Ofrecidos:<br>';

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
								  	}


									echo '<div class="row">';
											echo '<div class="container-fluid" style="padding: 20px">';
												echo '<span>';
													echo '<button type="submit" id="editar_perfil" name="editar_perfil" class="btn btn-success">Guardar Cambios</button>';
												echo '</span>';
											echo '</div>';
									echo '</div>';

				} 

									echo "<hr><br>";

									echo '<div style="margin-top: 5px;"><h5 style="padding-left: -20%" class="col-lg-12">Cambiar Contraseña</h5></div>';

									echo '<input style="width: 80%;" type="password" class="form-control" id="txt-contrasena-actual" name="signup_form[displayname]" required="required" maxlength="100" placeholder="Contraseña actual">';
			     					echo "<br>";
			     					echo '<input style="width: 80%;" type="password" class="form-control" id="txt-contrasena-nueva" name="signup_form[displayname]" required="required" maxlength="100" placeholder="Nueva contraseña">';
			     					echo "<br>";
			     					echo '<input style="width: 80%;" type="password" class="form-control" id="txt-contrasena-confirmar" name="signup_form[displayname]" required="required" maxlength="100" placeholder="Confimar contraseña">';
			     					echo '<div id="mensaje6" class="errores">Las contraseñas no coinciden</div>';
			     					echo '<div id="mensaje7" class="errores">Por favor rellene los campos requeridos</div>';
								
			     					echo '<div class="row">';
											echo '<div class="container-fluid" style="padding: 20px">';
												echo '<span>';
													echo '<button type="submit" id="cambiar_contrasena" name="cambiar_contrasena" class="btn btn-success">Cambiar Contraseña</button>';
												echo '</span>';
											echo '</div>';
									echo '</div>';

									//eliminar cuenta
									echo '<hr><br><div style="margin-top: 10px;"><h5 style="padding-left: -20%" class="col-lg-12">Eliminar Cuenta</h5></div>';

									echo '<div class="row">';
											echo '<div class="container-fluid" style="padding: 20px">';
												echo '<span>';
													
													echo '<button type="button" class="btn btn-danger" data-toggle="modal" data-target=".bd-example-modal-sm">Confirmar eliminar cuenta</button>';
													echo '<p><b>Nota: </b>Una vez eliminada su cuenta no podrá volver a recuperarla y todas sus publicaciones serán eliminadas de la página.</p>';
												echo '</span>';
											echo '</div>';
									echo '</div>';

									//modal para eliminar cuenta
									echo '<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
									  <div class="modal-dialog modal-sm" role="document">
									    <div class="modal-content" style="padding:20px">
									      <center><b>¿Está seguro que quiere eliminar su cuenta para siempre?</b>
									      <p style="color:#DC3545">No podrá volver a recuperarla.</p><hr></center>
									      Introduzca su contraseña para confirmar
									      <input type="password" class="form-control" id="contrasena_eliminar" required="required"placeholder="Contraseña"><br>
									      <center>
									      <div id="mensaje10" class="errores" style="margin-left:240px">Contraseña inválida</div>
									      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">No</button>
        									<button type="button" id="btn_eliminar_cuenta" class="btn btn-success btn-sm">Sí, estoy seguro</button>
        								  </center>
									    </div>
									  </div>
									</div>';

								echo '</div>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
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
	<script src="js/controlador_editarPerfilVendedor.js"></script>
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