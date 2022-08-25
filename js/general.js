function $(id)
{
  return document.getElementById(id);
}

/*
 * Program (C) by Bernd W. Go�mann
 * eMail bwg@wolfsburg.de
 * Javascript für allgemeine Funktionen
*/

function int_k_test(dezi) // Test ob Integer bzw Ganzzahl ohne Vorzeichen
{
  l =dezi.length;
  for(i=0;i < l;i++)
    if((dezi[i]>="0" && dezi[i]<="9"))
    {
      // okay
    }
    else return false;  
  return true;
}

function float_k_test(dezi) // Test ob Fließkommazahl ohne Vorzeichen
{
  l =dezi.length;
  for(i=0;i < l;i++)
    if((dezi[i]>="0" && dezi[i]<="9") || (dezi[i]==",") || (dezi[i]=="."))
    {}
    else return false;
  return true;
}

function isbn_test(isbn)  // Testet ob Zeichen in ISBN zulässig
{  
  var rueck='';
  l =isbn.length;
  for(i=0;i < l;i++)
    if((isbn[i]>="0" && isbn[i]<="9") || (isbn[i]=="X") || (isbn[i]=="x") || (isbn[i]=="-"))
      rueck += isbn[i];
  return rueck;
}

function feld_highlight(objekt) // Hintergrund Farbe ändern zum Hervorheben des Objektes
{
  objekt.style.backgroundColor ='orange';
}

function feld_highlight_off(objekt) //// Hintergrund Farbe zurücksetzen auf Weiss
{
  objekt.style.backgroundColor ='white';
}

function reinige_ziffernfolge(pin) // ISBN Code für Check aufbereiten
{
  var i;
  var dummy="";
  for(i=0;i<=pin.length;i++) // Alles Raus was nicht zu EAN gehört ausser X falls alte ISBN nummer EAN 10
    {
      if((pin.charAt(i)>="0") && (pin.charAt(i)<="9") || pin.charAt(i)=="X" || pin.charAt(i)=="x" )
        {
          dummy=dummy + pin.charAt(i);
        }
     }
  return dummy
}

function isbn_k_test(ziffer)   /* Prüft ob der ISBN Code Fehler enthält/korrekt ist gibt true zurück wenn io */
{
  var summe;
  var pr_ziffer;
  var ean_type;
  var pin;
  
  pin=reinige_ziffernfolge(ziffer);
  
  if(pin.length==13)
    ean_type=13;
  else if(pin.length==10)
    ean_type=10;
  else
  	return false  
  
  if(ean_type==13)  // Check nach EAN-13
  {
    summe = pin.charAt(0) * 1 + pin.charAt(1) * 3 + pin.charAt(2) * 1 + pin.charAt(3) * 3 + pin.charAt(4) * 1; 
    summe += pin.charAt(5) * 3 + pin.charAt(6) * 1 + pin.charAt(7) * 3 + pin.charAt(8) * 1;
    summe += pin.charAt(9) * 3 + pin.charAt(10) * 1 + pin.charAt(11) * 3;
    pr_ziffer = 10 - summe % 10;
    if(pr_ziffer==10) pr_ziffer=0;
    if(pr_ziffer == pin.charAt(12))
    	return true;
    else return false;	
  }
  else if(ean_type==10)  // Check nach ISBN 10 ,hier kann die Prüfsumme X sein
  {
    summe = pin.charAt(0) * 1 + pin.charAt(1) *2 + pin.charAt(2) * 3 + pin.charAt(3) *4 + pin.charAt(4) * 5; 
    summe += pin.charAt(5) *6 + pin.charAt(6) * 7 + pin.charAt(7) *8 + pin.charAt(8) * 9;
    pr_ziffer = summe % 11;
    if(pr_ziffer == pin.charAt(9) || (pr_ziffer==10) && pin.charAt(9)=='x' || pin.charAt(9)=='X')
    	return true;
    else return false;	    
  }
}

function isbn_pz(ziffer)   /* Generiert die Prüfziffer des ISBN Code*/
{
  var summe;
  var pr_ziffer;
  var ean_type;
  var pin;
  
  pin=reinige_ziffernfolge(ziffer);
  
  if(pin.length==12)
    ean_type=13;
  else if(pin.length==9)
    ean_type=10;
  else
  	return false  
  
  if(ean_type==13)  // Check nach EAN-13
  {
    summe = pin.charAt(0) * 1 + pin.charAt(1) * 3 + pin.charAt(2) * 1 + pin.charAt(3) * 3 + pin.charAt(4) * 1; 
    summe += pin.charAt(5) * 3 + pin.charAt(6) * 1 + pin.charAt(7) * 3 + pin.charAt(8) * 1;
    summe += pin.charAt(9) * 3 + pin.charAt(10) * 1 + pin.charAt(11) * 3;
    pr_ziffer = 10 - summe % 10;
    if(pr_ziffer==10) pr_ziffer=0;
    return pr_ziffer;
  }
  else if(ean_type==10)  // Check nach ISBN 10 , hier kann die Prüfsumme X sein
  {
    summe = pin.charAt(0) * 1 + pin.charAt(1) * 2 + pin.charAt(2) * 3 + pin.charAt(3) *4 + pin.charAt(4) * 5; 
    summe += pin.charAt(5) * 6 + pin.charAt(6) * 7 + pin.charAt(7) * 8 + pin.charAt(8) * 9;
    pr_ziffer = summe % 11;
	if(pr_ziffer==10) { pr_ziffer='X' };
  	return pr_ziffer;
  }
}

function isbn_10_to_ean_13(isbn)
{
  var pin;
  var pz;
  pin=reinige_ziffernfolge(isbn)
  if(pin.length== 10)
  {
    pin=pin.substring(0,9);
  }
  pz=isbn_pz('978'+pin);
  return '978'+pin+pz;
}
