$(document).ready(function(){
    $("#btn_enviar").click(function() {
        var nombre = $("#txt_nombre").val();
        var correo = $("#txt_correo").val();
        var sugerencia = $("#txt_sugerencia").val();
		var parametros = "&txt_correo="+correo+"&txt_nombre="+nombre+"&txt_sugerencia="+sugerencia;
		$.ajax({
			url:"ajax_procesar_php/acciones_contactanos.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				if(respuesta != "Ningun campo debe estar vacio"){
					alert(respuesta);
					$("#btn_cerrar").click()
				}else{
					alert(respuesta);
				}
			}
		});	
		
	});

});