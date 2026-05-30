

function fcCarregarGridMovimentacaoCustoMedio(){
    
    var strNenhumRegisto = "";
    var strRetorno = "";
        
    var objParametros = {
        "dt_movimentacao_ini": dt_movimentacao_ini,
        "dt_movimentacao_fim": dt_movimentacao_fim,
        "produtos_pk": produtos_pk
    };         

    var arrCarregar = carregarController("movimentacao_estoque", "relatorioMovimentacaoEstoqueCustoMedio", objParametros); 
    NewWindow(v_last_url) 
    //var v_url = montarUrlController("movimentacao_estoque", "relatorioMovimentacaoEstoqueProduto", objParametros);

    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   
            
                    strRetorno+="<div class='row'><div class='col-md-12'>";
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>Produto</th>";
                    strRetorno+="<th width='20%'>DOC/NF</th>";
                    strRetorno+="<th width='20%'>Unidade</th>";
                    strRetorno+="<th width='20%'>VL ESTOQUE INICIAL</th>";
                    strRetorno+="<th width='20%'>QT. EST. INICIAL</th>";
                    strRetorno+="<th width='20%'>QT. COMPRAS</th>"; 
                    strRetorno+="<th width='20%'>VL.COMPRAS</th>";
                    strRetorno+="<th width='20%'>QT SAIDAS</th>";
                    strRetorno+="<th width='20%'>VL. SAIDA</th>"; 
                    strRetorno+="<th width='20%'>Custo Médio</th>";
                    //strRetorno+="<th width='20%'>Qtd Mínima</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['t_ds_tipo_unidade']==null){
                            var ds_tipounidade1 = "";
                        }
                        else{
                            var ds_tipounidade1 = arrCarregar.data[i]['t_ds_tipo_unidade'];
                        }
                        if(arrCarregar.data[i]['t_ds_produto']==null){
                            var ds_produto1 = "";
                        }
                        else{
                            var ds_produto1 = arrCarregar.data[i]['t_ds_produto'];
                        }

                        
                        if(arrCarregar.data[i]['t_qtde']==null){
                            var t_qtde1 = "";
                        }
                        else{
                            var t_qtde1 = arrCarregar.data[i]['t_qtde'];
                        }
                        if(arrCarregar.data[i]['t_qtde_saidas']==null){
                            var t_qtde_saidas1 = "";
                        }
                        else{
                            var t_qtde_saidas1 = arrCarregar.data[i]['t_qtde_saidas'];
                        }
                        if(arrCarregar.data[i]['t_vl_unitario']==null){
                            var t_vl_unitario1 = "";
                        }
                        else{
                            var t_vl_unitario1 = arrCarregar.data[i]['t_vl_unitario'];
                        }
                        if(arrCarregar.data[i]['t_qtde_inicial']==null){
                            var t_qtde_inicial1 = "";
                        }
                        else{
                            var t_qtde_inicial1 = arrCarregar.data[i]['t_qtde_inicial'];
                        }
                        if(arrCarregar.data[i]['t_vl_total_item_entrada']==null){
                            var vl_total_item_entrada1 = "";
                        }
                        else{
                            var vl_total_item_entrada1 = arrCarregar.data[i]['t_vl_total_item_entrada'];
                        }
                        if(arrCarregar.data[i]['t_vl_total_item_saida']==null){
                            var vl_total_item_saida1 = "";
                        }
                        else{
                            var vl_total_item_saida1 = arrCarregar.data[i]['t_vl_total_item_saida'];
                        }
                        if(arrCarregar.data[i]['t_vl_saida']==null){
                            var t_vl_saida1 = "";
                        }
                        else{
                            var t_vl_saida1 = arrCarregar.data[i]['t_vl_saida'];
                        }
                        strRetorno+="<tr>";                      
                        strRetorno+="<th width='20%'>"+ds_produto1+"</th>";
                        strRetorno+="<th width='20%'>"+ "" +"</th>";
                        strRetorno+="<th width='20%'>"+ds_tipounidade1+"</th>";
                        strRetorno+="<th width='20%'>"+vl_total_item_entrada1 +"</th>";
                        strRetorno+="<th width='20%'>"+t_qtde_inicial1+"</th>";
                        strRetorno+="<th width='20%'>"+t_qtde1+"</th>";
                        strRetorno+="<th width='20%'>"+vl_total_item_saida1+"</th>";
                        strRetorno+="<th width='20%'>"+ t_qtde_saidas1 +"</th>";
                        strRetorno+="<th width='20%'>"+ t_vl_saida1 +"</th>"; 
                        strRetorno+="<th width='20%'>"+ t_vl_unitario1 +"</th>"; 

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

    sendPost("rel_estoque_custo_medio.php", {token: token});
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
    
   
    
    $("#ds_lead").text(leads_pk_option);
    
    $("#dt_movimentacao").text(dt_movimentacao_ini+" até " +dt_movimentacao_fim);
    
    
    fcCarregarGridMovimentacaoCustoMedio();
    alert("aqui")

});