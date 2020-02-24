$(document).ready(function(){

	

	$('#inputBuscador').on('keyup',function(){
		var inputBuscador=$('#inputBuscador').val()
		
		$.ajax({
			type: 'POST',
			url: 'inputBuscador.php',
			data: {'inputBuscador':inputBuscador},



		})
		.done(function(resultado){
			$('#divContenidoBuscador').html(resultado)


		})
		.fail(function(resultado){
			alert('pinche error')
		})

		

	})

})

