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

	//MUESTRA ESTADISTICAS POR TIEMPO
	$('#slc-estadisticas').change(function() {	
		var tiempo = $("#slc-estadisticas").val();
		var parametros = "accion=3&tiempo="+tiempo;
		if (tiempo == 0) {
			$("#div-estadisticas").html("");
		} else {
			$.ajax({
				url:"ajax_procesar_php/acciones_administrador.php",
				data:parametros,
				dataType:'json',
				method:"POST",
				success:function(respuesta){
				console.log(respuesta);
				if (tiempo != "Tiempo") {
					var promedioCuentas = "Promedio de cuentas creadas al "+tiempo+": <b>"+respuesta.CUENTAS_TOTALES_P+"</b>";
					var promedioCuentasInd = "Promedio de cuentas individuales creadas al "+tiempo+": <b>"+respuesta.CUENTAS_INDIVIDUALES_P+"</b>";
					var promedioCuentasEmp = "Promedio de cuentas empresariales creadas al "+tiempo+": <b>"+respuesta.CUENTAS_EMPRESARIALES_P+"</b>";
					var promedioPublicaciones = "Promedio de publicaciones creadas al "+tiempo+": <b>"+respuesta.PUBLICACIONES_TOTALES_P+"</b>";
					var promedioProductos = "Promedio de publicaciones de productos creadas al "+tiempo+": <b>"+respuesta.PUBLICACIONES_PRODUCTOS_P+"</b>";
					var promedioServicios = "Promedio de publicaciones de servicios creadas al "+tiempo+": <b>"+respuesta.PUBLICACIONES_SERVICIOS_P+"</b>";
					var promedioVendidos = "Promedio de publicaciones vendidas al "+tiempo+": <b>"+respuesta.PUBLICACIONES_VENDIDOS_P+"</b>";
					var promedioEliminados = "Promedio de publicaciones eliminadas al "+tiempo+": <b>"+respuesta.PUBLICACIONES_ELIMINADAS_P+"</b>";
					var promedioReportes = "Promedio de reportes hechos al "+tiempo+": <b>"+respuesta.TOTAL_REPORTES_P+"</b>";
					var promedioReportesVend = "Promedio de reportes a vendedores hechos al "+tiempo+": <b>"+respuesta.REPORTES_VENDEDOR_P+"</b>";
					var promedioReportesProd = "Promedio de reportes a productos hechos al "+tiempo+": <b>"+respuesta.REPORTES_PRODUCTOS_P+"</b>";
					var promedioReportesRes = "Promedio de reportes resueltos al "+tiempo+": <b>"+respuesta.REPORTES_RESUELTOS_P+"</b>";
				} else {
					var promedioCuentas = "<br>";
					var promedioCuentasInd = "<br>";
					var promedioCuentasEmp = "<br>";
					var promedioPublicaciones = "<br>";
					var promedioProductos = "<br>";
					var promedioServicios = "<br>";
					var promedioVendidos = "<br>";
					var promedioEliminados = "<br>";
					var promedioReportes = "<br>";
					var promedioReportesVend = "<br>";
					var promedioReportesProd = "<br>";
					var promedioReportesRes = "<br>";
				}
				var imprimir = '<div class="card-deck">';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">CUENTAS TOTALES <br>CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.CUENTAS_TOTALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioCuentas+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">CUENTAS INDIVIDUALES CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.CUENTAS_INDIVIDUALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioCuentasInd+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">CUENTAS EMPRESARIALES CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.CUENTAS_EMPRESARIALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioCuentasEmp+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">PUBLICACIONES TOTALES CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.PUBLICACIONES_TOTALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioPublicaciones+'</div>'+
								'</div>';
				imprimir += '</div><div class="card-deck">';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">PUBLICACIONES DE PRODUCTOS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.PUBLICACIONES_PRODUCTOS+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioProductos+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">PUBLICACIONES DE SERVICIOS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.PUBLICACIONES_SERVICIOS+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioServicios+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">PUBLICACIONES TOTALES VENDIDAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.PUBLICACIONES_VENDIDOS+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioVendidos+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">PUBLICACIONES TOTALES ELIMINADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.PUBLICACIONES_ELIMINADAS+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioEliminados+'</div>'+
								'</div>';
				imprimir += '</div><div class="card-deck">';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">REPORTES<br>TOTALES</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.TOTAL_REPORTES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioReportes+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">REPORTES A<br>VENDEDORES</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.REPORTES_VENDEDOR+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioReportesVend+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">REPORTES A PUBLICACIONES</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.REPORTES_PRODUCTOS+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioReportesProd+'</div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">REPORTES TOTALES RESUELTOS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.REPORTES_RESUELTOS+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success" style="font-size:13px">'+promedioReportesRes+'</div>'+
								'</div>';
				imprimir += '</div>';
				imprimir += '<div style="margin:0 auto;width:40%" class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">CATEGORÍA MAS USADA</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:20px">'+respuesta.NOMBRE_CATEGORIA+'</h5>'+
								    '<p class="card-text">'+respuesta.CANTIDAD+' publicaciones con esta categoría en este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success"></div>'+
								'</div>';
				$("#div-estadisticas").html(imprimir);
			},
				error:function(error){
					console.log(error);
				}
			});	
		}
	});

	//MUESTRA LAS DENUNCIAS			
	VerDenuncias('');
	$('#txt-buscar').keyup(function() {
		var busqueda = $('#txt-buscar').val();
		VerDenuncias(busqueda);
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
		data:"accion=4&busqueda="+busqueda,
		dataType:'json',
		method:"POST",
		success:function(respuesta){
			console.log(respuesta);
			var imprimir = '';
			for (var i=0; i<respuesta.length; i++){
				var habilitarBtn = "";
				if (respuesta[i].CODIGO_TIPO_REPORTE==1) { 
					//reporte a vendedor
					var nombre = respuesta[i].NOMBRE_COMPLETO;
					var accion = 	respuesta[i].CODIGO_REPORTE+","+
									respuesta[i].CODIGO_TIPO_REPORTE+","+
									respuesta[i].CODIGO_USUARIO_VENDEDOR;
					var link = "'Informacion_de_vendedor.php?codigo-usuario="+respuesta[i].CODIGO_USUARIO_VENDEDOR+"'";
					var btn1 = "Dar de Baja";
					var btn2 = "Ver Perfil";
				}
				if (respuesta[i].CODIGO_TIPO_REPORTE==2) { 
					//reporte a producto
					var nombre = respuesta[i].NOMBRE_PRODUCTO;
					var accion = 	respuesta[i].CODIGO_REPORTE+","+
									respuesta[i].CODIGO_TIPO_REPORTE+","+
									respuesta[i].CODIGO_PUBLICACION_PRODUCTO;
					var link = "'InfodeProductos.php?codigo-publicacion="+respuesta[i].CODIGO_PUBLICACION_PRODUCTO+"'";
					var btn1 = "Eliminar Producto";
					var btn2 = "Ver Producto";
				}
				imprimir += '<div class="row">'+
								'<div class="col-lg-9 col-sm-12">'+
									'<b>Denuncia a: </b>'+nombre+'<br>'+
									'<p><b>Descripción: </b>'+respuesta[i].COMENTARIO_REPORTE+'</p>'+
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
									''+btn1+'</button>'+
									'<button role="link" onclick="window.location='+link+'" class="btn '+
									'btn-success btn-block" '+habilitarBtn+'>'+btn2+'</button>'+
								'</div>'+
							'</div><hr>';
			}
			$("#div-denuncias").html(imprimir);
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