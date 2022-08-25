<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("inc/kopf_u_fuss.php");	
html5_kopf("Buch Neu nach Vorlage",true,"js/dat_b_neu_vorlage.js","","js/dat_b_neu.js");
?>
<form id="form1" name="form1" action="dat_b_pr_sch.php" method="get" target="_self">
<input type="button" onclick="formular_senden();" name="dummy" value="Anlegen" /> <input type="reset" /><br /><br />
<b>Buchtitel:</b><br />
<input type="text" id="c_bo_title" name="c_bo_title" value="" size="50" maxlength="100" /><br /><br />
<b>Gelesen : </b><input type="checkbox" id="c_bo_has_read" name="c_bo_has_read" value="v" /><br /><br />
<b>Auflagedaten:</b><br />
<input type="text" id="c_bo_print_run" name="c_bo_print_run" value="" size="50" maxlength="50" /><br /><br />
<b>Preis EUR: </b><input type="text" id="c_bo_price" name="c_bo_price" value="" size="8" maxlength="8" onblur="test_float(this)" /><b>&nbsp;&nbsp; ISBN(EAN): </b><input type="text" id="c_bo_isbn" name="c_bo_isbn" value="" size="20" maxlength="20" ondblclick="_10_to_13(this)" onblur="test_isbn(this)" /><br /><br />
<b>Buchabmessung (mm):</b><br />
<b>Höhe: </b><input type="text" id="c_bo_height" name="c_bo_height" value="0" size="3" maxlength="3" onblur="test_int(this)" />mm<b>
&nbsp;&nbsp;Tiefe: </b><input type="text" id="c_bo_deep" name="c_bo_deep" value="0" size="3" maxlength="3" onblur="test_int(this)" />mm<b>
&nbsp;&nbsp;Breite: </b><input type="text" id="c_bo_width" name="c_bo_width" value="0" size="3" maxlength="3" onblur="test_int(this)" />mm<br />
<br />
<b>Buchgewicht (gramm): </b><input type="text" id="c_bo_weight_gr" name="c_bo_weight_gr" value="0" size="5" maxlength="5" onblur="test_int(this)" /><br /><br />
<b>Buchregal: </b><span id="ziel_r"></span><br />
<span class="button" onclick="search_data('storage');">Suche Regal</span>  <span class="button" onclick="new_data('storage');">Neues Regal</span><br /><br />
<b>Datenträger:</b><input type="checkbox" id="c_bo_has_dc" name="c_bo_has_dc" value="v" /><b>  Lagert: </b><span id="ziel_r_dc"></span><span class="button" onclick="search_data('storage_dc');">Suche Regal</span><br /><br />
<b>Autor(en):</b><span id="ziel_a"></span><br />
<span class="button" onclick="search_data('autor');">Suche Autor</span> <span class="button" onclick="new_data('autor');">Neuer Autor</span><br /><br />
<b>Buchserie: </b><span id="ziel_s"></span><br />
<span class="button" onclick="search_data('serie');">Suche Serie</span> <span class="button" onclick="new_data('serie');">Neue Serie</span><br /><br />
<b>Verlag   : </b><span id="ziel_v"></span><br />
<span class="button" onclick="search_data('publisher');">Suche Verlag</span> <span class="button" onclick="new_data('publisher');">Neuer Verlag</span><br /><br />
<b>Genre    : </b><span id="ziel_g"></span><br />
<span class="button" onclick="search_data('genre');">Suche Genre</span> <span class="button" onclick="new_data('genre');">Neue Genre</span><br /><br />
<b>Cover    : </b><span id="ziel_c"></span><br />
<span class="button" onclick="search_data('cover');">Suche Cover</span> <span class="button" onclick="new_data('cover');">Neues Cover</span><br /><br />
<b>Bindung  : </b><span id="ziel_bi"></span><br />
<span class="button" onclick="search_data('bind');">Suche Bindung</span> <span class="button" onclick="new_data('bind');">Neue Bindung</span><br /><br />
<input type="button" onclick="formular_senden();" name="dummy" value="Anlegen" /><br /><br />
<b>Kommentar:</b><br />
<textarea id="c_bo_comment" name="c_bo_comment" cols="50" rows="5"></textarea><br /><br />
<b>Verleihstatus:</b><br />
<input type="text" id="c_bo_conferred" name="c_bo_conferred" value="" size="40" maxlength="40" /><br /><br /> 

<input type="hidden" name="anzahl_r" value="0" />
<input type="hidden" name="anzahl_a" value="0" />
<input type="hidden" name="anzahl_r_dc" value="0" />
<input type="hidden" name="anzahl_s" value="0" />
<input type="hidden" name="anzahl_v" value="0" />
<input type="hidden" name="anzahl_g" value="0" />
<input type="hidden" name="anzahl_c" value="0" />
<input type="hidden" name="anzahl_bi" value="0" />
<input type="hidden" name="back" value="vorlage" />
</form>

<?php
html_fuss();
}
?>