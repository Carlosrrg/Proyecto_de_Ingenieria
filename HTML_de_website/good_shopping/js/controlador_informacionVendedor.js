$(document).ready(function(){
	//Variable que contiene el codigo del vendedor que se va a calificar
	var codigo_vendedor = $('#codigoVendedor').val();
	
	//Si se presiona alguna estrella
	$("#rating").click(function(){
		//Se toma el numero de estrellas seleccionadas y se almacena en la variable rating 
		var rating = $('input:radio[name=rating]:checked').val();
		
		/*parametros necesarios para calificar un vendedor:
			numero_de_estrellas = rb_rating
			codigo_del_vendedor = codigoVendedor
			accion = calificar
		*/
		parametros = "&rb_rating="+rating+"&codigoVendedor="+codigo_vendedor+"&accion=calificar";

		$.ajax({
			url:"ajax_procesar_php/acciones_calificarVendedor.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				if (respuesta != 0) {
					//alert(respuesta);
					//si se puntuo el vendedor se recarga la pagina para visualizar los cambios
					location.reload(true);
				} else {
					alert("Error al calificar vendedor.");
				}
			}
		});
		
	});
	
	//si se preciona el boton enviar del modal de comentarios
	$("#btn_enviar").click(function(){
		//Se toma el texto del text area con id: txt_comentario
		var comentario = $('#txt_comentario').val();
		/*parametros necesarios para calificar un vendedor:
			comentarios = txt_comentario
			codigo_del_vendedor = codigoVendedor
			accion = comentar
		*/
		parametros = "&accion=comentar"+"&codigoVendedor="+codigo_vendedor+"&txt_comentario="+comentario;
		$.ajax({
				url:"ajax_procesar_php/acciones_calificarVendedor.php",
				data:parametros,
				method:"POST",
				success:function(respuesta){
					if (respuesta != 0) {
						if(respuesta == 'vacio'){
							//en caso que el text area no tuviese ningun caracter
							alert('tiene que agregar un comentario no dejar el texto vacío');
						}else{
							//alert(respuesta);
							location.reload(true);//recargar la pagina para poder ver los nuevos comentarios
						}
					} else {
						alert("Error al agregar comentario.");
					}
				}
		});
	});
	
	//si se preciona el boton agregar a favoritos
	$("#btn_favoritos").click(function(){
		/*parametros necesarios para calificar un vendedor:
			codigo_del_vendedor = codigoVendedor
			accion = favoritos
		*/
		parametros = "&accion=favoritos"+"&codigoVendedor="+codigo_vendedor;
		$.ajax({
				url:"ajax_procesar_php/acciones_calificarVendedor.php",
				data:parametros,
				method:"POST",
				success:function(respuesta){
					if (respuesta != 0) {
						alert(respuesta);//se agrgo correctamente a favoritos
					} else {
						alert("Error al agregar a favoritos.");
					}
				}
		});
	});
});