<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("inc/kopf_u_fuss.php");	
html5_kopf("Buch Vorlage für Massenerfassung",true,"js/dat_b_neu.js","","js/dat_b_vorlage.js");
?>
<form id="form1" name="form1" action="" method="get" target="_self">
<br /><br />
<b>Buchtitel:</b><br />
<input type="text" id="c_bo_title" name="c_bo_title" value="" size="50" maxlength="100" /><br /><br />
<b>Gelesen : </b><input type="checkbox" id="c_bo_has_read" name="c_bo_has_read" value="v" /><br /><br />
<b>Auflagedaten:</b><br />
<input type="text" id="c_bo_print_run" name="c_bo_print_run" value="" size="50" maxlength="50" /><br /><br />
<b>Preis EUR: </b><input type="text" id="c_bo_price" name="c_bo_price" value="0,0" size="8" maxlength="8" onblur="test_float(this)" /><b>&nbsp;&nbsp; ISBN(EAN): </b><input type="text" id="c_bo_isbn" name="c_bo_isbn" value="" size="20" maxlength="20" onblur="test_isbn(this)" /><br /><br />
<b>Buchabmessung (mm):</b><br />
<b>Höhe: </b><input type="text" id="c_bo_height" name="c_bo_height" value="0" size="3" maxlength="3" onblur="test_int(this)" />mm<b>
&nbsp;&nbsp;Tiefe: </b><input type="text" id="c_bo_deep" name="c_bo_deep" value="0" size="3" maxlength="3" onblur="test_int(this)" />mm<b>
&nbsp;&nbsp;Breite: </b><input type="text" id="c_bo_width" name="c_bo_width" value="0" size="3" maxlength="3" onblur="test_int(this)" />mm<br />
<br />
<b>Buchgewicht (gramm): </b><input type="text" id="c_bo_weight_gr" name="c_bo_weight_gr" value="0" size="5" maxlength="5" onblur="test_float(this)" /><br /><br />
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
<b>Kommentar:</b><br />
<textarea id="c_bo_comment" name="c_bo_comment" cols="50" rows="5"></textarea><br /><br />
<b>Verleihstatus:</b><br />
<input type="text" id="c_bo_conferred" name="c_bo_conferred" value="" size="40" maxlength="40" /><br /><br /> 

<br />
Speichern und laden der Vorlage
<br />
(HTML5 Lokaler Speicher muss eventuell aktiviert werden)
<table border="1">
<tr>
 <td>Beschreibung der Vorlage</td>
 <td>SAVE</td>
 <td>LOAD</td>
 <td>Aktivieren</td> 
</tr>
<tr>
 <td><input type="text" id="speichername1" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 1" onclick="vorlage_write(1)"></td>
 <td><input type="button" name="" value="Slot 1" onclick="vorlage_read(1)"></td>
 <td><input type="button" name="" value="Slot 1" onclick="vorlage_aktivieren(1)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername2" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 2" onclick="vorlage_write(2)"></td>
 <td><input type="button" name="" value="Slot 2" onclick="vorlage_read(2)"></td>
 <td><input type="button" name="" value="Slot 2" onclick="vorlage_aktivieren(2)"></td> 
</tr>
<tr>
 <td><input type="text" id="speichername3" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 3" onclick="vorlage_write(3)"></td>
 <td><input type="button" name="" value="Slot 3" onclick="vorlage_read(3)"></td>
 <td><input type="button" name="" value="Slot 3" onclick="vorlage_aktivieren(3)"></td> 
</tr>
<tr>
 <td><input type="text" id="speichername4" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 4" onclick="vorlage_write(4)"></td>
 <td><input type="button" name="" value="Slot 4" onclick="vorlage_read(4)"></td>
 <td><input type="button" name="" value="Slot 4" onclick="vorlage_aktivieren(4)"></td> 
</tr>
<tr>
 <td><input type="text" id="speichername5" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 5" onclick="vorlage_write(5)"></td>
 <td><input type="button" name="" value="Slot 5" onclick="vorlage_read(5)"></td>
 <td><input type="button" name="" value="Slot 5" onclick="vorlage_aktivieren(5)"></td> 
</tr>
<tr>
 <td><input type="text" id="speichername6" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 6" onclick="vorlage_write(6)"></td>
 <td><input type="button" name="" value="Slot 6" onclick="vorlage_read(6)"></td>
 <td><input type="button" name="" value="Slot 6" onclick="vorlage_aktivieren(6)"></td> 
</tr>
<tr>
 <td><input type="text" id="speichername7" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 7" onclick="vorlage_write(7)"></td>
 <td><input type="button" name="" value="Slot 7" onclick="vorlage_read(7)"></td>
 <td><input type="button" name="" value="Slot 7" onclick="vorlage_aktivieren(7)"></td> 
</tr>
<tr>
 <td><input type="text" id="speichername8" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 8" onclick="vorlage_write(8)"></td>
 <td><input type="button" name="" value="Slot 8" onclick="vorlage_read(8)"></td>
 <td><input type="button" name="" value="Slot 8" onclick="vorlage_aktivieren(8)"></td> 
</tr>
<tr>
 <td><input type="text" id="speichername9" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="" value="Slot 9" onclick="vorlage_write(9)"></td>
 <td><input type="button" name="" value="Slot 9" onclick="vorlage_read(9)"></td>
 <td><input type="button" name="" value="Slot 9" onclick="vorlage_aktivieren(9)"></td> 
</tr>
</table>

<input type="hidden" id="anzahl_r" name="anzahl_r" value="0" />
<input type="hidden" id="anzahl_a" name="anzahl_a" value="0" />
<input type="hidden" id="anzahl_r_dc" name="anzahl_r_dc" value="0" />
<input type="hidden" id="anzahl_s" name="anzahl_s" value="0" />
<input type="hidden" id="anzahl_v" name="anzahl_v" value="0" />
<input type="hidden" id="anzahl_g" name="anzahl_g" value="0" />
<input type="hidden" id="anzahl_c" name="anzahl_c" value="0" />
<input type="hidden" id="anzahl_bi" name="anzahl_bi" value="0" />

</form>

<?php
html_fuss();
}
?>