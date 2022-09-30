<?php
function oneGeneric($zielID,$target,$id) {
  # Lade Sequence Datei in String
  $sequence = file_get_contents('../sequence_v1/'.$target.'.sequence');
  $mapping = file('../mapping_v1/'.$target.'.mapping');
  # Datensatz aus DB holen

  anbindung_db($verbindung);
  $result=$verbindung->query("SELECT * from {$target} where {$id}='{$zielID}'");
  if($result->rowCount()) { # Daten gefunden Anpassung im String vornehmen
	$ergebnis=$result->fetch(PDO::FETCH_ASSOC);
    
    foreach($mapping as $map){
        $dummy=explode('=',$map);
        # crlf entfernen vom Mapping entfernen sonst wird es nicht als Datenfeld genommen
        $dummy[1]= str_replace(array("\r\n", "\n", "\r"), '', $dummy[1]); # CRLF entfernen
        # Aufbereiten für JSON
        $dummy1 = str_replace('"', "'", $ergebnis[$dummy[1]]); # Text Gänsefüsschen raus gegen '
        $dummy1 = str_replace(array("\r\n", "\n", "\r"), ' ', $dummy1); # CRLF gegen Leerzeichen falls vorhanden
        $sequence=str_replace($dummy[0],stripslashes($dummy1), $sequence);
    }
    #Rückgabe JSON
    return ''.$sequence.'';
  }
  return 'error';
}
# Thats all Folkss
?>