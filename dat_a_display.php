<?php
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");

# Daten holen

$alles_io=true;
if(isset($_REQUEST['c_au_id']))
  $c_au_id=$_REQUEST['c_au_id'];
else
  $c_au_id='';

# Daten inhalt Prüfen

if($c_au_id == '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  echo 'Die Daten sind entsprechen nicht den Anforderungen bitt Prüfen sie ihre Eingaben!&nbsp;&nbsp;';
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  exit();
}

anbindung_db($verbindung);

$result=$verbindung->query("SELECT au_firstname,au_lastname,au_biografie FROM autor where au_id='{$c_au_id}'");

if($result->rowCount()) # Autor gefunden Daten holen
{
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
 	$c_au_firstname=stripslashes($ergebnis->au_firstname);
  $c_au_lastname=stripslashes($ergebnis->au_lastname);
  $c_au_biografie=stripslashes($ergebnis->au_biografie);        
}

html_kopf("Autor anzeigen");
?>
<pre>
<span class="button" onclick="parent.display('dat_b_search.php?autor=<?php echo $c_au_id; ?>&suche=%&mode=display');">Alle Bücher zum Autor</span>
<b>Autoren Vorname:</b>
<?php echo $c_au_firstname; ?><br />
<b>Autoren Nachname:</b>
<?php echo $c_au_lastname; ?><br />
<b>Kurzbiografie:</b>
<?php echo $c_au_biografie; ?>
</pre>
<?php
html_fuss();
?>