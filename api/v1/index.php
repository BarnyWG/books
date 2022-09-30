<?php
require_once("../../anbindung_db.php");
require_once("../includes_v1/oneBook.php");
require_once("../includes_v1/allBooks.php");
require_once("../includes_v1/oneGeneric.php");
require_once("../includes_v1/allGeneric.php");

$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

switch ($method) {
  case 'PUT':
    #do_something_with_put($request);  
    echo "Put Nicht unterstützt";
    break;
  case 'POST':
    #do_something_with_post($request);
    echo "Post Nicht unterstützt";  
    break;
  case 'GET':
    #do_something_with_get($request);
    getRequest();
    break;
  default:
    handle_error($request);  
    break;
}

function getRequest() {
  $json='error';
  $befehle =$_SERVER['REQUEST_URI'];
 
  if (strpos($befehle, "/v1/book")) $json = onBook($befehle);
  if (strpos($befehle, "/v1/autor")) $json = onGeneric($befehle,'autor','au_id','autor');
  if (strpos($befehle, "/v1/publisher")) $json = onGeneric($befehle,'publisher','pb_id','pubisher');
  if (strpos($befehle, "/v1/serie")) $json = onGeneric($befehle,'book_series','bs_id','series');
  if (strpos($befehle, "/v1/genre")) $json = onGeneric($befehle,'genre','ge_id','genre');
  if (strpos($befehle, "/v1/cover")) $json = onGeneric($befehle,'cover','co_id','cover');
  if (strpos($befehle, "/v1/bind")) $json = onGeneric($befehle,'bind','bi_id','bindings');
  if (strpos($befehle, "/v1/storage")) $json = onGeneric($befehle,'storage','st_id','storages');

# Seitenbau
  if ($json=='error') {
    header("HTTP/1.0 404 Not Found");
    echo 'Die Angefragte Ressource konnte nicht gefunden werden!</br>';
    echo 'Verfügbare Ressourcen: </br>';
    echo "/v1/book</br>";
    echo "/v1/autor</br>";
    echo "/v1/publisher</br>";
    echo "/v1/serie</br>";
    echo "/v1/genre</br>";
    echo "/v1/cover</br>";
    echo "/v1/bind</br>";
    echo "/v1/storage</br>";
  }else{
    header('HTTP/1.1 200 OK');
    header( "Content-Type: application/json");
    echo $json;
  }
}

function onBook($uri) {
  # Analyse nur ein bestimmtes buch also /books/Nummer oder /books
  $suche= strrpos($uri, '/');
  $gefunden = substr($uri,$suche+1);
  if (is_numeric($gefunden)) { # Zahl am Ende gefunden also einzelnes Buch Listen
    return oneBook($gefunden);
  }else {
    # alle Bücher Listen;
    return allBooks();
  }
}

 function onGeneric($uri,$target,$id,$titel) {
  $suche= strrpos($uri, '/');
  $gefunden = substr($uri,$suche+1);
  if (is_numeric($gefunden)) { # Zahl am Ende gefunden also einzelnes Buch Listen
    return oneGeneric($gefunden,$target,$id);
  }else {
    # alle Bücher Listen;
    return allGeneric($target,$id,$titel);
  }
 }
 
?>