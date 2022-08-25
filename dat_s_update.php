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
if(isset($_REQUEST['c_bs_id']))
  $c_bs_id=$_REQUEST['c_bs_id'];
else
  $c_bs_id='';
  
if(isset($_REQUEST['c_bs_name']))
  $c_bs_name=addslashes($_REQUEST['c_bs_name']);
else
  $c_bs_name='';

# Daten inhalt Prüfen testen auf injection

if($c_bs_id == '')
  $alles_io=false;

if($c_bs_name == '')
  $alles_io=false;
if(strlen($c_bs_name) > 60)
  $alles_io = false;
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# Serie update

anbindung_db($verbindung);

$sqlstr="UPDATE book_series SET bs_name='{$c_bs_name}' WHERE bs_id='{$c_bs_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Die Serie wurde erfolgreich in die Datenbank geändert";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig