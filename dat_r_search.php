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

html_kopf('Regal Suche',true,'js/onload_select.js');
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<h3><b>Regal Datensatz Suche <?php if($mode=="verlagern") echo "Zielregal w&auml;hlen";?></b></h3>
Nach welchem Regal oder an welchem Ort soll ich suchen ?<br />
Regalname oder Standort:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT st_name,st_location,st_id,st_deep,st_height,st_width,st_capa FROM storage where st_name LIKE '%{$suche}%' OR st_location LIKE '%{$suche}%' ORDER BY st_name";
$result=$verbindung->query($strsql);

#echo $strsql;

if($result->rowCount())
{
  echo '<table border="1">';
  echo '<tr><th>Regal</th><th>Ort</th>';
  if($mode == 'edit') echo '<th>Höhe</th><th>Breite</th><th>Tiefe</th><th>Kapa</th><th>Editieren</th>';
  if($mode == 'loesch') echo '<th>Löschen</th>';
  if($mode == 'holen') echo '<th>Übernehmen</th>';
  if($mode == 'holen_dc') echo '<th>Übernehmen</th>';
  if($mode == 'display') echo '<th>Höhe</th><th>Breite</th><th>Tiefe</th><th>Kapa</th>';          
  if($mode == 'inhalt') echo '<th>Inhalt Regal</th><th>Inhalt Ort</th>';    
  if($mode == 'verlagern') echo '<th>Buch nach hier Verlagern</th>';      
  echo '</tr>';
  $rows=$result->fetchAll();
  foreach($rows as $ergebnis)   # solange bis alle Datensätze dargestellt sind ausgeben
  {
      if($mode == 'edit')   # erzeuge Editieren Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display2('dat_r_edit.php?c_st_id=";
        echo $ergebnis["st_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["st_name"]);
        echo '</td><td>';        
        echo stripslashes($ergebnis["st_location"]);
        echo '</td><td align="right">';
        echo $ergebnis["st_height"];
        echo '</td><td align="right">';
        echo $ergebnis["st_width"];
        echo '</td><td align="right">';
        echo $ergebnis["st_deep"];
        echo '</td><td align="right">';
        echo $ergebnis["st_capa"];
        echo '</td><td>';                
        echo '<input name="c_st_id" type="button" value="Editieren" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'loesch')   # erzeuge Löschen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_r_loesch.php?zurueck=edit&suche={$suche}&c_st_id=";
        echo $ergebnis["st_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["st_name"]);
        echo '</td><td>';
        echo stripslashes($ergebnis["st_location"]);
        echo '</td><td>';   
        echo '<input name="c_st_id" type="button" value="Löschen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'display')   # erzeuge Anzeigen Zeile
      {
        echo '<tr>';
        echo '<td>';
        echo stripslashes($ergebnis["st_name"]);
        echo '</td><td>';        
        echo stripslashes($ergebnis["st_location"]);
        echo '</td><td align="right">';
        echo $ergebnis["st_height"];
        echo '</td><td align="right">';
        echo $ergebnis["st_width"];
        echo '</td><td align="right">';
        echo $ergebnis["st_deep"];
        echo '</td><td align="right">';
        echo $ergebnis["st_capa"];
        echo '</td>';                
        echo '</tr>';
        echo "\n";
	  }	  
      if($mode == 'holen')   # erzeuge übertragen Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_r('";
        echo $ergebnis["st_id"];
        echo "','" .stripslashes($ergebnis["st_name"]);
        echo "','" .stripslashes($ergebnis["st_location"])."')";           
        echo '"><td>';
        echo stripslashes($ergebnis["st_name"]);
        echo '</td><td>';
        echo stripslashes($ergebnis["st_location"]);
        echo '</td><td>';   
        echo '<input name="c_st_id" type="button" value="Übernehmen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
	  if($mode == 'holen_dc')   # erzeuge übertragen Zeile DataCarrier
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_r_dc('";
        echo $ergebnis["st_id"];
        echo "','" .stripslashes($ergebnis["st_name"]);
        echo "','" .stripslashes($ergebnis["st_location"])."')";           
        echo '"><td>';
        echo stripslashes($ergebnis["st_name"]);
        echo '</td><td>';
        echo stripslashes($ergebnis["st_location"]);
        echo '</td><td>';   
        echo '<input name="c_st_id" type="button" value="Übernehmen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }	  
      if($mode == 'inhalt')   # erzeuge Inhalt -Zeile
      {
        echo '<tr><td>';
        echo stripslashes($ergebnis["st_name"]);
        echo '</td><td>';
        echo stripslashes($ergebnis["st_location"]);
        echo '</td>'; 
        echo "\n";  
        echo '<td><input name="c_st_id" type="button" value="Inhalt Regal" onclick="';
        echo "window.open('dat_b_search.php?suche=%&mode=display&regal=";
        echo $ergebnis["st_id"];
        echo "','_self')";
        echo '" /></td>';
        echo "\n";
        echo '<td><input name="c_st_id" type="button" value="Inhalt Ort" onclick="';
        echo "window.open('dat_b_search.php?suche=%&mode=display&ort=";
        echo $ergebnis["st_location"];
        echo "','_self')";
        echo '" /></td>';       
        echo '</tr>';
        echo "\n";
	  }	 
	  if($mode == 'verlagern')   # erzeuge verlagern Zeile Auswahl des Regales in das eingelagert werden soll
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display2('dat_b_search.php?mode=display&suche=%&regal=";
        echo $ergebnis["st_id"];
        echo "');parent.display('dat_b_r_search.php?regal=";
        echo $ergebnis["st_id"];
		echo "')"; 
        echo '"><td>';
        echo stripslashes($ergebnis["st_name"]);
        echo '</td><td>';
        echo stripslashes($ergebnis["st_location"]);
        echo '</td><td>';   
        echo '<input name="c_st_id" type="button" value="Als Ziel wählen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }	  	   
  }
  
  echo '</table>';
}
anbindung_schliessen($verbindung);  
html_fuss();
?>