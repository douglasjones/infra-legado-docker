var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
      
    var objParametros = {
        "ds_cidade": ds_cidade,
        "ic_tipo_lead": ic_tipo_lead,
        "ic_cliente": ic_cliente,
        "leads_pk": leads_pk
    };         

    var arrCarregar = carregarController("lead", "RelatorioPostoTrabalhoAnalitico", objParametros); 

    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   

                    
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="       <tr>";
                    strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
                    strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
                    strRetorno+="            <th><input type='text' id='txtRE' /></th>";
                    strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
                    strRetorno+="            <th><input type='text' id='txtTurno' /></th>";
                    strRetorno+="            <th><input type='text' id='txtFerias' /></th>";
                    strRetorno+="            <th><input type='text' id='txtEscala' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto1' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto2' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto3' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto4' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto5' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto6' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto7' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto8' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto9' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto10' /></th>";
                    strRetorno+="       </tr>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>Cód</th>";
                    strRetorno+="<th width='20%'>Tipo Lead</th>";
                    strRetorno+="<th width='20%'>Cliente Pai</th>";
                    strRetorno+="<th width='20%'>Posto de Trabalho</th>";
                    strRetorno+="<th width='20%'>Razão Social</th>";
                    strRetorno+="<th width='20%'>CNPJ</th>";
                    strRetorno+="<th width='20%'>Endereço</th>";
                    strRetorno+="<th width='20%'>Número</th>";
                    strRetorno+="<th width='20%'>Complemento</th>";
                    strRetorno+="<th width='20%'>Bairro</th>";
                    strRetorno+="<th width='20%'>Cidade</th>";
                    strRetorno+="<th width='20%'>UF</th>";
                    strRetorno+="<th width='20%'>Telefone</th>";
                    strRetorno+="<th width='20%'>Segmento</th>";
                    strRetorno+="<th width='20%'>Supervisor</th>";
                    strRetorno+="<th width='20%'>Data Vencimento</th>";
                    strRetorno+="<th width='20%'>Data Cadastro</th>";
                    strRetorno+="<th width='20%'>Usuario Cadastro</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['pk']==null){
                            var pk = "";
                        }
                        else{
                            var pk = arrCarregar.data[i]['pk'];
                        }
                        if(arrCarregar.data[i]['ds_tipo_lead']==null){
                            var ds_tipo_lead = "";
                        }
                        else{
                            var ds_tipo_lead = arrCarregar.data[i]['ds_tipo_lead'];
                        }
                        if(arrCarregar.data[i]['ds_lead_pai']==null){
                            var ds_lead_pai = "";
                        }
                        else{
                            var ds_lead_pai = arrCarregar.data[i]['ds_lead_pai'];
                        }
                        if(arrCarregar.data[i]['ds_lead']==null){
                            var ds_lead = "";
                        }
                        else{
                            var ds_lead = arrCarregar.data[i]['ds_lead'];
                        }
                        if(arrCarregar.data[i]['ds_razao_social']==null){
                            var ds_razao_social = "";
                        }
                        else{
                            var ds_razao_social = arrCarregar.data[i]['ds_razao_social'];
                        }
                        if(arrCarregar.data[i]['ds_cpf_cnpj']==null){
                            var ds_cpf_cnpj = "";
                        }
                        else{
                            var ds_cpf_cnpj = arrCarregar.data[i]['ds_cpf_cnpj'];
                        }
                        if(arrCarregar.data[i]['ds_endereco']==null){
                            var ds_endereco = "";
                        }
                        else{
                            var ds_endereco = arrCarregar.data[i]['ds_endereco'];
                        }
                        if(arrCarregar.data[i]['ds_numero']==null){
                            var ds_numero = "";
                        }
                        else{
                            var ds_numero = arrCarregar.data[i]['ds_numero'];
                        }
                        if(arrCarregar.data[i]['ds_complemento']==null){
                            var ds_complemento = "";
                        }
                        else{
                            var ds_complemento = arrCarregar.data[i]['ds_complemento'];
                        }
                        if(arrCarregar.data[i]['ds_bairro']==null){
                            var ds_bairro = "";
                        }
                        else{
                            var ds_bairro = arrCarregar.data[i]['ds_bairro'];
                        }
                        if(arrCarregar.data[i]['ds_cidade']==null){
                            var ds_cidade_lead = "";
                        }
                        else{
                            var ds_cidade_lead = arrCarregar.data[i]['ds_cidade'];
                        }
                        if(arrCarregar.data[i]['ds_uf']==null){
                            var ds_uf = "";
                        }
                        else{
                            var ds_uf = arrCarregar.data[i]['ds_uf'];
                        }
                        if(arrCarregar.data[i]['ds_tel']==null){
                            var ds_tel = "";
                        }
                        else{
                            var ds_tel = arrCarregar.data[i]['ds_tel'];
                        }
                        if(arrCarregar.data[i]['ds_segmento']==null){
                            var ds_segmento = "";
                        }
                        else{
                            var ds_segmento = arrCarregar.data[i]['ds_segmento'];
                        }
                        if(arrCarregar.data[i]['ds_supervisor']==null){
                            var ds_supervisor = "";
                        }
                        else{
                            var ds_supervisor = arrCarregar.data[i]['ds_supervisor'];
                        }
                        if(arrCarregar.data[i]['dt_vencimento']==null){
                            var dt_vencimento = "";
                        }
                        else{
                            var dt_vencimento = arrCarregar.data[i]['dt_vencimento'];
                        }
                        if(arrCarregar.data[i]['dt_cadastro']==null){
                            var dt_cadastro = "";
                        }
                        else{
                            var dt_cadastro = arrCarregar.data[i]['dt_cadastro'];
                        }
                        if(arrCarregar.data[i]['ds_usuario_cadastro']==null){
                            var ds_usuario_cadastro = "";
                        }
                        else{
                            var ds_usuario_cadastro = arrCarregar.data[i]['ds_usuario_cadastro'];
                        }

                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>"+pk+"</th>";
                        strRetorno+="<th width='20%'>"+ds_tipo_lead+"</th>";
                        strRetorno+="<th width='20%'>"+ds_lead_pai+"</th>";
                        strRetorno+="<th width='20%'>"+ds_lead+"</th>";
                        strRetorno+="<th width='20%'>"+ds_razao_social+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cpf_cnpj+"</th>";
                        strRetorno+="<th width='20%'>"+ds_endereco+"</th>";
                        strRetorno+="<th width='20%'>"+ds_numero+"</th>";
                        strRetorno+="<th width='20%'>"+ds_complemento+"</th>";
                        strRetorno+="<th width='20%'>"+ds_bairro+"</th>";
                        strRetorno+="<th width='20%'>"+ds_cidade_lead+"</th>";
                        strRetorno+="<th width='20%'>"+ds_uf+"</th>";
                        strRetorno+="<th width='20%'>"+ds_tel+"</th>";
                        strRetorno+="<th width='20%'>"+ds_segmento+"</th>";
                        strRetorno+="<th width='20%'>"+dt_vencimento+"</th>";
                        strRetorno+="<th width='20%'>"+dt_cadastro+"</th>";
                        strRetorno+="<th width='20%'>"+ds_usuario_cadastro+"</th>";
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

    sendPost("rel_posto_trabalho_analitico_res_form.php", {token: token});
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
    fcCarregarGrid();
    $("#ds_cidade").text(ds_cidade);
    $("#ds_ic_tipo_lead").text(ds_ic_tipo_lead);
    $("#ds_ic_cliente").text(ds_ic_cliente);
    $("#ds_lead").text(ds_lead);
    
    
    
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


