<?php
/**
	Archivo usadado para poder traer la respuesta de la api
**/
require ('../vendor/autoload.php');
use GuzzleHttp\Client;
/** 
	Crear el cliente para llamadas al servicio
	Debes cambiar el valor de base_uri a la dirección en donde esta tu servicio
	El valor de timeout, en este caso es para decir que despues de 5 segundos
	si el servicio no responde, se cancela el proceso.
**/
$client = new Client([
    'base_uri' => 'http://localhost/EntrevistaTrabajo/rest/src/post.php',
    'timeout'  => 5.0,
]);


$filtro = $_POST[ 'filtro' ];

if ( $filtro == 'getPeliculas' ){
	$arrayRespuesta['html'] = '';
	//Hacer la llamada al metodo get, sin ningún parametro
	$res = $client->request('GET');
	if ($res->getStatusCode() == '200') //Verifico que me retorne 200 = OK
	{
	  $respuesta = $res->getBody();
	  $respuesta = json_decode($respuesta);
	  // var_dump($respuesta);
	  foreach ($respuesta as $key => $value) {

	  	$peliculas = get_object_vars($value);

  		$arrayRespuesta['html'] .= 
  		'<div class="card col s6" >' . 
		    '<div class="card-image waves-effect waves-block waves-light" >' .
		      	'<img class="activator" src="img/pelicula.jpg">' .
		    '</div>' . 
		    '<div class="card-content">' .
		      	'<span class="card-title activator grey-text text-darken-4">'. $peliculas[ "titulo" ] . '<i class="material-icons right">more_vert</i></span>' .
		      	'<p>' . $peliculas[ "descripcion" ] . '</p>'.
		    '</div>' . 
		    '<div class="card-reveal">' .
		      	'<span class="card-title grey-text text-darken-4">' . $peliculas[ "titulo" ] . '<i class="material-icons right">close</i></span>' .
		      	'<p>' . $peliculas[ "descripcion" ] . '</p><p> <b> Tipo de Formato:</b> ' . $peliculas[ "des_formato" ] . '</p> <p> <b> Fecha de Creacion: </b> ' . $peliculas['fec_creacion'] . ' </p> <p> <b> Calificaicon: </b>' . $peliculas["calificacion"] . '</p>' .
		    '</div>' .
		'</div>';
	  	
	  }
	  // var_dump($peliculas);
	  echo json_encode($arrayRespuesta);
	}

}

if ( $filtro == 'saveMovies' ) {
	$respuesta = array();
	$parametros = array(
		'titulo' 		=> $_POST[ 'titulo' ],
		'tipo_formato'	=> $_POST[ 'tipo_formato' ],
		'descripcion'	=> $_POST[ 'des_pelicula' ],
		'calificacion' 	=> $_POST[ 'calificacion' ]
	);
	$res = $client->request('POST', '', ['form_params' => $parametros]);
	
	if ($res->getStatusCode() == '200') { // Verifico que me retorne 200 = OK
		$respuesta["valor"] = 1;
	  	$respuesta["respuesta"] = "Se inserto la pelicula ( " . $_POST[ "titulo" ] . " )";
	} else {
		$respuesta["valor"] = 0;
		$respuesta["respuesta"] = "Error la insertar la pelicula";
	}
	echo json_encode($respuesta);
}
?>