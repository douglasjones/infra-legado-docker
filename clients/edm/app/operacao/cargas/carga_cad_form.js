function carregar(){
	//Código javascript ao carregar a tabela;
}

function enviar(){
	var frm = document.forms[0];
	
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
