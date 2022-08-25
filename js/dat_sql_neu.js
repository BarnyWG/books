var operation="=";
var logik="AND";

function transfer()
{
  var position=$('auswahl').length;
  var Eintrag = document.createElement("option");
  Eintrag.text = $('felder').value;
  Eintrag.value = $('felder').value;
  if($('felder').value.length > 0)
  {
    $('auswahl').options[position] =Eintrag;
  }
  else
  alert("Bitte ein DB-Feld auswählen!");
}

function loeschen()
{
  if($('auswahl').value.length > 0)
  {
  	$('auswahl').remove($('auswahl').selectedIndex);
  }
}

function auswahl_up()
{
  var eintrag_1 = document.createElement("option");
  var eintrag_2 = document.createElement("option");
  var eintrag_dummy = document.createElement("option");  
  if($('auswahl').length > 1)
  {
  	select=$('auswahl').selectedIndex;
  	if(select > 0)
  	{
  	  eintrag_1=$('auswahl').options[select];
  	  eintrag_2=$('auswahl').options[select-1];
	  $('auswahl').options[select]=eintrag_dummy;
	  $('auswahl').options[select-1]=eintrag_1;
  	  $('auswahl').options[select]=eintrag_2;  
  	}
  }
}

function auswahl_down()
{
  var eintrag_1 = document.createElement("option");
  var eintrag_2 = document.createElement("option");
  var eintrag_dummy = document.createElement("option");   
  if($('auswahl').length > 1)
  {
  	select=$('auswahl').selectedIndex;
  	if(select < $('auswahl').length)
  	{
  	  eintrag_1=$('auswahl').options[select];
  	  eintrag_2=$('auswahl').options[select+1];
	  $('auswahl').options[select]=eintrag_dummy;
  	  $('auswahl').options[select+1]=eintrag_1;
	  $('auswahl').options[select]=eintrag_2;  	    
  	}
  }
}

function where()
{
  if($('felder').value.length > 0)
  {
    $('bedingungsfeld').value=$('felder').value;
  }
  else
  alert("Bitte ein DB-Feld auswählen!");
}

function operator(op)
{
  operation=op;
  $('aktueller_op').value = op;
}

function transfer_where()
{
  if($('bedingungsfeld').value.length > 0)
  var position=$('sel_where').length;
  var Eintrag = document.createElement("option");
  Eintrag.text = logik+" "+$('bedingungsfeld').value+" "+operation+" '"+$('suchwert').value+"'";
  Eintrag.value = logik+" "+$('bedingungsfeld').value+" "+operation+" '"+$('suchwert').value+"'";
  if($('suchwert').value.length > 0 && $('bedingungsfeld').value.length > 0)
  {
    $('sel_where').options[position]=Eintrag;
  }
  else
  alert("Kann Bedingung nicht erstellen!\nWenigstens ein benötigtes Feld ist Leer!");
}

function transfer_where_zw()
{
  var position=$('sel_where').length;
  var Eintrag = document.createElement("option");
  Eintrag.text = logik+" "+$('bedingungsfeld').value+" between '"+$('zwischen1').value+"' AND '"+$('zwischen2').value+"'";
  Eintrag.value = logik+" "+$('bedingungsfeld').value+" between '"+$('zwischen1').value+"' AND '"+$('zwischen2').value+"'";
  if($('zwischen1').value.length > 0 && $('zwischen2').value.length >0 && $('bedingungsfeld').value.length > 0)
  {
    $('sel_where').options[position]=Eintrag;
  }
  else
  alert("Kann Bedingung nicht erstellen!\nWenigstens ein benötigtes Feld ist Leer!");
}
function where_loesch()
{
  if($('sel_where').value.length > 0)
  {
  	$('sel_where').remove($('sel_where').selectedIndex);
  }
}

function where_up()
{
  var eintrag_1 = document.createElement("option");
  var eintrag_2 = document.createElement("option");
  var eintrag_dummy = document.createElement("option");  
  if($('sel_where').length > 1)
  {
  	select=$('sel_where').selectedIndex;
  	if(select > 0)
  	{
  	  eintrag_1=$('sel_where').options[select];
  	  eintrag_2=$('sel_where').options[select-1];
	  $('sel_where').options[select]=eintrag_dummy;
	  $('sel_where').options[select-1]=eintrag_1;
  	  $('sel_where').options[select]=eintrag_2;  
  	}
  }
}

function where_down()
{
  var eintrag_1 = document.createElement("option");
  var eintrag_2 = document.createElement("option");
  var eintrag_dummy = document.createElement("option");   
  if($('sel_where').length > 1)
  {
  	select=$('sel_where').selectedIndex;
  	if(select < $('sel_where').length)
  	{
  	  eintrag_1=$('sel_where').options[select];
  	  eintrag_2=$('sel_where').options[select+1];
	  $('sel_where').options[select]=eintrag_dummy;
  	  $('sel_where').options[select+1]=eintrag_1;
	  $('sel_where').options[select]=eintrag_2;  	    
  	}
  }
}

function oder(log)
{
  logik=log;
  $('aktueller_lop').value=log;
}

function sql_abfrage(mode)
{
  var auswahlfelder="";
  var where_bedingungen="";
  var order_bedingungen="";
  var sql_befehl="";
  var tabellen="";
  var i;
  if($('auswahl').length > 0)
  {
    for(i=0;i < $('auswahl').length;i++)
    {
      auswahlfelder += $('auswahl').options[i].text + ",";
    }
    if($('sel_where').length > 0)
    {
    	for(i=0;i < $('sel_where').length;i++)
    	{
      		where_bedingungen += $('sel_where').options[i].text + " ";
    	}
    where_bedingungen = where_bedingungen.substring(4,where_bedingungen.length);
    }
    auswahlfelder = auswahlfelder.substring(0,auswahlfelder.length-1);
    if (auswahlfelder.indexOf("book")> -1 || where_bedingungen.indexOf("book")> -1 )
    {
      tabellen = "book,";
    }
    if (auswahlfelder.indexOf("ll_bo_au")> -1 || where_bedingungen.indexOf("ll_bo_au")> -1 )
    {
      tabellen += "ll_bo_au,";
    }
    if (auswahlfelder.indexOf("autor")> -1 || where_bedingungen.indexOf("autor")> -1 )
    {
      tabellen += "autor,";
    }
    if (auswahlfelder.indexOf("book_series")> -1 || where_bedingungen.indexOf("book_series")> -1 )
    {
      tabellen += "book_series,";
    }
    if (auswahlfelder.indexOf("genre")> -1 || where_bedingungen.indexOf("genre")> -1 )
    {
      tabellen += "genre,";
    }
    if (auswahlfelder.indexOf("storage")> -1 || where_bedingungen.indexOf("storage")> -1 )
    {
      tabellen += "storage,";
    }
    if (auswahlfelder.indexOf("cover")> -1 || where_bedingungen.indexOf("cover")> -1 )
    {
      tabellen += "cover,";
    }
    if (auswahlfelder.indexOf("bind")> -1 || where_bedingungen.indexOf("bind")> -1 )
    {
      tabellen += "bind,";
    }
    if (auswahlfelder.indexOf("publisher")> -1 || where_bedingungen.indexOf("publisher")> -1 )
    {
      tabellen += "publisher,";
    }
    for(i=0;i < $('sel_order').length;i++)
    {
      order_bedingungen += $('sel_order').options[i].text + ", ";
    }
    

    tabellen = tabellen.substring(0,tabellen.length-1);
    sql_befehl= auswahlfelder+" FROM "+tabellen;
    if(where_bedingungen.length >0) sql_befehl+=" WHERE "+where_bedingungen;
    if(order_bedingungen.length)
    {
    	sql_befehl += " ORDER BY "+order_bedingungen.substring(0,order_bedingungen.length-2);
    }
    
    switch(mode)
    {
    	case 'csv':
    	{
    	  	parent.display2('dat_sql_call.php?sqlbefehl=' + sql_befehl + '&mode=csv');
    	  	break;
    	}
		case 'pdf':
    	{
    	  	parent.display2('dat_sql_call.php?sqlbefehl=' + sql_befehl + '&mode=pdf');
    	  	break;
    	}
    	case 'xlsx':
    	{
    	  	parent.display2('dat_sql_call.php?sqlbefehl=' + sql_befehl + '&mode=xlsx');
    	  	break;
    	}    	
    	default:
    	{	
    		parent.display2('dat_sql_call.php?sqlbefehl=' + sql_befehl);
    	}
    }
  }
}

function feld_gleich(welches_feld)
{
  if($('felder').value.length > 0)
  {
    if(welches_feld=="1")
    {
      $('feld_gleich1').value=$('felder').value;
    }
    else
      $('feld_gleich2').value=$('felder').value;
  }
  else
  alert("Bitte ein DB-Feld auswählen!");
}

function transfer_gleich()
{
  var position=$('sel_where').length;
  var Eintrag = document.createElement("option");
  Eintrag.text = logik+" "+$('feld_gleich1').value+" = "+$('feld_gleich2').value;
  Eintrag.value = logik+" "+$('feld_gleich1').value+" = "+$('feld_gleich2').value;
  if($('feld_gleich1').value.length > 0 && $('feld_gleich2').value.length > 0)
  {
    $('sel_where').options[position]=Eintrag;
  }
  else
  alert("Kann Bedingung nicht erstellen!\nWenigstens ein benötigtes Feld ist Leer!");
}

function order_loesch()
{
  if($('sel_order').value.length > 0)
  {
  	$('sel_order').remove($('sel_order').selectedIndex);
  }
}

function transfer_order()
{
  var position=$('sel_order').length;
  var Eintrag = document.createElement("option");
  Eintrag.text = $('felder').value;
  Eintrag.value = $('felder').value;
  if($('felder').value.length > 0)
  {
    $('sel_order').options[position]=Eintrag;
  }
  else
  alert("Bitte ein DB-Feld auswählen!");
}

function order_up()
{
  var eintrag_1 = document.createElement("option");
  var eintrag_2 = document.createElement("option");
  var eintrag_dummy = document.createElement("option");  
  if($('sel_order').length > 1)
  {
  	select=$('sel_order').selectedIndex;
  	if(select > 0)
  	{
  	  eintrag_1=$('sel_order').options[select];
  	  eintrag_2=$('sel_order').options[select-1];
	  $('sel_order').options[select]=eintrag_dummy;
	  $('sel_order').options[select-1]=eintrag_1;
  	  $('sel_order').options[select]=eintrag_2;  
  	}
  }
}

function order_down()
{
  var eintrag_1 = document.createElement("option");
  var eintrag_2 = document.createElement("option");
  var eintrag_dummy = document.createElement("option");   
  if($('sel_order').length > 1)
  {
  	select=$('sel_order').selectedIndex;
  	if(select < $('sel_order').length)
  	{
  	  eintrag_1=$('sel_order').options[select];
  	  eintrag_2=$('sel_order').options[select+1];
	  $('sel_order').options[select]=eintrag_dummy;
  	  $('sel_order').options[select+1]=eintrag_1;
	  $('sel_order').options[select]=eintrag_2;  	    
  	}
  }
}
// Speicherfunktionen Html5 Supercookie
storage=false;

window.onload = storage_init;

function storage_init()
{
	if(typeof(localStorage) == 'undefined' || typeof(localStorage) == 'unknown')
	{
	  alert('Speichern nicht möglich. Browser unterstützt kein LokalStorage!');
	}
	else
	{
		storage=true;
		init_slots(9);
	}  
}

function sql_abfrage_write(slot)
{
  if(!storage){alert('Speichern nicht möglich. Browser unterstützt kein LokalStorage!'); return;}
  
  beschreibung=$('speichername'+slot).value;
  feldzahl=$('auswahl').length;
  wherezahl=$('sel_where').length;
  orderzahl=$('sel_order').length;
  localStorage.setItem('Slot'+slot+'_beschreibung',beschreibung);
  localStorage.setItem('Slot'+slot+'_feldzahl',feldzahl);  
  localStorage.setItem('Slot'+slot+'_wherezahl',wherezahl);
  localStorage.setItem('Slot'+slot+'_orderzahl',orderzahl);
  // Ausgewählte Felder speichern
  for(i=0;i < $('auswahl').length;i++)
  {
     localStorage.setItem('Slot'+slot+'_feld'+i,$('auswahl').options[i].text);
  }
  // Ausgewählte Where Bedingungen speichern
  for(i=0;i < $('sel_where').length;i++)
  {
     localStorage.setItem('Slot'+slot+'_where'+i,$('sel_where').options[i].text);
  }
  // Order By Felder speichern
  for(i=0;i < $('sel_order').length;i++)
  {
     localStorage.setItem('Slot'+slot+'_order'+i,$('sel_order').options[i].text);
  }
  alert('Gespeichert');
}  

function sql_abfrage_read(slot)
{
	feldzahl=localStorage.getItem('Slot'+slot+'_feldzahl');  
    wherezahl=localStorage.getItem('Slot'+slot+'_wherezahl');
	orderzahl=localStorage.getItem('Slot'+slot+'_orderzahl');
  // Ausgewählte Felder laden
  for(i=0;i < feldzahl;i++)
  {
     add_element_auswahl(localStorage.getItem('Slot'+slot+'_feld'+i));
  }	
  // Ausgewählte Where Bedingungen laden
  for(i=0;i < wherezahl;i++)
  {
  	 add_element_sel_where(localStorage.getItem('Slot'+slot+'_where'+i));
  }
  // Order BY Felder laden
  for(i=0;i < orderzahl;i++)
  {
  	 add_element_sel_order(localStorage.getItem('Slot'+slot+'_order'+i));
  }	  	
}

function add_element_sel_where(element)
{
  var Eintrag = document.createElement("option");
  Eintrag.text=element;
  Eintrag.value=element;
  $('sel_where').options[$('sel_where').length]=Eintrag;
}

function add_element_sel_order(element)
{
  var Eintrag = document.createElement("option");
  Eintrag.text=element;
  Eintrag.value=element;
  $('sel_order').options[$('sel_order').length]=Eintrag;
}

function add_element_auswahl(element)
{
  var Eintrag = document.createElement("option");
  Eintrag.text=element;
  Eintrag.value=element;
  $('auswahl').options[$('auswahl').length]=Eintrag;
}

function init_slots(anzahl_slots)
{

  for(slot=1;slot<=anzahl_slots;slot++)
  {
    information_slots(slot);
  }
}

function information_slots(slot)
{
  var beschreibung = $('speichername'+slot);
  beschreibung.value =  localStorage.getItem('Slot'+slot+'_beschreibung');
}