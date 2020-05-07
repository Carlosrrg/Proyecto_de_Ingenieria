$(document).ready(function(){

	//CAMBIAR DIAS INDIVIDUAL
	var btn_ind = 0;
	$("#btn-dias-ind").click(function(){
		if (btn_ind == 0) {
			$("#txt-dias-ind").prop('disabled', false);
			$("#btn-dias-ind").text('Guardar');
			btn_ind = 1;
		} else {
			var dias = $("#txt-dias-ind").val();
			if (dias == " " || dias < 7 || dias > 365) {
				alert("Ingrese un número de días correcto entre 7-365");
				window.location="Adm_gestion_publicaciones.php";
			} else {
				var parametros = "tipo-vendedor=1&accion=1&dias="+dias;
				$.ajax({
					url:"ajax_procesar_php/acciones_administrador.php",
					data:parametros,
					method:"POST",
					success:function(respuesta){
						if (respuesta == 0) {
							alert("Actualizado con éxito!");
							window.location="Adm_gestion_publicaciones.php";
						} else {
							alert("Error al cambiar días.");
						}
					}
				});	
			}
		}
	});

	//CAMBIAR DIAS EMPRESARIAL
	var btn_emp = 0;
	$("#btn-dias-emp").click(function(){
		if (btn_emp == 0) {
			$("#txt-dias-emp").prop('disabled', false);
			$("#btn-dias-emp").text('Guardar');
			btn_emp = 1;
		} else {
			var dias = $("#txt-dias-emp").val();
			if (dias == " " || dias < 7 || dias > 365) {
				alert("Ingrese un número de días correcto entre 7-365");
				window.location="Adm_gestion_publicaciones.php";
			} else {
				var parametros = "tipo-vendedor=2&accion=1&dias="+dias;
				$.ajax({
					url:"ajax_procesar_php/acciones_administrador.php",
					data:parametros,
					method:"POST",
					success:function(respuesta){
						if (respuesta == 0) {
							alert("Actualizado con éxito!");
							window.location="Adm_gestion_publicaciones.php";
						} else {
							alert("Error al cambiar días.");
						}
					}
				});	
			}
		}	
	});

	//AGREGA NUEVA SUBCATEGORIA
	$("#txt-subcategoria").keyup(function(){
		var subcategoria = $("#txt-subcategoria").val();
		if (subcategoria.length == 0) {
			$("#btn-subcategoria").prop('disabled', true);
		} else {
			$("#btn-subcategoria").prop('disabled', false);
		}
	});

	$("#btn-subcategoria").click(function(){
		var subcategoria = $("#txt-subcategoria").val();
		var categoria = $("#slc-categoria").val();
		var parametros = "accion=7&subcategoria="+subcategoria+"&categoria="+categoria;
		
		$.ajax({
			url:"ajax_procesar_php/acciones_administrador.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				if (respuesta == 0) {
					alert("Subcategoria agregada con éxito!");
					window.location="Adm_gestion_vendedores.php";
				} else {
					if (respuesta == 'ExisteSubcategoria') {
						alert("La subcategoria ingresada ya existe!");
						$("#txt-subcategoria").val('');
						$("#btn-subcategoria").prop('disabled', true);
					} else {
						alert("Error al agregar subcategoria.");
					}
				}
			}
		});	
	});

	//ELIMINA SUBCATEGORIAS
	$("#btn-eliminar-subcategorias").click(function(){
		var subcategorias = "";   
	    $('input[name="chk-subcategorias[]"]:checked').each(function(){
	        subcategorias += $(this).val() + ",";
	    });

	    $.ajax({
			url:"ajax_procesar_php/acciones_administrador.php",
			data:"accion=9&subcategorias="+subcategorias,
			method:"POST",
			success:function(respuesta){
				if (respuesta == 0) {
					alert("Subcategoria(s) eliminada con éxito!");
				} else {
					alert("Error al eliminar subcategoria(s)");
					alert(respuesta);
				}
				window.location="Adm_gestion_vendedores.php";
			}
		});	

	});

	//AGREGA NUEVO SERVICIO
	$("#txt-servicio").keyup(function(){
		var servicio = $("#txt-servicio").val();
		if (servicio.length == 0) {
			$("#btn-servicio").prop('disabled', true);
		} else {
			$("#btn-servicio").prop('disabled', false);
		}
	});

	$("#btn-servicio").click(function(){
		var servicio = $("#txt-servicio").val();
		var parametros = "accion=2&servicio="+servicio;
		$.ajax({
			url:"ajax_procesar_php/acciones_administrador.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				if (respuesta == 0) {
					alert("Servicio agregado con éxito!");
					window.location="Adm_gestion_vendedores.php";
				} else {
					if (respuesta == 'ExisteServicio') {
						alert("El servicio ingresado ya existe!");
						$("#txt-servicio").val('');
						$("#btn-servicio").prop('disabled', true);
					} else {
						alert("Error al agregar servicio.");
					}
				}
			}
		});	
	});

	//ELIMINA SERVICIOS
	$("#btn-eliminar-servicios").click(function(){
		var servicios = "";   
	    $('input[name="chk-servicios[]"]:checked').each(function(){
	        servicios += $(this).val() + ",";
	    });

	    $.ajax({
			url:"ajax_procesar_php/acciones_administrador.php",
			data:"accion=8&servicios="+servicios,
			method:"POST",
			success:function(respuesta){
				if (respuesta == 0) {
					alert("Servicio(s) eliminado con éxito!");
				} else {
					alert("Error al eliminar servicio(s)");
					alert(respuesta);
				}
				window.location="Adm_gestion_vendedores.php";
			}
		});	

	});

	//MUESTRA LAS DENUNCIAS			
	VerDenuncias('');
	VerDenunciasVendedores('');
	$('#txt-buscar').keyup(function() {
		var busqueda = $('#txt-buscar').val();
		VerDenuncias(busqueda);
		VerDenunciasVendedores(busqueda);
	});

	//CONFIRMA ACCIONES
	$("#btn-si").click(function(){
		$("#btn-cerrar").click();
		var tipo_reporte = $("#valorTipo").val();
		var codigo = $("#valorCodigo").val();
		var codigo_reporte = $("#valorCodigoReporte").val();
		var parametros = 	"tipo-reporte="+tipo_reporte+
							"&codigo="+codigo+
							"&codigo-reporte="+codigo_reporte+
							"&accion=5";
		$.ajax({
			url:"ajax_procesar_php/acciones_administrador.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				if (respuesta == 0) {
					alert("Accion éxitosa!");
					window.location="Adm_denuncias.php";
				} else {
					alert("Error al realizar la acción!");
				}
			}
		});
	});

	//DESHACE ACCIONES
	$("#btn-no").click(function(){
		$("#btn-cerrar").click();
	});

	//MUESTRA ELIMINACIONES
	$.ajax({
		url:"ajax_procesar_php/acciones_administrador.php",
		data:"accion=6",
		dataType:'json',
		method:"POST",
		success:function(respuesta){
			console.log(respuesta);
			var imprimir = '';
			for (var i=0; i<respuesta.length; i++){
				imprimir += '<div class="row">'+
								'<div class="col-lg-8 col-sm-12">'+
									'<b>Nombre del vendedor: </b>'+respuesta[i].NOMBRE_COMPLETO+'<br>'+
									'<b>Nombre de la publicación: </b>'+respuesta[i].NOMBRE_PRODUCTO+'<br>'+
									'<p><b>Comentarios: </b>'+respuesta[i].COMENTARIOS+'</p>'+
					            '</div>'+
								'<div class="col-lg-4 col-sm-12">'+
									'<b>Eliminada el: </b>'+respuesta[i].FECHA_EMITIO+'<br>'+
									'<b>Motivo de eliminación: </b>'+
									'<button style="margin-right:5px; margin-bottom:5px" class="btn btn-danger '+
									'btn-sm" disabled>'+respuesta[i].NOMBRE_MOTIVO_ELIMINACION+'</button>'+
								'</div>'+
							'</div><hr>';
			}
			$("#div-publicaciones-eliminadas").html(imprimir);
		},
		error:function(error){
			console.log(error);
		}
	});	

});

function VerDenuncias(busqueda){
	$.ajax({
		url:"ajax_procesar_php/acciones_administrador.php",
		data:"accion=4&subaccion=1&busqueda="+busqueda,
		dataType:'json',
		method:"POST",
		success:function(respuesta){
			console.log(respuesta);
			var imprimir = '';
			for (var i=0; i<respuesta.length; i++){
				var habilitarBtn = "";
				var accion = 	respuesta[i].CODIGO_REPORTE+",2,"+
								respuesta[i].CODIGO_PUBLICACION_PRODUCTO;
				var link = "'InfodeProductos.php?codigo-publicacion="+respuesta[i].CODIGO_PUBLICACION_PRODUCTO+"'";

				imprimir += '<div class="row">'+
								'<div class="col-lg-9 col-sm-12">'+
									'<b>Denuncia a producto: </b>'+respuesta[i].NOMBRE_PRODUCTO+'<br>'+
									'<p><b>Descripción de la denuncia: </b>'+respuesta[i].COMENTARIO_REPORTE+'</p>'+
									'<p><b>Cantidad de denuncias a este producto: </b>'+respuesta[i].CANTIDAD_REPORTES+'</p>'+
									'<button style="margin-right:5px; margin-bottom:5px" class="btn btn-danger '+
									'btn-sm" disabled>'+respuesta[i].NOMBRE_TIPO_REPORTE+'</button>'+
									'<button style="margin-right:5px; margin-bottom:5px" class="btn btn-danger '+
									'btn-sm" disabled>'+respuesta[i].NOMBRE_MOTIVO_REPORTE+'</button>';
				if (respuesta[i].COMENTARIO_REPORTE == "****RESUELTO****") {
					imprimir += '<button style="margin-right:5px; margin-bottom:5px" class="btn btn-info '+
								'btn-sm" disabled>Reporte Resuelto</button>';
					habilitarBtn = "disabled";
				}
				imprimir +=		'</div>'+
								'<div class="col-lg-3 col-sm-12">'+
									'<b>Emitida: </b>'+respuesta[i].FECHA_EMITIO+''+
									'<button onclick="accionar('+accion+')" style="margin-top:5px" '+
									'class="btn btn-success btn-block" '+habilitarBtn+'>'+
									'Eliminar Producto</button>'+
									'<button role="link" onclick="window.location='+link+'" class="btn '+
									'btn-success btn-block" '+habilitarBtn+'>Ver Producto</button>'+
								'</div>'+
							'</div><hr>';

			}
			imprimir += '<center>-- Fin de los resultados --</center>';
			$("#div-denuncias").html(imprimir);
		},
		error:function(error){
			console.log(error);
		}
	});	
}

function VerDenunciasVendedores(busqueda){
	$.ajax({
		url:"ajax_procesar_php/acciones_administrador.php",
		data:"accion=4&subaccion=2&busqueda="+busqueda,
		dataType:'json',
		method:"POST",
		success:function(respuesta){
			console.log(respuesta);
			var imprimir = '<div class="alert alert-warning alert-dismissible fade show" role="alert">'+
 							'<strong>Importante:</strong> Aquí aparecen los vendedores que cuentan con 5 o más reportes actualmente.'+
  							'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
    						'<span aria-hidden="true">&times;</span>'+
  							'</button>'+
						   '</div>';
			for (var i=0; i<respuesta.length; i++){
				var habilitarBtn = "";
				var accion = 	respuesta[i].CODIGO_REPORTE+",1,"+
								respuesta[i].CODIGO_USUARIO_VENDEDOR;
				var link = "'Informacion_de_vendedor.php?codigo-usuario="+respuesta[i].CODIGO_USUARIO_VENDEDOR+"'";
				
				imprimir += '<div class="row">'+
								'<div class="col-lg-9 col-sm-12">'+
									'<b>Nombre del vendedor: </b>'+respuesta[i].NOMBRE_COMPLETO_VENDEDOR+'<br>'+
									'<p><b>Correo electrónico: </b>'+respuesta[i].CORREO_ELECTRONICO+'</p>'+
									'<p><b>Teléfono: </b>'+respuesta[i].TELEFONO+'</p>'+
									'<p><b>Cantidad de reportes al vendedor: </b>'+respuesta[i].CANTIDAD_REPORTES_VENDEDORES+'</p>';
				if (respuesta[i].CORREO_ELECTRONICO == "correo_deshabilitado") {
					imprimir += '<button style="margin-right:5px; margin-bottom:5px" class="btn btn-info '+
								'btn-sm" disabled>Reporte Resuelto</button>';
					habilitarBtn = "disabled";
				}
				imprimir +=		'</div>'+
								'<div class="col-lg-3 col-sm-12">'+
									'<button onclick="accionar('+accion+')" style="margin-top:5px" '+
									'class="btn btn-success btn-block" '+habilitarBtn+'>'+
									'Dar de Baja</button>'+
									'<button role="link" onclick="window.location='+link+'" class="btn '+
									'btn-success btn-block" '+habilitarBtn+'>Ver Perfil</button>'+
								'</div>'+
							'</div><hr>';

			}
			imprimir += '<center>-- Fin de los resultados --</center>';
			$("#div-denuncias-vendedores").html(imprimir);
		},
		error:function(error){
			console.log(error);
		}
	});	
}

function accionar(codigo_reporte,tipo_reporte,codigo){
	$("#valorTipo").val(tipo_reporte);
	$("#valorCodigo").val(codigo);
	$("#valorCodigoReporte").val(codigo_reporte);
	$("#btn-modal").click();
}