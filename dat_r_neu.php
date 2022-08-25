<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("inc/kopf_u_fuss.php");	
html_kopf("Regal Daten Neu",false,"js/onload_focus.js");
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';
?>
<form action="dat_r_pr_sch.php" method="get">
<pre>
<b>Regalfach:</b>
<input id="focus" type="text" name="c_st_name" value="" size="20" maxlength="20" /><br />
<b>Standort :</b>
<input type="text" name="c_st_location" value="" size="20" maxlength="20" />
<b>Kapazität:</b>(z.B. Anzahl Fächer)
<input type="text" name="c_st_capa" value="" size="3" maxlength="3" />
<b>Regalabmessung (mm):</b>
<b>H&ouml;he:</b><input type="text" name="c_st_height" value="0" size="4" maxlength="4" /><b>  Breite:</b><input type="text" name="c_st_width" value="0" size="4" maxlength="4" /><b>  Tiefe:</b><input type="text" name="c_st_deep" value="0" size="4" maxlength="4" /><br />
<input type="submit" name="dummy" value="Anlegen" /><input type="reset" /><br />
</pre>
<input type="hidden" name="mode" value="<?php echo $mode;?>" />
</form>
<?php
html_fuss();
}
?>
