var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];

function getMoney( str )
{
        return parseInt( str.replace(/[\D]+/g,'') );
}
function formatReal( int )
{
        var tmp = int+'';
        tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
        if( tmp.length > 6 )
                tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

        return tmp;
}


function fcCarregarGrid(){
    
   
    var strNenhumRegisto = "";
    var strRetorno = "";
    var v_total_lancamento = new Number(0);
    var v_total_receita = new Number(0);
    var v_total_despesa = new Number(0);
    var objParametros = {
        tipo_lancamento_pk:tipo_lancamento_pk,
        ic_status_pagamento:ic_status,
        "dt_vencimento_ini": dt_vencimento_ini,
        "dt_vencimento_fim": dt_vencimento_fim,
        "dt_pagamento_ini": dt_pagamento_ini,
        "dt_pagamento_fim": dt_pagamento_fim,
        "tipos_operacao_pk_receita": tipos_operacao_pk_receita,
        "contas_bancarias_pk": contas_bancarias_pk,
        "ic_status": ic_status,
        "empresas_pk":empresas_pk,
        "tipo_grupo_pk":tipo_grupo_pk,
        "grupo_leancamento_pk":grupo_leancamento_pk,
        "usuario_cadastro_pk":usuario_cadastro_pk,
        "dt_faturamento_ini": dt_faturamento_ini,
        "dt_faturamento_fim": dt_faturamento_fim,
    };         

        


    var arrCarregar = carregarController("lancamento", "RelatorioLancamento", objParametros); 
   // NewWindow(v_last_url)
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   
            
                    strRetorno+="<div class='row'><div class='col-md-12'>";
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<thead>";
                    strRetorno+="<tr>";
                    strRetorno+="  <th></th>";
                    strRetorno+="  <th><input type='text' id='txtCod' /></th>";
                    strRetorno+="  <th><input type='text' id='txtLancamento' /></th>";
                    strRetorno+="  <th><input type='text' id='txtVlLancamento' /></th>";
                    strRetorno+="  <th><input type='text' id='txtVlReceita' /></th>";
                    strRetorno+="  <th><input type='text' id='txtVlDespesaS' /></th>";
                    strRetorno+="  <th><input type='text' id='txtDtVencimento' /></th>";
                    strRetorno+="  <th><input type='text' id='txtDtFaturamento' /></th>";
                    strRetorno+="  <th><input type='text' id='txtMetodoRecebimento' /></th>";
                    strRetorno+="  <th><input type='text' id='txtStatus' /></th>";
                    strRetorno+="  <th><input type='text' id='txtDtPagamento' /></th>";
                    strRetorno+="  <th><input type='text' id='txtTipoOperacao' /></th>";
                    strRetorno+="  <th> </th>";
                    strRetorno+="  <th> </th>";
                    strRetorno+="  <th><input type='text' id='txtIdLancamento' /></th>";
                    strRetorno+="  <th><input type='text' id='txtGrupoOrigem' /></th>";
                    strRetorno+="  <th><input type='text' id='txtPagoRecebidoDe' /></th>";
                    strRetorno+="  <th><input type='text' id='txtGrupoCentroDeCusto' /></th>";
                    strRetorno+="  <th><input type='text' id='txtCentroDeCusto' /></th>";
                    strRetorno+="  <th><input type='text' id='txtUsuCadastro' /></th>";
                    strRetorno+="  <th><input type='text' id='txtObs' /></th>";
                    strRetorno+="</tr>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>#</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Cód</font></th>";
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Tipo<br>Lançamento</font></th>";                     
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>VL Lençamento(s)</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>VL Receita(s)</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>VL Despesa(s)</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Vencimento<br>Recebimento</font></th>"; 
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Faturamento</font></th>"; 
                    //strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Data<br>Competência / Referência</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Método de Recebimento<br>Pagamento</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Status</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Dt Pagamento</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Tipo Operação<br>Planos Conta</font></th>";    
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Empresa do <br>lançamento</font></th>";
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Conta do Bancária</font></th>";
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Identificação do<br>Lançamento</font></th>";
                    strRetorno+="<th width='10%'><font style='font-size: 12px'>Grupo Origem<br>do Lançamento</font></th>";
                    strRetorno+="<th width='5%'class='menu_fixo'><font style='font-size: 12px'>Rebido de ?<br>Pago para ?</font></th>";
                    strRetorno+="<th width='10%'><font style='font-size: 12px'>Grupos Centro<br>de Custo</font></th>";
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Centro de Custo</font></th>";                    
                    strRetorno+="<th width='5%' class='menu_fixo'><font style='font-size: 12px'>Usuário de<br>Cadastro</font></th>";
                    strRetorno+="<th width='10%' class='menu_fixo'><font style='font-size: 12px'>Observação</font></th>";
                    strRetorno+="</tr>";
                    strRetorno+="</thead>";
                    strRetorno+="<tbody>";
                    var count = 1;
                    for(i=0; i < arrCarregar.data.length ;i++){
                        
                        if(arrCarregar.data[i]['t_dt_faturamento']!=null){
                            var dt_faturamento = arrCarregar.data[i]['t_dt_faturamento']
                        }else{
                            var dt_faturamento ="";
                        }

                        strRetorno+="<tr data-empresa='"+arrCarregar.data[i]['t_ds_razao_social']+"'>";
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+count+"</b></td>";
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_pk']+"</b></td>";
                        strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_operacao']+"</b></td>"; 
                        v_total_lancamento += moeda2float(arrCarregar.data[i]['t_vl_lancamento']);
                        if(arrCarregar.data[i]['t_operacao_pk']==1){
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px;color:blue'>"+float2moeda(arrCarregar.data[i]['t_vl_lancamento'])+"</b></td>";
                    
                        }else{
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px;color:red'> - "+float2moeda(arrCarregar.data[i]['t_vl_lancamento'])+"</b></td>";                             
                        }
                        
                        
                        if(arrCarregar.data[i]['t_operacao_pk']==1){
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px: 13px;color:blue'>"+float2moeda(arrCarregar.data[i]['t_vl_lancamento'])+"</b></td>";
                            v_total_receita += moeda2float(arrCarregar.data[i]['t_vl_lancamento']);
                        }else{
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        if(arrCarregar.data[i]['t_operacao_pk']!=1){
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px;color:red'>"+float2moeda(arrCarregar.data[i]['t_vl_lancamento'])+"</b></td>";
                            v_total_despesa += moeda2float(arrCarregar.data[i]['t_vl_lancamento']);
                        }else{
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        
                        
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_dt_vencimento']+"</b></td>"; 
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+dt_faturamento+"</b></td>"; 
                        
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_metodo_pagamento']+"</b></td>"; 
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_status_pagamento']+"</b></td>";
                        if(arrCarregar.data[i]['t_dt_pagamento']==null){
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'></b></td>";
                        }else{
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_dt_pagamento']+"</b></td>";
                        }
                            
                        
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_tipo_operacao']+"</b></td>";
                        if(arrCarregar.data[i]['t_ds_razao_social']==null){
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        else{
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_razao_social']+"</b></td>";
                        }
                        if(arrCarregar.data[i]['t_ds_conta_bancaria']==null){
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        else{
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_conta_bancaria']+"</b></td>";
                        }
                        
                        strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_lancamento']+"</b></td>";
                        strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_tipo_grupo']+"</b></td>";
                        
                        
                        if(arrCarregar.data[i]['t_ds_recebido_de']==null){
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        else{
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_recebido_de']+"</b></td>";
                        }
                        if(arrCarregar.data[i]['t_ds_tipo_grupo_centro_custo']==null){
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        else{
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_tipo_grupo_centro_custo']+"</b></td>";
                        }
                        if(arrCarregar.data[i]['t_ds_recebido_de_centro_custo']==null){
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        else{
                            strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_ds_recebido_de_centro_custo']+"</b></td>";
                        }
                        strRetorno+="<td width='5%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['ds_usuario']+"</b></td>";
                        if(arrCarregar.data[i]['t_obs_lancamento']==null){
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        else{
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_obs_lancamento']+"</b></td>";
                        }
                    
                        /*if(arrCarregar.data[i]['t_n_documento']==null){
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'></b></td>";
                        }
                        else{
                            strRetorno+="<td width='10%' align='center'><b style='font-size: 13px'>"+arrCarregar.data[i]['t_n_documento']+"</b></td>";
                        }*/
                        strRetorno+="</tr>";
                        count ++;
                }
                strRetorno+="</tbody>";
                strRetorno+="<tfoot>";
                strRetorno+="   <th></th>";
                strRetorno+="   <th></th>";
                strRetorno+="   <th>Totais</th>";
                strRetorno+="   <th>";
                strRetorno+="       <font id='valor_lancamento' style='font-size: 13px'>"+formatReal(v_total_lancamento)+"</font>";
                strRetorno+="   </th>";
                strRetorno+="   <th>";
                strRetorno+= "      <font id='valor_receita' style='font-size: 13px;color:blue'>"+formatReal(v_total_receita)+"</font>";
                strRetorno+="   </th>";
                strRetorno+="   <th>";
                strRetorno+="       <font id='valor_despesa' style='font-size: 13px;color:red'>"+formatReal(v_total_despesa)+"</font>";
                strRetorno+="   </th>";
                
                strRetorno+="</tfoot>";
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

function fcCarregarEmpresas(){
    var objParametros = {
        tipo_lancamento_pk:tipo_lancamento_pk,
        ic_status_pagamento:ic_status,
        "dt_vencimento_ini": dt_vencimento_ini,
        "dt_vencimento_fim": dt_vencimento_fim,
        "dt_pagamento_ini": dt_pagamento_ini,
        "dt_pagamento_fim": dt_pagamento_fim,
        "tipos_operacao_pk_receita": tipos_operacao_pk_receita,
        "contas_bancarias_pk": contas_bancarias_pk,
        "ic_status": ic_status,
        "empresas_pk":empresas_pk,
        "tipo_grupo_pk":tipo_grupo_pk,
        "grupo_leancamento_pk":grupo_leancamento_pk,
        "usuario_cadastro_pk":usuario_cadastro_pk,
        "dt_faturamento_ini": dt_faturamento_ini,
        "dt_faturamento_fim": dt_faturamento_fim,
    };               

    var arrCarregar = carregarController("lancamento", "RelatorioLancamento", objParametros);  
    carregarComboAjax($("#empresaLancamento"), arrCarregar, " ", "t_ds_razao_social", "t_ds_razao_social");
    
}



function fcCancelar(){

    sendPost("rel_lancamento_res_form.php", {token: token});
}

function fcExport(){

    /*var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#tblResultado").html() + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
    
    var hyperlink = document.createElement("a");
    hyperlink.download = "export.xls";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);*/

    $("#dados_a_enviar").val( $("<div>").append( $("#tblResultado").eq(0).clone()).html());
    
    $("#FormularioExportacao").submit();
}

function AdicionarFiltroSelect(tabela, coluna) {
    var cols = $("#" + tabela + " thead tr:first-child th").length;
    if ($("#" + tabela + " thead tr").length == 1) {
        var linhaFiltro = "<tr>";
        for (var i = 0; i < cols; i++) {
            linhaFiltro += "<th></th>";
        }
        linhaFiltro += "</tr>";
 
        $("#" + tabela + " thead").append(linhaFiltro);
    }
 
    var colFiltrar = $("#" + tabela + " thead tr:nth-child(1) th:nth-child(" + coluna + ")");
 
    $(colFiltrar).html("<select id='filtroColuna_" + coluna.toString() + "'  class='filtroColuna'> </select>");
 
    var valores = new Array();
 
    $("#" + tabela + " tbody tr").each(function () {
        var txt = $(this).children("td:nth-child(" + coluna + ")").text();
        if (valores.indexOf(txt) < 0) {
            valores.push(txt);
        }
    });
    $("#filtroColuna_" + coluna.toString()).append("<option> </option>")
    for (elemento in valores) {
        $("#filtroColuna_" + coluna.toString()).append("<option>" + valores[elemento] + "</option>");
    }
 
    $("#filtroColuna_" + coluna.toString()).change(function () {
        var filtro = $(this).val();
        if($("#" + tabela + " tbody tr").is(':visible')){
            $(this).show();
        }
        if(filtro == ""){
            $("#" + tabela + " tbody tr").show();
        }
        if (filtro != "") {
            $("#" + tabela + " tbody tr").each(function () {
                var txt = $(this).children("td:nth-child(" + coluna + ")").text();
                if (txt != filtro) {
                    $(this).hide();
                }
            });
        }
        

        $("#valor_lancamento").html("")
        $("#valor_receita").html("")
        $("#valor_despesa").html("")

        //Calcula valor total Lançamento
        var valores_lancamento = new Array();
        var v_total_lancamento = new Number(0);
        $("#" + tabela + " tbody tr:visible").each(function () {
            var lancamento = $(this).children("td:nth-child(4)").text();
            if (valores_lancamento.indexOf(lancamento) < 0) {
                valores_lancamento.push(lancamento);
            }
        })
        for (elemento_lancamento in valores_lancamento) {
            if(valores_lancamento[elemento_lancamento] != ""){
                v_total_lancamento += moeda2float(valores_lancamento[elemento_lancamento].replace("-", "").replace(",", "."))
            }
        }
    
        //Calcula valor total Receita
        var v_total_receita = new Number(0);
        var valores_receita = new Array();
        $("#" + tabela + " tbody tr:visible").each(function () {
            var receita = $(this).children("td:nth-child(5)").text();
            if (valores_receita.indexOf(receita) < 0) {
                valores_receita.push(receita);
            }
        })
        for (elemento_receita in valores_receita) {
            if(valores_receita[elemento_receita] != ""){
                v_total_receita += moeda2float(valores_receita[elemento_receita].replace("-", "").replace(",", "."))
            }
        }
    
        //Calcula valor total Despesa
        var valores_despesa = new Array();
        var v_total_despesa = new Number(0);
        $("#" + tabela + " tbody tr:visible").each(function () {
            var despesa = $(this).children("td:nth-child(6)").text();
            if (valores_despesa.indexOf(despesa) < 0) {
                valores_despesa.push(despesa);
            }
        })
        for (elemento_despesa in valores_despesa) {
            if(valores_despesa[elemento_despesa] != ""){
                v_total_despesa += moeda2float(valores_despesa[elemento_despesa].replace("-", "").replace(",", "."))
            }
        }
    
        $("#valor_lancamento").html(formatReal(v_total_lancamento))
        $("#valor_receita").html(formatReal(v_total_receita))
        $("#valor_despesa").html(formatReal(v_total_despesa))
    
    });
};

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
            
    $("#dt_periodo").text(dt_vencimento_ini+" até "+dt_vencimento_fim);
    
    if(tipo_lancamento_pk==0){
        $("#ds_tipo_lancamento").text("Receita e Despesa");
    }
    else if(tipo_lancamento_pk==1){
        $("#ds_tipo_lancamento").text("Receita");
    }
    if(tipo_lancamento_pk==2){
        $("#ds_tipo_lancamento").text("Despesa");
    }
    
    $("#ds_empresa").text(ds_empresa);
    $("#ds_tipo_grupo").text(ds_tipo_grupo);
    $("#ds_grupo_leancamento").text(ds_grupo_leancamento);
    $("#ds_usuario_cadastro").text(ds_usuario_cadastro);
    $("#ds_ic_status").text(ds_ic_status);
    fcCarregarGrid();
    fcCarregarEmpresas()
    AdicionarFiltroSelect('tblResultado', 1)
    AdicionarFiltroSelect('tblResultado', 2)
    AdicionarFiltroSelect('tblResultado', 3);
    AdicionarFiltroSelect('tblResultado', 4)
    AdicionarFiltroSelect('tblResultado', 5)
    AdicionarFiltroSelect('tblResultado', 6)
    AdicionarFiltroSelect('tblResultado', 7);
    AdicionarFiltroSelect('tblResultado', 8);
    AdicionarFiltroSelect('tblResultado', 9);
    AdicionarFiltroSelect('tblResultado', 10);
    AdicionarFiltroSelect('tblResultado', 11);
    AdicionarFiltroSelect('tblResultado', 12);
    AdicionarFiltroSelect('tblResultado', 13);
    AdicionarFiltroSelect('tblResultado', 14);
    AdicionarFiltroSelect('tblResultado', 15)
    AdicionarFiltroSelect('tblResultado', 16);
    AdicionarFiltroSelect('tblResultado', 17);
    AdicionarFiltroSelect('tblResultado', 18);
    AdicionarFiltroSelect('tblResultado', 19);
    AdicionarFiltroSelect('tblResultado', 20);
    AdicionarFiltroSelect('tblResultado', 21)

    

});


