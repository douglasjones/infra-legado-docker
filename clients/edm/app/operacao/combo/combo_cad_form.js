function carregar(v_produto_tipo_pk){
	tipo_produto(v_produto_tipo_pk);
}

function enviar(){
	
	var frm = document.forms[0];
			
	if(frm.operador_pk.value == ""){
		alert('Selecione a Operadora!');
		return false;
	}

	if(frm.ds_combo.value == ""){
		alert('Preencha o nome do Combo!');
		return false;
	}

	if(frm.vl_combo.value == ""){
		alert('Preencha o valor do Combo!');
		return false;
	}

	if(frm.n_vigencia_contrato.value == ""){
		alert('Preencha a vigência do contrato!');
		return false;
	}
	
	var tabela = document.getElementById("tbl_produtos");
	
	if(tabela.rows.length == 0){	
		alert('Adicione os produtos do Combo!');
		return false;
	}
	
	capiturar_produtos();
		
			
	frm.acao.value = "gravar";
	frm.submit();
	
}

	

function add_produto(){
	    if(document.getElementById("combo_produto_tipo_pk").options[document.getElementById("combo_produto_tipo_pk").selectedIndex].text==""){
			alert('Selecion o Tipo Produto !!');
			return false;
		}	
		if(document.getElementById("produto_pk").value==""){
			alert('Selecion o Produto !!');
			return false;
		}
		var produto_pk= document.getElementById("produto_pk").value;
		
		var ds_tipo_produto = document.getElementById("combo_produto_tipo_pk").options[document.getElementById("combo_produto_tipo_pk").selectedIndex].text;
		var ds_produto = document.getElementById("produto_pk").options[document.getElementById("produto_pk").selectedIndex].text;
		
		try{									
				var tabela = document.getElementById("tbl_produtos");				
				row = tabela.insertRow(tabela.rows.length);
				
				row.id = 'row'+tabela.rows.length;
				
				cell = row.insertCell(0);
				cell.innerHTML = "<input type='hidden' name='produto_combo_pk' id=produto_combo_pk' value='"+produto_pk+"'><label   class='form' >"+ds_tipo_produto+"</label>";
				cell.align = "center";		
			
				cell = row.insertCell(1);
				cell.innerHTML = "<label   class='form' >"+ds_produto+"</label>";
				cell.align = "center";	
				
				cell = row.insertCell(2);
				cell.innerHTML = "<a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinha("+'"'+row.id+'"'+")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>";
				cell.align = "center";			
	}
	
	catch(e){
		alert(e.description);
	}
	document.getElementById("combo_produto_tipo_pk").selectedIndex = "";
	document.getElementById("produto_pk").options[document.getElementById("produto_pk").selectedIndex].text="";
}		

function capiturar_produtos(){

	var frm = document.forms[0];
	var tabela = document.getElementById("tbl_produtos");
	var strRetorno = "";
		
	for(i = 0; i < tabela.rows.length; i++){
		
		v_pk = tabela.rows[i].cells[0].children[0].value;
		
		strRetorno += v_pk+"////";
		
	}	

	frm.itens_produtos_combo.value = strRetorno;
	
	return true;
}	

function reload_combo(id){
			
	var d = document.forms.combo;	
    var operador = document.getElementById('operador_pk').value;
	
	var pars = 'tipo=1' + '&produto_tipo_pk=' + id +'&operador_pk='+operador+'&acao=select';	
	
	new Ajax.Updater('produto_combo', 'combo_cad_proc.php', { method: 'post', parameters: pars } );	
	new Ajax.Updater('div_produto_combo', 'combo_cad_proc.php', { method: 'post', parameters: pars } );	
	
}

function excluirLinha(rowId){
	var frm = document.forms[0];
	var tabela = document.getElementById("tbl_produtos");
	if(confirm("Deseja realmente excluir o registro?")){
		for (i = 0 ; i < tabela.rows.length; i++){		
			
			if(tabela.rows[i].id == rowId){
              tabela.deleteRow(i);  
				return;
			}
		}        
	}	
}
function delete_linhavalor_produto(rowId){
	var frm = document.forms[0];
	var tabela = document.getElementById("tbl_valor_produto");
	if(confirm("Deseja realmente excluir o registro?")){
		for (i = 0 ; i < tabela.rows.length; i++){			
			
			if(tabela.rows[i].id == rowId){						
				//Grava o código para exclusão do banco de dados.
				//if(tabela.rows[i].cells[0].children[1].value != "")
				//	frm.itens_proposta_excluido.value += tabela.rows[i].cells[0].children[1].value+";;";				
				
                tabela.deleteRow(i);  
				return;
			}
		}        
	}	
}


