/*Propriedade Validate
	datatype={string,numeric,		Determina o tipo de dados
			  date,time,shorttime,
			  email,cnpj,cep}
	required 						Determina se o campo é obrigatório
	regexp=<regexp>					Uma expressão regular para validação
	min=<min value>					Determina o valor mínimo do campo (>=)
	max=<max value>					Determina o valor máximo do campo (<=)
	decimals=<num decimas digits>	Determina a quantidade de digitos após a vígula para números*/

function daysInMonth(month,year) {
	var dd = new Date(year, month, 0);
	return dd.getDate();
}

function selecionarDia(vdia, vmes, vano, txt_id, sp_id){
	
	if (vdia.toString().length < 2)
		vdia = "0"+vdia;
		
	if(vmes.toString().length < 2)
		vmes = "0"+vmes;
		
	var txt = document.getElementById(txt_id);
	txt.value = (vdia +"/"+vmes+"/"+vano);
	
	fecharCalendario(sp_id);
}

function mesAnterior(mes, ano, sp_id, txt_id){

	//calcula o mes anterior
	if(mes == 1){
		mes = 12
		ano = ano - 1;
	}
	else{
		mes = mes - 1;
	}
		

	var txt = document.getElementById(txt_id);
	var dv = document.getElementById(sp_id);
	
	dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
	dv.style.display = 'block';
}

function anoAnterior(mes, ano, sp_id, txt_id){
	//calcula o mes anterior
	ano = ano -1;		

	var txt = document.getElementById(txt_id);
	var dv = document.getElementById(sp_id);
	
	dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
	dv.style.display = 'block';
}

function mesProximo(mes, ano, sp_id, txt_id){
	//calcula o mes anterior
	if(mes == 12){
		mes = 1
		ano = ano + 1;
	}
	else{
		mes = mes + 1;
	}
	var txt = document.getElementById(txt_id);
	var dv = document.getElementById(sp_id);
	
	dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
	dv.style.display = 'block';
	
}
function anoProximo(mes, ano, sp_id, txt_id){
	ano = ano + 1;
	var txt = document.getElementById(txt_id);
	var dv = document.getElementById(sp_id);
	
	dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
	dv.style.display = 'block';
}

function fecharCalendario(sp_id){
	var dv = document.getElementById(sp_id);
	dv.style.display = 'none';
}

function criarCalendario(mes, ano, sp_id, txt_id){

	var arrTituloMes = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
	var arrTituloSemana = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'];
	
	var strTabela = "";
	strTabela+="<table border=1 cellspacing=0 cellpadding=0>";
	strTabela+="<tr><td bgcolor=white>";
	strTabela+="<table border='0' cellspacing=1 cellpadding=1>";
	//strTabela+="<tr bgcolor='#003366'>";
	strTabela+="<tr bgcolor='black'>";
	strTabela+="<td align=center colspan='6' align='center'>";
	strTabela+="<input title='Voltar Mês' type='button' value='<<' id='ano_voltar' name='ano_voltar' onclick='anoAnterior("+mes+","+ano+", "+'"'+sp_id+'"'+", "+'"'+txt_id+'"'+")' />";
	strTabela+="<input title='Voltar Asno' type='button' value='<' id='mes_voltar' name='mes_voltar' onclick='mesAnterior("+mes+","+ano+", "+'"'+sp_id+'"'+", "+'"'+txt_id+'"'+")'  />";
	strTabela+="&nbsp;<span id='sp_mes'><font face='verdana' size='2'  color='white'><b>"+arrTituloMes[mes]+"</b></font></span>&nbsp;<font color='white'><b>/</b></font>&nbsp;<span id='sp_ano'><font  face='verdana' size='2' color='white'><b>"+ano+"</b></font></span>&nbsp;";
	strTabela+="<input title='Avançar Mês' type='button' value='>' id='mes_avancar' name='mes_avancar' onclick='mesProximo("+mes+","+ano+", "+'"'+sp_id+'"'+", "+'"'+txt_id+'"'+")'  />";
	strTabela+="<input title='Avançar Ano' type='button' value='>>' id='ano_avancar' name='ano_avancar' onclick='anoProximo("+mes+","+ano+", "+'"'+sp_id+'"'+", "+'"'+txt_id+'"'+")'  />";
	strTabela+="</td>";
	strTabela+="<td align='center'>&nbsp;";
	strTabela+="<input title='Fechar Calendario' type='button' value='X' id='bt_fechar' name='bt_fechar' onclick='fecharCalendario("+'"'+sp_id+'"'+")'>";
	strTabela+="&nbsp;</td>";
	strTabela+="</tr>";
	strTabela+="<tr bgcolor='#838383'>";
	for(i = 0; i< 7; i++){
		strTabela+="<th><font color='white'  face='verdana' size='2' >"+arrTituloSemana[i]+"</font></th>";
	}
	strTabela+="</tr>";
	//calcula a quantidade de semanas;
	
	var dhoje = new Date();
	var hoje_dia = dhoje.getDate();
	var hoje_mes = dhoje.getMonth();
	var hoje_ano = dhoje.getFullYear();
	
	if(hoje_mes == 11){
		hoje_mes = 0;
	}
	else{
		hoje_mes ++;
	}	
	
	var diaSemana = 1;
	var ultimoDia = daysInMonth(mes, ano);
	var ddia = new Date(ano, (mes-1), 1);
	var diaSemanaPrimeiroDia = ddia.getDay();
	var diaAtual = 1;
	for(linha = 0; linha <= 5; linha++){
		
		if(diaAtual <= ultimoDia){
			strTabela+="<tr>";
			for (coluna = 0; coluna <= 6; coluna++){
				if (coluna == 0 || coluna == 6){
					cor_celula='#D6D6D6'
					cor_letra = 'red';
					
				}
				else{
					cor_celula='white';
					cor_letra = 'black';
				}
				
				//verifica se o dia é hoje
				if(hoje_dia == diaAtual){
					if(hoje_mes == mes){
						if(hoje_ano == ano){
							cor_celula='black';
							cor_letra = 'white';
						}
					}
				}
				
				if(linha == 0){
					if(coluna < diaSemanaPrimeiroDia){
						strTabela+="<td bgcolor='"+cor_celula+"'>&nbsp;</td>";
					}
					else{
						strTabela+="<td bgcolor='"+cor_celula+"' align=center><a style='text-decoration:none' href='javascript:selecionarDia("+diaAtual+","+mes+","+ano+","+'"'+txt_id+'"'+", "+'"'+sp_id+'"'+")'><font face='verdana' size='2' color='"+cor_letra+"'>"+diaAtual+"</font></a></td>";
						diaAtual++;
					}
				}
				else{
					if(diaAtual <= ultimoDia){
						strTabela+="<td  bgcolor='"+cor_celula+"' align=center><a style='text-decoration:none' href='javascript:selecionarDia("+diaAtual+","+mes+","+ano+","+'"'+txt_id+'"'+", "+'"'+sp_id+'"'+")'><font face='verdana' size='2'  color='"+cor_letra+"'>"+diaAtual+"</font></a></td>";
						diaAtual++;
					}
					else{
						strTabela+="<td bgcolor='"+cor_celula+"'>&nbsp;</td>";
					}				
				}
			}
			strTabela+="</tr>";
		}
	}
	strTabela+="</table>";
	strTabela+="</td></tr>";		
	
	strTabela+="</table>";
	return strTabela;
}

function abrirCalendario(objname){
	
	var txt = document.getElementById(objname);
	var dv = document.getElementById('sp_'+objname);
	var hoje = new Date();
	var dia = hoje.getDate();
	var mes = hoje.getMonth();
	var ano = hoje.getFullYear();
	
	if(mes == 12){
		mes = 0;
	}
	else{
		mes ++;
	}
		
	if(txt.value.length == 10){
		arrData = txt.value.split("/");
		mes = parseInt(stripLeftZeros(arrData[1]));
		ano = parseInt(arrData[2]);
	}
	
	dv.innerHTML = criarCalendario(mes, ano, dv.id, txt.id);
	dv.style.display = 'block';
}

function isValidTelefone(v_tel){
	v_tel=v_tel.replace(/\D/g,"");
	if(v_tel.length < 8){
		return false;
	}
	return true;
}

function initFormValidation(){
	for(var i = 0; i < document.forms.length; i++){
		for(var j = 0; j < document.forms[i].elements.length; j++){
			var obj = document.forms[i].elements[j]
			if(obj.getAttribute('validate')){
				if(!obj.validateFunction){
					var opt = obj.getAttribute('validate').split(';')
					obj.validateRequired = false
					obj.validateFunction = objectValidate
					for(var l = 0; l < opt.length; l++){
						if(/^datatype/i.test(opt[l]))
							obj.validateDataType = opt[l].replace(/^datatype=/i, '')
						if(/^required/i.test(opt[l]))
							obj.validateRequired = true
						if(/^regexp/i.test(opt[l]))
							obj.validateRegExp = opt[l].replace(/^regexp=/i, '')
						if(/^min/i.test(opt[l]))
							obj.validateMin = opt[l].replace(/^min=/i, '')
						if(/^max/i.test(opt[l]))
							obj.validateMax = opt[l].replace(/^max=/i, '')
						if(/^decimals/i.test(opt[l]))
							obj.validateDecimals = opt[l].replace(/^decimals=/i, '')
					}
					if(obj.validateDataType && obj.validateDataType == 'date'){
						
						var link = document.createElement('A')
						link.id = 'calendar_' + obj.id
						link.href = "javascript:abrirCalendario('"+obj.id+"')";
						
						var sp = document.createElement('SPAN');
						sp.id = 'sp_'+obj.id;
						sp.style.display = 'none';
						sp.style.position = 'absolute';
						
						var img = document.createElement('IMG')
						img.src = '../../images/calendar.png'
						img.style.verticalAlign = 'middle'
						img.style.border = 'none'
						img.title = 'Abrir Calendário'
						link.appendChild(img)
						obj.parentNode.insertBefore(sp, obj.nextSibling);
						obj.parentNode.insertBefore(link, obj.nextSibling);
						
												
					}
					if(obj.validateDataType && (obj.validateMin || obj.validateMax)){
						switch(obj.validateDataType){
							case 'numeric':
								if(obj.validateMin) obj.validateMin = parseFloat(obj.validateMin)
								if(obj.validateMax) obj.validateMax = parseFloat(obj.validateMax)
								break
							case 'date':
								if(obj.validateMin && isDate(obj.validateMin))
									obj.validateMin = new Date(obj.validateMin)
								else
									obj.validateMin = null
								if(obj.validateMax && isDate(obj.validateMax))
									obj.validateMax = new Date(obj.validateMax)
								else
									obj.validateMax = null
								break
						}
					}
				}
			}
		}
	}
}

function objectValidate(){
	this.style.borderColor = 'red'
	this.style.borderWidth = '3px'
	
	if(this.validateRequired && this.value == ''){
			alert('Valor deve ser especificado.')
			this.focus()
			if(this.select)
				this.select()
			return false
		}
	if(this.validateDataType){
		var re;
		var func = true;
		switch(this.validateDataType){
			case 'string':
				re = /^.*$/;
				break;
			case 'numeric':
				re = '/^[-+]?[0-9]+';
				if(this.validateDecimals)
					re = re + '[.]?[0-9]{0,' + this.validateDecimals + '}?';
				re = eval(re + '$/');
				break;
			case 'date':
				re = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[0-9]{4}$/;
				func = isDate(this.value);
				break;
			case 'time':
				re = /^([01][0-9]|2[0-3]):[0-5][0-9]:[0-5][0-9]$/;
				break;
			case 'shorttime':
				re = /^([01][0-9]|2[0-3]):[0-5][0-9]$/;
				break;
			case 'email':
				re = /^[A-Za-z0-9_.-]+@([A-Za-z0-9][A-Za-z0-9_-]*[A-Za-z0-9]*\.)+[A-Za-z]{2,4}$/;
				break;
			case 'cnpj':
				re = /^\d{2}.\d{3}.\d{3}\/\d{4}\-\d{2}$/;
				func = isCNPJ(this.value);
				break;
			case 'cpf':
				re = /^\d{3}.\d{3}.\d{3}\-\d{2}$/;
				func = isCPF(this.value);
				break;
			case 'cnpj_cpf':
				re = /^(\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}|\d{3}\.\d{3}\.\d{3}\-\d{2})$/;
				func = isCNPJ(this.value) || isCPF(this.value);
				break;
			case 'cep':
				re = /^\d{5}-\d{3}$/;
				break;
			case 'tel':
				v = this.value.replace(/\D/g,"");
				if(v.length <= 8)
					re = /^\d{4}-\d{4}$/;
				else
					re = /^\d{5}-\d{4}$/;
					
				break;
		}
		if(this.value != ''){
			if(!re.test(this.value)){
				alert('Formato inválido.')
				this.focus()
				if(this.select)
					this.select()
				return false
			}
			if(!(re.test(this.value) && func)){
				alert('Valor inválido.')
				this.focus()
				if(this.select)
					this.select()
				return false
			}
		}
	}
	if(this.validateRegExp && this.value != ''){
		var re = eval(this.validateRegExp)
		if(!re.test(this.value)){
			alert('Valor inválido.')
			this.focus()
			if(this.select)
				this.select()
			return false
		}
	}
	if(this.validateMin && this.value != '')
		if(this.value < this.validateMin){
			alert('Valor deve ser maior ou igual à ' + this.validateMin + '.')
			this.focus()
			if(this.select)
				this.select()
			return false
		}
	if(this.validateMax && this.value != '')
		if(this.value > this.validateMax){
			alert('Valor deve ser menor ou igual à ' + this.validateMax + '.')
			this.focus()
			if(this.select)
				this.select()
			return false
		}
	this.style.borderColor = ''
	this.style.borderWidth = ''
	return true
}

function validateForm(frm){
	var ret = true
	for(i = 0; i < frm.elements.length; i++){
		if(frm.elements[i].validateFunction){
			ret = ret && frm.elements[i].validateFunction()
		}
	}
	return ret
}

function isDate(value){
	if(!(/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[012])\/[0-9]{4}$/).test(value))
		return false
	var parts = value.split('/')
	var dt = new Date(parts[2], parts[1] - 1, parts[0])
	if(!dt || !(dt.getDate() == parts[0] && (dt.getMonth() + 1) == parts[1] && dt.getFullYear() == parts[2]))
		return false
	return true
}

function isCNPJ(CNUMB){
	return Verify(CNUMB, 'CNPJ')
}

function isCPF(CNUMB){
	return Verify(CNUMB, 'CPF')
}

function ClearStr(str, chr){
	var cx;
	while((cx = str.indexOf(chr)) != -1){		
		str = str.substring(0, cx) + str.substring(cx + 1);
	}
	return(str);
}

function ParseNumb(c){
  c = ClearStr(c, '-');
  c = ClearStr(c, '/');
  c = ClearStr(c, ',');
  c = ClearStr(c, '.');
  c = ClearStr(c, '(');
  c = ClearStr(c, ')');
  c = ClearStr(c, ' ');
  if((parseFloat(c) / c != 1)){
		if(parseFloat(c) * c == 0){
			return(c);
		}else{
			return(0);
		}
	}else{
		return(c);
	}
}

function Verify(CNUMB, CTYPE){
	CNUMB = ParseNumb(CNUMB)
	if(CNUMB == 0){
		return(false);
	}else{
		var g = CNUMB.length - 2;
		if(TestDigit(CNUMB, CTYPE, g)){
			g = CNUMB.length - 1;
			if(TestDigit(CNUMB, CTYPE, g)){	
				return(true);
			}else{
				return(false);
			}
		}else{
			return(false);
		}
	}
}

function TestDigit(CNUMB, CTYPE, g){
	var dig = 0;
	var ind = 2;
	for(var f = g;f > 0;f--){
		dig += parseInt(CNUMB.charAt(f - 1)) * ind;
		if (CTYPE == 'CNPJ'){
			if(ind > 8){
				ind = 2;
			}else{
				ind++;
			}
		}else{
			ind++;
		}
	}
	dig %= 11;
	if(dig < 2){
		dig = 0;
	}else{
		dig = 11 - dig;
	}
	if(dig != parseInt(CNUMB.charAt(g))){
		return(false);
	}else{
		return(true);
	}
}

/*var dt = new DatePicker()
dt.days = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab', 'Dom']
dt.months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']
dt.setShowNone(false)
dt.setShowToday(false)*/

var calendar = Class.create();

calendar.prototype = {
	initialize: function(link){
		this.dt = new DatePicker()
		this.dt.setShowNone(false)
		this.dt.setShowToday(false)
		this.dt.setFirstWeekDay(6)
		this.dt.onchange = function(){
			var d = this.dt.getDate()
			var day = d.getDate().toString()
			day = (day.length < 2?'0':'') + day
			var month = (d.getMonth() + 1).toString()
			month = (month.length < 2?'0':'') + month
			this.obj.value = day + '/' + month + '/' + d.getFullYear()
			this.obj.focus()
			if(this.obj.select){
				this.obj.select()
			}
			closeSimpleBox()
		}.bind(this);

		this.obj = document.getElementsByName(link.id.substring(9))[0]
		Event.observe(link, 'click', this.openCalendar.bindAsEventListener(this));
	},
	openCalendar: function(e){
		createSimpleBox(this.dt.create())
		Event.stop(e);
	}
}


Event.observe(window, 'load', initFormValidation)