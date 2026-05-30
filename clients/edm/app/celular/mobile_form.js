function logoff(){
	location.href = 'index.php?logoff=1';
}
function printmensagem(strRetorno){    
    var arrCampos = strRetorno.split("////");
    var mensagem = arrCampos[1];
    
    //SISTEMA BLOQUEAD
    if(mensagem=='bloqueado'){
        document.getElementById('login').value = '';
        document.getElementById('senha').value = '';
        document.getElementById('printms').innerHTML = '<font color="red"><b>Acesso desabilitado!<br>entre em contato com o administrador do sistema</b></font>';      
        return false;
    }
    //LOGIN INCORRETO
    if(mensagem =='nlogin'){  
        document.getElementById('login').value = '';
        document.getElementById('senha').value = '';
        document.getElementById('printms').innerHTML = '<font color="red"><b>usuario/senha inv&aacute;lidos</b></font>';           
        return false;
    }    
    //HORARIO DE UTILIZACAO ERRADO
    if(mensagem =='nhorario'){  
        document.getElementById('login').value = '';
        document.getElementById('senha').value = '';
        document.getElementById('printms').innerHTML = '<font color="red"><b>Horário não permitido<br>para acesso ao sistema</b></font>';           
        return false;
    } 
    if(mensagem =='login'){  
        location.href = 'mobile_inicio_form.php';
    }
}

function valida_campos_login(){
        
	var d = document.forms[0];
    
	if(d.login.value==""){
		document.getElementById('login').style.border = 'solid 3px red';              
		d.login.focus();
		return false;
	}   
    
	if(d.senha.value==""){
		document.getElementById('senha').style.border = 'solid 3px red';
		d.senha.focus();
		return false;
	}       
    
    var login = d.login.value;
    var senha = d.senha.value;
     
    var url = 'mobile_login.php';
    
	var pars = 'login='+login+'&senha='+senha;
    
	//Inicio da rotina do ajax

	var myAjax = new Ajax.Request(url,
					{
					method:'get',
					parameters: pars,
					onSuccess:
						function(transport){							
                            printmensagem(transport.responseText);
						},
					onFailure:
						function(){			
						  
							//erroProcurarCentroCusto(rowid);
						}
					}
				);

}
function pesq_lead(){
    var d = document.forms[0];
    
    d.submit();  
}	
function salvar_lead(){
    var d = document.forms[0];    

	if(d.razaosocial.value==""){
		document.getElementById('razaosocial').style.border = 'solid 3px red';              
		d.razaosocial.focus();
		return false;

	}
	if(d.ddd.value==""){
		document.getElementById('ddd').style.border = 'solid 3px red';              
		d.ddd.focus();
		return false;
	}               
	if(d.tel.value==""){
		document.getElementById('tel').style.border = 'solid 3px red';              
		d.tel.focus();
		return false;
	} 
    if(d.codlead.value==""){
        d.acao.value = "ist";    
    }else{
        d.acao.value = "alt";
    }    
    d.submit();           
}
function salvar_agenda(){    
    var d = document.forms[0];    
    var qtv = $('qtv');
    var qtdop = $('qtdop');
    
    if(d.cep.value==""){
		document.getElementById('cep').style.border = 'solid 3px red';
        alert('Preencher Cep da Visita!');              
		d.cep.focus();
		return false;
	}     
	if(d.endereco.value==""){
		document.getElementById('endereco').style.border = 'solid 3px red';              
		alert('Preencher Endereço da Visita!');
        d.endereco.focus();
		return false;
	}    
	if(d.numero.value==""){
		document.getElementById('numero').style.border = 'solid 3px red'; 
        alert('Preencher Número da Visita!');             
		d.numero.focus();
		return false;
	}               
	if(d.bairro.value==""){
		document.getElementById('bairro').style.border = 'solid 3px red';
        alert('Preencher Bairro da Visita!');              
		d.bairro.focus();
		return false;
	}
    if(d.cidade.value==""){
		document.getElementById('cidade').style.border = 'solid 3px red'; 
        alert('Preencher Cidade da Visita!');             
		d.cidade.focus();
		return false;
	}
    if(d.uf.value==""){
		document.getElementById('uf').style.border = 'solid 3px red';
        alert('Preencher UF da Visita!');              
		d.uf.focus();
		return false;
	} 
    if(d.codcontatolead.value==""){
		document.getElementById('codcontatolead').style.border = 'solid 3px red';
        alert('Selecionar Contato da Visita!');              
		d.codcontatolead.focus();
		return false;
	}

    if(d.codagendalead.value==""){
        if(d.datahorario.value==""){
    		document.getElementById('datahorario').style.border = 'solid 3px red'; 
            alert('Preencher Data e Horário da Visita!');             
    		d.datahorario.focus();
    		return false;
    	} 
     } 
    
	//VALIDA TAMANHO DA VISITA
	var tm_chkd = 0;//obrigatoriedade de campos 08/02/2010
	
    for (i = 0; i < qtv.value; i++){
		if(document.dados.cod_tamanho_visita[i].checked == true){
			tm_chkd++;
		}
	}	

	if(tm_chkd == 0){
		alert('Preencher o tamanho da Visita!');
		return false;
	}   
    //VALIDA A CLASSIFICA;ÁO DE LINHAS
	if(d.linha_nova.checked == false && d.linha_adicao.checked == false && d.linha_portabilidade.checked == false && d.linha_renovacao.checked == false && d.linha_migracao.checked == false && d.linha_transferencia.checked == false){
		alert('Preencher a classificação das Linhas!');
		return false;
	}
    if(d.descricao.value==""){
		document.getElementById('descricao').style.border = 'solid 3px red'; 
        alert('Preencher a Descrição da Visita!');             
		d.descricao.focus();
		return false;
	}  
    
	//checar operadoras
    
        if(d.codagendalead.value==""){            
        	var Ops_chkd = 0;
        	for (i = 0; i < qtdop.value; i++){
        		if(document.dados.operadoras[i].checked == true){
        			Ops_chkd++;
        		}
        	}
        	if(Ops_chkd == 0){
        		alert('Preencher uma Operadora!');
        		return false;
        	}
        }  
                
    
    if(d.codagendalead.value==""){
        d.acao.value = "ist";    
    }else{
        d.acao.value = "alt";
    }
    
    d.submit();           
}
function campos_lead(id){
    if (id==1) {			
    	document.getElementById('maiscamposlead').style.display = "none";
        document.getElementById('menoscamposlead').style.display = "inline"; 
        document.getElementById('dadoslead').style.display = "inline";
	}else{
		document.getElementById('maiscamposlead').style.display = "inline";
        document.getElementById('menoscamposlead').style.display = "none";	
        document.getElementById('dadoslead').style.display = "none";		
	}                
}
function campos_contato(id){
    if (id==1) {			
    	document.getElementById('mais_dados_contatos').style.display = "none";
        document.getElementById('menos_dados_contatos').style.display = "inline"; 
	}else{
		document.getElementById('mais_dados_contatos').style.display = "inline";
        document.getElementById('menos_dados_contatos').style.display = "none";		
	}                
} 
function cpfoucnpj(vlr){
	var frm = document.forms[0];
	frm.cnpj_cpf.value = "";
	if (vlr == "PJ"){
		frm.cnpj_cpf.onkeypress = function onkeypress(event) {mascara(frm.cnpj_cpf,cnpj);};
		frm.cnpj_cpf.onblur = function onblur(event) {}
	}
	else if(vlr == "PF"){
		frm.cnpj_cpf.onkeypress = function onkeypress(event) {mascara(frm.cnpj_cpf,cpf);};
		frm.cnpj_cpf.onblur = function onblur(event) {}
	}
	else{
		frm.cnpj_cpf.onkeypress = function onkeypress(event) {frm.cnpj_cpf.value = "";};
		frm.cnpj_cpf.onblur = function onblur(event) {frm.cnpj_cpf.value = "";}
	}
}
function salvar_classificacaoagenda(){
    var d = document.forms[0];    
    
     if(d.termino.value==""){
		document.getElementById('termino').style.border = 'solid 3px red';                    
		d.termino.focus();
		return false;
	} 
    if(d.codstatus.value==""){
		document.getElementById('codstatus').style.border = 'solid 3px red';                    
		d.codstatus.focus();
		return false;
	} 
    if(d.informacoes.value==""){
		document.getElementById('informacoes').style.border = 'solid 3px red';                    
		d.informacoes.focus();
		return false;
	}
    if(d.codstatus.value==2){
        if(d.codmotivolead.value==""){
    		document.getElementById('codmotivolead').style.border = 'solid 3px red';                    
    		d.codmotivolead.focus();
    		return false;
    	} 
    }       
    d.acao.value = "ist";    

    d.submit(); 
}
