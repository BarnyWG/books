<?php
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");	
html_kopf("Buch Anzeigen",false,"js/dat_b_neu.js");

if(isset($_REQUEST['c_bo_id']))
  $c_bo_id=$_REQUEST['c_bo_id'];
else
  die('Fehler');
  
anbindung_db($verbindung);

$result=$verbindung->query("SELECT * FROM book WHERE bo_id='{$c_bo_id}'");
$ergebnis=$result->fetch();
$c_bo_title		=$ergebnis["bo_title"];
$c_bo_isbn		=$ergebnis["bo_isbn"];



?>
<form id="form1" name="form1" action="dat_b_loesch_en.php" method="get" target="_self">
<input type="hidden" name="c_bo_id" value="<?php echo $c_bo_id; ?>" />
<pre>
Soll das Buch
<b>Buchtitel:</b>
<span class="info"><?php echo $c_bo_title; ?></span><br />
<b>ISBN:</b><span class="info"><?php echo $c_bo_isbn; ?></span><br />
Gelöscht werden?
<input type="submit" name="loeschen" value="Entgültig löschen" />
</pre>
</form>
<?php
html_fuss();
?>