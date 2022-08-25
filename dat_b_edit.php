<?php
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");	
html_kopf("Buch Anzeigen",true,"js/dat_b_neu.js");

if(isset($_REQUEST['c_bo_id']))
  $c_bo_id=$_REQUEST['c_bo_id'];
else
  die('Fehler');
  
anbindung_db($verbindung);

$result=$verbindung->query("SELECT * FROM book WHERE bo_id='{$c_bo_id}'");
$ergebnis=$result->fetch(PDO::FETCH_OBJ);
$c_bo_title		=stripslashes($ergebnis->bo_title);
$c_bo_isbn		=stripslashes($ergebnis->bo_isbn);
$c_bo_print_run	=stripslashes($ergebnis->bo_print_run);
$c_bo_height	=$ergebnis->bo_height;
$c_bo_width 	=$ergebnis->bo_width;
$c_bo_deep		=$ergebnis->bo_deep;
$c_bo_weight_gr	=$ergebnis->bo_weight_gr;
$c_bo_height	=$ergebnis->bo_height;
$c_bo_price		=$ergebnis->bo_price;
$c_bo_co_id		=$ergebnis->bo_co_id;
$c_bo_ge_id		=$ergebnis->bo_ge_id;
$c_bo_pb_id		=$ergebnis->bo_pb_id;
$c_bo_st_id		=$ergebnis->bo_st_id;
$c_bo_st_id_dc	=$ergebnis->bo_st_id_dc;
$c_bo_has_dc	=$ergebnis->bo_has_dc;
$c_bo_has_read	=$ergebnis->bo_has_read;
$c_bo_bi_id		=$ergebnis->bo_bi_id;
$c_bo_bs_id		=$ergebnis->bo_bs_id;
$c_bo_conferred =stripslashes($ergebnis->bo_conferred);
$c_bo_comment   =stripslashes($ergebnis->bo_comment);
$c_bo_price =strtr($c_bo_price,'.',',');



if($c_bo_co_id)
{
	$result=$verbindung->query("SELECT co_type FROM cover WHERE co_id='{$c_bo_co_id}'");
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
	$c_co_type=stripslashes($ergebnis->co_type);
	
}
else $c_co_type='';

if($c_bo_ge_id)
{
	$result=$verbindung->query("SELECT ge_type FROM genre WHERE ge_id='{$c_bo_ge_id}'");
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
	$c_ge_type=stripslashes($ergebnis->ge_type);

}
else $c_ge_type='';

if($c_bo_pb_id)
{
	$result=$verbindung->query("SELECT pb_name,pb_location FROM publisher WHERE pb_id='{$c_bo_pb_id}'");
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
	$c_pb_name=stripslashes($ergebnis->pb_name);
	$c_pb_location=stripslashes($ergebnis->pb_location);
		
}
else { $c_pb_name=''; $c_pb_location='';}

if($c_bo_st_id)
{
	$result=$verbindung->query("SELECT st_name FROM storage WHERE st_id='{$c_bo_st_id}'");
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
	$c_st_name=stripslashes($ergebnis->st_name);
	
}
else $c_st_name='';

if($c_bo_st_id_dc)
{
	$result=$verbindung->query("SELECT st_name FROM storage WHERE st_id='{$c_bo_st_id_dc}'");
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
	$c_st_name_dc=stripslashes($ergebnis->st_name);
	
}
else $c_st_name_dc='';

if($c_bo_bi_id)
{
	$result=$verbindung->query("SELECT bi_type FROM bind WHERE bi_id='{$c_bo_bi_id}'");
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
	$c_bi_type=stripslashes($ergebnis->bi_type);
	
}
else $c_bi_type='';

if($c_bo_bs_id)
{
	$result=$verbindung->query("SELECT bs_name FROM book_series WHERE bs_id='{$c_bo_bs_id}'");
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
	$c_bs_name=stripslashes($ergebnis->bs_name);
	
}
else $c_bs_name='';

# autoren holen

$result=$verbindung->query("SELECT au_lastname,au_firstname,au_id FROM ll_bo_au,autor WHERE ll_bo_au_bo_id='{$c_bo_id}' AND ll_bo_au_au_id=au_id ORDER BY au_lastname");
$autor=true;
if($result <> null)
{
	$rows=$result->fetchAll();
	foreach($rows as $ergebnis)
	{
  		$c_au_lastname[]=stripslashes($ergebnis["au_lastname"]);
  		$c_au_firstname[]=stripslashes($ergebnis["au_firstname"]);
  		$c_au_id[]=$ergebnis["au_id"];
	}
}
else 
$autor=false;

?>
<form id="form1" name="form1" action="dat_b_update.php" method="get" target="_self">
<input type="hidden" name="c_bo_id" value="<?php echo $c_bo_id; ?>" />
<input type="button" onclick="formular_senden();" name="dummy" value="Update" />  <input type="reset" /><br /><br />
<b>Buchtitel:</b><br />
<input id="focus" type="text" name="c_bo_title" value="<?php echo $c_bo_title; ?>" size="50" maxlength="100" /><br /><br />
<b>Gelesen : </b><input type="checkbox" name="c_bo_has_read" value="v"<?php if($c_bo_has_read) echo ' checked="checked"'; ?> /><br /><br />
<b>Auflagedaten:</b><br />
<input type="text" name="c_bo_print_run" value="<?php echo $c_bo_print_run; ?>" size="50" maxlength="50" /><br /><br /><br />
<b>Preis EUR: </b><input type="text" name="c_bo_price" value="<?php echo $c_bo_price; ?>" size="8" maxlength="8" onblur="test_float(this)" /><b>&nbsp;&nbsp;  ISBN(EAN): </b><input type="text" name="c_bo_isbn" value="<?php echo $c_bo_isbn; ?>" size="20" maxlength="20" ondblclick="_10_to_13(this)" onblur="test_isbn(this)" /><br /><br />
<b>Buchabmessung (mm):</b><br />
<b>Höhe: </b><input type="text" name="c_bo_height" value="<?php echo $c_bo_height; ?>" size="3" maxlength="3" onblur="test_int(this)" />mm<b>
&nbsp;&nbsp;Tiefe: </b><input type="text" name="c_bo_deep" value="<?php echo $c_bo_deep; ?>" size="3" maxlength="3" onblur="test_int(this)" />mm<b>
&nbsp;&nbsp;Breite: </b><input type="text" name="c_bo_width" value="<?php echo $c_bo_width; ?>" size="3" maxlength="3" onblur="test_int(this)" />mm
<br /><br />
<b>Buchgewicht (gramm): </b><input type="text" name="c_bo_weight_gr" value="<?php echo $c_bo_weight_gr; ?>" size="5" maxlength="5" onblur="test_int(this)" /><br /><br />
<b>Buchregal: </b><span id="ziel_r">
<?php if($c_bo_st_id){?>
<span id="zeile_r1">
<?php
echo $c_st_name." "; ?><input type="button" value="Löschen" onclick="raus_r('zeile_r1')" /><input id="st_id1" type="hidden" name="st_id1" value="<?php echo $c_bo_st_id; ?>" />
</span>
<?php
} 
?>
</span><br />
<span class="button" onclick="search_data('storage');">Suche Regal</span>  <span class="button" onclick="new_data('storage');">Neues Regal</span><br /><br />
<b>Datenträger:</b><input type="checkbox" name="c_bo_has_dc" value="v"<?php if($c_bo_has_dc) echo ' checked="checked"'; ?> /><b>
&nbsp;&nbsp;Lagert: </b><span id="ziel_r_dc">
<?php if($c_bo_st_id_dc){?>
<span id="zeile_r_dc1">
<?php echo $c_st_name_dc." "; ?>
<input type="button" value="Löschen" onclick="raus_r_dc('zeile_r_dc1')" /><input id="st_id_dc1" type="hidden" name="st_id_dc1" value="<?php echo $c_bo_st_id_dc; ?>" /></span>
<?php 
}
?>
</span><span class="button" onclick="search_data('storage_dc');">Suche Regal</span><br /><br />
<b>Kommentar:</b><br />
<textarea name="c_bo_comment" cols="50" rows="5"><?php echo $c_bo_comment; ?></textarea><br /><br />
<b>Verleihstatus:</b><br />
<input type="text" name="c_bo_conferred" value="<?php echo $c_bo_conferred; ?>" size="40" maxlength="40" /><br /><br /> 
<b>Autor(en):</b><span id="ziel_a"><?php
if($autor)
{
	for($i=0;$i<count($c_au_lastname);$i++)
	{
		$t=$i+1;
		echo '<br /><span id="zeile_a'.$t.'">';
		echo '<input type="button" value="Löschen" onclick="raus_a(';
		echo "'zeile_a".$t."')";
		echo '"/>'; 
    	echo " ".$c_au_lastname[$i].", ".$c_au_firstname[$i];
    	echo '<input id="au_id'.$t.'" type="hidden" name="au_id'.$t.'" value="'.$c_au_id[$i].'" />';
		echo "</span>";
	}
}	
?></span><br />
<span class="button" onclick="search_data('autor');">Suche Autor</span> <span class="button" onclick="new_data('autor');">Neuer Autor</span><br /><br />
<b>Buchserie: </b><span id="ziel_s"><?php if($c_bo_bs_id){?><span id="zeile_s1">
<?php echo $c_bs_name." "; ?><input type="button" value="Löschen" onclick="raus_s('zeile_s1')" />
<input id="bs_id1" type="hidden" name="bs_id1" value="<?php echo $c_bo_bs_id; ?>" />
</span><?php } ?></span><br /> 
<span class="button" onclick="search_data('serie');">Suche Serie</span> <span class="button" onclick="new_data('serie');">Neue Serie</span><br /> <br /> 
<b>Verlag   : </b><span id="ziel_v"><?php if($c_bo_pb_id){?><span id="zeile_v1">
<?php echo $c_pb_name.", ".$c_pb_location." "; ?><input type="button" value="Löschen" onclick="raus_v('zeile_v1')" /><input id="pb_id1" type="hidden" name="pb_id1" value="<?php echo $c_bo_pb_id; ?>" />
</span><?php } ?></span><br /> 
<span class="button" onclick="search_data('publisher');">Suche Verlag</span> <span class="button" onclick="new_data('publisher');">Neuer Verlag</span><br /> <br /> 
<b>Genre    : </b><span id="ziel_g"><?php if($c_bo_ge_id){?><span id="zeile_g1">
<?php echo $c_ge_type." "; ?><input type="button" value="Löschen" onclick="raus_g('zeile_g1')" /><input id="ge_id1" type="hidden" name="ge_id1" value="<?php echo $c_bo_ge_id; ?>" />
</span><?php } ?></span><br /> 
<span class="button" onclick="search_data('genre');">Suche Genre</span> <span class="button" onclick="new_data('genre');">Neue Genre</span><br /> <br /> 
<b>Cover    : </b><span id="ziel_c"><?php if($c_bo_co_id){?><span id="zeile_c1">
<?php echo $c_co_type." "; ?><input type="button" value="Löschen" onclick="raus_c('zeile_c1')" /><input id="co_id1" type="hidden" name="co_id1" value="<?php echo $c_bo_co_id; ?>" />
</span><?php } ?></span><br /> 
<span class="button" onclick="search_data('cover');">Suche Cover</span> <span class="button" onclick="new_data('cover');">Neues Cover</span><br /> <br /> 
<b>Bindung  : </b><span id="ziel_bi"><?php if($c_bo_bi_id){?><span id="zeile_bi1">
<?php echo $c_bi_type." "; ?><input type="button" value="Löschen" onclick="raus_bi('zeile_bi1')" /><input id="bi_id1" type="hidden" name="bi_id1" value="<?php echo $c_bo_bi_id; ?>" />
</span><?php } ?></span><br /> 
<span class="button" onclick="search_data('bind');">Suche Bindung</span> <span class="button" onclick="new_data('bind');">Neue Bindung</span><br /> <br /> 
<input type="button" onclick="formular_senden();" name="dummy" value="Update" />
<input type="hidden" name="anzahl_r" value="<?php if($c_bo_st_id) echo '1'; else echo '0';?>" />
<input type="hidden" name="anzahl_a" value="<?php if($autor){if(count($c_au_lastname)) echo count($c_au_lastname);} else echo '0';?>"  />
<input type="hidden" name="anzahl_r_dc" value="<?php if($c_bo_st_id_dc) echo '1'; else echo '0';?>" />
<input type="hidden" name="anzahl_s" value="<?php if($c_bo_bs_id) echo '1'; else echo '0';?>" />
<input type="hidden" name="anzahl_v" value="<?php if($c_bo_pb_id) echo '1'; else echo '0';?>" />
<input type="hidden" name="anzahl_g" value="<?php if($c_bo_ge_id) echo '1'; else echo '0';?>" />
<input type="hidden" name="anzahl_c" value="<?php if($c_bo_co_id) echo '1'; else echo '0';?>" />
<input type="hidden" name="anzahl_bi" value="<?php if($c_bo_bi_id) echo '1'; else echo '0';?>" />
</form>
<?php
html_fuss();
?>