$(document).ready(function(){

	$("#btn_publicar").click(function(){
		var tipoP = $("#slc-tipo-publicacion").val();
		var nombre_producto = $("#txt-nombreProducto").val();
		var moneda = $('input:radio[name=moneda]:checked').val();
		var precio = $("#txt-precioProducto").val();
		var descripcion = $("#txt-descripcion").val();

		var parametros = 	"&txt-nombre-producto="+nombre_producto+
							"&rbt-moneda="+moneda+
							"&txt-precio-producto="+precio+
							"&txt-descripcion="+descripcion+
							"&slc-tipo-publicacion="+tipoP+
							"&accion=publicar";

		var servicios_seleccionados = 0;

		if (tipoP == 1) {	//Producto
			var estado = $('input:radio[name=estadoProducto]:checked').val();
			var categoria = $("#slc-categoria").val();

			var cont = 0;
			var selected = [];      
	        $('input[name="chk-subcategorias[]"]:checked').each(function(){
	                selected[cont] = $(this).val();
	         		cont++;
	        });

	        var subcategorias = "";

	        for (var i = 0; i < selected.length; i++) {
	        	if (i == selected.length-1) {
	        		subcategorias += selected[i];
	        	}else{
	        		subcategorias += selected[i]+",";
	        	}
	        }

	        parametros += 	"&estadoProducto="+estado+
	        				"&slc-categoria="+categoria+
	        				"&chk-subcategorias="+subcategorias;

		} else {	//Servicio
			var cont = 0;
			var selected = [];     
			var servicios = ""; 
	        $('input[name="chk-servicios[]"]:checked').each(function(){
	                selected[cont] = $(this).val();
	         		cont++
	        });

	        if (selected.length==0) {
	        	servicios_seleccionados = 1;
	        }

	        var servicios = "";

	        for (var i = 0; i < selected.length; i++) {
	        	if (i == selected.length-1) {
	        		servicios += selected[i];
	        	}else{
	        		servicios += selected[i]+",";
	        	}
	        }

	        parametros +=	"&chk-servicios="+servicios;
		}

		if (nombre_producto == "") {
			$("#mensaje1").fadeIn();
			$('html, body').animate({scrollTop:0}, 'slow');
			return false;
		}
		else{
			$("#mensaje1").fadeOut();
			if (precio == "") {
				$("#mensaje2").fadeIn();
				$('html, body').animate({scrollTop:0}, 'slow');
				return false;
			}
			else{
				$("#mensaje2").fadeOut();
				if (imagenes.length==0) {
					$("#mensaje3").fadeIn();
					$('html, body').animate({scrollTop:0}, 'slow');
					return false;
				}
				else{
					$("#mensaje3").fadeOut();
					if (descripcion == "" || descripcion.length > 499) {
						$("#mensaje4").fadeIn();
						return false;
					}
					else{
						$("#mensaje4").fadeOut();
						if (servicios_seleccionados == 1) {
							$("#mensaje5").fadeIn();
							$('html, body').animate({scrollTop:0}, 'slow');
							return false;
						}else {
							$("#mensaje5").fadeOut();
							//alert(parametros);
							
							$.ajax({
								url:"ajax_procesar_php/acciones_publicarProducto.php",
								data:parametros,
								method:"POST",
								success:function(respuesta){
									if (respuesta != 0) {
										alert(respuesta);
										window.location="Productos_y_servicios.php";
									} else {
										alert("Error al publicar producto o servicio.");
									}
								}
							});	
						}	
					}
				}
			}
		}

		//SUBE IMAGENES DE PUBLICACION
		if (imagenes.length != 0) {
			var formData = new FormData();
			for (var i = 0; i < imagenes.length; i++) {
				var foto = imagenes[i];
				//alert(foto);
				formData.append('foto',foto);
				$.ajax({
			        url: 'ajax_procesar_php/imagenes_productos.php',
			        type: 'post',
			        data: formData,
			        contentType: false,
			        processData: false,
			        success: function(response) {
			            //alert(response);
			            if (response != 0) {
			                //alert('Imagen subida en '+response);
			            } else {
			                alert('Error al subir imagen: '+(i+1));
			            }
			        }
			    });
			}
		}
        
	});

	//solo imprime numeros en el campo precio
	$('#txt-precioProducto').on('input', function () {
	    this.value = this.value.replace(/[^0-9]/g,'');
	});

	//Muestra subcategorias
	var categoria = $("#slc-categoria").val();
	var parametros = 	"slc-categoria="+categoria+
						"&accion=subcategorias";
					
	$.ajax({
		url:"ajax_procesar_php/acciones_publicarProducto.php",
		data:parametros,
		dataType:'json',
		method:"POST",
		success:function(respuesta){
			console.log(respuesta);
			var imprimir = '';
			for (var i=0; i<respuesta.length; i++){
				if (respuesta[i].NOMBRE_SUB_CATEGORIA == "Comprar") {
					respuesta[i].NOMBRE_SUB_CATEGORIA = "Vender";
				}
				imprimir += '<label><input type="checkbox" id="chk-subcategorias[]" name="chk-subcategorias[]"'+
							' class="thirdparty" value="'+respuesta[i].CODIGO_SUB_CATEGORIA+'"> '+
							respuesta[i].NOMBRE_SUB_CATEGORIA+'</label><br>';
			}
			$("#div-subcategorias").html(imprimir);
		},
		error:function(error){
			console.log(error);
		}
	});	

	$('#slc-categoria').change(function() {	
		var categoria = $("#slc-categoria").val();
		var parametros = 	"slc-categoria="+categoria+
							"&accion=subcategorias";
					
		$.ajax({
			url:"ajax_procesar_php/acciones_publicarProducto.php",
			data:parametros,
			dataType:'json',
			method:"POST",
			success:function(respuesta){
			console.log(respuesta);
			var imprimir = '';
			for (var i=0; i<respuesta.length; i++){
				if (respuesta[i].NOMBRE_SUB_CATEGORIA == "Comprar") {
					respuesta[i].NOMBRE_SUB_CATEGORIA = "Vender";
				}
				imprimir += '<label><input type="checkbox" id="chk-subcategorias[]" name="chk-subcategorias[]"'+
							' class="thirdparty" value="'+respuesta[i].CODIGO_SUB_CATEGORIA+'"> '+
							respuesta[i].NOMBRE_SUB_CATEGORIA+'</label><br>';
			}
			$("#div-subcategorias").html(imprimir);
		},
			error:function(error){
				console.log(error);
			}
		});	

	});

	//Tipo de publicación cambie
	$('#slc-tipo-publicacion').change(function() {	
		var tipoP = $("#slc-tipo-publicacion").val();
		if (tipoP == 1) { //De producto
			$("#div-productos").css("display", "block");
			$("#div-servicios").css("display", "none");
			$("#btn_publicar").text("Publicar Producto");
		} else { //De servicio
			$("#div-productos").css("display", "none");
			$("#div-servicios").css("display", "block");
			$("#btn_publicar").text("Publicar Servicio");
		}
	});

	//Visualiza imagenes
	var imagenes = [];
	var cantidad = 0;
	$('input[type=file]').change(function() {
		$("#mensaje3").fadeOut();
		var activo = " ";
		if (cantidad==0) {
			activo = "active";
			$("#carousel-inner").html("");
		}
		$("#carousel-inner").append(
					'<div id="imagen-'+cantidad+'" class="carousel-item '+activo+' col-lg-1">'+
					'<img class="d-block w-0" src=" "'+
					'style="width: 400px; height: 200px"></div>');

		reader = new FileReader();
		var etiqueta = '#imagen-'+cantidad+' img';

		reader.onload = function (e) {
			$(etiqueta).attr('src', e.target.result);
		}

		reader.readAsDataURL(this.files[0]);
		imagenes[cantidad] = this.files[0];

		cantidad++;
		$("#agregadas").text('Imágenes agregadas: '+cantidad+'/5');

		if (cantidad == 5) {
			$("#btn_subir_foto").prop('disabled', true);
		}

	});

});