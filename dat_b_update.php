<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("anbindung_db.php");
require_once("inc/kopf_u_fuss.php");
require_once("inc/db_fehler.php");

# Daten holen

$alles_io=true;

if(isset($_REQUEST['c_bo_id']))
  $c_bo_id=$_REQUEST['c_bo_id'];
else
  $c_bo_id='';
  
#Buchtitel
if(isset($_REQUEST['c_bo_title']))
  $c_bo_title=addslashes($_REQUEST['c_bo_title']);
else
  $c_bo_title='';
#Auflagedaten
if(isset($_REQUEST['c_bo_print_run']))
  $c_bo_print_run=addslashes($_REQUEST['c_bo_print_run']);
else
  $c_bo_print_run='';
# Preis
if(isset($_REQUEST['c_bo_price']))
  $c_bo_price=$_REQUEST['c_bo_price'];
else
  $c_bo_price=0;
$c_bo_price=strtr($c_bo_price,',','.');  
  
#ISBN
if(isset($_REQUEST['c_bo_isbn']))
  $c_bo_isbn=$_REQUEST['c_bo_isbn'];
else
  $c_bo_isbn='';
#H�he
if(isset($_REQUEST['c_bo_height']))
  $c_bo_height=$_REQUEST['c_bo_height'];
else
  $c_bo_height=0;
#Breite
if(isset($_REQUEST['c_bo_width']))
  $c_bo_width=$_REQUEST['c_bo_width'];
else
  $c_bo_width=0;
#Tiefe
if(isset($_REQUEST['c_bo_deep']))
  $c_bo_deep=$_REQUEST['c_bo_deep'];
else
  $c_bo_deep=0;
#Gewicht
if(isset($_REQUEST['c_bo_weight_gr']))
  $c_bo_weight_gr=$_REQUEST['c_bo_weight_gr'];
else
  $c_bo_weight_gr=0;

#Buch schon gelesen
if(isset($_REQUEST['c_bo_has_read']))
  $c_bo_has_read=$_REQUEST['c_bo_has_read'];
else
  $c_bo_has_read='';

if($c_bo_has_read=='v')
  $c_bo_has_read='true';
else
  $c_bo_has_read='false';  
    
# Pr�fe ob Regal f�r Buch gew�hlt wurde
if(isset($_REQUEST['st_id1']))
  $c_bo_st_id=$_REQUEST['st_id1'];
else
  $c_bo_st_id=0;

#Hat das Buch einen Datentr�ger
if(isset($_REQUEST['c_bo_has_dc']))
  $c_bo_has_dc=$_REQUEST['c_bo_has_dc'];
else
  $c_bo_has_dc='';

if($c_bo_has_dc=='v')
  $c_bo_has_dc='true';
else
  $c_bo_has_dc='false';

# Pr�fe ob Regal f�r Datentr�ger gew�hlt wurde
if(isset($_REQUEST['st_id_dc1']))
  $c_bo_st_id_dc=$_REQUEST['st_id_dc1'];
else
  $c_bo_st_id_dc=0;

#Kommentar
if(isset($_REQUEST['c_bo_comment']))
  $c_bo_comment=addslashes($_REQUEST['c_bo_comment']);
else
  $c_bo_comment='';

#Verleihstatus
if(isset($_REQUEST['c_bo_conferred']))
  $c_bo_conferred=addslashes($_REQUEST['c_bo_conferred']);
else
  $c_bo_conferred='';

# Pr�fe ob Autor(en) gew�hlt wurden
if(isset($_REQUEST["anzahl_a"]))
	$anzahl_a=$_REQUEST['anzahl_a'];
else
  $anzahl_a=0;
  
if($anzahl_a > 0)
  $autor = true;
else
  $autor = false;

if ($autor) #Autoren holen
{
	for($i=1; $i <= $anzahl_a; $i++)
	{
	  if(isset($_REQUEST["au_id{$i}"]))
	    $au_id[]=$_REQUEST["au_id{$i}"];
	}
}	

#Buchserie
if(isset($_REQUEST['bs_id1']))
  $c_bo_bs_id=$_REQUEST['bs_id1'];
else
  $c_bo_bs_id=0;

#Verlag
if(isset($_REQUEST['pb_id1']))
  $c_bo_pb_id=$_REQUEST['pb_id1'];
else
  $c_bo_pb_id=0;
   
#Genre
if(isset($_REQUEST['ge_id1']))
  $c_bo_ge_id=$_REQUEST['ge_id1'];
else
  $c_bo_ge_id=0;  

#Cover
if(isset($_REQUEST['co_id1']))
  $c_bo_co_id=$_REQUEST['co_id1'];
else
  $c_bo_co_id=0;

#Bindung
if(isset($_REQUEST['bi_id1']))
  $c_bo_bi_id=$_REQUEST['bi_id1'];
else
  $c_bo_bi_id=0;
  
# Daten inhalt Prüfen testen auf injection

if($c_bo_id== '')
  $alles_io=false;

if($c_bo_title== '')
  $alles_io=false;
if(strlen($c_bo_title) > 100)
  $alles_io = false;
if(strlen($c_bo_isbn) > 20)
  $alles_io = false;

if(strlen($c_bo_comment) > 200)
  $alles_io = false;
if(strlen($c_bo_conferred) > 40)
  $alles_io = false;  
$c_bo_price=strtr($c_bo_price,',','.');  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

# Buch updaten erfolgsmeldung geben
anbindung_db($verbindung);
$sqlstr="UPDATE book SET bo_title='{$c_bo_title}',bo_print_run='{$c_bo_print_run}', bo_isbn='{$c_bo_isbn}', bo_height='{$c_bo_height}'" .
		", bo_width='{$c_bo_width}', bo_deep='{$c_bo_deep}', bo_weight_gr='{$c_bo_weight_gr}', bo_price='{$c_bo_price}', bo_co_id='{$c_bo_co_id}'" .
		", bo_ge_id='{$c_bo_ge_id}', bo_pb_id='{$c_bo_pb_id}', bo_st_id='{$c_bo_st_id}', bo_st_id_dc='{$c_bo_st_id_dc}', bo_has_dc={$c_bo_has_dc}, bo_has_read={$c_bo_has_read}".
		", bo_bi_id='{$c_bo_bi_id}', bo_bs_id='{$c_bo_bs_id}', bo_conferred='{$c_bo_conferred}', bo_comment='{$c_bo_comment}' " .
		"WHERE bo_id='{$c_bo_id}'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io)
{
    # alle Autoren verbindungen löschen
    $sqlstr="DELETE FROM ll_bo_au WHERE ll_bo_au_bo_id='{$c_bo_id}'";
    $verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());    	
	# Neu verbinden Autoren
	if($autor)
	{
		foreach($au_id as $au)
		{
			$sqlstr="INSERT INTO ll_bo_au (ll_bo_au_au_id,ll_bo_au_bo_id) VALUES ('{$au}','{$c_bo_id}')";
        	$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
		}
	}	
  html_kopf();
  echo "Das Buch wurde erfolgreich in der Datenbank überarbeitet!";
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig