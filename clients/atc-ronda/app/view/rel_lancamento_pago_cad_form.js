var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
  
    var objParametros = {
        "tipo_lancamento_pk":tipo_lancamento_pk,
        "dt_pagamento_ini":dt_pagamento_ini,
        "dt_pagamento_fim":dt_pagamento_fim,
        "dt_lancamento_ini":dt_lancamento_ini,
        "dt_lancamento_fim":dt_lancamento_fim,
        "lancamento_pk":lancamento_pk,
        "pk_cliente": pk_cliente,
        "cnpj_cliente": cnpj_cliente,
        "cnpj_fornecedor":cnpj_fornecedor
    };         

    var arrCarregar = carregarController("lancamento", "RelatorioLancamentoPago", objParametros); 
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   
            
                     strRetorno+="<div class='row'><div class='col-md-12 tableFixHead'>";
                    //strRetorno+="<div class='overflow-auto' style='height:800px;overflow-y: scroll;' >";
                    strRetorno+="<table id='tabela' class='table table-striped table-bordered ' style='width:100%' id='tblResultado' >";
                    strRetorno+="<tbody>";
                    strRetorno+="<tr align='center'>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Cód</font></th>";
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Cadastro</font></th>"; 
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Tipo<br>Lançamento</font></th>"; 
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Valor</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Vencimento<br>Recebimento</font></th>";    
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Método de Recebimento<br>Pagamento</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Status</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Pagamento</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Tipo Operação<br>Planos Conta</font></th>";    
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Empresa do <br>lançamento</font></th>";
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Conta do Bancária</font></th>";
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Identificação do<br>Lançamento</font></th>";
                    //strRetorno+="<th width='10%'>Grupo Origem<br>do Lançamento</th>";
                    strRetorno+="<th width='5%'class='menu_fixo'><font style='font-size: 12px'>Rebido de ?<br>Pago para ?</font></th>";
                    strRetorno+="<th width='5%'class='menu_fixo'><font style='font-size: 12px'>CPF/CNPJ</font></th>";
                    //strRetorno+="<th width='10%'>Grupos Centro<br>de Custo</th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Centro de Custo</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Usuário de<br>Cadastro</font></th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){

                        strRetorno+="<tr>";
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_pk']+"</font></th>";
                        strRetorno+="<th width='10%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_dt_cadastro']+"</font></th>"; 
                        strRetorno+="<th width='10%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_operacao']+"</font></th>"; 
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+float2moeda(arrCarregar.data[i]['t_vl_lancamento'])+"</font></th>"; 
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_dt_vencimento']+"</font></th>"; 
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_metodo_pagamento']+"</font></th>"; 
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_status_pagamento']+"</font></th>";
                        if(arrCarregar.data[i]['t_dt_pagamento']!=null){
                            strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_dt_pagamento']+"</font></th>";
                        }
                        else{
                            strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                        }

                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_tipo_operacao']+"</font></th>";
                        strRetorno+="<th width='10%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_razao_social']+"</font></th>";
                        if(arrCarregar.data[i]['t_ds_conta_bancaria']!=null){
                            strRetorno+="<th width='10%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_conta_bancaria']+"</font></th>";
                        }
                        else{
                            strRetorno+="<th width='10%' align='center'><font style='font-size: 13px'></font></th>";
                        }
                        strRetorno+="<th width='10%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_lancamento']+"</font></th>";
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_recebido_de']+"</font></th>";
                        if(arrCarregar.data[i]['t_cpf_cnpj']!=null){
                            strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_cpf_cnpj']+"</font></th>";
                        }
                        else{
                            strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'></font></th>";
                        }
                        
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_recebido_de_centro_custo']+"</font></th>";
                        strRetorno+="<th width='5%' align='center'><font style='font-size: 13px'>"+arrCarregar.data[i]['ds_usuario']+"</font></th>";
                        strRetorno+="</tr>";
                    }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<br><br><br><br>";
                if(strRetorno!=""){
                    $("#grid").html(strRetorno);
                }
                else{

                    strNenhumRegisto+="<div class='row'>";
                    strNenhumRegisto+="<div class='col-md-12 text-center'>";
                    strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
                    strNenhumRegisto+=" </div>";
                    strNenhumRegisto+="</div>";
                    $("#grid").html(strNenhumRegisto);
                }

        }
        else{
            strNenhumRegisto+="<div class='row'>";
            strNenhumRegisto+="<div class='col-md-12 text-center'>";
            strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
            strNenhumRegisto+=" </div>";
            strNenhumRegisto+="</div>";
            $("#grid").html(strNenhumRegisto);
        }
        
    }
    else{
        alert('Falhar ao carregar o registro');
    }
}



function fcCancelar(){

    sendPost("rel_lancamento_res_form.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#form").html() + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "export.xls";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}

$(document).ready(function(){    
    
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    var seg = today.getSeconds();
    //data
    if(dd<10) {
        dd = '0'+dd
    } 

    if(mm<10) {
        mm = '0'+mm
    } 
    //hora 
    if(hh<10) {
        hh = '0'+hh
    } 

    if(min<10) {
        min = '0'+min
    } 
    if(seg<10) {
        seg = '0'+seg
    } 

    today = dd + '/' + mm + '/' + yyyy + ' '+hh+':'+min+':'+seg;


    $("#dt_emissao").text(today);
    
    if(tipo_lancamento_pk==0){
        $("#ds_tipo_lancamento").text("Receita e Despesa");
    }
    else if(tipo_lancamento_pk==1){
        $("#ds_tipo_lancamento").text("Receita");
    }
    if(tipo_lancamento_pk==2){
        $("#ds_tipo_lancamento").text("Despesa");
    }
    
    $("#dt_pagamento").text(dt_pagamento_ini + " até "+dt_pagamento_fim);
    $("#dt_lancamento").text(dt_lancamento_ini + " até "+dt_lancamento_fim);
    $("#lancamento_pk").text(lancamento_pk);
    $("#pk_cliente").text(pk_cliente);
    $("#cnpj_cliente").text(cnpj_cliente);
    $("#cnpj_fornecedor").text(cnpj_fornecedor);
    
   
   
    fcCarregarGrid();

});


