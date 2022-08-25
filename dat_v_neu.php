<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("inc/kopf_u_fuss.php");	
html_kopf("Verlags Daten Neu",false,"js/onload_focus.js");
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';
?>
<form action="dat_v_pr_sch.php" method="get" target="_self">
<pre>
<b>Verlags Name:</b>
<input id="focus" type="text" name="c_pb_name" value="" size="50" maxlength="200" /><br />
<b>Straße + Nr.:</b>
<input type="text" name="c_pb_street" value="" size="40" maxlength="40" /><br />
<b>PLZ:</b><input type="text" name="c_pb_postindex" value="00000" size="5" maxlength="5" /><b>  Ort:</b><input type="text" name="c_pb_location" value="" size="40" maxlength="40"/><br />
<input type="submit" name="dummy" value="Anlegen" /><input type="reset" /><br />
</pre>
<input type="hidden" name="mode" value="<?php echo $mode;?>" />
</form>
<?php
html_fuss();
}
?>
