$(document).ready(function(){
	$("#cargando").hide();
    $("#btn_enviar").click(function() {
		$("#cargando").show();
        var nombre = $("#txt_nombre").val();
        var correo = $("#txt_correo").val();
        var sugerencia = $("#txt_sugerencia").val();
		var parametros = "&txt_correo="+correo+"&txt_nombre="+nombre+"&txt_sugerencia="+sugerencia;
		$.ajax({
			url:"ajax_procesar_php/acciones_contactanos.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				$("#cargando").hide();
				if(respuesta == "0"){
					$("#mensaje16").fadeIn();
					$("#cargando").hide();
				}else if(respuesta != "Ningun campo debe estar vacio"){
					alert(respuesta);
					$("#cargando").hide();
					$("#btn_cerrar").click()
				}else{
					alert(respuesta);
					$("#mensaje16").fadeOut();
				}
			}
		});	
		
	});

});