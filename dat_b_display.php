<?php
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");	
html_kopf("Buch Anzeigen");

if(isset($_REQUEST['c_bo_id']))
  $c_bo_id=$_REQUEST['c_bo_id'];
else
  die('Fehler');
  
anbindung_db($verbindung);

    $result=$verbindung->query("SELECT * FROM book WHERE bo_id='{$c_bo_id}'");
 
 
    	$ergebnis= $result->fetch(PDO::FETCH_OBJ);

//$ergebnis=mysql_query("SELECT * FROM book WHERE bo_id='{$c_bo_id}'",$verbindung);

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

//mysql_free_result($ergebnis);

if($c_bo_co_id)
{
	$result=$verbindung->query("SELECT co_type FROM cover WHERE co_id='{$c_bo_co_id}'");
	$ergebnis = $result->fetch(PDO::FETCH_OBJ);
	$c_co_type=stripslashes($ergebnis->co_type);
}
else $c_co_type='';

if($c_bo_ge_id)
{
	$result=$verbindung->query("SELECT ge_type FROM genre WHERE ge_id='{$c_bo_ge_id}'");
	$ergebnis = $result->fetch(PDO::FETCH_OBJ);
	$c_ge_type=stripslashes($ergebnis->ge_type);
}
 
else $c_ge_type='';

if($c_bo_pb_id)
{
	$result=$verbindung->query("SELECT pb_name,pb_location  FROM publisher WHERE pb_id='{$c_bo_pb_id}'");
	$ergebnis = $result->fetch(PDO::FETCH_OBJ);
	$c_pb_name=stripslashes($ergebnis->pb_name);
	$c_pb_location=stripslashes($ergebnis->pb_location);
	
}
else { $c_pb_name=''; $c_pb_location='';}

if($c_bo_st_id)
{
	$result=$verbindung->query("SELECT st_name FROM storage WHERE st_id='{$c_bo_st_id}'");
	$ergebnis = $result->fetch(PDO::FETCH_OBJ);
	$c_st_name=stripslashes($ergebnis->st_name);
	
}
else $c_st_name='';

if($c_bo_st_id_dc)
{
	$result=$verbindung->query("SELECT st_name FROM storage WHERE st_id='{$c_bo_st_id_dc}'");
	$ergebnis = $result->fetch(PDO::FETCH_OBJ);
	$c_st_name_dc=stripslashes($ergebnis->st_name);
	
}
else $c_st_name_dc='';

if($c_bo_bi_id)
{
	$result=$verbindung->query("SELECT bi_type FROM bind WHERE bi_id='{$c_bo_bi_id}'");
	$ergebnis = $result->fetch(PDO::FETCH_OBJ);
	$c_bi_type=stripslashes($ergebnis->bi_type);
	
}
else $c_bi_type='';

if($c_bo_bs_id)
{
	$result=$verbindung->query("SELECT bs_name FROM book_series WHERE bs_id='{$c_bo_bs_id}'");
	$ergebnis = $result->fetch(PDO::FETCH_OBJ);
	$c_bs_name=stripslashes($ergebnis->bs_name);
	
}
else $c_bs_name='';

# autoren holen

$result=$verbindung->query("SELECT au_lastname,au_firstname,au_id FROM ll_bo_au,autor WHERE ll_bo_au_bo_id='{$c_bo_id}' AND ll_bo_au_au_id=au_id ORDER BY au_lastname");
$autor=true;
$rows = $result->fetchAll(PDO::FETCH_ASSOC);
if($rows <> null)
{
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
<pre>
<b>Buchtitel:</b> gelesen<input type="checkbox" class="info" name="c_bo_has_read" value="v"<?php if($c_bo_has_read) echo ' checked'; ?> />
<span class="info"><?php echo $c_bo_title; ?></span><br />

<b>Auflagedaten:</b>
<span class="info"><?php echo $c_bo_print_run; ?></span><br />

<b>Preis EUR:</b><span class="info"><?php echo $c_bo_price; ?></span><b>  ISBN:</b><span class="info"><?php echo $c_bo_isbn; ?></span><br />
<b>Buchabmessung (mm):</b>
<b>Höhe:</b><span class="info"><?php echo $c_bo_height; ?></span>mm<b>  Tiefe:</b><span class="info"><?php echo $c_bo_deep; ?></span>mm<b>  Breite:</b><span class="info"><?php echo $c_bo_width; ?></span>mm<br />
<b>Buchgewicht (gramm):</b><span class="info"><?php echo $c_bo_weight_gr; ?></span><br />
<b>Buchregal:</b><span class="info"><?php echo $c_st_name; ?></span><br />
<b>Datenträger:</b><input type="checkbox" class="info" name="c_bo_has_dc" value="v"<?php if($c_bo_has_dc) echo ' checked'; ?> /><b>  Lagert:</b><span class="info"><?php echo $c_st_name_dc; ?></span><br />
<b>Kommentar:</b>
<span class="info"><?php echo $c_bo_comment; ?></span>

<b>Verleihstatus:</b>
<span class="info"><?php echo $c_bo_conferred; ?></span><br /> 
<b>Autor(en):</b>
<?php 
if($autor)
{
	for($i=0;$i<count($c_au_lastname);$i++)
	{
		echo '<span class="info">';
		echo $c_au_lastname[$i].", ".$c_au_firstname[$i]." ";
		echo '</span>';
		echo '<span class="button" onclick="parent.display(';
		echo "'dat_b_search.php?autor=".$c_au_id[$i]."&suche=%&mode=display');";
		echo '">Alle Bücher zum Autor</span>'."\n";	 
	}
}
?><br />

<b>Buchserie:</b><span class="info"><?php echo $c_bs_name." ";?></span>
<?php if($c_bo_bs_id){ ?>
<span class="button" onclick="parent.display('dat_b_search.php?serie=<?php echo $c_bo_bs_id; ?>&suche=%&mode=display');">Alle Bücher zur Serie</span>
<?php }?>
<br />
<b>Verlag   :</b><span class="info"><?php echo $c_pb_name.", ".$c_pb_location." "; ?></span>
<?php if($c_bo_pb_id){ ?>
<span class="button" onclick="parent.display('dat_b_search.php?verlag=<?php echo $c_bo_pb_id; ?>&suche=%&mode=display');">Alle Bücher aus dem Verlag</span>
<?php }?>
<br />
<b>Genre    :</b><span class="info"><?php echo $c_ge_type; ?></span><br />
<b>Cover    :</b><span class="info"><?php echo $c_co_type; ?></span><br />
<b>Bindung  :</b><span class="info"><?php echo $c_bi_type; ?></span><br />
</pre>
<?php
html_fuss();
?>