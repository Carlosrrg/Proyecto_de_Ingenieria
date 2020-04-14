$(document).ready(function(){
	var codigo_vendedor = $('#codigoVendedor').val();
	$("#btn_enviar").click(function(){
		var rating = $('input:radio[name=rating]:checked').val();
		parametros = "&rb_rating="+rating+"&codigoVendedor="+codigo_vendedor+"&accion=calificar";
		if(rating >= 0){
			$.ajax({
				url:"ajax_procesar_php/acciones_calificarVendedor.php",
				data:parametros,
				method:"POST",
				success:function(respuesta){
					if (respuesta != 0) {
						alert(respuesta);
					} else {
						alert("Error al calificar vendedor.");
					}
				}
			});
		}
	});
	
	$("#btn_favoritos").click(function(){
		parametros = "&accion=favoritos"+"&codigoVendedor="+codigo_vendedor;
		$.ajax({
				url:"ajax_procesar_php/acciones_calificarVendedor.php",
				data:parametros,
				method:"POST",
				success:function(respuesta){
					if (respuesta != 0) {
						alert(respuesta);
					} else {
						alert("Error al agregar a favoritos.");
					}
				}
		});
	});
});