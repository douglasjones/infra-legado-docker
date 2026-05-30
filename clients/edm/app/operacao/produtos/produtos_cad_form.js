function carregar(v_produto_tipo_pk){
    document.getElementById("vl_produto").disabled=true;
    document.getElementById("tipo_pk").disabled=true;
    
    tipo_produto(v_produto_tipo_pk);
}

function enviar(){
	
	var frm = document.forms[0];
			
	if(frm.operador_pk.value == ""){
		alert('Selecione a Operadora!');
		return false;
	}
	if(frm.produtos_tipo_pk.value == ""){
		alert('Selecione o tipo de produto!');
		return false;
	}
            if(frm.ds_produto.value == ""){
                alert('Preencha o nome produto!');
                return false;
            }

	
	var tabela = document.getElementById("tbl_valor_produto");
	if(frm.tipo_valor_pk.value==1){
            if(tabela.rows.length == 0){	
                    alert('Adicionar o valor do produto');
                    return false;
            }
        }
	
	capiturar_itens_valor();
	
	//Local
	if(document.getElementById('visualiza_vc1_local').checked==true){
		document.getElementById('visualiza_vc1_local').value = "1";		
	}	
	
	if(document.getElementById('visualiza_vc2_local').checked==true){
		document.getElementById('visualiza_vc2_local').value = "1";		
	}
	
	if(document.getElementById('visualiza_vc3_local').checked==true){
		document.getElementById('visualiza_vc3_local').value = "1";		
	}		
	//Estadual
	if(document.getElementById('visualiza_vc1_Estad').checked==true){
		document.getElementById('visualiza_vc1_Estad').value = "1";		
	}	

	if(document.getElementById('visualiza_vc2_Estad').checked==true){
		document.getElementById('visualiza_vc2_Estad').value = "1";		
	}	
	
	if(document.getElementById('visualiza_vc3_Estad').checked==true){
		document.getElementById('visualiza_vc3_Estad').value = "1";		
	}	
	//Nacional
	if(document.getElementById('visualiza_vc1_Nac').checked==true){
		document.getElementById('visualiza_vc1_Nac').value = "1";		
	}	
	
	if(document.getElementById('visualiza_vc2_Nac').checked==true){
		document.getElementById('visualiza_vc2_Nac').value = "1";		
	}
	
	if(document.getElementById('visualiza_vc3_Nac').checked==true){
		document.getElementById('visualiza_vc3_Nac').value = "1";		
	}		
			
	frm.acao.value = "gravar";
	frm.submit();
	
}

function tipo_produto(v_produto_tipo_pk){	
	if(v_produto_tipo_pk=="1"){
		document.getElementById('dv_vcs').style.display = "inline";	
	}else{
		document.getElementById('dv_vcs').style.display = "none";
	}			
}	

function add_valor_produto(){
	
	if(document.getElementById("vl_produto").value == ""){
		alert('Preencha o campo valor!');
		return false;
	}
	var v_valor = document.getElementById("vl_produto").value;
        var v_tipo = document.getElementById("tipo_pk").value;
        if(v_tipo==1){
            var dsc_tipo='Chip';
        }else{
            var dsc_tipo='Aparelho';
        }
	try{								
				var tabela = document.getElementById("tbl_valor_produto");				
				row = tabela.insertRow(tabela.rows.length);
				
				row.id = 'row'+tabela.rows.length;
				
				cell = row.insertCell(0);
				cell.innerHTML = "<label name='vl_produto' id='vl_produto' >"+v_valor+"</label>";
				cell.align = "center";
                                
                                cell = row.insertCell(1);
				cell.innerHTML = "<input type='hidden' value='"+v_tipo+"' >"+dsc_tipo;
				cell.align = "center";
							
				cell = row.insertCell(2);
				cell.innerHTML = "<input type='hidden' name='' id='' value=''><a id='excluir' name='excluir' title='Excluir o registro' href='javascript: delete_linhavalor_produto("+'"'+ row.id +'"'+")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>";
				cell.align = "center";					
	}
	catch(e){
		alert(e.description);
	}
	document.getElementById("vl_produto").value = "";
        document.getElementById("tipo_pk").value = "";
}		

function capiturar_itens_valor(){
	var frm = document.forms[0];
	
	var tabela = document.getElementById("tbl_valor_produto");
	var strRetorno = "";
	var v_tipo_pk ="";
	for(i = 0; i < tabela.rows.length; i++){
				
										
		v_vl_produto = tabela.rows[i].cells[0].children[0].innerHTML; 	    
	        if(tabela.rows[i].cells[1].children[0].value){
                    v_tipo_pk = tabela.rows[i].cells[1].children[0].value; 
                }
		
		strRetorno += v_vl_produto+"##"+v_tipo_pk+"////";		
	}
	
	frm.valores_produto.value = strRetorno;	
	return true;	
}	

function excluirLinha(rowId){
	var frm = document.forms[0];
	var tabela = document.getElementById("tbl_produtos_combo");
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

function alt_valor(id){
    if(id==1){
        document.getElementById("vl_produto").disabled=false;
        document.getElementById("tipo_pk").disabled=false;
    }else{
        document.getElementById("vl_produto").disabled=true;
        document.getElementById("tipo_pk").disabled=true;
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
function sl_book(cod_operador){

    var frm = document.forms[0];		
    var url = 'produtos_cad_proc.php';
    
    var pars = '&acao=select&operador_pk='+cod_operador;
  
	
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
				(url,
					{
					method:'get',
					parameters: pars,
					onSuccess:
						function(transport){																		
                                                    add_combo_book(transport.responseText,cod_operador);
						},
					onFailure:
						function(){							
							alert('Erro')
						}
					}
				);	
                        
                     
}
function add_combo_book(arr){  

    document.getElementById("combo_book").innerHTML = carregarCombo("produto_book_pk",arr,"sl_n_dsc_book");     
}

function carregarCombo(strNomeObjeto,arr_origem,funcao){
    
	var arr = arr_origem.split('////')			
	var strRetorno = "";

	strRetorno+="<select name='"+strNomeObjeto+"' id='"+strNomeObjeto+"' class='formulario_select' onchange='"+funcao+"(this.value)'>";
        strRetorno+="<option value=''></option>";
	for (t = 0; t < arr.length-1; t++){			
		arrValor = arr[t].split("##");		 
		strRetorno+="<option value='"+arrValor[0]+"'>"+arrValor[1]+"</option>";
	}		 
	strRetorno+="</select>";	

	return strRetorno;
}


