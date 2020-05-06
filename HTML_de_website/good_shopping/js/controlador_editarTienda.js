$(document).ready(function(){
	$("#editar_tienda").click(function(){

		var nombre_tienda = $("#txt-nombre-tienda").val();
		var correo_tienda = $("#txt-correo-tienda").val();
		var telefono_tienda = $("#txt-telefono-tienda").val();
		var direccion_tienda = $("#txt-direccion-tienda").val();
		var descripcion = $("#txt-descripcion").val();

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

		if (nombre_tienda == "") {
			$("#mensaje22").fadeIn();
			$('html, body').animate({scrollTop:0}, 'slow');
			return false;
		}
		else{
			$("#mensaje22").fadeOut();
			if (telefono_tienda == "" || telefono_tienda.length != 8) {
				$("#mensaje23").fadeIn();
				$('html, body').animate({scrollTop:0}, 'slow');
				return false;
			}
			else{
				$("#mensaje23").fadeOut();
				if (direccion_tienda == "") {
					$("#mensaje24").fadeIn();
					$('html, body').animate({scrollTop:0}, 'slow');
					return false;
				}
				else{
					$("#mensaje24").fadeOut();
					if (descripcion.length > 499) {
						$("#errorDescripcion").fadeIn();
						return false;
					}
					else{
						$("#errorDescripcion").fadeOut();
						$("#mensaje25").fadeOut();
						$("#mensaje26").fadeOut();

						var parametros = 	"&txt-nombre-tienda="+nombre_tienda+
											"&txt-correo-tienda="+correo_tienda+
											"&txt-telefono-tienda="+telefono_tienda+
											"&txt-direccion-tienda="+direccion_tienda+
											"&slc-servicios="+servicios+
											"&txt-descripcion="+descripcion;
						
						$.ajax({
							url:"ajax_procesar_php/acciones_editarTienda.php",
							data:parametros,
							method:"POST",
							success:function(respuesta){
								if (respuesta == 0) {
									//alert("El correo electronico ingresado es invalido, por favor ingrese uno nuevo...");
									$("#mensaje25").fadeIn();
									$("#txt-correo-tienda").val("");
								}
								if (respuesta == 2) {
									$("#mensaje26").fadeIn();
									$('html, body').animate({scrollTop:0}, 'slow');
								}
								else{
									$("#mensaje25").fadeOut();
									alert("Actualizado con exito...");
									window.location="EditarTienda.php";
								}
							}
						});	
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
	            url: 'ajax_procesar_php/imagen_tienda_logo.php',
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

        //SUBE IMAGEN DE BANNER
		var formData = new FormData();
        var banner = $('#banner')[0].files[0];
        if (banner) {
        	formData.append('banner',banner);
	        $.ajax({
	            url: 'ajax_procesar_php/imagen_tienda_banner.php',
	            type: 'post',
	            data: formData,
	            contentType: false,
	            processData: false,
	            success: function(response) {
	            	//alert(response);
	                if (response != 0) {
	                    //alert('Imagen subida en '+response);
	                } else {
	                    alert('Error al subir banner de tienda');
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
	$('input').keyup(function() {
		$("#editar_tienda").prop('disabled', false);
	});
	$('textarea').keyup(function() {
		$("#editar_tienda").prop('disabled', false);
		var descripcion = $("#txt-descripcion").val();
		if (descripcion.length > 499) {
			$("#errorDescripcion").fadeIn();
		} else {
			$("#errorDescripcion").fadeOut();
		}
	});

});
