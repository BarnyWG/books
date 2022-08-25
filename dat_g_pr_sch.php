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
if(isset($_REQUEST['c_ge_type']))
  $c_ge_type=addslashes($_REQUEST['c_ge_type']);
else
  $c_ge_type='';
  
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

# Daten inhalt Prüfen testen auf injection

if($c_ge_type== '')
  $alles_io=false;
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf("Datenfehler");
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# testen ob Genre schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT ge_type FROM genre where ge_type='{$c_ge_type}'");

if($result->rowCount()) # Genre bereits vorhanden
{
# Verlag vorhanden Hinweis 
  html_kopf("Genre schon vorhanden");
  echo "Ein Genre mit dem Namen {$c_ge_type} ist bereits in der Datenbank vorhanden pr&uuml;fen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zur&uuml;ck</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Genre noch nicht vorhanden, einfügen erfolgsmeldung geben

$sqlstr="INSERT INTO genre (ge_type) VALUES ('{$c_ge_type}')";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf("Genre erfolgreich",false,"js/onload_focus.js");
  echo "Das Genre wurde erfolgreich in die Datenbank eingef&uuml;gt!";
  echo '<input type="button" id="focus" value="Weiteres Genre anlegen" onclick="window.open(';
  echo "'dat_g_neu.php?mode=".$mode."','_self')";
  echo '" />';
  if($mode=='b_neu')
  {
  	$ge_id=$verbindung->lastInsertId();
        echo '<table><tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_g('";
        echo $ge_id;
        echo "','" .stripslashes($c_ge_type);
        echo "')";        
        echo '"><td>';
        echo stripslashes($c_ge_type);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_ge_id" type="button" value="gleich &uuml;bernehmen" />';
        echo '</td>';
        echo '</tr></table>';  	
  }    	
  html_fuss();	
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig