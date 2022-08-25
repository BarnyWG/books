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

html_kopf('Verlags Suche',true,'js/onload_select.js');
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<h3><b>Verlagsdatensatz Suche</b></h3>
Nach welchem Verlag soll ich suchen ?<br />
Verlagsname(Ort,Strasse):<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT pb_name,pb_street,pb_postindex,pb_location,pb_id FROM publisher WHERE pb_name LIKE '%{$suche}%' OR pb_street LIKE'%{$suche}%' OR pb_location LIKE'%{$suche}%' ORDER BY pb_name";
$result=$verbindung->query($strsql);

#echo $strsql;

if($result->rowCount())
{
  echo '<table border="1">';
  echo '<tr><th>Verlag</th><th>Straße</th><th>PLZ</th><th>Ort</th>';
  if($mode == 'edit') echo '<th>Editieren</th>';
  if($mode == 'loesch') echo '<th>Löschen</th>';
  if($mode == 'holen') echo '<th>Übernehmen</th>';
  if($mode == 'display') echo '<th>Anzeigen</th>';    
  echo '</tr>';
  $rows=$result->fetchAll();
  foreach($rows as $ergebnis)  # solange bis alle Datensätze dargestellt sind ausgeben
  {
      if($mode == 'edit')   # erzeuge Editieren Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display2('dat_v_edit.php?c_pb_id=";
        echo $ergebnis["pb_id"];
        echo "')";
        echo '"><td>';        
        echo substr(stripslashes($ergebnis["pb_name"]),0,20)."...";
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["pb_street"]);
        echo '</td>';
        echo '<td>';
        echo $ergebnis["pb_postindex"];
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["pb_location"]);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_pb_id" type="button" value="Editieren" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'loesch')   # erzeuge Löschen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_v_loesch.php?c_pb_id=";
        echo $ergebnis["pb_id"];
        echo "')";
        echo '"><td>';
        echo substr(stripslashes($ergebnis["pb_name"]),0,20)."...";
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["pb_street"]);
        echo '</td>';
        echo '<td>';
        echo $ergebnis["pb_postindex"];
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["pb_location"]);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_pb_id" type="button" value="Löschen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'holen')   # erzeuge übertragen Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_v('";
        echo $ergebnis["pb_id"];
        echo "','" .stripslashes($ergebnis["pb_name"]);
        echo "','" .stripslashes($ergebnis["pb_location"])."')";           
        echo '"><td>';
        echo substr(stripslashes($ergebnis["pb_name"]),0,20)."...";
        echo '<td>';
        echo stripslashes($ergebnis["pb_street"]);
        echo '</td>';
        echo '<td>';
        echo $ergebnis["pb_postindex"];
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["pb_location"]);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_pb_id" type="button" value="Übernehmen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'display')   # erzeuge Anzeigen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_b_search.php?&mode=display&suche=%&verlag=";
        echo $ergebnis["pb_id"];
        echo "')";
        echo '"><td>';
        echo substr(stripslashes($ergebnis["pb_name"]),0,20)."...";
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["pb_street"]);
        echo '</td>';
        echo '<td>';
        echo $ergebnis["pb_postindex"];
        echo '</td>';
        echo '<td>';
        echo stripslashes($ergebnis["pb_location"]);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_pb_id" type="button" value="Anzeigen Bücher" />';
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
?>