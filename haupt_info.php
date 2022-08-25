<?php
@session_start();
if($_SESSION["s_us_name"] =='')
{
   header("location:index.php");
}
require_once("inc/kopf_u_fuss.php");
html_kopf("Hauptmenue",false,"js/haupt_info.js");
?>
<div align="right"><a href="index.php" title="Neu anmelden">User: <?php echo $_SESSION['s_us_name'] ?>  LVL: <?php echo $_SESSION['s_us_level'] ?></a></div>
<div align="center"><img src="grafik/headline.jpg" width="640" height="100" border="0" alt="" /></div>
<iframe id="menu" src="menu_haupt.php" width="150" height="600" style="position:absolute;display:block;left:0px;top:120px;z-index:100;">
</iframe>
<iframe id="display" src="" width="700" height="500" style="position:absolute;display:block;left:150px;top:120px;z-index:100;">
</iframe>
<?php
html_fuss();
?>