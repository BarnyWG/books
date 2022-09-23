<?php
function allBooks() {
    # Lade Sequence Datei in String
    $sequence = file_get_contents('./book.sequence');
    # Datensatz aus DB holen
    anbindung_db($verbindung);
    $result=$verbindung->query("SELECT * from book");
    $i2 = $result->rowCount();
    $t2 = 0;
    $all = '{';
    if($result->rowCount()){ # Buch gefunden Anpassung im String vornehmen

    	$zeilen=$result->fetchAll(PDO::FETCH_OBJ);
 
        foreach($zeilen as $ergebnis){
            $CopyOfSequence = $sequence;
        # eventuell anstatt der reinen zahlen z.B. 'HTTP://books/restful/autor/1' also Resorcelinks bei allen IDs
            $CopyOfSequence=str_replace('%bo_id%',stripslashes($ergebnis->bo_id), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_co_id%',stripslashes($ergebnis->bo_co_id), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_ge_id%',stripslashes($ergebnis->bo_ge_id), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_pb_id%',stripslashes($ergebnis->bo_pb_id), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_st_id%',stripslashes($ergebnis->bo_st_id), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_st_id_dc%',stripslashes($ergebnis->bo_st_id_dc), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_bi_id%',stripslashes($ergebnis->bo_bi_id), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_bs_id%',stripslashes($ergebnis->bo_bs_id), $CopyOfSequence);
            # Aufbereiten für JSON
            $dummy1 = str_replace('"', "'", $ergebnis->bo_title); # Text Gänsefüsschen raus
            $dummy1 = str_replace(PHP_EOL, ' ', $dummy1); # CRLF gegen Leerzeichen
            $CopyOfSequence=str_replace('%bo_title%',stripslashes($dummy1), $CopyOfSequence);
            # Aufbereiten für JSON
            $dummy2 = str_replace('"', "'", $ergebnis->bo_print_run); # Text Gänsefüsschen raus
            $dummy2 = str_replace(PHP_EOL, ' ', $dummy2); # CRLF gegen Leerzeichen
            $CopyOfSequence=str_replace('%bo_print_run%',stripslashes($dummy2), $CopyOfSequence); # Text Gänsefüsschen raus
            $CopyOfSequence=str_replace('%bo_isbn%',stripslashes($ergebnis->bo_isbn), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_height%',stripslashes($ergebnis->bo_height), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_width%',stripslashes($ergebnis->bo_width), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_deep%',stripslashes($ergebnis->bo_deep), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_price%',stripslashes($ergebnis->bo_price), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_weight_gr%',stripslashes($ergebnis->bo_weight_gr), $CopyOfSequence);
            $CopyOfSequence=str_replace('%bo_conferred%',stripslashes($ergebnis->bo_conferred), $CopyOfSequence);
            # Aufbereiten für JSON
            $dummy3 = str_replace('"', "'", $ergebnis->bo_comment); # Text Gänsefüsschen raus
            $dummy3 = str_replace(PHP_EOL, ' ', $dummy3); # CRLF gegen Leerzeichen
            $CopyOfSequence=str_replace('%bo_comment%',stripslashes($dummy3), $CopyOfSequence); # Text Gänsefüsschen raus
            
        # autoren holen und einfügen
            $result2=$verbindung->query("SELECT ll_bo_au_au_id from ll_bo_au where ll_bo_au_bo_id='{$ergebnis->bo_id}'");

            $autoren="";
            $rows = $result2->fetchAll(PDO::FETCH_ASSOC);
            $i = count($rows);
            $t = 0;
            foreach ($rows as $ergebnis){
                $t ++;
                $autoren .=stripslashes($ergebnis["ll_bo_au_au_id"]);
                if ($t<$i) $autoren .=',';
            }
            $CopyOfSequence=str_replace('$authors$', $autoren, $CopyOfSequence);
            $all .= $CopyOfSequence;
            $t2 ++;
            if($t2<$i2) $all .=',';
        }  # alle Bücher geholt
    }
    #Rückgabe alle Bücher als JSON 
    return $all .='}';
}
return 'error'
# Thats all Folks
?>