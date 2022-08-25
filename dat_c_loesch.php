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

if(isset($_REQUEST['c_co_id']))
  $c_co_id=$_REQUEST['c_co_id'];
else
  $c_co_id='';

# Daten inhalt Pr�fen testen auf injection

if($c_co_id== '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollst�ndig abbruch
{
  html_kopf();
  echo 'Die Daten entsprechen nicht den Anforderungen bitte pr�fen sie ihre Eingaben!&nbsp;&nbsp;';
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zur�ck</span>';
  html_fuss();
  exit();
}
  
# testen ob Cover noch verwender wird, wenn ja B�cher zum Editieren anlisten

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bo_title,bo_id FROM book WHERE bo_co_id='{$c_co_id}'");

if($result->rowCount()) # Bücher mit Cover vorhanden
{
  html_kopf("Cover noch verwendet");
  echo "Das Cover wird noch bei folgenden Büchern verwendet";
  echo '<table border="1">';
  echo '<tr><th>Buchtitel</th><th>Editieren</th>';
  echo '</tr>';
	$rows = $result->fetchAll();    
  foreach ( $rows as $ergebnis)   # solange bis alle Datens�tze dargestellt sind ausgeben
  {
	echo '<tr class="drill_in" onclick="';
    echo "parent.display('dat_b_edit.php?c_bo_id=";
    echo $ergebnis["bo_id"];
    echo "')";
    echo '"><td>';
    echo $ergebnis["bo_title"];
    echo '</td><td>';        
    echo '<input name="c_bo_id" type="button" value="Editieren" />';
    echo '</td>';
    echo '</tr>';
    echo "\n";
  }  
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Cover nicht verwendet, löschen und erfolgsmeldung geben

$sqlstr="DELETE FROM cover WHERE co_id='{$c_co_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Das Cover wurde erfolgreich aus der Datenbank entfernt!";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig