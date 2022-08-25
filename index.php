<?php
require_once('inc/kopf_u_fuss.php');
html_kopf("Startseite Books",false,"js/onload_focus.js");
?>
<table border="0"><tr><td><img src="grafik/buchbild.gif" border="0" class="grk_logo" alt="" /></td>
<td class="unten">
<h1>Books B&uuml;cher die ich habe!</h1></td></tr></table>
<form method="post" name="anmeldung_gast" target="_self" action="benutz_check.php" >
<input name="us_name" type="hidden" value="gast" />
<input name="us_pass" type="hidden" value="gast" />
<input type="submit" value="Nur St&ouml;bern" />
</form>
<form method="post" name="anmeldung" target="_self" action="benutz_check.php" >
<pre>
Benutzerkennung:<input id="focus" name="us_name" type="text" size="20" />
       Passwort:<input name="us_pass" type="password" size="20" />
                <input type="submit" value="Anmelden" />
</pre>
</form>
<form method="post" name="passaendern" target="_self" action="be_pass_aendern.php">
<pre>
<input type="submit" value="Passwort &Auml;ndern" />
</pre>
</form>
Kein Passwort? Mail an den Admin
<a href="mailto:<?php 
  include('inc/mail_admin.inc');
  include('inc/anmelde_mail.inc');
?>">f&uuml;r "Books" anmelden:</a>

Entwickelt unter Benutzung von:
<br />
<a href="http://www.eclipse.org/" target="_blank">Eclipse</a>
<a href="http://www.phpeclipse.com/" target="_blank">PHPEclipse</a>
<br />
<a href="http://www.mozilla-europe.org/de/firefox/" target="_blank">Firefox</a>
<br />
<a href="http://getfirebug.com/" target="_blank">Firebug</a>
<br />
<a href="http://users.skynet.be/mgueury/mozilla/" target="_blank">Validated by HTML Validator</a>
<br />
Excel Export mit PHPExcel
<br />
Grafiken erstellt mit Paint Shop Pro 8
<br />
Programmiersprachen: PHP <?php echo phpversion(); ?> ,JavaScript
<br />
Server: <?php echo $_SERVER["SERVER_SOFTWARE"] ?>
<br />
Datenbank: MySql
<?php
html_fuss();
?>