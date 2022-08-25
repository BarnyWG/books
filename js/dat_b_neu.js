function formular_senden()
{
 document.form1.submit();
}

function load_display2(source)
{
  obj=parent.document.getElementById('display2');
  obj.src=source;
}

function test_float(objekt)
{
  if(!float_k_test(objekt.value))
  {
    feld_highlight(objekt);
    return false;
  }
  else
  {
    feld_highlight_off(objekt);
    return true;
  }
}

function _10_to_13(objekt)
{
  var pin;
  var rueck;
  pin=isbn_10_to_ean_13(objekt.value)
  rueck=confirm('EAN='+pin+' Übernehmen?');
  if(rueck) objekt.value = pin;
}

function test_int(objekt)
{
  if(!int_k_test(objekt.value))
  {
    feld_highlight(objekt);
    return false;
  }
  else
  {
    feld_highlight_off(objekt);
    return true;    
  }
}

function test_isbn(objekt)
{
  if(!isbn_k_test(objekt.value))
  {
    feld_highlight(objekt);
    return false;
  }
  else
  {
    feld_highlight_off(objekt);
    return true;
  }
}

/* Neue Daten einfügen */
function new_data(aktion)
{
  switch(aktion)
  {
  	case 'storage':
    	load_display2("dat_r_neu.php?mode=b_neu")
    break;
  	case 'autor':
    	load_display2("dat_a_neu.php?mode=b_neu")
    break;
  	case 'publisher':
    	load_display2("dat_v_neu.php?mode=b_neu")
    break;
  	case 'serie':
    	load_display2("dat_s_neu.php?mode=b_neu")
    break;
  	case 'genre':
    	load_display2("dat_g_neu.php?mode=b_neu")
    break;
  	case 'cover':
    	load_display2("dat_c_neu.php?mode=b_neu")
    break;
  	case 'bind':
    	load_display2("dat_bi_neu.php?mode=b_neu")
    break;
  }
}  

/* Daten suchen und einfügen */
function search_data(aktion)
{
  switch(aktion)
  {
  	case 'storage':
    	load_display2("dat_r_search.php?mode=holen&suche=%")
    break;
  	case 'autor':
        load_display2("dat_a_search.php?mode=holen&suche=%");
    break;
    case 'storage_dc':    
    	load_display2("dat_r_search.php?mode=holen_dc&suche=%");
    break;
  	case 'publisher':
    	load_display2("dat_v_search.php?mode=holen&suche=%");
    break;
  	case 'serie':
    	load_display2("dat_s_search.php?mode=holen&suche=%"); 
    break;
  	case 'genre':
   		load_display2("dat_g_search.php?mode=holen&suche=%");    	
    break;
  	case 'cover':
		load_display2("dat_c_search.php?mode=holen&suche=%");    	
    break;
  	case 'bind':
		load_display2("dat_bi_search.php?mode=holen&suche=%");
    break;
  }
}
/* Regal Buch Übernehmen */
function uebernehme_r(id,name)
{
  var i= document.form1.anzahl_r.value;
  // Testen ob Eintrag schon vorhanden
  if(i==0)
  {
  
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_r.value = i;
  var anhang=$("ziel_r");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_r'+i);

  neuer_text= document.createTextNode(name+'  ');
  text.appendChild(neuer_text);
  
  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_r('zeile_r'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);


  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "st_id"+i;
  id_hidden.id = "st_id"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
  }
}

function raus_r(zeile)
{
   knoten=document.getElementById(zeile);
   knoten.parentNode.removeChild(knoten);
   document.form1.anzahl_r.value = 0;
}

/* Autoren Übernehmen */
function uebernehme_a(id,nachname,vorname)
{
  var i= document.form1.anzahl_a.value;
  // Testen ob Eintrag schon vorhanden
  for(t=1;t<=i;t++)
  {
     au_id="au_id"+t;
     try{
       if($(au_id).value == id)
         return false;
     } catch(e){}
  }
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_a.value = i;
  var anhang=$("ziel_a");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_a'+i);
  
  var linefeed = document.createElement("br");
  text.appendChild(linefeed);

  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_a('zeile_a'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);
    
  neuer_text= document.createTextNode(' '+nachname+' '+', '+vorname+'   ');
  text.appendChild(neuer_text);

  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "au_id"+i;
  id_hidden.id = "au_id"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
}

function raus_a(nummer)
{
   knoten=$(nummer);
   knoten.parentNode.removeChild(knoten);
}

/* Regal Datenträger Übernehmen */
function uebernehme_r_dc(id,name)
{
  var i= document.form1.anzahl_r_dc.value;
  // Testen ob Eintrag schon vorhanden
  if(i==0)
  {
  
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_r_dc.value = i;
  var anhang=$("ziel_r_dc");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_r_dc'+i);

  neuer_text= document.createTextNode(name+'  ');
  text.appendChild(neuer_text);
  
  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_r_dc('zeile_r_dc'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);

  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "st_id_dc"+i;
  id_hidden.id = "st_id_dc"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
  }
}

function raus_r_dc(zeile)
{
   knoten=$(zeile);
   knoten.parentNode.removeChild(knoten);
   document.form1.anzahl_r_dc.value = 0;
}

/* Serie Übernehmen */
function uebernehme_s(id,name)
{
  var i= document.form1.anzahl_s.value;
  // Testen ob Eintrag schon vorhanden
  if(i==0)
  {
  
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_s.value = i;
  var anhang=$("ziel_s");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_s'+i);

  neuer_text= document.createTextNode(name+' ');
  text.appendChild(neuer_text);

  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_s('zeile_s'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);

  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "bs_id"+i;
  id_hidden.id = "bs_id"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
  }
}

function raus_s(zeile)
{
   knoten=$(zeile);
   knoten.parentNode.removeChild(knoten);
   document.form1.anzahl_s.value = 0;
}

/* Verlag Übernehmen */
function uebernehme_v(id,name,location)
{
  var i= document.form1.anzahl_v.value;
  // Testen ob Eintrag schon vorhanden
  if(i==0)
  {
  
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_v.value = i;
  var anhang=$("ziel_v");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_v'+i);
  
  neuer_text= document.createTextNode(' '+name+' '+', '+location+'  ');
  text.appendChild(neuer_text);
  
  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_v('zeile_v'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);

  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "pb_id"+i;
  id_hidden.id = "pb_id"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
  }
}

function raus_v(zeile)
{
   knoten=$(zeile);
   knoten.parentNode.removeChild(knoten);
   document.form1.anzahl_v.value = 0;
}

/* Genre Übernehmen */
function uebernehme_g(id,name)
{
  var i= document.form1.anzahl_g.value;
  // Testen ob Eintrag schon vorhanden
  if(i==0)
  {
  
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_g.value = i;
  var anhang=$("ziel_g");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_g'+i);
  
  neuer_text= document.createTextNode(name+' ');
  text.appendChild(neuer_text);
  
  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_g('zeile_g'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);

  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "ge_id"+i;
  id_hidden.id = "ge_id"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
  }
}

function raus_g(zeile)
{
   knoten=$(zeile);
   knoten.parentNode.removeChild(knoten);
   document.form1.anzahl_g.value = 0;
}

/* Cover Übernehmen */
function uebernehme_c(id,name)
{
  var i= document.form1.anzahl_c.value;
  // Testen ob Eintrag schon vorhanden
  if(i==0)
  {
  
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_c.value = i;
  var anhang=$("ziel_c");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_c'+i);

  neuer_text= document.createTextNode(name+' ');
  text.appendChild(neuer_text);
  
  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_c('zeile_c'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);

  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "co_id"+i;
  id_hidden.id = "co_id"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
  }
}

function raus_c(zeile)
{
   knoten=$(zeile);
   knoten.parentNode.removeChild(knoten);
   document.form1.anzahl_c.value = 0;
}

/* Bindung Übernehmen */
function uebernehme_bi(id,name)
{
  var i= document.form1.anzahl_bi.value;
  // Testen ob Eintrag schon vorhanden
  if(i==0)
  {
  
  // nicht gefunden einfügen
  i++;
  document.form1.anzahl_bi.value = i;
  var anhang=$("ziel_bi");

  var text= document.createElement("span");
  text.setAttribute('id','zeile_bi'+i);

  neuer_text= document.createTextNode(name+' ');
  text.appendChild(neuer_text);

  var loesch_but = document.createElement("input");
  loesch_but.type ="button";
  loesch_but.onclick =function(){raus_bi('zeile_bi'+i);};
  loesch_but.value ="Löschen";
  text.appendChild(loesch_but);

  var id_hidden = document.createElement("input");
  id_hidden.type ="hidden";
  id_hidden.name= "bi_id"+i;
  id_hidden.id = "bi_id"+i;
  id_hidden.value= id;
  text.appendChild(id_hidden);
  anhang.appendChild(text);
  }
}

function raus_bi(zeile)
{
   knoten=$(zeile);
   knoten.parentNode.removeChild(knoten);
   document.form1.anzahl_bi.value = 0;
}