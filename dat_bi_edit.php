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
if(isset($_REQUEST['c_bi_id']))
  $c_bi_id=$_REQUEST['c_bi_id'];
else
  $c_bi_id='';

# Daten inhalt Pr�fen

if($c_bi_id == '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bi_type FROM bind WHERE bi_id='{$c_bi_id}'");

if($result->rowCount()) # Daten gefunden Daten holen
{
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
  $c_bi_type=stripslashes($ergebnis->bi_type);
}

html_kopf("Bindung Editieren",false,"js/onload_focus.js");
?>
<form action="dat_bi_update.php" method="get" target="_self">
<pre>
<input type="hidden" name="c_bi_id" value="<?php echo $c_bi_id;?>" />
<b>Bindungsart:</b>
<input id="focus" type="text" name="c_bi_type" value="<?php echo $c_bi_type;?>" size="20" maxlength="20" /><br />
<input type="submit" name="dummy" value="Update" />  <input type="reset" /><br />
</pre>
</form>
<?php
html_fuss();
}
?>