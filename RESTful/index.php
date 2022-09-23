<?php
require_once("../anbindung_db.php");
require_once("./oneBook.php");
require_once("./allBooks.php");
require_once("./oneGeneric.php");
require_once("./allGeneric.php");

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
#print_r($request);
#$anzahl = count ( $request );
#echo "<p>Es gibt $anzahl Einträge</p>";
#echo "<ul>";
 
#for ($x = 0; $x < $anzahl; $x++)
#{
    #echo "<li>Eintrag von $x ist $request[$x] </li>";
#}
 
#echo "</ul>";
# echo  $_SERVER['PHP_SELF']; # bringt den script
# echo "</br>";
# echo $_SERVER['REQUEST_URI'];
# echo "</br>server:";
# echo $_SERVER['HTTP_HOST'];

function getRequest() {
  $json='error';
  $befehle =$_SERVER['REQUEST_URI'];
 
  if (strpos($befehle, "/restful/book")) $json = onBook($befehle);
  if (strpos($befehle, "/restful/autor")) $json = onGeneric($befehle,'autor','au_id');
  if (strpos($befehle, "/restful/publisher")) $json = onGeneric($befehle,'publisher','pb_id');
  if (strpos($befehle, "/restful/serie")) $json = onGeneric($befehle,'book_series','bs_id');
  if (strpos($befehle, "/restful/genre")) $json = onGeneric($befehle,'genre','ge_id');
  if (strpos($befehle, "/restful/cover")) $json = onGeneric($befehle,'cover','co_id');
  if (strpos($befehle, "/restful/bind")) $json = onGeneric($befehle,'bind','bi_id');
  if (strpos($befehle, "/restful/storage")) $json = onGeneric($befehle,'storage','st_id');

# Seitenbau
  if ($json=='error') {
    header("HTTP/1.0 404 Not Found");
    echo 'Die Angefragte Ressource konnte nicht gefunden werden!</br>';
    echo 'Verfügbare Ressourcen: </br>';
    echo "/restful/book</br>";
    echo "/restful/autor</br>";
    echo "/restful/publisher</br>";
    echo "/restful/serie</br>";
    echo "/restful/genre</br>";
    echo "/restful/cover</br>";
    echo "/restful/bind</br>";
    echo "/restful/storage</br>";
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

 function onGeneric($uri,$target,$id) {
  $suche= strrpos($uri, '/');
  $gefunden = substr($uri,$suche+1);
  if (is_numeric($gefunden)) { # Zahl am Ende gefunden also einzelnes Buch Listen
    return oneGeneric($gefunden,$target,$id);
  }else {
    # alle Bücher Listen;
    return allGeneric($target,$id);
  }
 }
 
?>