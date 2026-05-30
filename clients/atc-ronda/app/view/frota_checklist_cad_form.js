var tblDocumentos;

function fcBuscarFormVeiculo(){
    try {
    var v_id_veiculo = $("#id_veiculo").val();
    $("#leads_pk").val("");
    $("#formUltimoChecklist").html("");
    if(v_id_veiculo != ''){
        var objParametros = {
            "id_veiculo": v_id_veiculo
        };    
    
        var arrCarregar = carregarController("frota", "listarPorIdVeiculo", objParametros);
       // NewWindow(v_last_url)
        $("#frota_pk").val(arrCarregar.data[0]['pk']);
        $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);

        if (arrCarregar.result == 'success'){
            var html = "";
            alert(arrCarregar.data[0]['pk'] )
            if(arrCarregar.data[0]['pk'] > 0){
                for(var i=0; i < arrCarregar.data.length; i++){
                    html += "<input type='hidden' id='auditorias_categorias_itens_pk_"+i+"' name='auditorias_categorias_itens_pk_"+i+"' value='"+arrCarregar.data[i]['pk']+"'>";
                    if(arrCarregar.data[i]['tipo_item_pk'] == "1"){
                        html += "<div class='row'>";
                        html += "   <div class='col-md-4'>";
                        html += "       &nbsp;";
                        html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['checklistItens'][0]['pk']+">";
                        html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='select'>";
                        html += "   </div>";
                        html += "   <div class='col-md-4'>";
                        html += "       <br>";
                        html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                        html += "       <select class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'>";
                        html += "           <option></option>";
                        for(var l=0; l<arrCarregar.data[i]['itensDados'].length; l++){
                            if(arrCarregar.data[i]['checklistItens'][0]['ds_resultado_dados'] == arrCarregar.data[i]['itensDados'][l]['pk']){
                                html += "       <option value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'selected>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+"</option>"; 
                            }else{
                                html += "       <option value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+"</option>"; 
                            }
                        }
                        html += "       </select>";
                        html += "   </div>";
                        html += "</div>";
                    }else if(arrCarregar.data[i]['tipo_item_pk'] == "2"){
                        var ds_resultado_dados = arrCarregar.data[i]['checklistItens'][0]['ds_resultado_dados'];
                        if(ds_resultado_dados == null){
                            ds_resultado_dados = "";
                        }
                        html += "<div class='row'>";
                        html += "   <div class='col-md-4'>";
                        html += "       &nbsp;";
                        html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['checklistItens'][0]['pk']+">";
                        html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='text'>";
                        html += "   </div>";
                        html += "   <div class='col-md-4'>";
                        html += "       <br>";
                        html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                        html += "       <input class='form-control form-control-sm' type='text' id='campo_"+i+"' name='campo_"+i+"' value="+ds_resultado_dados+">";
                        html += "   </div>";
                        html += "</div>";
                    }else if(arrCarregar.data[i]['tipo_item_pk'] == "3"){
                        html += "<div class='row'>";
                        html += "   <div class='col-md-4'>";
                        html += "       &nbsp;";
                        html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='checkbox'>";
                        html += "   </div>";
                        html += "   <div class='col-md-4'>";
                        html += "       <br>";
                        if(arrCarregar.data[i]['itensDados'].length > 0){
                            html += "       <b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b><hr style='margin-top:0'>";
                            for(var l=0; l < arrCarregar.data[i]['itensDados'].length; l++){
                                html += "       <input type='hidden' id='pk_campo_"+i+"_"+l+"' name='pk_campo_"+i+"_"+l+"'value="+arrCarregar.data[i]['checklistItens'][0]['pk']+">";
                                html += "   <label for='campo_"+i+"_"+l+"'>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+":&nbsp;</label>";
                                if(arrCarregar.data[i]['checklistItens'][0]['ic_checkbox'] == "1"){
                                    html += "   <input type='checkbox' id='campo_"+i+"_"+l+"' name='campo"+i+"_"+l+"' value='"+arrCarregar.data[i]['itensDados'][0]['auditorias_categoria_itens_dados_pk']+"' checked><br>";
                                }else{
                                    html += "   <input type='checkbox' id='campo_"+i+"_"+l+"' name='campo"+i+"_"+l+"' value='"+arrCarregar.data[i]['itensDados'][0]['auditorias_categoria_itens_dados_pk']+"'><br>";
                                }
                            }
                        }else{
                            html += "   <label for='campo_"+i+"_"+l+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                            html += "       <input type='hidden' id='pk_campo_"+i+"_0' name='pk_campo_"+i+"_0' value="+arrCarregar.data[i]['checklistItens'][0]['pk']+">";
                                if(arrCarregar.data[i]['checklistItens'][i]['ic_checkbox'] == "1"){
                                    html += "   <input type='checkbox' id='campo_"+i+"_0' name='campo"+i+"_0' value='"+arrCarregar.data[i]['checklistItens'][0]['auditorias_categoria_itens_dados_pk']+"' checked><br>";
                                }else{
                                    html += "   <input type='checkbox' id='campo_"+i+"_0' name='campo"+i+"_0' value='"+arrCarregar.data[i]['checklistItens'][0]['auditorias_categoria_itens_dados_pk']+"'><br>";
                                }
                        }
                        html += "       <input type='hidden' id='qtd_checkbox_"+i+"' name='qtd_checkbox_"+i+"'' value='"+l+"'>";
                        html += "   </div>";
                        html += "</div>";
                    }else if(arrCarregar.data[i]['tipo_item_pk'] == "4"){
                        var ds_resultado_textarea = arrCarregar.data[i]['checklistItens'][0]['ds_resultado_textarea'];
                        if(ds_resultado_textarea == null){
                            ds_resultado_textarea = "";
                        }
                        html += "<div class='row'>";
                        html += "   <div class='col-md-4'>";
                        html += "       &nbsp;";
                        html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['checklistItens'][0]['pk']+">";
                        html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='textarea'>";
                        html += "   </div>";
                        html += "   <div class='col-md-4'>";
                        html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                        html += "       <textarea class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'>"+ds_resultado_textarea+"</textarea>";
                        html += "   </div>";
                        html += "</div>";
                    }
                }
                if(arrCarregar.data[0]['itensDados']!=null){
                    $( "#conteiner_forms" ).show(); 
                    $( "#qtd_campos" ).val(i); 
                    $( "#formUltimoChecklist" ).append( html ); 
                }else{
                    $( "#conteiner_forms" ).show(); 
                    $( "#cmdRepetirChecklist" ).prop( "disabled", true); 
                }
               
            }else{
               alert('Veículo não encontrado!')
               $( "#conteiner_forms" ).hide(); 
            }
    
        }

    }else{
        alert('Informe o Id Do Veículo!')
    }
} catch (error) {
        alert(error)
}
}

// Listar Combos
function fcCarregarCondutor(){    
    var arrCarregar = carregarController("veiculos_condutores", "listarVeiculos", "");
    carregarComboAjax($("#condutores_pk"), arrCarregar, " ", "condutor_pk", "ds_condutor");      
}

function fcCarregarLeads(){
    var arrCarregar = carregarController("lead", "listarLeadsCombo", "");
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");
}

//Retornanr para Página inicial
function fcCancelar(){
    sendPost("frota_checklist_res_form.php", {token: token});
}

function fcCarregarEstruturaForm(){
    
    $( "#div_none" ).show(); 
    $( "#formNovoChecklist" ).html(''); 
    var objParametros = {
        "ds_categoria_item": 'Checklist Frota'
    };
    var arrCarregar = carregarController("frota", "listarFormPorIdVeiculo", objParametros);
    var html = "";
    for(var i=0; i < arrCarregar.data.length; i++){
        html += "<input type='hidden' id='auditorias_categorias_itens_pk_"+i+"' name='auditorias_categorias_itens_pk_"+i+"' value='"+arrCarregar.data[i]['pk']+"'>";
    
        if(arrCarregar.data[i]['tipo_item_pk'] == "1"){
                html += "<div class='row'>";
                html += "   <div class='col-md-4'>";
                html += "       &nbsp;";
                html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"''>";
                html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='select'>";
                html += "   </div>";
                html += "   <div class='col-md-4'>";
                html += "       <br>";
                html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                html += "       <select class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'>";
                html += "           <option></option>";
                for(var l=0; l<arrCarregar.data[i]['itensDados'].length; l++){
                    html += "       <option value='"+arrCarregar.data[i]['itensDados'][l]['auditorias_categoria_itens_dados_pk']+"'>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+"</option>"; 
                }
                html += "       </select>";
                html += "   </div>";
                html += "</div>";
        }else if(arrCarregar.data[i]['tipo_item_pk'] == "2"){
                html += "<div class='row'>";
                html += "   <div class='col-md-4'>";
                html += "       &nbsp;";
                html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"''>";
                html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='text'>";
                html += "   </div>";
                html += "   <div class='col-md-4'>";
                html += "       <br>";
                html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                html += "       <input class='form-control form-control-sm' type='text' id='campo_"+i+"' name='campo_"+i+"'>";
                html += "   </div>";
                html += "</div>";
        }else if(arrCarregar.data[i]['tipo_item_pk'] == "3"){
                html += "<div class='row'>";
                html += "   <div class='col-md-4'>";
                html += "       &nbsp;";
                html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"''>";
                html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='checkbox'>";
                html += "   </div>";
                html += "   <div class='col-md-4'>";
                html += "       <br>";
                if(arrCarregar.data[i]['itensDados'].length > 0){
                    html += "       <b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b><hr style='margin-top:0'>";
                    for(var l=0; l<arrCarregar.data[i]['itensDados'].length; l++){
                        html += "   <label for='campo_"+i+"_"+l+"'>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+":&nbsp;</label>";
                        html += "   <input type='checkbox' id='campo_"+i+"_"+l+"' name='campo"+i+"_"+l+"' value='"+arrCarregar.data[i]['itensDados'][l]['auditorias_categoria_itens_dados_pk']+"'><br>";
                    }
                }else{
                    html += "   <label for='campo_"+i+"_"+l+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                    html += "   <input type='checkbox' id='campo_"+i+"0' name='campo"+i+"_0' value='"+arrCarregar.data[i]['pk']+"'><br>";
                }
                html += "       <input type='hidden' id='qtd_checkbox_"+i+"' name='qtd_checkbox_"+i+"'' value='"+l+"'>";
                html += "   </div>";
                html += "</div>";
        }else if(arrCarregar.data[i]['tipo_item_pk'] == "4"){
                html += "<div class='row'>";
                html += "   <div class='col-md-4'>";
                html += "       &nbsp;";
                html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"''>";
                html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='textarea'>";
                html += "   </div>";
                html += "   <div class='col-md-4'>";
                html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                html += "       <textarea class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'></textarea>";
                html += "   </div>";
                html += "</div>";
        }
    }
    $( "#formNovoChecklist" ).append( html ); 
    $( "#qtd_campos" ).val(i); 
}

function fcEnviar(form){
    var qtd_campos =  $( "#qtd_campos" ).val(); 
    var ds_resultado_dados = "";

    var arrKeys = [];
    arrKeys[0] = "pk";
    arrKeys[1] = "condutores_pk";
    arrKeys[2] = "ds_resultado_dados";
    arrKeys[3] = "ds_tipo_campo";
    arrKeys[4] = "auditorias_categorias_itens_pk";
    arrKeys[5] = "leads_pk";
    arrKeys[6] = "arrResultadoDados";
    arrKeys[7] = "arrIcCheckbox";
    arrKeys[8] = "arrPkCheckbox";
    arrKeys[9] = "qtdCheckbox";
    arrKeys[10] = "frota_pk";

    for(var i=0; i < qtd_campos; i++){
        var arrInformacoes = [];
        var arrDadosCheckbox = [];
        var ds_tipo_campo = $( "#"+form+" #ds_tipo_campo_"+i).val();
        var pk = $(  "#"+form+"#pk_campo_"+i).val();
        var auditorias_categorias_itens_pk = $(  "#"+form+" #auditorias_categorias_itens_pk_"+i).val();
        var condutores_pk =  $(  "#condutores_pk" ).val();
        var leads_pk = $( "#leads_pk").val();
        var frota_pk = $( "#frota_pk").val();

        if(ds_tipo_campo == 'checkbox'){
            var arrResultadoDados = [];
            var arrIcCheckbox = [];
            var arrPkCheckbox = [];
            for(var l=0; l<$( "#"+form+" #qtd_checkbox_"+i).val(); l++){
                ds_resultado_dados = $( "#"+form+" #campo_"+i+"_"+l).val(); 
                pk_checkbox = $( "#"+form+" #pk_campo_"+i+"_"+l).val();
                if($( "#"+form+" #campo_"+i+"_"+l).prop('checked') == true){
                    ic_checkbox = "1";
                }else{
                    ic_checkbox = "2";
                }
                arrResultadoDados[l] = [ds_resultado_dados];
                arrIcCheckbox[l] = [ic_checkbox];
                arrPkCheckbox[l] = [pk_checkbox];
            }
        }else{
            arrDadosCheckbox = ""
            ds_resultado_dados = $( "#"+form+" #campo_"+i).val();
        }
        
        arrInformacoes[0] = [pk, condutores_pk, ds_resultado_dados, ds_tipo_campo, auditorias_categorias_itens_pk, leads_pk, arrResultadoDados, arrIcCheckbox, arrPkCheckbox, $("#qtd_checkbox_"+i).val(), frota_pk];
        
        var JSONinfo = arrayToJson(arrKeys, arrInformacoes);
        var objParametros = {
            "JSONinfo": JSONinfo
        };    
        var arrEnviar = carregarController("frota_checklist", "salvar", objParametros);

    }

    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
         $( "#frota_checklist_pk" ).val(arrEnviar.data[0]['pk']); 
        //sendPost('frota_checklist_res_form.php', {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
    
}

//Documentos

function fcCarregarGridDocumentos(){
    var objParametros = {
        "frota_checklist_pk":  $( "#frota_checklist_pk" ).val(),
    };     
    
    var v_url = montarUrlController("frota_checklist_documentos", "listarDataTable", objParametros);

    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        "aaSorting"      : [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_nome_original"},
           {"targets": -3, "data": "t_ds_obs"},
           {"targets": -4, "data": "t_ds_documento"},
           {"targets": -5, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblDocumentos tbody').on('click', '.function_edit', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcDownloadDocumento(data['t_ds_documento']);
        }
    });
    $('#tblDocumentos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirDocumento(data['t_pk'],data['t_ds_documento']);
        }
        else{
            fcExcluirArquivo(data['t_ds_documento']);
            tblDocumentos.row($(this).parents('tr')).remove().draw();
        }
    });


}

function fcDownloadDocumento(ds_documento){
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumento(v_pk,v_ds_documento){    
    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("frota_checklist_documentos", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcExcluirArquivo(v_ds_documento);
            tblDocumentos.clear().destroy();    
            fcCarregarGridDocumentos();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    
    frota_checklist_pk = $( "#frota_checklist_pk" ).val(); 
    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    }
    else{
        if(frota_checklist_pk == ""){
            if($("#acao").val() == "ins"){
                var dsDocumento = "";
                var dsNomeOriginal = "";
                $('#tblArquivos tbody tr').each(function () {
                var colunas = $(this).children();
                    var colunas = $(this).children();
                    dsDocumento = $(colunas[0]).text();
                    dsNomeOriginal = $(colunas[1]).text();
                    fcIncluirDocumentoSemPk(dsDocumento,dsNomeOriginal);
                });
                $("#janela_documentos").modal("hide");
            }
        }
        else{
            fcEnviarDocumento(frota_checklist_pk);
        }

    }

}

function fcIncluirDocumentoSemPk(v_documento,v_nome_original){
    tblDocumentos.row.add(
        {
            "t_pk":"",
            "t_ds_documento":v_documento,
            "t_ds_obs":$("#ds_obs_doc").val(),
            "t_ds_nome_original":v_nome_original,
            "t_functions":""
        }
    ).draw();

    return false;
}

function fcEnviarDocumento(v_pk){

    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();

    var objParametros = {
        "frota_checklist_pk": v_pk,
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };


    var arrEnviar = carregarController("frota_checklist_documentos", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        //alert(arrEnviar.message);
        tblDocumentos.clear().destroy();
        fcCarregarGridDocumentos();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCarregarGridArquivos(){
    tblArquivos = $("#tblArquivos").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }
    );
    return false;
}

function fcApagarArquivo(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivo(nome_arquivo);
    });

    tblArquivos.row($(this).parents('tr')).remove().draw();
}

function fcCancelarEnvioDocumento(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
            var colunas = $(this).children();
            nome_arquivo = $(colunas[0]).text();
            fcExcluirArquivo(nome_arquivo);
        });
}


function fcExcluirArquivo(v_nome_arquivo){
    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };


    var arrEnviar = carregarController("frota_checklist_documentos", "removerArquivo", objParametros);

    if (arrEnviar.result == 'success'){

    }
}

function fcIncluirLinhaArquivo(nome_original){
    tblArquivos.row.add(
            [$("#ds_documento").text(),
             nome_original,
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcApagarArquivo);
    return false;
}


function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}

function fcAlterarNomeArquivo(v_arquivo){
    var objParametros = {
        "frota_checklist_pk": $( "#frota_checklist_pk" ).val(),
        "ds_documento": v_arquivo
    };


    var arrEnviar = carregarController("frota_checklist_documentos", "renomearArquivo", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento").text(arrEnviar.data[0]['t_ds_nome_salvo']);

    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }

}

$(function () {

    $('#fileupload').fileupload({

        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('Reset()', 2000);

            $.each(data.files, function (index, file) {

                $("#ds_nome_original").text(file.name);

                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);



            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width', progress + '%');
        }
    });
});

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() != "Nenhum registro encontrado"){
        var dsDocumento = "";
        var dsNomeOriginal = "";

        var arrKeys = [];
        arrKeys[0] = "ds_documento";
        arrKeys[1] = "ds_nome_original";

        var arrDados = [];
            var i = 0;
            $('#tblArquivos tbody tr').each(function () {
            var colunas = $(this).children();
                dsDocumento =  $(colunas[0]).text();
                dsNomeOriginal = $(colunas[1]).text();


                arrDados[i] = [dsDocumento, dsNomeOriginal];

                i++;
            });

        return arrayToJson(arrKeys, arrDados);
    }


}

function fcLimparDadosDocumento(){
    $("#ds_obs_doc").val("");
    $("#acao").val("");
}
function fcAbrirFormNovoDocumento(){
    tblArquivos.clear().destroy();
    fcCarregarGridArquivos();
    fcLimparDadosDocumento();
    $("#acao").val("ins");
    $("#janela_documentos").modal();

}



$(document).ready(function () {
    
    //Atribui os eventos dos demais controles
    $( "#div_none" ).hide(); 
    $( "#conteiner_forms" ).hide(); 

    $(document).on('click', '#cmdBuscarVeiculo', fcBuscarFormVeiculo);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdNovoChecklist', fcCarregarEstruturaForm);
    $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
    $(document).on('click', '#cmdCancelarDocumento', fcCancelarEnvioDocumento);
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);

    $("#cmdRepetirChecklist").click(function(){
        fcEnviar("formUltimoChecklist");
    });
    $("#cmdEnviar").click(function(){
        fcEnviar("formNovoChecklist");
    });

    fcCarregarGridDocumentos();
    fcCarregarGridArquivos();
    fcCarregarLeads();
    fcCarregarCondutor();
});