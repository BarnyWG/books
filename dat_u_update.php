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
$pass_rf=false;

if(isset($_REQUEST['c_us_id']))
  $c_us_id=$_REQUEST['c_us_id'];
else
  $alles_io=false;
  
if(isset($_REQUEST['c_us_name']))
  $c_us_name=$_REQUEST['c_us_name'];
else
  $c_us_name='';

if(isset($_REQUEST['c_us_pass']))
  $c_us_pass=$_REQUEST['c_us_pass'];
else
  $c_us_pass='';

if(isset($_REQUEST['c_us_working']))
  $c_us_working=$_REQUEST['c_us_working'];
else
  $c_us_working='';  
  
if(isset($_REQUEST['c_us_level']))
  $c_us_level=$_REQUEST['c_us_level'];
else
  $c_us_level=''; 

# Daten inhalt Prüfen testen auf injection

if($c_us_pass > '')
  $pass_rf=true;

if(strlen($c_us_pass) > 32)
  $alles_io=false;
   
if(strlen($c_us_name) < 8)
  $alles_io=false;

if(strlen($c_us_name) >20)
  $alles_io=false;

if(strlen($c_us_working) > 20)
  $alles_io = false;  
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# Benutzer update

anbindung_db($verbindung);
if($pass_rf)
{
  $c_us_pass=md5($c_us_pass);	
  $sqlstr="UPDATE user SET us_name='{$c_us_name}', us_pass='{$c_us_pass}', us_working='{$c_us_working}', us_level='{$c_us_level}' WHERE us_id='{$c_us_id}'";
}
else
  $sqlstr="UPDATE user SET us_name='{$c_us_name}', us_working='{$c_us_working}', us_level='{$c_us_level}' WHERE us_id='{$c_us_id}'";
  
#echo "$sqlstr<br>";
$io=$verbindung->query($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Der Benutzer wurde erfolgreich in der Datenbank geändert!";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig