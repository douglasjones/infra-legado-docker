var tblArquivos;
function fcValidarForm(){
    $("#form").validate({
        rules :{
            leads_pk:{
                required:true
            },
            auditoria_categorias_pk:{
                required:true
            },
            auditoria_categoria_tipos_pk:{
                required:true
            }
        },
        messages:{
            leads_pk:{
                required:"Por favor, informe Posto De Trabalho"
            },
            auditoria_categorias_pk:{
                required:"Por favor, informe Categoria"
            },
            auditoria_categoria_tipos_pk:{
                required:"Por favor, informe Formulário"
            }

        },
        submitHandler: function(form){
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });
}

function geoFindMe() {
    function success(position) {
      var ds_localizacao = position.coords.latitude +" "+ position.coords.longitude;
      $('#ds_localizacao').val(ds_localizacao)  
    }
  
    function error() {
      alert("Não foi possível recuperar sua localização");
    }

    navigator.geolocation.getCurrentPosition(success, error);
}

function fcEnviar(){
    var auditoria_categorias_pk = $('#auditoria_categorias_pk').val();
    var auditoria_categoria_tipos_pk = $('#auditoria_categoria_tipos_pk').val();
    var leads_pk = $('#leads_pk').val();
    var ds_localizacao = $('#ds_localizacao').val();

    var objParametros = {
        "pk": pk,
        "auditorias_categorias_pk": auditoria_categorias_pk,
        "auditorias_categorias_tipos_pk": auditoria_categoria_tipos_pk,
        "leads_pk": leads_pk,   
        "ds_localizacao": ds_localizacao     
    };    

   var arrEnviar = carregarController("supervisao_auditoria", "salvar", objParametros);
           
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        $( "#supervisao_auditoria_pk" ).val(arrEnviar.data[0]['pk']);
        $( "#container_documentacao" ).show();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
    
}

function fcSalvarForm(){
    var qtd_campos =  $( "#qtd_campos" ).val(); 
    var ds_resultado_dados = "";

    var arrKeys = [];
    arrKeys[0] = "pk";
    arrKeys[1] = "supervisao_auditoria_pk";
    arrKeys[2] = "ds_resultado_dados";
    arrKeys[3] = "ds_tipo_campo";
    arrKeys[4] = "auditorias_categorias_itens_pk";
    arrKeys[5] = "ds_obs_geral";
    arrKeys[6] = "arrResultadoDados";
    arrKeys[7] = "arrIcCheckbox";
    arrKeys[8] = "arrPkCheckbox";
    arrKeys[9] = "qtdCheckbox";


    for(var i=0; i <= qtd_campos; i++){
        var arrInformacoes = [];
        var arrDadosCheckbox = [];
        var ds_tipo_campo = $("#ds_tipo_campo_"+i).val();
        var pk = $("#pk_campo_"+i).val();
        var auditorias_categorias_itens_pk = $("#auditorias_categorias_itens_pk_"+i).val();
        var supervisao_auditoria_pk =  $( "#supervisao_auditoria_pk" ).val();
        var ds_obs_geral = $("#ds_obs_geral").val();

        if(ds_tipo_campo == 'checkbox'){
            var arrResultadoDados = [];
            var arrIcCheckbox = [];
            var arrPkCheckbox = [];
            for(var l=0; l<$("#qtd_checkbox_"+i).val(); l++){
                ds_resultado_dados = $("#campo_"+i+"_"+l).val(); 
                pk_checkbox = $("#pk_campo_"+i+"_"+l).val();
                if($("#campo_"+i+"_"+l).prop('checked') == true){
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
            ds_resultado_dados = $("#campo_"+i).val();
        }
        
        arrInformacoes[0] = [pk, supervisao_auditoria_pk, ds_resultado_dados, ds_tipo_campo, auditorias_categorias_itens_pk, ds_obs_geral, arrResultadoDados, arrIcCheckbox, arrPkCheckbox, $("#qtd_checkbox_"+i).val()];
        
        var JSONinfoSupervisao = arrayToJson(arrKeys, arrInformacoes);

        var objParametros = {
            "JSONinfoSupervisao": JSONinfoSupervisao
        };    

        var arrEnviar = carregarController("supervisao_auditorias_itens", "salvar", objParametros);
        //NewWindow(v_last_url)
    
    }
    
   if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost('auditoria_supervisao_postos_trabalho_res_form.php', {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }

}

function fcCarregarPostoTrabalho(){
    var objParametros = {
        
    };

    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros);
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");
}

function fcCarregarCategorias(){
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("auditoria_categoria", "listarCategoriaCombo", objParametros);
    carregarComboAjax($("#auditoria_categorias_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fcCarregarTiposCategorias(auditoria_categorias_pk){
    var objParametros = {
        "auditoria_categorias_pk": auditoria_categorias_pk
    };

    var arrCarregar = carregarController("auditoria_categoria_tipos", "listarPorAuditoriaCategoriasPk", objParametros);
    carregarComboAjax($("#auditoria_categoria_tipos_pk"), arrCarregar, " ", "pk", "ds_auditoria_categoria_tipo");
}

function fcCarregarEstruturaFormulario(auditoria_categoria_tipos_pk){
    
    try {
        var objParametros = {
            "auditorias_categorias_tipos_pk": auditoria_categoria_tipos_pk,
            "supervisao_auditorias_pk": pk
        };
        var arrCarregar = carregarController("auditoria_categorias_itens", "listarPorCategoriasTiposSupervisao", objParametros);
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
        $( "#auditoria_categoria_form" ).append( html ); 
        $( "#qtd_campos" ).val(i); 

        
        
    } catch (error) {
        alert(error)
    }
}

function fcCarregar(){
    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("supervisao_auditoria", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
        
            $("#auditoria_categorias_pk").val(arrCarregar.data[0]['auditorias_categorias_pk']);
            var auditoria_categorias_pk = $('#auditoria_categorias_pk').val();
            fcCarregarTiposCategorias(auditoria_categorias_pk);

            $("#auditoria_categoria_tipos_pk").val(arrCarregar.data[0]['auditorias_categorias_tipos_pk']);
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);

            var auditoria_categoria_tipos_pk = $('#auditoria_categoria_tipos_pk').val();
            $( "#ds_form" ).append("Formulário - " + $('#auditoria_categoria_tipos_pk option').filter(':selected').text()); 
            fcCarregarForm(auditoria_categoria_tipos_pk);
            $("#leads_pk").prop('disabled', true);
            $("#auditoria_categorias_pk").prop('disabled', true);
            $("#auditoria_categoria_tipos_pk").prop('disabled', true);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcCarregarForm(auditoria_categoria_tipos_pk){
    try {
        if(pk > 0){

            var objParametros = {
                "supervisao_auditorias_pk": pk,
                "auditoria_categoria_tipos_pk": auditoria_categoria_tipos_pk
            };
    
            var arrCarregar = carregarController("supervisao_auditorias_itens", "listarValoresCamposForm", objParametros);
            //NewWindow(v_last_url)
            if (arrCarregar.result == 'success'){
                for(var i=0; i < arrCarregar.data.length; i++){
                    var html = "";
                    html += "<input type='hidden' id='auditorias_categorias_itens_pk_"+i+"' name='auditorias_categorias_itens_pk_"+i+"' value='"+arrCarregar.data[i]['pk']+"'>";
                
                    if(arrCarregar.data[i]['tipo_item_pk'] == "1"){
                        html += "<div class='row'>";
                        html += "   <div class='col-md-4'>";
                        html += "       &nbsp;";
                        html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
                        html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='select'>";
                        html += "   </div>";
                        html += "   <div class='col-md-4'>";
                        html += "       <br>";
                        html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                        html += "       <select class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'>";
                        html += "           <option></option>";
                        for(var l=0; l<arrCarregar.data[i]['itensDados'].length; l++){
                            if(arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_dados'] == arrCarregar.data[i]['itensDados'][l]['pk']){
                                html += "       <option value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'selected>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+"</option>"; 
                            }else{
                                html += "       <option value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+"</option>"; 
                            }
                        }
                        html += "       </select>";
                        html += "   </div>";
                        html += "</div>";
                    }else if(arrCarregar.data[i]['tipo_item_pk'] == "2"){
                        var ds_resultado_dados = arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_dados'];
                        if(ds_resultado_dados == null){
                            ds_resultado_dados = "";
                        }
                        html += "<div class='row'>";
                        html += "   <div class='col-md-4'>";
                        html += "       &nbsp;";
                        html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
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
                            for(var l=0; l<arrCarregar.data[i]['itensDados'].length; l++){
                                html += "       <input type='hidden' id='pk_campo_"+i+"_"+l+"' name='pk_campo_"+i+"_"+l+"'value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][l]['pk']+">";
                                html += "   <label for='campo_"+i+"_"+l+"'>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+":&nbsp;</label>";
                                if(arrCarregar.data[i]['supervisaoAuditoriasItens'][l]['ic_checkbox'] == "1"){
                                    html += "   <input type='checkbox' id='campo_"+i+"_"+l+"' name='campo"+i+"_"+l+"' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"' checked><br>";
                                }else{
                                    html += "   <input type='checkbox' id='campo_"+i+"_"+l+"' name='campo"+i+"_"+l+"' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'><br>";
                                }
                            }
                        }else{
                            html += "   <label for='campo_"+i+"_"+l+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;<b></label>";
                            html += "       <input type='hidden' id='pk_campo_"+i+"_0' name='pk_campo_"+i+"_0' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
                                if(arrCarregar.data[i]['supervisaoAuditoriasItens'][l]['ic_checkbox'] == "1"){
                                    html += "   <input type='checkbox' id='campo_"+i+"_0' name='campo"+i+"_0' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"' checked><br>";
                                }else{
                                    html += "   <input type='checkbox' id='campo_"+i+"_0' name='campo"+i+"_0' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'><br>";
                                }
                        }
                        html += "       <input type='hidden' id='qtd_checkbox_"+i+"' name='qtd_checkbox_"+i+"'' value='"+l+"'>";
                        html += "   </div>";
                        html += "</div>";
                    }else if(arrCarregar.data[i]['tipo_item_pk'] == "4"){
                        var ds_resultado_textarea = arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_textarea'];
                        if(ds_resultado_textarea == null){
                            ds_resultado_textarea = "";
                        }
                        html += "<div class='row'>";
                        html += "   <div class='col-md-4'>";
                        html += "       &nbsp;";
                        html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
                        html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='textarea'>";
                        html += "   </div>";
                        html += "   <div class='col-md-4'>";
                        html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                        html += "       <textarea class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'>"+ds_resultado_textarea+"</textarea>";
                        html += "   </div>";
                        html += "</div>";
                    }
                    $( "#auditoria_categoria_form" ).append( html ); 
                }
                $( "#qtd_campos" ).val(i); 
            }else{
                alert('Falhar ao carregar o registro');
            }
               
        }
        
    } catch (error) {
        alert(error)
    }
    
       
}

function fcCancelar(){
    sendPost("auditoria_supervisao_postos_trabalho_res_form.php", {token: token});
}

function fcCarregarGridDocumentos(){
        var objParametros = {
            "supervisao_auditorias_pk":  $( "#supervisao_auditoria_pk" ).val(),
        };     
        
        var v_url = montarUrlController("supervisao_auditoria_documentos", "listarDataTable", objParametros);
        //NewWindow(v_last_url)
    
        //Trata a tabela
        tblDocumentos = $('#tblDocumentos').DataTable({
            "scrollX": false,
            "ajax": {"url": v_url, "type": "POST"},
            "responsive": true,
            "bDeferRender"   : true,
            //"bProcessing"    : true,
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
        });
    
    
}

function fcExcluirDocumento(v_pk,v_ds_documento){    
    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("supervisao_auditoria_documentos", "excluir", objParametros);   

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

function fcExcluirArquivo(v_nome_arquivo){
    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "removerArquivo", objParametros);           
           
    if (arrEnviar.result == 'success'){
        
    }
}

function fcAbrirFormNovoDocumento(){
    fcCarregarGridArquivos();
    $("#janela_documentos").modal();
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

function fcDownloadDocumento(ds_documento){ 
    var v_url = "../docs/"+ds_documento;
    NewWindow(v_url, '_blank');
}

function fcEnviarDocumento(){    
    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();
    
    var objParametros = {
        "supervisao_auditorias_pk": $( "#supervisao_auditoria_pk" ).val(),
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };       
    
    var arrEnviar = carregarController("supervisao_auditoria_documentos", "salvar", objParametros); 
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        alert(arrEnviar.message);
        tblDocumentos.clear().destroy();    
        fcCarregarGridDocumentos();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
           
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

function fcApagarArquivo(){
    var nome_arquivo = "";
    tblArquivos = $('#tblArquivos').DataTable();
    $('#tblArquivos tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivo(nome_arquivo);
    });
    
    tblArquivos.row($(this).parents('tr')).remove().draw();
}

function fcIncluirLinhaArquivo(nome_original){
    tblArquivos = $('#tblArquivos').DataTable();
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

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivos(){
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

function fcValidarDocumentos(){  
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    } 
    else{
        fcEnviarDocumento();
    }
    
}

function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}

function fcAlterarNomeArquivo(v_arquivo){   
    
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivo", objParametros);   
   
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
                
                $("#ds_nome_original").html(file.name);
                
                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);
                
                               
            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressOc .progress-bar').css('width', progress + '%');
        }
    });
});


$(document).ready(function(){
    $( "#supervisao_auditoria_pk" ).val(pk);
    fcCarregarPostoTrabalho();
    fcCarregarCategorias();
    fcCarregar();
    geoFindMe();
    $("#container_documentacao").hide();

    $('#auditoria_categorias_pk').change(function(){
        var auditoria_categorias_pk = $('#auditoria_categorias_pk').val();
        fcCarregarTiposCategorias(auditoria_categorias_pk);
    });
    
    $('#auditoria_categoria_tipos_pk').change(function(){
        fcEnviar();
    });

    $('#auditoria_categoria_tipos_pk').change(function(){
        //limpa formulário
        $( "#ds_form" ).html(" "); 
        $( "#auditoria_categoria_form" ).html(" "); 

        var auditoria_categoria_tipos_pk = $('#auditoria_categoria_tipos_pk').val();
        $( "#ds_form" ).append("Formulário - " + $('#auditoria_categoria_tipos_pk option').filter(':selected').text()); 
        fcCarregarEstruturaFormulario(auditoria_categoria_tipos_pk)
    });

    fcCarregarGridDocumentos();
    if(pk > 0){
        $( "#container_documentacao" ).show();
    }

    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdEnviar', fcSalvarForm);
    $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);
    $(document).on('click', '#cmdCancelarDocumento', fcCancelarEnvioDocumento);

    //Atribui a validação do formulário dos campos obrigatórios
    //fcValidarForm();


    
});