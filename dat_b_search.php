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

if(isset($_REQUEST['autor']))
  $autor=$_REQUEST['autor'];
else
  $autor='';

if(isset($_REQUEST['serie']))
  $serie=$_REQUEST['serie'];
else
  $serie='';  

if(isset($_REQUEST['verlag']))
  $verlag=$_REQUEST['verlag'];
else
  $verlag='';  

if(isset($_REQUEST['regal']))
  $regal=$_REQUEST['regal'];
else
  $regal='';  

if(isset($_REQUEST['ort']))
  $ort=$_REQUEST['ort'];
else
  $ort='';

if(isset($_REQUEST['genre']))
  $genre=$_REQUEST['genre'];
else
  $genre='';  
  
if(isset($_REQUEST['isbn']))
  $isbn=$_REQUEST['isbn'];
else
  $isbn='';
        
html_kopf('Buch Suche',true,'js/onload_select.js');
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>"  method="get" target="_self">
<input type="hidden" name="mode" value="<?php echo $mode; ?>" /><input type="hidden" name="autor" value="<?php echo $autor; ?>" /><input type="hidden" name="serie" value="<?php echo $serie; ?>" /><input type="hidden" name="verlag" value="<?php echo $verlag; ?>" /><input type="hidden" name="regal" value="<?php echo $regal; ?>" />
<input type="hidden" name="ort" value="<?php echo $ort; ?>" /><input type="hidden" name="genre" value="<?php echo $genre; ?>" />
<h3><b>Buch Datensatz suche
<?php
  if($autor<>'') echo " nach Autor";
  if($serie<>'') echo " nach Serie";
  if($verlag<>'') echo " nach Verlag";
  if($regal<>'') echo " im Regal ";
  if($ort<>'') echo " am Ort ";
  if($genre<>'') echo " zum Genre ";
  if($isbn<>'') echo " zur Teil ISBN ";     
  if($mode=='kommentar') echo " nach Kommentar" 
?>  
</b></h3>
<?php 
if($mode=='kommentar')
{
?>
Nach welchem Kommentar soll ich suchen ?<br />
Buchkommentar:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<?php 
}
else
{
?>
Nach welchem Buchtitel soll ich suchen ?<br />
Buchtitel:<input id="focus" type="text" name="suche" value="<?php echo $suche; ?>" size="20" maxlength="40" />
<?php
}
?>
<input type="submit" name="dummy" value="Anfrage Senden" />
</form>
<?php

if($suche=='')
{
	html_fuss();
	exit();
}

anbindung_db($verbindung);
$strsql="SELECT bo_title,bo_isbn,bo_id FROM book WHERE bo_title LIKE '%{$suche}%' ORDER BY bo_title";
if($autor<>'')
  $strsql="SELECT bo_title,bo_id FROM book,ll_bo_au WHERE bo_title LIKE '%{$suche}%' AND ll_bo_au_au_id={$autor} AND ll_bo_au_bo_id=bo_id ORDER BY bo_title";
if($serie<>'')
  $strsql="SELECT bo_title,bo_id,bs_name FROM book,book_series WHERE bo_title LIKE '%{$suche}%' AND bo_bs_id={$serie} AND bo_bs_id=bs_id ORDER BY bo_title";
if($verlag<>'')
  $strsql="SELECT bo_title,bo_id,pb_name FROM book,publisher WHERE bo_title LIKE '%{$suche}%' AND bo_pb_id={$verlag} AND bo_pb_id=pb_id ORDER BY bo_title";
if($regal<>'')
  $strsql="SELECT bo_title,bo_id,st_name,st_location FROM book,storage WHERE bo_title LIKE '%{$suche}%' AND bo_st_id={$regal} AND bo_st_id=st_id ORDER BY bo_title";
if($ort<>'')
  $strsql="SELECT bo_title,bo_id,st_name,st_location FROM book,storage WHERE bo_title LIKE '%{$suche}%' AND bo_st_id=st_id AND st_location ='{$ort}' ORDER BY bo_title";
if($genre<>'')  
  $strsql="SELECT bo_title,bo_id,ge_type FROM book,genre WHERE bo_title LIKE '%{$suche}%' AND bo_ge_id=ge_id AND ge_id ='{$genre}' ORDER BY bo_title";
if($isbn<>'')
  $strsql="SELECT bo_title,bo_id,bo_isbn FROM book,storage WHERE bo_title LIKE '%{$suche}%' AND bo_isbn LIKE '%{$isbn}%' ORDER BY bo_title";
if($mode=='kommentar')
  $strsql="SELECT bo_title,bo_comment,bo_id FROM book WHERE bo_comment LIKE '%{$suche}%' ORDER BY bo_comment";
$result=$verbindung->query($strsql);
# echo $strsql;
$rows = $result->fetchAll(PDO::FETCH_ASSOC);

if($result->rowCount() > 0)
{
    echo '<table border="1">';
    echo '<tr><th>Buchtitel</th>';
    if($regal<>'' || $ort<>'') echo '<th>Regal</th><th>Ort</th>';
    if($serie<>'') echo '<th>Serie</th>';
    if($verlag<>'') echo '<th>Verlag</th>';
    if($genre<>'') echo '<th>Genre</th>';         
    if($mode == 'edit') echo '<th>Editieren</th>';
    if($mode == 'loesch') echo '<th>ISBN<th>Löschen</th>';
    if($mode == 'display') echo '<th>Anzeigen</th>'; 
    if($mode == 'kommentar') echo '<th>Kommentar</th><th>Anzeigen</th>';  
    echo '</tr>';
    
    foreach ($rows as $ergebnis)
    {
      if($mode == 'edit')   # erzeuge Editieren Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_b_edit.php?zurueck=edit&suche={$suche}&c_bo_id=";
        echo $ergebnis["bo_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["bo_title"]);
        echo '</td><td>';        
        echo '<input name="c_bo_id" type="button" value="Editieren" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'loesch')   # erzeuge Löschen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_b_loesch.php?zurueck=edit&suche={$suche}&c_bo_id=";
        echo $ergebnis["bo_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["bo_title"]);
        echo '</td><td>';
        echo $ergebnis["bo_isbn"];
        echo '</td><td>';
        echo '<input name="c_bo_id" type="button" value="Löschen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
      if($mode == 'display' || $mode == 'kommentar')   # erzeuge Anzeigen -Zeile
      {
        echo '<tr class="drill_in" onclick="';
        echo "parent.display('dat_b_display.php?c_bo_id=";
        echo $ergebnis["bo_id"];
        echo "')";
        echo '"><td>';
        echo stripslashes($ergebnis["bo_title"]);
        echo '</td>'; 
        if($mode == 'kommentar')
        {
	        echo '<td>';
    	    echo stripslashes($ergebnis["bo_comment"]);
        	echo '</td>';
        }
        if($regal<>'')
        {
	        echo '<td>';
    	    echo stripslashes($ergebnis["st_name"]);
        	echo '</td>'; 
	        echo '<td>';
    	    echo stripslashes($ergebnis["st_location"]);
        	echo '</td>'; 
        }
        if($ort<>'')
        {
	        echo '<td>';
    	    echo stripslashes($ergebnis["st_name"]);
        	echo '</td>'; 
	        echo '<td>';
    	    echo stripslashes($ergebnis["st_location"]);
        	echo '</td>'; 
        }    
        if($serie<>'')
        {
	        echo '<td>';
    	    echo stripslashes($ergebnis["bs_name"]);
        	echo '</td>';
        }
        if($verlag<>'')
        {
	        echo '<td>';
    	    echo stripslashes($ergebnis["pb_name"]);
        	echo '</td>';
        }
        if($genre<>'')
        {
	        echo '<td>';
    	    echo stripslashes($ergebnis["ge_type"]);
        	echo '</td>';
        }
        if($isbn<>'')
        {
	        echo '<td>';
    	    echo stripslashes($ergebnis["bo_isbn"]);
        	echo '</td>';
        }        
                
        echo '<td><input name="c_bo_id" type="button" value="Anzeigen" />';
        echo '</td>';
        echo '</tr>';
        echo "\n";
	  }
  }

  echo '</table>';
  if($autor<>'') echo "Ergebnis für Autor";
  if($serie<>'') echo "Ergebnis für Serie";
  if($verlag<>'') echo "Ergebnis für Verlag";
  if($regal<>'') echo "Inhalt im Regal ".stripslashes($ergebnis["st_name"])." ".stripslashes($ergebnis["st_location"]);
  if($ort<>'') echo "Inhalt am Ort ".stripslashes($ergebnis["st_name"])." ".stripslashes($ergebnis["st_location"]);  
  echo "<br />Anzahl gefundener Datensätze : ".$result->rowCount();
   //mysql_free_result($ergebnis);
}
else
  echo '<br />Die Abfrage brachte keine Ergebnisse!'; 
anbindung_schliessen($verbindung);  
html_fuss();
?>