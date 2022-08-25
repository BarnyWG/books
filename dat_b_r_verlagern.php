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

if(isset($_REQUEST['c_bo_id']))
  $c_bo_id=$_REQUEST['c_bo_id'];
else
  $c_bo_id='';
  
#Buchtitel
if(isset($_REQUEST['c_bo_title']))
  $c_bo_title=addslashes($_REQUEST['c_bo_title']);
else
  $c_bo_title='';
    
# Hole Name des Regals von dem Ausgelagert wird
if(isset($_REQUEST['c_st_name']))
  $c_st_name=$_REQUEST['c_st_name'];
else
  $c_st_name="";

# Hole ID des Regales in das eingelagert werden soll
if(isset($_REQUEST['regal']))
  $c_regal_target=$_REQUEST['regal'];
else
  $c_regal_target=0;
   
# Daten inhalt Prüfen testen auf injection

if($c_bo_id== '')
  $alles_io=false;

if($c_regal_target== '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

# Buch updaten Regal Daten erfolgsmeldung geben
anbindung_db($verbindung);
$sqlstr="UPDATE book SET bo_st_id='{$c_regal_target}' WHERE bo_id='{$c_bo_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf("Done");
  print "Das Buch $c_bo_title wurde erfolgreich von Regal $c_st_name in das Zielregal überführt!";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig

