function carregar(){
	//Código javascript ao carregar a tabela;
}

function enviar(){
	
	var frm = document.forms[0];
			
	if(frm.operador_pk.value == ""){
		alert('Selecione a Operadora!');
		return false;
	}
	
	if(frm.fabricante_pk.value == ""){
		alert('Selecione o Fabricante!');
		return false;
	}
	
	if(frm.ds_aparelho.value == ""){
		alert('Indique o nome do aparelho!');
		return false;
	}
	
	
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
