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
if(isset($_REQUEST['c_st_id']))
  $c_st_id=$_REQUEST['c_st_id'];
else
  $alles_io=false;
  
if(isset($_REQUEST['c_st_name']))
  $c_st_name=addslashes($_REQUEST['c_st_name']);
else
  $c_st_name='';

if(isset($_REQUEST['c_st_height']))
  $c_st_height=$_REQUEST['c_st_height'];
else
  $c_st_height='';

if(isset($_REQUEST['c_st_width']))
  $c_st_width=$_REQUEST['c_st_width'];
else
  $c_st_width='';

if(isset($_REQUEST['c_st_deep']))
  $c_st_deep=$_REQUEST['c_st_deep'];
else
  $c_st_deep='';

if(isset($_REQUEST['c_st_capa']))
  $c_st_capa=$_REQUEST['c_st_capa'];
else
  $c_st_capa='';
  
if(isset($_REQUEST['c_st_location']))
  $c_st_location=addslashes($_REQUEST['c_st_location']);
else
  $c_st_location='';

# Daten inhalt Prüfen testen auf injection

if($c_st_name== '')
  $alles_io=false;
if(strlen($c_st_name) > 50)
  $alles_io = false;
if($c_st_location== '')
  $alles_io=false;
if(strlen($c_st_location) > 50)
  $alles_io = false;
if($c_st_height== '')
  $c_st_height=0;
if($c_st_width== '')
  $c_st_width=0;
if($c_st_deep== '')
  $c_st_deep=0;
if($c_st_capa== '')
  $c_st_capa=0;

  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# Regal update

anbindung_db($verbindung);

$sqlstr="UPDATE storage SET st_name='{$c_st_name}', st_height='{$c_st_height}', st_width='{$c_st_width}', st_deep='{$c_st_deep}', st_location='{$c_st_location}', st_capa='{$c_st_capa}' WHERE st_id='{$c_st_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Das Regal wurde erfolgreich in der Datenbank geändert";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig