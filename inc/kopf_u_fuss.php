<?php
function html_kopf($title="No Title",$script=false,$special_script="",$special_css="",$special_script2="")
/*
 * $title = generiert den Titel der Seite
 * $script = gibt an ob das Standard Script general.js eingebunden wird
 * $special_script = gibt ein weiteres Script an das eingebunden werden soll mit relativen pfad
 * $special_css = gibt das zusätzliche CSS an
 * $special_script2 = gibt ein weiteres Script an das eingebunden werden soll mit relativen pfad
 * 
 * bei nicht angabe Default wert oder keine Aktion
 */
{
  print "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"\n";
  print "\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
  print "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
  print "<head>\n";
  print "<title>{$title}</title>\n";
  print "<meta name=\"author\" content=\"Bernd W. Go&szlig;mann\" />\n";
  print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
  print "<link rel=\"shortcut icon\" href=\"grafik/books.ico\" />\n";    
  print "<link rel=\"stylesheet\" href=\"css/general.css\" type=\"text/css\" />\n";
  if($special_css<>'')
  {
  	print "<link rel=\"stylesheet\" href=\"$special_css\" type=\"text/css\" />\n";
  }
  if($script)
  {
    print "<script type=\"text/javascript\" src=\"js/general.js\"></script>\n";	
  }
  if($special_script<>'')
  {
  	print "<script type=\"text/javascript\" src=\"$special_script\"></script>\n";
  }
  if($special_script2<>'')
  {
  	print "<script type=\"text/javascript\" src=\"$special_script2\"></script>\n";
  }

  print "</head>\n";
  print "<body>\n";
}

function html5_kopf($title="No Title",$script=false,$special_script="",$special_css="",$special_script2="")
/*
 * $title = generiert den Titel der Seite
 * $script = gibt an ob das Standard Script general.js eingebunden wird
 * $special_script = gibt ein weiteres Script an das eingebunden werden soll mit relativen pfad
 * $special_css = gibt das zusätzliche CSS an
 * $special_script2 = gibt ein weiteres Script an das eingebunden werden soll mit relativen pfad
 * 
 * bei nicht angabe Default wert oder keine Aktion
 */
{
  print "<!DOCTYPE html>\n";
  print "<html>\n";
  print "<head>\n";
  print "<title>{$title}</title>\n";
  print "<meta name=\"author\" content=\"Bernd W. Go&szlig;mann\">\n";
  print "<meta charset=\"utf-8\">\n";
  print "<link rel=\"shortcut icon\" href=\"grafik\\books.ico\">\n";  
  print "<link rel=\"stylesheet\" href=\"css/general.css\" type=\"text/css\">\n";
  if($special_css<>'')
  {
  	print "<link rel=\"stylesheet\" href=\"$special_css\" type=\"text/css\">\n";
  }
  if($script)
  {
    print "<script type=\"text/javascript\" src=\"js/general.js\"></script>\n";	
  }
  if($special_script<>'')
  {
  	print "<script type=\"text/javascript\" src=\"$special_script\"></script>\n";
  }
  if($special_script2<>'')
  {
  	print "<script type=\"text/javascript\" src=\"$special_script2\"></script>\n";
  }

  print "</head>\n";
  print "<body>\n";
}
function html_fuss()
{
  print "</body>\n";
  print "</html>\n";	
}
?>