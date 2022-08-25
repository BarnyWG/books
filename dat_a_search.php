<?php
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");

# Daten holen

if(isset($_REQUEST['suche']))
  $suche=$_REQUEST['suche'];
else
  $suche='';

if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

html_kopf('Autoren Suche',true,'js/onload_select.js');
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<h3><b>Autordatensatz Suche</b></h3>
Nach welchem Autoren soll ich suchen ?<br />
Autorname:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT au_firstname,au_lastname,au_biografie,au_id FROM autor where au_firstname LIKE '%{$suche}%' OR au_lastname LIKE'%{$suche}%' ORDER BY au_lastname, au_firstname";
$result=$verbindung->query($strsql);

#echo $strsql;

if($result->rowCount()>0)
{
	$rows=$result->fetchAll();
  echo '<table border="1">';
  echo '<tr><th>Name</th><th>Vorname</th><th>Biografie</th>';
  if($mode == 'edit') echo '<th>Editieren</th>';
  if($mode == 'loesch') echo '<th>Löschen</th>';
  if($mode == 'holen') echo '<th>Übernehmen</th>';
  if($mode == 'display') echo '<th>Anzeigen</th>';    
  echo '</tr>';
  foreach($rows as $ergebnis)   # solange bis alle Datensätze dargestellt sind ausgeben
  {
      if($mode == 'edit')   # erzeuge Editieren Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display2('dat_a_edit.php?c_au_id=";
        echo $ergebnis["au_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["au_lastname"]);
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["au_firstname"]);
        echo '</td>';
        echo '<td>';
        echo substr(stripslashes($ergebnis["au_biografie"]),0,20)."...";
        echo '</td>';
        echo '<td>';
        echo '<input name="c_au_id" type="button" value="Editieren" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'loesch')   # erzeuge L�schen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_a_loesch.php?zurueck=edit&suche={$suche}&c_au_id=";
        echo $ergebnis["au_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["au_lastname"]);
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["au_firstname"]);
        echo '</td>';
        echo '<td>';
        echo substr(stripslashes($ergebnis["au_biografie"]),0,20)."...";
        echo '</td>';
        echo '<td>';
        echo '<input name="c_au_id" type="button" value="Löschen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'holen')   # erzeuge �bertragen Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_a('";
        echo $ergebnis["au_id"];
        echo "','" .stripslashes($ergebnis["au_lastname"]);
        echo "','" .stripslashes($ergebnis["au_firstname"])."')";        
        echo '"><td>';
        echo stripslashes($ergebnis["au_lastname"]);
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["au_firstname"]);
        echo '</td>';
        echo '<td>';
        echo substr(stripslashes($ergebnis["au_biografie"]),0,20)."...";
        echo '</td>';
        echo '<td>';
        echo '<input name="c_au_id" type="button" value="Übernehmen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'display')   # erzeuge Anzeigen Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_a_display.php?c_au_id=";
        echo $ergebnis["au_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["au_lastname"]);
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["au_firstname"]);
        echo '</td>';
        echo '<td>';
        echo substr(stripslashes($ergebnis["au_biografie"]),0,20)."...";
        echo '</td>';
        echo '<td>';
        echo '<input name="c_au_id" type="button" value="Anzeigen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }

  }

  echo '</table>';
  echo "<br />Anzahl gefundener Datensätze : ".$result->rowCount();
}
else
  echo '<br />Die Abfrage brachte keine Ergebnisse!'; 
anbindung_schliessen($verbindung);  
html_fuss();
?>



