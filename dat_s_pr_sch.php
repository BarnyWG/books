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
if(isset($_REQUEST['c_bs_name']))
  $c_bs_name=addslashes($_REQUEST['c_bs_name']);
else
  $c_bs_name='';
  
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

# Daten inhalt Prüfen testen auf injection

if($c_bs_name == '')
  $alles_io=false;
if(strlen($c_bs_name) > 60)
  $alles_io = false;
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  echo 'Die Daten entsprechen nicht den Anforderungen bitte pr&uuml;fen sie ihre Eingaben!&nbsp;&nbsp;';
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zur&uuml;ck</span>';
  html_fuss();
  exit();
}
  
# testen ob Serie schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bs_name FROM book_series where bs_name='{$c_bs_name}'");

if($result->rowCount()) # Serie bereits vorhanden
{
  html_kopf("Serie schon vorhanden");
  echo "Ein Serie mit dem Namen {$c_bs_name} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Serie noch nicht vorhanden, einfügen erfolgsmeldung geben

$sqlstr="INSERT INTO book_series (bs_name) VALUES ('{$c_bs_name}')";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf("Serie erfolgreich",false,"js/onload_focus.js");
  echo "Die Serie wurde erfolgreich in die Datenbank eingefügt!";
  echo '<input type="button" id="focus" value="Weitere Serie anlegen" onclick="window.open(';
  echo "'dat_s_neu.php?mode=".$mode."','_self')";
  echo '" />';
  if($mode=='b_neu')
  {
  	$bs_id=$verbindung->lastInsertId();
        echo '<table><tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_s('";
        echo $bs_id;
        echo "','" .stripslashes($c_bs_name);
        echo "')";        
        echo '"><td>';
        echo stripslashes($c_bs_name);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_bs_id" type="button" value="gleich &uuml;bernehmen" />';
        echo '</td>';
        echo '</tr></table>';    	
  }  
  html_fuss();	
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig