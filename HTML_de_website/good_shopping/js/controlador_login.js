$(document).ready(function(){
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
																				"&txt-anio="+anio;
															//alert(parametros);

															$.ajax({
																	url:"ajax_procesar_php/acciones_registrar.php",
																	data:parametros,
																	method:"POST",
																	//dataType:"json",
																	success:function(respuesta1){
																		//$("#prueba").html(respuesta);
																		//alert(respuesta1);
																		if(respuesta1 == 1){
																			alert("Lo sentimos, el correo ingresado ya existe, intente con uno nuevo...");
																			$("#txt-correo").val("");
																		}
																		else if (respuesta1 == 2){
																			alert("Datos ingresados con exito");
																			//window.location="modulo_registro.html";
																		}
																		else if (respuesta1 == 3){
																			alert("Lo sentimos, el correo electronico ingresado es invalido...");
																			//$("#txt-correo").val("");
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
						alert("El usuario ingresado no existe...");
						$("#txt-correo").val("");
						$("#txt-contrasena").val("");
					}
					else{
						alert("El usuario ingresado existe... "+respuesta);
						window.location="index.php";
					}
				}
			});	
		}
	});
});