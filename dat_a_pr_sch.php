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

if(isset($_REQUEST['mode']))
  $mode=$_REQUEST['mode'];
else
  $mode='';  

# Daten inhalt Prüfen testen auf injection

if($c_au_lastname == '')
  $alles_io=false;
if(strlen($c_au_lastname) > 50)
  $alles_io = false;
  
if($c_au_firstname == '')
  $alles_io=false;
if(strlen($c_au_firstname) > 50)
  $alles_io = false;

if(strlen($c_au_biografie) > 200)
  $alles_io = false;    
 
$c_au_biografie=addslashes($c_au_biografie); # Escapen
  
if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  echo 'Die Daten entsprechen nicht den Anforderungen bitte prüfen sie ihre Eingaben!&nbsp;&nbsp;';
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  exit();
}
  
# testen ob Autor schon vorhanden

anbindung_db($verbindung);

$result=$verbindung->query("SELECT au_firstname,au_lastname FROM autor where au_firstname='{$c_au_firstname}' AND au_lastname='{$c_au_lastname}'");

if($result->rowCount() >0) # Autor bereits vorhanden
{

# Autor vorhanden Hinweis 
  html_kopf("Autor schon vorhanden");
  echo "Ein Autor mit dem Namen {$c_au_lastname}, {$c_au_firstname} ist bereits in der Datenbank vorhanden prüfen sie ihre Eingaben!&nbsp;&nbsp;";
  echo '<span class="zurueck" onclick="parent.history.back()">&lt;&lt;Zurück</span>';
  html_fuss();
  anbindung_schliessen($verbindung);
  exit();
}

# Autor noch nicht vorhanden, einf�gen erfolgsmeldung geben

$sqlstr="INSERT INTO autor (au_lastname,au_firstname,au_biografie) VALUES ('{$c_au_lastname}','{$c_au_firstname}','{$c_au_biografie}')";
#echo "$sqlstr<br>";
$io=$verbindung->exec($sqlstr) or fehlermeldung(mysql_error($verbindung));
if ($io)
{
  html_kopf("Autor erfolgreich",false,"js/onload_focus.js");
  echo "Der Autor wurde erfolgreich in die Datenbank eingefügt!";
  echo '<input type="button" id="focus" value="Weiteren Autor anlegen" onclick="window.open(';
  echo "'dat_a_neu.php?mode=".$mode."','_self')";
  echo '" />';
  if($mode=='b_neu')
  {
  	$au_id=$verbindung->lastinsertid();
        echo '<table><tr class="drill_in" onclick="';
        echo "parent.links.uebernehme_a('";
        echo $au_id;
        echo "','" .stripslashes($c_au_lastname);
        echo "','" .stripslashes($c_au_firstname)."')";        
        echo '"><td>';
        echo stripslashes($c_au_lastname);
        echo '</td>';
        echo '<td>';
        echo stripslashes($c_au_firstname);
        echo '</td>';
        echo '<td>';
        echo '<input name="c_au_id" type="button" value="gleich übernehmen" />';
        echo '</td>';
        echo '</tr></table>';
  }
  html_fuss();
}

anbindung_schliessen($verbindung);
exit();
}
# Fertig