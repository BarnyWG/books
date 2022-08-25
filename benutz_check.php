<?php # Überprüft ob der Benutzer in der Datenbank vorhanden ist und setzt die Umgebungsvariablen für den Benutzer ändert auf Anforderung das Passwort
@session_start();
# Programmiert von: Bernd W. Go�mann
require_once('anbindung_db.php');
require_once('inc/kopf_u_fuss.php');
$user = $_REQUEST['us_name'];
$pass = $_REQUEST['us_pass'];

if (isset($_REQUEST['mode']))
{
  $mode = $_REQUEST['mode'];
}
else
{
  $mode= "";
}    
if ($mode == "changepw")
{
  $passn = $_REQUEST['us_passn'];
  $passnw = $_REQUEST['us_passnw'];	
}

    # suche den Benutzer in der DB
    anbindung_db($verbindung);
    $sql="SELECT us_pass,us_id,us_level,us_working FROM user WHERE us_name='".$user."'";
//    $kommando = $verbindung->prepare($sql);
//    $kommando->execute();
//     $ergebnis=$kommando->fetch(PDO::FETCH_OBJ);
    
    $result=$verbindung->query($sql);
    if($result <> null)
    {
    	$ergebnis= $result->fetch(PDO::FETCH_OBJ);
    if($ergebnis->us_pass == md5($pass))
    {
    	$_SESSION["s_us_name"] = $user;
        $_SESSION["s_us_id"] = $ergebnis->us_id;
        $_SESSION["s_us_level"] = $ergebnis->us_level;
        $_SESSION["s_us_working"] = $ergebnis->us_working;
    }
    else
    {
      anbindung_schliessen($verbindung);
      zugriff_verweigert();   # Benutzer nicht gefunden
      exit();
    }  
    }
    else
    {
      anbindung_schliessen($verbindung);
      zugriff_verweigert();   # Benutzer nicht gefunden
      exit();
    }

    if ($mode=="changepw") # wenn benutzer okay Prüfe ob Passworterneuerung
    {
      if($user<>'gast')
      {
        if(strlen($passn) > 6)
        {
      	  if ($passn == $passnw) # passwort �ndernung
      	  {
            $ergebnis = $verbindung->exec("UPDATE user SET us_pass='".md5($passn)."' WHERE us_name='".$user."'");
            if($ergebnis)
            {
              html_kopf('Passwort geändert',false,'js/onload_focus.js');
              echo "Passwort wurde geändert! ";
              echo '<a id="focus" href="haupt_info.php">Weiter</a>';
              html_fuss();
            }
   	  	  }
          else
          {
            html_kopf('Passwort Fehler',false,'js/onload_focus.js');
            echo "Neues Passwort und Wiederholung stimmen nicht Überein! ";
            echo '<a id="focus" href="index.php">ZURÜCK</a>';
            html_fuss();   	    		
   	      }
        }	
        else
        {
          html_kopf('Verweigern',false,'js/onload_focus.js');
          echo "Neues Passwort zu kurz benutzen sie mindestes 6 Zeichen! ";
          echo '<a id="focus" href="index.php">ZURÜCK</a>';
          html_fuss();   	    		
        }	
    	
    }
    else
    {
      html_kopf('Verweigern',false,'js/onload_focus.js');
      echo "Passwort für Gast kann nicht geändert werden! ";
      echo '<a id="focus" href="index.php">ZURÜCK</a>';
      html_fuss();   	    		
    }  
  }

  anbindung_schliessen($verbindung);
  if($mode=="") abgesang();

    
function zugriff_verweigert()
{
  html_kopf('Prüfe Benutzer',false,'js/onload_focus.js');
  echo '<h1>Benutzer Nicht Authentifiziert</h1>';
  echo '<input id="focus" type="Submit" value="<< Zurück" onclick="javascript:parent.history.back()" />';
  html_fuss();
}

function abgesang()
{
  header("location:haupt_info.php"); # wenn I.O. gleich weiterleiten
}
?>
