<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("inc/kopf_u_fuss.php");	
html_kopf("Serie Daten Neu",false,"js/onload_focus.js");
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';
?>
<form action="dat_s_pr_sch.php" method="get" target="_self">
<pre>
<b>Buchserie:</b>
<input id="focus" type="text" name="c_bs_name" value="" size="30" maxlength="60" /><br />
<input type="submit" name="dummy" value="Anlegen" /><input type="reset" /><br />
</pre>
<input type="hidden" name="mode" value="<?php echo $mode;?>" />
</form>
<?php
html_fuss();
}
?>
