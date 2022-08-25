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

if(isset($_REQUEST['suche']))
  $suche=$_REQUEST['suche'];
else
  $suche='';

if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

html_kopf('Genre Suche',true,'js/onload_select.js');
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<h3><b>Genre Datensatz Suche</b></h3>
Nach welcher Genre soll ich suchen ?<br />
Genre bezeichnung:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT ge_type,ge_id FROM genre WHERE ge_type LIKE '%{$suche}%' ORDER BY ge_type";
$result=$verbindung->query($strsql);

#echo $strsql;

if($result->rowCount())
{
  echo '<table border="1">';
  echo '<tr><th>Genre</th>';
  if($mode == 'edit') echo '<th>Editieren</th>';
  if($mode == 'loesch') echo '<th>Löschen</th>';
  if($mode == 'display');
  if($mode == 'holen') echo '<th>Übernehmen</th>';
  if($mode == 'inhalt') echo '<th>Bücher hierzu</th>';
  echo '</tr>';
  $rows=$result->fetchAll();
  foreach($rows as $ergebnis)   # solange bis alle Datensätze dargestellt sind ausgeben
  {
      if($mode == 'edit')   # erzeuge Editieren Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display2('dat_g_edit.php?c_ge_id=";
        echo $ergebnis["ge_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["ge_type"]);
        echo '</td><td>';        
        echo '<input name="c_ge_id" type="button" value="Editieren" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'loesch')   # erzeuge Löschen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_g_loesch.php?zurueck=edit&suche={$suche}&c_ge_id=";
        echo $ergebnis["ge_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["ge_type"]);
        echo '</td><td>';        
        echo '<input name="c_ge_id" type="button" value="Löschen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'display')   # erzeuge Anzeigen Zeile
      {
        echo '<tr>';
        echo '<td>';
        echo stripslashes($ergebnis["ge_type"]);
        echo '</td>';        
        echo '</tr>';
        echo "\n";
	  }	  
      if($mode == 'inhalt')   # erzeuge Anzeigen Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "window.open('dat_b_search.php?mode=display&suche=%&genre=";
        echo $ergebnis["ge_id"];
        echo "','_self')";
        echo '"><td>';
        echo stripslashes($ergebnis["ge_type"]);
        echo '</td><td>';        
        echo '<input name="c_ge_id" type="button" value="Anzeigen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }	  
      if($mode == 'holen')   # erzeuge Übertragen Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_g('";
        echo $ergebnis["ge_id"];
        echo "','" .stripslashes($ergebnis["ge_type"])."')";           
        echo '"><td>';        
        echo stripslashes($ergebnis["ge_type"]);
        echo '</td><td>';        
        echo '<input name="c_ge_id" type="button" value="Übernehmen" />';
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
}
?>