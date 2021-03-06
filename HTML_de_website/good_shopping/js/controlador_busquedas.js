$(document).ready(function(){

	$("#btn_buscar").click(function(){
		var busca = $("#txt_buscar").val();
		var lugar = $("#cmb_ubicacion").val();
		var categoria = $("#cmb_categoria").val();
		var tipo_moneda = $('input:radio[name=opcion_moneda]:checked').val();
		var precio_min = $("#precio_min").val();
		var precio_max = $("#precio_max").val();
		var orden = $("#cmb_ordenar").val();

		var cont = 0;
		var selected = [];      
	    $('input[name="cbox_subcategorias"]:checked').each(function(){
	        selected[cont] = $(this).val();
	        cont++;
	    });

	    var subcategorias = "";

	    for (var i = 0; i < selected.length; i++) {
	        if (i == selected.length-1) {
	        	subcategorias += selected[i];
	        }else{
	        	subcategorias += selected[i]+",";
	        }
	    }

		var parametros = 	"pagina=1"+
							"&busca="+busca+
							"&lugar="+lugar+
							"&categoria="+categoria+
							"&tipo_moneda="+tipo_moneda+
							"&subcategorias="+subcategorias+
							"&orden="+orden;

		var guarda_precio = 0;
		if (precio_min!="" && precio_max!="") {
			if (parseInt(precio_min) > parseInt(precio_max)) {
				guarda_precio = precio_min;
				precio_min = precio_max;
				precio_max = guarda_precio;
			}
		}

		if (precio_min!="") {
			parametros += "&precio_min="+precio_min;
		}

		if (precio_max!="") {
			parametros += "&precio_max="+precio_max;
		}

		window.location="BusquedaP.php?"+parametros+"";
        
	});

	//Funcion para ejecutar al presionar enter
	$("#txt_buscar").keypress(function(e) {
	    var code = (e.keyCode ? e.keyCode : e.which);
	    if(code==13){
	        $("#btn_buscar").click();
	    }
	});
	$("#precio_min").keypress(function(e) {
	    var code = (e.keyCode ? e.keyCode : e.which);
	    if(code==13){
	        $("#btn_buscar").click();
	    }
	});
	$("#precio_max").keypress(function(e) {
	    var code = (e.keyCode ? e.keyCode : e.which);
	    if(code==13){
	        $("#btn_buscar").click();
	    }
	});

	//solo numeros en el rango
	$("#precio_min").keyup(function (){
       this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    $("#precio_max").keyup(function (){
       this.value = (this.value + '').replace(/[^0-9]/g, '');
    });

	//Click al boton de rango de precio
	$("#btn_precio").click(function(){
		$("#btn_buscar").click();
	});

	//Muestra subcategorias
	$('#cmb_categoria').change(function() {	
		var categoria = $("#cmb_categoria").val();
		var parametros = 	"slc-categoria="+categoria+
							"&accion=subcategorias";
		if (categoria == 0) {
			$("#div-subcategorias").html("");
		} else {
			$.ajax({
				url:"ajax_procesar_php/acciones_busquedas.php",
				data:parametros,
				dataType:'json',
				method:"POST",
				success:function(respuesta){
				console.log(respuesta);
				var imprimir = '';
				for (var i=0; i<respuesta.length; i++){
					imprimir += '<label>'+
								'<input type="checkbox" name="cbox_subcategorias" value="'+respuesta[i].CODIGO_SUB_CATEGORIA+'"'+
								' id="cbox_subcategorias"> '+respuesta[i].NOMBRE_SUB_CATEGORIA+
					  			'</label> <br>';
				}
				$("#div-subcategorias").html(imprimir);
			},
				error:function(error){
					console.log(error);
				}
			});	
		}
	});

});