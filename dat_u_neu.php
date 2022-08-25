<?php
@session_start();
if($_SESSION["s_us_level"] <"1")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require_once("inc/kopf_u_fuss.php");	
html_kopf("Benutzer Daten Neu",false,"js/onload_focus.js");
?>
<form action="dat_u_pr_sch.php" method="get" target="_self">
<pre>
<b>UserID:</b>
<input type="text" id="focus" name="c_us_name" value="" size="20" maxlength="20" /><br />
<b>Passwort:</b>
<input type="text" name="c_us_pass" value="" size="20" maxlength="32" />(bis 32 Char MD5 wird gespeichert)<br />
<b>User Level:</b>
<input type="text" name="c_us_level" value="0" size="4" maxlength="4" /><br />
<b>User Working:</b>
<input type="text" name="c_us_working" value="" size="10" maxlength="10" /><br />
<br />
<input type="submit" name="dummy" value="Anlegen" /><input type="reset" /><br />

Userlevel:
0 = Gast darf nur Lesend zugreifen
1 = User darf Datensätze neu anlegen und Editieren sein Passwort ändern
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