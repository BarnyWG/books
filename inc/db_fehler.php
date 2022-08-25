<?php
function fehlermeldung($sql_error)
{
html_kopf();
?>
<h1 class="fehler"> Während der Verarbeitung ist ein Fehler aufgetreten!</h1>
Bitte versuchen sie die Verarbeitung durch Aktualisieren des Frames erneut zu Starten!<br />
Sollte das nicht Funktionieren versuchen sie die Eingabe der Daten erneut!
Datenbank meldet:
<?php
  echo $sql_error;
  html_fuss();
  exit();
}
?> 
