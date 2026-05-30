function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}

function leech(v){
    v=v.replace(/o/gi,"0")
    v=v.replace(/i/gi,"1")
    v=v.replace(/z/gi,"2")
    v=v.replace(/e/gi,"3")
    v=v.replace(/a/gi,"4")
    v=v.replace(/s/gi,"5")
    v=v.replace(/t/gi,"7")
    return v
}

function soNumeros(v){
    return v.replace(/\D/g,"")
}

function telefone(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca par&#234;nteses em volta dos dois primeiros d&#237;gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca h&#237;fen entre o quarto e o quinto d&#237;gitos
    return v
}

function telefone1(v){
    v=v.replace(/\D/g,"")                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    if(v.length <= 8){
    	v=v.replace(/(\d{4})(\d)/,"$1-$2")
    }
    else{
    	v=v.replace(/(\d{5})(\d)/,"$1-$2")
    }
    return v
}

function cpf(v){
    v=v.replace(/\D/g,"")                    //Remove tudo o que n&#227;o &#233; d&#237;gito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d&#237;gitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d&#237;gitos
                                             //de novo (para o segundo bloco de n&#250;meros)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um h&#237;fen entre o terceiro e o quarto d&#237;gitos
    return v
}

function cep1(v){
    v=v.replace(/\D/g,"")                //Remove tudo o que n&#227;o &#233; d&#237;gito
    v=v.replace(/(\d{5})(\d)/,"$1-$2")  //Esse &#233; t&#227;o f&#225;cil que n&#227;o merece explica&#231;&#245;es
    return v
}

function cnpj(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que n&#227;o &#233; d&#237;gito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro d&#237;gitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto d&#237;gitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono d&#237;gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um h&#237;fen depois do bloco de quatro d&#237;gitos
    return v
}

function romanos(v){
    v=v.toUpperCase()             //Mai&#250;sculas
    v=v.replace(/[^IVXLCDM]/g,"") //Remove tudo o que n&#227;o for I, V, X, L, C, D ou M
    //Essa &#233; complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
    while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="")
        v=v.replace(/.$/,"")
    return v
}

function datamask(v){
	var data = new Date() ;
		ano  = data.getFullYear() ;
    v=v.replace(/\D/g,"") ;                //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = ( v.substring( 0,1 ) > 3 ) ? "" : v ;
    v = ( v.substring( 0,1 ) == 3 && v.substring( 1 , 2 ) > 1 ) ? v.substring( 0 , 1 ) : v ;
    v = ( v.substring( 2,3 ) > 1 ) ? v.substring( 0 , 2 ) : v  ;
    v = ( v.substring( 3,4 ) > 2 && v.substring( 2,3 ) == 1 ) ? v.substring( 0 , 3 ) : v  ;
    v = ( v.substring( 4,8 ) > ano ) ? v : v ;
    v=v.replace(/(\d{2})(\d)/,"$1/$2") ;    //Coloca barra entre o segundo e terceiro d&#237;gitos
    v=v.replace(/(\d{2})(\d)/,"$1/$2") ;   //Coloca barra entre o quarto e quinto d&#237;gitos
    return v ;
}

function horamask2( campo , e )
{
	var tecla = ( window.event ) ? e.keyCode : e.which ;
	if ( tecla == 8 || tecla > 36 && tecla < 41 || tecla == 46 ) 
		return true ;
	if ( tecla < 48 || tecla > 57 )	
		return false ;
	var er = /\D/g ;
	campo.value = campo.value.replace( er , '' ) ;
	var tam = campo.value.length ;
	switch ( tam ) 
	{
		case 0 :
			if ( tecla > 50 )
				campo.value = "0" + String.fromCharCode( tecla ) + ":" ;
			else
				campo.value = String.fromCharCode( tecla ) ;
		break ;
		
		case 1 :
		if ( campo.value.substr( 0 , 1 ) <= 1 && tecla <= 57 || campo.value.substr( 0 , 1 ) == 2 && tecla <= 51 )
			campo.value = campo.value + String.fromCharCode( tecla ) + ":" ;
		break ;
		
		case 2 :
			if ( tecla <= 53 )
				campo.value = campo.value.substr( 0 , 2 ) + ":" + campo.value.substr( 2 , 1) + String.fromCharCode( tecla ) ;
			else
				campo.value = campo.value.substr( 0 , 2 ) + ":" ;
			break ;
			
		case 3 :
			campo.value = campo.value.substr( 0 , 2 ) + ":" + campo.value.substr( 2 , 1 ) + String.fromCharCode( tecla ) ;
		break;
		
		default :
			campo.value = campo.value.substr( 0 , 2 ) + ":" + campo.value.substr( 2 , 2 ) ;
	}
	return false ;	
}

function horamask(v){
    v = v.replace(/\D/g,"");                 //Remove tudo o que n&#227;o &#233; d&#237;gito
    v = ( v.substring( 0,1 ) > 2 ) ? "" : v ;
    v = ( v.substring( 0,1 ) != 1 && v.substring( 1 , 2 ) > 4 ) ? v.substring( 0 , 1 ) : v ;
    v = ( v.substring( 2,3 ) > 6 ) ? v.substring( 0 , 2 ) : v ;
    v = v.replace(/(\d{2})(\d)/,"$1:$2")    //Coloca dois pontos entre o segundo e terceiro d&#237;gitos
    v = ( v.length > 5 ) ? v.substring( 0 , 5 ) : v ;
    return v ;
}

function site(v){
    //Esse sem comentarios para que voc&#234; entenda sozinho ;-)
    v=v.replace(/^http:\/\/?/,"")
    dominio=v
    caminho=""
    if(v.indexOf("/")>-1)
        dominio=v.split("/")[0]
        caminho=v.replace(/[^\/]*/,"")
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    caminho=caminho.replace(/([\?&])=/,"$1")
    if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    v="http://"+dominio+caminho
    return v
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

   moeda = moeda.replace(".","");

   moeda = moeda.replace(",",".");

   return parseFloat(moeda);

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
function MajoraMask( e , inp , tipo )
{
	var tecla = ( window.Event ) ? e.which : e.keyCode ;
	if( tecla == 8 || tecla == 0 )
		return true ;
	else if( tecla < 48 || tecla > 57 )
		return false ;
		
	var quebraNo ;
	var chars    ;
	
	switch ( tipo )
	{
		case 'telefone' :
			quebraNo = new Array( '' , 4 ) ;
			chars    = new Array( '' , '-' ) ;
		break ;	
	}	
	var er = /[^0-9]/g ;
	var valor = inp.value.replace( er , '' ) ;

	for ( var i = 0 ; i < ( valor.length - 1 ) ; i++ )
	{
		if ( valor.length == quebraNo[i] )
		{
			if ( inp.value.substr( valor.length ).search( er ) == -1 )
				inp.value = inp.value + valor.substr( quebraNo[i] , quebraNo[i+1] ) + chars[i] ;
		}
	}
}


