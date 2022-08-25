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

function vorlage_write(slot)
{
  if(!storage){alert('Speichern nicht möglich. Browser unterstützt kein LokalStorage!'); return;}
  
  localStorage.setItem('VSlot'+slot+'_beschreibung',$('speichername'+slot).value);  
  localStorage.setItem('VSlot'+slot+'_anzahl_a',$('anzahl_a').value);
  localStorage.setItem('VSlot'+slot+'_anzahl_r',$('anzahl_r').value);
  localStorage.setItem('VSlot'+slot+'_anzahl_r_dc',$('anzahl_r_dc').value);
  localStorage.setItem('VSlot'+slot+'_anzahl_s',$('anzahl_s').value);
  localStorage.setItem('VSlot'+slot+'_anzahl_v',$('anzahl_v').value);
  localStorage.setItem('VSlot'+slot+'_anzahl_g',$('anzahl_g').value);
  localStorage.setItem('VSlot'+slot+'_anzahl_c',$('anzahl_c').value);
  localStorage.setItem('VSlot'+slot+'_anzahl_bi',$('anzahl_bi').value);

  // Ausgewählte Autoren speichern
  if($('anzahl_a').value > 0)
  {
  	for(i=1;i <= $('anzahl_a').value;i++)  // Bei löschen von Autoren kann die Anzahl falsch sein
  	{
  	  try{
      localStorage.setItem('VSlot'+slot+'_au_id'+i,$('au_id'+i).value);
      localStorage.setItem('VSlot'+slot+'_au_name'+i,$('zeile_a'+i).childNodes[2].wholeText);
      }
      catch(e){}
  	}
  }
  // einzelen Auswahlwerte Speichern
  if($('anzahl_r').value > 0)
  {
      localStorage.setItem('VSlot'+slot+'_st_id',$('st_id1').value);
      localStorage.setItem('VSlot'+slot+'_st_name',$('zeile_r1').childNodes[0].wholeText);  
  }
  if($('anzahl_r_dc').value > 0)
  {
      localStorage.setItem('VSlot'+slot+'_st_id_dc',$('st_id_dc1').value);
      localStorage.setItem('VSlot'+slot+'_st_name_dc',$('zeile_r_dc1').childNodes[0].wholeText);    
  }
  if($('anzahl_s').value > 0)
  {
      localStorage.setItem('VSlot'+slot+'_bs_id',$('bs_id1').value);
      localStorage.setItem('VSlot'+slot+'_bs_name',$('zeile_s1').childNodes[0].wholeText);  
  }
  if($('anzahl_v').value > 0)
  {
      localStorage.setItem('VSlot'+slot+'_pb_id',$('pb_id1').value);
      localStorage.setItem('VSlot'+slot+'_pb_name',$('zeile_v1').childNodes[0].wholeText);   
  }
  if($('anzahl_g').value > 0)
  {
      localStorage.setItem('VSlot'+slot+'_ge_id',$('ge_id1').value);
      localStorage.setItem('VSlot'+slot+'_ge_type',$('zeile_g1').childNodes[0].wholeText);    
  }
  if($('anzahl_c').value > 0)
  {
      localStorage.setItem('VSlot'+slot+'_co_id',$('co_id1').value);
      localStorage.setItem('VSlot'+slot+'_co_type',$('zeile_c1').childNodes[0].wholeText);    
  }  
  if($('anzahl_bi').value > 0)
  {
      localStorage.setItem('VSlot'+slot+'_bi_id',$('bi_id1').value);
      localStorage.setItem('VSlot'+slot+'_bi_type',$('zeile_bi1').childNodes[0].wholeText);    
  }  
  // Speichern Inhalt eingabefelder (ISBN kann nicht gespeichert werden!)
  localStorage.setItem('VSlot'+slot+'_c_bo_title',$('c_bo_title').value);
  localStorage.setItem('VSlot'+slot+'_c_bo_print_run',$('c_bo_print_run').value);  
  localStorage.setItem('VSlot'+slot+'_c_bo_price',$('c_bo_price').value);  
  localStorage.setItem('VSlot'+slot+'_c_bo_isbn',$('c_bo_isbn').value); 
  localStorage.setItem('VSlot'+slot+'_c_bo_height',$('c_bo_height').value);
  localStorage.setItem('VSlot'+slot+'_c_bo_deep',$('c_bo_deep').value);    
  localStorage.setItem('VSlot'+slot+'_c_bo_width',$('c_bo_width').value);  
  localStorage.setItem('VSlot'+slot+'_c_bo_weight_gr',$('c_bo_weight_gr').value);            
  localStorage.setItem('VSlot'+slot+'_c_bo_comment',$('c_bo_comment').value);
  localStorage.setItem('VSlot'+slot+'_c_bo_conferred',$('c_bo_conferred').value);
  // Speichern Inhalt Checkbox Felder
  localStorage.setItem('VSlot'+slot+'_c_bo_has_read',$('c_bo_has_read').checked);
  localStorage.setItem('VSlot'+slot+'_c_bo_has_dc',$('c_bo_has_dc').checked);
      
  alert('Gespeichert');
}  

function vorlage_read(slot)
{
  if(!storage){alert('Laden nicht möglich. Browser unterstützt kein LokalStorage!'); return;}
  
  anzahl_a=localStorage.getItem('VSlot'+slot+'_anzahl_a');
  anzahl_r=localStorage.getItem('VSlot'+slot+'_anzahl_r');
  anzahl_r_dc=localStorage.getItem('VSlot'+slot+'_anzahl_r_dc');
  anzahl_s=localStorage.getItem('VSlot'+slot+'_anzahl_s');
  anzahl_v=localStorage.getItem('VSlot'+slot+'_anzahl_v');
  anzahl_g=localStorage.getItem('VSlot'+slot+'_anzahl_g');
  anzahl_c=localStorage.getItem('VSlot'+slot+'_anzahl_c');
  anzahl_bi=localStorage.getItem('VSlot'+slot+'_anzahl_bi');

  // Ausgewählte Autoren laden
  if(anzahl_a > 0) // Beim löschen von Autoren kann die Anzahl zu hoch sein
  {
  	for(i=1;i <= anzahl_a;i++)
  	{
  	  try{
      name=localStorage.getItem('VSlot'+slot+'_au_name'+i);
      namen=name.split(','); 	
      uebernehme_a(localStorage.getItem('VSlot'+slot+'_au_id'+i),namen[0],namen[1]);
      }
      catch(e){}
  	}
  }
  // einzelen Auswahlwerte laden
  if(anzahl_r > 0)
  {
      uebernehme_r(localStorage.getItem('VSlot'+slot+'_st_id'),localStorage.getItem('VSlot'+slot+'_st_name'));  
  }
  if(anzahl_r_dc > 0)
  {
      uebernehme_r_dc(localStorage.getItem('VSlot'+slot+'_st_id_dc'),localStorage.getItem('VSlot'+slot+'_st_name_dc'));
  }
  if(anzahl_s > 0)
  {
      uebernehme_s(localStorage.getItem('VSlot'+slot+'_bs_id'),localStorage.getItem('VSlot'+slot+'_bs_name'));
  }
  if(anzahl_v > 0)
  {
  	  name=localStorage.getItem('VSlot'+slot+'_pb_name');
  	  namen=name.split(',');
	  uebernehme_v(localStorage.getItem('VSlot'+slot+'_pb_id'),namen[0],namen[1]);   
  }
  if(anzahl_g > 0)
  {
      uebernehme_g(localStorage.getItem('VSlot'+slot+'_ge_id'),localStorage.getItem('VSlot'+slot+'_ge_type'));    
  }
  if(anzahl_c > 0)
  {
  	  uebernehme_c(localStorage.getItem('VSlot'+slot+'_co_id'),localStorage.getItem('VSlot'+slot+'_co_type'));    
  }  
  if(anzahl_bi > 0)
  {
  	  uebernehme_bi(localStorage.getItem('VSlot'+slot+'_bi_id'),localStorage.getItem('VSlot'+slot+'_bi_type'));    
  }  
  // Laden Inhalt eingabefelder (ISBN kann nicht gespeichert werden!)
  $('c_bo_title').value=localStorage.getItem('VSlot'+slot+'_c_bo_title');
  $('c_bo_print_run').value=localStorage.getItem('VSlot'+slot+'_c_bo_print_run');  
  $('c_bo_price').value=localStorage.getItem('VSlot'+slot+'_c_bo_price');  
  $('c_bo_isbn').value=localStorage.getItem('VSlot'+slot+'_c_bo_isbn');  
  $('c_bo_height').value=localStorage.getItem('VSlot'+slot+'_c_bo_height');
  $('c_bo_deep').value=localStorage.getItem('VSlot'+slot+'_c_bo_deep');    
  $('c_bo_width').value=localStorage.getItem('VSlot'+slot+'_c_bo_width');  
  $('c_bo_weight_gr').value=localStorage.getItem('VSlot'+slot+'_c_bo_weight_gr');            
  $('c_bo_comment').value=localStorage.getItem('VSlot'+slot+'_c_bo_comment');
  $('c_bo_conferred').value=localStorage.getItem('VSlot'+slot+'_c_bo_conferred');
  // Laden Inhalt Checkbox Felder
  if(localStorage.getItem('VSlot'+slot+'_c_bo_has_read')=='true')
  {
    $('c_bo_has_read').checked='checked';
  }
  else
  {
    $('c_bo_has_read').checked='';
  }   
  if(localStorage.getItem('VSlot'+slot+'_c_bo_has_dc')=='true')
  {
    $('c_bo_has_dc').checked='checked';
  }
  else
  {
    $('c_bo_has_dc').checked='';
  }
    
  alert('Geladen');
}  

function vorlage_aktivieren(slot)
{
  if(!storage){alert('Laden nicht möglich. Browser unterstützt kein LokalStorage!'); return;}
  
  localStorage.setItem('VSlot_aktive',slot);
    
  alert('Vorlage '+slot+' '+$('speichername'+slot).value+' Aktiviert!');
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
  beschreibung.value =  localStorage.getItem('VSlot'+slot+'_beschreibung');
}
