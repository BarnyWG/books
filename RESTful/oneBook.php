<?php
function oneBook($zielID) {
  # Lade Sequence Datei in String
  $sequence = file_get_contents('./book.sequence');
  # Datensatz aus DB holen
  anbindung_db($verbindung);
  $result=$verbindung->query("SELECT * from book where bo_id='{$zielID}'");
  if($result->rowCount()) { # Buch gefunden Anpassung im String vornehmen
	  $ergebnis=$result->fetch(PDO::FETCH_OBJ);

    # eventuell anstatt der reinen zahlen z.B. 'HTTP://books/restful/autor/1' also Resorcelinks bei allen IDs
    $sequence=str_replace('%bo_id%',stripslashes($ergebnis->bo_id), $sequence);
    $sequence=str_replace('%bo_co_id%',stripslashes($ergebnis->bo_co_id), $sequence);
    $sequence=str_replace('%bo_ge_id%',stripslashes($ergebnis->bo_ge_id), $sequence);
    $sequence=str_replace('%bo_pb_id%',stripslashes($ergebnis->bo_pb_id), $sequence);
    $sequence=str_replace('%bo_st_id%',stripslashes($ergebnis->bo_st_id), $sequence);
    $sequence=str_replace('%bo_st_id_dc%',stripslashes($ergebnis->bo_st_id_dc), $sequence);
    $sequence=str_replace('%bo_bi_id%',stripslashes($ergebnis->bo_bi_id), $sequence);
    $sequence=str_replace('%bo_bs_id%',stripslashes($ergebnis->bo_bs_id), $sequence);
    # Aufbereiten für JSON
    $dummy1 = str_replace('"', "'", $ergebnis->bo_title); # Text Gänsefüsschen raus
    $dummy1 = str_replace(PHP_EOL, ' ', $dummy1); # CRLF gegen Leerzeichen
    $sequence=str_replace('%bo_title%',stripslashes($dummy1), $sequence); # Text Gänsefüsschen raus
    # Aufbereiten für JSON
    $dummy2 = str_replace('"', "'", $ergebnis->bo_print_run); # Text Gänsefüsschen raus
    $dummy2 = str_replace(PHP_EOL, ' ', $dummy2); # CRLF gegen Leerzeichen
    $sequence=str_replace('%bo_print_run%',stripslashes($dummy2), $sequence); # Text Gänsefüsschen raus
    $sequence=str_replace('%bo_isbn%',stripslashes($ergebnis->bo_isbn), $sequence);
    $sequence=str_replace('%bo_height%',stripslashes($ergebnis->bo_height), $sequence);
    $sequence=str_replace('%bo_width%',stripslashes($ergebnis->bo_width), $sequence);
    $sequence=str_replace('%bo_deep%',stripslashes($ergebnis->bo_deep), $sequence);
    $sequence=str_replace('%bo_price%',stripslashes($ergebnis->bo_price), $sequence);
    $sequence=str_replace('%bo_weight_gr%',stripslashes($ergebnis->bo_weight_gr), $sequence);
    $sequence=str_replace('%bo_conferred%',stripslashes($ergebnis->bo_conferred), $sequence);
    # Aufbereiten für JSON
    $dummy3 = str_replace('"', "'", $ergebnis->bo_comment); # Text Gänsefüsschen raus
    $dummy3 = str_replace(PHP_EOL, ' ', $dummy3); # CRLF gegen Leerzeichen
    $sequence=str_replace('%bo_comment%',stripslashes($dummy3), $sequence); 

    # autoeren holen und einfügen
    $result=$verbindung->query("SELECT ll_bo_au_au_id from ll_bo_au where ll_bo_au_bo_id='{$zielID}'");
    $autoren="";
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    $i = count($rows);
    $t = 0;
    foreach ($rows as $ergebnis){
      $t ++;
      $autoren .=stripslashes($ergebnis["ll_bo_au_au_id"]);
      if ($t<$i) $autoren .=',';
    }
    $sequence=str_replace('$authors$', $autoren, $sequence);
    #Rückgabe JSON
    return '{'.$sequence.'}';
  }
  return 'error';
}
# Thats all Folks
?>