$(document).ready(function(){
	
	$("#btn-eliminar").click(function(){
		var codigo_publicacion = $("#codigo-publicacion").val();
		var codigo_usuario_vendedor = $("#codigo-usuario-vendedor").val();
		var motivo_denuncia = $("input:radio[name=rbt-motivo]:checked").val();
		var comentario = $("#txt-descripcion-comentario").val();


		var parametros = 	"codigo-publicacion="+codigo_publicacion+
							"&codigo-usuario-vendedor="+codigo_usuario_vendedor+
							"&codigo-motivo="+motivo_denuncia+
							"&comentario="+comentario;
		//alert(parametros);

		$.ajax({
			url:"ajax_procesar_php/acciones_denunciar_publicacion.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				//alert(respuesta);
				if (respuesta == 0) {
					alert("Su denuncia se ha realizado exitosamente...")
					window.location="InfodeProductos.php?codigo-publicacion="+codigo_publicacion;
				} 
			}
		});
	});


	$("#btn_cancelar").click(function(){
		var codigo_publicacion = $("#codigo-publicacion").val();
		window.location="InfodeProductos.php?codigo-publicacion="+codigo_publicacion;
	});	

});
