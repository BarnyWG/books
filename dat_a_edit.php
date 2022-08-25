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

# Daten inhalt Pr�fen

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

if($result->rowCount() >0 ) # Autor gefunden Daten holen
{
  $ergebnis=$result->fetch(PDO::FETCH_OBJ);
  $c_au_firstname=stripslashes($ergebnis->au_firstname);
  $c_au_lastname=stripslashes($ergebnis->au_lastname);
  $c_au_biografie=stripslashes($ergebnis->au_biografie);        
}

html_kopf("Autor Editieren",false,"js/onload_focus.js");
?>
<form action="dat_a_update.php" method="get" target="_self">
<pre>
<input type="hidden" name="c_au_id" value="<?php echo $c_au_id; ?>" />
<b>Autoren Vorname:</b>
<input id="focus" type="text" name="c_au_firstname" value="<?php echo $c_au_firstname; ?>" size="50" maxlength="50" /><br />
<b>Autoren Nachname:</b>
<input type="text" name="c_au_lastname" value="<?php echo $c_au_lastname; ?>" size="50" maxlength="50" /><br />
<b>Kurzbiografie:</b>
<textarea name="c_au_biografie" cols="50" rows="5"><?php echo $c_au_biografie; ?></textarea>
<input type="submit" name="dummy" value="Update" />  <input type="reset" /><br />
</pre>
</form>
<?php
html_fuss();
}
?>