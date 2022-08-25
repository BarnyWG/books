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
if(isset($_REQUEST['c_pb_id']))
  $c_pb_id=$_REQUEST['c_pb_id'];
else
  $c_pb_id='';

# Daten inhalt Pr�fen

if($c_pb_id == '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

anbindung_db($verbindung);

$result=$verbindung->query("SELECT pb_name,pb_street,pb_postindex,pb_location FROM publisher where pb_id='{$c_pb_id}'");

if($result->rowCount()) # Verlag gefunden Daten holen
{
  $ergebnis=$result->fetch(PDO::FETCH_OBJ);	
  $c_pb_name=stripslashes($ergebnis->pb_name);
  $c_pb_street=stripslashes($ergebnis->pb_street);
  $c_pb_postindex=$ergebnis->pb_postindex;
  $c_pb_location=stripslashes($ergebnis->pb_location);
}

html_kopf("Verlag Editieren",false,"js/onload_focus.js");
?>
<form action="dat_v_update.php" method="get" target="_self">
<pre>
<input type="hidden" name="c_pb_id" value="<?php echo $c_pb_id; ?>" />
<b>Verlags Name:</b>
<input id="focus" type="text" name="c_pb_name" value="<?php echo stripslashes($c_pb_name); ?>" size="50" maxlength="200" /><br />
<b>Straße + Nr.:</b>
<input type="text" name="c_pb_street" value="<?php echo $c_pb_street; ?>" size="40" maxlength="40" /><br />
<b>PLZ:</b><input type="text" name="c_pb_postindex" value="<?php echo $c_pb_postindex; ?>" size="5" maxlength="5" /><b>  Ort:</b><input type="text" name="c_pb_location" value="<?php echo $c_pb_location; ?>" size="40" maxlength="40" /><br />
<input type="submit" name="dummy" value="Update" />  <input type="reset" /><br />
</pre>
</form>

<?php
html_fuss();
}
?>