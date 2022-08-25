var but_normal = new Array;
var but_press = new Array;
var but_over_nor = new Array;
var but_over_pre = new Array;
var but_status = new Array;
var bez= new Array;

// Auflistung der ID im HTML muss die ID vergeben werden und als 'name' die Buttonnummer die zu Wechseln ist 
bez[0]="buch";
bez[1]="autor";
bez[2]="komm";
bez[3]="serie";
bez[4]="verlag";
bez[5]="regal";
bez[6]="verwaltung";
bez[7]="genre";

// Initalisieren der Arrays
for (but in bez) 
{
	but_normal[but]= new Image();
	but_press[but] = new Image();
	but_over_nor[but] = new Image();
	but_over_pre[but] = new Image();
	but_status[but] = 0;
}

// für jeden Button die Viererfolge
but_normal[0].src ="grafik/buch_suche_up.jpg";    
but_press[0].src ="grafik/buch_suche_dw.jpg";
but_over_nor[0].src ="grafik/buch_suche_up_hi.jpg";
but_over_pre[0].src ="grafik/buch_suche_dw_hi.jpg";
but_normal[1].src ="grafik/autors_up.jpg";
but_press[1].src ="grafik/autors_dw.jpg";
but_over_nor[1].src ="grafik/autors_up_hi.jpg";
but_over_pre[1].src ="grafik/autors_dw_hi.jpg";
but_normal[2].src ="grafik/koms_up.jpg";
but_press[2].src ="grafik/koms_dw.jpg";
but_over_nor[2].src ="grafik/koms_up_hi.jpg";
but_over_pre[2].src ="grafik/koms_dw_hi.jpg";
but_normal[3].src ="grafik/series_up.jpg";
but_press[3].src ="grafik/series_dw.jpg";
but_over_nor[3].src ="grafik/series_up_hi.jpg";
but_over_pre[3].src ="grafik/series_dw_hi.jpg";
but_normal[4].src ="grafik/verlag_m_up.jpg";
but_press[4].src ="grafik/verlag_m_dw.jpg";
but_over_nor[4].src ="grafik/verlag_m_up_hi.jpg";
but_over_pre[4].src ="grafik/verlag_m_dw_hi.jpg";
but_normal[5].src ="grafik/regal_m_up.jpg";
but_press[5].src ="grafik/regal_m_dw.jpg";
but_over_nor[5].src ="grafik/regal_m_up_hi.jpg";
but_over_pre[5].src ="grafik/regal_m_dw_hi.jpg";
but_normal[6].src ="grafik/verwalt_m_up.jpg";
but_press[6].src ="grafik/verwalt_m_dw.jpg";
but_over_nor[6].src ="grafik/verwalt_m_up_hi.jpg";
but_over_pre[6].src ="grafik/verwalt_m_dw_hi.jpg";
but_normal[7].src ="grafik/genre_m_up.jpg";
but_press[7].src ="grafik/genre_m_dw.jpg";
but_over_nor[7].src ="grafik/genre_m_up_hi.jpg";
but_over_pre[7].src ="grafik/genre_m_dw_hi.jpg";

function wechsel (nummer)
{
	for (t = 0 ; t < bez.length ; t++)
	{
		$(bez[t]).src=but_normal[t].src;
		but_status[t]=0;
	}
	nummer.src=but_over_pre[nummer.getAttribute('name')].src;
	but_status[nummer.getAttribute('name')]=1;
	return
}

function ueber (nummer)
{
	if (but_status[nummer.getAttribute('name')] == 0)
	{
		$(nummer.id).src=but_over_nor[nummer.getAttribute('name')].src;
	}
 	if (but_status[nummer.getAttribute('name')] == 1) 
 	{
		$(nummer.id).src=but_over_pre[nummer.getAttribute('name')].src;
	}
	return
}

function raus (nummer) 
{
	if (but_status[nummer.getAttribute('name')] == 0) 
	{
		$(nummer.id).src=but_normal[nummer.getAttribute('name')].src;
	}
	if (but_status[nummer.getAttribute('name')] == 1) 
	{
		$(nummer.id).src=but_press[nummer.getAttribute('name')].src;
	}
	return
}