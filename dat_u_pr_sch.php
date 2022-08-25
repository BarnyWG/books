<?php
@session_start();
#error_reporting(E_ALL);
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
$meldung='';
$alles_io=true;
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

if($c_us_name== '')
{
  $alles_io=false;
  $meldung=$meldung . '<br>Username darf nicht leer sein. ';
}
if(strlen($c_us_name) > 20)
{
  $alles_io = false;
  $meldung=$meldung . '<br>Username darf nur 20 Zeichen lang sein. ';
}
if(strlen($c_us_name) < 8)
{
  $alles_io = false; 
  $meldung=$meldung . '<br>Username muss mindestens 8 Zeichen lang sein. ';
}

if($c_us_pass== '')
{
  $alles_io=false;
  $meldung=$meldung . '<br>Userpasswort darf nicht leer sein. ';
}
if(strlen($c_us_pass) > 32)
{
  $alles_io = false;  
  $meldung=$meldung . '<br>Userpasswort darf nur 32 Zeichen Lang sein. ';
}
if(strlen($c_us_working) > 20)
{  
  $alles_io = false;  
  $meldung=$meldung . '<br>Workingeinträge maximal 20 Zeichen. ';
}
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  echo $meldung;
  html_fuss();
  exit();
}
  
# testen ob User schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT us_name FROM user WHERE us_name='{$c_us_name}'");

if($result->rowCount()) # User bereits vorhanden
{
  html_kopf("User schon vorhanden");
  echo "Ein Benutzer mit dem Namen {$c_us_name} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# User noch nicht vorhanden, einfügen erfolgsmeldung geben
$c_us_pass=md5($c_us_pass);
$sqlstr="INSERT INTO user (us_name,us_pass,us_working,us_level) VALUES ('{$c_us_name}','{$c_us_pass}','{$c_us_working}','{$c_us_level}')";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Der Benutzer wurde erfolgreich in die Datenbank eingefügt!";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig