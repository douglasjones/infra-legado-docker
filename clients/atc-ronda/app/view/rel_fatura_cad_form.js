var tblResultado;
var click_id = 0;

function fcCarregarGrid(){  
    
    
    var v_leads_pk = leads_pk;
    var v_empresas_pk = empresas_pk;
    var dt_agenda_ini = dt_ini;
    var v_dt_ini = dt_ini;
   
    var strRetorno = "";

    var strNenhumRegisto = "";
    
    var objParametros1 = {
        "leads_pk": v_leads_pk,
        "empresas_pk": v_empresas_pk,
        "dt_ini": dt_ini,
        "dt_fim": dt_fim,
    };         

    var arrCarregar1 = carregarController("fatura", "relatorioFatura", objParametros1);
   
    if (arrCarregar1.result == 'success'){
        
        if(arrCarregar1.data.length > 0){
         
            strRetorno+="<table id='tabela' class='table table-striped table-bordered nowrap' style='width:100%' id='tblResultado'>";
            strRetorno+="    <thead>";
            strRetorno+="       <tr>";
            strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
            strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
            strRetorno+="            <th><input type='text' id='txtRE' /></th>";
            strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno2' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno3' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno4' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno5' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno6' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno7' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno8' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno9' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno10' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno11' /></th>";
            strRetorno+="            <th><input type='text' id='txtTurno12' /></th>";
            strRetorno+="       </tr>";
            strRetorno+="       <tr>";
            strRetorno+="           <th>Empresa</th>";
            strRetorno+="           <th>Número Fatura</th>";
            strRetorno+="           <th>Data Fatura</th>";
            strRetorno+="           <th>Cliente</th>";
            strRetorno+="           <th>CNPJ</th>";
            strRetorno+="           <th>Dt. Vencimento</th>";
            strRetorno+="           <th>Valor Serviço</th>";
            strRetorno+="           <th>Valor Materiais</th>";
            strRetorno+="           <th>Valor Serviços Adicionais</th>";
            strRetorno+="           <th>Valor Desconto</th>";
            strRetorno+="           <th>Valor Bruto</th>";
            strRetorno+="           <th>Valor Retenção INSS</th>";
            strRetorno+="           <th>Valor Retenção ISSQN</th>";
            strRetorno+="           <th>Valor a Pagar</th>";
            strRetorno+="           <th>Observação</th>";
            strRetorno+="           <th>Data Cancelamento</th>";
            strRetorno+="           <th>Obs Cancelamento</th>";
            strRetorno+="       </tr>";
            strRetorno+="    </thead>";
            strRetorno+="<tbody'>";
            for(i=0; i < arrCarregar1.data.length ;i++){
                  
                
                var ds_empresa = "";
                if(arrCarregar1.data[i]['ds_empresa']!=null){
                    var ds_empresa = arrCarregar1.data[i]['ds_empresa'];
                }
                var ds_numero_fatura = "";
                if(arrCarregar1.data[i]['pk']!=null){
                    var ds_numero_fatura = arrCarregar1.data[i]['pk'];
                }
                var dt_fatura = "";
                if(arrCarregar1.data[i]['periodo']!=null){
                    var dt_fatura = arrCarregar1.data[i]['periodo'];
                }
                var ds_lead = "";
                if(arrCarregar1.data[i]['ds_lead']!=null){
                    var ds_lead = arrCarregar1.data[i]['ds_lead'];
                }
                var ds_cpf_cnpj = "";
                if(arrCarregar1.data[i]['ds_cpf_cnpj']!=null){
                    var ds_cpf_cnpj = arrCarregar1.data[i]['ds_cpf_cnpj'];
                }
                var dt_vencimento = "";
                if(arrCarregar1.data[i]['dt_vencimento']!=null){
                    var dt_vencimento = arrCarregar1.data[i]['dt_vencimento'];
                }
                var vl_servico = 0;
                if(arrCarregar1.data[i]['vl_servico']!=null){
                    var vl_servico = float2moeda(arrCarregar1.data[i]['vl_servico']);
                }
                var vl_material = 0;
                if(arrCarregar1.data[i]['vl_material']!=null){
                    var vl_material = float2moeda(arrCarregar1.data[i]['vl_material']);
                }
                var vl_servico_adicionais = 0;
                if(arrCarregar1.data[i]['vl_servico_adicionais']!=null){
                    var vl_servico_adicionais = float2moeda(arrCarregar1.data[i]['vl_servico_adicionais']);
                }
                var vl_desconto = 0;
                if(arrCarregar1.data[i]['vl_desconto']!=null){
                    var vl_desconto = float2moeda(arrCarregar1.data[i]['vl_desconto']);
                }
                var vl_bruto_total = "";
                if(arrCarregar1.data[i]['vl_bruto_total']!=null){
                    var vl_bruto_total = float2moeda(arrCarregar1.data[i]['vl_bruto_total']);
                }
                var valor_inss = "";
                if(arrCarregar1.data[i]['valor_inss']!=null){
                    var valor_inss = float2moeda(arrCarregar1.data[i]['valor_inss']);
                }
                var valor_issqn = "";
                if(arrCarregar1.data[i]['valor_issqn']!=null){
                    var valor_issqn = float2moeda(arrCarregar1.data[i]['valor_issqn']);
                }
                var valor_total_a_pagar = "";
                if(arrCarregar1.data[i]['valor_total_a_pagar']!=null){
                    var valor_total_a_pagar = float2moeda(arrCarregar1.data[i]['valor_total_a_pagar']);
                }
                var dt_cancelamento = "";
                if(arrCarregar1.data[i]['dt_cancelamento']!=null){
                    var dt_cancelamento = (arrCarregar1.data[i]['dt_cancelamento']);
                }
                var ds_descricao_cancelamento = "";
                if(arrCarregar1.data[i]['ds_descricao_cancelamento']!=null){
                    var  ds_descricao_cancelamento = (arrCarregar1.data[i]['ds_descricao_cancelamento']);
                }
                
                var obs = "";
                var obs = "Desconto de "+arrCarregar1.data[i]['qtde_falta']+" falta(s) no valor de R$ "+float2moeda(arrCarregar1.data[i]['vl_falta']);
                
                strRetorno+="<tr>";
                strRetorno+="<td width='10%'>"+ds_empresa+"</td>";
                strRetorno+="<td width='10%'>"+ds_numero_fatura+"</td>";
                strRetorno+="<td width='10%'>"+dt_fatura+"</td>";
                strRetorno+="<td width='10%'>"+ds_lead+"</td>";
                strRetorno+="<td width='10%'>"+ds_cpf_cnpj+"</td>";
                strRetorno+="<td width='10%'>"+dt_vencimento+"</td>";
                strRetorno+="<td width='10%'>R$: "+vl_servico+"</td>";
                strRetorno+="<td width='10%'>R$: "+vl_material+"</td>";
                strRetorno+="<td width='10%'>R$: "+vl_servico_adicionais+"</td>";
                strRetorno+="<td width='10%'>R$: "+vl_desconto+"</td>";
                strRetorno+="<td width='10%'>R$: "+vl_bruto_total+"</td>";
                strRetorno+="<td width='10%'>R$: "+valor_inss+"</td>";
                strRetorno+="<td width='10%'>R$: "+valor_issqn+"</td>";
                strRetorno+="<td width='10%'>R$: "+valor_total_a_pagar+"</td>";
                strRetorno+="<td width='10%'>"+obs+"</td>";
                strRetorno+="<td width='10%'>"+dt_cancelamento+"</td>";
                strRetorno+="<td width='10%'>"+ds_descricao_cancelamento+"</td>";
                strRetorno+="</tr>";

                }
            strRetorno+="</tbody>";
            strRetorno+="</table>";
            }
        }
     
    
    if(strRetorno!=""){        
        $("#grid").html(strRetorno);
    }else{ 
        $("#grid").append(strNenhumRegisto);
    }
    
}

pegarUltimoDiaMes = function(year, month){
    var ultimoDia = (new Date(year, month, 0)).getDate();
    return ultimoDia;
};

function pegarPosicaoDiaSemana(data){
    
    var splitData = data.split("/");
    var semana = [0, 1, 2, 3, 4, 5,6];
    var d = new Date(splitData[2], splitData[1] - 1, splitData[0]);
    return semana[d.getDay()];
}

function fcCarregarColaborador(){

    var objParametros = {
        "pk": ds_colaboradores
    };      
    
    var arrCarregar = carregarController("colaborador", "listarPk", objParametros); 
    if (arrCarregar.result == 'success'){
        $("#ds_colaborador").text(arrCarregar.data[0]['ds_colaborador']);
    }
        
}

function fcCancelar(){

    sendPost("rel_fatura_res_form.php", {token: token});
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
     
    //fcCarregarColaborador();
 
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
    
   $("#ds_empresa").text(ds_empresa);
   $("#ds_lead").text(ds_lead);
    
    $("#dt_emissao").text(today);
    $("#dt_ini").text(dt_ini);
    $("#dt_fim").text(dt_fim);
 
    fcCarregarGrid();
        
    $("#tabela input").keyup(function(){
            var index = $(this).parent().index();
            var nth = "#tabela td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $("#tabela tbody tr").show();
            $(nth).each(function(){
                    if($(this).text().toUpperCase().indexOf(valor) < 0){
                            $(this).parent().hide();
                    }
            });
    });
    $("#tabela input").blur(function(){
            $(this).val("");
    });	
    $("#loader").hide();
    $("#exibir").show();

});


