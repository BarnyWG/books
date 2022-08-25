// Speicherfunktionen Html5 Supercookie
storage=false;

window.onload = storage_init;

function storage_init()
{
	if(typeof(localStorage) == 'undefined' || typeof(localStorage) == 'unknown')
	{
	  alert('Laden nicht möglich. Browser unterstützt kein LokalStorage!');
	}
	else
	{
		storage=true;
		vorlage_read();
	} 
	// Focus auf c_bo_title
	$('c_bo_title').focus(); 
}

function vorlage_read()
{
  if(!storage){alert('Laden nicht möglich. Browser unterstützt kein LokalStorage!'); return;}
  slot=localStorage.getItem('VSlot_aktive');
  anzahl_a=localStorage.getItem('VSlot'+slot+'_anzahl_a');
  anzahl_r=localStorage.getItem('VSlot'+slot+'_anzahl_r');
  anzahl_r_dc=localStorage.getItem('VSlot'+slot+'_anzahl_r_dc');
  anzahl_s=localStorage.getItem('VSlot'+slot+'_anzahl_s');
  anzahl_v=localStorage.getItem('VSlot'+slot+'_anzahl_v');
  anzahl_g=localStorage.getItem('VSlot'+slot+'_anzahl_g');
  anzahl_c=localStorage.getItem('VSlot'+slot+'_anzahl_c');
  anzahl_bi=localStorage.getItem('VSlot'+slot+'_anzahl_bi');

  // Ausgewählte Autoren laden
  if(anzahl_a > 0) // Bei löschen von Autoren kann die Anzahl zu hoch sein
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
}