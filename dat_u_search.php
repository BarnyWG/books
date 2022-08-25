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

html_kopf('Benutzer suche',true,'js/onload_select.js');
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
<h3><b>Benutzer Datensatz suche</b></h3>
Nach welchem Benutzernamen soll ich suchen ?<br />
Benutzername:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT us_name,us_id FROM user WHERE us_name LIKE '%{$suche}%' ORDER BY us_name";
$result=$verbindung->query($strsql);

#echo $strsql;

if($result->rowCount())
{
  echo '<table border="1">';
  echo '<tr><th>Benutzername</th>';
  if($mode == 'edit') echo '<th>Editieren</th>';
  if($mode == 'loesch') echo '<th>Löschen</th>';
  echo '</tr>';
  $rows=$result->fetchAll();
  foreach($rows as $ergebnis)   # solange bis alle Datensätze dargestellt sind ausgeben
  {
      if($mode == 'edit')   # erzeuge Editieren Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_u_edit.php?zurueck=edit&suche={$suche}&c_us_id=";
        echo $ergebnis["us_id"];
        echo "')";
        echo '"><td>';
        echo $ergebnis["us_name"];
        echo '</td><td>';        
        echo '<input name="c_us_id" type="button" value="Editieren" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'loesch')   # erzeuge Löschen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_u_loesch.php?zurueck=edit&suche={$suche}&c_us_id=";
        echo $ergebnis["us_id"];
        echo "')";
        echo '"><td>';
        echo $ergebnis["us_name"];
        echo '</td><td>';        
        echo '<input name="c_us_id" type="button" value="Löschen" />';
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