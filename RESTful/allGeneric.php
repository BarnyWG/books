<?php
function allGeneric($target,$id) {
  # Lade Sequence Datei in String
  $sequence = file_get_contents('./'.$target.'.sequence');
  $mapping = file('./'.$target.'.mapping');
  # Datensatz aus DB holen

  anbindung_db($verbindung);
  $result=$verbindung->query("SELECT * from {$target}");
  $i2 = $result->rowCount();
  $t2 = 0;
  $all = '{';
  if($result->rowCount()) { # Daten gefunden Anpassung im String vornehmen

    $zeilen=$result->fetchAll(PDO::FETCH_ASSOC);
    foreach($zeilen as $ergebnis){
        $CopyOfSequence = $sequence;  
        foreach($mapping as $map){
            $dummy=explode('=',$map);
            # crlf entfernen vom Mapping entfernen sonst wird es nicht als Datenfeld genommen
            $dummy[1]= str_replace(PHP_EOL, '', $dummy[1]); # CRLF entfernen
            # Aufbereiten für JSON
            $dummy1 = str_replace('"', "'", $ergebnis[$dummy[1]]); # Text Gänsefüsschen raus gegen '
            $dummy1 = str_replace(PHP_EOL, ' ', $dummy1); # CRLF gegen Leerzeichen falls vorhanden
            $CopyOfSequence=str_replace($dummy[0],stripslashes($dummy1), $CopyOfSequence);
        }
        $all .= $CopyOfSequence;
        $t2 ++;
        if($t2<$i2) $all .=',';
    }
    #Rückgabe JSON
    return $all .='}';
  }
  return 'error';
}
# Thats all Folkss
?>