var ueber_eintrag;
ueber_eintrag=false;

function test()
{
alert('Parent');
}

function  einblenden(nummer)
{
  alle_aus();

  tag=$(nummer);
   if ( tag.style.top == '-1000px' ){
      tag.style.top='0';
      }
    else {
     tag.style.top='-1000px';
    }
  ueber_eintrag=true;  
}

function menu_check()
{
  if(!ueber_eintrag) alle_aus();
}

function alle_aus()
{
  var mp=$('anzahl_mp').value;
  for(i=1;i<=mp;i++)
  {
    tag=$('m'+i);
    tag.style.top='-1000px';
  }
}

function clear_display2()
{
 $('display2').src ='';
 $('backtask').src ='';
}

function highlight(objekt)
{
 objekt.setAttribute('class','m_drauf');
 ueber_eintrag=true;
}

function nicht_highlight(objekt)
{
 objekt.setAttribute('class','menulist');
 ueber_eintrag=false;
 window.setTimeout("menu_check()",1500);
}

function display(source)
{
  $('display1').src = source;
}
  
function display2(source)
{
  $('display2').src=source;
}

function backtask(source)
{
  $('backtask').src=source;
}

function zumachen ()
{
  alle_aus();
  window.clearInterval();
}
