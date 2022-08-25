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
if(isset($_REQUEST['c_bs_id']))
  $c_bs_id=$_REQUEST['c_bs_id'];
else
  $c_bs_id='';

# Daten inhalt Prüfen

if($c_bs_id == '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bs_name FROM book_series where bs_id='{$c_bs_id}'");

if($result->rowCount()) # Autor gefunden Daten holen
{
  $ergebnis=$result->fetch(PDO::FETCH_OBJ);	
  $c_bs_name=stripslashes($ergebnis->bs_name);
}

html_kopf("Serie Editieren",false,"js/onload_focus.js");
?>
<form action="dat_s_update.php" method="get" target="_self">
<pre>
<input type="hidden" name="c_bs_id" value="<?php echo $c_bs_id;?>" />
<b>Buchserie:</b>
<input id="focus" type="text" name="c_bs_name" value="<?php echo $c_bs_name;?>" size="30" maxlength="60" /><br />
<input type="submit" name="dummy" value="Update" />  <input type="reset" /><br />
</pre>
</form>
<?php
html_fuss();
}
?>