<?php
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");	
html_kopf("Buch Anzeigen",false,"js/dat_b_neu.js");

if(isset($_REQUEST['c_bo_id']))
  $c_bo_id=$_REQUEST['c_bo_id'];
else
  die('Fehler');
  
anbindung_db($verbindung);

$io=$verbindung->exec("DELETE FROM ll_bo_au WHERE ll_bo_au_bo_id='{$c_bo_id}'");
if($io)
{
  echo "...Autoren verbindungen gelöscht!";
}
else 
	echo "...Autoren verbindungen konnten nicht gelöscht werden!";
	
$io=$verbindung->exec("DELETE FROM book WHERE bo_id='{$c_bo_id}'");
if($io)
{
  echo "...Buch gelöscht!";
}
else 

  echo "...Buch konnte nicht entfernt werden!";

html_fuss();
?>