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
if(isset($_REQUEST['c_pb_id']))
  $c_pb_id=$_REQUEST['c_pb_id'];
else
  $c_pb_id='';
  
if(isset($_REQUEST['c_pb_name']))
  $c_pb_name=addslashes($_REQUEST['c_pb_name']);
else
  $c_pb_name='';

if(isset($_REQUEST['c_pb_street']))
  $c_pb_street=addslashes($_REQUEST['c_pb_street']);
else
  $c_pb_street='';

if(isset($_REQUEST['c_pb_postindex']))
  $c_pb_postindex=$_REQUEST['c_pb_postindex'];
else
  $c_pb_postindex='';

if(isset($_REQUEST['c_pb_location']))
  $c_pb_location=addslashes($_REQUEST['c_pb_location']);
else
  $c_pb_location='';  

# Daten inhalt Prüfen testen auf injection

if($c_pb_id == '')
  $alles_io=false;
  
if($c_pb_name == '')
  $alles_io=false;
if(strlen($c_pb_name) > 200)
  $alles_io = false;
  
if(strlen($c_pb_street) > 40)
  $alles_io = false;

if(strlen($c_pb_postindex) > 5)
  $alles_io = false;
  
#if(!preg_match('/[0-9]{1}[0-9]{1}[0-9]{1}[0-9]{1}[0-9]{1}/',$c_pb_postindex)) # 5 Stellige Zahl
#  $alles_io=false;  

if(strlen($c_pb_location) > 40)
  $alles_io = false; 
  
#$c_pb_name=addslashes($c_pb_name); # Escapen
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# Publischer Update

anbindung_db($verbindung);

$sqlstr="UPDATE publisher SET pb_name='{$c_pb_name}',pb_street='{$c_pb_street}',pb_postindex='{$c_pb_postindex}',pb_location='{$c_pb_location}' WHERE pb_id='{$c_pb_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Der Verlag wurde erfolgreich in die Datenbank gepflegt";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig