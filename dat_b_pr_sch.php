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
if(strlen($c_bo_price)<1)
  $c_bo_price=0;
$c_bo_price=strtr($c_bo_price,',','.');  
  
#ISBN
if(isset($_REQUEST['c_bo_isbn']))
  $c_bo_isbn=addslashes($_REQUEST['c_bo_isbn']);
else
  $c_bo_isbn='';
#Höhe
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
#Back rücksprung festlegen
if(isset($_REQUEST['back']))
  $back=$_REQUEST['back'];
else
  $back='';

#Buch schon gelesen
if(isset($_REQUEST['c_bo_has_read']))
  $c_bo_has_read=$_REQUEST['c_bo_has_read'];
else
  $c_bo_has_read='';

if($c_bo_has_read=='v')
  $c_bo_has_read='true';
else
  $c_bo_has_read='false';  
    
# Prüfe ob Regal für Buch gewählt wurde
if(isset($_REQUEST['st_id1']))
  $c_bo_st_id=$_REQUEST['st_id1'];
else
  $c_bo_st_id=0;

#Hat das Buch einen Datenträger
if(isset($_REQUEST['c_bo_has_dc']))
  $c_bo_has_dc=$_REQUEST['c_bo_has_dc'];
else
  $c_bo_has_dc='';

if($c_bo_has_dc=='v')
  $c_bo_has_dc='true';
else
  $c_bo_has_dc='false';

# Prüfe ob Regal für Datenträger gewählt wurde
if(isset($_REQUEST['st_id_dc1']))
  $c_bo_st_id_dc=$_REQUEST['st_id_dc1'];
else
  $c_bo_st_id_dc=0;

#Kommentar
if(isset($_REQUEST['c_bo_comment']))
  $c_bo_comment=$_REQUEST['c_bo_comment'];
else
  $c_bo_comment='';

#Verleihstatus
if(isset($_REQUEST['c_bo_conferred']))
  $c_bo_conferred=addslashes($_REQUEST['c_bo_conferred']);
else
  $c_bo_conferred='';

# Prüfe ob Autor(en) gewählt wurden
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
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
include('/inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}
  
# testen ob Buch schon vorhanden eigentlich kann ein Buch auch doppelt sein

anbindung_db($verbindung);

$result=$verbindung->query("SELECT bo_title,bo_isbn FROM book WHERE bo_title='{$c_bo_title}' AND bo_isbn='{$c_bo_isbn}'");

if($result->rowCount()) # Buch bereits vorhanden
{
  html_kopf("Buch schon vorhanden");
  echo "Ein Buch mit dem Namen {$c_bo_title} mit der ISBN {$c_bo_isbn} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.links.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Buch noch nicht vorhanden, einfügen erfolgsmeldung geben

$sqlstr="INSERT INTO book (bo_title,bo_print_run, bo_isbn, bo_height, bo_width, bo_deep, bo_weight_gr, bo_price, bo_co_id, bo_ge_id, bo_pb_id, bo_st_id, bo_st_id_dc, bo_has_dc,bo_has_read, bo_bi_id, bo_bs_id, bo_conferred, bo_comment) " .
		"VALUES ('{$c_bo_title}','{$c_bo_print_run}','{$c_bo_isbn}','{$c_bo_height}','{$c_bo_width}','{$c_bo_deep}','{$c_bo_weight_gr}','{$c_bo_price}','{$c_bo_co_id}','{$c_bo_ge_id}','{$c_bo_pb_id}','{$c_bo_st_id}','{$c_bo_st_id_dc}',{$c_bo_has_dc},{$c_bo_has_read},'{$c_bo_bi_id}','{$c_bo_bs_id}','{$c_bo_conferred}','{$c_bo_comment}')";
#echo "$sqlstr<br>";

$io=$verbindung->exec($sqlstr) or fehlermeldung($verbindung->errorInfo());
if ($io && $autor)
{
	# letzte ID holen
    $bo_id=$verbindung->lastInsertID();	
	
	# verbinden Autoren
	foreach($au_id as $au)
	{
		$sqlstr="INSERT INTO ll_bo_au (ll_bo_au_au_id,ll_bo_au_bo_id) VALUES ('{$au}','{$bo_id}')";
        $verbindung->exec($sqlstr);
	}
		
  html_kopf("Buch angelegt",false,"js/onload_focus.js");
  echo "Das Buch wurde erfolgreich in die Datenbank eingefügt!";
  if($back=='vorlage')
  {
    echo '<input type="button" id="focus" value="Weiteres Buch anlegen" onclick="window.open(';
    echo "'dat_b_neu_vorlage.php','_self')";
    echo '" />';
  }
  else
  {
    echo '<input type="button" id="focus" value="Weiteres Buch anlegen" onclick="window.open(';
    echo "'dat_b_neu.php','_self')";
    echo '" />';
  }    
  html_fuss();
}
elseif($io)
{  
  html_kopf("Buch angelegt",false,"js/onload_focus.js");
  echo "Das Buch wurde erfolgreich in die Datenbank eingefügt! Autoren wurden keine Angelegt.";
  if($back=='vorlage')
  {
    echo '<input type="button" id="focus" value="Weiteres Buch anlegen" onclick="window.open(';
    echo "'dat_b_neu_vorlage.php','_self')";
    echo '" />';
  }
  else
  {
    echo '<input type="button" id="focus" value="Weiteres Buch anlegen" onclick="window.open(';
    echo "'dat_b_neu.php','_self')";
    echo '" />';
  }    
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig