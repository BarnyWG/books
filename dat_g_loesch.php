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

if(isset($_REQUEST['c_ge_id']))
  $c_ge_id=$_REQUEST['c_ge_id'];
else
  $c_ge_id='';

# Daten inhalt Prüfen testen auf injection

if($c_ge_id== '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# testen ob Bindungsart noch verwendet wird, wenn ja Bücher zum Editieren anlisten

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bo_title,bo_id FROM book WHERE bo_ge_id='{$c_ge_id}'");

if($result->rowCount()) # Bücher mit Genre vorhanden
{
  html_kopf("Genre noch verwendet");
  echo "Das Genre wird noch bei folgenden Büchern verwendet";
  echo '<table border="1">';
  echo '<tr><th>Buchtitel</th><th>Editieren</th>';
  echo '</tr>';
  $rows = $result->fetchAll();
  foreach ($rows as $ergebnis)  # solange bis alle Datensätze dargestellt sind ausgeben
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

# Genre nicht verwendet, löschen und erfolgsmeldung geben

$sqlstr="DELETE FROM genre WHERE ge_id='{$c_ge_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->query($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
  html_kopf();
  echo "Das Genre wurde erfolgreich aus der Datenbank entfernt!";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig 