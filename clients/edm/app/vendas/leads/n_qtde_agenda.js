function verifica_qtde(dt_agenda,hr_agenda,usuario_pk){
    var frm = document.forms[0];		
	var url = 'n_qtde_agenda_proc.php';
	var pars = 'dt_agenda='+dt_agenda+'&hr_agenda='+dt_agenda+'&usuario_pk='+dt_agenda;
	
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
            (url,
                    {
                    method:'get',
                    parameters: pars,
                    onSuccess:
                            function(transport){                                                        
                                    carregarRetotno(transport.responseText,pk,v_row_id);
                            },
                    onFailure:
                            function(){							
                                    erroExcluirItem();
                            }
                    }
            );		
}
function carregarRetotno(retorno){
    alert(retorno)
}