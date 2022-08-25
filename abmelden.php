<?php 
/*
 * Program (C) by Bernd W. Go�mann
 * eMail bwg@wolfsburg.de
 * Abmeldung von der Anwendung und zurück zur Startseite
*/
@session_start();
session_destroy();
header("location:index.php");
?>