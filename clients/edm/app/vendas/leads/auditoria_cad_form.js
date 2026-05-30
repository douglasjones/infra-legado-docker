function carregar(){
	//Código javascript ao carregar a tabela;
}

function enviar(){
	var frm = document.forms[0];
	
	
	if(document.getElementById("tel_fixo").value=="" && document.getElementById("contatoslead_pk").value==""){
		alert('Selecion Telefone ou Contato!');	
		return false;		
	}	
	
	if(document.getElementById("dsc_auditoria").value==""){
		alert('Insira a observação!');	
		return false;		
	}	
	
	frm.acao.value = "gravar";
	frm.submit();
}

function excluir(){

	if(!confirm("Deseja REALMENTE excluir o registro?")){
		return;
	}
	
	var frm = document.forms[0];
	frm.acao.value = "excluir";
	frm.submit();
}
