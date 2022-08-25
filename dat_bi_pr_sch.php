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
if(isset($_REQUEST['c_bi_type']))
  $c_bi_type=addslashes($_REQUEST['c_bi_type']);
else
  $c_bi_type='';

if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';
# Daten inhalt Pr�fen testen auf injection

if($c_bi_type== '')
  $alles_io=false;
  
if(!$alles_io) # wenn Daten unvollst�ndig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# testen ob Bindung schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bi_type FROM bind where bi_type='{$c_bi_type}'");

if($result->rowCount()) # Bindung bereits vorhanden
{
  
# Bindung vorhanden Hinweis 
  html_kopf("Bindung schon vorhanden");
  echo "Eine Bindung mit dem Namen {$c_bi_type} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Bindung noch nicht vorhanden, einfügen erfolgsmeldung geben

$sqlstr="INSERT INTO bind (bi_type) VALUES ('{$c_bi_type}')";
# echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf("Bindungsart angelegt",false,"js/onload_focus.js");
  echo "Die Bindungsart wurde erfolgreich in die Datenbank eingefügt!";
  echo '<input type="button" id="focus" value="Weitere Bindung anlegen" onclick="window.open(';
  echo "'dat_bi_neu.php?mode=".$mode."','_self')";
  echo '" />'; 
  if($mode=='b_neu')
  {
  	$bi_id=$verbindung->lastInsertId();
        echo '<table><tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_bi('";
        echo $bi_id;
        echo "','" .stripslashes($c_bi_type);
        echo "')";        
        echo '"><td>';
        echo stripslashes($c_bi_type);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_bi_id" type="button" value="gleich übernehmen" />';
        echo '</td>';
        echo '</tr></table>';      	
  }  
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig