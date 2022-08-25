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

if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';
  
# Daten inhalt Prüfen testen auf injection

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
  
$c_pb_name=addslashes($c_pb_name); # Escapen
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# testen ob Publischer schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT pb_name FROM publisher where pb_name='{$c_pb_name}'");

if($result->rowCount()) # Autor bereits vorhanden
{
# Verlag vorhanden Hinweis 
  html_kopf("Verlag schon vorhanden");
  echo "Ein Verlag mit dem Namen {$c_pb_name} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Verlag noch nicht vorhanden, einfügen erfolgsmeldung geben

$sqlstr="INSERT INTO publisher (pb_name,pb_street,pb_postindex,pb_location) VALUES ('{$c_pb_name}','{$c_pb_street}','{$c_pb_postindex}','{$c_pb_location}')";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf("Verlag erfolgreich",false,"js/onload_focus.js");
  echo "Der Verlag wurde erfolgreich in die Datenbank eingef&uuml;gt!";
  echo '<input type="button" id="focus" value="Weiteren Verlag anlegen" onclick="window.open(';
  echo "'dat_v_neu.php?mode=".$mode."','_self')";
  echo '" />';
  if($mode=='b_neu')
  {
  	$pb_id=$verbindung->lastInsertId();
        echo '<table><tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_v('";
        echo $pb_id;
        echo "','" .stripslashes($c_pb_name);
        echo "','" .stripslashes($c_pb_location)."')";         
        echo '"><td>';
        echo stripslashes($c_pb_name);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_pb_id" type="button" value="gleich &uuml;bernehmen" />';
        echo '</td>';
        echo '</tr></table>';    	
  }  
  html_fuss();	
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig