$(document).ready(function(){
	$("#btn_login").click(function(){
		var parametros = "inputEmail=" +$("#inputEmail").val() + 
						"&inputPassword="+$("#inputPassword").val();
		//alert(parametros);
		$.ajax({
				url:"ajax_procesar_php/acciones_login.php",
				method:"POST",
				data:parametros,
				success:function(respuesta){
					$("#prueba").html(respuesta);
					if(respuesta == 0){
						alert("Lo sentimos, correo o contrasena incorrectos...");
						window.location="iniciar_seccion.html";
					}
					else{
						//alert("el codigo_usuario es= " + respuesta);
						window.location="vista_general_cuenta.php";
					}
				}
		});
	});	
	$("#btn_registrarse").click(function(){
		var parametros1 = "txt-email=" +$("#txt-email").val()+ 
						"&txt-confirmar-email="+$("#txt-confirmar-email").val()+
						"&txt-contrasena="+$("#txt-contrasena").val()+
						"&txt-nombre="+$("#txt-nombre").val()+
						"&txt-dia="+$("#txt-dia").val()+
						"&slc-mes="+$("#slc-mes").val()+
						"&txt-anio="+$("#txt-anio").val()+
						"&rtb-genero="+$("input:radio[name=rtb-genero]:checked").val();			

		//alert(parametros1);
		$.ajax({
				url:"ajax_procesar_php/acciones_registrar.php",
				method:"POST",
				data:parametros1,
				success:function(respuesta1){
					$("#prueba").html(respuesta1);
					if(respuesta1 == 1){
						alert("Lo sentimos, el correo ingresado ya existe, intente con uno nuevo");
						window.location="modulo_registro.php";
					}
					else if (respuesta1 == 2){
						alert("Los correos electronicos ingresados no coinciden, intentelo de nuevo.");
						window.location="modulo_registro.php";
					}
					else if (respuesta1 == 3){
						alert("Ingrese los datos requeridos para registrarse.");
						window.location="modulo_registro.php";
					}
					else if (respuesta1 == 4){
						alert("Registro exitoso puede iniciar session a continuacion...");
						window.location="iniciar_seccion.html";
					}
				}
		});
	});	
});