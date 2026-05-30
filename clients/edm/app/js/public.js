function NewWindow(url, w, h) {
    var barraWin = 25
    var x = (screen.width - (w + 9)) / 2
    var y = ((screen.height - (h + 40)) / 2) - barraWin
    var newWindow = window.open(url, "", "width=" + w + ", height=" + h + ", top=" + y + ", left=" + x + ", scrollbars=yes, statusbars=yes, resizable=yes,maximized=yes");
    if (window.top != window.self) {
        newWindow.opener = window.top.pagina
    } else {
        newWindow.opener = window.self
    }
    return newWindow
}

function mascara(o, f) {
    v_obj = o
    v_fun = f
    setTimeout("execmascara()", 1)
}

function execmascara() {
    v_obj.value = v_fun(v_obj.value)
}

function leech(v) {
    v = v.replace(/o/gi, "0")
    v = v.replace(/i/gi, "1")
    v = v.replace(/z/gi, "2")
    v = v.replace(/e/gi, "3")
    v = v.replace(/a/gi, "4")
    v = v.replace(/s/gi, "5")
    v = v.replace(/t/gi, "7")
    return v
}

function soNumeros(v) {
    return v.replace(/\D/g, "")
}

function telefone(v) {
    v = v.replace(/\D/g, "")                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = v.replace(/^(\d\d)(\d)/g, "($1) $2") //Coloca par&#234;nteses em volta dos dois primeiros d&#237;gitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")    //Coloca h&#237;fen entre o quarto e o quinto d&#237;gitos
    return v
}

function telefone1(v) {
    v = v.replace(/\D/g, "")                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = v.replace(/(\d{4})(\d)/, "$1-$2")    //Coloca h&#237;fen entre o quarto e o quinto d&#237;gitos
    return v
}

function cpf(v) {
    v = v.replace(/\D/g, "")                    //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto d&#237;gitos
    v = v.replace(/(\d{3})(\d)/, "$1.$2")       //Coloca um ponto entre o terceiro e o quarto d&#237;gitos
    //de novo (para o segundo bloco de n&#250;meros)
    v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2") //Coloca um h&#237;fen entre o terceiro e o quarto d&#237;gitos
    return v
}

function cep1(v) {
    v = v.replace(/\D/g, "")                //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = v.replace(/(\d{5})(\d)/, "$1-$2")  //Esse &#233; t&#227;o f&#225;cil que n&#227;o merece explica&#231;&#245;es
    return v
}

function cnpj(v) {
    v = v.replace(/\D/g, "")                           //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = v.replace(/^(\d{2})(\d)/, "$1.$2")             //Coloca ponto entre o segundo e o terceiro d&#237;gitos
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3") //Coloca ponto entre o quinto e o sexto d&#237;gitos
    v = v.replace(/\.(\d{3})(\d)/, ".$1/$2")           //Coloca uma barra entre o oitavo e o nono d&#237;gitos
    v = v.replace(/(\d{4})(\d)/, "$1-$2")              //Coloca um h&#237;fen depois do bloco de quatro d&#237;gitos
    return v
}

function romanos(v) {
    v = v.toUpperCase()             //Mai&#250;sculas
    v = v.replace(/[^IVXLCDM]/g, "") //Remove tudo o que n&#227;o for I, V, X, L, C, D ou M
    //Essa &#233; complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
    while (v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/, "") != "")
        v = v.replace(/.$/, "")
    return v
}

function datamask(v) {
    var data = new Date();
    ano = data.getFullYear();
    v = v.replace(/\D/g, "");                //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = (v.substring(0, 1) > 3) ? "" : v;
    v = (v.substring(0, 1) == 3 && v.substring(1, 2) > 1) ? v.substring(0, 1) : v;
    v = (v.substring(2, 3) > 1) ? v.substring(0, 2) : v;
    v = (v.substring(3, 4) > 2 && v.substring(2, 3) == 1) ? v.substring(0, 3) : v;
    v = (v.substring(4, 8) > ano) ? v : v;
    v = v.replace(/(\d{2})(\d)/, "$1/$2");    //Coloca barra entre o segundo e terceiro d&#237;gitos
    v = v.replace(/(\d{2})(\d)/, "$1/$2");   //Coloca barra entre o quarto e quinto d&#237;gitos
    return v;
}

function horamask2(campo, e) {
    var tecla = (window.event) ? e.keyCode : e.which;
    if (tecla == 8 || tecla > 36 && tecla < 41 || tecla == 46)
        return true;
    if (tecla < 48 || tecla > 57)
        return false;
    var er = /\D/g;
    campo.value = campo.value.replace(er, '');
    var tam = campo.value.length;
    switch (tam) {
        case 0:
            if (tecla > 50)
                campo.value = "0" + String.fromCharCode(tecla) + ":";
            else
                campo.value = String.fromCharCode(tecla);
            break;

        case 1:
            if (campo.value.substr(0, 1) <= 1 && tecla <= 57 || campo.value.substr(0, 1) == 2 && tecla <= 51)
                campo.value = campo.value + String.fromCharCode(tecla) + ":";
            break;

        case 2:
            if (tecla <= 53)
                campo.value = campo.value.substr(0, 2) + ":" + campo.value.substr(2, 1) + String.fromCharCode(tecla);
            else
                campo.value = campo.value.substr(0, 2) + ":";
            break;

        case 3:
            campo.value = campo.value.substr(0, 2) + ":" + campo.value.substr(2, 1) + String.fromCharCode(tecla);
            break;

        default:
            campo.value = campo.value.substr(0, 2) + ":" + campo.value.substr(2, 2);
    }
    return false;
}

function horamask(v) {
    v = v.replace(/\D/g, "");                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = (v.substring(0, 1) > 2) ? "" : v;
    v = (v.substring(0, 1) != 1 && v.substring(1, 2) > 4) ? v.substring(0, 1) : v;
    v = (v.substring(2, 3) > 6) ? v.substring(0, 2) : v;
    v = v.replace(/(\d{2})(\d)/, "$1:$2")    //Coloca dois pontos entre o segundo e terceiro d&#237;gitos
    v = (v.length > 5) ? v.substring(0, 5) : v;
    return v;
}

function site(v) {
    //Esse sem comentarios para que voc&#234; entenda sozinho ;-)
    v = v.replace(/^http:\/\/?/, "")
    dominio = v
    caminho = ""
    if (v.indexOf("/") > -1)
        dominio = v.split("/")[0]
    caminho = v.replace(/[^\/]*/, "")
    dominio = dominio.replace(/[^\w\.\+-:@]/g, "")
    caminho = caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g, "")
    caminho = caminho.replace(/([\?&])=/, "$1")
    if (caminho != "") dominio = dominio.replace(/\.+$/, "")
    v = "http://" + dominio + caminho
    return v
}

/*Função que padroniza valor monétario*/
function Valor(v){
	
	//Revove todos os zeros a esquerda.
	v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
	
	//adaptacao Guilherme Watanabe Ferreira
	//Remove os zeros a esquerda desde que tenha pelo menos 3 digitos
	v_temp = v;
	v = "";
	for(i = 0; i < v_temp.length; i++){
		if(v_temp.charAt(i) != "0"){
			v = v_temp.substr(i,v_temp.length);
			break;
		}
	}
	
	if(v.length == 1){
		v = "00" + v;
	}
	if(v.length == 2){
		v = "0" + v;
	}
	//Fim da Adaptacao

	//v=v.replace(/^([0-9]{3}\.?){3}-[0-9]{2}$/,"$1,$2");
	//v=v.replace(/(\d{3})(\d)/g,"$1,$2")
	v=v.replace(/(\d)(\d{2})$/,"$1.$2") //Coloca ponto antes dos 2 últimos digitos
	
	return float2moeda(v);
}


/**
* Mascara para qualquer tipo de campo numerico.
* @author Rogerio Avelino da Silva 25/02/2009.
* @tutotial Voc&#234; deve chamar a fun&#231;&#227;o dessa maneira: onkeypress="return MajoraMask( event , this , 'nome da mascara do switch' );"
*/
function MajoraMask(e, inp, tipo) {
    var tecla = (window.Event) ? e.which : e.keyCode;
    if (tecla == 8 || tecla == 0)
        return true;
    else if (tecla < 48 || tecla > 57)
        return false;

    var quebraNo;
    var chars;

    switch (tipo) {
        case 'telefone':
            quebraNo = new Array('', 4);
            chars = new Array('', '-');
            break;
    }
    var er = /[^0-9]/g;
    var valor = inp.value.replace(er, '');

    for (var i = 0; i < (valor.length - 1); i++) {
        if (valor.length == quebraNo[i]) {
            if (inp.value.substr(valor.length).search(er) == -1)
                inp.value = inp.value + valor.substr(quebraNo[i], quebraNo[i + 1]) + chars[i];
        }
    }
}

function daysInMonth(month, year) {
    var dd = new Date(year, month, 0);
    return dd.getDate();
}

function selecionarDia(vdia, vmes, vano, txt_id, sp_id) {

    if (vdia.toString().length < 2)
        vdia = "0" + vdia;

    if (vmes.toString().length < 2)
        vmes = "0" + vmes;

    var txt = document.getElementById(txt_id);
    txt.value = (vdia + "/" + vmes + "/" + vano);

    fecharCalendario(sp_id);
}

function mesAnterior(mes, ano, sp_id, txt_id) {

    //calcula o mes anterior
    if (mes == 1) {
        mes = 12
        ano = ano - 1;
    }
    else {
        mes = mes - 1;
    }


    var txt = document.getElementById(txt_id);
    var dv = document.getElementById(sp_id);

    dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
    dv.style.display = 'block';
}

function anoAnterior(mes, ano, sp_id, txt_id) {
    //calcula o mes anterior
    ano = ano - 1;

    var txt = document.getElementById(txt_id);
    var dv = document.getElementById(sp_id);

    dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
    dv.style.display = 'block';
}

function mesProximo(mes, ano, sp_id, txt_id) {
    //calcula o mes anterior
    if (mes == 12) {
        mes = 1
        ano = ano + 1;
    }
    else {
        mes = mes + 1;
    }
    var txt = document.getElementById(txt_id);
    var dv = document.getElementById(sp_id);

    dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
    dv.style.display = 'block';

}
function anoProximo(mes, ano, sp_id, txt_id) {
    ano = ano + 1;
    var txt = document.getElementById(txt_id);
    var dv = document.getElementById(sp_id);

    dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
    dv.style.display = 'block';
}

function fecharCalendario(sp_id) {
    var dv = document.getElementById(sp_id);
    dv.style.display = 'none';
}

function criarCalendario(mes, ano, sp_id, txt_id) {

    var arrTituloMes = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    var arrTituloSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];

    var strTabela = "";
    strTabela += "<table border=1 cellspacing=0 cellpadding=0>";
    strTabela += "<tr><td bgcolor=white>";
    strTabela += "<table border='0' cellspacing=1 cellpadding=1>";
    strTabela += "<tr bgcolor='black'>";
    strTabela += "<td align=center colspan='6' align='center'>";
    strTabela += "<input title='Voltar Mês' type='button' value='<<' id='ano_voltar' name='ano_voltar' onclick='anoAnterior(" + mes + "," + ano + ", " + '"' + sp_id + '"' + ", " + '"' + txt_id + '"' + ")' />";
    strTabela += "<input title='Voltar Asno' type='button' value='<' id='mes_voltar' name='mes_voltar' onclick='mesAnterior(" + mes + "," + ano + ", " + '"' + sp_id + '"' + ", " + '"' + txt_id + '"' + ")'  />";
    strTabela += "&nbsp;<span id='sp_mes'><font face='verdana' size='2'  color='white'><b>" + arrTituloMes[mes] + "</b></font></span>&nbsp;<font color='white'><b>/</b></font>&nbsp;<span id='sp_ano'><font  face='verdana' size='2' color='white'><b>" + ano + "</b></font></span>&nbsp;";
    strTabela += "<input title='Avançar Mês' type='button' value='>' id='mes_avancar' name='mes_avancar' onclick='mesProximo(" + mes + "," + ano + ", " + '"' + sp_id + '"' + ", " + '"' + txt_id + '"' + ")'  />";
    strTabela += "<input title='Avançar Ano' type='button' value='>>' id='ano_avancar' name='ano_avancar' onclick='anoProximo(" + mes + "," + ano + ", " + '"' + sp_id + '"' + ", " + '"' + txt_id + '"' + ")'  />";
    strTabela += "</td>";
    strTabela += "<td align='center'>&nbsp;";
    strTabela += "<input title='Fechar Calendario' type='button' value='X' id='bt_fechar' name='bt_fechar' onclick='fecharCalendario(" + '"' + sp_id + '"' + ")'>";
    strTabela += "&nbsp;</td>";
    strTabela += "</tr>";
    strTabela += "<tr bgcolor='#838383'>";
    for (i = 0; i < 7; i++) {
        strTabela += "<th><font color='white'  face='verdana' size='2' >" + arrTituloSemana[i] + "</font></th>";
    }
    strTabela += "</tr>";
    //calcula a quantidade de semanas;

    var dhoje = new Date();
    var hoje_dia = dhoje.getDate();
    var hoje_mes = dhoje.getMonth();
    var hoje_ano = dhoje.getFullYear();

    if (hoje_mes == 11) {
        hoje_mes = 0;
    }
    else {
        hoje_mes++;
    }

    var diaSemana = 1;
    var ultimoDia = daysInMonth(mes, ano);
    var ddia = new Date(ano, (mes - 1), 1);
    var diaSemanaPrimeiroDia = ddia.getDay();
    var diaAtual = 1;
    for (linha = 0; linha <= 5; linha++) {

        if (diaAtual <= ultimoDia) {
            strTabela += "<tr>";
            for (coluna = 0; coluna <= 6; coluna++) {
                if (coluna == 0 || coluna == 6) {
                    cor_celula = '#D6D6D6'
                    cor_letra = 'red';

                }
                else {
                    cor_celula = 'white';
                    cor_letra = 'black';
                }

                //verifica se o dia é hoje
                if (hoje_dia == diaAtual) {
                    if (hoje_mes == mes) {
                        if (hoje_ano == ano) {
                            cor_celula = 'black';
                            cor_letra = 'white';
                        }
                    }
                }

                if (linha == 0) {
                    if (coluna < diaSemanaPrimeiroDia) {
                        strTabela += "<td bgcolor='" + cor_celula + "'>&nbsp;</td>";
                    }
                    else {
                        strTabela += "<td bgcolor='" + cor_celula + "' align=center><a style='text-decoration:none' href='javascript:selecionarDia(" + diaAtual + "," + mes + "," + ano + "," + '"' + txt_id + '"' + ", " + '"' + sp_id + '"' + ")'><font face='verdana' size='2' color='" + cor_letra + "'>" + diaAtual + "</font></a></td>";
                        diaAtual++;
                    }
                }
                else {
                    if (diaAtual <= ultimoDia) {
                        strTabela += "<td  bgcolor='" + cor_celula + "' align=center><a style='text-decoration:none' href='javascript:selecionarDia(" + diaAtual + "," + mes + "," + ano + "," + '"' + txt_id + '"' + ", " + '"' + sp_id + '"' + ")'><font face='verdana' size='2'  color='" + cor_letra + "'>" + diaAtual + "</font></a></td>";
                        diaAtual++;
                    }
                    else {
                        strTabela += "<td bgcolor='" + cor_celula + "'>&nbsp;</td>";
                    }
                }
            }
            strTabela += "</tr>";
        }
    }
    strTabela += "</table>";
    strTabela += "</td></tr>";

    strTabela += "</table>";
    return strTabela;
}

function abrirCalendario(objname) {

    var txt = document.getElementById(objname);
    var dv = document.getElementById('sp_' + objname);
    var hoje = new Date();
    var dia = hoje.getDate();
    var mes = hoje.getMonth();
    var ano = hoje.getFullYear();

    if (mes == 12) {
        mes = 0;
    }
    else {
        mes++;
    }

    if (txt.value.length == 10) {
        arrData = txt.value.split("/");
        mes = parseInt(arrData[1]);
        ano = parseInt(arrData[2]);
    }

    dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
    dv.style.display = 'block';
}

function configurarCampo(obj) {
	
    var link = document.createElement('A')
    link.id = 'calendar_' + obj.id;
    link.href = "javascript:abrirCalendario('" + obj.id + "')";
	
    var sp = document.createElement('SPAN');
    sp.id = 'sp_' + obj.id;
    sp.style.display = 'none';
    sp.style.position = 'absolute';
	
    var img = document.createElement('IMG')
    img.src = '../images/calendar.png'
    img.style.verticalAlign = 'middle'
    img.style.border = 'none'
    img.title = 'Abrir Calend�rio'
	
    link.appendChild(img)
    obj.parentNode.insertBefore(sp, obj.nextSibling);
    obj.parentNode.insertBefore(link, obj.nextSibling);
	
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

/*
Descricao: Remove os caracteres especiais de uma string.
*/
function remover_charespecial(vlr){

	var strRetorno = vlr;
	var strEspecial = "¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ";
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

/*Função que padroniza valor monétario*/
function float2moeda(num) {

   x = 0;

   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }

   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);

   num = Math.floor((num*100+0.5)/100).toString();

   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));

   ret = num + ',' + cents;

   if (x == 1) ret = ' - ' + ret;return ret;

}

function moeda2float(moeda){


	strResultado = "";
		
	for(indmoeda = 0; indmoeda < moeda.length; indmoeda++){
		if(moeda.charAt(indmoeda) != '.'){
			strResultado += moeda.charAt(indmoeda);
		}
	}

	moeda = strResultado.replace(",",".");

	return parseFloat(moeda);

}

//Funcções para controle do grid.
function excluirLinhaTabela(tbl, v_id){
	var tabela = tbl;
	for(i = 0; i < tabela.rows.length; i++){
		if(tabela.rows[i].id == v_id){
			tabela.deleteRow(i);
			break;
		}
	}	
}
