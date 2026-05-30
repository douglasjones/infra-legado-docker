/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function enviar(){
    var frm = document.forms[0];
    
    if(document.getElementById('termino').value==""){	
        alert('Informe o horário de termino !')
        document.getElementById('termino').style.border = 'solid 3px red';
        document.getElementById('termino').focus();
        return false;
    }  
    
    if(document.getElementById('codstatus').value==""){	
        alert('Selecione a classificação da visita !')
        document.getElementById('codstatus').style.border = 'solid 3px red';
        document.getElementById('codstatus').focus();
        return false;
    }  
    
    if(document.getElementById('codstatus').value==2){
       if(document.getElementById('codmotivolead').value==""){
        alert('Selecione o motivo do Sem Interesse !');
        document.getElementById('codmotivolead').style.border = 'solid 3px red';
        document.getElementById('codmotivolead').focus();
        return false;
       } 
    }
    
    if(document.getElementById('codstatus').value==6){
       if(document.getElementById('dt_prev_receb_conta').value==""){
        alert('Informe a data de previsão !');
        document.getElementById('dt_prev_receb_conta').style.border = 'solid 3px red';
        document.getElementById('dt_prev_receb_conta').focus();
        return false;
       } 
    }

    frm.acao.value = "gravar";	
    frm.submit();
}
function seleciona_itens(id){ 

    if(id==''){
        document.getElementById('div_seleciona_operadora').style.display = "none";
        document.getElementById('div_formulario_seminteresse').style.display = "none"; 
         document.getElementById('div_dados_operadoras').style.display = "none";

    }else if(id==1){     

        document.getElementById('div_formulario_seminteresse').style.display = "none";
        document.getElementById('div_dados_operadoras').style.display = "none";
        if(document.getElementById('codtipo').value==1){
            document.getElementById('div_seleciona_operadora').style.display = "inline";
            document.getElementById('div_botao_seminteresse').style.display = "none";  
            document.getElementById('div_botao_proposta').style.display = "inline";
        }else{
            document.getElementById('div_seleciona_operadora').style.display = "none";
           
            document.getElementById('div_botao_seminteresse').style.display = "inline";  
            document.getElementById('div_botao_proposta').style.display = "none"; 
        }
        
    }else if(id==2){
        document.getElementById('div_seleciona_operadora').style.display = "none";
        document.getElementById('div_formulario_seminteresse').style.display = "inline";
        document.getElementById('div_dados_operadoras').style.display = "inline";        

        document.getElementById('div_botao_seminteresse').style.display = "inline";
        document.getElementById('div_botao_proposta').style.display = "none";    
    }
}

function add_new_proposta(){    
   var operador_pk = "";
   
    if(document.getElementById('termino').value==""){	
        alert('Informe o horário de termino !')
        document.getElementById('termino').style.border = 'solid 3px red';
        document.getElementById('termino').focus();
        return false;
    }  
    
    //QTDE DE OPERADORAS LIBERADAS 
    
    var radio = document.getElementById('qtde_operador').value;  
 
    for (i = 0; i < radio; i++){  
          
        if(document.getElementById('operador_pk_'+i).checked == true){ 
          
            operador_pk = document.getElementById('operador_pk_'+i).value;           
        }     
    }
    

    if(operador_pk==""){
        alert('Selecione a operadora da proposta !');
        return false;
    }
   
   var leads_pk = document.getElementById('leads_pk').value;  
   var agenda_visita_pk = document.getElementById('agenda_visita_pk').value;   
   var termino = document.getElementById('termino').value;
   
   var status_classificacao_pk = document.getElementById('codstatus').value;
   var informacoes1 = document.getElementById('informacoes1').value;
   
   NewWindow("../../vendas/leads/propostas_cad_form.php?acao=ins&codlead="+leads_pk+"&agendalead_pk="+agenda_visita_pk+"&operador_pk="+ operador_pk+"&termino="+ termino+"&status_classificacao_pk="+ status_classificacao_pk+"&informacoes1="+informacoes1, 1160, 600)	
   
   self.close();
}
function cliente(pk,operadora_pk,leads_pk){
    
    var url = 'leads_proc.php';
    var pars = '&acao=cliente&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&lead_cliente='+pk; 
  
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){
                               msg(transport.responseText,pk);
                            },
                    onFailure:
                            function(){							
                                alert('erro');
                            }
                    }
	);    
}

function base(pk,operadora_pk,leads_pk){
    var url = 'leads_proc.php';
    var pars = '&acao=cliente_base&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&lead_cliente_base='+pk; 

	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){
                              msg(transport.responseText,pk);
                            },
                    onFailure:
                            function(){							
                                alert('erro');
                            }
                    }
	);    
}

function dt_ativacao_contrato(dt,operadora_pk,leads_pk){

    var url = 'leads_proc.php';
    var pars = '&acao=dt_ativacao_contrato&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&dt_ativacao='+dt; 

	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){
                               msg(transport.responseText,dt);
                            },
                    onFailure:
                            function(){							
                                alert('erro');
                            }
                    }
	);    
}



function vencimento_contrato(dt,operadora_pk,leads_pk){

    var url = 'leads_proc.php';
    var pars = '&acao=dt_vencimento_contrato&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&dt_vencimento='+dt; 

	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){
                               msg(transport.responseText,dt);
                            },
                    onFailure:
                            function(){							
                                alert('erro');
                            }
                    }
	);    
}

function classificacao_operadora_lead(pk,operadora_pk,leads_pk){
    
    var url = 'leads_proc.php';
    var pars = '&acao=classificacao_operadora_lead&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&classificacao_operadora_pk='+pk; 
    
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){
                               msg(transport.responseText,pk);
                            },
                    onFailure:
                            function(){							
                                alert('erro');
                            }
                    }
	);    
}

function qtde_voz_lead(pk,operadora_pk,leads_pk){
    var url = 'leads_proc.php';
    var pars = '&acao=qtde_voz_leade&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&qtde_voz='+pk; 
    
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){
                               msg(transport.responseText,pk);
                            },
                    onFailure:
                            function(){							
                                alert('erro');
                            }
                    }
	);    
}

function qtde_dados_lead(pk,operadora_pk,leads_pk){
    var url = 'leads_proc.php';
    var pars = '&acao=qtde_dados_leade&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&qtde_dados='+pk; 
    
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){
                               msg(transport.responseText,pk);
                            },
                    onFailure:
                            function(){							
                                alert('erro');
                            }
                    }
	);    
}

