$(document).ready(function(){
	$("#editar_tienda").click(function(){

		var nombre_tienda = $("#txt-nombre-tienda").val();
		var correo_tienda = $("#txt-correo-tienda").val();
		var telefono_tienda = $("#txt-telefono-tienda").val();
		var direccion_tienda = $("#txt-direccion-tienda").val();
		var descripcion = $("#txt-descripcion").val();

		var servicio1 = 0;
		var servicio2 = 0;
		var servicio3 = 0;
		var servicio4 = 0;
		var cont = 0;
		//var selected = '';
		var selected = [];      
        $('input:checkbox:checked').each(function(){
            	
                selected[cont] = $(this).val();
         		//alert(selected[cont++]);
         		cont++
        });


        for (var i = selected.length - 1; i >= 0; i--) {
        	if (selected[i] == "Servicios de construccion") {
        		servicio1 = 1;
        	}
        	if (selected[i] == "Fletes") {
        		servicio2 = 2;
        	}
        	if (selected[i] == "Ventas de productos al por mayor") {
        		servicio3 = 3;
        	}
        	if (selected[i] == "Ventas solo de productos") {
        		servicio4 = 4;
        	}
        }

        //alert(servicio1+" "+servicio2+" "+servicio3+" "+servicio4);
		
		var parametros = 	"&txt-nombre-tienda="+nombre_tienda+
							"&txt-correo-tienda="+correo_tienda+
							"&txt-telefono-tienda="+telefono_tienda+
							"&txt-direccion-tienda="+direccion_tienda+
							"&txt-servicio1="+servicio1+
							"&txt-servicio2="+servicio2+
							"&txt-servicio3="+servicio3+
							"&txt-servicio4="+servicio4+
							"&txt-descripcion="+descripcion;
		//alert(parametros);

		$.ajax({
			url:"ajax_procesar_php/acciones_editarTienda.php",
			data:parametros,
			method:"POST",
			success:function(respuesta){
				alert(respuesta);
			}
		});	
	});

});
