<?php
@session_start();
if($_SESSION["s_us_level"] <"7")
{
  include("inc/zugriff_verw.inc");
}
else 
{
require("anbindung_db.php");
require("inc/kopf_u_fuss.php");

#Daten holen
$alles_io=true;
if(isset($_REQUEST['sqlbefehl']))
  $strsql=$_REQUEST['sqlbefehl'];
else
{  $strsql=''; die("Kein Befehl gefunden");}
if(isset($_REQUEST['mode']))
	$mode=$_REQUEST['mode']; 
else
  $mode='';
   
  // main

  $strsql = "SELECT ".str_replace("*","%",str_replace("?","_",$strsql));
  if (strlen($strsql)>0 && $mode=='')
  {
    anbindung_db($anbindung);
    $RS1 = $anbindung->query($strsql);
    if($RS1->rowCount())
    {
    	html_kopf("Ergebnistabelle Abfrage");
	    echo $strsql;
	    echo '<table class="tabellen_einstellungen"><tr>';
    	for ($i = 0; $i < $RS1->columnCount(); $i++)
    	{
    		$meta=$RS1->getColumnMeta($i);
    		echo '<th class="tabellenkopf">'.$meta['name'].'</th>';
    	}
    	echo "</tr>\n";
    	$t=0;
    	$rows = $RS1->fetchAll();
		  foreach ( $rows as $zeile)   # solange bis alle Datensätze dargestellt sind ausgeben
			{
    		echo '<tr ';
    		if (($t % 2)==0)
      			echo  'class="tabellenzeile_odd">';
    		else
      			echo  'class="tabellenzeile_even">';
    		$t += 1;
    		for ($i = 0; $i < $RS1->columnCount(); $i++)
    		    echo '<td>'.$zeile[$i].'</td>';
    		echo "</tr>\n";
    	}
    	echo "</table><br />Anzahl gefundener Datensätze : ".$RS1->rowCount();
    	html_fuss();
    }	
    else
    {
    	html_kopf("Abfrage ohne Ergebnis");
    	print "<h1>Die Abfrage brachte kein Ergebnis</h1>";
    	print "Rückmeldung: $RS1<br />";
    	print "Überprüfen sie die Zusammenstellung<br />";
    	print $strsql;
    	html_fuss();
    }
    anbindung_schliessen($anbindung);
  }
  elseif (strlen($strsql)>0 && $mode=='csv')
  {
    anbindung_db($anbindung);
    $RS1 = $anbindung->query($strsql);
    if($RS1->rowCount())
    {    
		header( "Content-Type: test/csv" ); 
		header( "Content-Disposition: attachment; filename=Abfrage.csv"); 
		header( "Content-Description: csv File" ); 
		header( "Pragma: no-cache" ); 
		header( "Expires: 0" );  
	    for ($i = 0; $i < $RS1->columnCount(); $i++)
	    {
	    	$meta = $RS1->getColumnMeta($i);
	    	echo $meta['name'].';';
	    }
    	echo "\n";
    	$t=0;
    	$rows = $RS1->fetchAll();
		foreach ( $rows as $zeile)   # solange bis alle Datensätze dargestellt sind ausgeben
		{    		   		
    		for ($i = 0; $i < $RS1->columnCount(); $i++)
    		    echo $zeile[$i].';';
    		echo "\n";
    	}
    	echo "Ausgeführter SQL-Befehl war {$strsql}";
    }	
    anbindung_schliessen($anbindung);  	
  }
  /* ExcelExport */
  elseif (strlen($strsql)>0 && $mode=='xlsx')
  {
  /** Include PHPExcel */
	include ('../Classes/PHPExcel.php');
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();
	$worksheet = $objPHPExcel->getActiveSheet();
    
    /* DB Daten Holen und in Sheet einfügen */
    anbindung_db($anbindung);
    $RS1 = $anbindung->query($strsql);
    if($RS1->rowCount())
    {    
	    for ($i = 0; $i < $RS1->columnCount(); $i++)
	    	/* in Excel Kopfspalte einfügen */
		{
			// Inhalt
			$meta = $RS1->getColumnMeta($i);
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, 1, $meta['name']);
			// Fette Schrift
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getFont()->setBold(true);
			// Dünner Rahmen
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
			// Cell Hintergrund Farbe			
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,1)->getFill()->getStartColor()->setARGB('FFC0C0FF');
			
	
		}
    $t=$i;
    $rows = $RS1->fetchAll();
    $x=0;
		foreach ( $rows as $zeile)   # solange bis alle Datensätze dargestellt sind ausgeben
		{   
			for ($i = 0; $i < $RS1->columnCount(); $i++)
			{
    		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $x+2,$zeile[$i]);  // Ausgabe nach Excel ohne Konvertierung Funktioniert  		
 				// Dünner Rahmen
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$x+2)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$x+2)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$x+2)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
				// Cell Hintergrund Farbe			
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$x+2)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				if (($x % 2)==0)
    			$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$x+2)->getFill()->getStartColor()->setARGB('FFF0F0F0');
    		else
      		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($i,$x+2)->getFill()->getStartColor()->setARGB('FFC0C0C0');
    	}
    	$x++;
		}

    	for ($i =0; $i < $t;$i++)
    	{
    	 //	$calculatedWidth = $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->getWidth();
    	  $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($i)->setAutoSize(true);
    	}	
    	 	$objPHPExcel->getActiveSheet()->calculateColumnWidths();
    	
    	
    	//echo "Ausgeführter SQL-Befehl war {$strsql}";
    }	
    anbindung_schliessen($anbindung);  	
	/* Vorbereitung Header für Excel Datei */
//	header("Pragma: public");
//	header("Expires: 0");
//	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
//	header("Content-Type: application/force-download");
//	header("Content-Type: application/octet-stream");
//	header("Content-Type: application/download");;
//	header("Content-Disposition: attachment;filename=sql_abfrage.xlsx"); 
//	header("Content-Transfer-Encoding: binary ");
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="sql_abfrage.xlsx"');
	header('Cache-Control:max-age=0');
	
	/* und Ausgeben*/
	// $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	// $objWriter->setPreCalculateFormulas(false);
	// $objWriter->save('php://output');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');    
    
  }
  else
  {
  html_kopf();	
  echo "<h1>Keine Parameter ! Fehler !</h1>";
  html_fuss();
  }
}
?>