<?php
/*
 * Program (C) by Bernd W. Goßmann
 * eMail bwg@wolfsburg.de
 */
@session_start();
if(!isset($_SESSION['s_us_name']))
{
  header("location:index.php");
  exit();
}
require_once('inc/kopf_u_fuss.php');
html_kopf("Menue",true,"js/menue.js","css/hor_down.css"); 
?>
<div align="left"><a href="haupt_info.php">zurück zum Hauptmenue</a>&nbsp;&nbsp;Datenbankverwaltung User: <?php echo $_SESSION['s_us_name'] ?>  LVL: <?php echo $_SESSION['s_us_level'] ?></div>
<form action="">
<input type="hidden" value="10" id="anzahl_mp" />	
</form>
<table>
<tr>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m1')">Buch</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m2')">Verlag</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m3')">Autor</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m4')">Serie</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m5')">Genre</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m6')">Bindung</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m7')">Cover</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m8')">Regal</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m9')">Benutzer</th>
<th class="menu_top" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);einblenden('m10')">SQL-Query</th>
</tr>
<tr style="vertical-align: top;">
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m1">
<tr><td class="menulist" onclick="display('dat_b_neu.php');alle_aus();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_b_neu_vorlage.php');alle_aus();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu aus Vorlage</td></tr>
<tr><td class="menulist" onclick="display('dat_b_search.php?mode=edit');alle_aus();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_b_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_b_search.php?mode=display');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
<tr><td class="menulist" onclick="display('dat_b_vorlage.php');alle_aus();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Vorlage erstellen</td></tr>
<tr><td class="menulist" onclick="display('dat_r_search.php?mode=verlagern');alle_aus();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Buch Verlagern</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m2">
<tr><td class="menulist" onclick="display('dat_v_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_v_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_v_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_v_search.php?mode=display&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m3">
<tr><td class="menulist" onclick="display('dat_a_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_a_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_a_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_a_search.php?mode=display&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m4">
<tr><td class="menulist" onclick="display('dat_s_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_s_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_s_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_s_search.php?mode=display&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m5">
<tr><td class="menulist" onclick="display('dat_g_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_g_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_g_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_g_search.php?mode=display&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m6">
<tr><td class="menulist" onclick="display('dat_bi_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_bi_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_bi_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_bi_search.php?mode=display&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m7">
<tr><td class="menulist" onclick="display('dat_c_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_c_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_c_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_c_search.php?mode=display&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m8">
<tr><td class="menulist" onclick="display('dat_r_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_r_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_r_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
<tr><td class="menulist" onclick="display('dat_r_search.php?mode=display&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Anzeigen</td></tr>
<tr><td class="menulist" onclick="display('dat_r_search.php?mode=inhalt&suche=%');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Inhalt</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m9">
<tr><td class="menulist" onclick="display('dat_u_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Neu</td></tr>
<tr><td class="menulist" onclick="display('dat_u_search.php?mode=edit');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Editieren</td></tr>
<tr><td class="menulist" onclick="display('dat_u_search.php?mode=loesch');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">L&ouml;schen</td></tr>
</table>
</td>
<td>
<table class="menulist" style="z-index:100;position:relative;top: -1000px;" id="m10">
<tr><td class="menulist" onclick="display('dat_sql_neu.php');alle_aus();clear_display2();" onmouseout="nicht_highlight(this);" onmouseover="highlight(this);">Abfrage</td></tr>
</table>
</td>
</tr>
</table>
<iframe id="display1" name="links" src="" width="480" height="100%" style="position:absolute;left:0px;top:50px;z-index:1;">
</iframe>
<iframe id="display2" name="rechts" src="" width="100%" height="100%" scrolling="yes" style="position:absolute;left:500px;top:50px;z-index:1;">
</iframe>
<iframe id="backtask" name="backtask" src="" width="0%" height="0%" style="position:absolute;left:0px;top:550px;z-index:-1;">
</iframe>
<?php
html_fuss();
?>