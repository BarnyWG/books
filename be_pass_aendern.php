<?php
require_once('inc/kopf_u_fuss.php');
html_kopf('Passwort &Auml;ndern',false,"js/onload_focus.js");
?>
<table border="0"><tr><td><img src="all_grafik/books-logo.png" border="0" id="grk_logo" alt="" /></td>
<td class="unten">
<h1>Books Passwort &auml;ndern</h1></td></tr></table>
<form method="post" name="anmeldung" target="_self" action="benutz_check.php" >
<pre>
Benutzerkennung:<input id="focus" name="us_name" type="text" size="16" />
 altes Passwort:<input name="us_pass" type="password" size="32" />
 neues Passwort:<input name="us_passn" type="password" size="32" />
Wiederholen
 neues Passwort:<input name="us_passnw" type="password" size="32" />
 
 <input type="button" value="<< Zurück" onclick="javascript:parent.history.back()" />     <input type="submit" value="Passwort &Auml;ndern" />
 <input name="mode" type="hidden" value="changepw" />         
</pre>
</form>
<?php
html_fuss();
?>