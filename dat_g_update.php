<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");
require_once("inc/db_fehler.php");

# Daten holen

$alles_io=true;
if(isset($_REQUEST['c_ge_id']))
  $c_ge_id=$_REQUEST['c_ge_id'];
else
  $c_ge_id='';
  
if(isset($_REQUEST['c_ge_type']))
  $c_ge_type=addslashes($_REQUEST['c_ge_type']);
else
  $c_ge_type='';

# Daten inhalt Prüfen testen auf injection

if($c_ge_id == '')
  $alles_io=false;

if($c_ge_type== '')
  $alles_io=false;
if(strlen($c_ge_type) > 20)
  $alles_io = false;
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  echo 'Die Daten entsprechen nicht den Anforderungen bitte Prüfen sie ihre Eingaben';
  echo '<input type="button" value="<<Zurück" onclick="parent.history.back()">';
  html_fuss();
  exit();
}
  
# Genre update

anbindung_db($verbindung);

$sqlstr="UPDATE genre SET ge_type='{$c_ge_type}' WHERE ge_id='{$c_ge_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Das Genre wurde erfolgreich in der Datenbank geändert";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig