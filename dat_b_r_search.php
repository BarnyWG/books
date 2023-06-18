<?php
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");

# Daten holen

if(isset($_REQUEST['suche']))
  $suche=$_REQUEST['suche'];
else
  $suche='';

if(isset($_REQUEST['suche2']))
  $suche2=$_REQUEST['suche2'];
else
  $suche2='';  

if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

if(isset($_REQUEST['regal']))
  $regal=$_REQUEST['regal'];
else
  $regal='';  

if(isset($_REQUEST['ort']))
  $ort=$_REQUEST['ort'];
else
  $ort='';
        
html_kopf('Buch Suche',true,'js/onload_select.js');
?>
<form name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" /><input type="hidden" name="regal" value="<?php echo $regal; ?>" />
<h3><b>Buch Datensatz suche mit Regal zum Verlagern
</b></h3>
Nach welchem Buchtitel soll ich suchen ?<br />
Buchtitel:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
Oder welches Regal/Standort soll ich suchen ?<br />
Regal/Ort:<input type="text" name="suche2" value="<?php echo $suche2; ?>" size="20" maxlength="40" />

<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='' && $suche2=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT bo_title,bo_id,st_location,st_id,st_name FROM book,storage WHERE bo_title LIKE '%{$suche}%' AND bo_st_id=st_id ORDER BY bo_title";
if($suche<>'' && $suche2=='') // Buch gesucht aber kein Regal
  $strsql="SELECT bo_title,bo_id,st_name,st_location,st_id FROM book,storage WHERE bo_title LIKE '%{$suche}%' AND bo_st_id=st_id ORDER BY st_name";
if($suche<>'' && $suche2<>'') // Buch gesucht und Regal
  $strsql="SELECT bo_title,bo_id,st_name,st_location,st_id FROM book,storage WHERE bo_title LIKE '%{$suche}%' AND (st_name LIKE '%{$suche2}%' OR st_location LIKE '%{$suche2}%') AND bo_st_id=st_id ORDER BY st_name";
if($suche=='' && $suche2<>'') // kein Buch gesucht aber Regal
  $strsql="SELECT bo_title,bo_id,st_name,st_location,st_id FROM book,storage WHERE (st_name LIKE '%{$suche2}%' OR st_location LIKE '%{$suche2}%') AND bo_st_id=st_id ORDER BY st_name";

$result=$verbindung->query($strsql);
#echo $strsql;

if($result->rowCount())
{
	echo '<table border="1">';
    echo '<tr><th>Buchtitel</th><th>Regal</th><th>Standort</th><th>Verlagern ==></th>';
    echo '</tr>';
    $rows = $result->fetchAll();
	foreach ($rows as $ergebnis )   # solange bis alle Datensätze dargestellt sind ausgeben
  	{
       	echo '<tr class="drill_in" onclick="';
       	echo "parent.backtask('dat_b_r_verlagern.php?c_bo_id=";
       	echo $ergebnis["bo_id"];
       	echo "&regal={$regal}"; // Reihenfolge geändert da das '#' ein Problem bereitet
		echo "&c_bo_title=";
       	echo htmlentities(stripslashes($ergebnis["bo_title"]));
       	echo "&c_st_name=";
       	echo htmlentities(stripslashes($ergebnis["st_name"]));
		echo "')";
       	echo '"><td>';
       	echo stripslashes($ergebnis["bo_title"]);
        echo '</td>';	 
   	    echo '<td>';
    	echo stripslashes($ergebnis["st_name"]);
   		echo '</td>'; 
        echo '<td>';
		echo stripslashes($ergebnis["st_location"]);
       	echo '</td>'; 
	    echo '<td><input name="c_bo_id" type="button" value="Verlagern ==>" />';
    	echo '</td>';
        echo '</tr>';
	    echo "\n";
	}
	echo '</table>';
	echo "<br />Anzahl gefundener Datensätze : ".$result->rowCount();
	
}
else
  echo '<br />Die Abfrage brachte keine Ergebnisse!'; 
anbindung_schliessen($verbindung);  
html_fuss();
?>