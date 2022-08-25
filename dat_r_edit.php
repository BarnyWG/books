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
if(isset($_REQUEST['c_st_id']))
  $c_st_id=$_REQUEST['c_st_id'];
else
  $c_st_id='';

# Daten inhalt Prüfen

if($c_st_id == '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

anbindung_db($verbindung);

$result=$verbindung->query("SELECT st_name,st_height,st_width,st_deep,st_location,st_capa FROM storage WHERE st_id='{$c_st_id}'");

if($result->rowCount()) # Regal gefunden Daten holen
{
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
  $c_st_name	=stripslashes($ergebnis->st_name);
  $c_st_height	=$ergebnis->st_height;
  $c_st_width	=$ergebnis->st_width;
  $c_st_deep	=$ergebnis->st_deep;
  $c_st_location=stripslashes($ergebnis->st_location); 
  $c_st_capa	=$ergebnis->st_capa;       
}

html_kopf("Regal Editieren",false,"js/onload_focus.js");
?>

<form action="dat_r_update.php" method="get">
<pre>
<input type="hidden" name="c_st_id" value="<?php echo $c_st_id;?>" />
<b>Regalfach:</b>
<input id="focus" type="text" name="c_st_name" value="<?php echo $c_st_name;?>" size="20" maxlength="20" /><br />
<b>Standort :</b>
<input type="text" name="c_st_location" value="<?php echo $c_st_location;?>" size="20" maxlength="20" />
<b>Kapazit&auml;t:</b>(z.B. Anzahl F&auml;cher)
<input type="text" name="c_st_capa" value="<?php echo $c_st_capa;?>" size="3" maxlength="3" />
<b>Regalabmessung (mm):</b>
<b>Höhe:</b><input type="text" name="c_st_height" value="<?php echo $c_st_height;?>" size="4" maxlength="4" /><b>  Breite:</b><input type="text" name="c_st_width" value="<?php echo $c_st_width;?>" size="4" maxlength="4" /><b>  Tiefe:</b><input type="text" name="c_st_deep" value="<?php echo $c_st_deep;?>" size="4" maxlength="4" /><br />
<input type="submit" name="dummy" value="Update" /><input type="reset" />
</pre>
</form>
<?php
html_fuss();
}
?>