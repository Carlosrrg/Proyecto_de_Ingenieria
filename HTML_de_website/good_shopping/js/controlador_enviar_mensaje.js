$(document).ready(function(){

	$("#btn_enviar_mensaje").click(function(){

		var mensaje = $("#txt-mensaje").val();
		var codigo_vendedor = $("#txt-idVendedor").val();
		var codigo_publicacion = $("#txt-codigo-p").val();

		if (mensaje == "") {
			$("#mensaje1").fadeIn();
			return false;
		}
		else{
			$("#mensaje1").fadeOut()
			var parametros = 	"&txt-mensaje="+mensaje+
								"&txt-idVendedor="+codigo_vendedor+
								"&txt-codigo-p="+codigo_publicacion;
			//alert(parametros);

			$.ajax({
				url:"ajax_procesar_php/acciones_enviar_mensaje_vendedor.php",
				data:parametros,
				method:"POST",
				success:function(respuesta){
					//alert(respuesta);
					if(respuesta == 0){
						alert("Mensaje enviado...");
					}
					else{
						alert("Error al enviar el mensaje.");
					}
				}
			});	
		}
	});
});



