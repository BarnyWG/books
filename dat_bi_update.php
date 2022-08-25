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
if(isset($_REQUEST['c_bi_id']))
  $c_bi_id=$_REQUEST['c_bi_id'];
else
  $c_bi_id='';
  
if(isset($_REQUEST['c_bi_type']))
  $c_bi_type=addslashes($_REQUEST['c_bi_type']);
else
  $c_bi_type='';

# Daten inhalt Prüfen testen auf injection

if($c_bi_id == '')
  $alles_io=false;

if($c_bi_type== '')
  $alles_io=false;
if(strlen($c_bi_type) > 20)
  $alles_io = false;
  
if(!$alles_io) # wenn Daten unvollst�ndig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# Bindung update

anbindung_db($verbindung);

$sqlstr="UPDATE bind SET bi_type='{$c_bi_type}' WHERE bi_id='{$c_bi_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Die Bindungsart wurde erfolgreich in der Datenbank geändert";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig