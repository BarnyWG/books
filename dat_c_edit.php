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
if(isset($_REQUEST['c_co_id']))
  $c_co_id=$_REQUEST['c_co_id'];
else
  $c_co_id='';

# Daten inhalt Pr�fen

if($c_co_id == '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

anbindung_db($verbindung);

$result=$verbindung->query("SELECT co_type FROM cover where co_id='{$c_co_id}'");

if($result->rowCount()) # Cover gefunden Daten holen
{
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
  $c_co_type=stripslashes($ergebnis->co_type);
}

html_kopf("Cover Editieren",false,"js/onload_focus.js");
?>
<form action="dat_c_update.php" method="get" target="_self">
<pre>
<input type="hidden" name="c_co_id" value="<?php echo $c_co_id;?>" />
<b>Coverart:</b>
<input id="focus" type="text" name="c_co_type" value="<?php echo $c_co_type;?>" size="20" maxlength="20" /><br />
<input type="submit" name="dummy" value="Update" />  <input type="reset" /><br />
</pre>
</form>
<?php
html_fuss();
}
?>