$(document).ready(function(){
	$("#btn_registrarse").click(function(){
		var parametros1 = "txt-nombre=" +$("#txt-nombre").val()+ 
						"&txt-apellido="+$("#txt-apellido").val()+
						"&txt-correo="+$("#txt-correo").val()+
						"&txt-contrasena="+$("#txt-contrasena").val()+
						"&txt-confirmar-contrasena="+$("#txt-confirmar-contrasena").val()+
						"&txt-telefono="+$("#txt-telefono").val()+
						"&slc-ubicacion="+$("#slc-ubicacion").val()+
						"&txt-dia="+$("#txt-dia").val()+
						"&slc-mes="+$("#slc-mes").val()+
						"&txt-anio="+$("#txt-anio").val();			
		
		//alert(parametros1);
		$.ajax({
				url:"ajax_procesar_php/acciones_registrar.php",
				data:parametros1,
				method:"POST",
				dataType:"json",
				success:function(respuesta1){
					//$("#prueba").html(respuesta1);
					//alert(respuesta1);

					if(respuesta1 == 1){
						alert("Lo sentimos, el correo ingresado ya existe, intente con uno nuevo...");
						//window.location="modulo_registro.html";
						//$("#txt-correo").reset();
						//$("#txt-correo").empty();

					}
					else if (respuesta1 == 2){
						alert("El correo electronico es valido...");
						//window.location="modulo_registro.html";
					}
					else if (respuesta1 == 3){
						alert("Lo sentimos, el correo electronico ingresado es invalido...");
						//window.location="modulo_registro.html";
					}
					else if (respuesta1 == 4){
						alert("Las contasenas no coinciden...");
						//window.location="modulo_registro.html";
					}
				}
		});
	});	
});