<?php
include "config.php";
include "utils.php";


$dbConn =  connect($db);

/*
  listar todos los posts o solo uno
  Si se envia por la url calificacion = true, va a mostrar el top 10 de las peliculas mejor calificacas
  Si se envia pro la url fecha = true , va a mostar todas las peliculas ordenadas por la fechad de creacion.
  Si se envia por la url nombre , va a poder filtrar las peliculas por el nombre 
  Si se envia por la url categoria , se va poder filtrar todas las peliculas por las categorias ( ENVIAR EL ID DE LA TABLA TIPO_FORMATO )
 */
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

  if ( isset($_GET["calificacion"]) == 'true' ){
    $sql = $dbConn->prepare("SELECT * FROM peliculas p JOIN tipo_formato tp ON tp.Id = p.tipo_formato WHERE p.calificacion in ('4','5') order by calificacion");
    // $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode( $sql->fetchAll()  );
    exit();
  } else if ( isset($_GET["fecha"]) == 'true' ) {
    $sql = $dbConn->prepare("SELECT * FROM peliculas p JOIN tipo_formato tp ON tp.Id = p.tipo_formato ORDER BY p.fec_creacion LIMIT 10");
    // $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode( $sql->fetchAll()  );
    exit();
  } else if ( isset($_GET["nombre"]) or isset($_GET["categoria"]) )  {

    if ( isset($_GET["nombre"]) != '' and isset($_GET["categoria"]) != '' ) {

      $filtro = "WHERE p.titulo LIKE '%" . $_GET["nombre"] . "%' AND tp.id IN(" . $_GET["categoria"] . ") ";
    
    } else if ( isset($_GET["nombre"])  ){
      
      $filtro = " WHERE p.titulo LIKE '%" . $_GET["nombre"] . "%' ";
    
    } else if ( isset($_GET["categoria"]) ){
      
      $filtro = " WHERE tp.id IN( " . $_GET["categoria"] . " ) ";
    
    }

    $sql = $dbConn->prepare("SELECT * FROM peliculas p JOIN tipo_formato tp ON tp.Id = p.tipo_formato ". $filtro ." ");
    // $sql->bindValue(':id', $_GET['id']);
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    header("HTTP/1.1 200 OK");
    echo json_encode( $sql->fetchAll()  );
    exit();
  } else {
    if (isset($_GET['id'])) {
        //Mostrar un post
        $sql = $dbConn->prepare("SELECT * FROM peliculas p JOIN tipo_formato tp ON tp.Id = p.tipo_formato where p.idserial=:id");
        $sql->bindValue(':id', $_GET['id']);
        $sql->execute();
        header("HTTP/1.1 200 OK");
        echo json_encode(  $sql->fetch(PDO::FETCH_ASSOC)  );
        exit();
      }else {
        //Mostrar lista de post
        $sql = $dbConn->prepare("SELECT * FROM peliculas p JOIN tipo_formato tp ON tp.Id = p.tipo_formato");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 OK");
        echo json_encode( $sql->fetchAll()  );
        exit();
      }
  }
      
}

// Crear un nuevo post
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $input = $_POST;
    $sql = "INSERT INTO peliculas
          ( titulo, tipo_formato, descripcion, calificacion )
          VALUES
          (?, ?, ?, ?)";
    $statement = $dbConn->prepare($sql);
    // bindAllValues($statement, $input);
    // echo '<pre>' . print_r($input,true) . '</pre>';
    
    if ( $statement->execute( array($input['titulo'],$input['tipo_formato'],$input['descripcion'],$input['calificacion']) ) ){
      $postId = $dbConn->lastInsertId();
      
      if($postId)
      {
        $input['id'] = $postId;
        header("HTTP/1.1 200 OK");
        echo json_encode($input);
        exit();
  	 }

    } else {
      echo 'Hubo un error al insertar la pelicula intentelo de nuevo';
      exit();
    }
}

//Borrar
if ($_SERVER['REQUEST_METHOD'] == 'DELETE')
{
	$id = $_GET['id'];
  $statement = $dbConn->prepare("DELETE FROM peliculas where idserial=:id");
  $statement->bindValue(':id', $id);
  $statement->execute();
	header("HTTP/1.1 200 OK");
	exit();
}

//Actualizar
if ($_SERVER['REQUEST_METHOD'] == 'PUT')
{
    $input = $_GET;
    $postId = $input['idserial'];
    $fields = getParams($input);

    $sql = "
          UPDATE peliculas
          SET $fields
          WHERE idserial='$postId'
           ";

    $statement = $dbConn->prepare($sql);
    bindAllValues($statement, $input);

    $statement->execute();
    header("HTTP/1.1 200 OK");
    exit();
}


//En caso de que ninguna de las opciones anteriores se haya ejecutado
header("HTTP/1.1 400 Bad Request");

?>