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
if(isset($_REQUEST['c_au_id']))
  $c_au_id=$_REQUEST['c_au_id'];
else
  $c_au_id='';
  
if(isset($_REQUEST['c_au_firstname']))
  $c_au_firstname=addslashes($_REQUEST['c_au_firstname']);
else
  $c_au_firstname='';

if(isset($_REQUEST['c_au_lastname']))
  $c_au_lastname=addslashes($_REQUEST['c_au_lastname']);
else
  $c_au_lastname='';

if(isset($_REQUEST['c_au_biografie']))
  $c_au_biografie=addslashes($_REQUEST['c_au_biografie']);
else
  $c_au_biografie='';

# Daten inhalt Pr�fen testen auf injection

if($c_au_id == '')
  $alles_io=false;
  
if($c_au_firstname == '')
  $alles_io=false;
if(strlen($c_au_firstname) > 50)
  $alles_io = false;

if(strlen($c_au_biografie) > 200)
  $alles_io = false;    
 
  
if(!$alles_io) # wenn Daten unvollst�ndig abbruch
{
  html_kopf();
  echo 'Die Daten sind entsprechen nicht den Anforderungen bitt Pr�fen sie ihre Eingaben';
  echo '<input type="button" value="<<Zur�ck" onclick="parent.history.back()">';
  html_fuss();
  exit();
}
  
# Autor Daten Update

anbindung_db($verbindung);

$sqlstr="UPDATE autor SET au_lastname='{$c_au_lastname}',au_firstname='{$c_au_firstname}',au_biografie='{$c_au_biografie}' where au_id='$c_au_id'";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung(mysql_error($verbindung));
if ($io)
{
  html_kopf();
  echo "Der Autor wurde erfolgreich gepflegt!";
  html_fuss();
}
anbindung_schliessen($verbindung);
exit();
}
# Fertig