<?php
@session_start();
if($_SESSION["s_us_level"] <"7")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require("anbindung_db.php");
require("inc/kopf_u_fuss.php");

html5_kopf("Abfrage bauen",true,"js/dat_sql_neu.js","css/dat_sql_neu.css");
?>
<h1>Flexible Auswertung Datenbank</h1>
<table >
<tr>
 <td>
 DB-Felder<br />
  <select id="felder" size="10">
<?php
function hole_felder($verbindung,$tabelle)
{
	$sqlstr="SELECT * FROM {$tabelle} limit 1";
	$result=$verbindung->query($sqlstr);
	$t = $result->columnCount();
	for($i=0;$i<$t;$i++)
	{
		$meta =$result->getColumnMeta($i);
  	echo '<option value="'.$tabelle.'.'.$meta['name'].'">'.$tabelle.'.'.$meta['name'].'</option>';		
	}
}

anbindung_db($verbindung);
hole_felder($verbindung,'book');
hole_felder($verbindung,'autor');
hole_felder($verbindung,'ll_bo_au');
hole_felder($verbindung,'book_series');
hole_felder($verbindung,'genre');
hole_felder($verbindung,'storage');
hole_felder($verbindung,'cover');
hole_felder($verbindung,'bind');
hole_felder($verbindung,'publisher');

?>
</select></td>
 <td>
 <input type="button" name="dummy1" value="==>" onclick="transfer()" /><br />
 <br />
 <br />
 <input type="button" name="dummy1" value="<==" onclick="loeschen()" /><br />
  </td> 
 <td> Zu Listende Felder<br />
  <select id="auswahl" size="10">
 </select>
  </td>
<td>
<input type="button" name="" value="&Lambda;" onclick="auswahl_up();" />
<br />
 <input type="button" name="dummy1" value="V" onclick="auswahl_down();" />
</td>  
</tr>
</table>
Auswahl nach<br />
<input type="button" name="dummy1" value="==>" onclick="where()" /><input type="text" id="bedingungsfeld" value="" /><br />
<table>
<tr>
<td class="operator">Operator<input type="text" id="aktueller_op" value="=" size="4" maxlength="4" disabled="disabled" /><br />
<input type="button" name="dummy1" value="=" onclick="operator('=')" /><br />
<input type="button" name="dummy1" value="<" onclick="operator('<')" /><br />
<input type="button" name="dummy1" value=">" onclick="operator('>')" /><br />
<input type="button" name="dummy1" value="like(wie)" onclick="operator('like')" /><br />
<input type="button" name="dummy1" value=">=" onclick="operator('>=')" /><br />
<input type="button" name="dummy1" value="<=" onclick="operator('<=')" /><br />
</td>
<td class="operator">Suchwert(Joker like,"*_")<br />
<input type="text" id="suchwert" value="" size="20" maxlength="30" /><br />
</td>
<td class="between">zwischen<br />
  <input type="text" id="zwischen1" value="" size="10" maxlength="100" /><br />und<br />
  <input type="text" id="zwischen2" value="" size="10" maxlength="100" />
</td>
<td class="oneToOne">Beziehung:Feld<br />
  <input type="button" name="" value="==>" onclick="feld_gleich('1')" /><input type="text" id="feld_gleich1" value="" /><br />entspricht Feld<br />
  <input type="button" name="" value="==>" onclick="feld_gleich('2')" /><input type="text" id="feld_gleich2" value="" />
</td>
</tr>
<tr>
<td class="logic">Logik<input type="text" id="aktueller_lop" value="AND" size="3" maxlength="3" disabled="disabled" /><br />
<input type="button" name="rb_logik" value="Oder" onclick="oder('OR')" /><br />
<input type="button" name="rb_logik" value="Und" onclick="oder('AND')" /><br />
<input type="button" name="rb_logik" value="Nicht" onclick="oder('NOT')" /><br />
</td>
<td class="operator center"><input type="button" name="" value="V" onclick="transfer_where()" />
</td>
<td class="between center"><input type="button" name="" value="V" onclick="transfer_where_zw()" /></td>
<td class="oneToOne center"><input type="button" name="" value="V" onclick="transfer_gleich()" /></td>
</tr>
</table>
<table>
<tr>
<td class="where">where Bedingung<br />
  <select id="sel_where" size="5">
 </select>
</td>
<td class="where">
<input type="button" name="" value="&Lambda;" onclick="where_up();" />
<br />
<input type="button" name="" value="Verwerfen" onclick="where_loesch()" />
 <br />
 <input type="button" name="" value="V" onclick="where_down();" />
</td>
</tr>
<tr>
<td class="orderBy">Order By<br />
  <select id="sel_order" size="5">
 </select>
</td>
 <td class="orderBy">
 <input type="button" name="dummy1" value="&Lambda;" onclick="order_up();" />
 <br />
 <input type="button" name="dummy1" value="<==" onclick="transfer_order()" /> DB-Feld
 <br />
 <input type="button" name="dummy1" value="Verwerfen" onclick="order_loesch()" />
 <br />
 <input type="button" name="dummy1" value="V" onclick="order_down();" />
 </td>
</tr>
</table>
<input type="button" name="dummy1" value="Abfrage t&auml;tigen" onclick="sql_abfrage()" />
<input type="button" name="dummy1" value="Abfrage als CSV holen" onclick="sql_abfrage('csv')" />
<img src="grafik/excel.png" title="Abfrage als XLSX holen" width="20" height="20" onclick="sql_abfrage('xlsx')">
<!-- <img src="grafik/pdf.gif" alt="Abfrage als PDF holen" onclick="sql_abfrage('pdf')"> -->
<br />
Speichern und laden der Abfrage
<br />
(HTML5 Lokaler Speicher muss eventuell aktiviert werden)
<table border="1">
<tr>
 <td>Beschreibung der Abfrage</td>
 <td>SAVE</td>
 <td>LOAD</td>
</tr>
<tr>
 <td><input type="text" id="speichername1" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 1" onclick="sql_abfrage_write(1)"></td>
 <td><input type="button" name="dummy1" value="Slot 1" onclick="sql_abfrage_read(1)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername2" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 2" onclick="sql_abfrage_write(2)"></td>
 <td><input type="button" name="dummy1" value="Slot 2" onclick="sql_abfrage_read(2)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername3" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 3" onclick="sql_abfrage_write(3)"></td>
 <td><input type="button" name="dummy1" value="Slot 3" onclick="sql_abfrage_read(3)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername4" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 4" onclick="sql_abfrage_write(4)"></td>
 <td><input type="button" name="dummy1" value="Slot 4" onclick="sql_abfrage_read(4)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername5" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 5" onclick="sql_abfrage_write(5)"></td>
 <td><input type="button" name="dummy1" value="Slot 5" onclick="sql_abfrage_read(5)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername6" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 6" onclick="sql_abfrage_write(6)"></td>
 <td><input type="button" name="dummy1" value="Slot 6" onclick="sql_abfrage_read(6)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername7" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 7" onclick="sql_abfrage_write(7)"></td>
 <td><input type="button" name="dummy1" value="Slot 7" onclick="sql_abfrage_read(7)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername8" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 8" onclick="sql_abfrage_write(8)"></td>
 <td><input type="button" name="dummy1" value="Slot 8" onclick="sql_abfrage_read(8)"></td>
</tr>
<tr>
 <td><input type="text" id="speichername9" value="" size="20" maxlength="20"></td>
 <td><input type="button" name="dummy1" value="Slot 9" onclick="sql_abfrage_write(9)"></td>
 <td><input type="button" name="dummy1" value="Slot 9" onclick="sql_abfrage_read(9)"></td>
</tr>
</table>
<?php
html_fuss();
}
?>