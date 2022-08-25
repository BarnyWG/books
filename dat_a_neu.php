<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("inc/kopf_u_fuss.php");	
html_kopf("Autor Daten Neu",false,"js/onload_focus.js");
if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';
?>
<form action="dat_a_pr_sch.php" method="get" target="_self">
<pre>
<b>Autoren Vorname:</b>
<input id="focus" type="text" name="c_au_firstname" value="" size="50" maxlength="50" /><br />
<b>Autoren Nachname:</b>
<input type="text" name="c_au_lastname" value="" size="50" maxlength="50" /><br />
<b>Kurzbiografie.:</b>
<textarea name="c_au_biografie" cols="50" rows="5"></textarea><br />
<input type="submit" name="dummy" value="Anlegen" /><input type="reset" /><br/>
</pre>
<input type="hidden" name="mode" value="<?php echo $mode;?>" />
</form>
<?php
html_fuss();
}
?>