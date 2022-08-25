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
if(isset($_REQUEST['c_co_id']))
  $c_co_id=$_REQUEST['c_co_id'];
else
  $c_bs_id='';
  
if(isset($_REQUEST['c_co_type']))
  $c_co_type=addslashes($_REQUEST['c_co_type']);
else
  $c_co_type='';

# Daten inhalt Prüfen testen auf injection

if($c_co_id == '')
  $alles_io=false;

if($c_co_type == '')
  $alles_io=false;
if(strlen($c_co_type) > 20)
  $alles_io = false;
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# Cover update

anbindung_db($verbindung);

$sqlstr="UPDATE cover SET co_type='{$c_co_type}' WHERE co_id='{$c_co_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Die Coverart wurde erfolgreich in die Datenbank geändert";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig