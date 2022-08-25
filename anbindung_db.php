<?php
function anbindung_db(&$verbindung)
{
	try{
		$verbindung = new PDO('mysql:host=localhost;dbname=books', 'root', '');
	}
	catch (PDOExeption $e)
	{
		echo 'Fehler: '.htmlspecialchars($e->getMessage());
		exit();
	}
}

function anbindung_schliessen(&$verbindung)
{
  $verbindung=null;
}

function db_fehler_info()
{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Datenbankfehler</title>
<link rel="stylesheet" href="css/general.css" type="text/css"></link>
</head>
<body>
<h1>W&auml;hrend des Datenbankzugriffs ist ein Fehler aufgetreten!</h1>
Bitte versuchen sie die Verabeitung durch Dr&uuml;cken von 'F5' erneut zu Starten!<br />
Sollte das nicht Funktionieren versuchen sie die Eingabe der Daten erneut!
</body>
</html>
<?php
}
?>