/*
	Este archivo contiene las funciones para poder conectarse comunicarse al api
*/

// metodo usado para treer una sola peliculas
function getPelicula( id = '' ){

}

// metodo usado para treer todas las peliculas
function getPeliculas( ){
	filtro = 'getPeliculas';
	$('#txt_peliculas').html('<i class="material-icons" >replay</i> Cargando Peliculas...');
	$.ajax({
		url : 'gestion_peliculas.php',
		data: 'filtro='+filtro,
		type : 'POST',
		success : function(json) {
			json = JSON.parse(json);
			console.log(json.html)
			if ( json.html == '' ){
				$('#txt_peliculas').html('<div class="materialert error"><i class="material-icons">error_outline</i>Sin peliculas</div> ')
			} else { 
				$('#txt_peliculas').html(json.html);
			}
		},error : function(xhr, status) {
			alert('Disculpe, existió un problema');
		}
	});
}

// metodo usado para guardar la peliculas
function saveMovies (){

	var puntuacion = 0;
	$( "input[name=estrellas]" ).each( function ( index ) { 
       if( $( this ).is( ':checked' ) ){
          puntuacion = $( this ).val() ;
       }
    });

    var filtro 			= 'saveMovies';
    var titulo 			= $('#titulo_pelicula').val();
    var des_pelicula 	= $('#des_pelicula').val();
    var tipo_formato 	= $('#tipo_formato').val();
    $('#saveMovies').attr('disabled', true);
    $('#saveMovies').html('Guardando...');
	$.ajax({
		url : 'gestion_peliculas.php',
		data: 'filtro='+filtro+'&titulo='+titulo+'&des_pelicula='+des_pelicula+'&calificacion='+puntuacion+'&tipo_formato='+tipo_formato,
		type : 'POST',
		success : function(json) {
			json = JSON.parse(json);
			// console.log(json)
			if ( json.valor == 1 ) {
    			$('.modal').modal('close');
				M.toast({html: json.respuesta});
				getPeliculas();
			} else {
				M.toast({html: json.respuesta});
			}
			$('#saveMovies').attr('disabled', false);
    		$('#saveMovies').html('Guardar');
		},error : function(xhr, status) {
			alert('Disculpe, existió un problema');
		}
	});
}