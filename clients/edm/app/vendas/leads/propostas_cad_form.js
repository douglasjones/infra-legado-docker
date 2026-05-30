function carregar(){
	calcularTotalProposta();
}
function enviar(){	
	var frm = document.forms[0];

	//Validação Voz
	var tabela_voz = document.getElementById("tbl_Voz");
	
	var str_voz = "";	
	for(i = 0; i < tabela_voz.rows.length; i++){			
				
	}
	
	//Valida Combo
	var tabela = document.getElementById("tbl_Combo");
	var str_combo = "";	
	if(document.getElementById("tbl_Combo")){
		for(i = 0; i < tabela.rows.length; i++){
			
			if(tabela.rows[i].cells[0].children[0].value==""){
				alert("Selecione o combo!");
				tabela.rows[i].cells[0].style.border = 'solid 3px red';
				return false;
			}	
			if(tabela.rows[i].cells[1].children[0].value==""){
				alert("Indique a quantidade do combo!");
				tabela.rows[i].cells[1].style.border = 'solid 3px red';
				return false;
			}	
		} 
	}
	
	/*Valida Dados*/
	var tabela = document.getElementById("tbl_Dados");
	var str_dados = "";	
	
        if(document.getElementById("tbl_Dados")){
            for(i = 0; i < tabela.rows.length; i++){		
                    if(tabela.rows[i].cells[0].children[0].value==""){
                            alert("Selecione o produto!");
                            tabela.rows[i].cells[0].style.border = 'solid 3px red';
                            return false;
                    }	
                    if(tabela.rows[i].cells[1].children[0].value==""){
                            alert("Indique a quantidade do produto!");
                            tabela.rows[i].cells[1].style.border = 'solid 3px red';
                            return false;
                    }	
            } 
        }
	
	//Validar Modulos
	var tabela = document.getElementById("tbl_Modulos");
	var str_modulos = "";	
	
        if(document.getElementById("tbl_Modulos")){
            for(i = 0; i < tabela.rows.length; i++){
                    if(tabela.rows[i].cells[0].children[0].value==""){
                            alert("Selecione o modulo!");
                            tabela.rows[i].cells[0].style.border = 'solid 3px red';
                            return false;
                    }	
                    if(tabela.rows[i].cells[1].children[0].value==""){
                            alert("Indique a quantidade do modulo!");
                            tabela.rows[i].cells[1].style.border = 'solid 3px red';
                            return false;
                    }				
            } 
        }
	
	
	//Validar Aparelhos
	var tabela = document.getElementById("tbl_aparelhos");
	var str_aparelhos = "";	
	
        if(document.getElementById("tbl_aparelhos")){
            for(i = 0; i < tabela.rows.length; i++){
                    if(tabela.rows[i].cells[0].children[0].value==""){
                            alert("Selecione o aparelhos");
                            tabela.rows[i].cells[0].style.border = 'solid 3px red';
                            return false;
                    }	
                    if(tabela.rows[i].cells[1].children[0].value==""){
                            alert("Indique a quantidade!");
                            tabela.rows[i].cells[1].style.border = 'solid 3px red';
                            return false;
                    }	

                    if(tabela.rows[i].cells[2].children[0].value==""){
                            alert("Indique o valor do aparelho!");
                            tabela.rows[i].cells[2].style.border = 'solid 3px red';
                            return false;
                    }				
            } 
        }

	
	//Valida Voz
	var frm = document.forms[0];
	
	var tabela = document.getElementById("tbl_datas_proposta");
	var strRetorno = "";

	var v_dt_previsao ="";
        
        if(document.getElementById("tbl_datas_proposta")){
            for(i = 0; i < tabela.rows.length; i++){
                    if(document.getElementById("ds_data_"+tabela.rows[i].cells[0].children[0].value).value=="envio_lead"){
                            v_dt_envio = tabela.rows[i].cells[1].children[0].value;
                    }
                    if(document.getElementById("ds_data_"+tabela.rows[i].cells[0].children[0].value).value=="previsao_recebe_assinatura"){
                            v_dt_previsao = tabela.rows[i].cells[1].children[0].value;
                    }	
            }

            if(v_dt_previsao !="" ){
                    if(v_dt_envio==""){
                     alert('A data de envio da proposta deve ser informada!');		 
                     return false;	
                    }	
            }

            //Validade da Proposta
            if(frm.dt_validade.value==''){
                     alert('Indique a validade da proposta!');
                     return;
            }
        }	
		
	if(document.getElementById("tbl_Voz")){
            capiturar_itens_voz();	
        }
	
	if(document.getElementById("tbl_Combo")){
            capiturar_itens_combo();
	}
        
        if(document.getElementById("tbl_Dados")){
            capiturar_itens_dados();
        }
        
        if(document.getElementById("tbl_Modulos")){
            capiturar_itens_modulos();
        }
        
	if(document.getElementById("tbl_aparelhos")){
		capiturar_itens_aparelhos();
	}
        
	capiturar_datas_proposta();
	
	document.getElementById("vl_total_proposta").value = document.getElementById("v_total_proposta").innerHTML;	
	frm.acao.value = "gravar";
	frm.submit();
}
function imprimir(){
	window.print()
}	
function enviar_cancelamento(){
	var frm = document.forms[0];	
	
	if(frm.motivo_cancelamento_pk.value == ""){
		alert('Selecione o motivo do cancelamento!');
		return false;
	}
	
	if(frm.dsc_cancelamento_proposta.value == ""){
		alert('Descreva o motivo do cancelamento!');
		return false;
	}
	
	frm.submit();
}	
function addItem(v_item){
		
		if(v_item==1){	
			document.getElementById('Voz').style.display = "inline";
			document.getElementById('dv_voz_off').style.display = "none";			
		}else if(v_item=="-1"){
			var tabela = document.getElementById("tbl_Voz");
			if(tabela.rows.length > 0){	
				alert('Existem Itens inseridos em Voz');
				return false;
			}else{
				document.getElementById('Voz').style.display = "none";
				document.getElementById('dv_voz_off').style.display = "inline";	
			}				
		}		
		
		if(v_item==2){	
			document.getElementById('Combo').style.display = "inline";
			document.getElementById('dv_combo_off').style.display = "none";
		}else if(v_item=="-2"){		
			var tabela = document.getElementById("tbl_Combo");
			if(tabela.rows.length > 0){	
				alert('Existem Itens inseridos em Combo');
				return false;
			}else{	
				document.getElementById('Combo').style.display = "none";
				document.getElementById('dv_combo_off').style.display = "inline";
			}	
		}	
		
		if(v_item==3){	
			document.getElementById('Dados').style.display = "inline";
			document.getElementById('dv_dados_off').style.display = "none";
		}else if(v_item=="-3"){	
			var tabela = document.getElementById("tbl_Dados");
			if(tabela.rows.length > 0){	
				alert('Existem Itens inseridos em Dados');
				return false;
			}else{						
				document.getElementById('Dados').style.display = "none";
				document.getElementById('dv_dados_off').style.display = "inline";
			}
		}	
		
		if(v_item==4){	
			document.getElementById('Modulos').style.display = "inline";
			document.getElementById('dv_modulos_off').style.display = "none";
		}else if(v_item=="-4"){		
			var tabela = document.getElementById("tbl_Modulos");
			if(tabela.rows.length > 0){	
				alert('Existem Itens inseridos em Modulos');
				return false;
			}else{					
				document.getElementById('Modulos').style.display = "none";
				document.getElementById('dv_modulos_off').style.display = "inline";
			}
		}
		
		if(v_item==5){	
			document.getElementById('Aparelhos').style.display = "inline";
			document.getElementById('dv_aparelhos_off').style.display = "none";
		}else if(v_item=="-5"){
			var tabela = document.getElementById("tbl_aparelhos");
			if(tabela.rows.length > 0){	
				alert('Existem Itens inseridos em Aparelhos');
				return false;
			}else{							
				document.getElementById('Aparelhos').style.display = "none";
				document.getElementById('dv_aparelhos_off').style.display = "inline";
			}	
		}		
						 
}	
function verifica_itens_produtos(v_tabela){
	var tabela = document.getElementById("tbl_"+v_tabela);
	if(tabela.rows.length > 0){	
		return false;
	}	
}
function criarComboStatus(v_id, v_arr, v_primeiro_item, v_default, v_complemento){
	var strRetorno = "";
	var status = "";
	strRetorno+="<select id='"+v_id+"' name='"+v_id+"' "+v_complemento+">";
	if(v_primeiro_item != ""){
		strRetorno+="<option>"+v_primeiro_item+"</option>";
	}
	for(i = 0; i < v_arr.length; i++){		
		if(v_arr[i][2]==""){
			status = 'color:#009900';
		}else{
			status = 'color:#990000';
		}		
		if(v_default == v_arr[i][0])
			strRetorno+="<option value='"+v_arr[i][0]+"' selected=true>"+v_arr[i][1]+"</option>";
		else
			strRetorno+="<option value='"+v_arr[i][0]+"' style='"+status+"'>"+v_arr[i][1]+"</option>";
			
	}
	strRetorno+="</select>";
	return strRetorno;
}
function addProduto(v_tabela){
	
	try{								
				var tabela = document.getElementById("tbl_"+v_tabela);							
				row = tabela.insertRow(tabela.rows.length);
				
				row.id = 'row'+tabela.rows.length;
								
				cell = row.insertCell(0);
				if(v_tabela=='Voz'){
					cell.innerHTML = criarComboStatus("", arrProdutosVoz, " ", "", " onchange='carregarInformacoesProduto(this.value,"+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")' ");
				}else if(v_tabela=='Combo'){
					cell.innerHTML = criarComboStatus("", arrProdutosCombo, " ", "", " onchange='carregarInformacoesProduto(this.value,"+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")' ");
				}else if(v_tabela=='Dados'){
					cell.innerHTML = criarComboStatus("", arrProdutosDados, " ", "", " onchange='carregarInformacoesProduto(this.value,"+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")' ");
				}else if(v_tabela=='Modulos'){
					cell.innerHTML = criarComboStatus("", arrProdutosModulos, " ", "", " onchange='carregarInformacoesProduto(this.value,"+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")' ");
				}			
				cell.align = "center";
				if(v_tabela=='Voz'){
					cell = row.insertCell(1);
					cell.innerHTML = cell.innerHTML = criarCombo("", arrTipoLinha, " ", "", " ");;
					cell.align = "center";				
				
					cell = row.insertCell(2);
					cell.innerHTML = "<input type='text' name='ddd' size='2' id='ddd' maxlength='2' style='text-align:right'  onKeypress='mascara(this,soNumeros)' >";
					cell.align = "center";				
				
					cell = row.insertCell(3);
					cell.innerHTML = "<input type='text' name='n_qtdn_qtdee' size='5' id='n_qtdn_qtdee' value='' style='text-align:right'  onKeypress='mascara(this,soNumeros)' onchange='ValoresVoz(this.value,"+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")'>";
					cell.align = "center";
				
					cell = row.insertCell(4);
					cell.innerHTML = "<div id='div_produto_combo'></div>";
					cell.align = "center";
				
					cell = row.insertCell(5);
					cell.innerHTML = "<input type='text' name='vl_assinatura' size='10' id='vl_assinatura' value='' style='text-align:right'   onkeypress='mascara(this,Valor)' >";
					cell.align = "center";	

					cell = row.insertCell(6);
					cell.innerHTML = "<input type='text' name='vl_franquia' size='10' id='vl_franquia' value='' style='text-align:right' onblur='ValoresVoz(this.value,"+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")' onkeypress='mascara(this,Valor)'>";
					cell.align = "center";	
									
					cell = row.insertCell(7);
					cell.innerHTML = "";
					cell.align = "left";	
					
					cell = row.insertCell(8);
					cell.innerHTML = "";
					cell.align = "left";	
					
					cell = row.insertCell(9);
					cell.innerHTML = "<label name='vl_total'></label>";
					cell.align = "right";					
					
					cell = row.insertCell(10);
					cell.innerHTML = "<a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinhaItens("+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>";
					cell.align = "center";	
				}else{
					cell = row.insertCell(1);
					cell.innerHTML = "<input type='text' name='n_qtde' id='n_qtde' size='5' value='' onKeypress='mascara(this,soNumeros)' onblur='ValoresProdutos(this.value,"+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")'>";
					cell.align = "center";
					
					cell = row.insertCell(2);
					cell.innerHTML = "";
					cell.align = "center";				
					
					cell = row.insertCell(3);
					cell.innerHTML = "<label name='vl_total'></label>";
					cell.align = "right";					
					
					cell = row.insertCell(4);
					cell.innerHTML = "<a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinhaItens("+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>";
					cell.align = "center";	
				}	
								
	}
	catch(e){
		alert(e.description);
	}
}
//Carrega linha Produtos	
function carregarInformacoesProduto(v_vlr,v_row_id,v_tabela){
	
	var tabela = document.getElementById("tbl_"+v_tabela);

	for(i = 0; i < tabela.rows.length; i++){		
		if(tabela.rows[i].id == v_row_id){	
			if(v_tabela=='Voz'){				
				v_produto_pk = tabela.rows[i].cells[0].children[0].value;
				tabela.rows[i].cells[1].children[0].value = "";	
				tabela.rows[i].cells[2].children[0].value = "";	
				tabela.rows[i].cells[3].children[0].value = "";
				//tabela.rows[i].cells[4].children[0].value = "";	
				tabela.rows[i].cells[5].children[0].value = "";	
				tabela.rows[i].cells[6].children[0].value = "";																																						
			}else{				
				v_produto_pk = tabela.rows[i].cells[0].children[0].value;				
				tabela.rows[i].cells[1].children[0].value = "";				
				tabela.rows[i].cells[3].children[0].innerHTML = "";				
			}
		}
	}	
	
	combo_valor_produto(v_produto_pk,v_row_id,v_tabela);
	tarifas(v_produto_pk,v_row_id,v_tabela);		
	
}

//COMBO VALOR LINHA
function combo_valor_produto(v_produto_pk,v_row_id,v_tabela){
		
	var frm = document.forms[0];		
	var url = 'propostas_cad_proc.php';
	var pars = 'produto_pk='+v_produto_pk+'&acao=select&tipo=vlproduto&tipo_produto='+v_tabela;
	
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
				(url,
					{
					method:'get',
					parameters: pars,
					onSuccess:
						function(transport){																		
							carregarValorProduto(transport.responseText,v_produto_pk,v_row_id,v_tabela);
						},
					onFailure:
						function(){							
							erroExcluirItem();
						}
					}
				);		
}		

function carregarValorProduto(arrValorProduto,v_produto_pk,v_row_id,v_tabela){	
    var arr = arrValorProduto.split('////')
    for (t = 0; t < arr.length-1; t++){	
        arrValor = arr[t].split("##"); 
        var valor_tipo_pk = arrValor[2];
    }
    
    
    if(valor_tipo_pk==2){
        
        var strRetorno = "";   
        
       
        var tabela = document.getElementById("tbl_"+v_tabela);
        for(i = 0; i < tabela.rows.length; i++){			
            if(tabela.rows[i].id == v_row_id){
                if(v_tabela=="Voz"){				
                        tabela.rows[i].cells[4].innerHTML = "<input type='text' size='10'  value='' style='text-align:right' onblur='ValoresVoz(this.value,"+'"'+v_row_id+'"'+","+'"'+v_tabela+'"'+")'  onkeypress='mascara(this,Valor)'>";							
                }else{				
                        tabela.rows[i].cells[2].innerHTML = "<input type='text' size='10'  value='' style='text-align:right'  onkeypress='mascara(this,Valor)'>";
                }		
            }
        }
       
        return strRetorno;
    }else{    
        var tabela = document.getElementById("tbl_"+v_tabela);
        for(i = 0; i < tabela.rows.length; i++){			
            if(tabela.rows[i].id == v_row_id){
                if(v_tabela=="Voz"){				
                        tabela.rows[i].cells[4].innerHTML = carregarCombo("cboUnidade", arrValorProduto,v_produto_pk,v_row_id,v_tabela);							
                }else{				
                        tabela.rows[i].cells[2].innerHTML = carregarCombo("cboUnidade", arrValorProduto,v_produto_pk,v_row_id,v_tabela);
                }		
            }
        }
    }
}	
function carregarCombo(strNomeObjeto,arrValorProduto,v_produto_pk,v_row_id,v_tabela){	
	
	var arr = arrValorProduto.split('////')
			
	var strRetorno = "";
	var arrValor = "";
	if(v_tabela=="Voz"){	
		strRetorno+="<select name='"+strNomeObjeto+"' id='"+strNomeObjeto+"' onchange='ValoresVoz("+'"'+ v_produto_pk +'"'+","+'"'+ v_row_id +'"'+","+'"'+v_tabela+'"'+")'>";	
	}else{
		strRetorno+="<select name='"+strNomeObjeto+"' id='"+strNomeObjeto+"' onchange='ValoresProdutos("+'"'+ v_produto_pk +'"'+","+'"'+ v_row_id +'"'+","+'"'+v_tabela+'"'+")'>";
	}
	
	for (t = 0; t < arr.length-1; t++){	
			
		arrValor = arr[t].split("##");		 
		strRetorno+="<option value='"+arrValor[0]+"'>"+float2moeda(arrValor[1])+"</option>";
	}		 
	strRetorno+="</select>";
	
	return strRetorno;
}

function tarifas(v_produto_pk,v_row_id,v_tabela){
   
	var frm = document.forms[0];		
	var url = 'propostas_cad_proc.php';
	var pars = 'produto_pk='+v_produto_pk+'&acao=select&tipo=tarifa';
	
	//Inicio da rotina do ajax
	var myAjax = new Ajax.Request
				(url,
					{
					method:'get',
					parameters: pars,
					onSuccess:
						function(transport){																		
							addlinha_tarifas(transport.responseText,v_produto_pk,v_row_id,v_tabela);
						},
					onFailure:
						function(){							
							erroExcluirItem();
						}
					}
				);		
}	
function addlinha_tarifas(arrCamposVc,v_produto_pk,v_row_id,v_tabela){
	var arr = arrCamposVc.split('||');	
	var tabela = document.getElementById("tbl_"+v_tabela);
	var v =6;

	for (n = 0; n < arr.length; n++){			
		for(i = 0; i < tabela.rows.length; i++){			
			if(tabela.rows[i].id == v_row_id){	
							
				if(v==6){					
					tabela.rows[i].cells[7].innerHTML = arr[0];
				}
				if(v==7){
					tabela.rows[i].cells[8].innerHTML = arr[1];
				}				
				v +=1;	
			}	
		}	
	}		
}	

//PREENCHE VALORES DA LINHA
function ValoresVoz(v_produto_pk,v_row_id,v_tabela){	
	
	var tabela = document.getElementById("tbl_Voz");
	var v_qtde_li = "";
	var v_total_qtde_li = 0;
	var v_valor_linha = "";
	var v_valor_franquia = 0;
	var v_valor_total = 0;
	for(i = 0; i < tabela.rows.length; i++){	
	        
		if(tabela.rows[i].id == v_row_id){
			
			//SOMA QTDE DE LINHAS
			v_qtde_li += new Number(tabela.rows[i].cells[3].children[0].value);
			//PREENCHE VALOR ASSINATURA
			
			//tabela.rows[i].cells[4].children[0].value = tabela.rows[i].cells[3].children[0].options[tabela.rows[i].cells[3].children[0].selectedIndex].text;
			
                        var vv_valor = (tabela.rows[i].cells[4].children[0].options[tabela.rows[i].cells[4].children[0].selectedIndex].text)
                        
                        
                        //var vv_valor1 = (tabela.rows[i].cells[4].children[0].value)
                        if(vv_valor!=''){ 
                      
                            v_valor_linha = (moeda2float(vv_valor) * tabela.rows[i].cells[3].children[0].value);
                        }
                       //if(vv_valor1!=''){
                           
                        //    v_valor_linha = (moeda2float(vv_valor1) * tabela.rows[i].cells[3].children[0].value);
                       // }
		    tabela.rows[i].cells[5].children[0].value =  float2moeda(v_valor_linha);
		    
		    
		    if(tabela.rows[i].cells[6].children[0].value!=""){
			v_valor_franquia = moeda2float(tabela.rows[i].cells[6].children[0].value);
		    }
			
		    tabela.rows[i].cells[9].children[0].innerHTML = float2moeda(v_valor_linha + v_valor_franquia);
		    
		}
	}	
	//TOTAL VOZ
	for(t = 0; t < tabela.rows.length; t++){		
		//SOMA QTDE TOTAL DE LINHAS
		v_total_qtde_li += new Number(tabela.rows[t].cells[3].children[0].value);
		
		//SOMA VALOR TOTAL DAS LINHAS
		v_valor_linha = (moeda2float(tabela.rows[t].cells[4].children[0].options[tabela.rows[t].cells[4].children[0].selectedIndex].text) * tabela.rows[t].cells[3].children[0].value);
		    
		if(tabela.rows[t].cells[6].children[0].value!=""){
			v_valor_franquia = moeda2float(tabela.rows[t].cells[6].children[0].value);
		}
				
		if(tabela.rows[t].cells[6].children[0].value!=""){		
			v_valor_total += (v_valor_linha + v_valor_franquia)	
		}else{
			v_valor_total += (v_valor_linha);
		}	
	}	
	
	//PRINT TOTAL DE LINHAS
	document.getElementById('n_qtde_total_linhas').innerHTML = v_total_qtde_li;	
	//PRINT VALOR TOTAL
	document.getElementById('vl_total').innerHTML = float2moeda(v_valor_total); 
	
	calcularTotalProposta();
}	
//PREENCHE VALORES DA LINHA PRODUTOS
function ValoresProdutos(v_produto_pk,v_row_id,v_tabela){
	
	var tabela = document.getElementById("tbl_"+v_tabela);
	var v_qtde_li = "";
	var v_total_qtde_li = 0;
	var v_valor_linha = "";
	var v_valor_franquia = 0;
	var v_valor_total = 0;
	
	for(i = 0; i < tabela.rows.length; i++){					
		if(tabela.rows[i].id == v_row_id){			
			
			//SOMA QTDE DE LINHAS
			v_qtde_li += new Number(tabela.rows[i].cells[1].children[0].value);
			//PREENCHE VALOR ASSINATURA
									
			v_valor_linha = (moeda2float(tabela.rows[i].cells[2].children[0].options[tabela.rows[i].cells[2].children[0].selectedIndex].text) * tabela.rows[i].cells[1].children[0].value);
		   
		    tabela.rows[i].cells[3].children[0].innerHTML = float2moeda(v_valor_linha);		    
		}
	}
	
	//TOTAL PRODUTOS
	for(t = 0; t < tabela.rows.length; t++){
			
		//SOMA QTDE TOTAL DE LINHAS
		v_total_qtde_li += new Number(tabela.rows[t].cells[1].children[0].value);
		//SOMA VALOR TOTAL DAS LINHAS
		//v_valor_total += new Number(tabela.rows[t].cells[3].children[0].innerHTML).value;
		v_valor_total += (moeda2float(tabela.rows[t].cells[2].children[0].options[tabela.rows[t].cells[2].children[0].selectedIndex].text) * tabela.rows[t].cells[1].children[0].value);	
		
	}	
	
	//PRINT TOTAL DE LINHAS
	document.getElementById('n_qtde_total_'+v_tabela).innerHTML = v_total_qtde_li;	
	//PRINT VALOR TOTAL
	document.getElementById('n_total_'+v_tabela).innerHTML = float2moeda(v_valor_total); 
	
	calcularTotalProposta();
}	
//Exclui linha Produtos
function excluirLinhaItens(rowId,v_tabela){
	
	var frm = document.forms[0];
	var tabela = document.getElementById("tbl_"+v_tabela);
	var v_qtde_li = "";
	var v_total_qtde_li = 0;
	var v_valor_linha = "";
	var v_valor_franquia = 0;
	var v_valor_total = 0;
	if(confirm("Deseja realmente excluir o registro?")){
		for (i = 0 ; i < tabela.rows.length; i++){				
			if(tabela.rows[i].id == rowId){	
				tabela.deleteRow(i);
			}			
		}		     
	}
	
	if(v_tabela=="Voz"){									
		for(t = 0; t < tabela.rows.length; t++){		
			//SOMA QTDE TOTAL DE LINHAS
			v_total_qtde_li += new Number(tabela.rows[t].cells[2].children[0].value);
			
			//SOMA VALOR TOTAL DAS LINHAS
			v_valor_linha = (moeda2float(tabela.rows[t].cells[3].children[0].options[tabela.rows[t].cells[3].children[0].selectedIndex].text) * tabela.rows[t].cells[2].children[0].value);
				
			if(tabela.rows[t].cells[5].children[0].value!=""){
				v_valor_franquia = moeda2float(tabela.rows[t].cells[5].children[0].value);
			}
			
			v_valor_total += (v_valor_linha + v_valor_franquia)			
		}	
		//PRINT TOTAL DE LINHAS
		document.getElementById('n_qtde_total_linhas').innerHTML = float2moeda(v_total_qtde_li);	
		//PRINT VALOR TOTAL
		document.getElementById('vl_total').innerHTML = float2moeda(v_valor_total); 				
	}else{				
		//TOTAL PRODUTOS
		for(t = 0; t < tabela.rows.length; t++){				
			//SOMA QTDE TOTAL DE LINHAS
			v_total_qtde_li += new Number(tabela.rows[t].cells[1].children[0].value);
			//SOMA VALOR TOTAL DAS LINHAS
			//v_valor_total += new Number(tabela.rows[t].cells[3].children[0].innerHTML).value;
			v_valor_total += (moeda2float(tabela.rows[t].cells[2].children[0].options[tabela.rows[t].cells[2].children[0].selectedIndex].text) * tabela.rows[t].cells[1].children[0].value);	
		}			
		//PRINT TOTAL DE LINHAS
		document.getElementById('n_qtde_total_'+v_tabela).innerHTML = float2moeda(v_total_qtde_li);	
		//PRINT VALOR TOTAL
		document.getElementById('n_total_'+v_tabela).innerHTML = float2moeda(v_valor_total); 						
	}
	calcularTotalProposta();
	return	
}	

//Monta Produtos
function capiturar_itens_voz(){	
	
	var frm = document.forms[0];

	//Voz
	var tabela_voz = document.getElementById("tbl_Voz");
	var str_voz = "";	
	var v_vc1ir = "";
	var v_vc1m = "";
	var v_vc1f = "";
        var v_vces = "";
        var v_vces2m = "";
        var v_vces2f = "";
	for(i = 0; i < tabela_voz.rows.length; i++){			
		
		v_pk = tabela_voz.rows[i].cells[0].children[0].value;
		if(tabela_voz.rows[i].cells[0].children[0].value==""){
			alert("Indique o tipo da linha!");
			return false;
		}	
			
	    v_tipo_linha_pk = tabela_voz.rows[i].cells[1].children[0].value;					
	    v_ddd = tabela_voz.rows[i].cells[2].children[0].value;	
	    v_qtde_li = tabela_voz.rows[i].cells[3].children[0].value;	        
	    v_vl_unitario = tabela_voz.rows[i].cells[4].children[0].options[tabela_voz.rows[i].cells[4].children[0].selectedIndex].text 
	    v_assinatura = tabela_voz.rows[i].cells[5].children[0].value;
	    v_franquia = tabela_voz.rows[i].cells[6].children[0].value; 
	              
            
	    if(document.getElementById("vc1ir")){
		v_vc1ir = document.getElementById("vc1ir").value;	
		}  
		if(document.getElementById("vc1m")){
			v_vc1m = document.getElementById("vc1m").value;	
		}
		if(document.getElementById("vc1f")){
			v_vc1f = document.getElementById("vc1f").value;
		}			
		
            if(document.getElementById("vces")){
                    v_vces = document.getElementById("vces").value;	
		}  
		if(document.getElementById("vces2m")){
                    v_vces2m = document.getElementById("vces2m").value;	
		}
		if(document.getElementById("vces2f")){
                    v_vces2f = document.getElementById("vces2f").value;
		}
        
        
		str_voz += v_pk+"##"+v_tipo_linha_pk+"##"+v_qtde_li+"##"+v_vl_unitario+"##"+v_assinatura+"##"+v_franquia+"##"+v_vc1ir+"##"+v_vc1m+"##"+v_vc1f+"##"+v_ddd+"##"+v_vces+"##"+v_vces2m+"##"+v_vces2f+"////";

	}  	
	
	frm.itens_voz.value = str_voz;	
	return true;
}	
//Combo
function capiturar_itens_combo(){
	var frm = document.forms[0];

	//Voz
	var tabela = document.getElementById("tbl_Combo");
	var str_combo = "";	
	
	for(i = 0; i < tabela.rows.length; i++){
		
		v_pk = tabela.rows[i].cells[0].children[0].value;
		v_qtde = tabela.rows[i].cells[1].children[0].value; 
		
	    v_vlr = tabela.rows[i].cells[2].children[0].options[tabela.rows[i].cells[2].children[0].selectedIndex].text;
	    
		str_combo += v_pk+"##"+v_qtde+"##"+v_vlr+"////";	
		
	} 
	
	frm.itens_combo.value = str_combo;	
	return true;	
}	
//Dados
function capiturar_itens_dados(){
	var frm = document.forms[0];

	//Voz
	var tabela = document.getElementById("tbl_Dados");
	var str_dados = "";	
	
	for(i = 0; i < tabela.rows.length; i++){
		
		v_pk = tabela.rows[i].cells[0].children[0].value;			
		v_qtde = tabela.rows[i].cells[1].children[0].value; 
	    v_vlr = tabela.rows[i].cells[2].children[0].options[tabela.rows[i].cells[2].children[0].selectedIndex].text;
	    
		str_dados += v_pk+"##"+v_qtde+"##"+v_vlr+"////";		
	} 
	
	frm.itens_dados.value = str_dados;	
	return true;	
}	
//Modulos
function capiturar_itens_modulos(){
	var frm = document.forms[0];

	//Voz
	var tabela = document.getElementById("tbl_Modulos");
	var str_modulos = "";	
	
	for(i = 0; i < tabela.rows.length; i++){
		
		v_pk = tabela.rows[i].cells[0].children[0].value;			
		v_qtde = tabela.rows[i].cells[1].children[0].value; 
	    v_vlr = tabela.rows[i].cells[2].children[0].options[tabela.rows[i].cells[2].children[0].selectedIndex].text;
	 
		str_modulos += v_pk+"##"+v_qtde+"##"+v_vlr+"////";		
	} 
	
	frm.itens_modulos.value = str_modulos;	
	return true;	
}
	
//Tabela Aparelhos
function addAparelhos(){	
		var v_tabela = "aparelhos";
		try{								
				var tabela = document.getElementById("tbl_aparelhos");				
				row = tabela.insertRow(tabela.rows.length);
				
				row.id = 'row'+tabela.rows.length;
				
				cell = row.insertCell(0);
				cell.innerHTML = criarCombo("", arrAparelhos, " ", "", "");	
				cell.align = "center";
				
				cell = row.insertCell(1);
				cell.innerHTML = "<input type='text' name='n_qtde' id='n_qtde' size='5' value='' onKeypress='mascara(this,soNumeros)' onblur='calculaValorAparelhos(this.value,"+'"'+ row.id +'"'+","+'tbl_aparelhos'+")'>";
				cell.align = "center";
				
				cell = row.insertCell(2);
				cell.innerHTML = "<input type='text' name='' size='10' id='' value='' style='text-align:right'  onkeypress='mascara(this,Valor)' onblur='calculaValorAparelhos(this.value,"+'"'+ row.id +'"'+","+'tbl_aparelhos'+")'>";
				cell.align = "center";
				
				cell = row.insertCell(3);
				cell.innerHTML = criarCombo("", arrFormaAquisicao, " ", "", "");	
				cell.align = "center";			
				
				cell = row.insertCell(4);
				cell.innerHTML = criarCombo("", arrParcelamento, " ", "", "onblur='calculaValorAparelhos(this.value,"+'"'+ row.id +'"'+","+'tbl_aparelhos'+")'");	
				cell.align = "center";	
				
				cell = row.insertCell(5);
				cell.innerHTML = "<input type='text' name='' size='10' id='' value='' style='text-align:right'  onkeypress='mascara(this,Valor)' onblur='calculaValorAparelhos(this.value,"+'"'+ row.id +'"'+","+'tbl_aparelhos'+")'>";
				cell.align = "center";				
				
				cell = row.insertCell(6);
				cell.innerHTML = "<label name='vl_total'></label>";
				cell.align = "center";							
				
				cell = row.insertCell(7);
				cell.innerHTML = "<a id='excluir' name='excluir' title='Excluir o registro' href='javascript: excluirLinhaAparelhos("+'"'+ row.id +'"'+","+'"'+v_tabela+'"'+")'><img border=0 src='../../images/btexcluirfaq.jpg' width=15 height=15></a>";
				cell.align = "center";			
	}
	catch(e){
		alert(e.description);
	}
}
//Valores linha Aparelhos
function calculaValorAparelhos(v_qtd,v_row_id,v_tabela){	
	
	var tabela = document.getElementById("tbl_aparelhos");
	var v_qtde = 0;	
	var v_total = 0;
	
	for(i = 0; i < tabela.rows.length; i++){				
		if(tabela.rows[i].id == v_row_id){
			v_qtde += (new Number(tabela.rows[i].cells[1].children[0].value) );		

			v_total = (v_qtde*moeda2float(tabela.rows[i].cells[2].children[0].value));					
			
			//DESCONTO
			if(tabela.rows[i].cells[5].children[0].value!=""){
				v_total = new Number(v_total - moeda2float(tabela.rows[i].cells[5].children[0].value));					
			}			
			
			if(tabela.rows[i].cells[4].children[0].options[tabela.rows[i].cells[4].children[0].selectedIndex].value!=""){				
				v_total = new Number(v_total / moeda2float(tabela.rows[i].cells[4].children[0].value));	
			}	
			
			
			if(tabela.rows[i].cells[2].children[0].value!=""){
				tabela.rows[i].cells[6].children[0].innerHTML = float2moeda(v_total);	
			}			
		}
	}
	calculaTotalAparelhos(v_qtd,v_row_id,v_tabela);
	return
}	
//Soma Total Aparelhos
function calculaTotalAparelhos(v_qtd,v_row_id,v_tabela){
    
	var tabela = document.getElementById("tbl_aparelhos");
	var v_total_qtde = 0;	
        var v_total = 0;
    
	if(tabela.rows.length > 0){		 
		for(i = 0; i < tabela.rows.length; i++){			
			 v_total_qtde += new Number(tabela.rows[i].cells[1].children[0].value);
			 v_total +=	moeda2float(tabela.rows[i].cells[6].children[0].innerHTML); 
			
		}
    } 
	document.getElementById('n_qtde_total_aparelhos').innerHTML = v_total_qtde;	
	document.getElementById('vl_total_aparelhos').innerHTML  = float2moeda(v_total) ;	
		
	calcularTotalProposta();
	return
   
}
//Exclui linha Produtos
function excluirLinhaAparelhos(rowId,v_tabela){
	
	var frm = document.forms[0];
	var tabela = document.getElementById("tbl_"+v_tabela);
	var v_total = 0;
	var v_total_qtde_li
	if(confirm("Deseja realmente excluir o registro?")){
		for (i = 0 ; i < tabela.rows.length; i++){
			if(tabela.rows[i].id == rowId){			
					 v_total_qtde_li = new Number(tabela.rows[i].cells[1].children[0].value);
					 v_total =	new Number(tabela.rows[i].cells[3].children[0].innerHTML);	
				tabela.deleteRow(i);  
			}
		}	
		
		document.getElementById('n_qtde_total_aparelhos').innerHTML = float2moeda(document.getElementById('n_qtde_total_aparelhos').innerHTML - v_total_qtde_li);
		document.getElementById('vl_total_aparelhos').innerHTML  = float2moeda(document.getElementById('vl_total_aparelhos').innerHTML-v_total) ;		
		
	}
	//Calcula total proposta;
	calcularTotalProposta();	
}
function capiturar_itens_aparelhos(){
	var frm = document.forms[0];

	//Voz
	var tabela = document.getElementById("tbl_aparelhos");
	var str_aparelhos = "";	
	
	for(i = 0; i < tabela.rows.length; i++){
		
		v_pk = tabela.rows[i].cells[0].children[0].value;			
		v_qtde = tabela.rows[i].cells[1].children[0].value; 
	    v_vlr = tabela.rows[i].cells[2].children[0].value;
	    v_forma_aquisicao = tabela.rows[i].cells[3].children[0].value;
	    v_parcelamento = tabela.rows[i].cells[4].children[0].value;
	    vl_desconto = tabela.rows[i].cells[5].children[0].value;
	    str_aparelhos += v_pk+"##"+v_qtde+"##"+v_vlr+"##"+v_forma_aquisicao+"##"+v_parcelamento+"##"+vl_desconto+"////";	
	} 
	
	frm.itens_aparelhos.value = str_aparelhos;	
	return true;	
}

//Tabela Datas Propostas
function incluirdatasProposta(label,cod_data_operador,valor_data,tipo_ocorrencia_pk,statusclassificacaolead_pk,v_obs){			
   
          try{								
				var tabela = document.getElementById("tbl_datas_proposta");				
				row = tabela.insertRow(tabela.rows.length);
				
				row.id = 'row'+tabela.rows.length;
				
				cell = row.insertCell(0);
				cell.innerHTML = "<input type='hidden' name='cod_data_proposta_operador' id='cod_data_proposta_operador' value='"+cod_data_operador+"'><label   class='form' >"+label+"</label>";
				cell.align = "center";		
			
				cell = row.insertCell(1);
                                
				cell.innerHTML = "<input type='text' size='12' maxlength='10' name='"+cod_data_operador+"' id='"+cod_data_operador+"' value='"+valor_data+"'  onkeypress='mascara(this,datamask)' maxlength='10' validate='datatype=date' >";
				
                                cell.align = "center";
				
				cell = row.insertCell(2);
				cell.innerHTML = "<textarea style='width: 98%' name='dsc_data' id='dsc_data' >"+v_obs+"</textarea>";
				cell.align = "center";
					
	}
	catch(e){
		alert(e.description);
	}
}
//Datas proposta
function capiturar_datas_proposta(){	
	
	var frm = document.forms[0];
	
	var tabela = document.getElementById("tbl_datas_proposta");
	var strRetorno = "";
	var v_dsc_data =""
	var v_tipo_ocorrencia =""
	var v_statusclassificacaolead_pk = ""
	var v_dt_envio = "";
	var v_dt_previsao ="";
	for(i = 0; i < tabela.rows.length; i++){
		if(document.getElementById("ds_data_"+tabela.rows[i].cells[0].children[0].value).value=="envio_lead"){
			v_dt_envio = tabela.rows[i].cells[1].children[0].value;
		}
		if(document.getElementById("ds_data_"+tabela.rows[i].cells[0].children[0].value).value=="previsao_recebe_assinatura"){
			v_dt_previsao = tabela.rows[i].cells[1].children[0].value;
		}	
		v_cod_data_proposta_operador = tabela.rows[i].cells[0].children[0].value;			
		v_dt_cad = tabela.rows[i].cells[1].children[0].value; 
	    v_desc = tabela.rows[i].cells[2].children[0].value;
	    v_dsc_data = document.getElementById("ds_data_"+tabela.rows[i].cells[0].children[0].value).value;  
	    
		strRetorno += v_cod_data_proposta_operador+"##"+v_dt_cad+"##"+v_desc+"##"+v_dsc_data+"////";		
	}
	
	frm.datas_proposta.value = strRetorno;	
	return true;
}	



function excluirLinha(rowId,v_tabela){
	var frm = document.forms[0];
	var tabela = document.getElementById("tbl_processo_datas_proposta");
	if(confirm("Deseja realmente excluir o registro?")){
		for (i = 0 ; i < tabela.rows.length; i++){
			if(tabela.rows[i].id == rowId){
								
				//Grava o código para exclusão do banco de dados.
				if(tabela.rows[i].cells[0].children[1].value != "")
					frm.datas_processo_proposta_excluido.value += tabela.rows[i].cells[0].children[1].value+";";					
				tabela.deleteRow(i);                
				return;
			}
		}        
	}	
}
function calcularTotalProposta(){ 

	var Voz = 0;
	var Combo = 0;
	var Dados = 0;
	var Modulos = 0;
	var Aparelho = 0;
	
	if(document.getElementById('vl_total').innerHTML != '0,00'){            
		if(document.getElementById('vl_total').innerHTML){                    
			Voz =  moeda2float(document.getElementById('vl_total').innerHTML);                       
		}                
	}
         
	/*if(document.getElementById('n_total_Combo').innerHTML !== '0,00'){
            alert('1');
		if(document.getElementById('n_total_Combo').innerHTML){			
			Combo =  moeda2float(document.getElementById('n_total_Combo').innerHTML);	
		}
	}*/
        
	if(document.getElementById('n_total_Dados').innerHTML != '0,00'){
		if(document.getElementById('n_total_Dados').innerHTML){
			Dados =  moeda2float(document.getElementById('n_total_Dados').innerHTML);
		}
	}
	if(document.getElementById('n_total_Modulos').innerHTML != '0,00'){
		if(document.getElementById('n_total_Modulos').innerHTML){
			Modulos =  moeda2float(document.getElementById('n_total_Modulos').innerHTML);						
		}
	}
	if(document.getElementById('vl_total_aparelhos').innerHTML != '0,00'){
		if(document.getElementById('vl_total_aparelhos').innerHTML){
			Aparelho = moeda2float(document.getElementById('vl_total_aparelhos').innerHTML);			
		}
	}
	
	document.getElementById('v_planos_servicos_proposta').innerHTML = float2moeda(Voz + Combo + Dados + Modulos); 
	
	document.getElementById('v_total_proposta').innerHTML = float2moeda(Voz + Combo + Dados + Modulos + Aparelho);           
}

function excluir(){
	if(!confirm("Deseja REALMENTE excluir o registro?")){
		return;
	}	
	var frm = document.forms[0];
	frm.acao.value = "excluir";
	frm.submit();
}

function enviar_email(){
        var str = "";
        var url = 'propostas_cad_proc.php';
    
        var leads_pk =  document.getElementById('leads_pk').value;
        var operador_pk = document.getElementById('operador_pk').value;
        var nomecontato = document.getElementById('nomecontato').value;
        var email_contato =  document.getElementById('email_contato').value;
        var razaosocial =  document.getElementById('razaosocial').value;
        var script =  document.getElementById('script_header').value; 
        var html =  document.getElementById('script_html').value; 
        
  
        str = "////"+script+"////";  
  
        alert(str)
        if(document.getElementById('nomecontato').value==""){
            alert("Contato não cadastrado!");
                return false;
        }else if(document.getElementById('email_contato').value==""){
            alert("Email não cadastrado!");
            return false;
        }

                 
                 
       var pars = 'acao=enviar_email&tipo=proposta&leads_pk='+leads_pk+'&operador_pk='+operador_pk+'&razaosocial='+razaosocial+'&nomecontato='+nomecontato+'&email_contato='+email_contato+'&html='+"'"+str;
     
       	var myAjax = new Ajax.Request
				(url,
					{
					method:'get',
					parameters: pars,
					onSuccess:
						function(transport){
                                                    alert(transport.responseText);
						},
					onFailure:
						function(){							
                                                    alert('erro');
						}
					}
	);

}
function msg(){
    alert('Operação executada com sucesso');
    opener.top.pagina.location.reload();
    self.close()
}
function e_email(){
   var frm = document.forms[0];
    if(document.getElementById('nomecontato').value==""){
        alert("Contato não cadastrado!");
            return false;
    }else if(document.getElementById('email_contato').value==""){
        alert("Email não cadastrado!");
        return false;
    }
    
    document.getElementById('acao').value = "enviar_email";
   

   frm.submit();

}