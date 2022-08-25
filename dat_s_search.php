<?php
require("anbindung_db.php");
require("inc/kopf_u_fuss.php");


# Daten holen

if(isset($_REQUEST['suche']))
  $suche=$_REQUEST['suche'];
else
  $suche='';

if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

html_kopf('Serie Suche',true,'js/onload_select.js');
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<h3><b>Serie Datensatz Suche</b></h3>
Nach welcher Serie soll ich suchen ?<br />
Serienname:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT bs_name,bs_id FROM book_series where bs_name LIKE '%{$suche}%' ORDER BY bs_name";
$result=$verbindung->query($strsql);

#echo $strsql;

if($result->rowCount())
{
  echo '<table border="1">';
  echo '<tr><th>Serie</th>';
  if($mode == 'edit') echo '<th>Editieren</th>';
  if($mode == 'loesch') echo '<th>L&ouml;schen</th>';
  if($mode == 'holen') echo '<th>&Uuml;bernehmen</th>';
  if($mode == 'display') echo '<th>Anzeigen</th>';
  echo '</tr>';
  $rows=$result->fetchAll();
  foreach($rows as $ergebnis)   # solange bis alle Datensätze dargestellt sind ausgeben
  {
      if($mode == 'edit')   # erzeuge Editieren Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display2('dat_s_edit.php?c_bs_id=";
        echo $ergebnis["bs_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["bs_name"]);
        echo '</td><td>';        
        echo '<input name="c_bs_id" type="button" value="Editieren" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'loesch')   # erzeuge Löschen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_s_loesch.php?zurueck=edit&suche={$suche}&c_bs_id=";
        echo $ergebnis["bs_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["bs_name"]);
        echo '</td><td>';        
        echo '<input name="c_bs_id" type="button" value="L&ouml;schen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'holen')   # erzeuge übertragen Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_s('";
        echo $ergebnis["bs_id"];
        echo "','" .stripslashes($ergebnis["bs_name"])."')";
        echo '"><td>';
        echo stripslashes($ergebnis["bs_name"]);
        echo '</td><td>';        
        echo '<input name="c_bs_id" type="button" value="Übernehmen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'display')   # erzeuge Serie anlisten Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_b_search.php?mode=display&suche=%&serie=";
        echo $ergebnis["bs_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["bs_name"]);
        echo '</td><td>';        
        echo '<input name="c_bs_id" type="button" value="Anzeigen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
  }
  echo '</table>';
}
else
  echo '<br />Die Abfrage brachte keine Ergebnisse!'; 
anbindung_schliessen($verbindung);  
html_fuss();
exit();
?>