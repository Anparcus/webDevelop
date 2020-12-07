$(document).ready(function(){

// Logearse
	$('#login-admin').on('submit', function(e){
		//prevenimos la accion por defecto del botton que hemos seleccionado
		e.preventDefault();
		
		//creamos una variable que nos almacene los datos registrados
		var datos = $(this).serializeArray();
		
		$.ajax({
			type: $(this).attr('method'),
			data: datos,
			url: $(this).attr('action'),
			dataType: 'json',
			success: function(data){				
				var resultado = data;	
				if(resultado.respuesta == 'exitoso'){
					Swal.fire(
					  'Login Correcto '+resultado.usuario+' !!',
					  'Bienvenido(a)!',
					  'success'
					)
					setTimeout(function(){
						window.location.href = 'admin-area.php';
					}, 2300);
				}else{
					Swal.fire(
					  'Ooppsss :( !',
					  'Usuario o password incorrectos!',
					  'error'
					)
				}
			}
		})		
	});
});