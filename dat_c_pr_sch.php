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
if(isset($_REQUEST['c_co_type']))
  $c_co_type=addslashes($_REQUEST['c_co_type']);
else
  $c_co_type='';
  
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';

# Daten inhalt Prüfen testen auf injection

if($c_co_type == '')
  $alles_io=false;
if(strlen($c_co_type) > 20)
  $alles_io = false;
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf("Datenfehler");
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# testen ob Cover schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT co_type FROM cover where co_type='{$c_co_type}'");

if($result->rowCount()) # Cover bereits vorhanden
{
  
  html_kopf("Coverart schon vorhanden");
  echo "Ein Coverart mit dem Namen {$c_co_type} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Cover noch nicht vorhanden, einfügen erfolgsmeldung geben

$sqlstr="INSERT INTO cover (co_type) VALUES ('{$c_co_type}')";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf("Cover erfolgreich",false,"js/onload_focus.js");
  echo "Die Coverart wurde erfolgreich in die Datenbank eingefügt!";
  echo '<input type="button" id="focus" value="Weiteres Cover anlegen" onclick="window.open(';
  echo "'dat_c_neu.php?mode=".$mode."','_self')";
  echo '" />';
  if($mode=='b_neu')
  {
  	$co_id=$verbindung->lastInsertId();
        echo '<table><tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_c('";
        echo $co_id;
        echo "','" .stripslashes($c_co_type);
        echo "')";        
        echo '"><td>';
        echo stripslashes($c_co_type);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_co_id" type="button" value="gleich übernehmen" />';
        echo '</td>';
        echo '</tr></table>';  	
  }  
  html_fuss();	
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig