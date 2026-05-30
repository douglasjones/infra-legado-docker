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



