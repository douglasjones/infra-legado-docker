
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

function custo_atual_lead(pk,operadora_pk,leads_pk){
    var url = 'leads_proc.php';
    var pars = '&acao=custo_atual_lead&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&vl_custo_atual='+pk; 
   
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
function score_lead(pk,operadora_pk,leads_pk){
    var url = 'leads_proc.php';
    var pars = '&acao=score_leade&leads_pk='+leads_pk+'&operadora_pk='+operadora_pk+'&n_score='+pk; 
    
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

function msg(){
    //alert('Atualização executada com sucesso!!!');
   location.reload(); 
}
function sl_operadora(pk){
    if(pk!=''){
        document.getElementById("status_cliente_pk").disabled = false; 
        document.getElementById("status_base_pk").disabled = false; 
        document.getElementById("dt_ativacao_ini").disabled = false; 
        document.getElementById("dt_ativacao_fim").disabled = false; 
        document.getElementById("dt_venc_contrato_ini").disabled = false;
        document.getElementById("dt_venc_contrato_fim").disabled = false;
        document.getElementById("qtdeli_ini").disabled = false;
        document.getElementById("qtdeli_fim").disabled = false;
        document.getElementById("qtdeli_dados_ini").disabled = false;
        document.getElementById("qtdeli_dados_fim").disabled = false;  
    }else{
        document.getElementById("status_cliente_pk").value = ""; 
        document.getElementById("status_base_pk").value = ""; 
        document.getElementById("dt_ativacao_ini").value = ""; 
        document.getElementById("dt_ativacao_fim").value = ""; 
        document.getElementById("dt_venc_contrato_ini").value = "";
        document.getElementById("dt_venc_contrato_fim").value = "";
        document.getElementById("qtdeli_ini").value = "";
        document.getElementById("qtdeli_fim").value = "";
        document.getElementById("qtdeli_dados_ini").value = "";
        document.getElementById("qtdeli_dados_fim").value = "";

        document.getElementById("status_cliente_pk").disabled = true; 
        document.getElementById("status_base_pk").disabled = true; 
        document.getElementById("dt_ativacao_ini").disabled = true; 
        document.getElementById("dt_ativacao_fim").disabled = true; 
        document.getElementById("dt_venc_contrato_ini").disabled = true;
        document.getElementById("dt_venc_contrato_fim").disabled = true;
        document.getElementById("qtdeli_ini").disabled = true;
        document.getElementById("qtdeli_fim").disabled = true;
        document.getElementById("qtdeli_dados_ini").disabled = true;
        document.getElementById("qtdeli_dados_fim").disabled = true;  
    }
}
function enviar_email(operador_pk){
    var codlead =  document.getElementById('codlead').value;
    var razaosocial =  document.getElementById('razaosocial').value;
    var ddd =  document.getElementById('ddd').value;
    var tel =  document.getElementById('tel').value;
    var CodGerenteConta =  document.getElementById('CodGerenteConta').value;
    var NomeContato =  document.getElementById('NomeContato').value;
    var DDD_fone =  document.getElementById('DDD_fone').value;
    var fone =  document.getElementById('fone').value;
    var emailpara =  document.getElementById('email').value;
    var nome =  document.getElementById('nome').value;
    
    
    if(document.getElementById('CodGerenteConta').value==""){
        alert("Cadastre o consultor");
        return false
    } 
    
    var url = 'leads_proc.php';
    
    var pars = '&acao=enviar_email&codlead='+codlead+'&razaosocial='+razaosocial+'&ddd='+ddd+'&tel='+tel+'&CodGerenteConta='+CodGerenteConta+'&NomeContato='+NomeContato+'&DDD_fone='+DDD_fone+'&fone='+fone+'&email='+emailpara+'&operador_pk='+operador_pk+'&nome='+nome; 

    //Inicio da rotina do ajax
    var myAjax = new Ajax.Request
        (url,
                {
                method:'get',
                parameters: pars,
                onSuccess:
                        function(transport){
                           msa(transport.responseText);
                        },
                onFailure:
                        function(){							
                            alert('erro');
                        }
                }
    );    
}

 function msa(){
    alert('Operação executada com sucesso');
    location.reload();

}



