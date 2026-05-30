function muda_cor( ID )
{
	var linha = document.getElementById( ID ) ;
	linha.style.backgroundColor = "gold" ;
}

function volta_cor( ID , cor )
{
	var linha = document.getElementById( ID ) ;
	linha.style.backgroundColor = cor ;
}

function NewWindow(url, w, h){
	var barraWin = 25
	var x = (screen.width - (w + 9)) / 2
	var y = ((screen.height - (h + 40)) / 2) - barraWin
	var newWindow = window.open(url, "", "width=" + w + ", height=" + h + ", top=" + y + ", left=" + x + ", scrollbars=yes, statusbars=yes, resizable=yes,maximized=yes");
	if(window.top != window.self){
		newWindow.opener = window.top.pagina
	}else{
		newWindow.opener = window.self
	}
	return newWindow
}

function VerificaCPF(valor) {
	if (valor.length == 14)
		return true;
	if (valor.length != 11)
		return false;
	primeiro=valor.substr(1,1);
	falso=true;
	size=valor.length;
	size--;
	for (i=2; i<size-1; ++i){
		proximo=(valor.substr(i,1));
		if (primeiro!=proximo)
			falso=false
	}

	if (falso)
		return false;

	if(modulo(valor.substring(0,valor.length - 2)) + "" + modulo(valor.substring(0,valor.length - 1)) != valor.substring(valor.length - 2,valor.length))
		return false;
	return true
}

function encodeHTML(value){
	value = value.replace(/&/g, "&amp;")
	value = value.replace(/>/g, "&gt;")
	value = value.replace(/</g, "&lt;")
	return(value)
}

function formatCurrency(num) {
	num = num.toString().replace(/\$|\,/g,'')
	if(isNaN(num))
		num = "0"
	sign = (num == (num = Math.abs(num)))
	num = Math.floor(num*100+0.50000000001)
	cents = num % 100
	num = Math.floor(num/100).toString()
	if(cents<10)
		cents = "0" + cents
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3)) + '.' + num.substring(num.length-(4*i+3))
	return (((sign)?'':'-') + num + ',' + cents);
}

function encodeHtmlEntities(strPlainText, blnPartialEncodeOnly){
    var strPartial  = [];
    var strFull     = [];
    var intP        = 0;
    var intF        = 0;
    var objPartialRegExp = (new RegExp).compile("[\\w\\s]");

    for (var intI=0; intI < strPlainText.length; ++intI) {
        var strChar = strPlainText.charAt(intI);
        var intChar = strChar.charCodeAt(0);
        if (isNaN(intChar)) {
            // IF CHAR FAILED TO DECODE, LEAVE AS CHAR
            strPartial.push(strFull.push(strChar));
        }
        else {
            var strEntity = "&#" + intChar + ";";
            strFull.push(strEntity);
            // IF CHAR WAS [a-zA-Z0-9_ \t] LEAVE AS CHAR, ELSE REPLACE WITH ENTITY
            strPartial.push(objPartialRegExp.test(strChar) ? strChar : strEntity);
        }
    }
    return (blnPartialEncodeOnly ? strPartial.join("") : strFull.join(""));
}

function decodeHtmlEntities(strEncodedText){
    var strData     = String(strEncodedText);
    var objRegExp   = (new RegExp).compile("&#(\\d+);", "ig");
    /**//* FOR EACH MATCH TO ANY ENTITY, REPLACE THAT
	ENTITY GLOBALLY WITH ITS SINGLE CHAR EQUIVALENT */
    while(strData.match(objRegExp)){
        var strCharMatch    = RegExp.$1;
        var objRegExpMatch  = new RegExp("&#" + strCharMatch + ";", "ig");
        strData = strData.replace(objRegExpMatch, String.fromCharCode(strCharMatch));
    }
    return strData;
}

var wndDebug
function debug(msg, newLine){
	if(!wndDebug)
		wndDebug = NewWindow('Debug.php', 500, 380)
	var log = wndDebug.document.getElementById('log')
	if(log)
		log.value = log.value + (newLine?'\n':'') + msg
	else
		setInterval('debug(\'' + msg + '\',' + newLine + ')', 100)
}

function clearDebug(){
	if(!wndDebug)
		return
	var log = wndDebug.document.getElementById('log')
	log.value = ''
}

function WindowSize()
{ // window size object
	this.w = 0;
	this.h = 0;
	return this.update();
}
WindowSize.prototype.update = function()
{
	var d = document;
	this.w =
	  (window.innerWidth) ? window.innerWidth
	: (d.documentElement && d.documentElement.clientWidth) ? d.documentElement.clientWidth
	: d.body.clientWidth;
	this.h =
	  (window.innerHeight) ? window.innerHeight
	: (d.documentElement && d.documentElement.clientHeight) ? d.documentElement.clientHeight
	: d.body.clientHeight;
	return this;
};
function PageSize()
{ // page size object
	this.win = new WindowSize();
	this.w = 0;
	this.h = 0;
	return this.update();
}
PageSize.prototype.update = function()
{
	var d = document;
	this.w =
	  (window.innerWidth && window.scrollMaxX) ? window.innerWidth + window.scrollMaxX
	: (d.body.scrollWidth > d.body.offsetWidth) ? d.body.scrollWidth
	: d.body.offsetWidt;
	this.h =
	  (window.innerHeight && window.scrollMaxY) ? window.innerHeight + window.scrollMaxY
	: (d.body.scrollHeight > d.body.offsetHeight) ? d.body.scrollHeight
	: d.body.offsetHeight;
	this.win.update();
	if (this.w < this.win.w) this.w = this.win.w;
	if (this.h < this.win.h) this.h = this.win.h;
	return this;
};
function PagePos()
{ // page position object
	this.x = 0;
	this.y = 0;
	return this.update();
}
PagePos.prototype.update = function()
{
	var d = document;
	this.x =
	  (window.pageXOffset) ? window.pageXOffset
	: (d.documentElement && d.documentElement.scrollLeft) ? d.documentElement.scrollLeft
	: (d.body) ? d.body.scrollLeft
	: 0;
	this.y =
	  (window.pageYOffset) ? window.pageYOffset
	: (d.documentElement && d.documentElement.scrollTop) ? d.documentElement.scrollTop
	: (d.body) ? d.body.scrollTop
	: 0;
	return this;
};
function UserAgent()
{ // user agent information
	var ua = navigator.userAgent;
	this.isWinIE = this.isMacIE = false;
	this.isGecko  = ua.match(/Gecko\//);
	this.isSafari = ua.match(/AppleWebKit/);
	this.isOpera  = window.opera;
	if (document.all && !this.isGecko && !this.isSafari && !this.isOpera) {
		this.isWinIE = ua.match(/Win/);
		this.isMacIE = ua.match(/Mac/);
		this.isNewIE = (ua.match(/MSIE 5\.5/) || ua.match(/MSIE 6\.0/));
	}
	return this;
}

function createSimpleBox(obj){
	var ws = new WindowSize()
	var ps = new PageSize()
	var pp = new PagePos()
	var ua = new UserAgent()

	var back = document.createElement('div')
	back.id = 'lightboxbackground'
	with (back.style) {
		position = 'fixed'
		top = '0px'
		left = '0px'
		zIndex = '9999'
		width = '100%'
		height = '100%'
	}
	if (ua.isWinIE){
		back.style.position = 'absolute'
	}
	Event.observe(back, "click", function(e){
		closeSimpleBox()
	})
	if (ua.isWinIE) {
		back.style.width  = [ws.w, 'px'].join('');
		back.style.height = [ps.h + 100, 'px'].join('');
	}
	document.body.appendChild(back)

	var wrap = document.createElement('div')
	wrap.id = 'overlay'
	with (wrap.style) {
		position = 'fixed'
		top = '0px'
		left = '0px'
		zIndex = '9999'
		width = '100%'
		height = '100%'
	}
	if (ua.isWinIE){
		wrap.style.position = 'absolute'
		wrap.style.width  = [ws.w, 'px'].join('');
		wrap.style.height = [ps.h + 100, 'px'].join('');
	}
	Event.observe(wrap, "click", function(e){
//		closeSimpleBox()
	})
	hideSelects('hidden', obj)
	document.body.appendChild(wrap)

	var box = document.createElement('div')
	box.id = 'lightbox'
	with (box.style) {
		position = 'absolute'
		zIndex = '60'
	}
	if (ua.isWinIE){
		box.style.display = 'block'
	}
	Event.observe(box, "click", function(e){
		if(e.stopPropagation){
			e.stopPropagation();
		}
		return false;
		//Event.stop(e)
	})
	Element.addClassName(obj, 'lightboxcontent')
	box.appendChild(obj)
	wrap.appendChild(box)
	if (ua.isWinIE){
		box.style.top  = [pp.y + (ps.win.h - box.offsetHeight - 30) / 2,'px'].join('')
	}else{
		box.style.top  = [(ps.win.h - box.offsetHeight - 30) / 2,'px'].join('')
	}
	box.style.left = [((ws.w - box.offsetWidth - 30) / 2),'px'].join('')
}

function closeSimpleBox(){
	hideSelects('visible')
	var obj = document.getElementsByClassName('lightboxcontent')[0]
	Element.removeClassName(obj, 'lightboxcontent')

	document.body.appendChild(obj)
	obj.style.display = 'none'
	document.body.removeChild(document.getElementById('lightboxbackground'));
	document.body.removeChild(document.getElementById('overlay'));
}

function hideSelects(visibility, notIn){
	selects = document.getElementsByTagName('select');
	if(notIn){
		var notselects = notIn.getElementsByTagName('select')
	}
	for(var i = 0; i < selects.length; i++) {
		var vis = selects[i].style.visibility
		if(notselects){
			selects[i].style.visibility = visibility;
			for(var j = 0; j < notselects.length; j++) {
				if(selects[i] == notselects[j]){
					selects[i].style.visibility = vis;
					break;
				}
			}
		}else{
			selects[i].style.visibility = visibility;
		}
	}
}

/*
Descricao: Remove os caracteres especiais de uma string.
*/
function remover_charespecial(vlr){

	var strRetorno = vlr;
	var strEspecial = "ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ";
	var strNormal   = "SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy";

	for (i = 0; i < strEspecial.length; i++){
		vlr = vlr.replace(strEspecial.charAt(i), strNormal.charAt(i));
	}
	
	strRetorno = vlr;
	
	return strRetorno;
			
}

function criarCombo(v_id, v_arr, v_primeiro_item, v_default, v_complemento){
	var strRetorno = "";
	strRetorno+="<select id='"+v_id+"' name='"+v_id+"' "+v_complemento+">";
	if(v_primeiro_item != ""){
		strRetorno+="<option>"+v_primeiro_item+"</option>";
	}
	for(i = 0; i < v_arr.length; i++){
		if(v_default == v_arr[i][0])
			strRetorno+="<option value='"+v_arr[i][0]+"' selected=true>"+v_arr[i][1]+"</option>";
		else
			strRetorno+="<option value='"+v_arr[i][0]+"'>"+v_arr[i][1]+"</option>";
	}
	strRetorno+="</select>";
	return strRetorno;
}

function criarComboStatus(v_id, v_arr, v_primeiro_item, v_default, v_complemento){
	var strRetorno = "";
	var status = "";
	strRetorno+="<select id='"+v_id+"' name='"+v_id+"' "+v_complemento+">";
	if(v_primeiro_item != ""){
		strRetorno+="<option>"+v_primeiro_item+"</option>";
	}
	for(i = 0; i < v_arr.length; i++){		
		if(v_arr[i][2]==""){
			status = 'color:#009900';
		}else{
			status = 'color:#990000';
		}		
		if(v_default == v_arr[i][0])
			strRetorno+="<option value='"+v_arr[i][0]+"' selected=true>"+v_arr[i][1]+"</option>";
		else
			strRetorno+="<option value='"+v_arr[i][0]+"' style='"+status+"'>"+v_arr[i][1]+"</option>";
			
	}
	strRetorno+="</select>";
	return strRetorno;
}

function formatanumero(numero,decimais)
{
  if (isNaN(numero)) { return 0};
  if (numero=='') { return 0};
 
  var IsNegative=(parseInt(numero)<0);
  if(IsNegative)numero=-numero;

  var snum = new String(numero);
  var sec = snum.split('.');
  var whole = parseInt(sec[0]);
  var result = '';
  if(sec.length > 1){
    var dec = new String(sec[1]);
    dec = parseInt(dec)/Math.pow(10,parseInt(dec.length-decimais-1));
Math.round(dec);
dec = parseInt(dec)/10;

if(IsNegative)
{
  var x = 0-dec;
      x = Math.round(x);
  dec = - x;
}
else
{
      dec = Math.round(dec);
}

/*
  * If the number was rounded up from 9 to 10, and it was for 1 'decimal'
  * then we need to add 1 to the 'whole' and set the dec to 0.
  */
if(decimais==1 && dec==10)
{
  whole+=1;
  dec="0";
}

    dec = String(whole) + "." + String(dec);
    var dot = dec.indexOf('.');
    if(dot == -1){
      dec += '.';
      dot = dec.indexOf('.');
    }
var l=parseInt(dot)+parseInt(decimais);
    while(dec.length <= l) { dec += '0'; }
    result = dec;
  } else{
    var dot;
    var dec = new String(whole);
    dec += '.';
    dot = dec.indexOf('.');
var l=parseInt(dot)+parseInt(decimais);
    while(dec.length <= l) { dec += '0'; }
    result = dec;
  }
  if(IsNegative)result="-"+result;
  return result;
}

function stripLeftZeros(sStr){
   var i;
   for(i=0;i<sStr.length;i++)
      if(sStr.charAt(i)!='0')
         return sStr.substring(i);
   return sStr;
}
