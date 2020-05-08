$(document).ready(function(){
	$("#tienda1").hide();
	$("#tienda2").hide();
	$("#correo-enviado").hide();
	$("#cargando").hide();
	$("#r-cargando").hide();
	$("#btn_registrarse").click(function(){
		var nombre = $("#txt-nombre").val();
		var apellido = $("#txt-apellido").val();
		var correo = $("#txt-correo").val();
		var contrasena = $("#txt-contrasena").val();
		var confirmar_contrasena = $("#txt-confirmar-contrasena").val();
		var telefono = $("#txt-telefono").val();
		var ubicacion = $("#slc-ubicacion").val(); 
		var dia = $("#txt-dia").val(); 
		var mes = $("#slc-mes").val();
		var anio = $("#txt-anio").val();
		var vendedor = $('input[name="opcion-tienda"]:checked').val();
		var nombre_tienda = $("#txt-nombre-tienda").val();
		var rtn = $("#txt-rtn").val();

		var acepta = $("input:checkbox[name=aceptar]:checked");

		var contrasena_enviar = "";

		if (nombre=="" && apellido=="" && correo=="" && contrasena=="" && confirmar_contrasena=="" && telefono=="" 
			&& ubicacion=="" && dia=="" && mes=="" && anio=="") {
			$("#mensaje1").fadeIn();
			$("#mensaje2").fadeIn();
			$("#mensaje3").fadeIn();
			$("#mensaje4").fadeIn();
			$("#mensaje5").fadeIn();
			$("#mensaje6").fadeIn();
			$("#mensaje7").fadeIn();
			$("#mensaje8").fadeIn();
			$("#mensaje13").fadeIn();
			$("#mensaje14").fadeIn();
		}
		else{
			$("#mensaje1").fadeOut()
			$("#mensaje2").fadeOut()
			$("#mensaje3").fadeOut()
			$("#mensaje4").fadeOut()
			$("#mensaje5").fadeOut()
			$("#mensaje6").fadeOut()
			$("#mensaje7").fadeOut()
			$("#mensaje8").fadeOut()
			$("#mensaje13").fadeOut()
			$("#mensaje14").fadeOut()
			if (nombre == "") {
				$("#mensaje1").fadeIn();
				return false;
			}
			else{
				$("#mensaje1").fadeOut();
				if (apellido == "") {
					$("#mensaje2").fadeIn();
					return false;
				}
				else{
					$("#mensaje2").fadeOut();
					if (correo == "") {
						$("#mensaje3").fadeIn();
						return false;
					}
					else{
						$("#mensaje3").fadeOut();
						if (contrasena == "") {
							$("#mensaje4").fadeIn();
							return false;
						}
						else{
							$("#mensaje3").fadeOut();
							if (confirmar_contrasena == "") {
								$("#mensaje5").fadeIn();
								return false;
							}
							else{
								$("#mensaje5").fadeOut();
								if (contrasena != confirmar_contrasena) {
									$("#mensaje9").fadeIn();
									return false;
								}
								else{
									$("#mensaje9").fadeOut();
									contrasena_enviar = contrasena;
									if (telefono == "" || telefono.length > 8 || telefono.length < 8) {
										$("#mensaje6").fadeIn();
										return false;
									}
									else{
										$("#mensaje6").fadeOut();
										if (ubicacion == "") {
											$("#mensaje7").fadeIn();
											return false;
										}
										else{
											$("#mensaje7").fadeOut();
											if (dia == "" || mes == "" || anio =="") {
												$("#mensaje8").fadeIn();
												return false;
											}
											else{
												$("#mensaje8").fadeOut();
												if (dia<1 || dia>31) {
													$("#mensaje10").fadeIn();
													return false;
												}
												else{
													$("#mensaje10").fadeOut();
													if (anio<1900 || anio >2001) {
														$("#mensaje11").fadeIn();
														return false;
													}else{
														$("#mensaje11").fadeOut();
														if (acepta.length == 0) {
															$("#mensaje12").fadeIn();
														}
														else{
															$("#mensaje12").fadeOut();

															var parametros = 	"txt-nombre="+nombre+ 
																				"&txt-apellido="+apellido+
																				"&txt-correo="+correo+
																				"&txt-contrasena-enviar="+contrasena_enviar+
																				"&txt-telefono="+telefono+
																				"&slc-ubicacion="+ubicacion+
																				"&txt-dia="+dia+
																				"&slc-mes="+mes+
																				"&txt-anio="+anio+
																				"&rb-vendedor="+vendedor;

															if (vendedor==2) {
																if (nombre_tienda == "") {
																	$("#mensaje13").fadeIn();
																	return false;
																}
																else{
																	$("#mensaje13").fadeOut();
																	if (rtn == "" || rtn.length != 14) {
																		$("#mensaje14").fadeIn();
																		return false;
																	}
																	else{
																		$("#mensaje14").fadeOut();

																		parametros = 	parametros+
																						"&txt-nombre-tienda="+nombre_tienda+
																						"&txt-rtn="+rtn;
																	}
																}
															}

															$("#r-cargando").show();
															$("#btn_registrarse").prop('disabled', true);
															//alert(parametros);
															
															$.ajax({
																	url:"ajax_procesar_php/acciones_registrar.php",
																	data:parametros,
																	method:"POST",
																	//dataType:"json",
																	success:function(respuesta1){
																		//$("#prueba").html(respuesta);
																		//alert(respuesta1);
																		$("#r-cargando").hide();
																		$("#btn_registrarse").prop('disabled', false);
																		if(respuesta1 == 0){
																			alert("Lo sentimos, el correo ingresado ya existe o no es valido, porfavor intente con uno nuevo...");
																			$("#txt-correo").val("");
																		}
																		else{
																			alert("Registrado con exito!, Se envio la informacion a su direccion de correo electronico");
																			window.location="index.php";
																		}
																	}
															});	
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}		
		}					
	});

	//Funcion para ejecutar al presionar enter
	$("#txt-contrasena").keypress(function(e) {
	    var code = (e.keyCode ? e.keyCode : e.which);
	    if(code==13){
	        $("#btn_iniciar").click();
	    }
	});

	$("#btn-busqueda").click(function(){
		var busca = $("#txt-barraBusqueda").val();
		window.location="BusquedaP.php?pagina=1&busca="+busca+"";
	});

	$("#txt-barraBusqueda").keypress(function(e) {
	    var code = (e.keyCode ? e.keyCode : e.which);
	    if(code==13){
	        var busca = $("#txt-barraBusqueda").val();
			window.location="BusquedaP.php?pagina=1&busca="+busca+"";
	    }
	});

	$("#btn_iniciar").click(function(){

		var correo = $("#txt-correo").val();
		var contrasena = $("#txt-contrasena").val();

		if (correo=="" && contrasena=="") {
			$("#mostrar_error_login").fadeIn();
			return false;
		}
		else{
			$("#mostrar_error_login").fadeOut()
			var parametros = 	"&txt-correo="+correo+"&txt-contrasena="+contrasena;
			//alert(parametros);

			$.ajax({
				url:"ajax_procesar_php/acciones_login.php",
				data:parametros,
				method:"POST",
				success:function(respuesta){
					//alert(respuesta);
					if(respuesta == 0){
						alert("El usuario o la contraseña ingresada no existe...");
						$("#txt-correo").val("");
						$("#txt-contrasena").val("");
					}
					else{
						//alert("El usuario ingresado existe... "+respuesta);
						window.location="index.php";
					}
				}
			});	
		}
	});
	
	$("#rb-individual").click(function() {
		$("#tienda1").hide();
		$("#tienda2").hide();
	});

	$("#rb-empresarial").click(function() {
		$("#tienda1").show();
		$("#tienda2").show();
	});

	$("#btn_codigo").click(function() {
		var correo = $("#txt-correo-restablecer").val();
		if (correo=="") {
			$("#mensaje15").fadeIn();
			return false;
		}else{
			$("#mensaje15").fadeOut();
			$("#cargando").show();
			var parametros = 	"&boton=1&txt-correo="+correo;
			//alert(parametros);

			$.ajax({
				url:"ajax_procesar_php/acciones_restablecer.php",
				data:parametros,
				method:"POST",
				success:function(respuesta){
					//alert(respuesta);
					if(respuesta == 0){
						$("#mensaje16").fadeIn();
						$("#cargando").hide();
					}else{
						$("#mensaje16").fadeOut();
						$("#cargando").hide();
						$("#correo-enviado").show();
						$("#btn_cambio_contrasena").prop('disabled', false);
						//$("#btn_cambio_contrasena")
						$("#btn_codigo").text('Reenviar código');
						//alert("codigo de usuario: "+respuesta);
					}
				}
			});	
		}
	});

	$("#mensaje21").hide();
	$("#btn_cambio_contrasena").click(function() {
		var correo = $("#txt-correo-restablecer").val();
		var codigo = $("#txt-codigo").val();
		var contrasena = $("#txt-contrasena-nueva").val();
		var confirmar_contrasena = $("#txt-contrasena-nueva-c").val();
		if (correo=="") {
			$("#mensaje15").fadeIn();
			return false;
		}else{
			$("#mensaje15").fadeOut();
			if (codigo=="") {
				$("#mensaje17").fadeIn();
				return false;
			}else{
				$("#mensaje17").fadeOut();
				$("#mensaje18").fadeOut();
				if (contrasena=="") {
					$("#mensaje19").fadeIn();
					return false;
				}else{
					$("#mensaje19").fadeOut();
					if (contrasena!=confirmar_contrasena) {
						$("#mensaje20").fadeIn();
						return false;
					}else{
						$("#mensaje20").fadeOut();

						var parametros = 	"&boton=2&txt-correo="+correo+
											"&txt-codigo="+codigo+
											"&txt-contrasena="+contrasena;
						//alert(parametros);

						$.ajax({
							url:"ajax_procesar_php/acciones_restablecer.php",
							data:parametros,
							method:"POST",
							success:function(respuesta){
								//alert(respuesta);
								if(respuesta == 0){
									//el correo no existe
									$("#mensaje16").fadeIn();
								}
								if(respuesta == 1){
									//el codigo ingresado es invalido
									$("#mensaje18").fadeIn();
								}
								if(respuesta == 2){
									//exito al restablecer
									$("#btn_codigo").prop('disabled', true);
									$("#btn_cambio_contrasena").prop('disabled', true);
									$("#mensaje21").show();
									window.setTimeout(function() { window.location="index.php"; }, 3000);
								}
								else{
									$("#mensaje16").fadeOut();
									$("#correo-enviado").show();
								}
							}
						});	

					}
				}
			}
		}
	});

});



