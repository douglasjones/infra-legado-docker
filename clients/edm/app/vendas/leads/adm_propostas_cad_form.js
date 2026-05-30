function carregar(){
    
	parent.opener.location.reload();
        
}
function enviar(){	
	var frm = document.forms[0];
	//VERIFICA SE O ITEM DO PROCESSO FOI SELECIONADO
	if(document.getElementById("data_proposta_operador_pk").value==""){
		alert('Selecione o item do processo!');	
		return false;		
	}
	
	//VERIFICA SE A DATA DO PROCESSO FOI INDICADA
	if(document.getElementById("vl_data").value==""){
		alert('Informe a data!');	
		return false;		
	}
        
       document.getElementById("dsc_processo").value =  (document.getElementById("data_proposta_operador_pk").options[document.getElementById("data_proposta_operador_pk").selectedIndex].text)
	
	frm.acao.value = "gravar";	
	frm.submit();
}
function novoDocumento(){
	NewWindow("documentos_cad_form.php?codlead=<?=$codlead?>&contrato=1", 600, 400)
}

function excluir(){
	if(!confirm("Deseja REALMENTE excluir o registro?")){
		return;
	}	
	var frm = document.forms[0];
	frm.acao.value = "excluir";
	frm.submit();
}