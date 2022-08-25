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
  
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

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
  
# testen ob Regal schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT st_name FROM storage where st_name='{$c_st_name}' AND st_location='{$c_st_location}'");

if($result->rowCount()) # Regal bereits vorhanden
{
  html_kopf("Regal schon vorhanden");
  echo "Ein Regal mit dem Namen {$c_st_name} an dem Ort {$c_st_location} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Regal noch nicht vorhanden, einfügen erfolgsmeldung geben

$sqlstr="INSERT INTO storage (st_name,st_height,st_width,st_deep,st_location,st_capa) VALUES ('{$c_st_name}','{$c_st_height}','{$c_st_width}','{$c_st_deep}','$c_st_location','$c_st_capa')";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf("Regal erfolgreich",false,"js/onload_focus.js");
  echo "Das Regal wurde erfolgreich in die Datenbank eingefügt!";
  echo '<input type="button" id="focus" value="Weiteres Regal anlegen" onclick="window.open(';
  echo "'dat_r_neu.php?mode=".$mode."','_self')";
  echo '" />';
  if($mode=='b_neu')
  {
  	$st_id=$verbindung->lastInsertId();
        echo '<table><tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_r('";
        echo $st_id;
        echo "','" .stripslashes($c_st_name);
        echo "')";        
        echo '"><td>';
        echo stripslashes($c_st_name);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_st_id" type="button" value="gleich übernehmen" />';
        echo '</td>';
        echo '</tr></table>';    	
  }  
  html_fuss();	
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig