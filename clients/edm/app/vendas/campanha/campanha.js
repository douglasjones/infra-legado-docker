function criarAssociacao(){
	var frm = document.forms[0];
	frm.acao.value = "associar";
	frm.submit();
}

function enviar(){
	var frm = document.forms[0];
	frm.acao.value = "gravar";		
	frm.submit();
}

function fecharCampanha(){
	var frm = document.forms[0];
	frm.acao.value = "fechar"
	frm.submit();
}

function simularCampanha(){
	var frm = document.forms[0];
	frm.acao.value = "simular";
	frm.submit();
}