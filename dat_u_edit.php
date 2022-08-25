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

# Daten holen

$alles_io=true;
if(isset($_REQUEST['c_us_id']))
  $c_us_id=$_REQUEST['c_us_id'];
else
  $c_us_id='';

# Daten inhalt Pr�fen

if($c_us_id == '')
  $alles_io=false;

if(!$alles_io) # wenn Daten unvollständig abbruch
{
  html_kopf();
  include('inc/daten_unvollstaendig.inc');
  html_fuss();
  exit();
}

anbindung_db($verbindung);

$result=$verbindung->query("SELECT us_name,us_working,us_level FROM user WHERE us_id='{$c_us_id}'");

if($result->rowCount()) # Benutzer gefunden Daten holen
{
	$ergebnis=$result->fetch(PDO::FETCH_OBJ);
  $c_us_name	=$ergebnis->us_name;
  $c_us_working	=$ergebnis->us_working;
  $c_us_level	=$ergebnis->us_level;
}

html_kopf("Benutzer editieren");
?>

<form action="dat_u_update.php" method="get">
<pre>
<input type="hidden" name="c_us_id" value="<?php echo $c_us_id;?>" />
<b>UserID:</b>
<input type="text" id="focus" name="c_us_name" value="<?php echo $c_us_name;?>" size="20" maxlength="20" /><br />
<b>Passwort:</b> !! Nur eintragen wenn passwort neu gesetzt werden soll !!
<input type="text" name="c_us_pass" value="" size="20" maxlength="32" />(bis 32 Char MD5 wird gespeichert)<br />
<b>User Level:</b>
<input type="text" name="c_us_level" value="<?php echo $c_us_level;?>" size="4" maxlength="4" /><br />
<b>User Working:</b>
<input type="text" name="c_us_working" value="<?php echo $c_us_working;?>" size="10" maxlength="10" /><br />
<br />
<input type="submit" name="dummy" value="Speichern" /><input type="reset" /><br />

Userlevel:
0 = Gast darf nur Lesend zugreifen
1 = User darf Datensätze Neu Anlegen und Editieren sein Passwort ändern
2 = UpUser darf Datensätze zusätzlich Löschen sein Passwort ändern
7 = SuperUser alle Datensatz Funktionen sowie Passwörter ändern neusetzen
    neue Benutzer einrichten Benutzer Level verändern
    
Working:
Special Chars für Arbeiterlaubnisse

L = Löschen von Datensätzen ....
    
</pre>
</form>
<?php
html_fuss();
}
?>