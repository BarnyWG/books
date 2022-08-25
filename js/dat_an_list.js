window.onload = function() {liste_verknuepfungen();}

if(window.XMLHttpRequest)
{
  resObjekt1 = new XMLHttpRequest();
  resObjekt2 = new XMLHttpRequest();
  resObjekt3 = new XMLHttpRequest();
  resObjekt4 = new XMLHttpRequest();  
}
else if(window.ActiveXObject)
{
  try
  {
    resObjekt1  = new ActiveXObject('Msxml2.XMLHTTP');
    resObjekt2  = new ActiveXObject('Msxml2.XMLHTTP');
    resObjekt3  = new ActiveXObject('Msxml2.XMLHTTP');    
    resObjekt4  = new ActiveXObject('Msxml2.XMLHTTP');    
  }
  catch(e1)
  {
    try
    {
      resObjekt1  = new ActiveXObject('Microsoft.XMLHTTP');
      resObjekt2  = new ActiveXObject('Microsoft.XMLHTTP');
      resObjekt3  = new ActiveXObject('Microsoft.XMLHTTP');
      resObjekt4  = new ActiveXObject('Microsoft.XMLHTTP');            
    }
    catch(e2)
    {}
  }
}

function suche()
{ 
    document.getElementById("container").innerHTML = 'Suche';
    url='dat_da_suche.php?da_besch=' + escape(document.form2.da_besch.value);
    url += '&da_id=' + escape(document.form2.da_id.value);
    url += '&da_name=' + escape(document.form2.da_name.value);
    resObjekt1.open('get',url,true);
    resObjekt1.onreadystatechange =handleResponse;
    resObjekt1.send(null);
}

function handleResponse()
{
  if(resObjekt1.readyState == 1)
  {
    document.getElementById("container").innerHTML ='Suche.';
  }
  if(resObjekt1.readyState == 2)
  {
    document.getElementById("container").innerHTML ='Suche..';
  }  
  if(resObjekt1.readyState == 3)
  {
    document.getElementById("container").innerHTML ='Suche...';
  }
  
  if(resObjekt1.readyState == 4)
  {
    document.getElementById("container").innerHTML =resObjekt1.responseText;
  }
}

function handleResponse_del_verk()
{
  if(resObjekt2.readyState == 1)
  {
    document.getElementById("status").innerHTML ='Verknüpfung Löschen.';
  }
  if(resObjekt2.readyState == 2)
  {
    document.getElementById("status").innerHTML ='Verknüpfung Löschen..';
  }  
  if(resObjekt2.readyState == 3)
  {
    document.getElementById("status").innerHTML ='Verknüpfung Löschen...';
  }
  
  if(resObjekt2.readyState == 4)
  {
    document.getElementById("status").innerHTML =resObjekt2.responseText;  
    liste_verknuepfungen();
  }
}

function handleResponse_dat_verk()
{
  if(resObjekt3.readyState == 1)
  {
    document.getElementById("status_suche").innerHTML ='Verknüpfe.';
  }
  if(resObjekt3.readyState == 2)
  {
    document.getElementById("status_suche").innerHTML ='Verknüpfe..';
  }  
  if(resObjekt3.readyState == 3)
  {
    document.getElementById("status_suche").innerHTML ='Verknüpfe...';
  }
  
  if(resObjekt3.readyState == 4)
  {
    document.getElementById("status_suche").innerHTML =resObjekt3.responseText;  
    liste_verknuepfungen();
  }
}

function handleResponse_liste_verk()
{
  if(resObjekt4.readyState == 1)
  {
    document.getElementById("status").innerHTML ='Lade.';
  }
  if(resObjekt4.readyState == 2)
  {
    document.getElementById("status").innerHTML ='Lade..';
  }  
  if(resObjekt4.readyState == 3)
  {
    document.getElementById("status").innerHTML ='Lade...';
  }
  
  if(resObjekt4.readyState == 4)
  {
    document.getElementById("liste_verk").innerHTML =resObjekt4.responseText;
    document.getElementById("status").innerHTML ='geladen';  
  }
}

function del_verknuepfung(id)
{ 
    document.getElementById("status").innerHTML = 'Verknüpfung Löschen';
    url='dat_al_del.php?al_id=' + id;
    resObjekt2.open('get',url,true);
    resObjekt2.onreadystatechange =handleResponse_del_verk;
    resObjekt2.send(null);
}

function datei_verknuepfen(da_id)
{ 
    document.getElementById("status_suche").innerHTML = 'Verknüpfe';
    url='dat_al_spe.php?da_id=' + da_id;
    url += '&bt_id=' + escape(document.form1.bt_id.value);
    resObjekt3.open('get',url,true);
    resObjekt3.onreadystatechange =handleResponse_dat_verk;
    resObjekt3.send(null);
}


function liste_verknuepfungen()
{ 
    document.getElementById("status").innerHTML = 'Lade';
    url='dat_an_list_verk.php?bt_id=' + escape(document.the_hidden.bt_id.value);
    url += '&mode=' + escape(document.the_hidden.mode.value);    
    resObjekt4.open('get',url,true);
    resObjekt4.onreadystatechange =handleResponse_liste_verk;
    resObjekt4.send(null);
}