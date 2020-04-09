$(document).ready(function(){
	
	$("#editar_perfil").click(function(){

		var nombre = $("#txt-nombre").val();
		var apellido = $("#txt-apellido").val();
		var telefono = $("#txt-telefono").val();
		var departamento = $("#slc-ubicacion").val();
		var ciudad = $("#txt-ciudad").val();
		var dia = $("#slc-dia").val();
		var mes = $("#slc-mes").val();
		var anio = $("#slc-anio").val();

		var cont = 0;
		//var selected = '';
		var selected = [];      
        $('input:checkbox:checked').each(function(){

            	//selected += $(this).val();
                selected[cont] = $(this).val();
         		//alert(selected[cont++]);
         		cont++
        });

        var servicios = "";

        for (var i = 0; i < selected.length; i++) {
        	if (i == selected.length-1) {
        		servicios += selected[i];
        	}else{
        		servicios += selected[i]+",";
        	}
        }
        //alert(servicios);


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
				if (telefono == "" || telefono.length > 8 || telefono.length < 8) {
					$("#mensaje3").fadeIn();
					return false;
				}
				else{
					$("#mensaje3").fadeOut();
					if (ciudad == "") {
						$("#mensaje4").fadeIn();
						return false;
					}
					else{
						$("#mensaje4").fadeOut();
						if (anio >2001) {
							$("#mensaje5").fadeIn();
							return false;
						}
						else{
							$("#mensaje5").fadeOut();

							var parametros = 	"&txt-nombre="+nombre+
												"&txt-apellido="+apellido+
												"&txt-telefono="+telefono+
												"&slc-ubicacion="+departamento+
												"&txt-ciudad="+ciudad+
												"&slc-servicios="+servicios+
												"&slc-dia="+dia+
												"&slc-mes="+mes+
												"&slc-anio="+anio;
							//alert(parametros);

							$.ajax({
								url:"ajax_procesar_php/acciones_editarPerfilVendedor.php",
								data:parametros,
								method:"POST",
								success:function(respuesta){
									//alert(respuesta);
									if(respuesta == 0){
										alert("Error, Los datos no se pudieron actualizar...");
									}
									else{
										alert("Datos actualizados con exito...");
									}
								}
							});	
						}		
					}
				}
			}
		}


		//SUBE IMAGEN DE LOGO
		var formData = new FormData();
        var logo = $('#btn-logo')[0].files[0];
        if (logo) {
        	formData.append('logo',logo);
	        $.ajax({
	            url: 'ajax_procesar_php/imagen_vendedor_normal_logo.php',
	            type: 'post',
	            data: formData,
	            contentType: false,
	            processData: false,
	            success: function(response) {
	            	//alert(response);
	                if (response != 0) {
	                    //alert('Imagen subida en '+response);
	                } else {
	                    alert('Error al subir logo de tienda');
	                }
	            }
	        });	
        }

	});


	//cambiar imagenes de banner y logo
	$banner = false;
	$('#btn-banner').on('click', function(e) {
	     e.preventDefault();
	    $banner = true;
	    $('#banner').click();
	})


	$('input[type=file]').change(function() {
		if ($banner) {
			var reader = new FileReader();
			reader.onload = function (e) {
	        	$('#previewbanner img').attr('src', e.target.result);
	    	};
	    	reader.readAsDataURL(this.files[0]);
		 }else{
		 	var file = (this.files[0].name).toString();
		    var reader = new FileReader();
		    
		    $('#btn-logo').text('');
		    $('#btn-logo').text(file);
		    
		     reader.onload = function (e) {
		         $('#preview img').attr('src', e.target.result);
			 }
		     
		     reader.readAsDataURL(this.files[0]);

		 }
	     $banner = false;    
	});

	$('input').change(function() {
		$("#editar_tienda").prop('disabled', false);
	});
	$('input').keypress(function() {
		$("#editar_tienda").prop('disabled', false);
	});
	$('textarea').keypress(function() {
		$("#editar_tienda").prop('disabled', false);
	});
	


	$("#cambiar_contrasena").click(function(){

		var contrasena_actual = $("#txt-contrasena-actual").val();
		var contrasena_nueva = $("#txt-contrasena-nueva").val();
		var contrasena_confirmar = $("#txt-contrasena-confirmar").val();

		if (contrasena_actual == "" || contrasena_nueva == "" || contrasena_confirmar == "") {
			$("#mensaje7").fadeIn();
			return false;
		}
		else{
			$("#mensaje7").fadeOut();
			if (contrasena_nueva != contrasena_confirmar) {
				$("#mensaje6").fadeIn();
				return false;
			}
			else{
				$("#mensaje6").fadeOut();

				var parametros2 = 	"&txt-contrasena-actual="+contrasena_actual+
									"&txt-contrasena-nueva="+contrasena_nueva;


				$.ajax({
					url:"ajax_procesar_php/acciones_cambiarContrasena.php",
					data:parametros2,
					method:"POST",
					success:function(respuesta2){
						//alert(respuesta);
						if(respuesta2 == 0){
							alert("La contraseña actual ingresada es incorrecta...");
							$("#txt-contrasena-actual").val("");
							$("#txt-contrasena-nueva").val("");
							$("#txt-contrasena-confirmar").val("");
						}
						else if(respuesta2 == 1){
							alert("Contraseña actualizada con exito...");
							$("#txt-contrasena-actual").val("");
							$("#txt-contrasena-nueva").val("");
							$("#txt-contrasena-confirmar").val("");
						}
						else if(respuesta2 == 2){
							alert("Error, la contraseña ingresada no se pudo actualizar...");
						}
					}
				});	

			}
		}
	});
});
