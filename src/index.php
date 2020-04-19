<?php 
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="js/jquery.js"></script>	
    <link href="css/material.css" rel="stylesheet">
	<title>Peliculas</title>
</head>
<body>
	<div class="container">
		<div class="row">
		    <div class="col s12">
		      	<ul class="tabs">
			        <li class="tab col s12"><a href="#test1">Peliculas</a></li>
		      	</ul>
		    </div>
		    <!-- inicio contenido del tab -->
		    <div id="test1" class="col s12">
	    		<div class="row "  >

	    			<div class="col s1 offset-s11" style="margin-top: 1em">
	    				<a class="waves-effect waves-light btn tooltipped modal-trigger" data-position="bottom" data-target="modalPelicula" data-tooltip="Agregar Pelicula">
	    					<i class="material-icons">add</i>
	    				</a>
	    			</div>

	    			<div class="card-columns" >
		    			<div id="txt_peliculas" >
		    				

		    			</div>
	    			</div>
	    		</div>
			</div>
			<!-- fin contendio del tab -->
		</div>
	</div>

	<!-- Inicio modal peliculas -->
		<div id="modalPelicula" class="modal">
		    <div class="modal-content">
		    	<div class="row" >
				    <div class="col s12">
				    	<h4 name='tituloPelicula' class="center-align" >Creación Pelicula</h4>
				   	</div>
				   	<div class="input-field col s12">
			          	<i class="material-icons prefix">movie</i>
			          	<input id="titulo_pelicula" name="titulo_pelicula" type="text" class="validate">
			          	<label for="titulo_pelicula"> Titulo de la Pelicula </label>
			        </div>
			        <div class="input-field col s12">
			          	<i class="material-icons prefix">subtitles</i>
			          	<textarea id="des_pelicula" name="des_pelicula" class="materialize-textarea"></textarea>
			          	<label for="des_pelicula"> Descripción de la Pelicula </label>
			        </div>
			        <div class="input-field col s6">
					    <select name="tipo_formato" id="tipo_formato" >
						    <option value="1">Pelicula</option>
						    <option value="2">Serie</option>
						    <option value="3">Mini Serie</option>
					    </select>
					    <label>Tipo de Formato</label>
					</div>
					<div class="col s2" style="padding-top: 20px">
						<i class="material-icons" >local_play</i> Calificacion 
					</div>
					<div class="col s4 center-align">
						<form class="form">
						    <p class="clasificacion">
						    	<input id="radio1" type="radio" name="estrellas" value="5"><!--
						    	--><label for="radio1">★</label><!--
						    	--><input id="radio2" type="radio" name="estrellas" value="4"><!--
						    	--><label for="radio2">★</label><!--
						    	--><input id="radio3" type="radio" name="estrellas" value="3"><!--
						    	--><label for="radio3">★</label><!--
						    	--><input id="radio4" type="radio" name="estrellas" value="2"><!--
						    	--><label for="radio4">★</label><!--
						    	--><input id="radio5" type="radio" name="estrellas" value="1"><!--
						    	--><label for="radio5">★</label>
						  	</p>
						</form>
					</div>
		    	</div>
		    </div>
		    <div class="modal-footer">
		      <a class="waves-effect waves-green btn-flat" name="saveMovies" id="saveMovies" onclick="saveMovies()" > <i class="material-icons" >save</i> Guardar</a>
		    </div>
		</div>
	<!-- fin modela peliculas -->

	<!-- Compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script type="text/javascript">
		// inicializa modales
		// document.addEventListener('DOMContentLoaded', function() {
	 //    	var elems = document.querySelectorAll('.modal');
	 //    	var instancesModal = M.Modal.init(elems);
	 //    	var instance = M.Modal.getInstance(elems);
	 //  	});
		$(document).ready(function(){
			// inicializa tabs
		    $('.tabs').tabs();
		    // inicializa toolstips
		    $('.tooltipped').tooltip();
		    // inicializa modales
		    $('.modal').modal();
		    // inicializar select 
		    $('select').formSelect();

		    // metodo para traer todas las peliculas
		    getPeliculas();
		  });
	</script>
	
	<script src="js/gestion_peliculas.js"></script>
</body>
</html>