<?php
@session_start();
require_once("inc/kopf_u_fuss.php");
html_kopf("Benutzermenue",true,"js/menu_haupt.js");
?>
<div align="center"><b>Buch Daten</b></div>
<img id="buch" name="0" onclick="wechsel (this);parent.display('dat_b_search.php?mode=display')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/buch_suche_up.jpg" border="0" alt="" /><br /><br />
<img id="autor" name="1" onclick="wechsel (this);parent.display('dat_a_search.php?mode=display')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/autors_up.jpg" border="0" alt="" /><br /><br />
<img id="komm" name="2" onclick="wechsel (this);parent.display('dat_b_search.php?mode=kommentar')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/koms_up.jpg" border="0" alt="" /><br /><br />
<img id="serie" name="3" onclick="wechsel(this);parent.display('dat_s_search.php?mode=display')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/series_up.jpg" border="0" alt="" /><br /><br />
<img id="verlag" name="4" onclick="wechsel(this);parent.display('dat_v_search.php?mode=display')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/verlag_m_up.jpg" border="0" alt="" /><br /><br />
<img id="regal" name="5" onclick="wechsel(this);parent.display('dat_r_search.php?mode=inhalt')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/regal_m_up.jpg" border="0" alt="" /><br /><br />
<img id="genre" name="7" onclick="wechsel(this);parent.display('dat_g_search.php?mode=inhalt')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/genre_m_up.jpg" border="0" alt="" /><br /><br />
<div align="center"><b>Daten Verwaltung</b></div>
<?php if($_SESSION["s_us_level"] >"0")
{ ?>
<img id="verwaltung" name="6" onclick="wechsel (this);window.open('menue.php','')" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/verwalt_m_up.jpg" border="0" alt="" />
<?php } else { ?>
<img id="verwaltung" name="6" onclick="wechsel (this)" onmouseover="ueber (this)" onmouseout="raus (this)" src="grafik/verwalt_m_up.jpg" border="0" alt="" />
<?php }
html_fuss();
?>