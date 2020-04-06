//CONTROLADOR PARA ACTUALIZACION DE PUBLICACIONES Y ELIMINACION DE PUBLICACIONES
/*
Descripcion de variable "solicitud":
solicitud = 1 -> Actualiza a vendido
solicitud = 2 -> Se va a la pantalla de editar producto
solicitud = 3 -> Se va a la pantalla de eliminar producto
solicitud = 4 -> Edita la informacion de la publicacion
solicitud = 5 -> Elimina la publicacion
*/
$(document).ready(function(){
	//Edita el producto
	$("#btn_editar").click(function(){
		var codigo = $("#codigo-publicacion").val();
		var tipoP = $("#slc-tipo-publicacion").val();
		var nombre_producto = $("#txt-nombreProducto").val();
		var moneda = $('input:radio[name=moneda]:checked').val();
		var precio = $("#txt-precioProducto").val();
		var descripcion = $("#txt-descripcion").val();

		var parametros = 	"codigo-publicacion="+codigo+
							"&txt-nombre-producto="+nombre_producto+
							"&rbt-moneda="+moneda+
							"&txt-precio-producto="+precio+
							"&txt-descripcion="+descripcion+
							"&slc-tipo-publicacion="+tipoP+
							"&elimina-imagenes="+elimina_imagenes+
							"&solicitud=4";

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
				if (elimina_imagenes==1 && imagenes.length==0) {
					$("#mensaje3").fadeIn();
					$('html, body').animate({scrollTop:0}, 'slow');
					return false;
				}
				else{
					$("#mensaje3").fadeOut();
					if (descripcion == "") {
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
								url:"ajax_procesar_php/acciones_productos_servicios.php",
								data:parametros,
								method:"POST",
								success:function(respuesta){
									if (respuesta == 0) {
										alert("Actualizado con éxito!");
										window.location="Productos_y_servicios.php";
									} else {
										alert("Error al editar producto o servicio.");
									}
								}
							});	
						}	
					}
				}
			}
		}

		//SUBE IMAGENES DE NUEVAS DE LA PUBLICACION
		if (elimina_imagenes==1) {
			if (imagenes.length != 0) {
				var formData = new FormData();
				var codigo = $("#codigo-publicacion").val();
				for (var i = 0; i < imagenes.length; i++) {
					var foto = imagenes[i];
					//alert(foto);
					formData.append('foto',foto);
					formData.append('codigo',codigo);
					$.ajax({
				        url: 'ajax_procesar_php/imagenes_productos_editados.php',
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
		} 
	});

	//Elimina el producto
	$("#btn-eliminar").click(function(){
		var codigo = $("#codigo-publicacion").val();
		var motivo = $("input:radio[name=rbt-motivo]:checked").val();
		var comentarios = $("#txt-descripcion-motivo").val();
		//alert(codigo+" "+motivo+" "+comentarios);
		var parametros = 	"codigo-publicacion="+codigo+
							"&motivo="+motivo+
							"&comentarios="+comentarios+
							"&solicitud=5";
		$.ajax({
			url:"ajax_procesar_php/acciones_productos_servicios.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				if (respuesta == 0) {
					alert("Se ha eliminado el producto/servicio!")
					window.location="Productos_y_servicios.php";
				} else {
					alert("Error al eliminar la publicación."+respuesta);
				}
			}
		});
	});

	//Cambia el estado del producto a vendido
	$("#btn-vendido-si").click(function(){
		$.ajax({
			url:"ajax_procesar_php/acciones_productos_servicios.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				if (respuesta == 0) {
					//alert("actualizado!")
					window.location="Productos_y_servicios.php";
				} else {
					alert("Error al actualizar estado de publicación.");
				}
			}
		});
	});

	$("#btn-vendido-no").click(function(){
		$("#btn-cerrar-vendido").click();
	});

	//Habilita boton de acciones
	$('select').change(function() {
		var idselect = $(this).attr("id");
		var valor = $("#"+idselect).val();
		if (valor!=0) {
			$('button[name='+idselect+']').prop('disabled', false);
		} else {
			$('button[name='+idselect+']').prop('disabled', true);
		}
	});

	//Muestra subcategorias
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

	//Elimina y agrega nuevas imagenes
	var elimina_imagenes = 0;
	$("#btn_cambiar_imagenes").click(function(){
		elimina_imagenes = 1;
		var html = 	'<div class="carousel-item active col-lg-1">'+
					'<img class="d-block w-0" src="recursos/imagenes/fotografiaP.png" '+
					'style="width: 400px; height: 200px"></div>';
		$("#carousel-inner").html(html);
		$("#agregadas").html("Imágenes agregadas: 0/5");
		$("#btn_subir_foto").prop('disabled', false);
		$("#btn_cambiar_imagenes").css("display", "none");
	});

	//Cancela editar
	$("#btn_cancelar").click(function(){
		window.location="Productos_y_servicios.php";
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

//Verifica la accion de la publicacion a elegir
var parametros = "";
function enviar(codigo){
	var solicitud = $("#slc-solicitud-"+codigo).val();
	parametros = 	"codigo-publicacion="+codigo+
					"&solicitud="+solicitud;

	if (solicitud == 1) { //Vendido
		$("#btn-vendido").click();
	}
	if (solicitud == 2) { //Modificar
		$("#div-editar").html('<a id="link-editar" href="Editar_producto.php?'+parametros+'"></a>');
		$("#link-editar").get(0).click();
	}
	if (solicitud == 3) { //Eliminar
		$("#div-eliminar").html('<a id="link-eliminar" href="Eliminar_producto.php?'+parametros+'"></a>');
		$("#link-eliminar").get(0).click();
	}
}