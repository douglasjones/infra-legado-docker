function carregar(){
	//Código javascript ao carregar a tabela;
}

function enviar_mailing(){
	var frm = document.forms[0];
			
	if(frm.dsc_mailing.value == ""){
		alert('Informe o Nailing !');
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
function carregarMailing(){

	try{
										
		var tabela = document.getElementById("tbl_mailing");				
		
		row = tabela.insertRow(tabela.rows.length);
		
		row.id = 'row'+tabela.rows.length;
		
		cell = row.insertCell(0);
		cell.innerHTML = criarCombo("",arrMailing, " ", "", "");	
		//cell.innerHTML = criarCombo("",arrMailing, " ", "", "")+' <input type="button" class="botao" value="+" onClick="addMailing()" title="Novo Mailing" />';	
		cell.align = "center";	
	}
	catch(e){
		alert(e.description);
	}
}	
function addMailing(){			
	NewWindow("mailing_cad_form.php?acao=ins", 300, 100)
}	
