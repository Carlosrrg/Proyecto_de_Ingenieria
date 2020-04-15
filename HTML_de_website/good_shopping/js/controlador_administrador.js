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
					alert("Error al agregar servicio.");
				}
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
				var imprimir = '<div class="card-deck">';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">CUENTAS TOTALES <br>CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.CUENTAS_TOTALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success"></div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">CUENTAS INDIVIDUALES CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.CUENTAS_INDIVIDUALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success"></div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">CUENTAS EMPRESARIALES CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.CUENTAS_EMPRESARIALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
								  '</div>'+
								  '<div class="card-footer bg-transparent border-success"></div>'+
								'</div>';
				imprimir += '<div class="card text-center border-success mb-3" style="max-width: 18rem;">'+
								'<div class="card-header bg-transparent border-success">PUBLICACIONES TOTALES CREADAS</div>'+
								  '<div class="card-body text-success">'+
								    '<h5 class="card-title" style="font-size:50px">'+respuesta.PUBLICACIONES_TOTALES+'</h5>'+
								    '<p class="card-text">En este '+tiempo+'</p>'+
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