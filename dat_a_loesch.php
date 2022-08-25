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

# Daten holen

$alles_io=true;

if(isset($_REQUEST['c_au_id']))
  $c_au_id=$_REQUEST['c_au_id'];
else
  $c_au_id='';

# Daten inhalt Prüfen testen auf injection

if($c_au_id== '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  echo 'Die Daten entsprechen nicht den Anforderungen bitte prüfen sie ihre Eingaben!&nbsp;&nbsp;';
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  exit();
}
  
# testen ob Autor noch verwender wird, wenn ja Bücher zum Editieren anlisten

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bo_title,bo_id FROM book,ll_bo_au WHERE ll_bo_au_au_id={$c_au_id} AND ll_bo_au_bo_id=bo_id ORDER BY bo_title");

if($result->rowCount() > 0) # Bücher mit Autor vorhanden
{
  $rows=$result->fetchAll();

  html_kopf("Autor noch verwendet");
  echo "Der Autor wird noch bei folgenden Büchern verwendet";
    echo '<table border="1">';
    echo '<tr><th>Buchtitel</th><th>Editieren</th>';
    echo '</tr>';
  foreach($rows as $ergebnis)   # solange bis alle Datensätze dargestellt sind ausgeben
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

# Autor nicht verwendet, löschen und erfolgsmeldung geben

$sqlstr="DELETE FROM autor WHERE au_id='{$c_au_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung();
if ($io)
{
  html_kopf();
  echo "Der Autor wurde erfolgreich aus der Datenbank entfernt!";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig

function fehlermeldung()
{
html_kopf();
?>
<h1 class="fehler"> Während der Verarbeitung ist ein Fehler aufgetreten!</h1>
Bitte versuchen sie die Verarbeitung durch Aktualisieren des Frames erneut zu Starten!<br />
Sollte das nicht Funktionieren versuchen sie die Eingabe der Daten erneut!
<?php
  html_fuss();
  exit();
}
?> 